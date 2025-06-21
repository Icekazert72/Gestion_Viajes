<?php
session_start();

if (isset($_SESSION['usuario']) && isset($_SESSION['tipo'])) {
    if ($_SESSION['tipo'] === 'admin') {
        header('Location:views/admin/index.php');
        exit;
    }
    $username = $_SESSION['usuario']; // Usuario normal
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
    <link rel="stylesheet" href="../css/ReservasPub.css">
</head>

<body>

    <div class="container pago-container">
        <div class="text-center titulo">¿Cómo deseas realizar tu pago?</div>

        <div class="d-grid gap-3">
            <button id="btnPagoPresencial" class="btn btn-outline-success" onclick="pagoPresencial()">Pago Presencial</button>
            <button class="btn btn-outline-primary" onclick="iniciarPagoEnLinea()">Pago en Línea (Muni Dinero)</button>
        </div>

        <form id="formMuni" class="form-muni mt-4">
            <h5 class="text-center text-info mb-3">Formulario Muni Dinero</h5>

            <div class="mb-3 position-relative">
                <label for="nombre" class="form-label">Nombre Completo</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" class="form-control" id="nombre" required>
                </div>
                <span class="icon-feedback" id="icon-nombre"></span>
            </div>

            <div class="mb-3 position-relative">
                <label for="dni" class="form-label">Número de Identidad Personal</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                    <input type="text" class="form-control" id="dni" required>
                </div>
                <span class="icon-feedback" id="icon-dni"></span>
            </div>

            <div class="mb-3 position-relative">
                <label for="telefono" class="form-label">Número Telefónico</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                    <input type="tel" class="form-control" id="telefono" required>
                </div>
                <span class="icon-feedback" id="icon-telefono"></span>
            </div>

            <!-- Ocultos -->
            <input type="hidden" id="destino_envio" value="Agencia Ndong Viajes Malabo">
            <input type="hidden" id="contacto_agencia" value="+240 555 123 456">
            <input type="hidden" id="cantidad" value="15000">

            <button type="submit" id="btnPagar" class="btn btn-primary w-100 mt-3">Comprar Boleto</button>
        </form>

        <div class="acciones-secundarias text-center">
            <button onclick="abrirResumenReserva()" class="btn btn-outline-dark me-2 mt-4">
                Ver Resumen de Reserva
            </button>
            <button onclick="mostrarInfoUsuario()" class="btn btn-outline-secondary mt-4">
                Ver Información del Usuario
            </button>
        </div>
        <div id="formsContainer"></div>
    </div>

    <!-- Mini Overlay (no ocupa toda la pantalla) -->
    <div id="mini-overlay">
        <div class="text-center mb-2">
            <i class="fas fa-lock fa-2x text-warning"></i>
        </div>
        <h6 class="text-center">Verificando cuenta Muni Dinero...</h6>
        <p class="text-center">¿Tienes una cuenta registrada?</p>
        <div class="d-flex justify-content-around">
            <button class="btn btn-sm btn-success" onclick="confirmarTieneCuenta()">Sí tengo cuenta</button>
            <button class="btn btn-sm btn-danger" onclick="cancelarPorFaltaCuenta()">No tengo cuenta</button>
        </div>
    </div>

    <!-- Toast personalizado -->
    <div id="toastHistorial" class="toast position-fixed bottom-0 end-0 m-4" role="alert" aria-live="assertive" aria-atomic="true" style="display: none; min-width: 250px;">
        <div class="toast-header bg-primary text-white">
            <strong class="me-auto">✅ Reserva Exitosa</strong>
            <button type="button" class="btn-close btn-close-white" onclick="document.getElementById('toastHistorial').style.display='none'"></button>
        </div>
        <div class="toast-body">
            <p class="toast-text">Ver historial de reservas</p>
            <button class="btn btn-sm btn-outline-primary" onclick="window.location.href='../../views/usuario/panel.php'">Ir al panel</button>
        </div>
    </div>

    <div id="toast" class="toast hidden">
        <span id="toast-message"></span>
    </div>

    <!-- Toast interactivo -->
    <div id="toastOpcion" class="toast hidden">
        <span id="toast-message-opcion"></span>
        <div class="toast-buttons">
            <button onclick="handlePresencial(true)">Sí</button>
            <button onclick="handlePresencial(false)">No</button>
        </div>
    </div>



    <style>
        .toast {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background-color: #1e1e1e;
            color: #fff;
            padding: 24px 36px;
            border-radius: 12px;
            font-size: 1.2rem;
            font-family: sans-serif;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.4);
            opacity: 0;
            transform: translateY(100px);
            transition: opacity 0.4s ease, transform 0.4s ease;
            z-index: 9999;
            max-width: 400px;
        }

        .toast.show {
            opacity: 1;
            transform: translateY(0);
        }

        .toast.hidden {
            display: none;
        }

        .toast-buttons {
            margin-top: 20px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .toast-buttons button {
            padding: 8px 16px;
            border: none;
            border-radius: 8px;
            background-color: #007bff;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .toast-buttons button:hover {
            background-color: #0056b3;
        }
    </style>

    <script src="../../controllers/js/bootstrap.min.js"></script>
    <script src="../../controllers/js/sweetalert2.js"></script>
    <script src="../../controllers/js/RVG.js"></script>
</body>

</html>