
function ReservasEstados() {
    const estadoActivo = document.querySelector('.filter-btn.active')?.dataset.filter.toLowerCase().trim() || 'pendiente';
    const contenedor = document.getElementById('contenedor-reservas');

    if (!contenedor) {
        console.error('❌ No se encontró el contenedor con ID "contenedor-reservas"');
        return;
    }

    const xhr = new XMLHttpRequest();
    xhr.open('GET', '../../models/PublicControler/ReservasEstado.php', true);

    xhr.onload = function () {

        contenedor.innerHTML = '';

        if (xhr.status === 200) {
            let reservas = [];

            try {
                reservas = JSON.parse(xhr.responseText);
                console.log('✅ Reservas recibidas:', reservas);
            } catch (e) {
                contenedor.innerHTML = '<div class="alert alert-danger">Respuesta inválida del servidor.</div>';
                return;
            }

            const reservasFiltradas = reservas.filter(r =>
                (r.estado_pago || '').toLowerCase().trim() === estadoActivo
            );

            if (!reservasFiltradas.length) {
                contenedor.innerHTML = `<div class="alert alert-warning">No tienes reservas <strong>${estadoActivo}</strong> actualmente.</div>`;
                return;
            }

            reservasFiltradas.forEach(r => {
                const estado = (r.estado_pago || '').toLowerCase().trim();
                const fecha = r.fecha_viaje;
                const servicio = r.tipo_servicio;
                const asiento = r.num_asiento_bus;
                const destino = `${r.origen} ➜ ${r.destino}`;

                const estadoInfo = {
                    pendiente: { color: 'warning', icon: 'clock', texto: 'Pendiente' },
                    confirmada: { color: 'primary', icon: 'circle-check', texto: 'Confirmada' },
                    finalizada: { color: 'success', icon: 'check-double', texto: 'Finalizada' },
                    cancelada: { color: 'danger', icon: 'ban', texto: 'Cancelada' },
                };

                const { color, icon, texto } = estadoInfo[estado] || {};

                const html = `
                    <div class="reserva-card mb-4" data-status="${estado}">
                        <div class="card border-start border-5 border-${color} shadow-sm rounded-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="text-${color} mb-0"><i class="fa-solid fa-${icon} me-2"></i> ${texto}</h5>
                                    <span class="badge bg-${color}-subtle text-${color}">${fecha}</span>
                                </div>
                                <p class="mb-1"><strong>Destino:</strong> ${destino}</p>
                                <p class="mb-1"><strong>Servicio:</strong> ${servicio}</p>
                                <p class="mb-3"><strong>Asiento:</strong> ${asiento}</p>
                                <div class="text-end">
                                    ${estado === 'pendiente' ? `<button class="btn btn-sm btn-outline-danger btn-cancelar" data-id="${r.id}"><i class="fa-solid fa-trash"></i> Cancelar</button>` : ''}
                                   ${estado === 'confirmada' ? `<button class="btn btn-sm btn-outline-secondary btn-ticket" data-id="${r.id}"><i class="fa-solid fa-eye"></i> Descargar Ticket</button>` : ''}

                                </div>
                            </div>
                        </div>
                    </div>
                `;

                contenedor.innerHTML += html;
            });

            // Botones cancelar
            document.querySelectorAll('.btn-cancelar').forEach(btn => {
                btn.addEventListener('click', () => {
                    const idReserva = btn.dataset.id;
                    if (confirm('¿Deseas cancelar esta reserva?')) {
                        const xhrCancel = new XMLHttpRequest();
                        xhrCancel.open('POST', '../../models/cancelar_reserva.php', true);
                        xhrCancel.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');

                        xhrCancel.onload = function () {
                            const resp = JSON.parse(xhrCancel.responseText);
                            if (resp.success) {
                                ReservasEstados();
                            } else {
                                alert('Error al cancelar la reserva.');
                            }
                        };

                        xhrCancel.send(JSON.stringify({ id: idReserva }));
                    }
                });
            });

            document.querySelectorAll('.btn-ticket').forEach(btn => {
                btn.addEventListener('click', () => {
                    const idReserva = btn.dataset.id;
                    // Redirige a un script PHP que genera el PDF y lo fuerza a descargarse
                    window.location.href = `../../models/PublicControler/descargar_ticket.php?id=${idReserva}`;
                });
            });

        } else {
            contenedor.innerHTML = '<div class="alert alert-danger">Error al cargar las reservas.</div>';
        }
    };

    xhr.onerror = function () {
        contenedor.innerHTML = '<div class="alert alert-danger">Error de red al cargar las reservas.</div>';
    };

    xhr.send();
}

// Eventos de los botones
document.querySelectorAll('.filter-btn').forEach(button => {
    button.addEventListener('click', () => {
        document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');
        ReservasEstados();
    });
});

// Cargar al iniciar
document.addEventListener('DOMContentLoaded', () => {
    ReservasEstados();
});
