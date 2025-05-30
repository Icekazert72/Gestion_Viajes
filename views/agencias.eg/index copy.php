<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Las agencias</title>
    <link rel="stylesheet" href="../css/all.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/fontawesome.min.css">
    <link rel="stylesheet" href="../css/agencia.css">
</head>
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
                    <div><a href="../nosotros.eg/" title="Acerca de nosotros">Nosotros</a></div>
                    <div><a href="#" title="Sobre otras agencias">Agencias</a></div>
                    <div>
                        <h5>Tipo de Servicio</h5>
                    </div>
                    <div><a href="#">Viajes</a></div>
                    <div title="Servicio de transporte de larga distancia"><a href="#">STLD</a></div>
                </div>
            </div>
        </div>

    </div>
    <div class="nav">
        <div class="nav_navegar">
            <div><a href="../../index.php">Inicio</a></div>
            <div> <a href="../nosotros.eg/">Nosotros</a></div>
            <div> <a href="#" class="active">Agencias</a></div>
        </div>
        <div class="vehiculo">

            <div title="Seliona el tipo de vehiculo" class="menu_opcion">
                <button class="btn drop-down" id="drop-down">Tipo de Servicio <i class="fa-solid fa-angle-down"></i></button>
                <div class="opcion" id="opciones">
                    <div class="cars">
                        <div title="Viaje por bus a larga distancia"><a href="#">VBD</a></div>
                        <div title="Servicio de transporte de larga distancia"><a href="#">STLD</a></div>
                        <div><button class="btn" id="drop-up"><i class="fa-solid fa-angle-up"></i></button></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="burgerButton" id="btn_mn"><i class="fa-solid fa-bars"></i></div>
        <div title="Registrate aqui" class="btn"><a href="#"><i class="fa-solid fa-user"></i></a></div>
        <div title="Cambiar el idioma aqui" class="idioma"><img src="../../img/index/bandera.png" alt=""></div>
    </div>
</header>

<body>

 <div class="agencia-card">
  <div class="agencia-header">
    <img src="../../img/index/images.png" alt="Logo Forama" class="logo-img">
    <div class="logo-text">
      <h2>Forama</h2>
      <img src="../../img/index/bandera.png" alt="Bandera" class="flag-img">
    </div>
  </div>

  <div class="agencia-body">
    <div class="descripcion">
      <h4>Descripción</h4>
      <p>Forama es una agencia de viajes que se especializa en ofrecer experiencias únicas y personalizadas. Crea itinerarios a medida adaptados a cada viajero.</p>
    </div>

    <div class="info-contacto">
      <div>
        <p><i class="fa-solid fa-phone"></i> +240 222 123 456</p>
        <p><i class="fa-solid fa-envelope"></i> viajarcon@foramail.com</p>
        <p><i class="fa-solid fa-location-dot"></i> Bikuy, Mercado, Rotonda</p>
      </div>
      <div class="social-icons">
        <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
        <a href="#"><i class="fa-brands fa-instagram"></i></a>
        <a href="#"><i class="fa-brands fa-twitch"></i></a>
        <a href="#"><i class="fa-brands fa-whatsapp"></i></a>
      </div>
    </div>

    <div class="agencia-mapa">
      <iframe src="https://www.google.com/maps/embed?..." frameborder="0" allowfullscreen=""></iframe>
    </div>

    <div class="agencia-footer">
      <a href="rutas_agencias.php" class="btn-ticket">Obtener Ticket</a>
    </div>
  </div>
</div>


    <footer>
        <div class="footer-container">


            <div class="footer-column">
                <h3>Ndong Viajes</h3>
                <p>Tu mejor elección para viajar por carretera con comodidad, seguridad y puntualidad.</p>
                <img src="../../img/index/Logo_viages.png" alt="">
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