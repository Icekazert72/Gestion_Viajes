<?php
require_once '../conexion.php';
session_start();

// Validar sesión
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Sesión no iniciada']);
    exit;
}

$agencia_id = $_SESSION['user_id'];

$db = new Database();
$conn = $db->getConexion();

// Seleccionar buses activos de la agencia
$sql = "SELECT id, placa, modelo FROM buses 
        WHERE agencia = ? AND activo = 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $agencia_id);
$stmt->execute();
$resultado = $stmt->get_result();

$buses = [];

while ($row = $resultado->fetch_assoc()) {
    $buses[] = [
        'id' => $row['id'],
        'nombre' => $row['placa'] . ' - ' . $row['modelo']
    ];
}

echo json_encode($buses);
$conn->close();
