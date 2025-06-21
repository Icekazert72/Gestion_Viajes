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
    <title>Tipo de servicio</title>
    <link rel="stylesheet" href="../css/all.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/fontawesome.min.css">
    <link rel="stylesheet" href="../css/window2.css">
</head>

<body>

    <div class="card_container container">
        <div class="card_head">
            <div class="title">
                <h4>Reserva de boleto</h4>
            </div>
            <div class="txt">
                <p>
                    <small>
                        Selecciona el tipo de servicio que deseas para tu viaje. 
                        Puedes elegir entre tres opciones: Básico, Platino y Oro. 
                        Cada uno ofrece diferentes beneficios y comodidades para hacer tu experiencia de viaje más placentera.
                        <br>
                        <strong>Nota:</strong> El servicio básico es gratuito, mientras que los servicios Platino y Oro tienen un costo adicional.
                    </small>
                </p>
            </div>
        </div>
        <div class="card_body">
            <div class="card basic">
                <div class="shine"></div>
                <div class="basic_head">
                    <h5>SERVICIO BASICO</h5>
                    <p>GRATIS</p>
                </div>
                <div class="basic_body">
                    <ul>
                        <li><i class="fas fa-check"></i> Asiento compartido</li>
                        <li><i class="fas fa-times"></i> Servicio de agua</li>
                        <li><i class="fas fa-check"></i> Entretenimiento básico</li>
                        <li><i class="fas fa-times"></i> Wifi limitado</li>
                        <li><i class="fas fa-times"></i> Sin comida incluida</li>
                        <li><i class="fas fa-times"></i> Sin servicio de atención al cliente</li>
                        <li><i class="fas fa-check"></i> equipaje adicional</li>
                    </ul>
                </div>
                <div class="basic_foot">
                    <button type="button" class="btn_basic btn_servicio" data-tipo="platino">Seleccionar</button>
                </div>
            </div>

            <div class="card platinum">
                <div class="shine"></div>
                <div class="platinum_head">
                    <h5>SERVICIO PLATINO</h5>
                    <p>1500 xaf</p>
                </div>
                <div class="platinum_body">
                    <ul>
                        <li><i class="fas fa-check"></i> Asiento individual</li>
                        <li><i class="fas fa-check"></i> Servicio de agua</li>
                        <li><i class="fas fa-check"></i> Entretenimiento avanzado</li>
                        <li><i class="fas fa-check"></i> Bus con aire acondicionado</li>
                        <li><i class="fas fa-check"></i> Servicio de atención al cliente</li>
                        <li><i class="fas fa-check"></i> Equipaje adicional incluido</li>
                    </ul>
                </div>
                <div class="platinum_foot">
                    <button type="button" class="btn_platinum btn_servicio" data-tipo="platino" data-precio="1500">Seleccionar</button>
                </div>
            </div>

            <div class="card gold">
                <div class="shine"></div>

                <div class="gold_head">
                    <h5>SERVICIO ORO</h5>
                    <p>3000 xaf</p>
                </div>

                <div class="gold_body">
                    <ul>
                        <li><i class="fas fa-check"></i> Asiento de individual</li>
                        <li><i class="fas fa-check"></i> Servicio de agua</li>
                        <li><i class="fas fa-check"></i> Recogida de local</li>
                        <li><i class="fas fa-check"></i> Bus con aire acondicionado</li>
                        <li><i class="fas fa-check"></i> Servicio de atención al cliente </li>
                        <li><i class="fas fa-check"></i> Equipaje adicional incluido</li>
                    </ul>
                </div>
                <div class="gold_foot">
                    <button type="button" class="btn_gold btn_servicio" data-tipo="oro" data-precio="3000">Seleccionar</button>
                </div>
            </div>
        </div>
        <div class="card_footer">
            <footer style="text-align: center; padding: 20px 0; font-size: 0.9rem; color: #666;">
                &copy; 2025 <strong>NDONG_VIAJES</strong>. Todos los derechos reservados.
            </footer>
        </div>
    </div>

    <script src="../../controllers/js/bootstrap.min.js"></script>
    <script src="../../controllers/js/sweetalert2.js"></script>
    <script src="../../controllers/js/tipoServicio.js"></script>
</body>

</html>