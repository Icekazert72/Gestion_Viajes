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
    <title>Rutas</title>
    <link rel="stylesheet" href="../css/all.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/fontawesome.min.css">
    <link rel="stylesheet" href="../css/othersWindows.css">
</head>

<body>
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
                        <div><a href="#" title="Acerca de nosotros">Nosotros</a></div>
                        <div><a href="../agencias.eg/index.php" title="Sobre otras agencias">Agencias</a></div>
                        
                    </div>
                </div>
            </div>

        </div>
        <div class="nav">
            <div class="nav_navegar">
                <div><a href="../../index.php">Inicio</a></div>
                <div> <a href="#">Nosotros</a></div>
                <div> <a href="#">Agencias</a></div>
            </div>
            <div class="burgerButton" id="btn_mn"><i class="fa-solid fa-bars"></i></div>
            <div title="Registrate aqui" class="btn"><a href="#"><i class="fa-solid fa-user"></i></a></div>
            <div title="Cambiar el idioma aqui" class="idioma"><img src="../../img/index/bandera.png" alt=""></div>
        </div>
    </header>

    <div class="slider_rutas">
        <div class="text">
            <div class="title">
                <h1>Terminal de rutas</h1>
            </div>
        </div>
        <div class="img">

        </div>
    </div>

    <div class="container main">
        <div class="aside">

            <div class="ini">
                <h5>Mañana - 06:00 salidas a</h5>
                <h5 class="des">Malabo</h5>
            </div>
            <div class="container_HmerViaje">


                <div class="ruta">
                    <div class="tiempo">
                        <p title="salida" class="salida">06:15</p>
                        <p class="traso"><i class="fa-solid fa-caret-right"></i></p>
                        <p title="llegada" class="llegada">06:15</p>
                    </div>
                    <div class="nombre">
                        <div class="agencia">
                            <P><strong><i class="fa-solid fa-location-dot"></i></strong></P>
                            <P><strong>Forama</strong></P>
                        </div>
                        <div class="precio">
                            <p>3500 xaf</p>
                        </div>
                    </div>
                </div>
                <div class="ruta">
                    <div class="tiempo">
                        <p title="salida" class="salida">06:15</p>
                        <p class="traso"><i class="fa-solid fa-caret-right"></i></p>
                        <p title="llegada" class="llegada">06:15</p>
                    </div>
                    <div class="nombre">
                        <div class="agencia">
                            <P><strong><i class="fa-solid fa-location-dot"></i></strong></P>
                            <P><strong>Forama</strong></P>
                        </div>
                        <div class="precio">
                            <p>3500 xaf</p>
                        </div>
                    </div>
                </div>
                <div class="ruta">
                    <div class="tiempo">
                        <p title="salida" class="salida">06:15</p>
                        <p class="traso"><i class="fa-solid fa-caret-right"></i></p>
                        <p title="llegada" class="llegada">06:15</p>
                    </div>
                    <div class="nombre">
                        <div class="agencia">
                            <P><strong><i class="fa-solid fa-location-dot"></i></strong></P>
                            <P><strong>Forama</strong></P>
                        </div>
                        <div class="precio">
                            <p>3500 xaf</p>
                        </div>
                    </div>
                </div>
                <div class="ruta">
                    <div class="tiempo">
                        <p title="salida" class="salida">06:15</p>
                        <p class="traso"><i class="fa-solid fa-caret-right"></i></p>
                        <p title="llegada" class="llegada">06:15</p>
                    </div>
                    <div class="nombre">
                        <div class="agencia">
                            <P><strong><i class="fa-solid fa-location-dot"></i></strong></P>
                            <P><strong>Forama</strong></P>
                        </div>
                        <div class="precio">
                            <p>3500 xaf</p>
                        </div>
                    </div>
                </div>
                <div class="ruta">
                    <div class="tiempo">
                        <p title="salida" class="salida">06:15</p>
                        <p class="traso"><i class="fa-solid fa-caret-right"></i></p>
                        <p title="llegada" class="llegada">06:15</p>
                    </div>
                    <div class="nombre">
                        <div class="agencia">
                            <P><strong><i class="fa-solid fa-location-dot"></i></strong></P>
                            <P><strong>Forama</strong></P>
                        </div>
                        <div class="precio">
                            <p>3500 xaf</p>
                        </div>
                    </div>
                </div>
                <div class="ruta">
                    <div class="tiempo">
                        <p title="salida" class="salida">06:15</p>
                        <p class="traso"><i class="fa-solid fa-caret-right"></i></p>
                        <p title="llegada" class="llegada">06:15</p>
                    </div>
                    <div class="nombre">
                        <div class="agencia">
                            <P><strong><i class="fa-solid fa-location-dot"></i></strong></P>
                            <P><strong>Forama</strong></P>
                        </div>
                        <div class="precio">
                            <p>3500 xaf</p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="ini">
                <h5>Medio dia - 12:00 salidas a</h5>
                <h5 class="des">Malabo</h5>
            </div>
            <div class="container_HmerViaje">


                <div class="ruta">
                    <div class="tiempo">
                        <p title="salida" class="salida">12:15</p>
                        <p class="traso"><i class="fa-solid fa-caret-right"></i></p>
                        <p title="llegada" class="llegada">14:00</p>
                    </div>
                    <div class="nombre">
                        <div class="agencia">
                            <P><strong><i class="fa-solid fa-location-dot"></i></strong></P>
                            <P><strong>Forama</strong></P>
                        </div>
                        <div class="precio">
                            <p>3500 xaf</p>
                        </div>
                    </div>
                </div>
                <div class="ruta">
                    <div class="tiempo">
                        <p title="salida" class="salida">06:15</p>
                        <p class="traso"><i class="fa-solid fa-caret-right"></i></p>
                        <p title="llegada" class="llegada">06:15</p>
                    </div>
                    <div class="nombre">
                        <div class="agencia">
                            <P><strong><i class="fa-solid fa-location-dot"></i></strong></P>
                            <P><strong>Forama</strong></P>
                        </div>
                        <div class="precio">
                            <p>3500 xaf</p>
                        </div>
                    </div>
                </div>
                <div class="ruta">
                    <div class="tiempo">
                        <p title="salida" class="salida">06:15</p>
                        <p class="traso"><i class="fa-solid fa-caret-right"></i></p>
                        <p title="llegada" class="llegada">06:15</p>
                    </div>
                    <div class="nombre">
                        <div class="agencia">
                            <P><strong><i class="fa-solid fa-location-dot"></i></strong></P>
                            <P><strong>Forama</strong></P>
                        </div>
                        <div class="precio">
                            <p>3500 xaf</p>
                        </div>
                    </div>
                </div>
                <div class="ruta">
                    <div class="tiempo">
                        <p title="salida" class="salida">06:15</p>
                        <p class="traso"><i class="fa-solid fa-caret-right"></i></p>
                        <p title="llegada" class="llegada">06:15</p>
                    </div>
                    <div class="nombre">
                        <div class="agencia">
                            <P><strong><i class="fa-solid fa-location-dot"></i></strong></P>
                            <P><strong>Forama</strong></P>
                        </div>
                        <div class="precio">
                            <p>3500 xaf</p>
                        </div>
                    </div>
                </div>
                <div class="ruta">
                    <div class="tiempo">
                        <p title="salida" class="salida">06:15</p>
                        <p class="traso"><i class="fa-solid fa-caret-right"></i></p>
                        <p title="llegada" class="llegada">06:15</p>
                    </div>
                    <div class="nombre">
                        <div class="agencia">
                            <P><strong><i class="fa-solid fa-location-dot"></i></strong></P>
                            <P><strong>Forama</strong></P>
                        </div>
                        <div class="precio">
                            <p>3500 xaf</p>
                        </div>
                    </div>
                </div>
                <div class="ruta">
                    <div class="tiempo">
                        <p title="salida" class="salida">06:15</p>
                        <p class="traso"><i class="fa-solid fa-caret-right"></i></p>
                        <p title="llegada" class="llegada">06:15</p>
                    </div>
                    <div class="nombre">
                        <div class="agencia">
                            <P><strong><i class="fa-solid fa-location-dot"></i></strong></P>
                            <P><strong>Forama</strong></P>
                        </div>
                        <div class="precio">
                            <p>3500 xaf</p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="ini">
                <h5>Regresos - 18:00 salidas a</h5>
                <h5 class="des">Malabo</h5>
            </div>
            <div class="container_HmerViaje">


                <div class="ruta">
                    <div class="tiempo">
                        <p title="salida" class="salida">06:15</p>
                        <p class="traso"><i class="fa-solid fa-caret-right"></i></p>
                        <p title="llegada" class="llegada">06:15</p>
                    </div>
                    <div class="nombre">
                        <div class="agencia">
                            <P><strong><i class="fa-solid fa-location-dot"></i></strong></P>
                            <P><strong>Forama</strong></P>
                        </div>
                        <div class="precio">
                            <p>3500 xaf</p>
                        </div>
                    </div>
                </div>
                <div class="ruta">
                    <div class="tiempo">
                        <p title="salida" class="salida">06:15</p>
                        <p class="traso"><i class="fa-solid fa-caret-right"></i></p>
                        <p title="llegada" class="llegada">06:15</p>
                    </div>
                    <div class="nombre">
                        <div class="agencia">
                            <P><strong><i class="fa-solid fa-location-dot"></i></strong></P>
                            <P><strong>Forama</strong></P>
                        </div>
                        <div class="precio">
                            <p>3500 xaf</p>
                        </div>
                    </div>
                </div>
                <div class="ruta">
                    <div class="tiempo">
                        <p title="salida" class="salida">06:15</p>
                        <p class="traso"><i class="fa-solid fa-caret-right"></i></p>
                        <p title="llegada" class="llegada">06:15</p>
                    </div>
                    <div class="nombre">
                        <div class="agencia">
                            <P><strong><i class="fa-solid fa-location-dot"></i></strong></P>
                            <P><strong>Forama</strong></P>
                        </div>
                        <div class="precio">
                            <p>3500 xaf</p>
                        </div>
                    </div>
                </div>
                <div class="ruta">
                    <div class="tiempo">
                        <p title="salida" class="salida">06:15</p>
                        <p class="traso"><i class="fa-solid fa-caret-right"></i></p>
                        <p title="llegada" class="llegada">06:15</p>
                    </div>
                    <div class="nombre">
                        <div class="agencia">
                            <P><strong><i class="fa-solid fa-location-dot"></i></strong></P>
                            <P><strong>Forama</strong></P>
                        </div>
                        <div class="precio">
                            <p>3500 xaf</p>
                        </div>
                    </div>
                </div>
                <div class="ruta">
                    <div class="tiempo">
                        <p title="salida" class="salida">06:15</p>
                        <p class="traso"><i class="fa-solid fa-caret-right"></i></p>
                        <p title="llegada" class="llegada">06:15</p>
                    </div>
                    <div class="nombre">
                        <div class="agencia">
                            <P><strong><i class="fa-solid fa-location-dot"></i></strong></P>
                            <P><strong>Forama</strong></P>
                        </div>
                        <div class="precio">
                            <p>3500 xaf</p>
                        </div>
                    </div>
                </div>
                <div class="ruta">
                    <div class="tiempo">
                        <p title="salida" class="salida">06:15</p>
                        <p class="traso"><i class="fa-solid fa-caret-right"></i></p>
                        <p title="llegada" class="llegada">06:15</p>
                    </div>
                    <div class="nombre">
                        <div class="agencia">
                            <P><strong><i class="fa-solid fa-location-dot"></i></strong></P>
                            <P><strong>Forama</strong></P>
                        </div>
                        <div class="precio">
                            <p>3500 xaf</p>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="cards_container">
            <div class="rutas_card" id="rutas_card">
                <!-- <div class="container cardContainer">
                    <div class="card_head">
                        <div class="img"><img src="../../img/index/images.png" alt=""></div>
                        <div class="title">
                            <h5 id="agencia" value="Forama">Forama</h5>
                        </div>
                    </div> 
                    <div class="card_body">
                        <div class="icon"><i class="fa-solid fa-bus"></i></div>
                        <div class="horario">
                            <p id="ini" value="12:40">12:40</p>
                            <p><i class="fa-solid fa-caret-right"></i></p>
                            <p id="fin" value="16:50">16:50</p>
                        </div>
                        <div class="bus_num">
                            <p id="num_bus" value="N:07-BUS">
                                <strong>
                                    N:07-BUS
                                </strong>
                            </p>
                        </div>
                    </div>
                    <div class="card_footer">
                        <div class="statico">
                            <div class="precio">
                                <p value="3500">3500 xaf</p>
                            </div>
                            <div class="btnTicket">
                                <button class="boton" id="btn" data-id-boton="1">Reservar</button>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>

    </div>

    <div class="sobreNosotros mt-4 mb-2">
        <div title="Logo" class="img">
            <img src="../../img/index/Logo_viages.png" alt="">
        </div>
        <div class="text">
            <h1>Sobre <strong>Ndong Viajes</strong></h1>
            <p><small>Somos una empresa de transporte de pasajeros, que ofrece servicios de transporte de
                    pasajeros a nivel nacional e internacional, ofrecemos servicios de transporte de pasajeros
                    en bus, coche personal y taxi, ofrecemos servicios de transporte de pasajeros a nivel
                    nacional e internacional, ofrecemos servicios de transporte de pasajeros en bus, coche
                    personal y taxi, ofrecemos servicios de transporte de pasajeros a nivel nacional e
                    internacional, ofrecemos servicios de transporte de pasajeros en bus, coche personal y
                    taxi</small></p>
        </div>
        <div class="btnMasInfo">
            <div title="Logo" class="subLogo">
                <img src="../../img/index/Logo_viages.png" alt="">
            </div>
            <p>
                <small>
                    Aqui puedes encontrar mas informacion sobre nosotros, nuestros servicios y nuestras tarifas, puedes
                    contactarnos para mas informacion.
                </small>
            </p>
            <a href="" class="btn">Mas Informacion</a>
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
    <script src="../../controllers/js/rutas.js"></script>
</body>

</html>