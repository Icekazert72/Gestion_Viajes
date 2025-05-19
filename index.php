<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ndong Viajes</title>
    <link rel="stylesheet" href="views/css/all.min.css">
    <link rel="stylesheet" href="views/css/bootstrap.min.css">
    <link rel="stylesheet" href="views/css/fontawesome.min.css">
    <link rel="stylesheet" href="views/css/sweetalert2.css">
    <link rel="stylesheet" href="views/css/index.css">
    <link rel="shortcut icon" href="img/index/Logo_viages.png" type="image/x-icon">
</head>
<header id="header">
    <div class="logo">
        <div title="Logo" class="img_logo"><img src="img/index/Logo_viages.png" alt=""></div>
        <div class="logo_text">
            <h5 title="Texto del logo">Ndong Viajes</h5>
            <div class="hidenMenu" id="hidenmenu">
                <div class="list">
                    <div>
                        <h5>Gestion</h5>
                    </div>
                    <div title="inicio del sitio"><a href="#">Inicio</a></div>
                    <div title="viaja en todas partes"><a href="#">Turismo</a></div>
                    <div><a href="views/nosotros.eg/index.php" title="Acerca de nosotros">Nosotros</a></div>
                    <div><a href="views/agencias.eg/index.php" title="Sobre otras agencias">Agencias</a></div>
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
            <div><a href="#">Inicio</a></div>
            <div title="viaja en todas partes"><a href="views/turismo.eg/index.php">Turismo</a></div>
            <div> <a href="views/nosotros.eg/index.php">Nosotros</a></div>
            <div> <a href="views/agencias.eg/index.php">Agencias</a></div>
        </div>
        <div class="burgerButton" id="btn_mn"><i class="fa-solid fa-bars"></i></div>
        <div title="Registrate aqui" class="btn"><a href="views/login/index.php"><i class="fa-solid fa-user"></i></a></div>
        <div title="Cambiar el idioma aqui" class="idioma"><img src="img/index/bandera.png" alt=""></div>
    </div>
</header>

<body>

    <div class="slider">

        <div class="formDIreccion">
            <h4>¿Cuál es tu ruta?</h4>
            <form action="" method="post">

                <!-- Lugar de origen -->
                <div class="input-group mt-1">
                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                    <input title="Lugar donde te encuentras ahora" id="input_de" type="text" class="form-control" placeholder="De">
                </div>
                <div id="deSugerencia" class="sugerencias"></div>

                <!-- Lugar de destino -->
                <div class="input-group mt-1">
                    <span class="input-group-text"><i class="fas fa-location-arrow"></i></span>
                    <input title="Lugar donde quieres ir" type="text" id="input_a" class="form-control" placeholder="A">
                </div>
                <div id="aSugerencia" class="sugerencias"></div>

                <!-- Número de viajeros -->
                <div class="input-group mt-1">
                    <span class="input-group-text"><i class="fas fa-users"></i></span>
                    <input title="Cuántos van contigo?" type="number" id="input_viajeros" class="form-control" placeholder="Número de Viajeros">
                </div>

                <!-- Fecha del viaje -->
                <div class="input-group mt-1">
                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                    <input title="Fecha de tu viaje" id="input_fecha" type="datetime-local" class="form-control">
                </div>

                <!-- Botón de envío -->
                <div class="input-group mt-1">
                    <span class="input-group-text"><i class="fas fa-search-location"></i></span>
                    <button title="Pulsar para ver las rutas" type="submit" id="submit" class="form-control">Buscar</button>
                </div>

            </form>
        </div>


    </div>

    <main class="container mt-5">

        <div class="info">
            <div class="tab">
                <h5>Bus de Linea <i class="fa-solid fa-bus"></i></h5>
                <p><small>Reserva tu plaza de bus como siempre de manera mas comoda, segura, rapida y facil
                        para llegar atu hogar sano y comodo, con una sonrisa
                        tras viajar de manera accesible de la manera que elijas
                        <strong>Reserva</strong> ya tu boleto
                    </small></p>
            </div>
            <div class="tab">
                <h5>Agencias de Viajes <i class="fa-solid fa-bus"></i></h5>
                <p><small>
                        Descubre las mejores agencias de viajes en bus que te ofrecen rutas frecuentes, precios accesibles y un servicio confiable. Planifica tus desplazamientos con comodidad y seguridad, con opciones de reserva anticipada, atención personalizada y cobertura nacional e internacional.
                        <strong>Consulta</strong> nuestras agencias y elige la mejor opción para tu próximo destino.
                    </small></p>
            </div>

            <div class="tab">
                <h5>Reserva de Boleto <i class="fa-solid fa-ticket"></i></h5>
                <p><small>Reserva tu plaza de bus como siempre de manera mas comoda, segura, rapida y facil
                        para llegar atu hogar sano y comodo, con una sonrisa
                        tras viajar de manera accesible de la manera que elijas
                        <strong>Reserva</strong> ya tu boleto
                    </small></p>
            </div>
            <div class="tab">
                <h5>Ruta Compartida <i class="fa-solid fa-calendar"></i></h5>
                <p><small>
                        Disfruta de un viaje cómodo y organizado a través de nuestras rutas compartidas, con paradas estratégicas que permiten recoger y dejar pasajeros de forma eficiente. Durante el trayecto, contarás con acompañamiento y soporte, asegurando una experiencia segura y agradable de principio a fin.
                        <strong>Consulta</strong> los horarios y puntos de encuentro disponibles para planificar mejor tu recorrido.
                    </small></p>
            </div>

        </div>

        <div class="personal mt-5">
            <div class="cart">
                <div class="img">
                    <div class="text-img">
                        <h1>Empieza tu viaje con nosotros</h1>
                        <h3>Regístrate y descubre nuevas rutas</h3>
                        <h5>¿Aún no tienes cuenta? ¡Crea la tuya hoy!</h5>
                    </div>
                </div>
                <div class="text">
                    <h4>Crea tu Cuenta</h4>
                    <p><small>
                            Únete a nuestra comunidad y disfruta de una experiencia de viaje más rápida, segura y personalizada. Al crear tu cuenta podrás gestionar tus reservas, recibir notificaciones importantes, acceder a promociones exclusivas y guardar tus rutas favoritas.
                            Todo en un solo lugar, fácil de usar y completamente gratuito. <strong>Empieza hoy</strong> y haz que cada viaje sea más simple y cómodo.
                        </small></p>
                    <a href="views/login/index.php">Crear mi cuenta</a>
                </div>
            </div>
        </div>

        <div class="sobreNosotros mt-4 mb-2">
            <div title="Logo" class="img">
                <img src="img/index/Logo_viages.png" alt="">
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
                    <img src="img/index/Logo_viages.png" alt="">
                </div>
                <p>
                    <small>
                        Aqui puedes encontrar mas informacion sobre nosotros, nuestros servicios y nuestras tarifas, puedes
                        contactarnos para mas informacion.
                    </small>
                </p>
                <a href="views/nosotros.eg/index.php" class="btn">Mas Informacion</a>
            </div>
        </div>

        <div class="rutasFrecuentes mt-1 mb-3">
            <h1>Rutas de Bus mas Frecuentes</h1>
            <div class="rutas">
                <div title="Ruta de viaje" class="ruta ruta1">
                    <div class="direcciones">
                        <div>
                            <h5>Bata</h5>
                        </div>
                        <div>
                            <h5><i class="fa-solid fa-angle-right"></i></h5>
                        </div>
                        <div>
                            <h5>OYALA </h5>
                        </div>
                        <div>
                            <h5><i class="fa-solid fa-bus-simple"></i></h5>
                        </div>
                    </div>
                    <p><small>Ruta 1</small></p>
                </div>
                <div title="Ruta de viaje" class="ruta ruta2">
                    <div class="direcciones">
                        <div>
                            <h5>bata</h5>
                        </div>
                        <div>
                            <h5><i class="fa-solid fa-angle-right"></i></h5>
                        </div>
                        <div>
                            <h5>Niefang </h5>
                        </div>
                        <div>
                            <h5><i class="fa-solid fa-bus-simple"></i></h5>
                        </div>
                    </div>
                    <p><small>Ruta 2</small></p>
                </div>
                <div title="Ruta de viaje" class="ruta ruta3">
                    <div class="direcciones">
                        <div>
                            <h5>bata</h5>
                        </div>
                        <div>
                            <h5><i class="fa-solid fa-angle-right"></i></h5>
                        </div>
                        <div>
                            <h5>Niefang </h5>
                        </div>
                        <div>
                            <h5><i class="fa-solid fa-bus-simple"></i></h5>
                        </div>
                    </div>
                    <p><small>Ruta 3</small></p>
                </div>
                <div title="Ruta de viaje" class="ruta ruta4">
                    <div class="direcciones">
                        <div>
                            <h5>bata</h5>
                        </div>
                        <div>
                            <h5><i class="fa-solid fa-angle-right"></i></h5>
                        </div>
                        <div>
                            <h5>Niefang </h5>
                        </div>
                        <div>
                            <h5><i class="fa-solid fa-bus-simple"></i></h5>
                        </div>
                    </div>
                    <p><small>Ruta 4</small></p>
                </div>
            </div>
        </div>

        <div class="rutasPopulares mt-4">
            <h1>Las Rutas Mas Populares Por estacion</h1>
            <div class="carts">
                <div class="cart">
                    <div class="img_ciudadDestino">
                        <img src="" alt="">
                    </div>
                    <div class="direcciones">
                        <a href="#">
                            <div class="dir">
                                <div>
                                    <h5>Bata</h5>
                                </div>
                                <div>
                                    <h5><i class="fa-solid fa-angle-right"></i></h5>
                                </div>
                                <div>
                                    <h5>OYALA </h5>
                                </div>
                                <div>
                                    <h5><i class="fa-solid fa-bus-simple"></i></h5>
                                </div>
                            </div>
                            <div class="ticket">
                                <div class="precio">
                                    <h5>3500 <small>XAF</small></h5>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="puntos">
                        <div>
                            <p><small>A Oyala desde</small></p>
                        </div>
                        <div class="py">
                            <a href="#">
                                <div class="punto">
                                    <h5>Bata</h5>
                                </div>
                                <div class="precio">
                                    <h5>3500 <small>XAF</small></h5>
                                </div>
                            </a>
                        </div>
                        <div class="py">
                            <a href="#">
                                <div class="punto">
                                    <h5>Mongomo</h5>
                                </div>
                                <div class="precio">
                                    <h5>4000 <small>XAF</small></h5>
                                </div>
                            </a>
                        </div>
                        <div class="py">
                            <a href="#">
                                <div class="punto">
                                    <h5>Niefang</h5>
                                </div>
                                <div class="precio">
                                    <h5>3000 <small>XAF</small></h5>
                                </div>
                            </a>
                        </div>
                        <div class="py">
                            <a href="#">
                                <div class="punto">
                                    <h5>Cogo</h5>
                                </div>
                                <div class="precio">
                                    <h5>3500 <small>XAF</small></h5>
                                </div>
                            </a>
                        </div>
                        <div class="py">
                            <a href="#">
                                <div class="punto">
                                    <h5>Mongomo</h5>
                                </div>
                                <div class="precio">
                                    <h5>1500 <small>XAF</small></h5>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="cart">
                    <div class="img_ciudadDestino">
                        <img src="" alt="">
                    </div>
                    <div class="direcciones">
                        <a href="#">
                            <div class="dir">
                                <div>
                                    <h5>Bata</h5>
                                </div>
                                <div>
                                    <h5><i class="fa-solid fa-angle-right"></i></h5>
                                </div>
                                <div>
                                    <h5>OYALA </h5>
                                </div>
                                <div>
                                    <h5><i class="fa-solid fa-bus-simple"></i></h5>
                                </div>
                            </div>
                            <div class="ticket">
                                <div class="precio">
                                    <h5>3500 <small>XAF</small></h5>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="puntos">
                        <div>
                            <p><small>A Oyala desde</small></p>
                        </div>
                        <div class="py">
                            <a href="#">
                                <div class="punto">
                                    <h5>Bata</h5>
                                </div>
                                <div class="precio">
                                    <h5>3500 <small>XAF</small></h5>
                                </div>
                            </a>
                        </div>
                        <div class="py">
                            <a href="#">
                                <div class="punto">
                                    <h5>Mongomo</h5>
                                </div>
                                <div class="precio">
                                    <h5>4000 <small>XAF</small></h5>
                                </div>
                            </a>
                        </div>
                        <div class="py">
                            <a href="#">
                                <div class="punto">
                                    <h5>Niefang</h5>
                                </div>
                                <div class="precio">
                                    <h5>3000 <small>XAF</small></h5>
                                </div>
                            </a>
                        </div>
                        <div class="py">
                            <a href="#">
                                <div class="punto">
                                    <h5>Cogo</h5>
                                </div>
                                <div class="precio">
                                    <h5>3500 <small>XAF</small></h5>
                                </div>
                            </a>
                        </div>
                        <div class="py">
                            <a href="#">
                                <div class="punto">
                                    <h5>Mongomo</h5>
                                </div>
                                <div class="precio">
                                    <h5>1500 <small>XAF</small></h5>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="cart">
                    <div class="img_ciudadDestino">
                        <img src="" alt="">
                    </div>
                    <div class="direcciones">
                        <a href="#">
                            <div class="dir">
                                <div>
                                    <h5>Bata</h5>
                                </div>
                                <div>
                                    <h5><i class="fa-solid fa-angle-right"></i></h5>
                                </div>
                                <div>
                                    <h5>OYALA </h5>
                                </div>
                                <div>
                                    <h5><i class="fa-solid fa-bus-simple"></i></h5>
                                </div>
                            </div>
                            <div class="ticket">
                                <div class="precio">
                                    <h5>3500 <small>XAF</small></h5>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="puntos">
                        <div>
                            <p><small>A Oyala desde</small></p>
                        </div>
                        <div class="py">
                            <a href="#">
                                <div class="punto">
                                    <h5>Bata</h5>
                                </div>
                                <div class="precio">
                                    <h5>3500 <small>XAF</small></h5>
                                </div>
                            </a>
                        </div>
                        <div class="py">
                            <a href="#">
                                <div class="punto">
                                    <h5>Mongomo</h5>
                                </div>
                                <div class="precio">
                                    <h5>4000 <small>XAF</small></h5>
                                </div>
                            </a>
                        </div>
                        <div class="py">
                            <a href="#">
                                <div class="punto">
                                    <h5>Niefang</h5>
                                </div>
                                <div class="precio">
                                    <h5>3000 <small>XAF</small></h5>
                                </div>
                            </a>
                        </div>
                        <div class="py">
                            <a href="#">
                                <div class="punto">
                                    <h5>Cogo</h5>
                                </div>
                                <div class="precio">
                                    <h5>3500 <small>XAF</small></h5>
                                </div>
                            </a>
                        </div>
                        <div class="py">
                            <a href="#">
                                <div class="punto">
                                    <h5>Mongomo</h5>
                                </div>
                                <div class="precio">
                                    <h5>1500 <small>XAF</small></h5>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="smsSeguridad container mb-3">
            <div class="sms">
                <h1>Viaja Seguro</h1>
                <p><small>Viaja seguro con nosotros, ofrecemos servicios de transporte de pasajeros a nivel
                        nacional e internacional, ofrecemos servicios de transporte de pasajeros en bus, coche
                        personal y taxi, ofrecemos servicios de transporte de pasajeros a nivel nacional e
                        internacional, ofrecemos servicios de transporte de pasajeros en bus, coche personal y
                        taxi</small></p>
            </div>
            <div class="img_sms">
                <div class="img">
                    <div class="iconos">
                        <i class="fa-solid fa-shield-halved"></i>
                        <i class="fa-solid fa-shield-halved"></i>
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <h5>Viaja Seguro con NDONG VIAJES</h5>
                </div>
            </div>
        </div>

    </main>


    <footer>
        <div class="footer-container">


            <div class="footer-column">
                <h3>Ndong Viajes</h3>
                <p>Tu mejor elección para viajar por carretera con comodidad, seguridad y puntualidad.</p>
                <img src="img/index/Logo_viages.png" alt="">
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

    <script src="controllers/js/bootstrap.min.js"></script>
    <script src="controllers/js/sweetalert2.js"></script>
    <script src="controllers/js/botones.js"></script>
    <script src="controllers/js/lgi.js"></script>
    <script src="controllers/js/buscador.js"></script>
</body>

</html>