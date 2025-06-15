<?php
require_once '../conexion.php';

$db = new Database();
$conn = $db->getConexion();

$sql = "SELECT 
            a.id AS id_asignacion,
            e.nombre,
            CONCAT('EMP-', LPAD(e.id, 5, '0')) AS codigo_conductor,
            CONCAT('BUS-', LPAD(b.id, 5, '0')) AS numero_bus,
            ag.nombre AS agencia
        FROM asignaciones a
        JOIN empleados_agencias e ON a.conductor_id = e.id
        JOIN buses b ON a.bus_id = b.id
        JOIN agencias ag ON e.agencia = ag.id
        WHERE a.activo = 1";


$result = $conn->query($sql);
$asignaciones = [];

while ($row = $result->fetch_assoc()) {
    $asignaciones[] = $row;
}

echo json_encode([
    "success" => true,
    "asignaciones" => $asignaciones
]);

$conn->close();
