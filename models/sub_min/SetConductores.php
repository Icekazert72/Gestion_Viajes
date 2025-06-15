<?php
require_once '../conexion.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Sesión no iniciada']);
    exit;
}

$agencia_id = $_SESSION['user_id'];

$db = new Database();
$conn = $db->getConexion();

$sql = "SELECT id, CONCAT(nombre, ' ', apellidos) AS nombre_completo, edad, telefono, email 
        FROM empleados_agencias 
        WHERE rol = 'conductor' AND agencia = ? AND activo = 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $agencia_id);
$stmt->execute();
$result = $stmt->get_result();

$conductores = [];
while ($row = $result->fetch_assoc()) {
    $conductores[] = $row;
}

echo json_encode($conductores);
$conn->close();
