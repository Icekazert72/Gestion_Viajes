<?php
session_start();

require('../conexion.php');
header('Content-Type: application/json');

$obj = new DATABASE;
$conn = $obj->getConexion();

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'message' => 'No autenticado']);
    exit;
}

$data = $_POST;
$user_id = $_SESSION['usuario_id'];

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Error de conexión']);
    exit;
}

// Validar campos requeridos
if (empty($data['nombre']) || empty($data['apellidos']) || empty($data['telefono']) || empty($data['dni'])) {
    echo json_encode(['success' => false, 'message' => 'Faltan datos']);
    exit;
}

// 1️⃣ Verificar si el usuario ya tiene un tutor
$check = $conn->prepare("SELECT id FROM tutores WHERE usuario = ?");
$check->bind_param("i", $user_id);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Este usuario ya tiene un tutor registrado.']);
    $check->close();
    $conn->close();
    exit;
}
$check->close();

// 2️⃣ Insertar el nuevo tutor si no existe
$stmt = $conn->prepare("INSERT INTO tutores (nombre, apellidos, telefono, dni, usuario) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("ssssi", $data['nombre'], $data['apellidos'], $data['telefono'], $data['dni'], $user_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Tutor registrado correctamente.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al insertar el tutor.']);
}

$stmt->close();
$conn->close();

