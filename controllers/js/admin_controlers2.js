document.querySelectorAll('.dock-btn').forEach((btn) => {
    btn.addEventListener('click', () => {
        const nombre = btn.dataset.nombre;
        const ventana = document.querySelector(`.window_${nombre}`);
        const main = document.getElementById('contenido');

        // Mostrar el contenedor principal
        main.style.display = 'block';

        // NO ocultamos otras ventanas
        // Ocultamos ícono minimizado si ya existe
        const icono = document.querySelector(`.minimized-icon[data-target="window_${nombre}"]`);
        if (icono) icono.remove();

        // Mostrar la ventana correspondiente si no está ya visible
        if (ventana && ventana.style.display !== 'flex') {
            ventana.style.display = 'flex';
            ventana.style.width = '60%';
            ventana.style.height = '60%';
            ventana.style.top = '20%';
            ventana.style.left = '20%';
        }
    });
});



// Cerrar ventana
document.querySelectorAll('.btn-close').forEach(btn => {
    btn.addEventListener('click', () => {
        const win = btn.closest('.window');
        win.style.display = 'none';

        // Eliminar ícono minimizado si existe
        const icono = document.querySelector(`.minimized-icon[data-target="${win.classList[1]}"]`);
        if (icono) icono.remove();

        // Ocultar el main si no hay ninguna ventana visible
        const visible = [...document.querySelectorAll('.window')].some(w => w.style.display !== 'none');
        if (!visible) {
            document.getElementById('contenido').style.display = 'none';
        }
    });
});

// Minimizar ventana
document.querySelectorAll('.btn-minimize').forEach(btn => {
    btn.addEventListener('click', () => {
        const win = btn.closest('.window');
        const nombreClase = win.classList[1]; // window_agencias, etc.
        const title = win.querySelector('.window-header span').textContent;

        win.style.display = 'none';

        // Crear ícono minimizado
        const icon = document.createElement('div');
        icon.className = 'minimized-icon';
        icon.textContent = title;
        icon.dataset.target = nombreClase;

        // Al hacer clic en el icono, restaurar la ventana
        icon.addEventListener('click', () => {
            win.style.display = 'flex';
            icon.remove();
        });

        document.getElementById('ventanas-minimizadas').appendChild(icon);
    });
});

// Maximizar ventana
document.querySelectorAll('.btn-maximize').forEach(btn => {
    btn.addEventListener('click', () => {
        const win = btn.closest('.window');

        if (win.classList.contains('maximized')) {
            // Restaurar a tamaño medio
            win.classList.remove('maximized');
            win.style.width = '60%';
            win.style.height = '60%';
            win.style.top = '20%';
            win.style.left = '20%';
        } else {
            // Maximizar al 100%
            win.classList.add('maximized');
            win.style.width = '100%';
            win.style.height = '100%';
            win.style.top = '0';
            win.style.left = '0';
        }
    });
});


// Hacer que las ventanas se puedan arrastrar por su header
document.querySelectorAll('.window').forEach(win => {
    const header = win.querySelector('.window-header');

    let isDragging = false;
    let offsetX, offsetY;

    header.addEventListener('mousedown', (e) => {
        isDragging = true;
        const rect = win.getBoundingClientRect();
        offsetX = e.clientX - rect.left;
        offsetY = e.clientY - rect.top;
        win.style.zIndex = 1000; // Traer al frente
        win.style.transition = 'none'; // Sin animaciones al mover
    });

    document.addEventListener('mousemove', (e) => {
        if (isDragging) {
            const cont = document.getElementById('contenido');
            const contRect = cont.getBoundingClientRect();

            let x = e.clientX - offsetX - contRect.left;
            let y = e.clientY - offsetY - contRect.top;

            // Limitar movimiento dentro del contenedor
            const maxX = cont.clientWidth - win.offsetWidth;
            const maxY = cont.clientHeight - win.offsetHeight;

            x = Math.max(0, Math.min(x, maxX));
            y = Math.max(0, Math.min(y, maxY));

            win.style.left = x + 'px';
            win.style.top = y + 'px';
        }
    });

    document.addEventListener('mouseup', () => {
        isDragging = false;
    });
});




document.getElementById('btnNuevoUsuarios').addEventListener('click', () => {
    document.getElementById('formRegistroUsuario').classList.remove('d-none');
    document.getElementById('formRegistroEmpleado').classList.add('d-none');
    document.getElementById('tablaUsuarios').classList.add('d-none');
    document.getElementById('tablaCliendo').classList.add('d-none');
});

document.getElementById('btnusuarios').addEventListener('click', ()=> {
    document.getElementById('formRegistroUsuario').classList.add('d-none');
    document.getElementById('tablaUsuarios').classList.remove('d-none');
    document.getElementById('formRegistroEmpleado').classList.add('d-none');
    document.getElementById('tablaCliendo').classList.add('d-none');
});

document.getElementById('cancelar-usuario').addEventListener('click', () => {
    document.getElementById('formRegistroUsuario').classList.add('d-none');
    document.getElementById('tablaUsuarios').classList.remove('d-none');
    document.getElementById('tablaCliendo').classList.add('d-none');
    document.getElementById('formRegistroEmpleado').classList.add('d-none');
    document.getElementById('formRegistroUsuario').reset();
});
document.getElementById('btnClientes').addEventListener('click', () => {
    document.getElementById('formRegistroUsuario').classList.add('d-none');
    document.getElementById('tablaUsuarios').classList.add('d-none');
    document.getElementById('tablaCliendo').classList.remove('d-none');
    document.getElementById('formRegistroEmpleado').classList.add('d-none');
});

document.getElementById('btnFrecuentes').addEventListener('click', () => {
    document.getElementById('frecuentes').classList.remove('d-none');
    document.getElementById('formRutas').classList.add('d-none');
    document.getElementById('rutas').classList.add('d-none');
    document.getElementById('regional').classList.add('d-none');
    document.getElementById('populares').classList.add('d-none');
});

document.getElementById('btnTodasRutas').addEventListener('click', () => {
    document.getElementById('frecuentes').classList.add('d-none');
    document.getElementById('formRutas').classList.add('d-none');
    document.getElementById('rutas').classList.remove('d-none');
    document.getElementById('regional').classList.add('d-none');
    document.getElementById('populares').classList.add('d-none');
});
document.getElementById('btnMasRutas').addEventListener('click', () => {
    document.getElementById('frecuentes').classList.add('d-none');
    document.getElementById('formRutas').classList.remove('d-none');
    document.getElementById('rutas').classList.add('d-none');
    document.getElementById('regional').classList.add('d-none');
    document.getElementById('populares').classList.add('d-none');
    console.log('');
    
});
document.getElementById('btnPopulares').addEventListener('click', () => {
    document.getElementById('frecuentes').classList.add('d-none');
    document.getElementById('formRutas').classList.add('d-none');
    document.getElementById('rutas').classList.add('d-none');
    document.getElementById('regional').classList.add('d-none');
    document.getElementById('populares').classList.remove('d-none');
});
document.getElementById('btnRegion').addEventListener('click', () => {
    document.getElementById('frecuentes').classList.add('d-none');
    document.getElementById('formRutas').classList.add('d-none');
    document.getElementById('regional').classList.remove('d-none');
    document.getElementById('rutas').classList.add('d-none');
    document.getElementById('populares').classList.add('d-none');
});

document.getElementById('btnBuses').addEventListener('click', () => {
    document.getElementById('buses').classList.remove('d-none');
    document.getElementById('conductos').classList.add('d-none');
});
document.getElementById('btnConductores').addEventListener('click', () => {
    document.getElementById('buses').classList.add('d-none');
    document.getElementById('conductos').classList.remove('d-none');
});

document.getElementById('btnComprados').addEventListener('click', () => {
    document.getElementById('comprados').classList.remove('d-none');
    document.getElementById('reservados').classList.add('d-none');
    document.getElementById('cancelados').classList.add('d-none');
    document.getElementById('reservar').classList.add('d-none');
    document.getElementById('pendientes').classList.add('d-none');
});
document.getElementById('btnReservados').addEventListener('click', () => {
    document.getElementById('comprados').classList.add('d-none');
    document.getElementById('reservados').classList.remove('d-none');
    document.getElementById('cancelados').classList.add('d-none');
    document.getElementById('reservar').classList.add('d-none');
    document.getElementById('pendientes').classList.add('d-none');
});
document.getElementById('btnCancelar').addEventListener('click', () => {
    document.getElementById('comprados').classList.add('d-none');
    document.getElementById('reservados').classList.add('d-none');
    document.getElementById('cancelados').classList.remove('d-none');
    document.getElementById('reservar').classList.add('d-none');
    document.getElementById('pendientes').classList.add('d-none');
});
document.getElementById('btnReservar').addEventListener('click', () => {
    document.getElementById('comprados').classList.add('d-none');
    document.getElementById('reservados').classList.add('d-none');
    document.getElementById('cancelados').classList.add('d-none');
    document.getElementById('reservar').classList.remove('d-none');
    document.getElementById('pendientes').classList.add('d-none');
});
document.getElementById('btnPendientes').addEventListener('click', () => {
    document.getElementById('comprados').classList.add('d-none');
    document.getElementById('reservados').classList.add('d-none');
    document.getElementById('cancelados').classList.add('d-none');
    document.getElementById('reservar').classList.add('d-none');
    document.getElementById('pendientes').classList.remove('d-none');
});

document.getElementById('btnLista').addEventListener('click', () => {
    document.getElementById('tablaSeguimiento').classList.add('d-none');
    document.getElementById('tablaLista').classList.remove('d-none');
    document.getElementById('ContainerNuevoViaje').classList.add('d-none');
    document.getElementById('ContainerBuses').classList.add('d-none');
});
document.getElementById('btnSeguimiento').addEventListener('click', () => {
    document.getElementById('tablaSeguimiento').classList.remove('d-none');
    document.getElementById('tablaLista').classList.add('d-none');
        document.getElementById('ContainerNuevoViaje').classList.add('d-none');
    document.getElementById('ContainerBuses').classList.add('d-none');
});
document.getElementById('btnNuevoViaje').addEventListener('click', () => {
    document.getElementById('tablaSeguimiento').classList.add('d-none');
    document.getElementById('tablaLista').classList.add('d-none');
    document.getElementById('ContainerNuevoViaje').classList.remove('d-none');
    document.getElementById('ContainerBuses').classList.add('d-none');
});
document.getElementById('btnBusesAsientos').addEventListener('click', () => {
    document.getElementById('tablaSeguimiento').classList.add('d-none');
    document.getElementById('tablaLista').classList.add('d-none');
    document.getElementById('ContainerNuevoViaje').classList.add('d-none');
    document.getElementById('ContainerBuses').classList.remove('d-none');
}); 



function initMap() {
    // Crear mapa centrado en Guinea Ecuatorial
    const centro = { lat: 1.65, lng: 10.27 }; // Coordenadas generales de Guinea Ecuatorial

    const map = new google.maps.Map(document.getElementById("mapa"), {
        zoom: 7,
        center: centro,
    });

    // Servicio de rutas
    const directionsService = new google.maps.DirectionsService();
    const directionsRenderer = new google.maps.DirectionsRenderer({
        suppressMarkers: false,
        preserveViewport: true
    });
    directionsRenderer.setMap(map);

    // Coordenadas o nombres de ubicación
    const origen = "Malabo, Guinea Ecuatorial";
    const destino = "Bata, Guinea Ecuatorial";

    directionsService.route({
        origin: origen,
        destination: destino,
        travelMode: google.maps.TravelMode.DRIVING
    }, (response, status) => {
        if (status === "OK") {
            directionsRenderer.setDirections(response);
        } else {
            console.error("No se pudo mostrar la ruta: " + status);
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById('chartUsuarios').getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Forama', 'Kassav', 'Luther'],
            datasets: [{
                label: 'Usuarios transportados',
                data: [320, 270, 190],
                backgroundColor: ['#198754', '#0d6efd', '#6c757d'], // Verde, Azul, Gris
                borderRadius: 8,
                barThickness: 24,
                borderSkipped: false
            }]
        },
        options: {
            indexAxis: 'y', // Barras horizontales
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#212529',
                    titleColor: '#fff',
                    bodyColor: '#adb5bd',
                    borderColor: '#0d6efd',
                    borderWidth: 1
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: { color: '#6c757d', stepSize: 50 },
                    grid: { color: 'rgba(0,0,0,0.05)' }
                },
                y: {
                    ticks: { color: '#343a40', font: { size: 14, weight: 'bold' } },
                    grid: { display: false }
                }
            }
        }
    });
});
