<?php
require_once('../conexion.php');
session_start();

header('Content-Type: application/json');

$obj = new Database();
$conn = $obj->getConexion();

// Verificar si hay sesión iniciada y agencia válida
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Sesión no iniciada.']);
    exit;
}

$idAgencia = $_SESSION['user_id']; // ID de agencia desde sesión

// Recoger datos del formulario
$nombre = $_POST['nombre'] ?? '';
$apellidos = $_POST['apellidos'] ?? '';
$edad = intval($_POST['edad'] ?? 0);
$dni = $_POST['dni'] ?? '';
$email = $_POST['email'] ?? '';
$telefono = $_POST['telefono'] ?? '';

// Validación básica
if (empty($nombre) || empty($apellidos) || empty($edad) || empty($dni) || empty($email) || empty($telefono)) {
    echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios.']);
    exit;
}

// Preparar e insertar en la tabla clientes_temporales
$stmt = $conn->prepare("INSERT INTO clientes_temporales (nombre, apellidos, edad, DNI, email, telefono, agencia) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssisssi", $nombre, $apellidos, $edad, $dni, $email, $telefono, $idAgencia);

if ($stmt->execute()) {
    $idCliente = $conn->insert_id;

    echo json_encode([
        'success' => true,
        'message' => 'Cliente temporal registrado correctamente.',
        'id_cliente' => $idCliente,
        'edad' => $edad,
        'datos_cliente' => [
            'nombre' => $nombre,
            'apellidos' => $apellidos,
            'telefono' => $telefono,
            'dni' => $dni,
            'email' => $email
        ]
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al registrar cliente: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
