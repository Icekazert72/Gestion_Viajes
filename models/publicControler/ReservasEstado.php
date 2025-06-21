<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode([]);
    exit;
}

require '../conexion.php';
$obj = new DATABASE;
$mysqli = $obj->getConexion();

$usuario_id = $_SESSION['usuario_id'];

$sql = "SELECT r.*, v.fecha_viaje, v.hora_salida, ru.origen, ru.destino 
        FROM reservas r
        JOIN viajes v ON r.viaje_id = v.id
        JOIN rutas ru ON v.ruta = ru.id
        WHERE r.usuario_id = ? 
        ORDER BY v.fecha_viaje DESC";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param('i', $usuario_id);
$stmt->execute();

$res = $stmt->get_result();
$reservas = [];

while ($row = $res->fetch_assoc()) {
    $reservas[] = $row;
}

echo json_encode($reservas);
?>
