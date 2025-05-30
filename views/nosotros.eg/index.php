<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location:views/login/index.php');
    exit;
}

$username = $_SESSION['usuario'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nosotros</title>
    <link rel="stylesheet" href="../css/all.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/fontawesome.min.css">
    <link rel="stylesheet" href="../css/othersWindows.css">
</head>

<body class="bd_us">
    <header id="header">
        <div class="logo">
            <div title="Logo" class="img_logo"><img src="../../img/index/Logo_viages.png" alt=""></div>
            <div class="logo_text">
                <h5 title="Texto del logo">Ndong Viajes</h5>
                <div class="hidenMenu" id="hidenmenu">
                    <div class="list">
                        <div>
                            <h5>Gestion</h5>
                        </div>
                        <div title="inicio del sitio"><a href="../../index.php">Inicio</a></div>
                        <div><a href="#"  title="Acerca de nosotros">Nosotros</a></div>
                        <div><a href="../agencias.eg/index.php" title="Sobre otras agencias">Agencias</a></div>
                       
                    </div>
                </div>
            </div>

        </div>
        <div class="nav">
            <div class="nav_navegar">
                <div><a href="../../index.php">Inicio</a></div>
                <div> <a href="#" class="active">Nosotros</a></div>
                <div> <a href="../agencias.eg/index.php">Agencias</a></div>
            </div>
            <div class="burgerButton" id="btn_mn"><i class="fa-solid fa-bars"></i></div>
            <div title="Registrate aqui" class="btn"><a href="#"><i class="fa-solid fa-user"></i></a></div>
            <div title="Cambiar el idioma aqui" class="idioma"><img src="../../img/index/bandera.png" alt=""></div>
        </div>
    </header>


    <!-- Header intacto (no tocado) -->

    <!-- Hero / Sobre Nosotros -->
    <section class="hero-section text-center py-5 bg-light">
        <div class="container">
            <h1 class="display-4 mb-3">Conócenos</h1>
            <p class="lead">
                Somos una empresa dedicada al transporte de larga distancia, con una flota moderna y un equipo capacitado para que tu viaje sea seguro, cómodo y puntual.
            </p>
            <img src="../../img/index/Logo_viages.png" alt="Logo Ndong Viajes" class="img-fluid mt-4" style="max-height: 120px;">
        </div>
    </section>

    <!-- ¿Quiénes somos? -->
    <section class="container py-5">
        <h2 class="mb-3">¿Quiénes somos?</h2>
        <p>
            Ndong_viajes es una empresa de transporte terrestre especializada en viajes en autobús. Nuestra misión es ofrecer un servicio de calidad, puntualidad y seguridad a cada pasajero. Contamos con una flota moderna, personal capacitado y cobertura nacional.
        </p>
    </section>

    <!-- Rutas -->
    <section class="bg-light py-5">
        <div class="container">
            <h2 class="mb-4">Rutas frecuentes</h2>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Malabo – Bata</h5>
                            <p class="card-text">4h • Salida: 08:00 y 16:00 • Lunes a Sábado</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Bata – Evinayong</h5>
                            <p class="card-text">2h 30min • Salida: 10:00 • Todos los días</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Malabo – Luba</h5>
                            <p class="card-text">1h 30min • Salida: 07:00, 12:00 y 17:00</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Bata – Mongomo</h5>
                            <p class="card-text">5h • Salida: 06:00 • Viernes a Domingo</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Servicios -->
    <section class="container py-5">
        <h2 class="mb-4">Servicios ofrecidos</h2>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">Venta online de billetes</li>
            <li class="list-group-item">Viajes turísticos personalizados</li>
            <li class="list-group-item">Transporte de paquetes y documentos</li>
            <li class="list-group-item">Wi-Fi y aire acondicionado a bordo</li>
            <li class="list-group-item">Alquiler privado de buses para empresas</li>
        </ul>
    </section>

    <!-- Reservas -->
    <!-- <section id="reservas" class="bg-light py-5">
        <div class="container">
            <h2 class="mb-4">Reservas</h2>
            <p>Para reservar tu viaje, completa el siguiente formulario:</p>
            <form class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nombre completo</label>
                    <input type="text" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Ruta deseada</label>
                    <select class="form-select" required>
                        <option>Malabo – Bata</option>
                        <option>Bata – Evinayong</option>
                        <option>Malabo – Luba</option>
                        <option>Bata – Mongomo</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Fecha del viaje</label>
                    <input type="date" class="form-control" required>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary mt-3">Enviar reserva</button>
                </div>
            </form>
        </div>
    </section> -->

    <!-- FAQ -->
    <section class="container py-5">
        <h2 class="mb-4">Preguntas frecuentes</h2>
        <div class="accordion" id="faqAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="q1">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#a1">
                        ¿Puedo cancelar o cambiar una reserva?
                    </button>
                </h2>
                <div id="a1" class="accordion-collapse collapse show">
                    <div class="accordion-body">Sí, hasta 24 horas antes de la salida. Contacta al soporte.</div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="q2">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#a2">
                        ¿Cómo puedo reservar un boleto?
                    </button>
                </h2>
                <div id="a2" class="accordion-collapse collapse">
                    <div class="accordion-body">
                       Puedes reservar tu boleto directamente en nuestro sitio web llenando el formulario de reservas o visitando una de nuestras agencias autorizadas.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="q2">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#a2">
                        ¿Puedo llevar equipaje extra?
                    </button>
                </h2>
                <div id="a2" class="accordion-collapse collapse">
                    <div class="accordion-body">Se permite hasta 20kg gratis. El exceso tiene un costo adicional.</div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="q2">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#a2">
                        ¿Con cuánto tiempo de anticipación debo llegar a la estación?
                    </button>
                </h2>
                <div id="a2" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        Recomendamos llegar al menos 30 minutos antes de la hora de salida programada para evitar contratiempos.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="q3">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#a3">
                        ¿Los buses tienen baño?
                    </button>
                </h2>
                <div id="a3" class="accordion-collapse collapse">
                    <div class="accordion-body">Algunas unidades lo incluyen. Confirma al reservar.</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonios -->
    <section class="bg-light py-5">
        <div class="container">
            <h2 class="mb-4">Lo que dicen nuestros clientes</h2>
            <blockquote class="blockquote">
                <p>“Excelente servicio, puntual y muy cómodo. ¡Viajar con Ndong_viajes fue una gran experiencia!”</p>
                <footer class="blockquote-footer">Ana, Malabo</footer>
            </blockquote>
            <blockquote class="blockquote mt-4">
                <p>“Reservé online sin problema. El bus salió a tiempo y el personal fue muy amable.”</p>
                <footer class="blockquote-footer">José, Bata</footer>
            </blockquote>
        </div>
    </section>

    <!-- Contacto -->
<section id="contacto" class="container py-5">
  <h2 class="mb-4 text-primary">Contacto</h2>
  <div class="contact-info mb-4">
    <p><i class="fa-solid fa-location-dot me-2 text-primary"></i><strong>Dirección:</strong> Av. Central 123, Malabo, Guinea Ecuatorial</p>
    <p><i class="fa-solid fa-phone me-2 text-primary"></i><strong>Teléfono:</strong> +240 555 123 456</p>
    <p><i class="fa-solid fa-envelope me-2 text-primary"></i><strong>Email:</strong> contacto@ndongviajes.com</p>
  </div>
  <div class="ratio ratio-16x9">
    <iframe src="https://maps.google.com/maps?q=malabo&t=&z=13&ie=UTF8&iwloc=&output=embed" allowfullscreen loading="lazy"></iframe>
  </div>
</section>


    <!-- Footer -->
  
    <footer>
        <div class="footer-container">


            <div class="footer-column">
                <h3>Ndong Viajes</h3>
                <p>Tu mejor elección para viajar por carretera con comodidad, seguridad y puntualidad.</p>
                <img src="../../img//index/Logo_viages.png" alt="">
            </div>

            <div class="footer-column">
                <h3>Enlaces útiles</h3>
                <ul>
                    <li><a href="#">Inicio</a></li>
                    <li><a href="#">Destinos</a></li>
                    <li><a href="#">Reservas</a></li>
                    <li><a href="#">Contacto</a></li>
                    <li><a href="#">Términos y condiciones</a></li>
                </ul>
            </div>


            <div class="footer-column">
                <h3>Contacto</h3>
                <ul>
                    <li><i class="fa-regular fa-map"></i>
                        <p>Calle Principal 45, Malabo</p>
                    </li>
                    <li><i class="fa-solid fa-square-phone"></i>
                        <p>+240 555 123456</p>
                    </li>
                    <li><i class="fa-regular fa-envelope"></i>
                        <p>info@ndongviajes.com</p>
                    </li>
                </ul>
            </div>


            <div class="footer-column">
                <h3>Síguenos</h3>
                <ul>
                    <li><a href="#"><i class="fa-brands fa-facebook"></i>
                            <p>Facebook</p>
                        </a></li>
                    <li><a href="#"><i class="fa-brands fa-instagram"></i>
                            <p>Instagram</p>
                        </a></li>
                    <li><a href="#"><i class="fa-brands fa-twitch"></i>
                            <p>Twitter</p>
                        </a></li>
                </ul>

                <h3 style="margin-top: 20px;">Idioma</h3>
                <select title="Seleccionar idioma de la web" class="language-select" id="idiomas">
                    <option value="es" id="es">Español (Guinea Ecuatorial)</option>
                    <option value="fr" id="fr">Français</option>
                    <option value="en" id="en">English</option>
                </select>
            </div>
        </div>

        <div class="footer-bottom">
            &copy; 2025 Ndong Viajes. Todos los derechos reservados.
        </div>
    </footer>





    <script src="../../controllers/js/bootstrap.min.js"></script>
    <script src="../../controllers/js/botones.js"></script>
    <script src="../../controllers/js/sweetalert2.js"></script>
</body>

</html>