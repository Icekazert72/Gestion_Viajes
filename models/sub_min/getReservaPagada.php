<?php
require_once('../conexion.php');
session_start();
header('Content-Type: application/json');

$obj = new Database();
$conexion = $obj->getConexion();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Agencia no autenticada']);
    exit;
}

$agencia_id = $_SESSION['user_id'];

// ...

$query = "
SELECT 
    r.id AS reserva_id,
    r.tipo_servicio,
    r.num_asiento_bus,
    r.estado_pago,
    r.fecha_registro,
    r.usuario_id,
    r.cliente_temporal_id,

    -- Datos del viaje
    v.fecha_viaje,
    v.hora_salida,
    v.hora_llegada,

    -- Datos de la ruta
    ru.origen,
    ru.destino,
    ru.horario,
    ru.precio,

    -- Datos del cliente (usuario o cliente temporal)
    IFNULL(u.nombre, ct.nombre) AS nombre,
    IFNULL(u.apellidos, ct.apellidos) AS apellidos,
    IFNULL(u.email, ct.email) AS email,
    IFNULL(u.telefono, ct.telefono) AS telefono,

    -- Datos de la agencia
    ag.nombre AS agencia_nombre

FROM reservas r
LEFT JOIN usuarios u ON r.usuario_id = u.id
LEFT JOIN clientes_temporales ct ON r.cliente_temporal_id = ct.id
INNER JOIN viajes v ON r.viaje_id = v.id
INNER JOIN rutas ru ON v.ruta = ru.id
INNER JOIN agencias ag ON v.agencia = ag.id

WHERE v.agencia = ? AND r.estado_pago IN ('confirmada', 'finalizada') 
ORDER BY r.fecha_registro DESC
";


$stmt = $conexion->prepare($query);

if ($stmt === false) {
    echo json_encode(['error' => 'Error al preparar la consulta: ' . $conexion->error]);
    exit;
}

$stmt->bind_param("i", $agencia_id);

if (!$stmt->execute()) {
    echo json_encode(['error' => 'Error al ejecutar la consulta: ' . $stmt->error]);
    exit;
}

$resultado = $stmt->get_result();
$reservas = [];

while ($row = $resultado->fetch_assoc()) {
    $reservas[] = $row;
}

echo json_encode($reservas);

$stmt->close();
$conexion->close();
