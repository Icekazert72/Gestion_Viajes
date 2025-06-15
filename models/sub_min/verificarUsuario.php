<?php
require_once('../conexion.php');
session_start();

header('Content-Type: application/json');

$obj = new Database();
$conn = $obj->getConexion();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['nombre']) || !isset($_POST['password'])) {
        echo json_encode(['success' => false, 'message' => 'Nombre o contraseña no proporcionados.']);
        exit;
    }

    $nombre = trim($_POST['nombre']);
    $password = trim($_POST['password']);

    // Buscar usuario por nombre (importante: se puede repetir si no es único)
    $stmt = $conn->prepare("SELECT id, nombre, apellidos, email, telefono, edad, agencia, PASSWORD_HASH FROM usuarios WHERE nombre = ?");
    $stmt->bind_param("s", $nombre);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

        // Verificar contraseña
        if (password_verify($password, $usuario['PASSWORD_HASH'])) {
            unset($usuario['PASSWORD_HASH']); // ocultar hash al enviar respuesta
            echo json_encode(['success' => true, 'usuario' => $usuario]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Contraseña incorrecta.']);
        }
    } elseif ($resultado->num_rows > 1) {
        echo json_encode(['success' => false, 'message' => 'Hay más de un usuario con ese nombre.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Usuario no encontrado con ese nombre.']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
}
