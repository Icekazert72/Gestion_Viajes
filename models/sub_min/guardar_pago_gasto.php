<?php
require_once('../conexion.php');
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Usuario no autenticado']);
    exit;
}

$db = new Database();
$conn = $db->getConexion();

if ($conn->connect_error) {
    echo json_encode(['error' => 'Error de conexión']);
    exit;
}

// Obtener agencia ID desde sesión
$agencia_id = $_SESSION['user_id'];

$data = json_decode(file_get_contents("php://input"), true);
if (!$data) {
    echo json_encode(['error' => 'Datos inválidos']);
    exit;
}

$tipo = $data['tipo'] ?? null; // 'pago' o 'gasto'

if ($tipo === 'pago') {
    $empleado = $data['empleado'] ?? null;
    $monto = $data['monto'] ?? null;
    $fecha_pago = $data['fecha'] ?? null;

    if (!$empleado || !$monto || !$fecha_pago) {
        echo json_encode(['error' => 'Faltan datos para pago']);
        exit;
    }

    $mes = (int)date('m', strtotime($fecha_pago));
    $año = (int)date('Y', strtotime($fecha_pago));

    $stmt = $conn->prepare("INSERT INTO pagos_empleados (empleado, agencia, monto, mes, año, fecha_pago) VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        echo json_encode(['error' => 'Error en la preparación de la consulta: ' . $conn->error]);
        exit;
    }

    // 'iiddds' = empleado (int), agencia (int), monto (double), mes (double - se puede usar int), año (double/int), fecha_pago (string)
    $stmt->bind_param("iidiss", $empleado, $agencia_id, $monto, $mes, $año, $fecha_pago);

    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'Pago registrado',
            'pago_id' => $conn->insert_id,
            'agencia_id' => $agencia_id
        ]);
    } else {
        echo json_encode(['error' => 'Error al guardar pago: ' . $stmt->error]);
    }

    $stmt->close();

} elseif ($tipo === 'gasto') {
    $monto = $data['monto'] ?? null;
    $descripcion = $data['descripcion'] ?? '';
    $fecha = $data['fecha'] ?? null;

    if (!$monto || !$fecha) {
        echo json_encode(['error' => 'Faltan datos para gasto']);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO gastos (agencia, monto, descripcion, fecha) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        echo json_encode(['error' => 'Error en la preparación de la consulta: ' . $conn->error]);
        exit;
    }

    $stmt->bind_param("idss", $agencia_id, $monto, $descripcion, $fecha);

    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'Gasto registrado',
            'gasto_id' => $conn->insert_id,
            'agencia_id' => $agencia_id
        ]);
    } else {
        echo json_encode(['error' => 'Error al guardar gasto: ' . $stmt->error]);
    }

    $stmt->close();

} else {
    echo json_encode(['error' => 'Tipo no válido']);
}

$conn->close();
