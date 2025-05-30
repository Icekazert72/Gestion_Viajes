

document.addEventListener("DOMContentLoaded", () => {
  const origen = document.getElementById("input_de");
  const destino = document.getElementById("input_a");
  const viajeros = document.getElementById("input_viajeros");
  const fecha = document.getElementById("input_fecha");
  const submit = document.getElementById("submit");

  const mensajeH4 = document.querySelector(".formDIreccion h4");

  const direccionRegex = /^[a-zA-Z0-9\s,.\-ºª]+$/;

  function marcarInput(input, icon, valido) {
    input.classList.toggle("input-valid", valido);
    input.classList.toggle("input-error", !valido);
    icon.style.color = valido ? "green" : "red";
  }

  function getIconFromInput(input) {
    return input.closest(".input-group").querySelector("i");
  }

  function validateAll() {
    const valOrigen = origen.value.trim();
    const valDestino = destino.value.trim();
    const valViajeros = viajeros.value.trim();
    const valFecha = fecha.value.trim();

    let mensaje = "";
    let valid = true;

    // Validar origen
    const iconOrigen = getIconFromInput(origen);
    const isOrigenValid = valOrigen !== "" && direccionRegex.test(valOrigen);
    marcarInput(origen, iconOrigen, isOrigenValid);
    if (!isOrigenValid) {
      mensaje = "Por favor, escribe tu lugar de origen correctamente.";
      valid = false;
    }

    // Validar destino
    const iconDestino = getIconFromInput(destino);
    const isDestinoValid = valDestino !== "" && direccionRegex.test(valDestino);
    marcarInput(destino, iconDestino, isDestinoValid);
    if (valid && !isDestinoValid) {
      mensaje = "Por favor, escribe tu destino correctamente.";
      valid = false;
    }

    // Validar viajeros
    const iconViajeros = getIconFromInput(viajeros);
    const numViajeros = parseInt(valViajeros);
    const isViajerosValid = !isNaN(numViajeros) && numViajeros > 0;
    marcarInput(viajeros, iconViajeros, isViajerosValid);
    if (valid && !isViajerosValid) {
      mensaje = "Indica cuántos viajeros van contigo.";
      valid = false;
    }

    // Validar fecha
    const iconFecha = getIconFromInput(fecha);
    const fechaVal = new Date(valFecha);
    const isFechaValid = valFecha !== "" && !isNaN(fechaVal.getTime()) && fechaVal > new Date();
    marcarInput(fecha, iconFecha, isFechaValid);
    if (valid && !isFechaValid) {
      mensaje = "Selecciona una fecha y hora válidas para tu viaje.";
      valid = false;
    }

    // Verificar si todo está vacío
    if (
      valOrigen === "" &&
      valDestino === "" &&
      valViajeros === "" &&
      valFecha === ""
    ) {
      mensaje = "Por favor, completa todos los campos para buscar tu ruta.";
      valid = false;
    }

    mensajeH4.textContent = mensaje || "¿Cuál es tu ruta?";
    return valid;
  }

  submit.addEventListener("click", (e) => {
    e.preventDefault();

    const todoValido = validateAll();

    if (todoValido) {
      const origenVal = origen.value.trim();
      const destinoVal = destino.value.trim();
      const viajerosVal = viajeros.value.trim();
      const fechaHora = new Date(fecha.value);
      const fechaVal = fechaHora.toISOString().split("T")[0];
      const horaVal = fechaHora.toTimeString().split(":").slice(0, 2).join(":");

      // Guardar en localStorage
      localStorage.setItem("origen", origenVal);
      localStorage.setItem("destino", destinoVal);
      localStorage.setItem("viajeros", viajerosVal);

      // Redirigir
      window.location.href = `././views/rutas.eg/index.php?origen=${encodeURIComponent(
        origenVal
      )}&destino=${encodeURIComponent(
        destinoVal
      )}&viajeros=${encodeURIComponent(
        viajerosVal
      )}&fecha=${fechaVal}&hora=${horaVal}`;
    }
  });
});
