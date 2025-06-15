<?php
session_start();

// Verificar sesión activa y tipo de usuario
if (!isset($_SESSION['user_id']) || $_SESSION['tipo'] !== 'agencia') {
    http_response_code(403);
    echo json_encode(['error' => 'Acceso no autorizado']);
    exit;
}

require_once('../conexion.php');

$obj = new Database();
$conn = $obj->getConexion();

$idAgencia = $_SESSION['user_id'];

$sql = "SELECT buses.id, buses.placa, buses.numero_bus, buses.modelo, 
               buses.capacidad, buses.activo, buses.fecha_registro, agencias.nombre AS agencia
        FROM buses
        INNER JOIN agencias ON buses.agencia = agencias.id
        WHERE agencias.id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idAgencia);
$stmt->execute();
$result = $stmt->get_result();

$buses = [];
while ($row = $result->fetch_assoc()) {
    $row['activo'] = $row['activo'] ? 'Activo' : 'Inactivo';
    $buses[] = $row;
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($buses, JSON_UNESCAPED_UNICODE);

$stmt->close();
$conn->close();
?>
