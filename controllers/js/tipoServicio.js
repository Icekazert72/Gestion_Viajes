document.addEventListener("DOMContentLoaded", () => {
  const botonesServicio = document.querySelectorAll('.btn_servicio');

  botonesServicio.forEach(btn => {
    btn.addEventListener('click', () => {
      const tipo = btn.getAttribute('data-tipo');
      const precioAdicional = parseInt(btn.getAttribute('data-precio')) || 0;

      const viaje_id   = localStorage.getItem('viaje_id');
      const origen     = localStorage.getItem('origen');
      const destino    = localStorage.getItem('destino');
      const viajeros   = localStorage.getItem('viajeros');
      const precioBase = parseInt(localStorage.getItem('precio')) || 0;
      const hora_ini   = localStorage.getItem('hora_ini');
      const hora_fin   = localStorage.getItem('hora_fin');
      const num_bus    = localStorage.getItem('num_bus');
      const agencia    = localStorage.getItem('agencia');
      const id_agencia = localStorage.getItem('id_agencia');

      if (viaje_id && origen && destino && viajeros && tipo) {
        const precioTotal = precioBase + precioAdicional;
        localStorage.setItem('tipo', tipo);
        localStorage.setItem('precio_servicio', precioAdicional);
        localStorage.setItem('precio_total', precioTotal);

        const xhr = new XMLHttpRequest();
        xhr.open("GET", "../../../Proyecto_0.1/models/publicControler/verificarSesion.php", true);
        xhr.onreadystatechange = function () {
          if (xhr.readyState === 4 && xhr.status === 200) {
            const res = JSON.parse(xhr.responseText);
            if (res.sesion_activa) {
              if (res.tipo === 'admin') {
                window.location.href = "../../../Proyecto_0.1/views/admin/index.php";
              } else {
                window.location.href = "../../../Proyecto_0.1/views/procesode_reserva/ReservarViaje.php";
              }
            } else {
              const url = new URL('../../../Proyecto_0.1/views/procesode_reserva/credencialesReserva.php', window.location.origin);
              url.searchParams.set('viaje_id', viaje_id);
              url.searchParams.set('origen', origen);
              url.searchParams.set('destino', destino);
              url.searchParams.set('viajeros', viajeros);
              url.searchParams.set('tipo', tipo);
              url.searchParams.set('precio', precioTotal);
              url.searchParams.set('hora_ini', hora_ini);
              url.searchParams.set('hora_fin', hora_fin);
              url.searchParams.set('num_bus', num_bus);
              url.searchParams.set('agencia', agencia);
              url.searchParams.set('id_agencia', id_agencia);
              window.location.href = url.toString();
            }
          }
        };
        xhr.send();
      } else {
        alert("Faltan datos para completar la reserva.");
      }
    });
  });
});
