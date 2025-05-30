<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Turismo en Guinea Ecuatorial</title>
<style>
  /* Colores y estilos basados en lo que me diste */
  :root {
    --bg-banner: rgba(100, 149, 237, 0.5);
    --color-primary: #0d47a1;
    --gradient-banner: linear-gradient(rgba(65, 105, 225, 0.8), rgba(169, 201, 255, 0.8));
    --shadow-dark: drop-shadow(0 0 12px rgba(0, 0, 0, 0.5));
    --shadow-light: drop-shadow(0 0 20px rgba(255, 255, 255, 0.8));
    --color-text: #1b233f;
    --color-bg: #f9fbff;
  }

  /* Reset y tipografía */
  * {
    margin: 0; padding: 0; box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  body {
    background-color: var(--color-bg);
    color: var(--color-text);
    line-height: 1.6;
  }

  /* Banner con imagen + overlay */
  header.banner {
    position: relative;
    height: 320px;
    background: url('https://upload.wikimedia.org/wikipedia/commons/f/f4/Flag_of_Equatorial_Guinea.svg') no-repeat center center/cover;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    color: white;
    filter: var(--shadow-dark);
  }
  header.banner::before {
    content: "";
    position: absolute;
    inset: 0;
    background: var(--gradient-banner);
    opacity: 0.85;
    z-index: 0;
  }
  header.banner h1 {
    position: relative;
    font-size: 3.5rem;
    font-weight: 900;
    letter-spacing: 5px;
    text-shadow:
      2px 2px 8px rgba(0,0,0,0.7),
      0 0 10px rgba(255,255,255,0.6);
    z-index: 1;
    text-transform: uppercase;
  }

  /* Contenedor general */
  .container {
    max-width: 1100px;
    margin: 2rem auto 4rem auto;
    padding: 0 1rem;
  }

  /* Introducción */
  .intro {
    background-color: var(--bg-banner);
    border-radius: 10px;
    padding: 1.5rem 2rem;
    margin-bottom: 2.5rem;
    box-shadow: var(--shadow-light);
    font-size: 1.2rem;
    color: var(--color-primary);
    font-weight: 600;
  }

  /* Sección destinos */
  h2.section-title {
    color: var(--color-primary);
    font-size: 2.2rem;
    margin-bottom: 1rem;
    padding-bottom: 0.4rem;
    font-weight: 700;
  }

  /* Destinos listado */
  .destinations {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
  }

  @media(min-width: 768px) {
    .destinations {
      grid-template-columns: 1fr 1fr;
    }
  }

  /* Tarjeta destino */
  .destination {
    background: white;
    border-radius: 14px;
    overflow: hidden;
    box-shadow:
      0 4px 10px rgba(0,0,0,0.12),
      inset 0 0 0 3px var(--color-primary);
    display: flex;
    flex-direction: column;
    transition: transform 0.3s ease;
  }
  .destination:hover {
    transform: scale(1.03);
    box-shadow:
      0 8px 16px rgba(0,0,0,0.2);
  }

  .destination img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    filter: var(--shadow-dark);
  }

  .dest-info {
    padding: 1rem 1.3rem 1.5rem 1.3rem;
  }

  .dest-info h3 {
    color: var(--color-primary);
    margin-bottom: 0.5rem;
    font-weight: 800;
    font-size: 1.5rem;
    letter-spacing: 1.3px;
  }

  .dest-info p {
    font-size: 1rem;
    color: var(--color-text);
    line-height: 1.4;
  }

  /* Pie de página */
  footer {
    background: var(--color-primary);
    color: white;
    text-align: center;
    padding: 1.2rem;
    font-weight: 600;
    letter-spacing: 1.1px;
    text-shadow:
      0 0 8px rgba(0,0,0,0.5);
  }
</style>
</head>
<body>

<header class="banner">
  <h1>Turismo Guinea Ecuatorial</h1>
</header>

<main class="container">
  <section class="intro">
    <p>
      Guinea Ecuatorial es un país fascinante en el corazón de África Central, con una diversidad natural, cultural e histórica impresionante. Desde selvas vírgenes hasta playas paradisíacas, esta tierra ofrece experiencias únicas para los amantes de la naturaleza, la cultura y la aventura. Explora sus parques nacionales, maravíllate con sus cascadas y disfruta de la calidez de su gente. ¡Descubre lo mejor de Guinea Ecuatorial con nosotros!
    </p>
  </section>

  <section>
    <h2 class="section-title">Destinos Turísticos Destacados</h2>
    <div class="destinations">

      <article class="destination">
        <img src="https://upload.wikimedia.org/wikipedia/commons/3/32/Monte_Al%C3%A9n_National_Park.jpg" alt="Parque Nacional Monte Alen" />
        <div class="dest-info">
          <h3>Parque Nacional de Monte Alén</h3>
          <p>Un paraíso de biodiversidad en la región continental, hogar de elefantes, gorilas y una exuberante selva tropical.</p>
        </div>
      </article>

      <article class="destination">
        <img src="https://upload.wikimedia.org/wikipedia/commons/8/8e/Cascadas_de_Iladyi.jpg" alt="Cascadas de Iladyi" />
        <div class="dest-info">
          <h3>Cascadas de Iladyi</h3>
          <p>Impresionantes caídas de agua en la isla de Bioko, rodeadas de una densa vegetación y accesibles mediante senderos naturales.</p>
        </div>
      </article>

      <article class="destination">
        <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Ureka_Bioko.jpg" alt="Ureka" />
        <div class="dest-info">
          <h3>Ureka</h3>
          <p>Playas vírgenes y cascadas en la costa sur de Bioko, ideales para el avistamiento de tortugas y la exploración de la naturaleza.</p>
        </div>
      </article>

      <article class="destination">
        <img src="https://upload.wikimedia.org/wikipedia/commons/4/4f/Pico_Basil%C3%A9.jpg" alt="Pico Basilé" />
        <div class="dest-info">
          <h3>Pico Basilé</h3>
          <p>La montaña más alta de Guinea Ecuatorial, ofreciendo vistas panorámicas y una rica biodiversidad.</p>
        </div>
      </article>

      <article class="destination">
        <img src="https://upload.wikimedia.org/wikipedia/commons/6/6d/Catedral_de_Santa_Isabel_Malabo.jpg" alt="Catedral de Santa Isabel" />
        <div class="dest-info">
          <h3>Catedral de Santa Isabel</h3>
          <p>Un emblemático edificio neogótico en Malabo, símbolo de la herencia colonial española.</p>
        </div>
      </article>

      <article class="destination">
        <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Torre_de_la_Libertad_Bata.jpg" alt="Torre de la Libertad" />
        <div class="dest-info">
          <h3>Torre de la Libertad (Bata)</h3>
          <p>Moderno monumento con un restaurante giratorio y vistas panorámicas de la ciudad.</p>
        </div>
      </article>

      <article class="destination">
        <img src="https://upload.wikimedia.org/wikipedia/commons/7/7e/Sipopo_Beach.jpg" alt="Playas de Sipopo" />
        <div class="dest-info">
          <h3>Playas de Sipopo</h3>
          <p>Aguas cristalinas y arenas blancas en un entorno lujoso cerca de Malabo.</p>
        </div>
</article>
</div>
</section>
</main>
<footer>
  &copy; 2025 Turismo GE | Inspirado en la esencia africana
</footer>
</body>
</html>
