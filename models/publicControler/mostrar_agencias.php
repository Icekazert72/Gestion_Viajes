<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Conexión a la base de datos
require_once('../conexion.php');

$obj = new DATABASE;
$conn = $obj->getConexion();

if ($conn->connect_errno) {
    http_response_code(500);
    echo json_encode(['error' => "Fallo al conectar a MySQL: " . $conn->connect_error]);
    exit();
}
$conn->set_charset("utf8");

// Consulta para obtener todas las agencias activas
$sql = "SELECT * FROM agencias WHERE activo = 1 ORDER BY fecha_registro DESC";
$result = $conn->query($sql);

$agencias = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $agencias[] = $row;
    }
    $result->free();
}

echo json_encode($agencias);
?>