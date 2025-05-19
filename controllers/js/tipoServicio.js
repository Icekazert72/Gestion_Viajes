document.addEventListener("DOMContentLoaded", () => {
  const botonesServicio = document.querySelectorAll('.btn_servicio');

  botonesServicio.forEach(btn => {
    btn.addEventListener('click', () => {
      const tipo = btn.getAttribute('data-tipo');
      const precioAdicional = parseInt(btn.getAttribute('data-precio')) || 0;

      // Recuperar datos guardados en localStorage
      const origen = localStorage.getItem('origen');
      const destino = localStorage.getItem('destino');
      const viajeros = localStorage.getItem('viajeros');
      const precioBase = parseInt(localStorage.getItem('precio')) || 0;

      if (origen && destino && viajeros && tipo) {
        // Calcular nuevo precio total
        const precioTotal = precioBase + precioAdicional;

        // Guardar los datos en localStorage
        localStorage.setItem('precio_servicio', precioAdicional); // <--- ESTA LÍNEA ES NUEVA
        localStorage.setItem('precio_total', precioTotal);
        localStorage.setItem('tipo', tipo); // también guarda el tipo por si lo necesitas después

        // Redirigir (también puedes incluir el precio de servicio en la URL si lo deseas)
        window.location.href = `credencialesReserva.php?origen=${encodeURIComponent(origen)}&destino=${encodeURIComponent(destino)}&viajeros=${encodeURIComponent(viajeros)}&tipo=${tipo}&precio=${precioTotal}`;
      } else {
        alert("Faltan datos para completar la reserva.");
      }
    });
  });
});

