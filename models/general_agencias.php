<?php
session_start();
require_once('conexion.php');
header('Content-Type: application/json');

// Mostrar errores (para desarrollo)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$obj = new Database();
$conn = $obj->getConexion();

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Conexión fallida: ' . $conn->connect_error]);
    exit;
}

// Obtener datos del formulario
$nombre    = $_POST['nombre'] ?? '';
$direccion = $_POST['direccion'] ?? '';
$telefono  = $_POST['telefono'] ?? '';
$email     = $_POST['email'] ?? '';
$usuario   = strtolower(trim($_POST['usuario'] ?? ''));
$password  = $_POST['password'] ?? '';

// Validación básica
if (empty($nombre) || empty($direccion) || empty($telefono) || empty($email) || empty($usuario) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios.']);
    exit;
}

// Validar formato de contraseña: exactamente 5 dígitos
if (!preg_match('/^\d{5}$/', $password)) {
    echo json_encode(['success' => false, 'message' => 'La contraseña debe tener exactamente 5 dígitos numéricos.']);
    exit;
}

// Verificar si ya existe el usuario
$stmt_check = $conn->prepare("SELECT usuario FROM agencias WHERE LOWER(usuario) = ?");
$stmt_check->bind_param("s", $usuario);
$stmt_check->execute();
$stmt_check->store_result();
if ($stmt_check->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'El usuario ya está registrado.']);
    exit;
}
$stmt_check->close();

// Encriptar la contraseña
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Subida de imagen
$nombreImagen = '';
if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
    $directorio = "../uploads/";
    if (!is_dir($directorio)) {
        mkdir($directorio, 0755, true);
    }

    $nombreImagen = uniqid() . "_" . basename($_FILES["imagen"]["name"]);
    $rutaDestino = $directorio . $nombreImagen;

    if (!move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaDestino)) {
        echo json_encode(['success' => false, 'message' => 'Error al subir la imagen.']);
        exit;
    }
}

// Insertar agencia en la base de datos
$sql = "INSERT INTO agencias (nombre, direccion, telefono, email, usuario, PASSWORD_HASH, imagen)
        VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssss", $nombre, $direccion, $telefono, $email, $usuario, $password_hash, $nombreImagen);

if ($stmt->execute()) {
    $idAgencia = $stmt->insert_id;

    // INICIAR SESIÓN automáticamente
    $_SESSION['user_id'] = $idAgencia;
    $_SESSION['usuario'] = $usuario;
    $_SESSION['tipo'] = 'agencia';

    echo json_encode([
        'success' => true,
        'message' => 'Agencia registrada y sesión iniciada.',
        'tipo' => 'agencia'
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al insertar: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
