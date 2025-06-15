<?php
require_once '../conexion.php';
session_start();

// Validar que haya una sesión activa con agencia
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Sesión no iniciada o sin ID de agencia']);
    exit;
}

$agencia_id = $_SESSION['user_id']; // ID de agencia logueada

$db = new Database();
$conn = $db->getConexion();

$sql = "SELECT id, nombre, apellidos FROM empleados_agencias 
        WHERE rol = 'conductor' AND agencia = ? AND activo = 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $agencia_id);
$stmt->execute();
$resultado = $stmt->get_result();

$conductores = [];

while ($fila = $resultado->fetch_assoc()) {
    $conductores[] = [
        'id' => $fila['id'],
        'nombre' => $fila['nombre'] . ' ' . $fila['apellidos']
    ];
}

echo json_encode($conductores);
$conn->close();
?>

