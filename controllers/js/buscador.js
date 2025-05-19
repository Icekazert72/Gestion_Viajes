document.addEventListener("DOMContentLoaded", () => {
  const origen = document.getElementById("input_de");
  const destino = document.getElementById("input_a");
  const viajeros = document.getElementById("input_viajeros");
  const fecha = document.getElementById("input_fecha");
  const submit = document.getElementById("submit");

  const direccionRegex = /^[a-zA-Z0-9\s,.\-ºª]+$/;

  function validateInput(input, isValidFn) {
    const value = input.value.trim();
    const isValid = isValidFn(value);

    input.classList.toggle("input-valid", isValid);
    input.classList.toggle("input-error", !isValid);

    return isValid;
  }

  submit.addEventListener("click", function (e) {
    e.preventDefault();

    const isOrigenValid = validateInput(origen, val => val !== "" && direccionRegex.test(val));
    const isDestinoValid = validateInput(destino, val => val !== "" && direccionRegex.test(val));
    const isViajerosValid = validateInput(viajeros, val => {
      const num = parseInt(val);
      return !isNaN(num) && num > 0;
    });
    const isFechaValid = validateInput(fecha, val => {
      const fechaVal = new Date(val);
      return val !== "" && !isNaN(fechaVal.getTime()) && fechaVal > new Date();
    });

    if (isOrigenValid && isDestinoValid && isViajerosValid && isFechaValid) {
      const origenVal = origen.value.trim();
      const destinoVal = destino.value.trim();
      const viajerosVal = viajeros.value.trim();

      const fechaHora = new Date(fecha.value);
      const fechaVal = fechaHora.toISOString().split("T")[0];
      const horaVal = fechaHora.toTimeString().split(":").slice(0, 2).join(":");

      // Guardar en localStorage sin encodeURIComponent (solo necesario en URL)
      localStorage.setItem('origen', origenVal);
      localStorage.setItem('destino', destinoVal);
      localStorage.setItem('viajeros', viajerosVal);

      // Redirigir con los valores codificados para la URL
      window.location.href = `././views/rutas.eg/index.php?origen=${encodeURIComponent(origenVal)}&destino=${encodeURIComponent(destinoVal)}&viajeros=${encodeURIComponent(viajerosVal)}&fecha=${fechaVal}&hora=${horaVal}`;
    }
  });
});
