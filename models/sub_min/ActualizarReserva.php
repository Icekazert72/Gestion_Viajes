<?php
require_once('../conexion.php');
header('Content-Type: application/json');
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no soportado.']);
    exit;
}

$reserva_id = $_POST['reserva_id'] ?? null;
$accion = $_POST['accion'] ?? null;

if (!$reserva_id || !$accion) {
    echo json_encode(['success' => false, 'message' => 'Faltan parámetros.']);
    exit;
}

$obj = new Database();
$conn = $obj->getConexion();

$idAgencia = $_SESSION['user_id'];

if ($accion === 'confirmar') {
    // Obtener datos de la reserva
    $stmt = $conn->prepare("SELECT id, tutor_id, usuario_id, viaje_id FROM reservas WHERE id = ?");
    $stmt->bind_param("i", $reserva_id);
    $stmt->execute();
    $stmt->bind_result($idReserva, $tutorId, $usuarioReserva, $viaje_id);
    $stmt->fetch();
    $stmt->close();

    if (!$idReserva) {
        echo json_encode(['success' => false, 'message' => 'Reserva no encontrada.']);
        exit;
    }

    // Obtener todas las reservas del usuario en ese viaje (reserva principal + posibles reservas vinculadas)
    $stmt = $conn->prepare("
        SELECT id FROM reservas 
        WHERE usuario_id = ? AND viaje_id = ? AND (id = ? OR tutor_id = ?)
    ");
    $stmt->bind_param("iiii", $usuarioReserva, $viaje_id, $idReserva, $idReserva);
    $stmt->execute();
    $result = $stmt->get_result();

    $reservasUsuario = [];
    while ($row = $result->fetch_assoc()) {
        $reservasUsuario[] = $row['id'];
    }
    $stmt->close();

    $cantidadReservas = count($reservasUsuario);
    if ($cantidadReservas === 0) {
        echo json_encode(['success' => false, 'message' => 'No se encontraron reservas del usuario para este viaje.']);
        exit;
    }

    // Obtener datos del viaje
    $stmt = $conn->prepare("
        SELECT v.bus, b.capacidad, ru.precio
        FROM viajes v
        JOIN buses b ON v.bus = b.id
        JOIN rutas ru ON v.ruta = ru.id
        WHERE v.id = ?
    ");
    $stmt->bind_param("i", $viaje_id);
    $stmt->execute();
    $stmt->bind_result($bus_id, $capacidad_total, $precio_ruta);
    $stmt->fetch();
    $stmt->close();

    if (!$bus_id) {
        echo json_encode(['success' => false, 'message' => 'Datos del viaje no encontrados.']);
        exit;
    }

    // Contar reservas confirmadas (ocupación actual del bus)
    $stmt = $conn->prepare("SELECT COUNT(*) FROM reservas WHERE viaje_id = ? AND estado_pago = 'confirmada'");
    $stmt->bind_param("i", $viaje_id);
    $stmt->execute();
    $stmt->bind_result($reservas_confirmadas);
    $stmt->fetch();
    $stmt->close();

    // Contar acompañantes para ese viaje
    $stmt = $conn->prepare("SELECT COUNT(*) FROM pasajeros_reserva WHERE viaje = ?");
    $stmt->bind_param("i", $viaje_id);
    $stmt->execute();
    $stmt->bind_result($totalAcompanantes);
    $stmt->fetch();
    $stmt->close();

    $totalPersonas = 1 + $totalAcompanantes; // 1 usuario principal + acompañantes

    // Verificar si hay suficientes asientos disponibles
    if (($reservas_confirmadas + $totalPersonas) > $capacidad_total) {
        echo json_encode(['success' => false, 'message' => 'No hay asientos disponibles para confirmar la reserva del usuario y acompañantes.']);
        exit;
    }

    $conn->begin_transaction();

    // Asignar asientos consecutivos a las reservas del usuario
    $asientoActual = $reservas_confirmadas + 1;

    foreach ($reservasUsuario as $idRes) {
        $stmt = $conn->prepare("UPDATE reservas SET estado_pago = 'confirmada', num_asiento_bus = ? WHERE id = ?");
        $stmt->bind_param("ii", $asientoActual, $idRes);
        $okUpdate = $stmt->execute();
        $stmt->close();

        if (!$okUpdate) {
            $conn->rollback();
            echo json_encode(['success' => false, 'message' => 'Error al confirmar la reserva ID ' . $idRes]);
            exit;
        }

        $asientoActual++;
    }

    // Calcular monto total
    $montoTotal = $precio_ruta * $totalPersonas;
    $fechaHoy = date('Y-m-d');

    // Registrar el pago (solo una vez para la reserva principal)
    $stmt = $conn->prepare("INSERT INTO pagos_cliente (reserva_id, fecha_pago, monto, metodo_pago) VALUES (?, ?, ?, 'efectivo')");
    $stmt->bind_param("isd", $idReserva, $fechaHoy, $montoTotal);
    $okPago = $stmt->execute();
    $stmt->close();

    if (!$okPago) {
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => 'Error al registrar el pago total.']);
        exit;
    }

    // Registrar ingreso a la agencia
    $descripcion = "Pago total reserva usuario #{$usuarioReserva} y {$totalAcompanantes} acompañante(s)";
    $stmt = $conn->prepare("INSERT INTO ingresos (agencia, monto, descripcion, fecha) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("idss", $idAgencia, $montoTotal, $descripcion, $fechaHoy);
    $okIngreso = $stmt->execute();
    $stmt->close();

    if (!$okIngreso) {
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => 'Error al registrar ingreso de la agencia.']);
        exit;
    }

    $conn->commit();

    echo json_encode([
        'success' => true,
        'message' => "Reserva confirmada correctamente. Se asignaron asientos desde {$reservas_confirmadas} hasta " . ($asientoActual - 1) . ".",
        'monto_total' => $montoTotal,
        'total_personas' => $totalPersonas
    ]);
}
?>
