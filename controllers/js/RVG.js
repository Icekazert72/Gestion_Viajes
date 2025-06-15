function abrirResumenReserva() {
  // Recuperar datos del localStorage
  const viaje_id     = localStorage.getItem('viaje_id');
  const origen       = localStorage.getItem('origen');
  const destino      = localStorage.getItem('destino');
  const viajeros     = localStorage.getItem('viajeros');
  const tipo         = localStorage.getItem('tipo');
  const precio       = localStorage.getItem('precio');
  const precioAdicional = localStorage.getItem('precio_servicio') || 0;
  const precioTotal  = localStorage.getItem('precio_total');
  const hora_ini     = localStorage.getItem('hora_ini');
  const hora_fin     = localStorage.getItem('hora_fin');
  const num_bus      = localStorage.getItem('num_bus');
  const agencia      = localStorage.getItem('agencia');

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

