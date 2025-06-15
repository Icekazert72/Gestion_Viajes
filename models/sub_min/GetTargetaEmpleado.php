<?php
require_once '../conexion.php';
session_start();

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'ID no proporcionado']);
    exit;
}

$id = intval($_GET['id']);
$agencia_id = $_SESSION['user_id'];

$db = new Database();
$conn = $db->getConexion();

$sql = "SELECT e.id, CONCAT(e.nombre, ' ', e.apellidos) AS nombre_completo,
               e.edad, e.telefono, e.email, e.DNI, e.agencia,
               a.nombre AS agencia_nombre,
               e.imagen, e.activo
        FROM empleados_agencias e
        JOIN agencias a ON e.agencia = a.id
        WHERE e.id = ? AND e.agencia = ? AND e.rol = 'conductor'";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id, $agencia_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    // Datos simulados
    $row['direccion'] = "Barrio Paraíso, Malabo"; // Si no tienes una columna en la base de datos
    $row['licencia'] = "LCN-45210"; // Simulado
    $row['bus'] = "Bus Nº 25"; // Simulado

    echo json_encode($row);
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Conductor no encontrado']);
}

$conn->close();
