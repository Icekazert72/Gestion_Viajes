<?php
// Archivo: getRutas.php
include_once '../conexion.php';

$conn = new Database();
$conn = $conn->getConexion();

$sql = "SELECT id, origen, destino, horario, precio FROM rutas ORDER BY id DESC LIMIT 10"; // Puedes cambiar el límite
$result = $conn->query($sql);

$rutas = [];

while ($row = $result->fetch_assoc()) {
    $rutas[] = [
        "id" => $row["id"],
        "origen" => $row["origen"],
        "destino" => $row["destino"],
        "horario" => $row["horario"],
        "precio" => number_format($row["precio"], 0, ',', '.') . " XAF"
    ];
}

header('Content-Type: application/json');
echo json_encode($rutas);

$conn->close();
