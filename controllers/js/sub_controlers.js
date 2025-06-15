

document.addEventListener('DOMContentLoaded', () => {
    const formulario = document.getElementById('formRegistroUsuario');
    const campos = formulario.querySelectorAll('.campo-validacion');
    const animacion = document.getElementById('envioAnimacion');

    campos.forEach(campo => {
        campo.addEventListener('input', () => validarCampo(campo));
        campo.addEventListener('blur', () => validarCampo(campo));
    });

    function validarCampo(campo) {
        const icono = campo.parentElement.querySelector('.icono-validacion i');
        if (campo.checkValidity()) {
            icono.classList.remove('fa-circle', 'text-danger');
            icono.classList.add('fa-check-circle', 'text-success');
        } else {
            icono.classList.remove('fa-check-circle', 'text-success');
            icono.classList.add('fa-times-circle', 'text-danger');
        }
    }

    formulario.addEventListener('submit', (e) => {
        e.preventDefault();

        let valido = true;
        campos.forEach(campo => {
            if (!campo.checkValidity()) {
                validarCampo(campo);
                valido = false;
            }
        });

        if (!valido) return;

        const formData = new FormData(formulario);

        // Generar contraseña automática (5 dígitos numéricos aleatorios)
        const pass = String(Math.floor(Math.random() * 100000)).padStart(5, '0');
        formData.append('password_generada', pass);

        // Mostrar animación
        animacion.style.display = 'flex';

        // Simular envío con animación (3 segundos)
        setTimeout(() => {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '../../../models/usuarios_submin.php', true);

            xhr.onload = () => {
                animacion.style.display = 'none'; // Ocultar animación

                if (xhr.status === 200) {
                    alert(xhr.responseText);
                    formulario.reset();
                    document.querySelectorAll('.icono-validacion i').forEach(icono => {
                        icono.className = 'fas fa-circle';
                    });
                    GetRutas();
                } else {
                    alert("Error al enviar formulario.");
                }
            };

            xhr.send(formData);
        }, 3000);
    });
});

const form = document.getElementById('rutaForm');
const campos = ['origen', 'destino', 'horario', 'precio', 'region'];

// Función de validación individual
function validarCampo(input) {
    const validSpan = input.parentElement.querySelector('.valid-span');
    const invalidSpan = input.parentElement.querySelector('.invalid-span');

    if (input.checkValidity()) {
        input.classList.remove('is-invalid');
        input.classList.add('is-valid');
        validSpan.classList.remove('d-none');
        invalidSpan.classList.add('d-none');
        return true;
    } else {
        input.classList.remove('is-valid');
        input.classList.add('is-invalid');
        validSpan.classList.add('d-none');
        invalidSpan.classList.remove('d-none');
        return false;
    }
}
// Asignar evento keyup a todos los campos
campos.forEach(id => {
    const input = document.getElementById(id);
    input.addEventListener('keyup', () => validarCampo(input));
    input.addEventListener('change', () => validarCampo(input)); // Para select y otros
});
// Envío del formulario
form.addEventListener('submit', function (e) {
    e.preventDefault();
    let valido = true;

    // Validar todos los campos antes de enviar
    campos.forEach(id => {
        const input = document.getElementById(id);
        const esValido = validarCampo(input);
        if (!esValido) valido = false;
    });

    if (valido) {
        const origen = document.getElementById("origen").value.trim();
        const destino = document.getElementById("destino").value.trim();
        const horario = document.getElementById("horario").value;
        const precio = document.getElementById("precio").value;
        const region = document.getElementById("region").value;
        const agencia_id = document.getElementById("agencia_id").value;

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "../../../models/sub_min/SetRuta.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onload = function () {
            const contenedor = document.getElementById("respuestaRuta");
            if (this.status === 200) {
                contenedor.innerHTML = `<div class="alert alert-success">${this.responseText}</div>`;
                form.reset();
                GetRutas(); // Actualizar rutas después de enviar

                // Limpiar estilos después de enviar
                campos.forEach(id => {
                    const input = document.getElementById(id);
                    input.classList.remove('is-valid', 'is-invalid');
                    input.parentElement.querySelector('.valid-span').classList.add('d-none');
                    input.parentElement.querySelector('.invalid-span').classList.add('d-none');
                });
            } else {
                contenedor.innerHTML = `<div class="alert alert-danger">${this.responseText}</div>`;
            }
        };

        const datos = `origen=${encodeURIComponent(origen)}&destino=${encodeURIComponent(destino)}&horario=${encodeURIComponent(horario)}&precio=${encodeURIComponent(precio)}&region=${encodeURIComponent(region)}&agencia_id=${encodeURIComponent(agencia_id)}`;
        xhr.send(datos);
    }
});

// Cargar conductores al iniciar la página
document.addEventListener('DOMContentLoaded', () => {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', '../../../models/sub_min/selectConductor.php', true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            try {
                const data = JSON.parse(xhr.responseText);
                const selectConductor = document.getElementById('conductor');

                data.forEach(conductor => {
                    const option = document.createElement('option');
                    option.value = conductor.id;
                    option.textContent = conductor.nombre;
                    selectConductor.appendChild(option);
                });

            } catch (e) {
                console.error('Error al procesar la respuesta JSON:', e);
            }
        }
    };

    xhr.onerror = function () {
        console.error('Error de red al cargar los conductores.');
    };

    xhr.send();
});

// Cargar buses al iniciar la página
document.addEventListener('DOMContentLoaded', function () {
    const xhrBus = new XMLHttpRequest();
    xhrBus.open('GET', '../../../models/sub_min/selectBuses.php', true);
    xhrBus.onload = function () {
        if (xhrBus.status === 200) {
            try {
                const data = JSON.parse(xhrBus.responseText);
                const selectBus = document.getElementById('bus');

                data.forEach(bus => {
                    const option = document.createElement('option');
                    option.value = bus.id;
                    option.textContent = bus.nombre;
                    selectBus.appendChild(option);
                });
            } catch (e) {
                console.error("Error al parsear los buses:", e);
            }
        } else {
            console.error("Error en la solicitud de buses:", xhrBus.status);
        }
    };
    xhrBus.send();
});

function Asignar() {
    const conductor = document.getElementById("conductor").value;
    const bus = document.getElementById("bus").value;

    if (!conductor || !bus) {
        alert("Seleccione un conductor y un bus.");
        return;
    }

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "../../../models/sub_min/asignacion.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            alert(xhr.responseText); // Mensaje de confirmación
            document.getElementById("assignmentForm").reset();
        }
    };

    const datos = "conductor=" + encodeURIComponent(conductor) + "&bus=" + encodeURIComponent(bus);
    xhr.send(datos);
}

// Asociar la función Asignar al submit del formulario
document.getElementById("assignmentForm").addEventListener("submit", function (e) {
    e.preventDefault();
    Asignar();
});


function cargarAsignaciones() {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "../../../models/sub_min/GetAsignacion.php", true);

    xhr.onload = function () {
        if (this.status === 200) {
            const data = JSON.parse(this.responseText);
            console.log(xhr.responseText); // Para depuración   

            const contenedor = document.getElementById("asignaciones-contenedor");
            contenedor.innerHTML = ""; // Limpiar antes de insertar

            if (data.success && data.asignaciones.length > 0) {
                data.asignaciones.forEach(asignacion => {
                    const box = document.createElement("div");
                    box.classList.add("asignacion-box");

                    box.innerHTML = `
                        <div class="asignacion-header">
                            <h3>Asignación Activa</h3>
                            <button class="btn-cerrar" id="cerrarAsignados">&times;</button>
                        </div>
                        <div class="asignacion-body">
                            <div class="info-bloque"><span class="label">Conductor:</span><span class="valor">${asignacion.nombre}</span></div>
                            <div class="info-bloque"><span class="label">ID:</span><span class="valor">${asignacion.codigo_conductor}</span></div>
                            <div class="info-bloque"><span class="label">Bus Asignado:</span><span class="valor">${asignacion.numero_bus}</span></div>
                            <div class="info-bloque"><span class="label">Agencia:</span><span class="valor">${asignacion.agencia}</span></div>
                            <button class="btn-desasignar" onclick="desasignar(${asignacion.id_asignacion})">Desasignar</button>
                        </div>
                    `;

                    contenedor.appendChild(box);
                });
            } else {
                contenedor.innerHTML = "<p>No hay asignaciones activas.</p>";
            }
            document.getElementById('cerrarAsignados').addEventListener('click', function () {
                // Mostrar asignaciones
                document.getElementById('asignaciones-contenedor').classList.add('d-none');
                document.getElementById('asignarCon').classList.remove('d-none');
            });
        }
    };

    xhr.send();
}

function SetUsuarioTemp() {
    const form = document.getElementById('reservaTemporalForm');
    if (!form) return;

    const inputs = form.querySelectorAll('input');

    // Validación con iconos
    inputs.forEach(input => {
        input.addEventListener('input', () => {
            const valid = input.checkValidity();
            input.classList.remove('is-valid', 'is-invalid');
            input.classList.add(valid ? 'is-valid' : 'is-invalid');
        });
    });

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        let valid = true;
        inputs.forEach(input => {
            if (!input.checkValidity()) {
                input.classList.add('is-invalid');
                valid = false;
            }
        });

        if (!valid) return;

        const formData = new FormData(form);

        // Deshabilitar inputs y botones mientras se procesa
        form.querySelectorAll('input, button').forEach(el => el.disabled = true);

        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../../../models/sub_min/SetUsuarioTemp.php', true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                const res = JSON.parse(xhr.responseText);
                console.log(xhr.responseText); // Para depuración   

                if (res.success) {
                    // Oculta el formulario actual
                    form.classList.add('d-none');

                    // Muestra el formulario correspondiente
                    if (res.edad < 18) {
                        mostrarFormularioTutor(res.id_cliente);
                    } else {
                        mostrarFormularioReserva(res.id_cliente, res.datos_cliente);
                    }
                } else {
                    form.innerHTML = '<p class="text-danger text-center">' + res.message + '</p>';
                    form.classList.remove('d-none');
                }
            } else {
                form.innerHTML = '<p class="text-danger text-center">Error en el servidor.</p>';
                form.classList.remove('d-none');
            }
        };

        xhr.send(formData);
    });
}


function mostrarFormularioTutor(clienteId) {
    const container = document.getElementById('formContainerTemp');
    container.classList.remove('d-none');
    container.innerHTML = `
        <form id="tutorForm" class="form-futurista text-light">
            <h5 class="text-info mb-3">Registro de Tutor</h5>
            <input type="hidden" name="cliente_id" value="${clienteId}">
            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Apellidos</label>
                <input type="text" name="apellidos" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Teléfono</label>
                <input type="tel" name="telefono" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">DNI</label>
                <input type="text" name="dni" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-info w-100">Guardar Tutor</button>
        </form>
    `;
}

function mostrarFormularioReserva(clienteId, datosCliente) {
    const container = document.getElementById('formContainerTemp');
    container.classList.remove('d-none');
    console.log(container);

    container.innerHTML = `
        <form id="reservaFinalForm" class="form-futurista text-light">
            <h5 class="text-info mb-3">Finalizar Reserva</h5>
            <p><strong>Nombre:</strong> ${datosCliente.nombre} ${datosCliente.apellidos}</p>
            <p><strong>Email:</strong> ${datosCliente.email}</p>
            <p><strong>Teléfono:</strong> ${datosCliente.telefono}</p>

            <input type="hidden" name="cliente_temporal_id" value="${clienteId}">
            <div class="mb-3">
                <label class="form-label">Ruta</label>
                <select name="ruta_id" class="form-control" required>
                    <option value="">Seleccionar Ruta</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Bus</label>
                <select name="bus_id" class="form-control" required>
                    <option value="">Seleccionar Bus</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Tipo de Servicio</label>
                <select name="tipo_servicio" class="form-control" required>
                    <option value="Basico">Básico</option>
                    <option value="Platino">Platino</option>
                    <option value="Oro">Oro</option>
                </select>
            </div>
            <button type="submit" class="btn btn-info w-100">Confirmar Reserva</button>
        </form>
    `;

    GetViajes // ← esta función debe llenar los selects

    const form = document.getElementById('reservaFinalForm');
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(form);

        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../../../models/sub_min/SetReservaFinal.php', true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                const res = JSON.parse(xhr.responseText);
                if (res.success) {
                    form.innerHTML = `
                        <div class="text-center py-5">
                            <i class="fas fa-check-circle text-success fs-1"></i>
                            <p class="text-light mt-3">Reserva realizada con éxito.</p>
                        </div>
                    `;
                } else {
                    alert(res.message);
                }
            } else {
                alert("Error en el servidor.");
            }
        };

        xhr.send(formData);
    });
}



function SelecCargarViajes() {
    const viajeSelect = document.querySelector('select[name="viaje_id"]');

    const xhr = new XMLHttpRequest();
    xhr.open('GET', '../../../models/sub_min/GetViajes.php', true); // Asegúrate de que la URL sea correcta

    xhr.onload = function () {
        if (xhr.status === 200) {
            const res = JSON.parse(xhr.responseText);
            console.log(xhr.responseText); // Para depuración
            
            // Verifica qué contiene la respuesta
            console.log(res);

            if (res.success) {
                if (res.viajes && Array.isArray(res.viajes)) {
                    // Rellenar viajes
                    res.viajes.forEach(viaje => {
                        const opcion = document.createElement('option');
                        opcion.value = viaje.viaje_id;
                        opcion.textContent = `
                            ${viaje.numero_bus} - ${viaje.modelo} (${viaje.placa}) | 
                            Ruta: ${viaje.origen} ➜ ${viaje.destino} | 
                            Fecha: ${viaje.fecha_viaje} | Hora: ${viaje.hora_salida}
                        `;
                        viajeSelect.appendChild(opcion);
                    });
                } else {
                    console.error("No se encontraron viajes o la estructura de datos es incorrecta.");
                }
            } else {
                console.error(res.message);
            }
        } else {
            console.error("Error en la solicitud: " + xhr.status);
        }
    };

    xhr.send();
}



SetUsuarioTemp();

document.getElementById('btn-asignacion').addEventListener('click', function () {
    // Mostrar asignaciones
    document.getElementById('asignaciones-contenedor').classList.remove('d-none');
    document.getElementById('asignarCon').classList.add('d-none');
    // Cargar dinámicamente las asignaciones
    cargarAsignaciones();
});


const contenedor = document.getElementById('asignaciones-contenedor');
contenedor.classList.remove('d-none');
setTimeout(() => contenedor.classList.add('visible'), 10);



function SetUsuarios() {
    console.log('funciona');

    document.addEventListener("DOMContentLoaded", function () {
        const xhr = new XMLHttpRequest();
        xhr.open("GET", "../../../models/sub_min/SetUsuarios.php", true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                console.log(xhr.responseText); // Para depuración              
                const usuarios = JSON.parse(xhr.responseText);
                const tbody = document.getElementById("tbodyUsuarios");
                tbody.innerHTML = "";

                usuarios.forEach((usuario, index) => {
                    const row = document.createElement("tr");
                    row.innerHTML = `
                    <td>${index + 1}</td>
                    <td><img src="../../../uploads/${usuario.imagen}" alt="Imagen Usuario" class="rounded-circle" width="50" height="50"></td>
                    <td>${usuario.nombre}</td>
                    <td>${usuario.apellidos}</td>
                    <td>${usuario.edad}</td>
                    <td>${usuario.DNI}</td>
                    <td>${usuario.email}</td>
                    <td>${usuario.telefono}</td>
                    <td>${usuario.fecha_registro.split(' ')[0]}</td>
                `;
                    tbody.appendChild(row);
                });
            } else {
                alert("Error al cargar usuarios: " + xhr.statusText);
            }
        };

        xhr.onerror = function () {
            alert("Error de conexión con el servidor.");
        };

        xhr.send();
    });
}

function GetRutas() {
    document.addEventListener("DOMContentLoaded", function () {
        const xhr = new XMLHttpRequest();
        xhr.open("GET", "../../../models/sub_min/getRutas.php", true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                const rutas = JSON.parse(xhr.responseText);
                const contenedor = document.getElementById("contenedorTarjetas");

                rutas.forEach(ruta => {
                    const tarjeta = document.createElement("div");
                    tarjeta.className = "card route-card p-3 mb-3";
                    tarjeta.innerHTML = `
                    <div class="row align-items-center">
                        <div class="col-md-2 text-center mb-2 mb-md-0">
                            <i class="fas fa-map-marker-alt fa-lg text-primary me-2"></i>
                            <strong>Origen:</strong><br> ${ruta.origen}
                        </div>
                        <div class="col-md-2 text-center mb-2 mb-md-0">
                            <i class="fas fa-location-arrow fa-lg text-success me-2"></i>
                            <strong>Destino:</strong><br> ${ruta.destino}
                        </div>
                        <div class="col-md-3 text-center mb-2 mb-md-0">
                            <i class="fas fa-clock fa-lg text-warning me-2"></i>
                            <strong>Horario:</strong><br> ${ruta.horario}
                        </div>
                        <div class="col-md-2 text-center mb-2 mb-md-0">
                            <i class="fas fa-money-bill text-danger me-2"></i>
                            <strong>Precio:</strong><br> ${ruta.precio}
                        </div>
                        <div class="col-md-3 d-flex justify-content-end">
                            <div class="botonera d-flex gap-3">
                                <button class="btn-realista eliminar btn-danger" onclick="eliminarRuta(${ruta.id})">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                <button class="btn-realista editar" onclick="editarRuta(${ruta.id})">
                                    <i class="fas fa-pen"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                    contenedor.appendChild(tarjeta);
                });
            } else {
                console.error("Error al obtener rutas: " + xhr.statusText);
            }
        };

        xhr.send();
    });

}

function observarCambios() {
    const objetivo = document.body; // Puedes observar todo el body o un contenedor específico

    const config = {
        childList: true, // Detecta nuevos nodos hijos (elementos agregados o eliminados)
        subtree: true,   // También observa los nodos descendientes
        attributes: true, // Detecta cambios en atributos
        characterData: true // Detecta cambios en el texto
    };

    const callback = function (mutationsList, observer) {
        for (let mutation of mutationsList) {
            if (mutation.type === 'childList' || mutation.type === 'attributes') {
                GetRutas();     // Actualizar rutas automáticamente
                SetUsuarios();  // Volver a cargar usuarios si aplica
                break; // Solo necesitas ejecutar una vez por lote de cambios
            }
        }
    };

    const observer = new MutationObserver(callback);
    observer.observe(objetivo, config);
}

function SetBuses() {
    const fields = ['placa', 'numero_bus', 'modelo', 'capacidad'];

    fields.forEach(id => {
        const input = document.getElementById(id);
        const status = document.getElementById(`${id}-status`);

        const validate = () => {
            if (input.value.trim() === '') {
                status.classList.remove('valid', 'invalid');
                status.innerHTML = '<i class="fas fa-times-circle"></i>';
            } else if (input.checkValidity()) {
                status.classList.add('valid');
                status.classList.remove('invalid');
                status.innerHTML = '<i class="fas fa-check-circle"></i>';
            } else {
                status.classList.remove('valid');
                status.classList.add('invalid');
                status.innerHTML = '<i class="fas fa-times-circle"></i>';
            }
        };

        input.addEventListener('keyup', validate);
    });

    document.getElementById('formBus').addEventListener('submit', function (e) {
        e.preventDefault(); // Detener envío normal

        let valid = true;
        const formData = new FormData();

        const spinner = document.getElementById('spinner');
        const respuesta = document.getElementById('respuesta');

        respuesta.innerHTML = ''; // Limpia respuesta previa
        spinner.style.display = 'inline-block'; // Mostrar spinner

        fields.forEach(id => {
            const input = document.getElementById(id);
            const status = document.getElementById(`${id}-status`);

            if (input.value.trim() === '' || !input.checkValidity()) {
                status.classList.remove('valid');
                status.classList.add('invalid');
                status.innerHTML = '<i class="fas fa-times-circle"></i>';
                valid = false;
            } else {
                status.classList.add('valid');
                status.classList.remove('invalid');
                status.innerHTML = '<i class="fas fa-check-circle"></i>';
                formData.append(id, input.value.trim());
            }
        });

        const agencia = document.getElementById('agencia');
        if (agencia.value === '') {
            alert('Debes seleccionar una agencia.');
            valid = false;
        } else {
            formData.append('agencia', agencia.value);
        }

        if (!valid) {
            spinner.style.display = 'none';
            respuesta.innerHTML = '<p style="color: red;">Por favor completa correctamente todos los campos.</p>';
            return;
        }

        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../../../models/sub_min/setBus.php', true);
        xhr.onload = function () {
            spinner.style.display = 'none';

            if (xhr.status === 200) {
                respuesta.innerHTML = `<p style="color: green;">${xhr.responseText}</p>`;
                document.getElementById('formBus').reset();
                fields.forEach(id => {
                    document.getElementById(`${id}-status`).innerHTML = '';
                });
                GetBuses(); // Actualizar lista de buses    
            } else {
                respuesta.innerHTML = `<p style="color: red;">Error al registrar el bus.</p>`;
            }
        };
        xhr.onerror = function () {
            spinner.style.display = 'none';
            respuesta.innerHTML = `<p style="color: red;">Error de conexión al servidor.</p>`;
        };
        xhr.send(formData);
    });


}
function GetBuses() {
    const contenedor = document.getElementById('bus-list');
    const xhr = new XMLHttpRequest();
    xhr.open('GET', '../../../models/sub_min/getbus.php', true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            const buses = JSON.parse(xhr.responseText);
            contenedor.innerHTML = ''; // Limpiar contenido anterior


            buses.forEach(bus => {
                const card = document.createElement('div');
                card.className = 'bus-card futuristic-card mt-5 mb-3 p-3';
                card.innerHTML = `
                    <div class="bus-card-header">
                        <div class="bus-title">
                            <i class="fas fa-bus me-2"></i>Bus Nº ${bus.numero_bus} - Placa: ${bus.placa}
                        </div>
                        <div class="bus-actions">
                            <button class="action-btn edit" title="Editar" data-id="${bus.id}">
                                <i class="fas fa-pen"></i>
                            </button>
                            <button class="action-btn delete" title="Eliminar" data-id="${bus.id}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="bus-card-body">
                        <div class="bus-info">
                            <div><i class="fas fa-cogs me-2"></i><strong>Modelo:</strong> ${bus.modelo}</div>
                            <div><i class="fas fa-users me-2"></i><strong>Capacidad:</strong> ${bus.capacidad} pasajeros</div>
                            <div><i class="fas fa-building me-2"></i><strong>Agencia:</strong> ${bus.agencia}</div>
                            <div><i class="fas fa-check-circle me-2"></i><strong>Estado:</strong>
                                <span class="status ${bus.estado === 'Activo' ? 'active' : 'inactive'}">${bus.estado}</span>
                            </div>
                        </div>
                    </div>
                `;
                contenedor.appendChild(card);
            });
        } else {
            contenedor.innerHTML = `<p style="color:red;">Error al cargar los buses.</p>`;
        }
    };
    xhr.send();
}

function GetEmpleados() {
    const formulario = document.getElementById('formRegistroEmpleado');
    const campos = formulario.querySelectorAll('.campo-validacion');
    const animacion = document.getElementById('envioAnimacion');

    campos.forEach(campo => {
        campo.addEventListener('input', () => validarCampo(campo));
        campo.addEventListener('blur', () => validarCampo(campo));
    });

    function validarCampo(campo) {
        const icono = campo.parentElement.querySelector('.icono-validacion i');
        if (!icono) return;

        if (campo.checkValidity()) {
            icono.classList.remove('fa-circle', 'text-danger');
            icono.classList.add('fa-check-circle', 'text-success');
        } else {
            icono.classList.remove('fa-check-circle', 'text-success');
            icono.classList.add('fa-times-circle', 'text-danger');
        }
    }

    formulario.addEventListener('submit', (e) => {
        e.preventDefault();

        let valido = true;
        campos.forEach(campo => {
            if (!campo.checkValidity()) {
                validarCampo(campo);
                valido = false;
            }
        });

        if (!valido) {
            console.log("Formulario inválido. Corrige los campos.");
            return;
        }

        const formData = new FormData(formulario);

        // Generar contraseña automática usando nombre + apellido + teléfono
        const nombre = formulario.querySelector('[name="nombre"]').value.trim().toLowerCase();
        const apellidos = formulario.querySelector('[name="apellidos"]').value.trim().toLowerCase();
        const telefono = formulario.querySelector('[name="telefono"]').value.trim();
        const pass = (nombre.charAt(0) + apellidos.charAt(0) + telefono).replace(/\D/g, '').slice(0, 5).padEnd(5, '0');

        formData.append('password_generada', pass);

        // Mostrar animación
        animacion.style.display = 'flex';

        setTimeout(() => {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '../../../models/sub_min/GetEmpleados.php', true);

            xhr.onload = () => {
                animacion.style.display = 'none';

                if (xhr.status === 200) {
                    alert(xhr.responseText);
                    formulario.reset();
                    document.querySelectorAll('.icono-validacion i').forEach(icono => {
                        icono.className = 'fas fa-circle';
                    });
                    console.log(xhr.responseText);

                    // SetEmpleados(); // si tienes función de recarga, aquí
                } else {
                    alert("Error al enviar formulario.");
                }
            };

            xhr.send(formData);
        }, 3000);
    });
}

function SetConductores() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', '../../../models/sub_min/SetConductores.php', true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            const data = JSON.parse(xhr.responseText);
            const tbody = document.getElementById('tbody');
            tbody.innerHTML = ''; // Limpiar contenido actual

            data.forEach(conductor => {
                const fila = document.createElement('tr');
                fila.innerHTML = `
                    <td>${conductor.id}</td>
                    <td>${conductor.nombre_completo}</td>
                    <td>${conductor.edad} años</td>
                    <td>${conductor.telefono}</td>
                    <td>${conductor.email}</td>
                    <td>
                        <button class="btn-open-card" data-id="${conductor.id}">
                            Ver tarjeta
                        </button>
                    </td>
                `;
                tbody.appendChild(fila);
            });

            // Asignar eventos a todos los botones generados
            const botones = document.querySelectorAll('.btn-open-card');
            botones.forEach(boton => {
                boton.addEventListener('click', () => {
                    const id = boton.getAttribute('data-id');
                    document.getElementById("targeta").classList.remove("d-none"); // Mostrar tarjeta
                    SetConductorCard(id); // Cargar datos del conductor
                });
            });

        } else {
            console.error("Error al cargar conductores.");
        }
    };
    xhr.send();
}
function SetConductorCard(id) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', '../../../models/sub_min/GetTargetaEmpleado.php?id=' + id, true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            const conductor = JSON.parse(xhr.responseText);
            console.log(xhr.responseText); // Para depuración   


            // Llenar la tarjeta con los datos
            document.getElementById("card-nombre").textContent = conductor.nombre_completo;
            document.getElementById("card-id").textContent = conductor.id;
            document.getElementById("card-edad").textContent = conductor.edad + " años";
            document.getElementById("card-direccion").textContent = conductor.direccion || "No disponible";
            document.getElementById("card-telefono").textContent = conductor.telefono;
            document.getElementById("card-email").textContent = conductor.email;
            document.getElementById("card-licencia").textContent = conductor.licencia || "Sin licencia";
            document.getElementById("card-bus").textContent = conductor.bus || "No asignado";
            document.getElementById("card-agencia").textContent = conductor.agencia || "Desconocida";

            // Enlaces dinámicos
            document.getElementById("card-whatsapp").href = `https://wa.me/${conductor.telefono.replace(/\s|\+/g, '')}`;
            document.getElementById("card-email-link").href = `mailto:${conductor.email}`;

            // Mostrar tarjeta
            document.getElementById("targeta").classList.remove("d-none");
        } else {
            alert("No se pudo cargar la información del conductor.");
        }
    };
    xhr.send();
}


function verificarUsuario(callback) {
    const form = document.getElementById('reservaUsuarioForm');
    const formData = new FormData(form);

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../../../models/sub_min/verificarUsuario.php', true);

    xhr.onload = function () {
        try {
            const res = JSON.parse(xhr.responseText);
            console.log("Respuesta del servidor:", res);

            if (res.success) {
                // Ocultar el formulario de verificación
                form.classList.add('d-none');

                // Mostrar formulario de reserva con datos
                callback(res.usuario.id, res.usuario);
            } else {
                alert(res.message);
            }
        } catch (error) {
            console.error("Respuesta inválida:", xhr.responseText);
            alert("Error del servidor. Inténtalo más tarde.");
        }
    };

    xhr.send(formData);
}

document.getElementById('reservaUsuarioForm').addEventListener('submit', function (e) {
    e.preventDefault();

    verificarUsuario(function (usuarioId, usuarioData) {
        mostrarFormularioReservaUsuario(usuarioId, usuarioData);
    });
});


function mostrarFormularioReservaUsuario(usuarioId, datos) {
    const container = document.getElementById('formContainer');
    container.classList.remove('d-none');

    container.innerHTML = `
    <form id="reservaFinalUsuarioForm" class="form-futurista text-light">
        <h5 class="text-info mb-3">Finalizar Reserva (Usuario)</h5>
        <p><strong>Nombre:</strong> ${datos.nombre} ${datos.apellidos}</p>
        <p><strong>Email:</strong> ${datos.email}</p>
        <p><strong>Teléfono:</strong> ${datos.telefono}</p>

        <input type="hidden" name="usuario_id" value="${usuarioId}">
        <input type="hidden" name="agencia_id" value="${datos.agencia}">

        <div class="mb-3">
            <label class="form-label">Seleccionar Viaje</label>
            <select name="viaje_id" class="form-control" required>
                <option value="">Seleccione un viaje</option>
                <!-- Aquí se agregan las opciones de viajes (bus, ruta, fecha de salida y hora) -->
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Tipo de Servicio</label>
            <select name="tipo_servicio" class="form-control" required>
                <option value="Basico">Básico</option>
                <option value="Platino">Platino</option>
                <option value="Oro">Oro</option>
            </select>
        </div>

        <button type="submit" class="btn btn-info w-100">Confirmar Reserva</button>
    </form>
`;


    SelecCargarViajes(); // Llamar a la función para llenar los viajes

    const form = document.getElementById('reservaFinalUsuarioForm');
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(form);

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "../../../models/sub_min/SetReservaUsuario.php", true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        alert("Reserva registrada exitosamente. Nº Reserva: TK" + String(response.reserva_id).padStart(6, "0"));
                        mostrarReservasPendientes();
                    } else {
                        alert("Error: " + response.message);
                    }
                } catch (error) {
                    console.error("Respuesta no válida del servidor", xhr.responseText);
                    alert("Error interno del servidor");
                }
            } else {
                alert("Error al enviar el formulario");
            }
        };
        xhr.send(formData);
    });
}




function mostrarReservasPendientes() {
    const contenedor = document.getElementById("pendientes");

    const xhr = new XMLHttpRequest();
    xhr.open("GET", "../../../models/sub_min/GetReservasPendientes.php", true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            const reservas = JSON.parse(xhr.responseText);
            contenedor.innerHTML = ""; // Limpiar antes de agregar
            console.log(xhr.responseText); // Para depuración
            reservas.forEach(r => {
                const nombre = r.u_nombre ? `${r.u_nombre} ${r.u_apellidos}` : `${r.ct_nombre} ${r.ct_apellidos}`;
                const telefono = r.u_telefono || r.ct_telefono;
                const email = r.u_email || r.ct_email;

                contenedor.innerHTML += `
<div class="container my-5">
    <div class="ticket-card border shadow-lg rounded-4 overflow-hidden mx-auto" style="max-width: 1000px; background-color: #fff;">
        <div class="bg-white p-4 border-bottom">
            <div class="d-flex justify-content-between flex-column flex-md-row">
                <div>
                    <h5 class="mb-2 fw-bold"><i class="fa-solid fa-user me-2 text-primary"></i>${nombre}</h5>
                    <p class="mb-1"><i class="fa-solid fa-phone text-muted me-2"></i>${telefono}</p>
                    <p class="mb-0"><i class="fa-solid fa-envelope text-muted me-2"></i>${email}</p>
                </div>
                <div class="text-md-end mt-3 mt-md-0">
                    <span class="badge bg-primary fs-6 px-3 py-2">Reserva Nº TK${r.reserva_id.toString().padStart(6, '0')}</span>
                </div>
            </div>
            <div class="mt-3">
                <span class="badge bg-warning text-dark fs-6 px-3 py-2">
                    <i class="fa-solid fa-star me-1"></i> Servicio: ${r.tipo_servicio}
                </span>
            </div>
        </div>
        <div class="bg-light-subtle px-4 py-3">
            <div class="row text-center text-md-start">
                <div class="col-md-4 mb-3 mb-md-0">
                    <h6 class="text-uppercase text-muted mb-1">Agencia</h6>
                    <p class="fw-semibold mb-0">${r.agencia_nombre}</p>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <h6 class="text-uppercase text-muted mb-1">Ruta</h6>
                    <p class="mb-0"><strong>${r.origen}</strong> → <strong>${r.destino}</strong></p>
                </div>
                <div class="col-md-4">
                    <h6 class="text-uppercase text-muted mb-1">Horario</h6>
                    <p class="mb-0">${r.fecha_registro.split(" ")[0]} - ${r.horario}</p>
                </div>
            </div>
        </div>
        <div class="bg-white px-4 py-3 d-flex justify-content-between align-items-center flex-column flex-md-row">
            <div>
                <p class="mb-1"><i class="fa-solid fa-chair me-2 text-secondary"></i><strong>Asiento:</strong> -</p>
                <p class="mb-0"><i class="fa-solid fa-clock me-2 text-warning"></i><strong>Estado:</strong> Pendiente</p>
            </div>
            <div class="text-md-end mt-3 mt-md-0">
                <h6 class="text-uppercase text-muted mb-1">Precio</h6>
                <p class="fs-4 fw-bold text-success mb-0">${parseInt(r.precio).toLocaleString()} XAF</p>
            </div>
        </div>
        <div class="bg-light px-4 py-3 border-top text-center">
            <p class="mb-3 fw-semibold">¿Deseas confirmar el pago de esta reserva?</p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <button class="btn btn-success px-4" onclick="confirmarPago(${r.reserva_id})">
                    <i class="fa-solid fa-credit-card me-2"></i> Confirmar Pago
                </button>
                <button class="btn btn-danger px-4" onclick="cancelarReserva(${r.reserva_id})">
                    <i class="fa-solid fa-xmark me-2"></i> Cancelar
                </button>
            </div>
        </div>
    </div>
</div>`;
            });
        }
    };
    xhr.send();
}

function mostrarToastAccion(mensaje, onConfirm, tipo = 'info') {
    const colores = {
        success: '#4CAF50',
        error: '#F44336',
        info: '#2196F3'
    };

    const toast = document.createElement('div');
    toast.style.cssText = `
        background-color: ${colores[tipo]};
        color: white;
        padding: 16px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        position: fixed;
        top: 20px;
        right: 20px;
        max-width: 300px;
        z-index: 9999;
        animation: fadeIn 0.5s ease;
    `;

    const texto = document.createElement('div');
    texto.innerText = mensaje;

    const botones = document.createElement('div');
    botones.style.marginTop = '10px';
    botones.style.textAlign = 'right';

    const btnConfirmar = document.createElement('button');
    btnConfirmar.innerText = 'Sí';
    btnConfirmar.style.marginRight = '8px';
    btnConfirmar.style.padding = '5px 10px';
    btnConfirmar.style.border = 'none';
    btnConfirmar.style.backgroundColor = '#fff';
    btnConfirmar.style.color = colores[tipo];
    btnConfirmar.style.borderRadius = '4px';
    btnConfirmar.onclick = () => {
        toast.remove();
        onConfirm();
    };

    const btnCancelar = document.createElement('button');
    btnCancelar.innerText = 'No';
    btnCancelar.style.padding = '5px 10px';
    btnCancelar.style.border = 'none';
    btnCancelar.style.backgroundColor = '#fff';
    btnCancelar.style.color = colores[tipo];
    btnCancelar.style.borderRadius = '4px';
    btnCancelar.onclick = () => {
        toast.remove();
    };

    botones.appendChild(btnConfirmar);
    botones.appendChild(btnCancelar);

    toast.appendChild(texto);
    toast.appendChild(botones);

    document.body.appendChild(toast);
}

// Función para confirmar pago
function confirmarPago(reservaId) {
    mostrarToastAccion("¿Confirmar el pago de la reserva?", () => {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "../../../models/sub_min/ActualizarReserva.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                try {
                    const respuesta = JSON.parse(xhr.responseText);
                    if (respuesta.success) {
                        mostrarToast("✅ Reserva confirmada correctamente", "success");
                        mostrarReservasPendientes();
                    } else {
                        mostrarToast("⚠️ Error: " + respuesta.message, "error");
                    }
                } catch (e) {
                    mostrarToast("❌ Respuesta no válida del servidor.", "error");
                    console.log(xhr.responseText); // Para depuración
                }
            }
        };
        xhr.send("reserva_id=" + reservaId + "&accion=confirmar");
    }, 'success');
}

// Función para cancelar reserva
function cancelarReserva(reservaId) {
    mostrarToastAccion("¿Estás seguro de que deseas cancelar esta reserva?", () => {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "../../../models/sub_min/ActualizarReserva.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                try {
                    const respuesta = JSON.parse(xhr.responseText);
                    if (respuesta.success) {
                        mostrarToast("❌ Reserva cancelada correctamente", "info");
                        mostrarReservasPendientes();
                    } else {
                        mostrarToast("⚠️ Error: " + respuesta.message, "error");
                    }
                } catch (e) {
                    mostrarToast("❌ Respuesta no válida del servidor.", "error");
                }
            }
        };
        xhr.send("reserva_id=" + reservaId + "&accion=cancelar");
    }, 'error');
}

function GetReservasConfirmadasAgencia() {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "../../../models/sub_min/getReservaPagada.php", true);

    xhr.onload = function () {
        if (xhr.status === 200) {
            const data = JSON.parse(xhr.responseText);

            // Get the target container for the reservation cards
            const container = document.getElementById("comprados");

            if (data.error) {
                container.innerHTML = "<p class='text-danger'>" + data.error + "</p>";
                return;
            }

            let html = "";
            data.forEach(reserva => {
                html += `
                <div class="ticket-card border shadow-lg rounded-4 overflow-hidden mx-auto mb-5" style="max-width: 1000px; background-color: #fff;">
                    <div class="bg-white p-4 border-bottom">
                        <div class="d-flex justify-content-between flex-column flex-md-row">
                            <div>
                                <h5 class="mb-2 fw-bold"><i class="fa-solid fa-user me-2 text-primary"></i>${reserva.nombre} ${reserva.apellidos}</h5>
                                <p class="mb-1"><i class="fa-solid fa-phone text-muted me-2"></i>${reserva.telefono}</p>
                                <p class="mb-0"><i class="fa-solid fa-envelope text-muted me-2"></i>${reserva.email}</p>
                            </div>
                            <div class="text-md-end mt-3 mt-md-0">
                                <span class="badge bg-primary fs-6 px-3 py-2">Reserva Nº TK${reserva.reserva_id.toString().padStart(6, '0')}</span>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="badge bg-warning text-dark fs-6 px-3 py-2">
                                <i class="fa-solid fa-star me-1"></i> Servicio: ${reserva.tipo_servicio}
                            </span>
                        </div>
                    </div>

                    <div class="bg-light-subtle px-4 py-3">
                        <div class="row text-center text-md-start">
                            <div class="col-md-4 mb-3 mb-md-0">
                                <h6 class="text-uppercase text-muted mb-1">Agencia</h6>
                                <p class="fw-semibold mb-0">${reserva.agencia_nombre}</p>
                            </div>
                            <div class="col-md-4 mb-3 mb-md-0">
                                <h6 class="text-uppercase text-muted mb-1">Ruta</h6>
                                <p class="mb-0"><strong>${reserva.origen}</strong> → <strong>${reserva.destino}</strong></p>
                            </div>
                            <div class="col-md-4">
                                <h6 class="text-uppercase text-muted mb-1">Horario</h6>
                                <p class="mb-0">${reserva.fecha_registro.split(" ")[0]} - ${reserva.horario.slice(0, 5)} h</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white px-4 py-3 d-flex justify-content-between align-items-center flex-column flex-md-row">
                        <div>
                            <p class="mb-1"><i class="fa-solid fa-chair me-2 text-secondary"></i><strong>Asiento:</strong> ${reserva.num_asiento_bus}</p>
                            <p class="mb-0"><i class="fa-solid fa-circle-check me-2 text-success"></i><strong>Estado:</strong> ${reserva.estado_pago}</p>
                        </div>
                        <div class="text-md-end mt-3 mt-md-0">
                            <h6 class="text-uppercase text-muted mb-1">Precio</h6>
                            <p class="fs-4 fw-bold text-success mb-0">${parseFloat(reserva.precio).toLocaleString()} XAF</p>
                        </div>
                    </div>
                </div>`;
            });

            // Insert the generated HTML directly into the "comprados" div
            container.innerHTML = html;
        } else {
            // Handle HTTP errors, e.g., 404, 500
            document.getElementById("comprados").innerHTML = "<p class='text-danger'>Error al cargar las reservas. Código de estado: " + xhr.status + "</p>";
        }
    };

    xhr.onerror = function () {
        // Handle network errors
        document.getElementById("comprados").innerHTML = "<p class='text-danger'>Error de red al intentar cargar las reservas.</p>";
    };

    xhr.send();
}

function enviarFormularioViaje(e) {
    if (e) e.preventDefault(); // Previene comportamiento por defecto del submit

    let valid = true;

    // Validación de los campos
    ['fecha', 'fecha_llegada', 'busSelect', 'ruta'].forEach(id => {
        const input = document.getElementById(id);
        const alert = document.getElementById('alert_' + id);

        if (!input.value) {
            alert?.classList.remove('d-none');
            valid = false;
        } else {
            alert?.classList.add('d-none');
        }
    });

    // Validar la fecha (si se necesita alguna validación extra)
    const fecha = document.getElementById('fecha').value;  // Formato YYYY-MM-DD
    if (!fecha) {
        valid = false;
        document.getElementById('alert_fecha').classList.remove('d-none');
    } else {
        document.getElementById('alert_fecha').classList.add('d-none');
    }

    // Si alguna validación falla, no enviamos el formulario
    if (!valid) return false;

    // Crear el FormData para enviar la información
    const data = new FormData();
    data.append('fecha', fecha);
    data.append('fecha_llegada', document.getElementById('fecha_llegada').value);
    data.append('bus', document.getElementById('busSelect').value);
    data.append('ruta', document.getElementById('ruta').value);

    // Crear la solicitud XMLHttpRequest
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../../../models/sub_min/SetNuevoViaje.php', true);

    xhr.onload = function () {
        if (xhr.status === 200) {
            let res;
            try {
                res = JSON.parse(xhr.responseText); // Intentamos parsear la respuesta JSON


            } catch {
                alert('Respuesta inválida del servidor: ' + xhr.responseText);
                console.log('Respuesta del servidor:', res);
                console.log(xhr.responseText);

                return;
            }

            // Mostrar mensaje de éxito o error
            alert(res.success || 'Viaje registrado exitosamente!');
            document.getElementById('viajeForm').reset(); // Reseteamos el formulario
        } else {
            let res = {};
            try {
                res = JSON.parse(xhr.responseText);
            } catch { }
            alert(res.error || 'Error al registrar el viaje.');
        }
    };

    xhr.onerror = function () {
        alert('Error en la solicitud. Verifica tu conexión.');
    };

    xhr.send(data); // Enviar los datos al servidor

    return true; // Devuelve true para que no se recargue la página
}



function CargarRutasYBuses() {
    const rutaSelect = document.getElementById('ruta');
    const busSelect = document.getElementById('busSelect'); // Cambiado aquí

    const xhr = new XMLHttpRequest();
    xhr.open('GET', '../../../models/sub_min/GetRutasYBuses.php', true);

    xhr.onload = function () {
        if (xhr.status === 200) {
            try {
                const res = JSON.parse(xhr.responseText);
                console.log('Respuesta recibida:', res);

                if (res.success) {
                    rutaSelect.innerHTML = '<option value="">Seleccione una ruta</option>';
                    busSelect.innerHTML = '<option value="">Seleccione un bus</option>';

                    if (Array.isArray(res.rutas)) {
                        res.rutas.forEach(ruta => {
                            const opcion = document.createElement('option');
                            opcion.value = ruta.id;
                            opcion.textContent = `${ruta.origen} ➜ ${ruta.destino} (${ruta.horario}) - ${parseFloat(ruta.precio).toFixed(2)} Fcfa`;
                            rutaSelect.appendChild(opcion);
                        });
                    }

                    if (Array.isArray(res.buses)) {
                        res.buses.forEach(bus => {
                            const opcion = document.createElement('option');
                            opcion.value = bus.id;
                            opcion.textContent = `#${bus.numero_bus} - ${bus.modelo} (${bus.placa})`;
                            busSelect.appendChild(opcion);
                        });
                        console.log('Opciones en busSelect:', busSelect.innerHTML);
                    } else {
                        console.warn('No se encontraron buses en la respuesta.');
                    }
                } else {
                    console.error(res.message || 'Error en la carga de datos.');
                }
            } catch (err) {
                console.error('Error al parsear respuesta JSON:', err);
            }
        } else {
            console.error(`Error HTTP ${xhr.status} al obtener datos.`);
        }
    };

    xhr.onerror = function () {
        console.error('Error de red al intentar cargar rutas y buses.');
    };

    xhr.send();
}

// Ejecutar al cargar la página
document.addEventListener('DOMContentLoaded', CargarRutasYBuses);



document.getElementById('viajeForm').addEventListener('submit', e => {
    e.preventDefault();
    enviarFormularioViaje();
});


function cargarTodosLosViajes() {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "../../../models/sub_min/obtener_viajes.php", true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            const viajes = JSON.parse(xhr.responseText);
            console.log(xhr.responseText); // Para depuración

            let contenido = '';

            viajes.forEach((viaje) => {
                let estadoClass = 'secondary';
                let estadoTexto = viaje.estado;

                // Asignar clases según el estado
                if (viaje.estado === 'activo') estadoClass = 'success';
                else if (viaje.estado === 'pendiente') estadoClass = 'warning';
                else if (viaje.estado === 'cancelado') estadoClass = 'danger';
                else if (viaje.estado === 'finalizado') estadoClass = 'secondary';

                contenido += `
                    <div class="card shadow-sm rounded-3 border-0 p-3 mb-3" style="max-width: 80%; margin: auto;">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <h6 class="mb-1 text-primary fw-bold">
                                    <i class="fas fa-ticket-alt me-2"></i>Viaje Nº ${viaje.id}
                                </h6>
                                <p class="mb-0 text-muted">
                                    <i class="fas fa-building me-2"></i>${viaje.agencia}
                                </p>
                            </div>
                            <span class="badge bg-${estadoClass} px-3 py-2">${estadoTexto}</span>
                        </div>

                        <hr class="my-2">

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1 text-primary fw-bold">
                                    <i class="fas fa-clock me-2"></i>Salida: ${viaje.hora_salida}
                                </h6>
                                <p class="mb-0 text-muted">
                                    <i class="fas fa-calendar-alt me-2"></i>${viaje.fecha_viaje}
                                </p>
                            </div>
                            <div>
                                <h6 class="mb-1 text-primary fw-bold">
                                    <i class="fas fa-flag-checkered me-2"></i>Llegada: ${viaje.hora_llegada}
                                </h6>
                                ${viaje.estado === "pendiente"
                        ? `<button class="btn btn-sm btn-outline-success mt-2" onclick="iniciarViaje(${viaje.id})">
                                                <i class="fas fa-play me-1"></i>Iniciar viaje
                                           </button>`
                        : ""
                    }
                            </div>
                        </div>
                    </div>
                `;
            });

            // Inyectar contenido en el contenedor
            document.getElementById("contenedor_viajes").innerHTML = contenido;
        }
    };
    xhr.send();
}




let pollingInterval;

function checkViajesEstado() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', '../../../models/sub_min/obtener_viajes.php', true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            const viajes = JSON.parse(xhr.responseText);

            viajes.forEach(viaje => {
                if (viaje.capacidad <= 0 && viaje.estado === 'pendiente') {
                    // Notificar que el viaje está lleno y listo para iniciar
                    mostrarToast(`Viaje Nº ${viaje.id} está lleno y listo para iniciar.`, 'info');
                }
            });
        }
    };
    xhr.send();
}

function iniciarPolling() {
    if (!pollingInterval) {
        pollingInterval = setInterval(checkViajesEstado, 30000);
    }
}

function detenerPolling() {
    if (pollingInterval) {
        clearInterval(pollingInterval);
        pollingInterval = null;
    }
}

function iniciarViaje(idViaje) {
    if (!confirm("¿Estás seguro de que deseas iniciar este viaje?")) return;

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "iniciar_viaje.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function () {
        if (xhr.status === 200 && xhr.responseText === "ok") {
            alert("Viaje iniciado correctamente.");
            cargarTodosLosViajes(); // Recarga la lista
            detenerPolling();       // Detiene las notificaciones
        } else {
            alert("Error al iniciar el viaje.");
        }
    };
    xhr.send("id=" + idViaje);
}





// Pequeño toast sin botones
function mostrarToast(mensaje, tipo = 'info') {
    const colores = {
        success: '#4CAF50',
        error: '#F44336',
        info: '#2196F3'
    };

    const toast = document.createElement('div');
    toast.style.cssText = `
        background-color: ${colores[tipo]};
        color: white;
        padding: 14px 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        margin-bottom: 10px;
    `;

    toast.innerText = mensaje;
    document.body.appendChild(toast);

    setTimeout(() => toast.remove(), 3000);
}

// Ejecutar al cargar la página
document.addEventListener("DOMContentLoaded", mostrarReservasPendientes);
document.addEventListener("DOMContentLoaded", cargarTodosLosViajes);
document.addEventListener("DOMContentLoaded", iniciarPolling);
document.addEventListener("DOMContentLoaded", function () {
    GetReservasConfirmadasAgencia();
});

// Llamar automáticamente al cargar la página
document.addEventListener('DOMContentLoaded', SetConductores);
// Llamar al cargar la página

document.getElementById('btnBuses').addEventListener('click', () => {
    GetBuses();
});


document.addEventListener('DOMContentLoaded', () => {
    const fields = ['conductor', 'bus'];

    fields.forEach(id => {
        const input = document.getElementById(id);
        const status = document.getElementById(`${id}-status`);

        const validate = () => {
            if (input.value === '') {
                status.classList.remove('valid');
                status.classList.add('invalid');
                status.innerHTML = '<i class="fas fa-times-circle"></i>';
            } else {
                status.classList.remove('invalid');
                status.classList.add('valid');
                status.innerHTML = '<i class="fas fa-check-circle"></i>';
            }
        };
        input.addEventListener('change', validate);
    });

    document.getElementById('assignmentForm').addEventListener('submit', function (e) {
        let valid = true;
        fields.forEach(id => {
            const input = document.getElementById(id);
            const status = document.getElementById(`${id}-status`);
            if (input.value === '') {
                status.classList.remove('valid');
                status.classList.add('invalid');
                status.innerHTML = '<i class="fas fa-times-circle"></i>';
                valid = false;
            }
        });

        if (!valid) {
            e.preventDefault();
            alert('Por favor, complete todos los campos antes de asignar.');
        }
    });
});

window.onload = function () {
    GetRutas();
    SetUsuarios();
    observarCambios();
    SetBuses();

};
document.addEventListener('DOMContentLoaded', GetBuses);
document.addEventListener('DOMContentLoaded', GetEmpleados);
GetRutas();

