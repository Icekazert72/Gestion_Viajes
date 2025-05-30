<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="views/css/all.min.css">
    <link rel="stylesheet" href="views/css/bootstrap.min.css">
    <link rel="stylesheet" href="views/css/fontawesome.min.css">
    <link rel="stylesheet" href="views/css/sweetalert2.css">
    <link rel="stylesheet" href="./s.css">
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
            <div><a href="#" class="active">Inicio</a></div>
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
<section class="banner">
  <h1>Turismo en Guinea Ecuatorial</h1>
  <p>Descubre los tesoros naturales y culturales de Guinea Ecuatorial. Explora paisajes exuberantes, vibrante historia y tradiciones únicas con experiencias diseñadas para viajeros curiosos y amantes de la autenticidad.</p>
</section>
<!--caja tour -->
<section class="caja2">
    <div class="tour-box">
  <div class="tour-text">
    <img src="../../img/index/Logo_viages.png" alt="" id="logo_viaje">
    <h2>Viaja en grupo, vive más</h2>
    <p>Descubre Guinea Ecuatorial con nuestras rutas en bus turístico. Conecta con otras personas, disfruta de paisajes impresionantes, cultura vibrante y la comodidad de un transporte confiable en cada rincón del país.</p>
    <p>Deja que una guía contextual conecte tus intereses en arte, gastronomía, historia o arquitectura con las historias menos conocidas que la mayoría de los viajeros desconocen. Transforma tu viaje de una simple lista de visitas turísticas en un momento verdaderamente emocionante de descubrimiento y conexión. ¿</p>
    <p>Listo para crear recuerdos inolvidables?</p>
  </div>
  <div class="tour-image" style="background-image: url('../../img/index/turismobuss.jpeg');">
    <!-- Imagen de turistas en bus -->
  </div>
</div>
</section>

<!--carusel destinos destacados-->

<!-- Caja de título y descripción -->
<section class="destinos-header">
  <h2>Destinos destacados</h2>
  <p>
    Explora los rincones más emblemáticos de Guinea Ecuatorial. Desde islas paradisíacas hasta parques nacionales y cultura ancestral, descubre destinos únicos que te sorprenderán.
  </p>
</section>
<div class="carousel-container">
  <div class="carousel-track" id="carouselTrack">
    <!-- Card 1 -->
    <div class="card">
      <img src="../../img/index/biokoturismo.jpeg" alt="Malabo">
      <h3>Malabo Colonial</h3>
    </div>
    <!-- Card 2 -->
    <div class="card">
      <img src="../../img/index/alenturismo.jpeg" alt="Monte Alen">
      <h3>Parque Monte Alén</h3>
    </div>
    <!-- Card 3 -->
    <div class="card">
      <img src="../../img/index/coriscoturismo.JPG" alt="Corisco">
      <h3>Isla de Corisco</h3>
    </div>
    <!-- Card 4 -->
    <div class="card">
      <img src="../../img/index/biokoturismo.jpeg" alt="Bioko">
      <h3>Isla de Bioko</h3>
    </div>
    <!-- Card 5 -->
    <div class="card">
      <img src="../../img/index/baileturismo (4).jpeg" alt="Fang Cultura">
      <h3>Cultura Fang</h3>
    </div>
  </div>

  <!-- Botones -->
  <div class="carousel-buttons" style="margin-bottom: 20rem;">
    <button onclick="moveCarousel(-1)" ><</button>
    <button onclick="moveCarousel(1)">></button>
  </div>
</div>

<!-- cajas region insular y continental -->

 <!-- Caja de título y descripción -->
<div class="fondo">
    <section class="destinos-header2">
  <h2> 🗺️ Destinos y experiencias</h2>
  <p>¿A dónde puedo ir?</p>
  <p>
    Te ofrecemos los mejores lugares de destinos bien organizados, experiencias destacadas que no vas a olvidar porque no solo son destinos si no una conexion directa con la naturaleza.
  </p>
</section>

 <section class="regiones-container">

  <div class="region region-insular">
    <h3 class="region-title">Región Insular</h3>
    <div class="card weird-shape rotate-left">
      <div class="image-container">
        <img src="../../img/index/arenablanca.jpeg" alt="Isla de Bioko">
        <div class="overlay">La Isla de Bioko, con su arena blanca natural y playa volcánica, es un paraíso natural en el golfo de Guinea.</div>
      </div>
      <h4>Arena Blanca</h4>
    </div>
    <div class="card weird-shape tilt-top">
      <div class="image-container">
        <img src="../../img/index/monoturismo.jpg" alt="Corisco">
        <div class="overlay">En la isla de bioko en el corazon de malabo se encuentra los mejores primates.</div>
      </div>
      <h4>Moka</h4>
    </div>
  </div>

  <div class="divider"></div>

  <div class="region region-continental">
    <h3 class="region-title">Región Continental</h3>
    <div class="card weird-shape rotate-right">
      <div class="image-container">
        <img src="../../img/index/puntambondaturismo.jpeg" alt="Monte Alén">
        <div class="overlay">En bata se encuentra una de los poblados mas preciosos de africa con su playa hermosa.</div>
      </div>
      <h4>Punta Mbonda</h4>
    </div>
    <div class="card weird-shape tilt-bottom">
      <div class="image-container">
        <img src="../../img/index/baileturismo (4).jpeg" alt="Cultura Fang">
        <div class="overlay">La región continental refleja la cultura Fang, rica en tradiciones, máscaras y ceremonias ancestrales.</div>
      </div>
      <h4>Cultura Fang</h4>
    </div>
  </div>

</section>
</div>

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
<script src="../js/turismo.js"></script>
</body>
</html>