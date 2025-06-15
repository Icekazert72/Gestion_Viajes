<?php
require_once('../conexion.php');
session_start();
header('Content-Type: application/json');

$obj = new Database();
$conn = $obj->getConexion();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Sesión no iniciada.']);
    exit;
}

$idAgencia = $_SESSION['user_id'];

// Obtener rutas
$sqlRutas = "SELECT id, origen, destino, horario, precio FROM rutas WHERE agencia = ?";
$stmtRutas = $conn->prepare($sqlRutas);
$stmtRutas->bind_param("i", $idAgencia);
$stmtRutas->execute();
$resultRutas = $stmtRutas->get_result();

$rutas = [];
while ($row = $resultRutas->fetch_assoc()) {
    $rutas[] = $row;
}
$stmtRutas->close();

// Obtener buses
$sqlBuses = "SELECT id, placa, numero_bus, modelo FROM buses WHERE agencia = ? AND activo = 1";
$stmtBuses = $conn->prepare($sqlBuses);
$stmtBuses->bind_param("i", $idAgencia);
$stmtBuses->execute();
$resultBuses = $stmtBuses->get_result();

$buses = [];
while ($row = $resultBuses->fetch_assoc()) {
    $buses[] = $row;
}
$stmtBuses->close();

$conn->close();

echo json_encode([
    'success' => true,
    'rutas' => $rutas,
    'buses' => $buses
]);
