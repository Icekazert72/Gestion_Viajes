const Boton = document.querySelectorAll('.btnTicket #btn');

Boton.forEach(function (btn) {
    btn.addEventListener('click', function () {
        let id_btn = btn.getAttribute('data-id-boton');
        console.log('Botón ' + id_btn);

        // Encontrar la tarjeta donde se encuentra el botón
        const card = btn.closest('.cardContainer');

        // Obtener el precio
        const precioText = card.querySelector('.precio p').textContent.trim();
        const precio = precioText.split(' ')[0]; // solo el número

        // Obtener horarios
        const horaIni = card.querySelector('#ini').textContent.trim();
        const horaFin = card.querySelector('#fin').textContent.trim();

        // Obtener número de bus
        const numBus = card.querySelector('#num_bus').textContent.trim();

        // Obtener nombre de la agencia
        const agencia = card.querySelector('#agencia').textContent.trim();

        // Guardar en localStorage
        localStorage.setItem('precio', precio);
        localStorage.setItem('hora_ini', horaIni);
        localStorage.setItem('hora_fin', horaFin);
        localStorage.setItem('num_bus', numBus);
        localStorage.setItem('agencia', agencia); // <-- NUEVA LÍNEA

        // Obtener datos anteriores
        const origen = localStorage.getItem('origen');
        const destino = localStorage.getItem('destino');
        const viajeros = localStorage.getItem('viajeros');

        // Redirigir
        window.location.href = `../../views/procesode_reserva/servicio_tipo.php?origen=${origen}&destino=${destino}&viajeros=${viajeros}&ruta_id=${id_btn}`;
    });
});


