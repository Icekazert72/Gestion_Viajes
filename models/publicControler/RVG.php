<?php
session_start();
header('Content-Type: application/json');

require_once '../../models/conexion.php';


if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['error' => 'Usuario no autenticado']);
    exit;
}

$usuarioId = $_SESSION['usuario_id'];

$obj = new DATABASE;
$conn = $obj->getConexion();

$stmt = $conn->prepare("SELECT id, nombre, apellidos, edad, DNI, email, telefono, imagen FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $usuarioId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();
    echo json_encode($usuario);
} else {
    echo json_encode(['error' => 'Usuario no encontrado']);
}

$stmt->close();
$conn->close();
