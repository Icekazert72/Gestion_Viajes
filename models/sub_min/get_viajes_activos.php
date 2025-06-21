<?php
header('Content-Type: application/json');

require('../conexion.php');
// Conexión a la base de datos

$obj = new DATABASE;
$conexion = $obj->getConexion();


if ($conexion->connect_error) {
    echo json_encode(['error' => 'Error de conexión']);
    exit;
}

$sql = "SELECT 
    v.id,
    v.fecha_viaje,
    v.hora_salida,
    v.hora_llegada,
    b.numero_bus,
    b.placa,
    b.modelo,
    b.capacidad,
    r.origen,
    r.destino,
    r.region,
    r.precio,
    a.nombre AS agencia_nombre,
    (SELECT CONCAT(nombre, ' ', apellidos)
     FROM empleados_agencias 
     WHERE agencia = a.id AND rol = 'conductor' 
     LIMIT 1) AS conductor_nombre,
    v.estado
FROM viajes v
JOIN buses b ON v.bus = b.id
JOIN rutas r ON v.ruta = r.id
JOIN agencias a ON v.agencia = a.id
WHERE v.estado = 'activo'";

$resultado = $conexion->query($sql);
$viajes = [];

while ($fila = $resultado->fetch_assoc()) {
    $viajes[] = $fila;
}

echo json_encode($viajes);
$conexion->close();
?>
