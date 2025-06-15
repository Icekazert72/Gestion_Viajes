<?php
require_once('../conexion.php');
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Sesión no iniciada.']);
    exit;
}

$obj = new Database();
$conn = $obj->getConexion();

$cliente_temporal_id = $_POST['cliente_temporal_id'] ?? null;
$ruta_id = $_POST['ruta_id'] ?? null;
$bus_id = $_POST['bus_id'] ?? null;
$tipo_servicio = $_POST['tipo_servicio'] ?? null;

if (!$cliente_temporal_id || !$ruta_id || !$bus_id || !$tipo_servicio) {
    echo json_encode(['success' => false, 'message' => 'Faltan campos obligatorios.']);
    exit;
}

$agencia_id = $_SESSION['user_id'];

$sql = "INSERT INTO reservas (cliente_temporal_id, agencia_id, ruta_id, bus_id, tipo_servicio) 
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iiiss", $cliente_temporal_id, $agencia_id, $ruta_id, $bus_id, $tipo_servicio);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Reserva registrada correctamente.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al registrar la reserva.']);
}

$stmt->close();
$conn->close();
