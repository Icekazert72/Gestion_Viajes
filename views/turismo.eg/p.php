<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Regiones Turísticas</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<style>
    body {
  font-family: 'Segoe UI', sans-serif;
  background-color: #f9f9f9;
  margin: 0;
  padding: 40px 0;
}

.regiones-container {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  max-width: 1300px;
  margin: auto;
  position: relative;
  flex-wrap: wrap;
}

/* Línea vertical centrada */
.divider {
  width: 3px;
  background: #ccc;
  height: 100%;
  position: absolute;
  left: 50%;
  top: 0;
  transform: translateX(-50%);
}

/* Estilos de cada región */
.region {
  width: 48%;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 40px;
  z-index: 1;
}

.region-title {
  font-size: 1.8rem;
  text-align: center;
  margin-bottom: 10px;
  color: #2c3e50;
}

/* Tarjetas con diseño diferente */
.card {
  background: white;
  border-radius: 25px;
  overflow: hidden;
  box-shadow: 0 6px 14px rgba(0, 0, 0, 0.1);
  position: relative;
  transition: transform 0.3s ease;
  width: 100%;
  max-width: 340px;
}

.image-container {
  position: relative;
  overflow: hidden;
  border-radius: 25px 25px 0 0;
}

.card img {
  width: 100%;
  height: 220px;
  object-fit: cover;
  transition: transform 0.4s ease;
}

.card h4 {
  margin: 0;
  padding: 15px;
  font-size: 1.1rem;
  background-color: #fff;
  text-align: center;
  color: #333;
}

.overlay {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(65, 105, 225, 0.8);
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  opacity: 0;
  padding: 20px;
  font-size: 1rem;
  transition: opacity 0.3s ease;
}

.card:hover .overlay {
  opacity: 1;
}

.card:hover img {
  transform: scale(1.1);
}


/* Formas creativas */
.weird-shape {
  clip-path: polygon(0 0, 100% 10%, 95% 100%, 5% 90%);
}

.rotate-left {
  transform: rotate(-1deg);
}

.rotate-right {
  transform: rotate(1deg);
}

.tilt-top {
  transform: translateY(-10px) rotate(-2deg);
}

.tilt-bottom {
  transform: translateY(10px) rotate(2deg);
}

/* Responsivo */
@media (max-width: 900px) {
  .regiones-container {
    flex-direction: column;
    align-items: center;
  }

  .divider {
    display: none;
  }

  .region {
    width: 100%;
    align-items: center;
  }

  .card {
    max-width: 90%;
  }
}

</style>
<section class="regiones-container">

  <div class="region region-insular">
    <h3 class="region-title">Región Insular</h3>
    <div class="card weird-shape rotate-left">
      <div class="image-container">
        <img src="https://upload.wikimedia.org/wikipedia/commons/0/0b/Bioko_Island_Landsat.jpg" alt="Isla de Bioko">
        <div class="overlay">La Isla de Bioko, con su biodiversidad y playas volcánicas, es un paraíso natural en el golfo de Guinea.</div>
      </div>
      <h4>Isla de Bioko</h4>
    </div>
    <div class="card weird-shape tilt-top">
      <div class="image-container">
        <img src="https://upload.wikimedia.org/wikipedia/commons/d/d7/Corisco_Island%2C_Equatorial_Guinea.jpg" alt="Corisco">
        <div class="overlay">La Isla de Corisco destaca por sus playas de arena blanca y restos arqueológicos precoloniales.</div>
      </div>
      <h4>Isla de Corisco</h4>
    </div>
  </div>

  <div class="divider"></div>

  <div class="region region-continental">
    <h3 class="region-title">Región Continental</h3>
    <div class="card weird-shape rotate-right">
      <div class="image-container">
        <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/Monte_Alen_National_Park_EG.jpg" alt="Monte Alén">
        <div class="overlay">Monte Alén es una reserva natural exuberante y hogar de elefantes, gorilas y otras especies endémicas.</div>
      </div>
      <h4>Parque Monte Alén</h4>
    </div>
    <div class="card weird-shape tilt-bottom">
      <div class="image-container">
        <img src="https://upload.wikimedia.org/wikipedia/commons/6/6d/Fang_people_in_Equatorial_Guinea.jpg" alt="Cultura Fang">
        <div class="overlay">La región continental refleja la cultura Fang, rica en tradiciones, máscaras y ceremonias ancestrales.</div>
      </div>
      <h4>Cultura Fang</h4>
    </div>
  </div>

</section>

</body>
</html>
