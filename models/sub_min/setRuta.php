<?php

require_once('../conexion.php');

// Configuración de conexión
$obj = new Database();
$conn = $obj->getConexion();

// Verificar conexión
if ($conn->connect_error) {
    http_response_code(500);
    echo "Error de conexión: " . $conn->connect_error;
    exit;
}

// Recibir y limpiar los datos
$origen = trim($_POST['origen'] ?? '');
$destino = trim($_POST['destino'] ?? '');
$horario = trim($_POST['horario'] ?? '');
$precio = trim($_POST['precio'] ?? '');
$region = trim($_POST['region'] ?? '');
$agencia_id = intval($_POST['agencia_id'] ?? 0);

// Validación básica
if ($origen === '' || $destino === '' || $horario === '' || $precio === '' || $region === '' || $agencia_id <= 0) {
    http_response_code(400);
    echo "Todos los campos son obligatorios.";
    exit;
}

// Insertar en la base de datos
$sql = "INSERT INTO rutas (region, origen, destino, horario, precio, agencia) 
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param("ssssdi", $region, $origen, $destino, $horario, $precio, $agencia_id);
    
    if ($stmt->execute()) {
        echo "Ruta registrada correctamente.";
    } else {
        http_response_code(500);
        echo "Error al insertar la ruta: " . $stmt->error;
    }

    $stmt->close();
} else {
    http_response_code(500);
    echo "Error en la preparación de la consulta: " . $conn->error;
}

$conn->close();
?>
