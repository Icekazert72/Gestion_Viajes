<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sobre Nosotros - Ndong Viajes</title>
    <link rel="stylesheet" href="../css/all.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/fontawesome.min.css">
    <link rel="stylesheet" href="../css/nosotrosprueba.css">
</head>
<body>

  <!-- Cabecera y navegación -->
  <!-- <header>
    <nav>
      <ul>
        <li><a href="../../index.php">Inicio</a></li>
        <li><a href="sobre-nosotros.html">Nosotros</a></li>
        <li><a href="../agencias.eg/index.php">Agencias</a></li>
        <li>
          <a href="#">Servicios</a>
          <ul>
            <li><a href="#">VBD</a></li>
            <li><a href="#">STLD</a></li>
          </ul>
        </li>
      </ul>
    </nav>
  </header> -->
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

  <!-- Sección Sobre Nosotros -->
  <section id="sobre-nosotros">
    <div>
      <h2>Conócenos</h2>
      <p>En <strong>Ndong Viajes</strong> llevamos más de 10 años conectando comunidades en Guinea Ecuatorial con nuestros servicios de transporte terrestre de larga distancia. Nacimos con la visión de ofrecer un viaje seguro, puntual y accesible, apoyándonos en tecnología de punta y un equipo humano apasionado.</p>
      <p>Desde nuestros inicios, hemos transportado a más de <strong>200,000 pasajeros</strong> a lo largo de rutas clave como Malabo–Bata, Bata–Evinayong y Malabo–Luba. Nuestra flota moderna cuenta con buses equipados con Wi-Fi, aire acondicionado y sistemas de seguridad avanzados. Cada unidad se somete a revisiones periódicas y nuestros conductores reciben formación constante para garantizar tu máxima tranquilidad.</p>
      <p>A lo largo de los años, hemos ampliado nuestra cobertura y servicios, incorporando reserva online en tiempo real, pasajes electrónicos y atención 24/7 a través de canales digitales. Además, colaboramos con operadores turísticos locales para ofrecer experiencias completas: paquetes de viaje, alojamientos y excursiones en cada destino.</p>
      <div>
        <h3>Misión</h3>
        <p>Brindar experiencias de viaje inolvidables, seguras y asequibles para todos.</p>
      </div>
      <div>
        <h3>Visión</h3>
        <p>Ser la empresa líder en transporte por carretera en la región Centroafricana, innovando cada día.</p>
      </div>
      <div>
        <h3>Valores</h3>
        <p>Seguridad, honestidad, sostenibilidad, innovación y servicio al cliente.</p>
      </div>
      <p>Nuestro compromiso con la sostenibilidad nos impulsa a optimizar rutas, reducir emisiones y apostar por energías limpias. Pronto incorporaremos buses híbridos y programas de compensación de carbono.</p>
    </div>

    <!-- Imagen representativa -->
    <div>
      <img src="../../img/index/buses.webp" alt="Nuestro equipo de trabajo">
    </div>
  </section>

  <!-- Pie de página -->
  <footer>
    <p>&copy; 2025 Ndong Viajes. Todos los derechos reservados.</p>
  </footer>
    <script src="../../controllers/js/bootstrap.min.js"></script>
    <script src="../../controllers/js/botones.js"></script>
    <script src="../../controllers/js/sweetalert2.js"></script>
</body>
</html>
