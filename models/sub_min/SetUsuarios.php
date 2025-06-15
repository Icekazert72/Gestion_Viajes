<?php
session_start();

// Verificar si hay sesión activa y tipo agencia
if (!isset($_SESSION['user_id']) || $_SESSION['tipo'] !== 'agencia') {
    http_response_code(403);
    echo json_encode(['error' => 'Acceso no autorizado']);
    exit;
}

require_once('../conexion.php');
$obj = new Database();
$conn = $obj->getConexion();

$idAgencia = $_SESSION['user_id'];

$sql = "SELECT id, nombre, apellidos, edad, DNI, email, telefono, imagen, fecha_registro
        FROM usuarios WHERE agencia = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idAgencia);
$stmt->execute();
$result = $stmt->get_result();

$usuarios = [];
while ($row = $result->fetch_assoc()) {
    $usuarios[] = $row;
}

echo json_encode($usuarios);
$stmt->close();
$conn->close();
?>
