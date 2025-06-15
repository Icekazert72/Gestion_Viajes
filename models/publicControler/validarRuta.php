<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('../conexion.php');

$obj = new DATABASE;
$conn = $obj->getConexion();

if ($conn->connect_error) {
    echo json_encode([
        "existe" => false,
        "mensaje" => "Error de conexión a la base de datos."
    ]);
    exit;
}

// Recibir y limpiar los datos POST
$origen = trim($_POST['origen'] ?? '');
$destino = trim($_POST['destino'] ?? '');
$fecha = trim($_POST['fecha'] ?? '');
$hora = trim($_POST['hora'] ?? '');

// Validar campos obligatorios
if (!$origen || !$destino || !$fecha || !$hora) {
    echo json_encode([
        "existe" => false,
        "mensaje" => "Faltan datos para validar la ruta."
    ]);
    exit;
}

// Convertir la fecha a formato adecuado
$fecha_valida = date('Y-m-d', strtotime($fecha)); // Convertir fecha a Y-m-d
$hora_valida = date('H:i:s', strtotime($hora)); // Convertir hora a H:i:s

// Buscar ruta exacta (si existe)
$sql = "
    SELECT v.id
    FROM viajes v
    JOIN rutas r ON v.ruta = r.id
    WHERE r.origen = ? 
      AND r.destino = ? 
      AND DATE(v.fecha_viaje) = ? 
      AND v.hora_salida >= ? 
      AND v.estado != 'finalizado'
    LIMIT 1
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $origen, $destino, $fecha_valida, $hora_valida);
$stmt->execute();
$stmt->store_result();

// Si se encuentra una ruta exacta, devolver el resultado
if ($stmt->num_rows > 0) {
    echo json_encode([
        "existe" => true,
        "mensaje" => "Ruta disponible."
    ]);
    $stmt->close();
    $conn->close();
    exit;
}

// Si no se encuentra una ruta exacta, buscar rutas diarias
$sql_diarias = "
    SELECT v.id
    FROM viajes v
    JOIN rutas r ON v.ruta = r.id
    WHERE r.origen = ? 
      AND r.destino = ? 
      AND v.estado != 'finalizado'
      AND DATE(v.fecha_viaje) > ?
    LIMIT 1
";
$stmt = $conn->prepare($sql_diarias);
$stmt->bind_param("sss", $origen, $destino, $fecha_valida);
$stmt->execute();
$stmt->store_result();

// Si se encuentra una ruta diaria, devolver el resultado
if ($stmt->num_rows > 0) {
    echo json_encode([
        "existe" => true,
        "mensaje" => "Ruta disponible en una fecha futura."
    ]);
    $stmt->close();
    $conn->close();
    exit;
}

// Si no se encuentra una ruta diaria, buscar rutas semanales (por día de la semana)
$dia_semana = date('w', strtotime($fecha_valida)); // Día de la semana (0=domingo, 6=sábado)

$sql_semanal = "
    SELECT v.id
    FROM viajes v
    JOIN rutas r ON v.ruta = r.id
    WHERE r.origen = ? 
      AND r.destino = ? 
      AND v.estado != 'finalizado' 
      AND WEEKDAY(v.fecha_viaje) = ? 
      AND DATE(v.fecha_viaje) > ?
    LIMIT 1
";
$stmt = $conn->prepare($sql_semanal);
$stmt->bind_param("ssss", $origen, $destino, $dia_semana, $fecha_valida);
$stmt->execute();
$stmt->store_result();

// Si se encuentra una ruta semanal, devolver el resultado
if ($stmt->num_rows > 0) {
    echo json_encode([
        "existe" => true,
        "mensaje" => "Ruta disponible en el mismo día de la semana."
    ]);
} else {
    echo json_encode([
        "existe" => false,
        "mensaje" => "No hay rutas disponibles para los datos indicados."
    ]);
}

$stmt->close();
$conn->close();
?>
