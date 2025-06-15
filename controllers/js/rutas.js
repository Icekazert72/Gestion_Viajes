
document.addEventListener("DOMContentLoaded", () => {
  function obtenerViajes() {
    const urlParams = new URLSearchParams(window.location.search);
    const origen = urlParams.get('origen');
    const destino = urlParams.get('destino');
    const hora = urlParams.get('hora');
    const fecha = urlParams.get('fecha');
    const viajeros = urlParams.get('viajeros');

    if (!origen || !destino || !hora || !fecha || !viajeros) {
      alert("Faltan parámetros de búsqueda.");
      return;
    }

    const apiUrl = `../../../Proyecto_0.1/models/publicControler/viajesOpcion.php?origen=${encodeURIComponent(origen)}&destino=${encodeURIComponent(destino)}&hora=${encodeURIComponent(hora)}&fecha=${encodeURIComponent(fecha)}&viajeros=${encodeURIComponent(viajeros)}`;

    const xhr = new XMLHttpRequest();
    xhr.open('GET', apiUrl, true);
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        try {
          const viajes = JSON.parse(xhr.responseText);
          const container = document.querySelector('.cards_container');
          container.innerHTML = '';

          if (viajes.length === 0) {
            container.innerHTML = "<p>No se encontraron viajes disponibles para los parámetros seleccionados.</p>";
          } else {
            viajes.forEach(viaje => {
              const card = document.createElement('div');
              card.classList.add('rutas_card');
              card.innerHTML = `
                <div class="container cardContainer" data-id-boton="${viaje.id}" data-origen="${origen}" data-destino="${destino}" data-viajeros="${viajeros}">
                  <div class="card_head">
                    <div class="img"><img src="../../img/index/images.png" alt=""></div>
                    <div class="title"><h5 class="agencia">${viaje.agencia}</h5></div>
                  </div> 
                  <div class="card_body">
                    <div class="icon"><i class="fa-solid fa-bus"></i></div>
                    <div class="horario">
                      <p id="ini">${viaje.hora_salida}</p>
                      <p><i class="fa-solid fa-caret-right"></i></p>
                      <p id="fin">${viaje.hora_llegada}</p>
                    </div>
                    <div class="bus_num"><p id="num_bus"><strong>${viaje.numero_bus} - ${viaje.modelo}</strong></p></div>
                  </div>
                  <div class="card_footer">
                    <div class="statico">
                      <div class="precio"><p>${viaje.precio} XAF</p></div>
                      <div class="btnTicket">
                        <button class="boton">Reservar</button>
                      </div>
                    </div>
                  </div>
                </div>
              `;
              container.appendChild(card);
            });
          }
        } catch (e) {
          console.error('Error parsing JSON:', e);
          console.log('Response Text:', xhr.responseText);
        }
      }
    };
    xhr.send();
  }

  // Delegación de eventos para los botones dinámicos
  document.addEventListener('click', function (e) {
    if (e.target && e.target.classList.contains('boton')) {
      const btn = e.target;
      const card = btn.closest('.cardContainer');

      const viajeId = card.getAttribute('data-id-boton');
      const origen = card.getAttribute('data-origen');
      const destino = card.getAttribute('data-destino');
      const viajeros = card.getAttribute('data-viajeros');

      const precioText = card.querySelector('.precio p')?.textContent.trim() || "0";
      const precio = precioText.split(' ')[0];

      const horaIni = card.querySelector('#ini')?.textContent.trim() || "";
      const horaFin = card.querySelector('#fin')?.textContent.trim() || "";
      const numBus = card.querySelector('#num_bus')?.textContent.trim() || "";
      const agencia = card.querySelector('.agencia')?.textContent.trim() || "";

      localStorage.setItem('viaje_id', viajeId);
      localStorage.setItem('origen', origen);
      localStorage.setItem('destino', destino);
      localStorage.setItem('viajeros', viajeros);
      localStorage.setItem('precio', precio);
      localStorage.setItem('hora_ini', horaIni);
      localStorage.setItem('hora_fin', horaFin);
      localStorage.setItem('num_bus', numBus);
      localStorage.setItem('agencia', agencia);

      window.location.href = `../../views/procesode_reserva/servicio_tipo.php?origen=${origen}&destino=${destino}&viajeros=${viajeros}&viaje_id=${viajeId}`;
    }
  });

  // Ejecutar búsqueda de viajes al cargar
  obtenerViajes();
});
