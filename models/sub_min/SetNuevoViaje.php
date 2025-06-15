<?php 
session_start();
require_once('../conexion.php');  

// Verificar si la sesión está activa
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'No autorizado. Agencia no encontrada en sesión.']);
    exit();
}

$agencia_id = $_SESSION['user_id'];
$db = new Database();
$conn = $db->getConexion();

// Recibir y sanitizar datos
$fecha = $_POST['fecha'] ?? '';  // Formato 'YYYY-MM-DD'
$fecha_llegada = $_POST['fecha_llegada'] ?? '';  // Formato 'HH:MM' o 'HH:MM:SS'
$bus = intval($_POST['bus'] ?? 0);
$ruta = intval($_POST['ruta'] ?? 0);

// Validar los parámetros
if (empty($fecha_llegada) || $bus <= 0 || $ruta <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Datos incompletos o inválidos.']);
    exit();
}

// Validar formato de hora (HH:MM o HH:MM:SS)
if (!preg_match('/^\d{2}:\d{2}(:\d{2})?$/', $fecha_llegada)) {
    http_response_code(400);
    echo json_encode(['error' => 'Formato de hora de llegada inválido.']);
    exit();
}

// Validar que la fecha esté en el formato correcto (YYYY-MM-DD)
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
    http_response_code(400);
    echo json_encode(['error' => 'Formato de fecha inválido.']);
    exit();
}

// Validar que la fecha sea válida
$fecha_obj = DateTime::createFromFormat('Y-m-d', $fecha);
if (!$fecha_obj || $fecha_obj->format('Y-m-d') !== $fecha) {
    http_response_code(400);
    echo json_encode(['error' => 'Fecha inválida.']);
    exit();
}

// Obtener horario y validar agencia
$stmt = $conn->prepare("SELECT horario, agencia FROM rutas WHERE id = ?");
$stmt->bind_param("i", $ruta);
$stmt->execute();
$stmt->bind_result($horario, $ruta_agencia);

if (!$stmt->fetch()) {
    http_response_code(400);
    echo json_encode(['error' => 'Ruta no encontrada.']);
    $stmt->close();
    $conn->close();
    exit();
}
$stmt->close();

// Verificar si la agencia tiene permiso para usar la ruta
if ($ruta_agencia != $agencia_id) {
    http_response_code(403);
    echo json_encode(['error' => 'No tienes permisos para usar esta ruta.']);
    $conn->close();
    exit();
}

// Insertar viaje
$fecha_salida = $horario; // Usamos el horario de la ruta como fecha_salida

// El estado es 'pendiente' por defecto, no es necesario pasarlo como parámetro
$stmt = $conn->prepare("INSERT INTO viajes (fecha_viaje, hora_salida, hora_llegada, agencia, bus, ruta, estado, fecha_registro) 
                        VALUES (?, ?, ?, ?, ?, ?, 'pendiente', CURRENT_TIMESTAMP)");

$stmt->bind_param("sssiis", $fecha, $fecha_salida, $fecha_llegada, $agencia_id, $bus, $ruta);

if (!$stmt->execute()) {
    http_response_code(500);
    echo json_encode(['error' => 'Error al guardar el viaje: ' . $stmt->error]);
    $stmt->close();
    $conn->close();
    exit();
}

$ultimo_id = $stmt->insert_id;
$stmt->close();
$conn->close();

http_response_code(200);
echo json_encode(['success' => 'Viaje guardado correctamente', 'id' => $ultimo_id]);
?>
