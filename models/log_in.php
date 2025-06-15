<?php
session_start();

// Responder en JSON con mensaje y estado HTTP
function responder($mensaje, $codigo = 400)
{
    http_response_code($codigo);
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'error',
        'message' => $mensaje
    ]);
    exit;
}

// Validaciones básicas
if (!isset($_POST['username']) || trim($_POST['username']) === '') {
    responder('El campo usuario es obligatorio.');
}
if (!isset($_POST['password']) || trim($_POST['password']) === '') {
    responder('El campo contraseña es obligatorio.');
}

$username = trim($_POST['username']);
$password = trim($_POST['password']);

// Conexión a la base de datos
$conexion = new mysqli('localhost', 'root', '', 'db_ndong_viajes');
if ($conexion->connect_error) {
    responder("Error de conexión: " . $conexion->connect_error, 500);
}

// -------------------------------
// PRIMERA CONSULTA: usuarios
// -------------------------------
$sql1 = "SELECT id, nombre AS nombre_usuario, PASSWORD_HASH FROM usuarios WHERE nombre = ?";
$stmt1 = $conexion->prepare($sql1);
$stmt1->bind_param("s", $username);
$stmt1->execute();
$resultado1 = $stmt1->get_result();

if ($resultado1->num_rows === 1) {
    $usuario = $resultado1->fetch_assoc();

    if (password_verify($password, $usuario['PASSWORD_HASH'])) {
        $_SESSION['usuario_id'] = $usuario['id']; 
        $_SESSION['usuario'] = $usuario['nombre_usuario'];
        $_SESSION['tipo'] = 'usuario';

        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success',
            'tipo' => 'usuario'
        ]);
        exit;
    } else {
        responder('Contraseña incorrecta.');
    }
}
$stmt1->close();

// -------------------------------
// SEGUNDA CONSULTA: agencias
// -------------------------------
$sql2 = "SELECT id, usuario AS nombre_usuario, PASSWORD_HASH FROM agencias WHERE usuario = ?";
$stmt2 = $conexion->prepare($sql2);
$stmt2->bind_param("s", $username);
$stmt2->execute();
$resultado2 = $stmt2->get_result();

if ($resultado2->num_rows === 1) {
    $agencia = $resultado2->fetch_assoc();

    if (password_verify($password, $agencia['PASSWORD_HASH'])) {
        $_SESSION['user_id'] = $agencia['id'];
        $_SESSION['usuario'] = $agencia['nombre_usuario'];
        $_SESSION['tipo'] = 'agencia';

        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success',
            'tipo' => 'agencia'
        ]);
        exit;
    } else {
        responder('Contraseña incorrecta.');
    }
}
$stmt2->close();

// Si no se encontró en ninguna tabla
responder('Usuario no encontrado.');
$conexion->close();
?>
