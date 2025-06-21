<?php
require_once('../conexion.php');
session_start();
header('Content-Type: application/json');

$obj = new Database();
$conn = $obj->getConexion();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Sesión no iniciada.']);
    exit;
}

$idAgencia = $_SESSION['user_id'];

$sql = "SELECT v.id, v.fecha_viaje, v.hora_salida, v.hora_llegada, v.estado, a.nombre AS agencia, 
               b.capacidad AS capacidad_total,
               (SELECT COUNT(*) FROM reservas r WHERE r.viaje_id = v.id) AS pasajeros
        FROM viajes v
        JOIN agencias a ON v.agencia = a.id
        JOIN buses b ON v.bus = b.id
        ORDER BY v.id DESC";

$result = $conn->query($sql);
$viajes = [];

while ($row = $result->fetch_assoc()) {
    $row['capacidad_llena'] = intval($row['pasajeros']) >= intval($row['capacidad_total']);
    $viajes[] = $row;
}

echo json_encode($viajes);
$conn->close();
