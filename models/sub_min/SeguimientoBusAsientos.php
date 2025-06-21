<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../conexion.php';

$obj = new DATABASE;
$mysqli = $obj->getConexion();

$viajesQuery = "
    SELECT 
        v.id AS viaje_id,
        v.fecha_viaje,
        v.hora_salida,
        v.hora_llegada,
        v.estado,
        b.numero_bus,
        b.placa,
        b.capacidad
    FROM viajes v
    JOIN buses b ON v.bus = b.id
    WHERE v.estado = 'pendiente'
    ORDER BY v.fecha_viaje ASC
";

$reservasQuery = "
    SELECT viaje_id, num_asiento_bus
    FROM reservas
    WHERE estado_pago = 'confirmada'
";

$viajesRes = $mysqli->query($viajesQuery);
$reservasRes = $mysqli->query($reservasQuery);

// Organizar reservas por viaje
$reservasPorViaje = [];
while ($r = $reservasRes->fetch_assoc()) {
    $vid = $r['viaje_id'];
    $asiento = $r['num_asiento_bus'];
    $reservasPorViaje[$vid][] = $asiento;
}

$viajes = [];
while ($v = $viajesRes->fetch_assoc()) {
    $v['asientos_ocupados'] = $reservasPorViaje[$v['viaje_id']] ?? [];
    $viajes[] = $v;
}

header('Content-Type: application/json');
echo json_encode($viajes);
// Cerrar la conexión
$mysqli->close();
// Fin del script
// Este script obtiene los viajes activos y los asientos ocupados por reservas confirmadas
