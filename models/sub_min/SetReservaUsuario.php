<?php
require_once('../conexion.php');
session_start();
header('Content-Type: application/json');

// Verificar sesión
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Sesión no iniciada.']);
    exit;
}

$agencia_id = $_SESSION['user_id'];

// Solo POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario_id     = $_POST['usuario_id'] ?? null;
    $viaje_id       = $_POST['viaje_id'] ?? null;
    $tipo_servicio  = $_POST['tipo_servicio'] ?? null;

    if (!$usuario_id || !$viaje_id || !$tipo_servicio) {
        echo json_encode(['success' => false, 'message' => 'Faltan datos obligatorios.']);
        exit;
    }

    $db = new Database();
    $conn = $db->getConexion();

    if ($conn->connect_error) {
        echo json_encode(["success" => false, "message" => "Error de conexión."]);
        exit;
    }

    // Calcular número de asiento (reservas previas para ese viaje)
    $stmtCount = $conn->prepare("SELECT COUNT(*) AS total FROM reservas WHERE viaje_id = ?");
    $stmtCount->bind_param("i", $viaje_id);
    $stmtCount->execute();
    $result = $stmtCount->get_result();
    $total_reservas = $result->fetch_assoc()['total'] ?? 0;
    $stmtCount->close();

    $num_asiento_bus = $total_reservas + 1;

    // Insertar la nueva reserva
    $stmt = $conn->prepare("INSERT INTO reservas (usuario_id, agencia_id, viaje_id, tipo_servicio, num_asiento_bus, estado_pago, fecha_registro)
                            VALUES (?, ?, ?, ?, ?, 'pendiente', NOW())");

    $stmt->bind_param("iiisi", $usuario_id, $agencia_id, $viaje_id, $tipo_servicio, $num_asiento_bus);

    if ($stmt->execute()) {
        echo json_encode([
            "success" => true,
            "reserva_id" => $stmt->insert_id,
            "num_asiento_bus" => $num_asiento_bus
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al registrar la reserva."]);
    }

    $stmt->close();
    $conn->close();
}
?>
