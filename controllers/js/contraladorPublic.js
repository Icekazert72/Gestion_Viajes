

function cargarAgencias() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '../../models/publicControler/mostrar_agencias.php', true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var agencias = JSON.parse(xhr.responseText);
            mostrarAgencias(agencias);
        }
    };
    xhr.send();
}

function mostrarAgencias(agencias) {
    var contenedor = document.getElementById('containerCard');
    contenedor.innerHTML = '';

    agencias.forEach(function (agencia) {
        var html = `
        <div class="contenedor-agencia mt-4 mb-4">
            <div class="content_logo">
                <div class="logo_text">
                    <h5 title="Texto del logo">${agencia.nombre || 'Agencia'}</h5>
                </div>
                <div class="logo">
                    <div title="Logo" class="img_logo">
                        <img src="${agencia.imagen ? agencia.imagen : '../../img/index/images.png'}" alt="">
                    </div>
                </div>
                <div class="logo_Bandera">
                    <img src="../../img/index/bandera.png" alt="">
                </div>
            </div>

            <div class="content_descripcion">
                <div class="descripcion">
                    <h5>Descripción</h5>
                    <div class="texto-scroll-vertical">
                        <p>${agencia.descripcion || 'Sin descripción.'}</p>
                    </div>
                </div>
            </div>

            <div class="content_localizacion">
                <div class="social">
                    <a href="#"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#"><i class="fa-brands fa-twitch"></i></a>
                    <a href="https://wa.me/${agencia.telefono ? agencia.telefono.replace(/[^0-9]/g, '') : ''}" target="_blank"><i class="fa-brands fa-whatsapp"></i></a>
                </div>
                <div class="contacto">
                    <p>${agencia.telefono || 'Sin teléfono'}</p>
                </div>
                <div class="email">
                    <p>${agencia.email || 'Sin email'}</p>
                </div>
                <div class="ubicacion">
                    <div class="ubicacion_texto">
                        <h5>Ubicacion</h5>
                    </div>
                    <div class="ubicacion_icono">
                        <div>${agencia.direccion || 'Sin dirección'}</div>
                        <div><i class="fa-solid fa-location-dot"></i></div>
                    </div>
                </div>
            </div>

            <div class="content_ubicacionMapa">
                <!-- Aquí puedes personalizar el mapa según la dirección si tienes lat/lon en la tabla -->
                <iframe
                    src="https://www.google.com/maps?q=${encodeURIComponent(agencia.direccion || '')}&output=embed"
                    width="100%"
                    height="100%"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>

            <div class="content_ticket">
                <a href="rutas_agencias.php?id=${agencia.id}" class="btn_ticket">Obtener Ticket</a>
            </div>
        </div>
        `;
        contenedor.innerHTML += html;
    });
}

window.onload = cargarAgencias;