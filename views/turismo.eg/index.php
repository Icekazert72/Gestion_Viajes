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
    <title>Turismo</title>
    <link rel="stylesheet" href="../css/all.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/fontawesome.min.css">
    <link rel="stylesheet" href="../css/sweetalert2.css">
    <link rel="stylesheet" href="../css/windows4.css">
    <link rel="shortcut icon" href="../../img/index/Logo_viages.png" type="image/x-icon">
</head>
<header id="header">
    <div class="logo">
        <div title="Logo" class="img_logo">
            <img src="img/index/Logo_viages.png" alt="">
        </div>
        <div class="logo_text">
            <h5 title="Texto del logo">Ndong Viajes</h5>
            <div class="hidenMenu" id="hidenmenu">
                <div class="list">
                    <div>
                        <h5>Gestión</h5>
                    </div>
                    <div><a href="#">Inicio</a></div>
                    <div><a href="#">Turismo</a></div>
                    <div><a href="../nosotros.eg/index.php">Nosotros</a></div>
                    <div><a href="../agencias.eg/index.php">Agencias</a></div>
                    <?php if (isset($_SESSION['usuario']) && $_SESSION['tipo'] === 'usuario'): ?>
                        <!-- Botón de panel de usuario -->
                        <div title="Mis reservas" class="btnPanel">
                            <a href="views/usuario/panel.php" style="color: orange;"><i class="fa-solid fa-calendar-check"></i></a>
                        </div>
                        <!-- Botón de cerrar sesión -->
                        <div title="Cerrar sesión" class="btnSesion">
                            <a href="../login/logout.php" style="color: red;"><i class="fa-solid fa-right-from-bracket"></i></a>
                        </div>
                    <?php else: ?>
                        <!-- Botón de iniciar sesión -->
                        <div title="Iniciar sesión" class="btn">
                            <a href="../login/index.php"><i class="fa-solid fa-user"></i></a>
                        </div>
                    <?php endif; ?>
                    <style>
                        .btnSesion:hover {
                            background-color: red;
                            color: white;

                            a {
                                background-color: red;
                                color: white;
                            }
                        }

                        .btnPanel:hover {
                            background-color: orange;
                            color: white;
                            a {
                                background-color: orange;
                                color: white;
                            }
                        }
                    </style>
                </div>
            </div>
        </div>
    </div>

    <div class="nav">
        <div class="nav_navegar">
            <div><a href="#" class="active">Inicio</a></div>
            <div><a href="views/turismo.eg/index.php">Turismo</a></div>
            <div><a href="views/nosotros.eg/index.php">Nosotros</a></div>
            <div><a href="views/agencias.eg/index.php">Agencias</a></div>
            <?php if (isset($_SESSION['usuario']) && $_SESSION['tipo'] === 'usuario'): ?>
                <!-- Botón de panel de usuario -->
                <div title="Mis reservas" class="btnPanel">
                    <a href="../usuario/panel.php" style="color: orange;"><i class="fa-solid fa-calendar-check"></i></a>
                </div>
                <!-- Botón de cerrar sesión -->
                <div title="Cerrar sesión" class="btnSesion">
                    <a href="../login/logout.php" style="color: red;"><i class="fa-solid fa-right-from-bracket"></i></a>
                </div>
            <?php else: ?>
                <!-- Botón de iniciar sesión -->
                <div title="Iniciar sesión" class="btn">
                    <a href=../login/index.php"><i class="fa-solid fa-user"></i></a>
                </div>
            <?php endif; ?>
        </div>

        <div class="burgerButton" id="btn_mn">
            <i class="fa-solid fa-bars"></i>
        </div>

        <div title="Cambiar el idioma aquí" class="idioma">
            <img src="img/index/bandera.png" alt="">
        </div>
    </div>
</header>
<body>

<!-- buscador y modal -->
  <!-- banner -->
  <div class="baner_carrusel">
  <div class="baner_principal">
    <h1>¿A dónde quieres ir?</h1>
    <div class="buscador">
      <input type="text" id="entrada-buscador" placeholder="Buscar destino turístico...">
      <div class="icono">
        <svg aria-hidden="true" data-prefix="fas" data-icon="search" role="img"
          xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
          class="svg-inline--fa fa-search fa-w-16 fa-7x">
          <path fill="currentColor"
            d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z">
          </path>
        </svg>
      </div>
    </div>

    <div class="botones-menu">
      <button class="boton-menu activo" data-destino="restaurante"><i class="fas fa-utensils"></i> Restaurante</button>
      <button class="boton-menu" data-destino="cultura"><i class="fas fa-landmark"></i> Cultura</button>
      <button class="boton-menu" data-destino="naturaleza"><i class="fa-solid fa-hotel"></i> Hoteles</button>
      <button class="boton-menu" data-destino="cosas"><i class="fas fa-running"></i> Cosas que hacer</button>
    </div>
  </div>
</div>

<!--boton 1 restaurantes -->
<div id="restaurante" class="seccion-contenido activa">
  <section><h1 class="text-center textoPrincipal">Viaje y gastronomía en perfecta armonía: disfrute de un restaurante excepcional.</h1></section>
  <div class="contenedor-cajas">
    <div class="caja" data-detalle="Ubicado en el corazón del Hotel Djibloho, ">
      <img src="../../img/index/turismo-djibloho.jpg" alt="">
      <div class="contenido">
        <h4>Restaurante del Hotel Djibloho (Oyala)</h4>
        <p>Alta cocina en un entorno de lujo y confort.</p>
        <a href=""><button class="btn-mas-info">Más info</button></a>
      </div>
    </div>
    <div class="caja">
      <img src="../../img/index/turismo-ferme.jpg" alt="">
      <div class="contenido">
        <h4>Restaurante La Ferme (Bata)</h4>
        <p>Cocina de calidad en un ambiente natural y relajante en Bata.</p>
        <a href=""><button class="btn-mas-info">Más info</button></a>
      </div>
    </div>
    <div class="caja">
      <img src="../../img/index/turismo-ntem.jpg" alt="">
      <div class="contenido">
        <h4>Restaurante Ntem</h4>
        <p>Cocina tradicional ecuatoguineana junto al río.</p>
        <a href=""><button class="btn-mas-info">Más info</button></a>
      </div>
    </div>
    <div class="caja">
      <img src="../../img/index/turismo-mongomo.jpg" alt="">
      <div class="contenido">
        <h4>Restaurante El Bosque (Mongomo)</h4>
        <p>Comida tradicional en un ambiente natural y fresco.</p>
        <a href=""><button class="btn-mas-info">Más info</button></a>
      </div>
    </div>
    <div class="caja">
      <img src="../../img/index/turismo-libertad.jpeg" alt="">
      <div class="contenido">
        <h4> La Torre de la Libertad (Bata)</h4>
        <p>Restaurante giratorio con vistas panorámicas de Bata.</p>
        <a href=""><button class="btn-mas-info">Más info</button></a>
      </div>
    </div>
    <div class="caja">
      <img src="../../img/index/turismo-anisok.jpeg" alt="">
      <div class="contenido">
        <h4>Mercado Gastronómico (Añisok)</h4>
        <p>Mercado de alimentos frescos y locales</p>
        <a href=""><button class="btn-mas-info">Más info</button></a>
      </div>
    </div>
    <div class="caja">
      <img src="../../img/index/turismo-manila.jpg" alt="">
      <div class="contenido">
        <h4>Restaurante Manila (Bata)</h4>
        <p>Ubicado en el Paseo Marítimo de Bata, el Restaurante Manila ofrece una experiencia gastronómica única con vistas al mar, cocina internacional y ambiente moderno.</p>
        <a href=""><button class="btn-mas-info">Más info</button></a>
      </div>
    </div>
    <div class="caja">
      <img src="../../img/index/turismo-mongomo2.webp" alt="">
      <div class="contenido">
        <h4>Terraza Mongomo</h4>
        <p>Moderno y acogedor, con hermosas vistas de la ciudad.</p>
        <a href=""><button class="btn-mas-info">Más info</button></a>
      </div>
    </div>
  </div>

  <!-- seccion de comidas del restaurantes-->
  <section class="lo-que-debes-probar">
  <h2>Lo que debes probar</h2>
  <p>Sabores tradicionales de la región continental: Bata, Mongomo, Añisok, Ebibeyin y Oyala.</p>
  <div class="galeria-platos">
    <a href="platos/pepper-soup.html" class="plato">
      <img src="../../img/index/turismo-pepesoup.png" alt="Pepper Soup">
      <h3>Pepper Soup</h3>
      <p>Sopa picante típica, reconfortante y sabrosa.</p>
    </a>
    <a href="platos/platano-maduro.html" class="plato">
      <img src="../../img/index/turismo-frito.jpg" alt="Plátano Maduro">
      <h3>Plátano Maduro</h3>
      <p>Dulce y dorado, perfecto como acompañamiento o postre.</p>
    </a>
    <a href="platos/bambucha.html" class="plato">
      <img src="../../img/index/turismo-bambucha.jpg" alt="Bambucha">
      <h3>Bambucha</h3>
      <p>Fermentado local hecho a base de maíz o plátano.</p>
    </a>
    <a href="platos/salsa-cacahuete.html" class="plato">
      <img src="../../img/index/turismo-cacahuete.jpg" alt="Salsa de Cacahuete">
      <h3>Salsa de Cacahuete</h3>
      <p>Espesa, nutritiva y llena de sabor africano auténtico.</p>
    </a>
    <a href="platos/bunuelos-banana.html" class="plato">
      <img src="../../img/index/turismo-bunuelos.jpg" alt="Buñuelos de Banana">
      <h3>Buñuelos de Banana</h3>
      <p>Deliciosos y crujientes bocados dulces.</p>
    </a>
    <a href="platos/yuca.html" class="plato">
      <img src="../../img/index/turismo-yuca.jpg" alt="Yuca cocida">
      <h3>Yuca</h3>
      <p>Tubérculo esencial, hervido o frito, lleno de energía.</p>
    </a>
    <!-- <a href="platos/caracoles.html" class="plato">
      <img src="../../img/index/turismo-caracol.jpg" alt="Caracoles en salsa">
      <h3>Caracoles</h3>
      <p>Un manjar tradicional muy apreciado por los locales.</p>
    </a> -->
  </div>
</section>

  
<!--carusel del restaurante: destinos destacados-->

<!-- Caja de título y descripción -->
<section class="destinos-header">
  <h2>Restaurantes destacados</h2>
  <p>
    Explora los restaurantes más emblemáticos. Desde restaurantes lujosos hasta restaurantes con temas naturales y tradicionales, descubre restaurantes únicos en tu ruta que te sorprenderán.
  </p>
</section>
<div class="carousel-container">
  <div class="carousel-track" id="carouselTrack">
    <!-- Card 1 -->
    <div class="card">
      <img src="../../img/index/turismo-ferme.jpg" alt="Bata">
      <h3>Restaurante La Ferme </h3>
    </div>
    <!-- Card 2 -->
    <div class="card">
      <img src="../../img/index/turismo-libertad.jpeg" alt="Bata">
      <h3> Restaurante La Torre de la Libertad </h3>
    </div>
    <!-- Card 3 -->
    <div class="card">
      <img src="../../img/index/turismo-manila.jpg" alt="Bata">
      <h3>Restaurante Manila </h3>
    </div>
    <!-- Card 4 -->
    <div class="card">
      <img src="../../img/index/turismo-djibloho.jpg" alt="Bata">
      <h3>Restaurante del Hotel Djibloho</h3>
    </div>
    <!-- Card 5 -->
    <div class="card">
      <img src="../../img/index/turismo-ibis.webp" alt="Bata">
      <h3>Restaurante del Hotel Ibis</h3>
    </div>
     <div class="card">
      <img src="../../img/index/turismo-manila.jpg" alt="Bata">
      <h3>Restaurante Manila </h3>
    </div>
    <!-- Card 4 -->
    <div class="card">
      <img src="../../img/index/turismo-djibloho.jpg" alt="Bata">
      <h3>Restaurante del Hotel Djibloho</h3>
    </div>
    <!-- Card 5 -->
    <div class="card">
      <img src="../../img/index/turismo-ibis.webp" alt="Bata">
      <h3>Restaurante del Hotel Ibis</h3>
    </div>
   
  </div>

  <!-- Botones -->
  <div class="carousel-buttons" style="margin-bottom: 20rem;">
    <button onclick="moveCarousel(-1)" ><</button>
    <button onclick="moveCarousel(1)">></button>
  </div>
</div>
<!--fin carusel del restaurante: destinos destacados-->

</section>
</div>
<!-- fin boton restaurantes-->

<!--boton 2 cultura -->
<div id="cultura" class="seccion-contenido">
  <section><h1  class="text-center textoPrincipal">Descubre la Cultura a lo Largo del Camino. </h1></section>
  <div class="contenedor-cajas">
    <div class="caja">
      <img src="../../img/index/turismo-mekuyo.jpg" alt="">
      <div class="contenido">
        <h4>Mekuyos Ndowe (Bata)</h4>
        <p>Descubre “El Mamarracho”, una vibrante fiesta tradicional masculina de los pueblos Ndowe como: los combes, bengas y buikos. Celebrada solo los domingos y siempre antes del atardecer, esta ceremonia ancestral mezcla ritmo, cultura y comunidad en una experiencia única que conecta con las raíces del litoral ecuatoguineano. Ideal para los viajeros que buscan sumergirse en tradiciones vivas.</p>
        <a href=""><button class="btn-mas-info">Más info</button></a>
      </div>
    </div>
    <div class="caja">
      <img src="../../img/index/baileturismo (4).jpeg" alt="">
      <div class="contenido">
        <h4>Cultura Fang (Bata)</h4>
        <p>El pueblo Fang, mayoritario en la región continental de Guinea Ecuatorial, representa una de las raíces culturales más profundas del país. Su cultura está basada en la comunidad, el respeto a los ancestros y la transmisión oral del conocimiento. </p>
        <a href=""><button class="btn-mas-info">Más info</button></a>
      </div>
    </div>
    <div class="caja">
      <img src="../../img/index/Torre.png" alt="">
      <div class="contenido">
        <h4>Torre de la Libertad (Bata)</h4>
        <p>La Torre de la Libertad, situada en el Paseo Marítimo de Bata, es un símbolo de la independencia nacional. Inaugurada en 2011, destaca por su arquitectura moderna, su iluminación nocturna y su restaurante giratorio con vistas panorámicas de la ciudad y el océano.</p>
        <a href=""><button class="btn-mas-info">Más info</button></a>
      </div>
    </div>
    <div class="caja">
      <img src="../../img/index/turismo-biblioteca.jpg" alt="">
      <div class="contenido">
        <h4>Biblioteca Subterránea (Bata)</h4>
        <p>La Biblioteca Subterránea de Bata es uno de los espacios culturales más fascinantes de Guinea Ecuatorial. Situada en el corazón de la ciudad, esta biblioteca no solo alberga miles de libros y documentos históricos, sino que lo hace en un entorno arquitectónico subterráneo, silencioso y refrescante, perfecto para la contemplación y el aprendizaje.</p>
        <a href=""><button class="btn-mas-info">Más info</button></a>
      </div>
    </div>
    <div class="caja">
      <img src="../../img/index/turismo-aauca.jpg" alt="">
      <div class="contenido">
        <h4>AAUCA (Oyala)</h4>
        <p>La Univesidad Afro-americana de Guinea Ecuatorial (AAUCA) en Oyala es un centro universitario dinámico que atrae estudiantes y visitantes interesados en la educación, la cultura y el desarrollo regional, ofreciendo una experiencia única para el turismo académico en la ciudad de Oyala. Ya que es la universidad mas grande de Guinea Ecuatorial. </p>
        <a href=""><button class="btn-mas-info">Más info</button></a>
      </div>
    </div>
    <div class="caja">
      <img src="../../img/index/turismo-maritimo.jpg" alt="">
      <div class="contenido">
        <h4>Paseo Marítimo (Bata)</h4>
        <p>El Paseo Marítimo de Bata es uno de los espacios más emblemáticos y encantadores de la ciudad. Frente al océano Atlántico, este bulevar peatonal se extiende a lo largo de la costa ofreciendo un escenario ideal para disfrutar del atardecer, pasear al aire libre, saborear mariscos frescos y empaparse del ambiente tropical.</p>
        <a href=""><button class="btn-mas-info">Más info</button></a>
      </div>
    </div>
    <div class="caja">
      <img src="../../img/index/turismo-mongomo2.jpg" alt="">
      <div class="contenido">
        <h4>Ciudad de Mongomo (Mongomo)</h4>
        <p>Mongomo es una ciudad vibrante en el corazón de la región continental de Guinea Ecuatorial, donde la cultura fang se vive en cada rincón. Con paisajes naturales, mercados llenos de vida y tradiciones que se celebran con orgullo, ofrece una experiencia auténtica para el viajero que busca cultura, sabor local y hospitalidad.</p>
        <a href=""><button class="btn-mas-info">Más info</button></a>
      </div>
    </div>
    <div class="caja">
      <img src="../../img/index/turismo-anisok.jpeg" alt="">
      <div class="contenido">
        <h4>Ciudad de Añisok (Añisok)</h4>
        <p>Anisok es una encantadora ciudad ubicada en la región continental de Guinea Ecuatorial, que ofrece a los visitantes una experiencia auténtica y enriquecedora. Rodeada de exuberantes paisajes naturales y rica en tradiciones culturales, Anisok invita a descubrir su patrimonio fang a través de sus mercados locales, festivales tradicionales y la cálida hospitalidad de su gente. </p>
        <a href=""><button class="btn-mas-info">Más info</button></a>
      </div>
    </div>  
  </div>
    <!-- seccion de comidas del restaurantes-->
  <section class="lo-que-debes-probar">
  <h2>Lo que debes descubrir</h2>
  <p>Sumérgete en la riqueza cultural a través de sus instrumentos, arte y vestimenta tradicional.</p>
  <div class="galeria-platos">
    <a href="" class="plato">
      <img src="../../img/index/turismo-instrumento1.jpg" alt="Pepper Soup">
      <h3>Mendjang o Xilófonos</h3>
      <p>Instrumento tradicional fang que se usan en bailes. Elaborados en madera, los hay de 11 palos o 21 palos.</p>
    </a>
    <a href="" class="plato">
      <img src="../../img/index/turismo-instrumento2.jpg" alt="Plátano Maduro">
      <h3>Monduma (tambor)</h3>
      <p>Instrumento de la etnia ecuatoguineana con los que que bailan ivanga y mecuyo.</p>
    </a>
    <a href="" class="plato">
      <img src="../../img/index/turismo-mascara.jpg" alt="Salsa de Cacahuete">
      <h3>Máscara Fang</h3>
      <p>Desde hace tiempo se utilizaban en distintas ceremonias de tipo familiar y comunal.</p>
    </a>
    <a href="platos/yuca.html" class="plato">
      <img src="../../img/index/turismo-pintar.webp" alt="Yuca cocida">
      <h3>Pintar el Rostro</h3>
      <p>Pintarse el rostro es una muestra de llamar a su cultura es clave..</p>
    </a>
    <a href="" class="plato">
      <img src="../../img/index/turismo-ropa tradicional.jpeg" alt="Bambucha">
      <h3>Popo africano</h3>
      <p>Tela africana tradicional que se suele usar mucho en ocasiones festivas tradicionales.</p>
    </a>
    <a href="" class="plato">
      <img src="../../img/index/turismo-baile.jpg" alt="Buñuelos de Banana">
      <h3>Baile tradicional</h3>
      <p>El amor al baile tradicional es propia de todas las etnias del país.</p>
    </a>
  </div>
</section>

  
<!--carusel del restaurante: destinos destacados-->

<!-- Caja de título y descripción -->
<section class="destinos-header">
  <h2>Destinos destacados</h2>
  <p>
    Explora los rincones más emblemáticos al viajar en bus. Lugares con mucha cultura y tradicion por descubrir.
  </p>
</section>
<div class="carousel-container">
  <div class="carousel-track" id="carouselTrack">
    <!-- Card 1 -->
    <div class="card">
      <img src="../../img/index/turismo-mongomo2.jpg" alt="Malabo">
      <h3>Ciudad de Mongomo (Mongomo)</h3>
    </div>
    <!-- Card 2 -->
    <div class="card">
      <img src="../../img/index/turismo-maritimo.jpg" alt="Monte Alen">
      <h3>Paseo Marítimo (Bata)</h3>
    </div>
    <!-- Card 3 -->
    <div class="card">
      <img src="../../img/index/turismo-biblioteca.jpg" alt="Corisco">
      <h3>Biblioteca Subterránea (Bata)</h3>
    </div>
    <!-- Card 4 -->
    <div class="card">
      <img src="../../img/index/turismo-anisok.jpeg" alt="Bioko">
      <h3>Ciudad de Añisok (Añisok)</h3>
    </div>
    <!-- Card 5 -->
    <div class="card">
      <img src="../../img/index/turismo-cultural.jpg" alt="Fang Cultura">
      <h3>Centro Cultural de España  (Bata)</h3>
    </div>
     <!-- Card 6 -->
    <div class="card">
      <img src="../../img/index/turismo-cultural2.jpg" alt="Fang Cultura">
      <h3>Centro Cultural Ecuatoguineano (Bata)</h3>
    </div>
     <!-- Card 7 -->
    <div class="card">
      <img src="../../img/index/turismo-torresoyala.jpeg" alt="Fang Cultura">
      <h3>Torres gemelas (Oyala)</h3>
    </div>
     <!-- Card 8 -->
    <div class="card">
      <img src="../../img/index/turismo-oyalarectorado.jpeg" alt="Fang Cultura">
      <h3>Rectorado de la AAUCA (Oyala)</h3>
    </div>
  </div>

  <!-- Botones -->
  <div class="carousel-buttons" style="margin-bottom: 20rem;">
    <button onclick="moveCarousel(-1)" ><</button>
    <button onclick="moveCarousel(1)">></button>
  </div>
</div>
<!--fin carusel del restaurante: destinos destacados-->

</section>
</div>
<!--fin boton  cultura -->


<!--boton 3 hotel antes era naturaleza -->
<div id="naturaleza" class="seccion-contenido">
  <section><h1  class="text-center textoPrincipal"  style="padding:28px;">Descubre alojamientos pensados para tu comodidad, ideales para complementar cada experiencia de viaje.</h1></section>
  <div class="contenedor-cajas">
    <div class="caja">
      <img src="../../img/index/turismo-Hotel-Basilica2.webp" alt="">
      <div class="contenido">
        <h4>Hotel Basílica (Mongomo)</h4>
        <p>Playa y arena impresionante en una isla preciosa.</p><!-- <p>Senderos y naturaleza impresionante.</p> -->
        <button class="btn-mas-info">Más info</button>
      </div>
    </div>
        <div class="caja">
      <img src="../../img/index/ciudadOyala.png" alt="">
      <div class="contenido">
        <h4>Hotel Djibloho (Oyala)</h4>
        <p>Playa y arena impresionante en una isla preciosa.</p><!-- <p>Senderos y naturaleza impresionante.</p> -->
        <button class="btn-mas-info">Más info</button>
      </div>
    </div>
    <div class="caja">
      <img src="../../img/index/turismo-hotel vistamar.jpg" alt="">
      <div class="contenido">
        <h4>Hotel Vistamar (Bata)</h4>
        <p>Una isla escondida en un pueblo de Bata con arenas finas y aguas claras.</p>
        <button class="btn-mas-info">Más info</button>
      </div>
    </div>
    <div class="caja">
      <img src="../../img/index/turismo-ibis2.jpg" alt="">
      <div class="contenido">
        <h4>Hotel Ibis (Oyala)</h4>
        <p></p>
        <button class="btn-mas-info">Más info</button>
      </div>
    </div>
    <div class="caja">
      <img src="../../img/index/turismo-Hotel_Mongomo.webp" alt="">
      <div class="contenido">
        <h4>Hotel Mongomo (Mongomo)</h4>
        <p>Playa y arena impresionante en una isla preciosa.</p>
        <button class="btn-mas-info">Más info</button>
      </div>
    </div>
    <div class="caja">
      <img src="../../img/index/turismo-pana.jpg" alt="">
      <div class="contenido">
        <h4>Hotel Panafrica (Bata)</h4>
        <p>Playa y arena impresionante en una isla preciosa.</p><!-- <p>Senderos y naturaleza impresionante.</p> -->
        <button class="btn-mas-info">Más info</button>
      </div>
    </div>
    <div class="caja">
      <img src="../../img/index/turismo-Hotel_Mongomo.webp" alt="">
      <div class="contenido">
        <h4>Hotel Mongomo (Mongomo)</h4>
        <p>Playa y arena impresionante en una isla preciosa.</p>
        <button class="btn-mas-info">Más info</button>
      </div>
    </div>
    <div class="caja">
      <img src="../../img/index/turismo-pana.jpg" alt="">
      <div class="contenido">
        <h4>Hotel Panafrica (Bata)</h4>
        <p>Playa y arena impresionante en una isla preciosa.</p>
        <button class="btn-mas-info">Más info</button>
      </div> 
    </div>
  </div>
    <!-- seccion de comidas del restaurantes-->
  <section class="lo-que-debes-probar">
  <h2>Lo que debes probar</h2>
  <p>Sabores tradicionales de la región continental: Bata, Mongomo, Añisok, Ebibeyin y Oyala.</p>
  <div class="galeria-platos">
    <a href="platos/caracoles.html" class="plato">
      <img src="../../img/index/turismo-caracol.jpg" alt="Caracoles en salsa">
      <h3>Caracoles</h3>
      <p>Un manjar tradicional muy apreciado por los locales.</p>
    </a>
    <a href="platos/platano-maduro.html" class="plato">
      <img src="../../img/index/turismo-frito.jpg" alt="Plátano Maduro">
      <h3>Plátano Maduro</h3>
      <p>Dulce y dorado, perfecto como acompañamiento o postre.</p>
    </a>
    <a href="platos/bambucha.html" class="plato">
      <img src="../../img/index/turismo-bambucha.jpg" alt="Bambucha">
      <h3>Bambucha</h3>
      <p>Fermentado local hecho a base de maíz o plátano.</p>
    </a>
    <a href="platos/salsa-cacahuete.html" class="plato">
      <img src="../../img/index/turismo-cacahuete.jpg" alt="Salsa de Cacahuete">
      <h3>Salsa de Cacahuete</h3>
      <p>Espesa, nutritiva y llena de sabor africano auténtico.</p>
    </a>
    <a href="platos/bunuelos-banana.html" class="plato">
      <img src="../../img/index/turismo-bunuelos.jpg" alt="Buñuelos de Banana">
      <h3>Buñuelos de Banana</h3>
      <p>Deliciosos y crujientes bocados dulces.</p>
    </a>
    <a href="platos/yuca.html" class="plato">
      <img src="../../img/index/turismo-yuca.jpg" alt="Yuca cocida">
      <h3>Yuca</h3>
      <p>Tubérculo esencial, hervido o frito, lleno de energía.</p>
    </a>
  </div>
</section>

  
<!--carusel del restaurante: destinos destacados-->

<!-- Caja de título y descripción -->
<section class="destinos-header">
  <h2>Hoteles  destacados</h2>
  <p>
    Explora los hoteles más emblemáticos de tu viaje. Desde hoteles muy lujosos de 5 estrellas y descubre establecimientos únicos que te sorprenderán.
  </p>
</section>
<div class="carousel-container">
  <div class="carousel-track" id="carouselTrack">
  <!-- Card 1 -->
    <div class="card">
      <img src="../../img/index/ciudadOyala.png" alt="">
      <h3>Hotel Djibloho (Oyala)</h3>
    </div>
    <!-- Card 2 -->
    <div class="card">
      <img src="../../img/index/turismo-hotel vistamar.jpg" alt="">
      <h3>Hotel Vistamar (Bata)</h3>
    </div>
    <!-- Card 3 -->
    <div class="card">
      <img src="../../img/index/turismo-Hotel-Basilica2.webp" alt="">
      <h3>Hotel Basílica (Mongomo)</h3>
    </div>
    <!-- Card 4 -->
    <div class="card">
      <img src="../../img/index/turismo-ibis2.jpg" alt="Bioko">
      <h3>Hotel Ibis (Oyala)</h3>
    </div>
    <!-- Card 5 -->
    <div class="card">
      <img src="../../img/index/turismo-pana.jpg" alt="Fang Cultura">
      <h3>Hotel Panafrica (Bata)</h3>
    </div>
    <!-- Card 6 -->
    <div class="card">
      <img src="../../img/index/turismo-Hotel_Mongomo.webp" alt="Fang Cultura">
      <h3>Hotel Mongomo (Mongomo)</h3>
    </div>
  </div>

  <!-- Botones -->
  <div class="carousel-buttons" style="margin-bottom: 20rem;">
    <button onclick="moveCarousel(-1)" ><</button>
    <button onclick="moveCarousel(1)">></button>
  </div>
</div>
<!--fin carusel del restaurante: destinos destacados-->

</section>
</div>
<!--fin boton 3  naturaleza ahora hotel -->


<!--boton 4 cosas -->
<div id="cosas" class="seccion-contenido">
  <section><h1  class="text-center textoPrincipal"  style="padding:0px 70px 0px 70px;">Explora experiencias únicas, actividades culturales y momentos inolvidables con cada viaje que planificamos para ti.</h1></section>
  <div class="contenedor-cajas">
      <div class="caja">
      <img src="../../img/index/turismo-bicicleta.jpg" alt="">
      <div class="contenido">
        <h4>Tour en Bicicleta</h4>
        <p>Explora la ciudad en dos ruedas.</p>
        <button class="btn-mas-info">Más info</button>
      </div>
    </div>
    <div class="caja">
      <img src="../../img/index/puntambondaturismo.jpeg" alt="">
      <div class="contenido">
        <h4>Ir a la playa de Punta Mbonda (Bata)</h4>
        <p>Visita la playa de Punta Mbonda, el momento ahí sobre todo con compañía es único.</p>
        <button class="btn-mas-info">Más info</button>
      </div>
    </div>
    <div class="caja">
      <img src="../../img/index/turismo-lago.jpeg" alt="">
      <div class="contenido">
        <h4>Bañar en el lago (Oyala)</h4>
        <p>En Oyala existe un lago escondido entre el silencioso bosque.</p>
        <button class="btn-mas-info">Más info</button>
      </div>
    </div>
    <div class="caja">
      <img src="../../img/index/coriscoturismo.JPG" alt="">
      <div class="contenido">
        <h4>Llegar a Corisco (Bata)</h4>
        <p>Las aguas limpias y cristalinas de Corisco te harán querer quedarte para siempre y no salir de sus aguas.</p>
        <button class="btn-mas-info">Más info</button>
      </div>
    </div>
    <div class="caja">
      <img src="../../img/index/turismo-manila.jpg" alt="">
      <div class="contenido">
        <h4>Comer en el Restaurante Manila (Bata)</h4>
        <p>Si te apetece comer en un restaurante muy elegante y romántico acercate a este restaurante.</p>
        <button class="btn-mas-info">Más info</button>
      </div>
    </div>
    <div class="caja">
      <img src="../../img/index/turismo-maritimo.jpg" alt="">
      <div class="contenido">
        <h4>Tomar aire fresco en el Paseo Marítimo (Bata)</h4>
        <p>Si quieres sentir el soplo de las olas tan suave y tranquilo acercate y date un paseo digno con una vista agradable.</p>
        <button class="btn-mas-info">Más info</button>
      </div>
    </div>
    <div class="caja">
      <img src="../../img/index/turismo-biblioteca.jpg" alt="">
      <div class="contenido">
        <h4>Leer libros en una Biblioteca Subterránea (Bata) </h4>
        <p>En medio de la ciudad se encuentra una biblioteca asombrosa con un silencio merecedor suficiente para trabajar o para leerte un libro.</p>
        <button class="btn-mas-info">Más info</button>
      </div>
    </div>
    <div class="caja">
      <img src="../../img/index/turismo-mongomo2.jpg" alt="">
      <div class="contenido">
        <h4>Explorar  Mongomo (Mongomo)</h4>
        <p>Existe una ciudad igual de preciosa que la ciudad de Bata fascinante y que tiene mucho por explorar.</p>
        <button class="btn-mas-info">Más info</button>
      </div>
    </div>
  </div>
    <!-- seccion de comidas del restaurantes-->
  <section class="lo-que-debes-probar">
  <h2>Lo que debes probar</h2>
  <p>Sabores tradicionales de la región continental: Bata, Mongomo, Añisok, Ebibeyin y Oyala.</p>
  <div class="galeria-platos">
    <a href="platos/caracoles.html" class="plato">
      <img src="../../img/index/turismo-caracol.jpg" alt="Caracoles en salsa">
      <h3>Caracoles</h3>
      <p>Un manjar tradicional muy apreciado por los locales.</p>
    </a>
    <a href="platos/platano-maduro.html" class="plato">
      <img src="../../img/index/turismo-frito.jpg" alt="Plátano Maduro">
      <h3>Plátano Maduro</h3>
      <p>Dulce y dorado, perfecto como acompañamiento o postre.</p>
    </a>
    <a href="platos/bambucha.html" class="plato">
      <img src="../../img/index/turismo-bambucha.jpg" alt="Bambucha">
      <h3>Bambucha</h3>
      <p>Fermentado local hecho a base de maíz o plátano.</p>
    </a>
    <a href="platos/salsa-cacahuete.html" class="plato">
      <img src="../../img/index/turismo-cacahuete.jpg" alt="Salsa de Cacahuete">
      <h3>Salsa de Cacahuete</h3>
      <p>Espesa, nutritiva y llena de sabor africano auténtico.</p>
    </a>
    <a href="platos/bunuelos-banana.html" class="plato">
      <img src="../../img/index/turismo-bunuelos.jpg" alt="Buñuelos de Banana">
      <h3>Buñuelos de Banana</h3>
      <p>Deliciosos y crujientes bocados dulces.</p>
    </a>
    <a href="platos/yuca.html" class="plato">
      <img src="../../img/index/turismo-yuca.jpg" alt="Yuca cocida">
      <h3>Yuca</h3>
      <p>Tubérculo esencial, hervido o frito, lleno de energía.</p>
    </a>
  </div>
</section>

  
<!--carusel del restaurante: destinos destacados-->

<!-- Caja de título y descripción -->
<section class="destinos-header">
  <h2>Actividades destacadas</h2>
  <p>
    Explora las actividades más emblemáticos de tu viaje. Sin limitaciones de lugares y sitios marravillosos para probar comidas bellas.
  </p>
</section>
<div class="carousel-container">
  <div class="carousel-track" id="carouselTrack">
    <!-- Card 1 -->
    <div class="card">
      <img src="../../img/index/turismo-biblioteca.jpg" alt="">
      <h3>Leer en la Biblioteca Subterránea (Bata)</h3>
    </div>
    <!-- Card 2 -->
    <div class="card">
      <img src="../../img/index/turismo-mongomo2.jpg" alt="">
      <h3>Explorar la Ciudad de Mongomo (Mongomo)</h3>
    </div>
    <!-- Card 3 -->
    <div class="card">
      <img src="../../img/index/turismo-manila.jpg" alt="">
      <h3>Comer en el Restaurante Manila (Bata)</h3>
    </div>
    <!-- Card 4 -->
    <div class="card">
      <img src="../../img/index/turismo-maritimo.jpg" alt="Bioko">
      <h3>Paseo en el Paseo Marítimo (Bata)</h3>
    </div>
    <!-- Card 5 -->
    <div class="card">
      <img src="../../img/index/turismo-lago.jpeg" alt=" ">
      <h3>Bañar en el lago (Oyala)</h3>
    </div>
      <!-- Card 6-->
    <div class="card">
      <img src="../../img/index/puntambondaturismo.jpeg" alt=" ">
      <h3>Ir a la playa de Punta Mbonda (Bata)</h3>
    </div>
         <!-- Card 7-->
    <div class="card">
      <img src="../../img/index/coriscoturismo.JPG" alt=" ">
      <h3>Llegar a Corisco (Bata)</h3>
    </div>
        <!-- Card 8-->
    <div class="card">
      <img src="../../img/index/turismo-bicicleta.jpg`" alt=" ">
      <h3>Tour en Bicicleta</h3>
    </div>
  </div>

  <!-- Botones -->
  <div class="carousel-buttons" style="margin-bottom: 20rem;">
    <button onclick="moveCarousel(-1)" ><</button>
    <button onclick="moveCarousel(1)">></button>
  </div>
</div>
<!--fin carusel del restaurante: destinos destacados-->

</section>
</div>
<!--fin boton4 cosas -->

<!-- footer -->
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
<script src="../js/turismo.js"></script>
<script src="../js/buscador.js"></script>
    <script src="../../controllers/js/bootstrap.min.js"></script>
    <script src="../../controllers/js/sweetalert2.js"></script>
    <script src="../../controllers/js/botones.js"></script>
    <script src="../../controllers/js/lgi.js"></script>
</body>
</html>