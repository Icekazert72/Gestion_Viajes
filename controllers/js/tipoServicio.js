document.addEventListener("DOMContentLoaded", () => {
  const botonesServicio = document.querySelectorAll('.btn_servicio');

  botonesServicio.forEach(btn => {
    btn.addEventListener('click', () => {
      const tipo = btn.getAttribute('data-tipo');
      const precioAdicional = parseInt(btn.getAttribute('data-precio')) || 0;

      // Recuperar todos los datos desde localStorage
      const viaje_id     = localStorage.getItem('viaje_id');
      const origen       = localStorage.getItem('origen');
      const destino      = localStorage.getItem('destino');
      const viajeros     = localStorage.getItem('viajeros');
      const precioBase   = parseInt(localStorage.getItem('precio')) || 0;
      const hora_ini     = localStorage.getItem('hora_ini');
      const hora_fin     = localStorage.getItem('hora_fin');
      const num_bus      = localStorage.getItem('num_bus');
      const agencia      = localStorage.getItem('agencia');

      if (viaje_id && origen && destino && viajeros && tipo) {
        // Calcular precio total
        const precioTotal = precioBase + precioAdicional;

        // Guardar en localStorage
        localStorage.setItem('tipo', tipo);
        localStorage.setItem('precio_servicio', precioAdicional);
        localStorage.setItem('precio_total', precioTotal);

        // Construir URL con todos los datos necesarios
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

        // Redirigir con todos los datos
        window.location.href = url.toString();
      } else {
        alert("Faltan datos para completar la reserva.");
      }
    });
  });
});
