<?php
require_once('../conexion.php');
header('Content-Type: application/json');

$obj = new Database();
$conn = $obj->getConexion();

$sql = "
SELECT
    r.id AS reserva_id,
    r.estado_pago,
    r.tipo_servicio,
    r.fecha_registro,
    r.usuario_id,
    r.cliente_temporal_id,
    
    -- Datos del usuario registrado
    u.nombre AS u_nombre,
    u.apellidos AS u_apellidos,
    u.email AS u_email,
    u.telefono AS u_telefono,

    -- Datos del cliente temporal
    ct.nombre AS ct_nombre,
    ct.apellidos AS ct_apellidos,
    ct.email AS ct_email,
    ct.telefono AS ct_telefono,

    -- Datos del viaje
    v.fecha_viaje,
    v.hora_salida,
    v.hora_llegada,
    
    -- Datos de la ruta
    ru.origen,
    ru.destino,
    ru.horario,
    ru.precio,

    -- Datos de la agencia
    a.nombre AS agencia_nombre

FROM reservas r
LEFT JOIN usuarios u ON r.usuario_id = u.id
LEFT JOIN clientes_temporales ct ON r.cliente_temporal_id = ct.id
INNER JOIN viajes v ON r.viaje_id = v.id
INNER JOIN rutas ru ON v.ruta = ru.id
INNER JOIN agencias a ON v.agencia = a.id

WHERE r.estado_pago = 'pendiente'
ORDER BY r.fecha_registro DESC
";

$resultado = $conn->query($sql);
$reservas = [];

while ($fila = $resultado->fetch_assoc()) {
    $reservas[] = $fila;
}

echo json_encode($reservas);
?>
