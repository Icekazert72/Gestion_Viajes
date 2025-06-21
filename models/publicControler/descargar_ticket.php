<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    http_response_code(403);
    exit('No autorizado. Por favor inicia sesión.');
}

$usuarioIdSesion = $_SESSION['usuario_id'];

require '../conexion.php'; // Asegúrate de que $conn sea una conexión mysqli válida
require '../../libs/fpdf.php';

$obj = new DATABASE;
$conn = $obj->getConexion();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    http_response_code(400);
    exit('ID de reserva inválido.');
}

$idReserva = intval($_GET['id']);

$sql = "
    SELECT r.id, r.num_asiento_bus, r.tipo_servicio, r.estado_pago, r.usuario_id,
           v.fecha_viaje, v.hora_salida, v.hora_llegada,
           a.nombre AS agencia, a.direccion, a.telefono,
           u.nombre AS usuario, ru.origen, ru.destino, ru.precio
    FROM reservas r
    INNER JOIN viajes v ON r.viaje_id = v.id
    INNER JOIN agencias a ON r.agencia_id = a.id
    INNER JOIN usuarios u ON r.usuario_id = u.id
    INNER JOIN rutas ru ON v.ruta = ru.id
    WHERE r.id = $idReserva
    LIMIT 1
";

$result = $conn->query($sql);
if (!$result || $result->num_rows === 0) {
    http_response_code(404);
    exit('Reserva no encontrada.');
}

$reserva = $result->fetch_assoc();

if ((int)$reserva['usuario_id'] !== (int)$usuarioIdSesion) {
    http_response_code(403);
    exit('No tienes permiso para este ticket.');
}

// Crear PDF tipo ticket
$pdf = new FPDF('P', 'mm', [80, 200]);
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
$pdf->SetFillColor(0, 102, 204);
$pdf->SetTextColor(255);
$pdf->Cell(0, 10, 'TICKET DE RESERVA', 0, 1, 'C', true);
$pdf->Ln(2);

// Info de agencia
$pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(0);
$pdf->Cell(0, 5, 'Agencia: ' . $reserva['agencia'], 0, 1);
$pdf->Cell(0, 5, 'Tel: ' . $reserva['telefono'], 0, 1);
$pdf->Cell(0, 5, 'Dirección: ' . $reserva['direccion'], 0, 1);
$pdf->Ln(2);
$pdf->Line(10, $pdf->GetY(), 70, $pdf->GetY());
$pdf->Ln(2);

// Detalles del cliente y viaje
$pdf->Cell(0, 5, 'Cliente: ' . $reserva['usuario'], 0, 1);
$pdf->Cell(0, 5, 'Origen: ' . $reserva['origen'], 0, 1);
$pdf->Cell(0, 5, 'Destino: ' . $reserva['destino'], 0, 1);
$pdf->Cell(0, 5, 'Fecha: ' . $reserva['fecha_viaje'], 0, 1);
$pdf->Cell(0, 5, 'Hora Salida: ' . $reserva['hora_salida'], 0, 1);
$pdf->Cell(0, 5, 'Hora Llegada: ' . $reserva['hora_llegada'], 0, 1);
$pdf->Cell(0, 5, 'Servicio: ' . $reserva['tipo_servicio'], 0, 1);
$pdf->Cell(0, 5, 'Asiento #: ' . $reserva['num_asiento_bus'], 0, 1);
$pdf->Ln(2);
$pdf->Line(10, $pdf->GetY(), 70, $pdf->GetY());
$pdf->Ln(2);

// Precio
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 8, 'TOTAL: $' . number_format($reserva['precio'], 2), 0, 1, 'R');

// Footer
$pdf->SetFont('Arial', 'I', 9);
$pdf->SetY(-15);
$pdf->Cell(0, 5, 'Gracias por viajar con nosotros.', 0, 1, 'C');

$pdf->Output('D', 'ticket_reserva_' . $reserva['id'] . '.pdf');
exit;
?>
