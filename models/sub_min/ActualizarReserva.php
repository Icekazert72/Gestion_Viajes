<?php
require_once('../conexion.php');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reserva_id = $_POST['reserva_id'] ?? null;
    $accion = $_POST['accion'] ?? null;

    if (!$reserva_id || !$accion) {
        echo json_encode(['success' => false, 'message' => 'Faltan parámetros.']);
        exit;
    }

    $obj = new Database();
    $conn = $obj->getConexion();

    if ($conn->connect_error) {
        echo json_encode(['success' => false, 'message' => 'Error de conexión.']);
        exit;
    }

    if ($accion === 'confirmar') {
        // 1. Obtener el viaje de la reserva
        $stmt = $conn->prepare("SELECT viaje_id FROM reservas WHERE id = ?");
        $stmt->bind_param("i", $reserva_id);
        $stmt->execute();
        $stmt->bind_result($viaje_id);
        $stmt->fetch();
        $stmt->close();

        if (!$viaje_id) {
            echo json_encode(['success' => false, 'message' => 'Reserva o viaje no encontrado.']);
            exit;
        }

        // 2. Obtener el ID del bus y su capacidad
        $stmt = $conn->prepare("SELECT v.bus, b.capacidad FROM viajes v JOIN buses b ON v.bus = b.id WHERE v.id = ?");
        $stmt->bind_param("i", $viaje_id);
        $stmt->execute();
        $stmt->bind_result($bus_id, $capacidad_total);
        $stmt->fetch();
        $stmt->close();

        if (!$bus_id || !$capacidad_total) {
            echo json_encode(['success' => false, 'message' => 'Bus o capacidad no disponible.']);
            exit;
        }

        // 3. Contar cuántas reservas hay ya confirmadas en ese viaje
        $stmt = $conn->prepare("SELECT COUNT(*) FROM reservas WHERE viaje_id = ? AND estado_pago = 'confirmada'");
        $stmt->bind_param("i", $viaje_id);
        $stmt->execute();
        $stmt->bind_result($reservas_confirmadas);
        $stmt->fetch();
        $stmt->close();

        if ($reservas_confirmadas >= $capacidad_total) {
            echo json_encode(['success' => false, 'message' => 'No hay asientos disponibles en este bus.']);
            exit;
        }

        // 4. Asignar asiento como: capacidad - reservas confirmadas
        $num_asiento = $capacidad_total - $reservas_confirmadas;

        // 5. Confirmar reserva
        $stmt = $conn->prepare("UPDATE reservas SET estado_pago = 'confirmada', num_asiento_bus = ? WHERE id = ?");
        $stmt->bind_param("ii", $num_asiento, $reserva_id);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => "Reserva confirmada. Asiento asignado: $num_asiento"]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al confirmar la reserva.']);
        }
        $stmt->close();

    } elseif ($accion === 'cancelar') {
        // Obtener datos de la reserva
        $stmt = $conn->prepare("SELECT viaje_id, estado_pago FROM reservas WHERE id = ?");
        $stmt->bind_param("i", $reserva_id);
        $stmt->execute();
        $stmt->bind_result($viaje_id, $estado_pago);
        $stmt->fetch();
        $stmt->close();

        // Eliminar la reserva
        $stmt = $conn->prepare("DELETE FROM reservas WHERE id = ?");
        $stmt->bind_param("i", $reserva_id);
        if ($stmt->execute()) {
            $stmt->close();
            echo json_encode(['success' => true, 'message' => 'Reserva cancelada correctamente.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al cancelar la reserva.']);
        }

    } else {
        echo json_encode(['success' => false, 'message' => 'Acción no válida.']);
    }

    $conn->close();
}
?>
