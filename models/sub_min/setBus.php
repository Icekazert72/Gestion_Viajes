<?php
header('Content-Type: application/json');
require_once('../conexion.php');

// Conectar a la base de datos
$obj = new Database();
$conn = $obj->getConexion();

// Verificar conexión
if ($conn->connect_error) {
    http_response_code(500);
    echo "Error de conexión: " . $conn->connect_error;
    exit;
}

// Recibir y sanitizar datos
$placa = strtoupper(trim($_POST['placa']));
$numero_bus = trim($_POST['numero_bus']);
$modelo = trim($_POST['modelo']);
$capacidad = intval($_POST['capacidad']);
$agencia = intval($_POST['agencia']);

// Validación simple
if (empty($placa) || empty($numero_bus) || empty($modelo) || $capacidad <= 0) {
    echo json_encode(['success' => false, 'message' => 'Campos inválidos o incompletos.']);
    exit;
}

// Insertar
$stmt = $conn->prepare("INSERT INTO buses (placa, numero_bus, modelo, capacidad, agencia) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssii", $placa, $numero_bus, $modelo, $capacidad, $agencia);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Bus registrado correctamente.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al insertar: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
