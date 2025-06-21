<?php
require_once('../conexion.php');
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['error' => 'Usuario no autenticado']);
    exit;
}

$usuario_id   = $_SESSION['usuario_id'];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

$viaje_id      = $_POST['viaje_id'] ?? null;
$tipo_servicio = $_POST['tipo_servicio'] ?? null;
$agencia_id    = $_POST['agencia_id'] ?? null;
$tutor_id      = $_POST['tutor_id'] ?? null;
$nombre        = $_POST['nombre'] ?? null;
$dni           = $_POST['dni'] ?? null;
$telefono      = $_POST['telefono'] ?? null;

if (!$viaje_id || !$tipo_servicio || !$agencia_id || !$nombre || !$dni || !$telefono) {
    echo json_encode(['success' => false, 'message' => 'Faltan datos obligatorios.']);
    exit;
}

$db = new Database();
$conn = $db->getConexion();

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Error de conexión."]);
    exit;
}

// Verificar duplicado
$stmtCheck = $conn->prepare("SELECT id FROM reservas WHERE usuario_id = ? AND viaje_id = ? AND tipo_servicio = ?");
$stmtCheck->bind_param("iis", $usuario_id, $viaje_id, $tipo_servicio);
$stmtCheck->execute();
$resultCheck = $stmtCheck->get_result();

if ($resultCheck->num_rows > 0) {
    echo json_encode([
        "success" => false,
        "message" => "Ya tienes una reserva registrada para este viaje y servicio."
    ]);
    $stmtCheck->close();
    $conn->close();
    exit;
}
$stmtCheck->close();

// Obtener precio de la ruta
$stmtPrecio = $conn->prepare("
    SELECT r.precio 
    FROM viajes v 
    JOIN rutas r ON v.ruta = r.id 
    WHERE v.id = ?");
$stmtPrecio->bind_param("i", $viaje_id);
$stmtPrecio->execute();
$stmtPrecio->bind_result($precio);
$stmtPrecio->fetch();
$stmtPrecio->close();

if (!$precio) {
    echo json_encode(['success' => false, 'message' => 'No se pudo obtener el precio del viaje.']);
    exit;
}

// Obtener número actual de reservas para calcular asiento inicial
$stmtCount = $conn->prepare("SELECT COUNT(*) AS total FROM reservas WHERE viaje_id = ?");
$stmtCount->bind_param("i", $viaje_id);
$stmtCount->execute();
$result = $stmtCount->get_result();
$total_reservas = $result->fetch_assoc()['total'] ?? 0;
$stmtCount->close();

// Obtener acompañantes
$stmtAcomp = $conn->prepare("SELECT nombre, apellidos, edad, telefono FROM pasajeros_reserva WHERE viaje = ?");
$stmtAcomp->bind_param("i", $viaje_id);
$stmtAcomp->execute();
$resultAcomp = $stmtAcomp->get_result();

$acompanantes = [];
while ($row = $resultAcomp->fetch_assoc()) {
    $acompanantes[] = $row;
}
$stmtAcomp->close();

// Total pasajeros (usuario + acompañantes)
$total_pasajeros = 1 + count($acompanantes);
$monto_total = $precio * $total_pasajeros;

// Comenzar transacción
$conn->begin_transaction();

$num_asiento_bus = $total_reservas + 1;

// Insertar reserva principal (usuario)
if ($tutor_id) {
    $stmt = $conn->prepare("INSERT INTO reservas 
        (usuario_id, agencia_id, viaje_id, tipo_servicio, num_asiento_bus, tutor_id, estado_pago, fecha_registro)
        VALUES (?, ?, ?, ?, ?, ?, 'confirmada', NOW())");
    $stmt->bind_param("iiisii", $usuario_id, $agencia_id, $viaje_id, $tipo_servicio, $num_asiento_bus, $tutor_id);
} else {
    $stmt = $conn->prepare("INSERT INTO reservas 
        (usuario_id, agencia_id, viaje_id, tipo_servicio, num_asiento_bus, estado_pago, fecha_registro)
        VALUES (?, ?, ?, ?, ?, 'confirmada', NOW())");
    $stmt->bind_param("iiisi", $usuario_id, $agencia_id, $viaje_id, $tipo_servicio, $num_asiento_bus);
}

if (!$stmt->execute()) {
    $conn->rollback();
    echo json_encode(["success" => false, "message" => "Error al registrar la reserva del usuario."]);
    exit;
}
$reserva_id = $stmt->insert_id;
$stmt->close();

// Insertar reservas para acompañantes
$asiento_actual = $num_asiento_bus + 1;

foreach ($acompanantes as $acomp) {
    $stmtInsert = $conn->prepare("INSERT INTO reservas 
        (usuario_id, agencia_id, viaje_id, tipo_servicio, num_asiento_bus, estado_pago, fecha_registro)
        VALUES (?, ?, ?, ?, ?, 'confirmada', NOW())");
    $stmtInsert->bind_param("iiisi", $usuario_id, $agencia_id, $viaje_id, $tipo_servicio, $asiento_actual);

    if (!$stmtInsert->execute()) {
        $conn->rollback();
        echo json_encode(["success" => false, "message" => "Error al registrar la reserva de un acompañante."]);
        exit;
    }

    $asiento_actual++;
    $stmtInsert->close();
}

// Insertar pago total
$fecha_pago = date('Y-m-d');
$stmtPago = $conn->prepare("INSERT INTO pagos_cliente (reserva_id, fecha_pago, monto, metodo_pago) VALUES (?, ?, ?, 'transferencia')");
$stmtPago->bind_param("isd", $reserva_id, $fecha_pago, $monto_total);

if (!$stmtPago->execute()) {
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => 'Error al registrar el pago del cliente.']);
    exit;
}
$stmtPago->close();

// Insertar ingreso contable
$descripcion = "Pago online reserva #$reserva_id (incluye $total_pasajeros pasajero(s))";
$stmtIngreso = $conn->prepare("INSERT INTO ingresos (agencia, monto, descripcion, fecha) VALUES (?, ?, ?, ?)");
$stmtIngreso->bind_param("idss", $agencia_id, $monto_total, $descripcion, $fecha_pago);

if (!$stmtIngreso->execute()) {
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => 'Error al registrar el ingreso.']);
    exit;
}
$stmtIngreso->close();

// Confirmar todo
$conn->commit();

echo json_encode([
    "success" => true,
    "reserva_id" => $reserva_id,
    "num_asientos" => $total_pasajeros,
    "monto_total" => $monto_total,
    "message" => "Reserva realizada correctamente con $total_pasajeros pasajero(s) y pago registrado."
]);

$conn->close();
