<?php
require_once('../conexion.php');
header('Content-Type: application/json');
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Sesión no iniciada.']);
    exit;
}

if (!isset($_POST['id'])) {
    echo json_encode(['success' => false, 'message' => 'ID de viaje no recibido.']);
    exit;
}

$id = intval($_POST['id']);
$obj = new Database();
$conn = $obj->getConexion();

// Obtener el número de pasajeros y la capacidad del bus
$sql = "
    SELECT 
        b.capacidad,
        (SELECT COUNT(*) FROM reservas r WHERE r.viaje_id = v.id) AS pasajeros
    FROM viajes v
    JOIN buses b ON v.bus = b.id
    WHERE v.id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Viaje no encontrado.']);
    $stmt->close();
    $conn->close();
    exit;
}

$data = $result->fetch_assoc();
$capacidad = intval($data['capacidad']);
$pasajeros = intval($data['pasajeros']);

if ($pasajeros < $capacidad) {
    echo json_encode([
        'success' => false,
        'message' => 'El bus aún no está lleno. No se puede iniciar el viaje.'
    ]);
    $stmt->close();
    $conn->close();
    exit;
}

$stmt->close();

// Actualizar el estado del viaje a "activo"
$sqlUpdate = "UPDATE viajes SET estado = 'activo' WHERE id = ?";
$stmtUpdate = $conn->prepare($sqlUpdate);
$stmtUpdate->bind_param("i", $id);

if ($stmtUpdate->execute()) {
    echo json_encode(['success' => true, 'message' => 'Viaje iniciado correctamente.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al iniciar el viaje.']);
}

$stmtUpdate->close();
$conn->close();
