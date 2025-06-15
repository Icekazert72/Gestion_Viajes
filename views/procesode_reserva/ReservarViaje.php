<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location:views/login/index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/all.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/fontawesome.min.css">
    <link rel="stylesheet" href="../css/window3.css">
</head>

<body>

    <button onclick="abrirResumenReserva()" class="btn btn-outline-primary mt-3">
        Ver Resumen de Reserva
    </button>
    <button onclick="mostrarInfoUsuario()" class="btn btn-outline-secondary mt-3">
        Ver Información del Usuario
    </button>


    <script src="../../controllers/js/bootstrap.min.js"></script>
    <script src="../../controllers/js/sweetalert2.js"></script>
    <script src="../../controllers/js/RVG.js"></script>
</body>

</html>