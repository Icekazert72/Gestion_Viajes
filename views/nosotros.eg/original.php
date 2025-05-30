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
                        <div><a href="#" title="Acerca de nosotros">Nosotros</a></div>
                        <div><a href="../agencias.eg/index.php" title="Sobre otras agencias">Agencias</a></div>
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
                <div> <a href="#">Nosotros</a></div>
                <div> <a href="#">Agencias</a></div>
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

    <div class="slider_us_content">
        <div class="text">
            <div class="title">
                <h1>Conocenos</h1>
            </div>
            <div class="text">
                <p>
                    Somos una empresa dedicada a brindar servicios de transporte de larga distancia, ofreciendo
                    comodidad y seguridad a nuestros pasajeros. Contamos con una flota moderna y un equipo de
                    profesionales altamente capacitados para garantizar una experiencia de viaje inolvidable.
                </p>
            </div>
        </div>
        <div class="img">
            <div class="img_logo">
                <img src="../../img/index/Logo_viages.png" alt="">
            </div>
        </div>
    </div>

    <main>

        <!-- Inicio -->
        <section id="inicio" class="hero">
            <div class="container">
                <h2>Viaja cómodo, seguro y a tiempo</h2>
                <p>Conectamos destinos en Guinea Ecuatorial con buses modernos, atención profesional y tarifas justas.</p>
                <a href="#reservas" class="btn">Reserva tu viaje</a>
            </div>
        </section>

        <!-- Nosotros -->
        <section id="nosotros" class="container section">
            <h2>¿Quiénes somos?</h2>
            <p>
                Ndong_viajes es una empresa de transporte terrestre especializada en viajes en autobús. Nuestra misión es ofrecer un servicio de calidad, puntualidad y seguridad a cada pasajero. Con años de experiencia, contamos con una flota moderna, personal capacitado y cobertura nacional.
            </p>
        </section>

        <!-- Rutas -->
        <section id="rutas" class="container section">
            <h2>Rutas frecuentes</h2>
            <div class="rutas-grid">
                <div class="ruta-card">
                    <h3>Malabo – Bata</h3>
                    <p>4h • Salida: 08:00 y 16:00 • Lunes a Sábado</p>
                </div>
                <div class="ruta-card">
                    <h3>Bata – Evinayong</h3>
                    <p>2h 30min • Salida: 10:00 • Todos los días</p>
                </div>
                <div class="ruta-card">
                    <h3>Malabo – Luba</h3>
                    <p>1h 30min • Salida: 07:00, 12:00 y 17:00</p>
                </div>
                <div class="ruta-card">
                    <h3>Bata – Mongomo</h3>
                    <p>5h • Salida: 06:00 • Viernes a Domingo</p>
                </div>
            </div>
        </section>

        <!-- Servicios -->
        <section id="servicios" class="container section">
            <h2>Servicios ofrecidos</h2>
            <ul>
                <li>Venta online de billetes</li>
                <li>Viajes turísticos personalizados</li>
                <li>Transporte de paquetes y documentos</li>
                <li>Flota equipada con Wi-Fi y aire acondicionado</li>
                <li>Alquiler privado de buses para empresas</li>
            </ul>
        </section>

        <!-- Reservas -->
        <section id="reservas" class="container section">
            <h2>Reservas</h2>
            <p>Para reservar tu viaje, completa el siguiente formulario o contáctanos directamente.</p>
            <form>
                <label>Nombre completo:<br><input type="text" required></label><br>
                <label>Email:<br><input type="email" required></label><br>
                <label>Ruta deseada:<br>
                    <select required>
                        <option>Malabo – Bata</option>
                        <option>Bata – Evinayong</option>
                        <option>Malabo – Luba</option>
                        <option>Bata – Mongomo</option>
                    </select>
                </label><br>
                <label>Fecha del viaje:<br><input type="date" required></label><br>
                <button type="submit">Enviar reserva</button>
            </form>
        </section>

        <!-- Preguntas Frecuentes -->
        <section id="faq" class="container section">
            <h2>Preguntas frecuentes</h2>
            <details>
                <summary>¿Puedo cancelar o cambiar una reserva?</summary>
                <p>Sí, hasta 24 horas antes de la salida. Contacta al soporte.</p>
            </details>
            <details>
                <summary>¿Puedo llevar equipaje extra?</summary>
                <p>Se permite hasta 20kg gratis. El exceso tiene un costo adicional.</p>
            </details>
            <details>
                <summary>¿Los buses tienen baño?</summary>
                <p>Algunas unidades lo incluyen. Confirma al reservar.</p>
            </details>
        </section>

        <!-- Testimonios -->
        <section id="testimonios" class="container section">
            <h2>Lo que dicen nuestros clientes</h2>
            <blockquote>
                “Excelente servicio, puntual y muy cómodo. ¡Viajar con Ndong_viajes fue una gran experiencia!” – Ana, Malabo
            </blockquote>
            <blockquote>
                “Reservé online sin problema. El bus salió a tiempo y el personal fue muy amable.” – José, Bata
            </blockquote>
        </section>

        <!-- Contacto -->
        <section id="contacto" class="container section">
            <h2>Contacto</h2>
            <p><strong>Dirección:</strong> Av. Central 123, Malabo, Guinea Ecuatorial</p>
            <p><strong>Teléfono:</strong> +240 555 123 456</p>
            <p><strong>Email:</strong> contacto@ndongviajes.com</p>
            <iframe src="https://maps.google.com/maps?q=malabo&t=&z=13&ie=UTF8&iwloc=&output=embed" allowfullscreen loading="lazy"></iframe>
        </section>

    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; 2025 Ndong_viajes. Todos los derechos reservados.</p>
            <div class="redes">
                <a href="#">Facebook</a> | <a href="#">Instagram</a> | <a href="#">WhatsApp</a>
            </div>
        </div>
    </footer>

    <script src="../../controllers/js/bootstrap.min.js"></script>
    <script src="../../controllers/js/botones.js"></script>
    <script src="../../controllers/js/sweetalert2.js"></script>
</body>

</html>