<?php
// update_estado_viaje.php
require('../conexion.php');
$obj = new Database();
$conn = $obj->getConexion();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $estado = $_POST['estado'] ?? null;

    if ($id && $estado) {
        // Aquí haces la conexión a tu DB
        // $conn = new mysqli(...);

        // Sanitizar $id y $estado
        $id = intval($id);
        $estado = $conn->real_escape_string($estado);

        $sql = "UPDATE viajes SET estado = '$estado' WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            http_response_code(200);
            echo json_encode(['success' => true]);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $conn->error]);
        }
        $conn->close();
    } else {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Faltan parámetros']);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
}
