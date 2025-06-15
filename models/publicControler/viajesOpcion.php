<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Conexión a la base de datos
require_once('../conexion.php');

$obj = new DATABASE;
$conn = $obj->getConexion();

// Verificar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtener los parámetros de la URL
$origen = $_GET['origen'] ?? '';
$destino = $_GET['destino'] ?? '';
$hora = $_GET['hora'] ?? '';
$fecha = $_GET['fecha'] ?? '';
$viajeros = $_GET['viajeros'] ?? '';

// Validar los parámetros
if (!$origen || !$destino || !$hora || !$fecha || !$viajeros) {
    die(json_encode(['error' => 'Faltan parámetros para realizar la búsqueda.']));
}

// Convertir la fecha y hora a formato adecuado
$fecha_valida = date('Y-m-d', strtotime($fecha));
$hora_valida = date('H:i:s', strtotime($hora));
$fecha_actual = date('Y-m-d');
$fecha_adelante = date('Y-m-d', strtotime("+1 month", strtotime($fecha_valida)));

$viajes = array();

if ($fecha_valida === $fecha_actual) {
    // Si la fecha es hoy, buscar solo los viajes posteriores a la hora seleccionada
    $sql = "
        SELECT v.id, v.hora_salida, v.hora_llegada, r.origen, r.destino, r.precio, b.numero_bus, b.modelo, v.estado, a.nombre AS agencia
        FROM viajes v
        JOIN rutas r ON v.ruta = r.id
        JOIN buses b ON v.bus = b.id
        JOIN agencias a ON v.agencia = a.id
        WHERE r.origen = ?
          AND r.destino = ?
          AND DATE(v.fecha_viaje) = ?
          AND v.hora_salida >= ?
          AND v.estado != 'finalizado'
        ORDER BY v.fecha_viaje ASC, v.hora_salida ASC
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $origen, $destino, $fecha_valida, $hora_valida);
} else {
    // Si la fecha no es hoy, buscar viajes desde esa fecha hasta un mes después
    $sql = "
        SELECT v.id, v.hora_salida, v.hora_llegada, r.origen, r.destino, r.precio, b.numero_bus, b.modelo, v.estado, a.nombre AS agencia
        FROM viajes v
        JOIN rutas r ON v.ruta = r.id
        JOIN buses b ON v.bus = b.id
        JOIN agencias a ON v.agencia = a.id
        WHERE r.origen = ?
          AND r.destino = ?
          AND DATE(v.fecha_viaje) >= ?
          AND DATE(v.fecha_viaje) <= ?
          AND v.estado != 'finalizado'
        ORDER BY v.fecha_viaje ASC, v.hora_salida ASC
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $origen, $destino, $fecha_valida, $fecha_adelante);
}

$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $viajes[] = $row;
}

echo json_encode($viajes);

$conn->close();
