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

// Obtener los viajes disponibles para la agencia
$sqlViajes = "
    SELECT 
        v.id AS viaje_id, 
        v.fecha_viaje, 
        v.hora_salida, 
        v.hora_llegada, 
        b.numero_bus, 
        b.modelo, 
        b.placa, 
        r.origen, 
        r.destino, 
        r.horario AS ruta_horario
    FROM viajes v
    JOIN buses b ON v.bus = b.id
    JOIN rutas r ON v.ruta = r.id
    WHERE v.agencia = ? AND v.estado = 'pendiente'
";
$stmtViajes = $conn->prepare($sqlViajes);
$stmtViajes->bind_param("i", $idAgencia);
$stmtViajes->execute();
$resultViajes = $stmtViajes->get_result();

$viajes = [];
while ($row = $resultViajes->fetch_assoc()) {
    $viajes[] = $row;
}
$stmtViajes->close();

$conn->close();

echo json_encode([
    'success' => true,
    'viajes' => $viajes
]);
?>
