<?php
// asignar_bus.php
require_once('../conexion.php');

$obj = new Database();
$conn = $obj->getConexion();

$conductor = intval($_POST['conductor']);
$bus = intval($_POST['bus']);

$sql = "INSERT INTO asignaciones (bus_id, conductor_id) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $bus, $conductor);

if ($stmt->execute()) {
    echo "Asignación registrada correctamente.";
} else {
    echo "Error al asignar: " . $stmt->error;
}

$stmt->close();
$conn->close();
