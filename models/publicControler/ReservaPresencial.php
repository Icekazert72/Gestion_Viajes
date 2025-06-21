<?php
require_once('../conexion.php');
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['error' => 'Usuario no autenticado']);
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

$viaje_id      = $_POST['viaje_id'] ?? null;
$tipo_servicio = $_POST['tipo_servicio'] ?? null;
$agencia_id    = $_POST['agencia_id'] ?? null;
$tutor_id      = $_POST['tutor_id'] ?? null;

if (!$viaje_id || !$tipo_servicio || !$agencia_id) {
    echo json_encode(['success' => false, 'message' => 'Faltan datos obligatorios.']);
    exit;
}

$db = new Database();
$conn = $db->getConexion();

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Error de conexión."]);
    exit;
}

// ✅ Verificar si ya existe una reserva del usuario para evitar duplicados
$stmtCheck = $conn->prepare("SELECT id FROM reservas WHERE usuario_id = ? AND viaje_id = ? AND tipo_servicio = ?");
$stmtCheck->bind_param("iis", $usuario_id, $viaje_id, $tipo_servicio);
$stmtCheck->execute();
$resultCheck = $stmtCheck->get_result();

if ($resultCheck->num_rows > 0) {
    echo json_encode([
        "success" => false,
        "message" => "Ya tienes una reserva registrada para este viaje y servicio. Por favor, no la dupliques."
    ]);
    $stmtCheck->close();
    $conn->close();
    exit;
}
$stmtCheck->close();

// ✅ Obtener número actual de asientos ya asignados
$stmtCount = $conn->prepare("SELECT COUNT(*) AS total FROM reservas WHERE viaje_id = ?");
$stmtCount->bind_param("i", $viaje_id);
$stmtCount->execute();
$result = $stmtCount->get_result();
$total_reservas = $result->fetch_assoc()['total'] ?? 0;
$stmtCount->close();

$num_asiento_actual = $total_reservas + 1;

// ✅ Obtener acompañantes del usuario para este viaje
$stmtAcomp = $conn->prepare("SELECT nombre, apellidos, edad, telefono FROM pasajeros_reserva WHERE viaje = ?");
$stmtAcomp->bind_param("i", $viaje_id);
$stmtAcomp->execute();
$resultAcomp = $stmtAcomp->get_result();

$acompanantes = [];
while ($row = $resultAcomp->fetch_assoc()) {
    $acompanantes[] = $row;
}
$stmtAcomp->close();

$total_pasajeros = 1 + count($acompanantes); // Usuario + acompañantes

// ✅ Iniciar transacción
$conn->begin_transaction();

try {
    // ✅ Insertar reserva del usuario principal
    if ($tutor_id) {
        $stmt = $conn->prepare("INSERT INTO reservas 
            (usuario_id, agencia_id, viaje_id, tipo_servicio, num_asiento_bus, tutor_id, estado_pago, fecha_registro)
            VALUES (?, ?, ?, ?, ?, ?, 'pendiente', NOW())");
        $stmt->bind_param("iiisii", $usuario_id, $agencia_id, $viaje_id, $tipo_servicio, $num_asiento_actual, $tutor_id);
    } else {
        $stmt = $conn->prepare("INSERT INTO reservas 
            (usuario_id, agencia_id, viaje_id, tipo_servicio, num_asiento_bus, estado_pago, fecha_registro)
            VALUES (?, ?, ?, ?, ?, 'pendiente', NOW())");
        $stmt->bind_param("iiisi", $usuario_id, $agencia_id, $viaje_id, $tipo_servicio, $num_asiento_actual);
    }

    if (!$stmt->execute()) {
        throw new Exception("Error al registrar la reserva del usuario.");
    }

    $reserva_principal_id = $stmt->insert_id;
    $stmt->close();
    $num_asiento_actual++;

    // ✅ Insertar reservas para cada acompañante (si hay)
    foreach ($acompanantes as $acomp) {
        $stmtA = $conn->prepare("INSERT INTO reservas 
            (usuario_id, agencia_id, viaje_id, tipo_servicio, num_asiento_bus, estado_pago, fecha_registro)
            VALUES (?, ?, ?, ?, ?, 'pendiente', NOW())");
        $stmtA->bind_param("iiisi", $usuario_id, $agencia_id, $viaje_id, $tipo_servicio, $num_asiento_actual);

        if (!$stmtA->execute()) {
            throw new Exception("Error al registrar la reserva de un acompañante.");
        }

        $stmtA->close();
        $num_asiento_actual++;
    }

    // ✅ Confirmar transacción
    $conn->commit();

    echo json_encode([
        "success" => true,
        "reserva_id" => $reserva_principal_id,
        "total_pasajeros" => $total_pasajeros,
        "message" => "Reserva registrada en estado pendiente para $total_pasajeros pasajero(s)."
    ]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode([
        "success" => false,
        "message" => "Error: " . $e->getMessage()
    ]);
}

$conn->close();
