<?php
header('Content-Type: application/json');
session_start();

require('../conexion.php');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Agencia no autenticada']);
    exit;
}

$obj = new DATABASE;
$conn = $obj->getConexion();

$agencia_id = (int)$_SESSION['user_id'];

// Configura tu conexión a la base de datos

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Error de conexión a la base de datos']);
    exit;
}

// Función para obtener el inicio y fin de la semana actual (lunes a domingo)
function getStartEndWeek()
{
    $dt = new DateTime();
    $dt->setISODate((int)$dt->format('o'), (int)$dt->format('W'));
    $start = $dt->format('Y-m-d');
    $dt->modify('+6 days');
    $end = $dt->format('Y-m-d');
    return [$start, $end];
}

// Función para obtener total sumando "monto" según tabla, agencia y rango de fechas
function obtenerTotal($conn, $tabla, $agencia_id, $fecha_inicio, $fecha_fin, $col_fecha = 'fecha')
{
    $sql = "SELECT COALESCE(SUM(monto),0) as total 
            FROM $tabla 
            WHERE agencia = ? AND $col_fecha BETWEEN ? AND ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $agencia_id, $fecha_inicio, $fecha_fin);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return (float)$res['total'];
}

// Obtener totales para cada periodo:

// Día actual
$hoy = date('Y-m-d');
$ingresos_dia = obtenerTotal($conn, 'ingresos', $agencia_id, $hoy, $hoy);
$gastos_dia = obtenerTotal($conn, 'gastos', $agencia_id, $hoy, $hoy);
$pagos_dia = obtenerTotal($conn, 'pagos_empleados', $agencia_id, $hoy, $hoy, 'fecha_pago');

// Semana actual
list($inicio_sem, $fin_sem) = getStartEndWeek();
$ingresos_semana = obtenerTotal($conn, 'ingresos', $agencia_id, $inicio_sem, $fin_sem);
$gastos_semana = obtenerTotal($conn, 'gastos', $agencia_id, $inicio_sem, $fin_sem);
$pagos_semana = obtenerTotal($conn, 'pagos_empleados', $agencia_id, $inicio_sem, $fin_sem, 'fecha_pago');

// Mes actual
$anio_actual = date('Y');
$mes_actual = date('m');
$inicio_mes = "$anio_actual-$mes_actual-01";
$fin_mes = date('Y-m-t');
$ingresos_mes = obtenerTotal($conn, 'ingresos', $agencia_id, $inicio_mes, $fin_mes);
$gastos_mes = obtenerTotal($conn, 'gastos', $agencia_id, $inicio_mes, $fin_mes);
$pagos_mes = obtenerTotal($conn, 'pagos_empleados', $agencia_id, $inicio_mes, $fin_mes, 'fecha_pago');

// Año actual
$inicio_ano = "$anio_actual-01-01";
$fin_ano = "$anio_actual-12-31";
$ingresos_ano = obtenerTotal($conn, 'ingresos', $agencia_id, $inicio_ano, $fin_ano);
$gastos_ano = obtenerTotal($conn, 'gastos', $agencia_id, $inicio_ano, $fin_ano);
$pagos_ano = obtenerTotal($conn, 'pagos_empleados', $agencia_id, $inicio_ano, $fin_ano, 'fecha_pago');

$data = [
    "dia" => [
        "ingresos" => $ingresos_dia,
        "gastos" => $gastos_dia,
        "pagos" => $pagos_dia
    ],
    "semana" => [
        "ingresos" => $ingresos_semana,
        "gastos" => $gastos_semana,
        "pagos" => $pagos_semana
    ],
    "mes" => [
        "ingresos" => $ingresos_mes,
        "gastos" => $gastos_mes,
        "pagos" => $pagos_mes
    ],
    "ano" => [
        "ingresos" => $ingresos_ano,
        "gastos" => $gastos_ano,
        "pagos" => $pagos_ano
    ],
];

echo json_encode($data);

$conn->close();
