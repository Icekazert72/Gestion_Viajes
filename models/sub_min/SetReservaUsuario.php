<?php
require_once('../conexion.php');
session_start();
header('Content-Type: application/json');

// Verificar sesión
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Sesión no iniciada.']);
    exit;
}

$agencia_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario_id     = $_POST['usuario_id'] ?? null;
    $viaje_id       = $_POST['viaje_id'] ?? null;
    $tipo_servicio  = $_POST['tipo_servicio'] ?? null;
    $acompanantes   = $_POST['acompanantes'] ?? [];

    if (!$usuario_id || !$viaje_id || !$tipo_servicio) {
        echo json_encode(['success' => false, 'message' => 'Faltan datos obligatorios.']);
        exit;
    }

    $db = new Database();
    $conn = $db->getConexion();

    if ($conn->connect_error) {
        echo json_encode(["success" => false, "message" => "Error de conexión."]);
        exit;
    }

    // Calcular número de asiento inicial (para el usuario principal)
    $stmtCount = $conn->prepare("SELECT COUNT(*) AS total FROM reservas WHERE viaje_id = ?");
    $stmtCount->bind_param("i", $viaje_id);
    $stmtCount->execute();
    $result = $stmtCount->get_result();
    $total_reservas = $result->fetch_assoc()['total'] ?? 0;
    $stmtCount->close();

    $asiento_actual = $total_reservas + 1;

    // Insertar la reserva del usuario principal
    $stmt = $conn->prepare("INSERT INTO reservas (usuario_id, agencia_id, viaje_id, tipo_servicio, num_asiento_bus, estado_pago, fecha_registro)
                            VALUES (?, ?, ?, ?, ?, 'pendiente', NOW())");
    $stmt->bind_param("iiisi", $usuario_id, $agencia_id, $viaje_id, $tipo_servicio, $asiento_actual);

    if ($stmt->execute()) {
        $reserva_id = $stmt->insert_id;
        $asiento_actual++; // siguiente asiento para el primer acompañante

        // Insertar acompañantes si existen
        if (!empty($acompanantes) && is_array($acompanantes)) {
            $stmtPasajero = $conn->prepare("INSERT INTO pasajeros_reserva (viaje, nombre, apellidos, edad, telefono) VALUES (?, ?, ?, ?, ?)");
            foreach ($acompanantes as $acompanante) {
                $nombre     = trim($acompanante['nombre'] ?? '');
                $apellidos  = trim($acompanante['apellidos'] ?? '');
                $edad       = intval($acompanante['edad'] ?? 0);
                $telefono   = trim($acompanante['telefono'] ?? '');

                if ($nombre && $apellidos && $edad > 0) {
                    $stmtPasajero->bind_param("issis", $viaje_id, $nombre, $apellidos, $edad, $telefono);
                    $stmtPasajero->execute();

                    // (Opcional) Podrías almacenar también el asiento asignado aquí si amplías la tabla
                    $asiento_actual++;
                }
            }
            $stmtPasajero->close();
        }

        echo json_encode([
            "success" => true,
            "reserva_id" => $reserva_id,
            "num_asiento_bus" => $asiento_actual - 1 // total de asientos ocupados por este grupo
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al registrar la reserva."]);
    }

    $stmt->close();
    $conn->close();
}
