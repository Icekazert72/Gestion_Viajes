
document.addEventListener("DOMContentLoaded", () => {
  const origen = document.getElementById("input_de");
  const destino = document.getElementById("input_a");
  const viajeros = document.getElementById("input_viajeros");
  const fecha = document.getElementById("input_fecha");
  const submit = document.getElementById("submit");

  const mensajeH4 = document.querySelector(".formDIreccion h4");

  const direccionRegex = /^[a-zA-Z0-9\s,.\-ºª]+$/;

  // Función para marcar el input con un estado de validación
  function marcarInput(input, icon, valido) {
    input.classList.toggle("input-valid", valido);
    input.classList.toggle("input-error", !valido);
    icon.style.color = valido ? "green" : "red";
  }

  // Obtener el icono relacionado con el input
  function getIconFromInput(input) {
    return input.closest(".input-group").querySelector("i");
  }

  // Validar todos los campos del formulario
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

  // Enviar la solicitud AJAX cuando se presiona el botón de enviar
  submit.addEventListener("click", (e) => {
    e.preventDefault();

    const todoValido = validateAll();
    if (!todoValido) return;

    const origenVal = origen.value.trim();
    const destinoVal = destino.value.trim();
    const viajerosVal = viajeros.value.trim();
    const fechaHora = new Date(fecha.value);
    const fechaVal = fechaHora.toISOString().split("T")[0];  // Obtener solo la fecha en formato Y-m-d
    const horaVal = fechaHora.toTimeString().split(":").slice(0, 2).join(":");  // Obtener solo la hora en formato H:i

    // Crear una nueva instancia de XMLHttpRequest para enviar datos
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "../../../Proyecto_0.1/models/publicControler/validarRuta.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Manejar la respuesta del servidor
    xhr.onload = function () {
      const titulo = document.getElementById("tituloRuta");
      try {
        // Intentar parsear la respuesta JSON
        const response = JSON.parse(xhr.responseText);
        
        if (xhr.status === 200) {
          if (response.existe) {
            // Si la ruta es válida, guardar los datos en localStorage y redirigir
            localStorage.setItem("origen", origenVal);
            localStorage.setItem("destino", destinoVal);
            localStorage.setItem("viajeros", viajerosVal);

            // Redirigir al usuario a la página de rutas disponibles
            window.location.href = `././views/rutas.eg/index.php?origen=${encodeURIComponent(origenVal)}&destino=${encodeURIComponent(destinoVal)}&viajeros=${encodeURIComponent(viajerosVal)}&fecha=${fechaVal}&hora=${horaVal}`;
          } else {
            // Si no hay rutas disponibles, mostrar el mensaje de error
            titulo.innerHTML = response.mensaje || "Ruta no encontrada o no disponible para el horario indicado.";
          }
        } else {
          // Si hay un error en el servidor, mostrar un mensaje de error
          titulo.innerHTML = "Error al verificar la ruta.";
        }
      } catch (e) {
        // Si no se puede parsear la respuesta como JSON, mostrar el error
        titulo.innerHTML = "Error al procesar la respuesta del servidor.";
        console.log(xhr.responseText );
        
      }
    };

    // Enviar los datos del formulario al servidor
    xhr.send(`origen=${encodeURIComponent(origenVal)}&destino=${encodeURIComponent(destinoVal)}&fecha=${fechaVal}&hora=${horaVal}`);
  });

});
