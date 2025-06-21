<?php
header('Content-Type: application/json');

$response = ['success' => false];

try {
    // Mostrar errores para desarrollo (quítalo en producción)
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once '../conexion.php';

    $obj = new DATABASE;
    $conn = $obj->getConexion();

    if ($conn->connect_error) {
        throw new Exception("Error de conexión: " . $conn->connect_error);
    }

    // Recibir datos POST
    $viaje     = $_POST['viaje_id'] ?? null;
    $nombre    = $_POST['nombre'] ?? null;
    $apellidos = $_POST['apellidos'] ?? null;
    $edad      = $_POST['edad'] ?? null;
    $telefono  = $_POST['telefono'] ?? null;

    // Validar campos obligatorios
    if ($viaje && $nombre && $apellidos && $edad && $telefono) {

        // 🔍 Verificar si el pasajero ya está registrado para este viaje
        $stmtCheck = $conn->prepare("SELECT id FROM pasajeros_reserva WHERE viaje = ? AND nombre = ? AND apellidos = ? AND telefono = ?");
        $stmtCheck->bind_param("isss", $viaje, $nombre, $apellidos, $telefono);
        $stmtCheck->execute();
        $result = $stmtCheck->get_result();

        if ($result->num_rows > 0) {
            $response['message'] = "El pasajero ya está registrado para este viaje.";
        } else {
            // ✅ Insertar si no existe
            $stmt = $conn->prepare("INSERT INTO pasajeros_reserva (viaje, nombre, apellidos, edad, telefono) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("issis", $viaje, $nombre, $apellidos, $edad, $telefono);

            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = "Pasajero registrado correctamente.";
            } else {
                $response['error'] = "Error al registrar el pasajero.";
            }

            $stmt->close();
        }

        $stmtCheck->close();
    } else {
        $response['error'] = "Faltan datos obligatorios.";
    }

    $conn->close();
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

echo json_encode($response);
