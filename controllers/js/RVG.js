function abrirResumenReserva() {
  // Recuperar datos del localStorage
  const viaje_id = localStorage.getItem('viaje_id');
  const origen = localStorage.getItem('origen');
  const destino = localStorage.getItem('destino');
  const viajeros = localStorage.getItem('viajeros');
  const tipo = localStorage.getItem('tipo');
  const precio = localStorage.getItem('precio');
  const precioAdicional = localStorage.getItem('precio_servicio') || 0;
  const precioTotal = localStorage.getItem('precio_total');
  const hora_ini = localStorage.getItem('hora_ini');
  const hora_fin = localStorage.getItem('hora_fin');
  const num_bus = localStorage.getItem('num_bus');
  const agencia = localStorage.getItem('agencia');
  const id_agencia = localStorage.getItem('id_agencia');

  // Verificar que haya datos
  if (!viaje_id || !origen || !destino || !viajeros || !tipo || !precioTotal) {
    alert("Faltan datos para mostrar el resumen.");
    return;
  }

  // Crear el contenido HTML
  const contenido = `
    <html>
      <head>
        <title>Resumen de Reserva</title>
        <style>
          body { font-family: Arial, sans-serif; padding: 20px; }
          h2 { color: #333; }
          table { width: 100%; border-collapse: collapse; margin-top: 20px; }
          td, th { padding: 10px; border: 1px solid #ccc; text-align: left; }
          .btn-print {
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
          }
        </style>
      </head>
      <body>
        <h2>Resumen de tu Reserva</h2>
        <table>
          <tr><th>Origen</th><td>${origen}</td></tr>
          <tr><th>Destino</th><td>${destino}</td></tr>
          <tr><th>Agencia</th><td>${agencia}</td></tr>
          <tr><th>Bus</th><td>${num_bus}</td></tr>
          <tr><th>Hora de salida</th><td>${hora_ini}</td></tr>
          <tr><th>Hora de llegada</th><td>${hora_fin}</td></tr>
          <tr><th>Tipo de Servicio</th><td>${tipo}</td></tr>
          <tr><th>Precio Base</th><td>${precio} XAF</td></tr>
          <tr><th>Precio Adicional</th><td>${precioAdicional} XAF</td></tr>
          <tr><th>Precio Total</th><td><strong>${precioTotal} XAF</strong></td></tr>
          <tr><th>Viajeros</th><td>${viajeros}</td></tr>
          <tr><th>ID de Agencia</th><td>${id_agencia}</td></tr>
        </table>
        <button class="btn-print" onclick="window.print()">Imprimir</button>
      </body>
    </html>
  `;

  // Abrir nueva ventana y escribir el contenido
  const nuevaVentana = window.open('', '_blank', 'width=800,height=600');
  nuevaVentana.document.open();
  nuevaVentana.document.write(contenido);
  nuevaVentana.document.close();
}

function mostrarInfoUsuario() {
  const xhr = new XMLHttpRequest();
  xhr.open('GET', '../../models/publicControler/RVG.php', true); // AJUSTA LA RUTA según ubicación

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      try {
        const usuario = JSON.parse(xhr.responseText);
        console.log(xhr.responseText);


        if (usuario.error) {
          alert(usuario.error);
          return;
        }

        // Mostrar los datos en nueva ventana
        const contenido = `
          <html>
            <head>
              <title>Datos del Usuario</title>
              <style>
                body { font-family: Arial, sans-serif; padding: 20px; }
                h2 { color: #333; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                td, th { padding: 10px; border: 1px solid #ccc; text-align: left; }
                img { max-width: 100px; border-radius: 5px; }
              </style>
            </head>
            <body>
              <h2>Información del Usuario</h2>
              <table>
                <tr><th>ID</th><td>${usuario.id}</td></tr>
                <tr><th>Nombre</th><td>${usuario.nombre}</td></tr>
                <tr><th>Apellidos</th><td>${usuario.apellidos}</td></tr>
                <tr><th>Edad</th><td>${usuario.edad}</td></tr>
                <tr><th>DNI</th><td>${usuario.DNI}</td></tr>
                <tr><th>Email</th><td>${usuario.email}</td></tr>
                <tr><th>Teléfono</th><td>${usuario.telefono}</td></tr>
                <tr><th>Imagen</th><td><img src="../../img/usuarios/${usuario.imagen}" alt="Imagen de usuario"></td></tr>
              </table>
            </body>
          </html>
        `;

        const nuevaVentana = window.open('', '_blank', 'width=700,height=500');
        nuevaVentana.document.open();
        nuevaVentana.document.write(contenido);
        nuevaVentana.document.close();
      } catch (e) {
        alert('Error procesando la respuesta del servidor');
      }
    }
  };

  xhr.send();
}

function pagoPresencial() {
  realizarReserva();
}

function iniciarPagoEnLinea() {
  document.getElementById('mini-overlay').style.display = 'block';
}

function confirmarTieneCuenta() {
  document.getElementById('mini-overlay').style.display = 'none';
  document.getElementById('formMuni').style.display = 'block';
}

function cancelarPorFaltaCuenta() {
  document.getElementById('mini-overlay').style.display = 'none';
  showToastWithOptions("⚠️ Para pagar en línea debes tener cuenta Muni Dinero. ¿Quieres realizar el pago presencial?");
}

// Validación en tiempo real
function validarCampo(id, iconId, tipo = "text") {
  const input = document.getElementById(id);
  const icon = document.getElementById(iconId);
  input.addEventListener('keyup', () => {
    const valor = input.value.trim();
    let valido = false;

    if (tipo === "text") valido = valor.length >= 3;
    if (tipo === "dni") valido = /^\d{6,15}$/.test(valor);
    if (tipo === "tel") valido = /^\+?\d{6,15}$/.test(valor);

    input.classList.toggle('valid', valido);
    input.classList.toggle('invalid', !valido);

    icon.innerHTML = valido
      ? '<i class="fas fa-check-circle text-success"></i>'
      : '<i class="fas fa-times-circle text-danger"></i>';
  });
}

validarCampo('nombre', 'icon-nombre', 'text');
validarCampo('dni', 'icon-dni', 'dni');
validarCampo('telefono', 'icon-telefono', 'tel');

document.getElementById('formMuni').addEventListener('submit', function (e) {
  e.preventDefault();

  const nombre = document.getElementById('nombre').value;
  const dni = document.getElementById('dni').value;
  const telefono = document.getElementById('telefono').value;
  const destino = document.getElementById('destino_envio').value;
  const contacto = document.getElementById('contacto_agencia').value;
  const cantidad = document.getElementById('cantidad').value;

  realizarReservaEnLinea();

  this.reset();
});

function realizarReserva() {
  const viaje_id = localStorage.getItem('viaje_id');
  const tipo_servicio = localStorage.getItem('tipo');
  const agencia_id = localStorage.getItem('id_agencia');
  const tutor_id = localStorage.getItem('tutor_id') || null;

  if (!viaje_id || !tipo_servicio || !agencia_id) {
    alert("Faltan datos importantes para realizar la reserva.");
    return;
  }

  const datos = new FormData();
  datos.append("viaje_id", viaje_id);
  datos.append("tipo_servicio", tipo_servicio);
  datos.append("agencia_id", agencia_id);
  if (tutor_id) datos.append("tutor_id", tutor_id);

  const xhr = new XMLHttpRequest();
  const btn = document.getElementById('btnPagoPresencial');

  xhr.open('POST', '../../models/publicControler/ReservaPresencial.php', true);

  xhr.onload = function () {
    if (xhr.status === 200) {
      try {
        const res = JSON.parse(xhr.responseText);

        if (res.success) {
          // Mostrar spinner en el botón
          btn.innerHTML = `<span class="spinner-border spinner-border-sm text-success" role="status" aria-hidden="true"></span> Procesando...`;
          btn.disabled = true;

          // Después de 3 segundos, mostrar "Listo"
          setTimeout(() => {
            btn.innerHTML = 'Listo';
            btn.classList.remove('btn-outline-success');
            btn.classList.add('btn-success');
          }, 3000);

          // Mostrar toast después de otros 3 segundos
          setTimeout(() => {
            const toast = document.getElementById('toastHistorial');
            toast.style.display = 'block';
            const bootstrapToast = new bootstrap.Toast(toast);
            bootstrapToast.show();
          }, 6000);

        } else {
          // ⚠️ Si la reserva ya existe u otro error
          btn.innerHTML = res.message.includes("Ya tienes una reserva")
            ? "⚠️ Reserva ya existe"
            : "❌ Error en la reserva";

          btn.classList.remove('btn-outline-success');
          btn.classList.add('btn-warning');
          btn.disabled = false;

          // Restaurar texto original tras 3 segundos
          setTimeout(() => {
            btn.innerHTML = 'Pago Presencial';
            btn.classList.remove('btn-warning');
            btn.classList.add('btn-outline-success');
          }, 3000);
        }

      } catch (e) {
        btn.innerHTML = '❌ Error inesperado';
        btn.classList.add('btn-danger');
        btn.disabled = false;
        console.error("Error procesando JSON:", e);
      }
    } else {
      btn.innerHTML = '❌ Error servidor';
      btn.classList.add('btn-danger');
      btn.disabled = false;
      console.error("Error al conectar con el servidor:", xhr.status);
    }
  };

  xhr.send(datos);
}
function realizarReservaEnLinea() {
  const viaje_id = localStorage.getItem('viaje_id');
  const tipo_servicio = localStorage.getItem('tipo');
  const agencia_id = localStorage.getItem('id_agencia');
  const tutor_id = localStorage.getItem('tutor_id') || null;

  const nombre = document.getElementById('nombre').value.trim();
  const dni = document.getElementById('dni').value.trim();
  const telefono = document.getElementById('telefono').value.trim();
  const btn = document.querySelector('#formMuni button[type="submit"]');

  // Validación básica
  if (!viaje_id || !tipo_servicio || !agencia_id || !nombre || !dni || !telefono) {
    btn.innerHTML = '⚠️ Faltan datos';
    btn.classList.remove('btn-primary');
    btn.classList.add('btn-warning');

    setTimeout(() => {
      btn.innerHTML = 'Enviar Pago';
      btn.classList.remove('btn-warning');
      btn.classList.add('btn-primary');
    }, 3000);
    return;
  }

  const datos = new FormData();
  datos.append("viaje_id", viaje_id);
  datos.append("tipo_servicio", tipo_servicio);
  datos.append("agencia_id", agencia_id);
  datos.append("nombre", nombre);
  datos.append("dni", dni);
  datos.append("telefono", telefono);
  if (tutor_id) datos.append("tutor_id", tutor_id);

  // Mostrar spinner
  btn.innerHTML = `<span class="spinner-border spinner-border-sm text-light me-2" role="status" aria-hidden="true"></span>Procesando...`;
  btn.disabled = true;

  const xhr = new XMLHttpRequest();
  xhr.open('POST', '../../models/publicControler/ReservaEnLinea.php', true);

  xhr.onload = function () {
    if (xhr.status === 200) {
      try {
        const res = JSON.parse(xhr.responseText);

        if (res.success) {
          btn.innerHTML = '✅ Compra realizada';
          btn.classList.remove('btn-primary');
          btn.classList.add('btn-success');

          const toast = document.getElementById('toastHistorial');
          toast.querySelector('.toast-text').innerText =
            `🎉 ¡Compra realizada con éxito!`;
          toast.style.display = 'block';
          const bootstrapToast = new bootstrap.Toast(toast);
          bootstrapToast.show();

          setTimeout(() => {
            btn.innerHTML = 'Enviar Pago';
            btn.classList.remove('btn-success');
            btn.classList.add('btn-primary');
            btn.disabled = false;
          }, 5000);
        } else {
          btn.innerHTML = res.message.includes("reserva")
            ? "⚠️ Reserva ya existe"
            : "❌ Error en la reserva";
          btn.classList.remove('btn-primary');
          btn.classList.add('btn-danger');
          btn.disabled = false;

          setTimeout(() => {
            btn.innerHTML = 'Enviar Pago';
            btn.classList.remove('btn-danger');
            btn.classList.add('btn-primary');
          }, 3000);
        }
      // ...existing code...
      } catch (e) {
        console.error("Error procesando JSON:", e);
        btn.innerHTML = '❌ Error inesperado';
        // Mostrar la respuesta cruda para depuración
        console.log('Respuesta recibida:', xhr.responseText);

        btn.classList.add('btn-danger');
        btn.disabled = false;
        setTimeout(() => {
          btn.innerHTML = 'Enviar Pago';
          btn.classList.remove('btn-danger');
          btn.classList.add('btn-primary');
        }, 3000);
      }
    } else {
      console.error("Error al conectar con el servidor:", xhr.status);
      btn.innerHTML = '❌ Error de red';
      btn.classList.add('btn-danger');
      btn.disabled = false;
      setTimeout(() => {
        btn.innerHTML = 'Enviar Pago';
        btn.classList.remove('btn-danger');
        btn.classList.add('btn-primary');
      }, 3000);
    }
  };

  xhr.send(datos);
}

function showToast(message, duration = 4000) {
  const toast = document.getElementById("toast");
  const toastMsg = document.getElementById("toast-message");

  toastMsg.textContent = message;
  toast.classList.remove("hidden");
  toast.classList.add("show");

  setTimeout(() => {
    toast.classList.remove("show");
    setTimeout(() => {
      toast.classList.add("hidden");
    }, 400); // Esperar a que termine la animación
  }, duration);
}

function showToastWithOptions(message) {
  const toast = document.getElementById("toastOpcion");
  const toastMsg = document.getElementById("toast-message-opcion");

  toastMsg.textContent = message;
  toast.classList.remove("hidden");
  toast.classList.add("show");
}

function handlePresencial(confirm) {
  const toast = document.getElementById("toastOpcion");
  toast.classList.remove("show");
  setTimeout(() => {
    toast.classList.add("hidden");
  }, 400);

  if (confirm) {
    // Acción si elige "Sí"
    showToast('Usuario eligió pago presencial');
    pagoPresencial();
  } else {
    // Acción si elige "No"
    showToast("Usuario canceló el pago presencial");
  }
}



checkEdadPrincipal();

function checkEdadPrincipal() {
  const xhr = new XMLHttpRequest();
  xhr.open("GET", "../../models/publicControler/checkEdadPrincipal.php", true);
  xhr.onload = () => {
    try {
      const res = JSON.parse(xhr.responseText);

      if (res.error) {
        alert("Error: " + res.error);
        return;
      }

      if (res.menor && !res.tutorRegistrado) {
        showTutorForm();
      } else {
        checkNumPasajeros();
      }
    } catch (e) {
      console.error("Respuesta no es JSON válido:", xhr.responseText);
      alert("Error inesperado del servidor.");
    }
  };
  xhr.onerror = () => {
    alert("Error de conexión con el servidor.");
  };
  xhr.send();
}


function showTutorForm() {
  const container = document.getElementById("formsContainer");
  container.innerHTML = `
    <div class="card shadow-sm p-4 mb-4 animate__animated animate__fadeIn">
      <h5>Registrar Tutor Legal</h5>
      <form id="tutorForm">
        <div class="mb-3"><label>Nombre</label><input class="form-control" name="nombre" required></div>
        <div class="mb-3"><label>Apellidos</label><input class="form-control" name="apellidos" required></div>
        <div class="mb-3"><label>Teléfono</label><input class="form-control" name="telefono" required></div>
        <div class="mb-3"><label>DNI</label><input class="form-control" name="dni" required></div>
        <button class="btn btn-success" type="submit">Registrar Tutor</button>
      </form>
    </div>`;

  document.getElementById("tutorForm").addEventListener("submit", e => {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);
    sendTutor(formData);
  });
}

function sendTutor(formData) {
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "../../models/publicControler/registerTutor.php", true);
  xhr.onload = () => {
    const res = JSON.parse(xhr.responseText);
    console.log(xhr.responseText);

    if (res.success) {
      animateOut("tutorForm", checkNumPasajeros);
      console.log(xhr.responseText);
    }
    console.log(xhr.responseText);
  };
  xhr.send(formData);
}

function checkNumPasajeros() {
  const viajeros = parseInt(localStorage.getItem("viajeros")) || 1;
  if (viajeros > 1) showPasajerosForm(viajeros);
}

function showPasajerosForm(viajeros) {
  const container = document.getElementById("formsContainer");
  const viaje_id = localStorage.getItem("viaje_id"); // 👈 obtener desde localStorage

  let html = `
    <div class="card shadow-sm p-4 mb-4 animate__animated animate__fadeIn">
      <h5>Datos de Acompañantes</h5>
      <form id="pasajerosForm">
        <input type="hidden" name="viaje_id" value="${viaje_id}">
  `;

  for (let i = 2; i <= viajeros; i++) {
    html += `
      <div class="border p-3 mb-3">
        <h6>Pasajero ${i}</h6>
        <div class="mb-2"><label>Nombre</label><input class="form-control" name="nombre" required></div>
        <div class="mb-2"><label>Apellidos</label><input class="form-control" name="apellidos" required></div>
        <div class="mb-2"><label>Edad</label><input type="number" class="form-control" name="edad" required></div>
        <div class="mb-2"><label>Teléfono</label><input class="form-control" name="telefono" required></div>
      </div>`;
  }

  html += `<button class="btn btn-primary" type="submit">Guardar Acompañantes</button></form></div>`;
  container.innerHTML = html;

  document.getElementById("pasajerosForm").addEventListener("submit", e => {
    e.preventDefault();
    const formData = new FormData(e.target);
    sendPasajeros(formData);
  });
}


function sendPasajeros(formData) {
  const viajeId = localStorage.getItem('viaje_id');

  if (!viajeId) {
    alert("No se encontró el ID del viaje.");
    return;
  }

  // Agregar el ID del viaje al formulario
  formData.append('viaje_id', viajeId);

  const xhr = new XMLHttpRequest();
  xhr.open("POST", "../../models/publicControler/registerPasajeros.php", true);
  xhr.onload = () => {
    const res = JSON.parse(xhr.responseText);
    if (res.success) {
      animateOut("pasajerosForm", () => showToast("Datos guardados. Continuar reserva."));
    } else {
      showToast("Error al guardar los datos de acompañantes." + xhr.responseText);
      console.log(xhr.responseText);
    }
  };
  xhr.send(formData);
}



function animateOut(formId, callback) {
  const form = document.getElementById(formId).parentNode;
  form.classList.replace("animate__fadeIn", "animate__fadeOut");
  setTimeout(() => {
    form.remove();
    callback();
  }, 500);
}
