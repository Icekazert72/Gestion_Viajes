<?php
require_once('../conexion.php');
header('Content-Type: application/json');

session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Agencia no autenticado']);
    exit;
}

$db = new Database();
$conn = $db->getConexion();

if ($conn->connect_error) {
    echo json_encode(['error' => 'Error de conexión']);
    exit;
}

$agencia_id = $_SESSION['user_id']; // ID agencia desde sesión

$stmt = $conn->prepare("SELECT id, nombre, apellidos FROM empleados_agencias WHERE agencia = ? AND activo = 1");
$stmt->bind_param("i", $agencia_id);
$stmt->execute();
$result = $stmt->get_result();

$empleados = [];
while ($row = $result->fetch_assoc()) {
    $empleados[] = [
        'id' => $row['id'],
        'nombre_completo' => $row['nombre'] . ' ' . $row['apellidos']
    ];
}

echo json_encode($empleados);

$stmt->close();
$conn->close();
?>
