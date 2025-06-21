<?php
ini_set('display_errors', 1); // Activar errores para debugging
error_reporting(E_ALL);

session_start();
header('Content-Type: application/json');

require('../conexion.php');

// Suponiendo que DATABASE está correctamente definida e incluye el método getConexion()
$obj = new DATABASE;
$conn = $obj->getConexion();

if ($conn->connect_error) {
    echo json_encode(['error' => 'Error de conexión']);
    exit;
}

$user_id = $_SESSION['usuario_id'] ?? 0;
$user_id = (int)$user_id; // Aseguramos que es entero para evitar inyección

if ($user_id <= 0) {
    echo json_encode(['error' => 'Sesión no iniciada']);
    exit;
}

// Preparar consulta para evitar inyección SQL
$stmt = $conn->prepare("SELECT edad FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();

if (!$res || $res->num_rows == 0) {
    echo json_encode(['error' => 'Usuario no encontrado']);
    exit;
}

$row = $res->fetch_assoc();
$menor = ($row['edad'] < 18);

// Verificar tutor con consulta preparada
$stmt2 = $conn->prepare("SELECT COUNT(*) as cnt FROM tutores WHERE usuario = ?");
$stmt2->bind_param("i", $user_id);
$stmt2->execute();
$tutorRes = $stmt2->get_result();

if (!$tutorRes) {
    echo json_encode(['error' => 'Error al consultar tutores']);
    exit;
}

$tutorCount = (int)$tutorRes->fetch_assoc()['cnt'];

if ($tutorCount > 0) {
    echo json_encode([
        'menor' => $menor,
        'tutorRegistrado' => true,
        'mensaje' => 'Todo está correcto. Ya tienes un tutor registrado.'
    ]);
    exit;
} else {
    echo json_encode([
        'menor' => $menor,
        'tutorRegistrado' => false,
        'mensaje' => 'No tienes tutor registrado, por favor regístralo.'
    ]);
    exit;
}
