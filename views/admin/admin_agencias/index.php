<?php
session_start();

// Verificar si hay sesión activa
if (!isset($_SESSION['user_id']) || $_SESSION['tipo'] !== 'agencia') {
    header('Location: ../../../../../views/login/index.php'); // Redirigir si no está logueado como agencia
    exit;
}

// Conexión a la base de datos
require_once('../../../models/conexion.php');
$obj = new Database();
$conn = $obj->getConexion();

$idAgencia = $_SESSION['user_id'];

// Consultar datos de la agencia
$sql_agencias = "SELECT id, nombre, direccion, telefono, email, usuario, imagen FROM agencias WHERE id = ?";
$stmt = $conn->prepare($sql_agencias);
$stmt->bind_param("i", $idAgencia);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 1) {
    $agencia = $resultado->fetch_assoc();
} else {
    echo "Error al cargar la información de la agencia.";
    exit;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Administrativo</title>
    <link rel="stylesheet" href="../../css/all.min.css">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/fontawesome.min.css">
    <link rel="stylesheet" href="../../css/adsys.css">
    <link rel="stylesheet" href="../../css/subMin.css">
    <link rel="shortcut icon" href="../../../img/index/Logo_viages.png" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

    <!-- <div id="pantalla-bienvenida" class="pantalla-bienvenida">
        <div class="contenido-bienvenida">
            <img src="../../img/index/Logo_viages.png" alt="Logo" class="logo-animado">
            <h2 class="titulo-bienvenida">Sistema administrativo <span></span></h2>
        </div>
    </div> -->

    <main id="contenido" style="display: none;">




        <div class="window window_rutas" style="display: none;">
            <div class="window-header">
                <span>Gestion Rutas</span>
                <div class="window-controls">
                    <button class="btn-minimize"><i class="fa-solid fa-window-minimize"></i></button>
                    <button class="btn-maximize"><i class="fa-solid fa-window-maximize"></i></button>
                    <button class="btn-close"><i class="fa-solid fa-xmark"></i></button>
                </div>
            </div>
            <div class="window-content h-100 d-flex">

                <aside class="bg-light border-end p-3" style="width: 220px;">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary mb-3" id="btnMasRutas">
                            <i class="fa-solid fa-plus"></i> Rutas
                        </button>
                        <button class="btn btn-outline-primary mb-3" id="btnTodasRutas">
                            Todas
                        </button>
                        <button class="btn btn-outline-primary mb-3" id="btnFrecuentes">
                            <i class="fa-solid fa-road"></i> Frecuentes
                        </button>
                        <button class="btn btn-outline-primary mb-3" id="btnPopulares">
                            <i class="fa-solid fa-road"></i> Populares
                        </button>
                        <button class="btn btn-outline-primary mb-3" id="btnRegion">
                            <i class="fa-solid fa-road"></i> Region
                        </button>
                    </div>
                </aside>

                <main class="flex-grow-1 p-4 overflow-auto">
                    <h4 class="mb-4">Gestion de rutas</h4>

                    <div class="container my-4" id="rutas">
                        <div class="mt-4" id="contenedorTarjetas">
                            <!-- <div class=" row align-items-center">
                            <div class="col-md-2 text-center mb-2 mb-md-0">
                                <i class="fas fa-map-marker-alt fa-lg text-primary me-2"></i>
                                <strong>Origen:</strong><br> Malabo
                            </div>
                            <div class="col-md-2 text-center mb-2 mb-md-0">
                                <i class="fas fa-location-arrow fa-lg text-success me-2"></i>
                                <strong>Destino:</strong><br> Bata
                            </div>
                            <div class="col-md-3 text-center mb-2 mb-md-0">
                                <i class="fas fa-clock fa-lg text-warning me-2"></i>
                                <strong>Horario:</strong><br> 08:00 - 14:00
                            </div>
                            <div class="col-md-2 text-center mb-2 mb-md-0">
                                <i class="fas fa-money-bill text-danger me-2"></i>
                                <strong>Precio:</strong><br> 20.000 XAF
                            </div>
                            <div class="col-md-3 d-flex justify-content-end">
                                <div class="botonera d-flex gap-3">
                                    <button class="btn-realista eliminar btn-danger" title="Agregar a la página" onclick="eliminarRuta()">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    <button class="btn-realista editar" title="Editar ruta" onclick="editarRuta()">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                </div>
                            </div>
                        </div> -->
                        </div>
                    </div>
                    <div class="container my-4 d-none" id="populares">
                        <div class="card route-card p-3">
                            <div class="row align-items-center">
                                <div class="col-md-2 text-center mb-2 mb-md-0">
                                    <i class="fas fa-map-marker-alt fa-lg text-primary me-2"></i>
                                    <strong>Origen:</strong><br> Malabo
                                </div>
                                <div class="col-md-2 text-center mb-2 mb-md-0">
                                    <i class="fas fa-location-arrow fa-lg text-success me-2"></i>
                                    <strong>Destino:</strong><br> Bata
                                </div>
                                <div class="col-md-3 text-center mb-2 mb-md-0">
                                    <i class="fas fa-clock fa-lg text-warning me-2"></i>
                                    <strong>Horario:</strong><br> 08:00 - 14:00
                                </div>
                                <div class="col-md-2 text-center mb-2 mb-md-0">
                                    <i class="fas fa-money-bill text-danger me-2"></i>
                                    <strong>Precio:</strong><br> 20.000 XAF
                                </div>
                                <div class="col-md-3 text-center d-flex justify-content-center align-items-center gap-2">
                                    <button class="btn btn-success btn-icon" title="Agregar a la página" onclick="agregarRuta()">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    <button class="btn btn-warning btn-icon" title="Editar ruta" onclick="editarRuta()">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container my-4 d-none" id="frecuentes">
                        <div class="card route-card p-3">
                            <div class="row align-items-center">
                                <div class="col-md-2 text-center mb-2 mb-md-0">
                                    <i class="fas fa-map-marker-alt fa-lg text-primary me-2"></i>
                                    <strong>Origen:</strong><br> Malabo
                                </div>
                                <div class="col-md-2 text-center mb-2 mb-md-0">
                                    <i class="fas fa-location-arrow fa-lg text-success me-2"></i>
                                    <strong>Destino:</strong><br> Bata
                                </div>
                                <div class="col-md-3 text-center mb-2 mb-md-0">
                                    <i class="fas fa-clock fa-lg text-warning me-2"></i>
                                    <strong>Horario:</strong><br> 08:00 - 14:00
                                </div>
                                <div class="col-md-2 text-center mb-2 mb-md-0">
                                    <i class="fas fa-money-bill text-danger me-2"></i>
                                    <strong>Precio:</strong><br> 20.000 XAF
                                </div>
                                <div class="col-md-3 text-center d-flex justify-content-center align-items-center gap-2">
                                    <button class="btn btn-success btn-icon" title="Agregar a la página" onclick="agregarRuta()">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    <button class="btn btn-warning btn-icon" title="Editar ruta" onclick="editarRuta()">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container my-4 d-none" id="regional">
                        <div class="card route-card p-3">
                            <div class="row align-items-center">
                                <div class="col-md-2 text-center mb-2 mb-md-0">
                                    <i class="fas fa-map-marker-alt fa-lg text-primary me-2"></i>
                                    <strong>Origen:</strong><br> Malabo
                                </div>
                                <div class="col-md-2 text-center mb-2 mb-md-0">
                                    <i class="fas fa-location-arrow fa-lg text-success me-2"></i>
                                    <strong>Destino:</strong><br> Bata
                                </div>
                                <div class="col-md-3 text-center mb-2 mb-md-0">
                                    <i class="fas fa-clock fa-lg text-warning me-2"></i>
                                    <strong>Horario:</strong><br> 08:00 - 14:00
                                </div>
                                <div class="col-md-2 text-center mb-2 mb-md-0">
                                    <i class="fas fa-money-bill text-danger me-2"></i>
                                    <strong>Precio:</strong><br> 20.000 XAF
                                </div>
                                <div class="col-md-3 text-center d-flex justify-content-center align-items-center gap-2">
                                    <button class="btn btn-success btn-icon" title="Agregar a la página" onclick="agregarRuta()">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    <button class="btn btn-warning btn-icon" title="Editar ruta" onclick="editarRuta()">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Formulario -->
                    <div class="container my-5 d-none" id="formRutas">
                        <div class="card shadow-lg p-4">
                            <h4 class="mb-4"><i class="fas fa-road text-primary me-2"></i>Registro de Ruta</h4>
                            <form id="rutaForm" novalidate>
                                <input type="hidden" id="agencia_id" value="<?= htmlspecialchars($agencia['id']) ?>">

                                <div class="row g-3">
                                    <!-- Origen -->
                                    <div class="col-md-6">
                                        <label for="origen" class="form-label">
                                            <i class="fas fa-map-marker-alt me-1 text-primary"></i>Origen
                                        </label>
                                        <input type="text" class="form-control" id="origen" required>
                                        <span class="valid-span text-success d-none">✓ Campo válido</span>
                                        <span class="invalid-span text-danger d-none">✗ Campo obligatorio</span>
                                    </div>

                                    <!-- Destino -->
                                    <div class="col-md-6">
                                        <label for="destino" class="form-label">
                                            <i class="fas fa-location-arrow me-1 text-success"></i>Destino
                                        </label>
                                        <input type="text" class="form-control" id="destino" required>
                                        <span class="valid-span text-success d-none">✓ Campo válido</span>
                                        <span class="invalid-span text-danger d-none">✗ Campo obligatorio</span>
                                    </div>

                                    <!-- Horario -->
                                    <div class="col-md-6">
                                        <label for="horario" class="form-label">
                                            <i class="fas fa-clock me-1 text-warning"></i>Horario
                                        </label>
                                        <input type="time" class="form-control" id="horario" required>
                                        <span class="valid-span text-success d-none">✓ Campo válido</span>
                                        <span class="invalid-span text-danger d-none">✗ Campo obligatorio</span>
                                    </div>

                                    <!-- Precio -->
                                    <div class="col-md-6">
                                        <label for="precio" class="form-label">
                                            <i class="fas fa-money-bill me-1 text-success"></i>Precio
                                        </label>
                                        <input type="number" class="form-control" id="precio" step="0.01" required>
                                        <span class="valid-span text-success d-none">✓ Campo válido</span>
                                        <span class="invalid-span text-danger d-none">✗ Campo obligatorio</span>
                                    </div>

                                    <!-- Región -->
                                    <div class="col-md-6">
                                        <label for="region" class="form-label">
                                            <i class="fas fa-globe-africa me-1 text-info"></i>Región
                                        </label>
                                        <select class="form-select" id="region" required>
                                            <option value="">Seleccione una opción</option>
                                            <option value="continental">Continental</option>
                                            <option value="regional">Regional</option>
                                        </select>
                                        <span class="valid-span text-success d-none">✓ Selección válida</span>
                                        <span class="invalid-span text-danger d-none">✗ Debe seleccionar una opción</span>
                                    </div>
                                </div>

                                <div class="mt-4 text-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i>Registrar Ruta
                                    </button>
                                </div>
                            </form>
                            <div id="respuestaRuta" class="mt-3"></div>
                        </div>
                    </div>


                </main>

            </div>
        </div>

        <div class="window window_buses" style="display: none;">


            <div class="window-header">
                <span>Buses</span>
                <div class="window-controls">
                    <button class="btn-minimize"><i class="fa-solid fa-window-minimize"></i></button>
                    <button class="btn-maximize"><i class="fa-solid fa-window-maximize"></i></button>
                    <button class="btn-close"><i class="fa-solid fa-xmark"></i></button>
                </div>
            </div>

            <div class="window-content h-100 d-flex">

                <aside class="bg-light border-end p-3" style="width: 220px;">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary mb-3" id="btnNuevoBuses">
                            <i class="fa-solid fa-bus"></i> Nuevo
                        </button>
                        <button class="btn btn-outline-primary mb-3" id="btnBuses">
                            <i class="fa-solid fa-bus"></i> Buses
                        </button>
                        <button class="btn btn-outline-primary mb-3" id="btnConductores">
                            <i class="fa-solid fa-user-group"></i> Condutores
                        </button>
                        <button class="btn btn-outline-primary mb-3" id="btnAsignar">
                            <i class="fa-solid fa-bus"></i> Asignar Bus
                        </button>
                    </div>
                </aside>

                <main class="flex-grow-1 p-4 overflow-auto">
                    <h4 class="mb-4"> Control de Buses </h4>

                    <div class="table-responsive" id="buses">
                        <div class="container my-5" id="bus-list">
                            <!-- <div class="bus-card futuristic-card"> -->
                            <!-- Cabecera -->
                            <!-- <div class="bus-card-header">
                                    <div class="bus-title">
                                        <i class="fas fa-bus me-2"></i>Bus Nº 25 - Placa: AB123CD
                                    </div>
                                    <div class="bus-actions">
                                        <button class="action-btn edit" title="Editar">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <button class="action-btn delete" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div> -->

                            <!-- Cuerpo -->
                            <!-- <div class="bus-card-body">
                                    <div class="bus-info">
                                        <div><i class="fas fa-cogs me-2"></i><strong>Modelo:</strong> Mercedes Sprinter</div>
                                        <div><i class="fas fa-users me-2"></i><strong>Capacidad:</strong> 18 pasajeros</div>
                                        <div><i class="fas fa-building me-2"></i><strong>Agencia:</strong> Ndong Viajes</div>
                                        <div><i class="fas fa-check-circle me-2"></i><strong>Estado:</strong>
                                            <span class="status active">Activo</span>
                                        </div>
                                    </div>
                                </div> -->
                            <!-- </div> -->
                        </div>
                    </div>

                    <div class="table-responsive d-none" id="conductos">
                        <div class="container mt-5">
                            <div class="futuristic-table-container">
                                <table class="futuristic-table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Edad</th>
                                            <th>Teléfono</th>
                                            <th>Email</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody">
                                        <!-- <tr>
                                            <td>20203040</td>
                                            <td>Juan Pedro Mba</td>
                                            <td>35 años</td>
                                            <td>+240 555 123456</td>
                                            <td>juan.pedro@email.com</td>
                                            <td><button class="btn-open-card" onclick="abrirTarjeta()">Ver tarjeta</button></td>
                                        </tr> -->
                                        <script>
                                            function abrirTarjeta() {
                                                document.getElementById("targeta").classList.remove("d-none");
                                            }

                                            function cerrarTarjeta() {
                                                document.getElementById("targeta").className.add("d-none");
                                            }
                                        </script>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="targeta d-none" id="targeta">
                            <div class="dni-card-modern" id="draggable-card">
                                <div class="dni-header" id="drag-handle">
                                    <div class="user-avatar">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <button class="close-btn" onclick="cerrarTargeta()" title="Cerrar tarjeta">&times;</button>
                                    <div class="user-name" id="card-nombre">Juan Pedro Mba</div>
                                    <div class="user-status active">Activo</div>

                                    <script>
                                        function cerrarTargeta() {
                                            document.getElementById("targeta").classList.add("d-none");
                                        }
                                    </script>
                                </div>

                                <div class="dni-body">
                                    <!-- Secciones -->
                                    <div class="dni-section">
                                        <h5 class="section-title">Datos Personales</h5>
                                        <div class="dni-info"><i class="fas fa-id-card"></i> <strong>ID:</strong>
                                            <div id="card-id"></div>
                                        </div>
                                        <div class="dni-info"><i class="fas fa-birthday-cake"></i> <strong>Edad:</strong>
                                            <div id="card-edad"></div>
                                        </div>
                                        <div class="dni-info"><i class="fas fa-home"></i> <strong>Domicilio:</strong>
                                            <div id="card-direccion"></div>
                                        </div>
                                    </div>
                                    <div class="dni-section">
                                        <h5 class="section-title">Contacto</h5>
                                        <div class="dni-info"><i class="fas fa-phone"></i> <strong>Tel:</strong>
                                            <div id="card-telefono"></div>
                                        </div>
                                        <div class="dni-info"><i class="fas fa-envelope"></i> <strong>Email:</strong>
                                            <div id="card-email"></div>
                                        </div>
                                    </div>
                                    <div class="dni-section">
                                        <h5 class="section-title">Información Profesional</h5>
                                        <div class="dni-info"><i class="fas fa-id-badge"></i> <strong>Licencia:</strong>
                                            <div id="card-licencia"></div>
                                        </div>
                                        <div class="dni-info"><i class="fas fa-bus"></i> <strong>Asignación:</strong>
                                            <div id="card-bus"></div>
                                        </div>
                                        <div class="dni-info"><i class="fas fa-building"></i> <strong>Agencia:</strong>
                                            <div id="card-agencia"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="dni-footer">
                                    <a href="https://wa.me/240555123456" target="_blank" id="card-whatsapp" class="btn-dni whatsapp">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                    <a href="mailto:juan.pedro@email.com" id="card-email-link" class="btn-dni email">
                                        <i class="fas fa-envelope"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>


                    <div class="table-responsive d-none" id="asignar">

                        <div class="assignment-container" id="asignarCon">
                            <h2>Asignar Bus a Conductor</h2>
                            <form id="assignmentForm">
                                <div class="form-group">
                                    <label for="conductor">Conductor:</label>
                                    <select id="conductor" name="conductor" required>
                                        <option value="">Seleccione un conductor</option>
                                        <!-- Opciones dinámicas -->
                                    </select>
                                    <span class="status-icon" id="conductor-status"></span>
                                </div>

                                <div class="form-group">
                                    <label for="bus">Bus:</label>
                                    <select id="bus" name="bus" required>
                                        <option value="">Seleccione un bus</option>
                                        <!-- Opciones dinámicas -->
                                    </select>
                                    <span class="status-icon" id="bus-status"></span>
                                </div>

                                <div class="form-buttons">
                                    <button type="submit" class="btn-azul">Asignar</button>
                                    <button type="button" class="btn-verde button" id="btn-asignacion">Ver Asignaciones</button>
                                </div>
                            </form>
                        </div>

                        <!-- CONTENEDOR PRINCIPAL DE TODAS LAS ASIGNACIONES ACTIVAS -->
                        <div id="asignaciones-contenedor" class="d-none"></div>

                        <!-- <div class="asignacion-box d-none" id="asignacion-body">
                            <div class="asignacion-header">
                                <h3>Asignación Activa</h3>
                                <button class="btn-cerrar" id="btn_cerra_asignacion">&times;</button>
                            </div>
                            <div class="asignacion-body">
                                <div class="info-bloque">
                                    <span class="label">Conductor:</span>
                                    <span class="valor">Juan Pedro Mba</span>
                                </div>
                                <div class="info-bloque">
                                    <span class="label">ID:</span>
                                    <span class="valor">EMP-00123</span>
                                </div>
                                <div class="info-bloque">
                                    <span class="label">Bus Asignado:</span>
                                    <span class="valor">BUS-548</span>
                                </div>
                                <div class="info-bloque">
                                    <span class="label">Agencia:</span>
                                    <span class="valor">Ndong Viajes</span>
                                </div>
                                <button class="btn-desasignar" onclick="desasignar(123)">Desasignar</button>
                            </div>
                        </div> -->

                    </div>


                    <div class="table-responsive d-none" id="nuevoBus">
                        <form id="formBus" method="POST" class="form-futurista">
                            <div class="form-group">
                                <label for="placa">Placa:</label>
                                <div class="input-icon">
                                    <input type="text" id="placa" name="placa" pattern="^[A-Z]{2}-\d{3}-[A-Z]{1}$" placeholder="Ej: BN-001-A">
                                    <span id="placa-status" class="status-icon"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="numero_bus">Número del Bus:</label>
                                <div class="input-icon">
                                    <input type="text" id="numero_bus" name="numero_bus" placeholder="Ej: 25">
                                    <span id="numero_bus-status" class="status-icon"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="modelo">Modelo:</label>
                                <div class="input-icon">
                                    <input type="text" id="modelo" name="modelo" placeholder="Ej: Toyota Coaster">
                                    <span id="modelo-status" class="status-icon"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="capacidad">Capacidad:</label>
                                <div class="input-icon">
                                    <input type="number" id="capacidad" name="capacidad" min="1" placeholder="Ej: 30">
                                    <span id="capacidad-status" class="status-icon"></span>
                                </div>
                            </div>

                            <!-- Campo oculto -->
                            <input type="hidden" id="agencia" name="agencia" value="<?= htmlspecialchars($agencia['id']) ?>">

                            <button type="submit" class="btn-enviar">Registrar Bus</button>
                            <div id="form-group" class="mt-3">
                                <div id="respuesta-container" style="margin-top: 10px;">
                                    <div id="spinner" style="display: none;">
                                        <i class="fas fa-spinner fa-spin" style="color: #007bff; font-size: 1.2em;"></i> Verificando datos...
                                    </div>
                                    <div id="respuesta" style="margin-top: 5px;"></div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <script>
                        document.getElementById('btnNuevoBuses').addEventListener('click', function() {
                            document.getElementById('nuevoBus').classList.remove('d-none');
                            document.getElementById('buses').classList.add('d-none');
                            document.getElementById('conductos').classList.add('d-none');
                            document.getElementById('asignar').classList.add('d-none');
                        });
                        document.getElementById('btnBuses').addEventListener('click', function() {
                            document.getElementById('buses').classList.remove('d-none');
                            document.getElementById('nuevoBus').classList.add('d-none');
                            document.getElementById('conductos').classList.add('d-none');
                            document.getElementById('asignar').classList.add('d-none');
                        });
                        document.getElementById('btnConductores').addEventListener('click', function() {
                            document.getElementById('conductos').classList.remove('d-none');
                            document.getElementById('buses').classList.add('d-none');
                            document.getElementById('nuevoBus').classList.add('d-none');
                            document.getElementById('asignar').classList.add('d-none');
                        });
                        document.getElementById('btnAsignar').addEventListener('click', function() {
                            document.getElementById('asignar').classList.remove('d-none');
                            document.getElementById('buses').classList.add('d-none');
                            document.getElementById('conductos').classList.add('d-none');
                            document.getElementById('nuevoBus').classList.add('d-none');
                        });
                    </script>

                </main>

            </div>

        </div>

        <div class="window window_reservas" style="display: none;">
            <div class="window-header">
                <span>Reservas</span>
                <div class="window-controls">
                    <button class="btn-minimize"><i class="fa-solid fa-window-minimize"></i></button>
                    <button class="btn-maximize"><i class="fa-solid fa-window-maximize"></i></button>
                    <button class="btn-close"><i class="fa-solid fa-xmark"></i></button>
                </div>
            </div>
            <div class="window-content h-100 d-flex">

                <aside class="bg-light border-end p-3" style="width: 220px;">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary mb-3" id="btnReservar">
                            <i class="fa-solid fa-circle-plus"></i> Reservar
                        </button>
                        <button class="btn btn-outline-primary mb-3" id="btnPendientes">
                            <i class="fa-solid fa-ticket"></i> Pendientes
                        </button>
                        <button class="btn btn-outline-primary mb-3" id="btnComprados">
                            <i class="fa-solid fa-ticket"></i> Comprados
                        </button>
                        <button class="btn btn-outline-primary mb-3" id="btnReservados">
                            <i class="fa-solid fa-ticket"></i> Reservados
                        </button>
                        <button class="btn btn-outline-primary mb-3" id="btnCancelar">
                            <i class="fa-solid fa-ticket"></i> Cancelados
                        </button>

                    </div>
                </aside>

                <!-- Contenido central -->
                <main class="flex-grow-1 p-4 overflow-auto">
                    <!-- Contenedor de notificaciones -->
                    <div id="toast-container" style="
                        position: fixed;
                        top: 20px;
                        right: 20px;
                        z-index: 9999;
                        display: flex;
                        flex-direction: column;
                        gap: 10px;
                        ">
                    </div>

                    <h4 class="mb-4">Gestion de reservas</h4>

                    <div class="table-responsive" id="pendientes">
                        <!-- <div class="container my-5">
                            <div class="ticket-card border shadow-lg rounded-4 overflow-hidden mx-auto" style="max-width: 1000px; background-color: #fff;">
                                
                                <div class="bg-white p-4 border-bottom">
                                    <div class="d-flex justify-content-between flex-column flex-md-row">
                                        <div>
                                            <h5 class="mb-2 fw-bold"><i class="fa-solid fa-user me-2 text-primary"></i>Juan Pedro Mba</h5>
                                            <p class="mb-1"><i class="fa-solid fa-phone text-muted me-2"></i>+240 555 123456</p>
                                            <p class="mb-0"><i class="fa-solid fa-envelope text-muted me-2"></i>juan.pedro@email.com</p>
                                        </div>
                                        <div class="text-md-end mt-3 mt-md-0">
                                            <span class="badge bg-primary fs-6 px-3 py-2">Reserva Nº TK123456</span>
                                        </div>
                                    </div>

                                    
                                    <div class="mt-3">
                                        <span class="badge bg-warning text-dark fs-6 px-3 py-2">
                                            <i class="fa-solid fa-star me-1"></i> Servicio: Oro
                                        </span>
                                    </div>
                                </div>

                               
                                <div class="bg-light-subtle px-4 py-3">
                                    <div class="row text-center text-md-start">
                                        <div class="col-md-4 mb-3 mb-md-0">
                                            <h6 class="text-uppercase text-muted mb-1">Agencia</h6>
                                            <p class="fw-semibold mb-0">Ndong Viajes</p>
                                        </div>
                                        <div class="col-md-4 mb-3 mb-md-0">
                                            <h6 class="text-uppercase text-muted mb-1">Ruta</h6>
                                            <p class="mb-0"><strong>Malabo</strong> → <strong>Bata</strong></p>
                                        </div>
                                        <div class="col-md-4">
                                            <h6 class="text-uppercase text-muted mb-1">Horario</h6>
                                            <p class="mb-0">25/05/2025 - 08:30 AM</p>
                                        </div>
                                    </div>
                                </div>

                               
                                <div class="bg-white px-4 py-3 d-flex justify-content-between align-items-center flex-column flex-md-row">
                                    <div>
                                        <p class="mb-1"><i class="fa-solid fa-chair me-2 text-secondary"></i><strong>Asiento:</strong> 12B</p>
                                        <p class="mb-0"><i class="fa-solid fa-circle-check me-2 text-success"></i><strong>Estado:</strong> Confirmado</p>
                                    </div>
                                    <div class="text-md-end mt-3 mt-md-0">
                                        <h6 class="text-uppercase text-muted mb-1">Precio</h6>
                                        <p class="fs-4 fw-bold text-success mb-0">8.000 XAF</p>
                                    </div>
                                </div>

                            
                                <div class="bg-light px-4 py-3 border-top text-center">
                                    <p class="mb-3 fw-semibold">¿Deseas confirmar el pago de esta reserva?</p>
                                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                                        <button class="btn btn-success px-4">
                                            <i class="fa-solid fa-credit-card me-2"></i> Confirmar Pago
                                        </button>
                                        <button class="btn btn-danger px-4">
                                            <i class="fa-solid fa-xmark me-2"></i> Cancelar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>

                    <div class="table-responsive" id="comprados">
                        <!-- <div class="container my-5">
                            <div class="ticket-card border shadow-lg rounded-4 overflow-hidden mx-auto" style="max-width: 1000px; background-color: #fff;">

                                
                                <div class="bg-white p-4 border-bottom">
                                    <div class="d-flex justify-content-between flex-column flex-md-row">
                                        <div>
                                            <h5 class="mb-2 fw-bold"><i class="fa-solid fa-user me-2 text-primary"></i>Juan Pedro Mba</h5>
                                            <p class="mb-1"><i class="fa-solid fa-phone text-muted me-2"></i>+240 555 123456</p>
                                            <p class="mb-0"><i class="fa-solid fa-envelope text-muted me-2"></i>juan.pedro@email.com</p>
                                        </div>
                                        <div class="text-md-end mt-3 mt-md-0">
                                            <span class="badge bg-primary fs-6 px-3 py-2">Reserva Nº TK123456</span>
                                        </div>
                                    </div>

                                    
                                    <div class="mt-3">
                                        <span class="badge bg-warning text-dark fs-6 px-3 py-2">
                                            <i class="fa-solid fa-star me-1"></i> Servicio: Oro
                                        </span>
                                    </div>
                                </div>

                                
                                <div class="bg-light-subtle px-4 py-3">
                                    <div class="row text-center text-md-start">
                                        <div class="col-md-4 mb-3 mb-md-0">
                                            <h6 class="text-uppercase text-muted mb-1">Agencia</h6>
                                            <p class="fw-semibold mb-0">Ndong Viajes</p>
                                        </div>
                                        <div class="col-md-4 mb-3 mb-md-0">
                                            <h6 class="text-uppercase text-muted mb-1">Ruta</h6>
                                            <p class="mb-0"><strong>Malabo</strong> → <strong>Bata</strong></p>
                                        </div>
                                        <div class="col-md-4">
                                            <h6 class="text-uppercase text-muted mb-1">Horario</h6>
                                            <p class="mb-0">25/05/2025 - 08:30 AM</p>
                                        </div>
                                    </div>
                                </div>

                               
                                <div class="bg-white px-4 py-3 d-flex justify-content-between align-items-center flex-column flex-md-row">
                                    <div>
                                        <p class="mb-1"><i class="fa-solid fa-chair me-2 text-secondary"></i><strong>Asiento:</strong> 12B</p>
                                        <p class="mb-0"><i class="fa-solid fa-circle-check me-2 text-success"></i><strong>Estado:</strong> Confirmado</p>
                                    </div>
                                    <div class="text-md-end mt-3 mt-md-0">
                                        <h6 class="text-uppercase text-muted mb-1">Precio</h6>
                                        <p class="fs-4 fw-bold text-success mb-0">8.000 XAF</p>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>

                    <div class="table-responsive d-none" id="reservados">
                        <div class="container my-5">
                            <div class="ticket-card border shadow-lg rounded-4 overflow-hidden mx-auto" style="max-width: 1000px; background-color: #fff;">

                                <!-- Cabecera: Nombre y reserva -->
                                <div class="bg-white p-4 border-bottom">
                                    <div class="d-flex justify-content-between flex-column flex-md-row">
                                        <div>
                                            <h5 class="mb-2 fw-bold"><i class="fa-solid fa-user me-2 text-primary"></i>Juan Pedro Mba</h5>
                                            <p class="mb-1"><i class="fa-solid fa-phone text-muted me-2"></i>+240 555 123456</p>
                                            <p class="mb-0"><i class="fa-solid fa-envelope text-muted me-2"></i>juan.pedro@email.com</p>
                                        </div>
                                        <div class="text-md-end mt-3 mt-md-0">
                                            <span class="badge bg-primary fs-6 px-3 py-2">Reserva Nº TK123456</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Detalles del viaje -->
                                <div class="bg-light-subtle px-4 py-3">
                                    <div class="row text-center text-md-start">
                                        <div class="col-md-4 mb-3 mb-md-0">
                                            <h6 class="text-uppercase text-muted mb-1">Agencia</h6>
                                            <p class="fw-semibold mb-0">Ndong Viajes</p>
                                        </div>
                                        <div class="col-md-4 mb-3 mb-md-0">
                                            <h6 class="text-uppercase text-muted mb-1">Ruta</h6>
                                            <p class="mb-0"><strong>Malabo</strong> → <strong>Bata</strong></p>
                                        </div>
                                        <div class="col-md-4">
                                            <h6 class="text-uppercase text-muted mb-1">Horario</h6>
                                            <p class="mb-0">25/05/2025 - 08:30 AM</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Asiento y precio -->
                                <div class="bg-white px-4 py-3 d-flex justify-content-between align-items-center flex-column flex-md-row">
                                    <div>
                                        <p class="mb-1"><i class="fa-solid fa-chair me-2 text-secondary"></i><strong>Asiento:</strong> 12B</p>
                                        <p class="mb-0"><i class="fa-solid fa-circle-check me-2 text-success"></i><strong>Estado:</strong> Confirmado</p>
                                    </div>
                                    <div class="text-md-end mt-3 mt-md-0">
                                        <h6 class="text-uppercase text-muted mb-1">Precio</h6>
                                        <p class="fs-4 fw-bold text-success mb-0">8.000 XAF</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive d-none" id="cancelados">
                        <div class="container my-5">
                            <div class="ticket-card border shadow-lg rounded-4 overflow-hidden mx-auto" style="max-width: 1000px; background-color: #fff;">

                                <!-- Cabecera: Nombre y reserva -->
                                <div class="bg-white p-4 border-bottom">
                                    <div class="d-flex justify-content-between flex-column flex-md-row">
                                        <div>
                                            <h5 class="mb-2 fw-bold"><i class="fa-solid fa-user me-2 text-primary"></i>Juan Pedro Mba</h5>
                                            <p class="mb-1"><i class="fa-solid fa-phone text-muted me-2"></i>+240 555 123456</p>
                                            <p class="mb-0"><i class="fa-solid fa-envelope text-muted me-2"></i>juan.pedro@email.com</p>
                                        </div>
                                        <div class="text-md-end mt-3 mt-md-0">
                                            <span class="badge bg-primary fs-6 px-3 py-2">Reserva Nº TK123456</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Detalles del viaje -->
                                <div class="bg-light-subtle px-4 py-3">
                                    <div class="row text-center text-md-start">
                                        <div class="col-md-4 mb-3 mb-md-0">
                                            <h6 class="text-uppercase text-muted mb-1">Agencia</h6>
                                            <p class="fw-semibold mb-0">Ndong Viajes</p>
                                        </div>
                                        <div class="col-md-4 mb-3 mb-md-0">
                                            <h6 class="text-uppercase text-muted mb-1">Ruta</h6>
                                            <p class="mb-0"><strong>Malabo</strong> → <strong>Bata</strong></p>
                                        </div>
                                        <div class="col-md-4">
                                            <h6 class="text-uppercase text-muted mb-1">Horario</h6>
                                            <p class="mb-0">25/05/2025 - 08:30 AM</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Asiento y precio -->
                                <div class="bg-white px-4 py-3 d-flex justify-content-between align-items-center flex-column flex-md-row">
                                    <div>
                                        <p class="mb-1"><i class="fa-solid fa-chair me-2 text-secondary"></i><strong>Asiento:</strong> 12B</p>
                                        <p class="mb-0"><i class="fa-solid fa-circle-check me-2 text-success"></i><strong>Estado:</strong> Confirmado</p>
                                    </div>
                                    <div class="text-md-end mt-3 mt-md-0">
                                        <h6 class="text-uppercase text-muted mb-1">Precio</h6>
                                        <p class="fs-4 fw-bold text-success mb-0">8.000 XAF</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive d-none" id="reservar">
                        <!-- Alerta futurista fullscreen -->
                        <div id="alertaReserva" class="position-fixed top-0 start-0 w-100 h-100 d-none bg-dark bg-opacity-90 z-3 d-flex justify-content-center align-items-center" style="backdrop-filter: blur(5px);">
                            <div class="text-center p-5 rounded-4" style="background-color: #0b0f1a; border: 2px solid #00bcd4;">
                                <h3 class="text-info mb-4">¿Ya estás registrado?</h3>
                                <div class="d-flex justify-content-center gap-3">
                                    <button class="btn btn-outline-info" id="btnYaRegistrado"><i class="fa-solid fa-user-check"></i> Sí, estoy registrado</button>
                                    <button class="btn btn-outline-warning" id="btnNoRegistrado"><i class="fa-solid fa-user-plus"></i> No, soy nuevo</button>
                                </div>
                            </div>
                        </div>

                        <!-- Formulario Reserva Usuario Registrado -->
                        <div class="reservaUsuario d-none" id="formReservaUsuario">
                            <div class="container mt-4 p-4 rounded-3" style="background-color: #111827; color: #fff;">
                                <h4 class="text-info mb-3"><i class="fa-solid fa-id-card"></i> Reserva Usuario Registrado</h4>
                                <form id="reservaUsuarioForm">
                                    <div class="mb-3 position-relative">
                                        <label class="form-label text-light">Nombre</label>
                                        <input type="text" name="nombre" class="form-control bg-dark text-white border-info" required>
                                        <i class="fa-solid fa-phone position-absolute top-50 end-0 translate-middle-y me-3 text-info"></i>
                                    </div>
                                    <div class="mb-3 position-relative">
                                        <label class="form-label text-light">Contraseña</label>
                                        <input type="password" name="password" class="form-control bg-dark text-white border-info" required>
                                        <i class="fa-solid fa-lock position-absolute top-50 end-0 translate-middle-y me-3 text-info"></i>
                                    </div>
                                    <button type="submit" class="btn btn-info mt-3"><i class="fa-solid fa-paper-plane"></i> Comprobar</button>
                                </form>
                                <div id="formContainer" class="d-none"></div>
                                <!-- Contenedor donde se mostrarán los formularios -->
                                <div id="formContainerTemp" class="p-4 bg-dark rounded d-none"></div>


                            </div>
                        </div>

                        <!-- Formulario Reserva Temporal -->
                        <div class="reservaRapida d-none" id="formReservaTemp">
                            <h4 class="text-info mb-3"><i class="fa-solid fa-user-clock"></i> Reserva Rápida</h4>
                            <form id="reservaTemporalForm" class="form-futurista text-light">
                                <div class="row mb-3 position-relative">
                                    <div class="col-md-6 position-relative">
                                        <label class="form-label">Nombre</label>
                                        <input type="text" class="form-control" name="nombre" id="nombre" required>
                                        <i class="fa-solid fa-user input-icon"></i>
                                        <i class="fa-solid fa-circle-check validation-icon"></i>
                                        <i class="fa-solid fa-circle-xmark validation-icon"></i>
                                    </div>
                                    <div class="col-md-6 position-relative">
                                        <label class="form-label">Apellidos</label>
                                        <input type="text" class="form-control" name="apellidos" id="apellidos" required>
                                        <i class="fa-solid fa-user-group input-icon"></i>
                                        <i class="fa-solid fa-circle-check validation-icon"></i>
                                        <i class="fa-solid fa-circle-xmark validation-icon"></i>
                                    </div>
                                </div>

                                <div class="row mb-3 position-relative">
                                    <div class="col-md-6 position-relative">
                                        <label class="form-label">Edad</label>
                                        <input type="number" class="form-control" name="edad" id="edad" required>
                                        <i class="fa-solid fa-hourglass-half input-icon"></i>
                                        <i class="fa-solid fa-circle-check validation-icon"></i>
                                        <i class="fa-solid fa-circle-xmark validation-icon"></i>
                                    </div>
                                    <div class="col-md-6 position-relative">
                                        <label class="form-label">Teléfono</label>
                                        <input type="tel" class="form-control" name="telefono" id="telefono" required>
                                        <i class="fa-solid fa-phone input-icon"></i>
                                        <i class="fa-solid fa-circle-check validation-icon"></i>
                                        <i class="fa-solid fa-circle-xmark validation-icon"></i>
                                    </div>
                                </div>

                                <div class="row mb-3 position-relative">
                                    <div class="col-md-6 position-relative">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" id="email" required>
                                        <i class="fa-solid fa-envelope input-icon"></i>
                                        <i class="fa-solid fa-circle-check validation-icon"></i>
                                        <i class="fa-solid fa-circle-xmark validation-icon"></i>
                                    </div>
                                    <div class="col-md-6 position-relative">
                                        <label class="form-label">DNI</label>
                                        <input type="text" class="form-control" name="dni" id="dni" required>
                                        <i class="fa-solid fa-id-card input-icon"></i>
                                        <i class="fa-solid fa-circle-check validation-icon"></i>
                                        <i class="fa-solid fa-circle-xmark validation-icon"></i>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-info w-100 mt-3">
                                    <i class="fa-solid fa-paper-plane"></i> Reservar
                                </button>
                            </form>
                            <div id="formContainer">
                                <!-- Aquí se cargan dinámicamente los formularios -->
                                <!-- Inicia con reservaTemporalForm -->
                            </div>

                            <script>
                                const btnReservar = document.getElementById("btnReservar");
                                const alertaReserva = document.getElementById("alertaReserva");
                                const btnYaRegistrado = document.getElementById("btnYaRegistrado");
                                const btnNoRegistrado = document.getElementById("btnNoRegistrado");

                                const formUsuario = document.getElementById("formReservaUsuario");
                                const formTemporal = document.getElementById("formReservaTemp");

                                btnReservar.addEventListener("click", () => {
                                    alertaReserva.classList.remove("d-none");
                                });

                                btnYaRegistrado.addEventListener("click", () => {
                                    alertaReserva.classList.add("d-none");
                                    formUsuario.classList.remove("d-none");
                                    formTemporal.classList.add("d-none");
                                });

                                btnNoRegistrado.addEventListener("click", () => {
                                    alertaReserva.classList.add("d-none");
                                    formTemporal.classList.remove("d-none");
                                    formUsuario.classList.add("d-none");
                                });
                            </script>

                        </div>

                    </div>
                </main>

            </div>
        </div>

        <div class="window window_viajes" style="display: none;">
            <div class="window-header">
                <span>Viajes</span>
                <div class="window-controls">
                    <button class="btn-minimize"><i class="fa-solid fa-window-minimize"></i></button>
                    <button class="btn-maximize"><i class="fa-solid fa-window-maximize"></i></button>
                    <button class="btn-close"><i class="fa-solid fa-xmark"></i></button>
                </div>
            </div>
            <div class="window-content h-100 d-flex">
                <!-- Sidebar -->
                <aside class="bg-light border-end p-3" style="width: 220px;">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary mb-3" id="btnNuevoViaje">
                            <i class="fas fa-map-marked-alt  me-2"></i> Nuevo viaje
                        </button>
                        <button class="btn btn-outline-primary mb-3" id="btnLista">
                            <i class="fas fa-map-marked-alt  me-2"></i> lista
                        </button>
                        <button class="btn btn-outline-primary mb-3" id="btnBusesAsientos">
                            <i class="fas fa-map-marked-alt  me-2"></i> Buses
                        </button>
                        <button class="btn btn-outline-primary mb-3" id="btnSeguimiento">
                            <i class="fas fa-route  me-2"></i> Seguimiento
                        </button>
                    </div>
                </aside>

                <!-- Contenido central -->
                <main class="flex-grow-1 p-4 overflow-auto">
                    <h4 class="mb-4">Seguimiento de viajes</h4>

                    <div class="table-responsive" id="tablaSeguimiento">
                        <div class="container my-4" id="contenedor-viajes">
                            <!-- <div class="card shadow-lg rounded-4 overflow-hidden" style="height: 275px; max-width: 1000px; margin: auto;">
                                <div class="row h-100 g-0">

                                
                                    <div class="col-md-8 bg-white p-4 d-flex flex-column justify-content-between">
                                       
                                        <div class="mb-2">
                                            <h5 class="fw-bold mb-1 text-primary">
                                                <strong>Forama</strong><br>
                                                <i class="fas fa-bus me-2"></i> Viaje en Bus Nº 25
                                            </h5>
                                            <span class="text-muted small"><i class="fas fa-road me-1"></i>Ruta Malabo - Bata</span>
                                        </div>

                                       
                                        <div class="row">
                                            <div class="col-6">
                                                <p class="mb-1"><i class="fas fa-user-tie me-2 text-muted"></i><strong>Conductor:</strong> Juan Pedro</p>
                                                <p class="mb-1"><i class="fas fa-id-badge me-2 text-muted"></i><strong>Placa:</strong> GE-4521-B</p>
                                                <p class="mb-0"><i class="fas fa-users me-2 text-muted"></i><strong>Pasajeros:</strong> 38</p>
                                            </div>
                                            <div class="col-6">
                                                <p class="mb-1"><i class="fas fa-clock me-2 text-muted"></i><strong>Salida:</strong> 08:30</p>
                                                <p class="mb-1"><i class="fas fa-flag-checkered me-2 text-muted"></i><strong>Llegada:</strong> 13:15</p>
                                                <p class="mb-0"><i class="fas fa-star me-2 text-warning"></i><strong>Servicio:</strong> Oro</p>
                                            </div>
                                        </div>
                                    </div>

                                 
                                    <div class="col-md-4 bg-light-subtle d-flex flex-column justify-content-between p-4">
                                     
                                        <div>
                                            <p class="text-muted text-uppercase small mb-1">Trámite de viaje</p>
                                            <div class="progress mb-2" style="height: 6px;">
                                                <div class="progress-bar bg-success" style="width: 72%;"></div>
                                            </div>
                                            <p class="small text-success fw-semibold mb-3">72% Completado</p>

                                            <p class="text-muted text-uppercase small mb-1">Distancia restante</p>
                                            <p class="fw-bold">Total: 158 km <i class="fas fa-location-arrow me-2 text-info"></i> 89 km</p>
                                        </div>

                                     
                                        <div class="d-grid gap-2">
                                            <a href="#" class="btn btn-outline-primary w-100">
                                                <i class="fas fa-map me-2"></i> Ver trayecto en mapa
                                            </a>
                                            <a href="#" class="btn btn-outline-secondary w-100">
                                                <i class="fas fa-users me-2"></i> Lista de pasajeros
                                            </a>
                                        </div>
                                    </div>

                                </div>
                            </div> -->
                        </div>
                    </div>

                    <div class="table-responsive d-none" id="tablaLista">
                        <div class="container my-3" id="contenedor_viajes">
                            <!-- <div class="card shadow-sm rounded-3 border-0 p-3" style="max-width: 80%; margin: auto;">

                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <h6 class="mb-1 text-primary fw-bold"><i class="fas fa-ticket-alt me-2"></i>Viaje Nº 45231</h6>
                                        <p class="mb-0 text-muted"><i class="fas fa-building me-2"></i>Ndong Viajes</p>
                                    </div>
                                    <span class="badge bg-success px-3 py-2">En curso</span>
                                </div>

                                <hr class="my-2">

                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1 text-primary fw-bold"><i class="fas fa-ticket-alt me-2"></i>Viaje Nº 45232</h6>
                                        <p class="mb-0 text-muted"><i class="fas fa-building me-2"></i>Ndong Viajes</p>
                                    </div>
                                    <span class="badge bg-secondary px-3 py-2">Llegado</span>
                                </div>

                            </div> -->
                        </div>
                    </div>

                    <div class="table-responsive d-none" id="ContainerNuevoViaje">
                        <form id="viajeForm" class="viaje-form p-4 rounded shadow-lg">
                            <h2 class="text-center mb-4 text-primary">
                                <i class="fas fa-space-shuttle"></i> Nuevo Viaje
                            </h2>

                            <!-- Fecha de Llegada -->
                            <div class="form-group">
                                <label for="fecha"><i class="fas fa-calendar-alt"></i> Fecha del viaje</label>
                                <input type="date" name="fecha" class="form-control" id="fecha" required>
                                <small class="text-danger d-none" id="alert_fecha">
                                    <i class="fas fa-exclamation-triangle"></i> Este campo es obligatorio
                                </small>
                            </div>

                            <!-- Fecha de Llegada -->
                            <div class="form-group">
                                <label for="fecha_llegada"><i class="fas fa-calendar-alt"></i> Fecha de Llegada</label>
                                <input type="time" name="fecha_llegada" class="form-control" id="fecha_llegada" required>
                                <small class="text-danger d-none" id="alert_fecha_llegada">
                                    <i class="fas fa-exclamation-triangle"></i> Este campo es obligatorio
                                </small>
                            </div>


                            <!-- Cambia el id a busSelect -->
                            <div class="form-group">
                                <label for="busSelect"><i class="fas fa-bus"></i> Bus</label>
                                <select class="form-control" name="bus" id="busSelect" required>
                                    <option value="">Seleccione un bus</option>
                                </select>
                                <small class="text-danger d-none" id="alert_bus">
                                    <i class="fas fa-exclamation-triangle"></i> Este campo es obligatorio
                                </small>
                            </div>

                            <!-- Ruta -->
                            <div class="form-group">
                                <label for="ruta"><i class="fas fa-road"></i> Ruta</label>
                                <select class="form-control" name="ruta" id="ruta" required>
                                    <option value="">Seleccione una ruta</option>
                                </select>
                                <small class="text-danger d-none" id="alert_ruta">
                                    <i class="fas fa-exclamation-triangle"></i> Este campo es obligatorio
                                </small>
                            </div>

                            <!-- Campo oculto fecha inicial (de tabla rutas.horario) -->
                            <input type="hidden" name="fecha_inicial" id="fecha_inicial" value="">

                            <!-- Botón de envío -->
                            <button type="submit" class="btn btn-primary btn-block mt-3">
                                <i class="fas fa-save"></i> Establecer Viaje
                            </button>
                        </form>
                    </div>

                    <div class="table-responsive d-none" id="ContainerBuses">

                        <div class="table-responsive" id="ContainerBuses">
                            <!-- <div class="infoBus">
                                <div class="busConductorViaje">
                                    <h5 class="text-primary mb-3"><i class="fas fa-bus me-2"></i>Bus Nº 25</h5>
                                    <p class="mb-1"><i class="fas fa-user-tie me-2 text-muted"></i>Conductor: Juan Pedro</p>
                                    <p class="mb-1"><i class="fas fa-id-badge me-2 text-muted"></i>Placa: GE-4521-B</p>
                                    <p class="mb-0"><i class="fas fa-users me-2 text-muted"></i>Pasajeros: 20</p>
                                </div>
                                <div id="bus-container">
                                    <div id="left-seats" class="seat-group">
                                        <div class="seat" id="seat-1">
                                            <i class="fa-solid fa-chair seat-icon free"></i>
                                            <div class="seat-number">1</div>
                                        </div>
                                        <div class="seat occupied" id="seat-2">
                                            <i class="fa-solid fa-chair seat-icon occupied"></i>
                                            <div class="seat-number">2</div>
                                        </div>
                                        <div class="seat" id="seat-3">
                                            <i class="fa-solid fa-chair seat-icon free"></i>
                                            <div class="seat-number">3</div>
                                        </div>
                                        <div class="seat" id="seat-4">
                                            <i class="fa-solid fa-chair seat-icon free"></i>
                                            <div class="seat-number">4</div>
                                        </div>
                                        <div class="seat" id="seat-5">
                                            <i class="fa-solid fa-chair seat-icon free"></i>
                                            <div class="seat-number">5</div>
                                        </div>
                                        <div class="seat" id="seat-6">
                                            <i class="fa-solid fa-chair seat-icon free"></i>
                                            <div class="seat-number">6</div>
                                        </div>
                                        <div class="seat occupied" id="seat-7">
                                            <i class="fa-solid fa-chair seat-icon occupied"></i>
                                            <div class="seat-number">7</div>
                                        </div>
                                        <div class="seat" id="seat-8">
                                            <i class="fa-solid fa-chair seat-icon free"></i>
                                            <div class="seat-number">8</div>
                                        </div>
                                        <div class="seat" id="seat-9">
                                            <i class="fa-solid fa-chair seat-icon free"></i>
                                            <div class="seat-number">9</div>
                                        </div>
                                        <div class="seat" id="seat-10">
                                            <i class="fa-solid fa-chair seat-icon free"></i>
                                            <div class="seat-number">10</div>
                                        </div>
                                    </div>


                                    <div id="aisle"></div>

                                    <div id="right-seats" class="seat-group">
                                        <div class="seat" id="seat-11">
                                            <i class="fa-solid fa-chair seat-icon free"></i>
                                            <div class="seat-number">11</div>
                                        </div>
                                        <div class="seat" id="seat-12">
                                            <i class="fa-solid fa-chair seat-icon free"></i>
                                            <div class="seat-number">12</div>
                                        </div>
                                        <div class="seat" id="seat-13">
                                            <i class="fa-solid fa-chair seat-icon free"></i>
                                            <div class="seat-number">13</div>
                                        </div>
                                        <div class="seat occupied" id="seat-14">
                                            <i class="fa-solid fa-chair seat-icon occupied"></i>
                                            <div class="seat-number">14</div>
                                        </div>
                                        <div class="seat" id="seat-15">
                                            <i class="fa-solid fa-chair seat-icon free"></i>
                                            <div class="seat-number">15</div>
                                        </div>
                                        <div class="seat" id="seat-16">
                                            <i class="fa-solid fa-chair seat-icon free"></i>
                                            <div class="seat-number">16</div>
                                        </div>
                                        <div class="seat" id="seat-17">
                                            <i class="fa-solid fa-chair seat-icon free"></i>
                                            <div class="seat-number">17</div>
                                        </div>
                                        <div class="seat occupied" id="seat-18">
                                            <i class="fa-solid fa-chair seat-icon occupied"></i>
                                            <div class="seat-number">18</div>
                                        </div>
                                        <div class="seat" id="seat-19">
                                            <i class="fa-solid fa-chair seat-icon free"></i>
                                            <div class="seat-number">19</div>
                                        </div>
                                        <div class="seat" id="seat-20">
                                            <i class="fa-solid fa-chair seat-icon free"></i>
                                            <div class="seat-number">20</div>
                                        </div>
                                    </div>

                                </div>
                            </div> -->
                        </div>
                    </div>

                </main>
            </div>
        </div>

        <div class="window window_mapas" style="display: none;">
            <div class="window-header">
                <span>Mapas</span>
                <div class="window-controls">
                    <button class="btn-minimize"><i class="fa-solid fa-window-minimize"></i></button>
                    <button class="btn-maximize"><i class="fa-solid fa-window-maximize"></i></button>
                    <button class="btn-close"><i class="fa-solid fa-xmark"></i></button>
                </div>
            </div>
            <div class="window-content h-100 d-flex">
                <!-- Sidebar -->
                <aside class="bg-light border-end p-3" style="width: 220px;">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary mb-3" id="btnNuevaAgencia">
                            <i class="fas fa-plus-circle me-2"></i> Nueva
                        </button>
                    </div>
                </aside>

                <!-- Contenido central -->
                <main class="flex-grow-1 p-4 overflow-auto">
                    <h4 class="mb-4">Crear Rutas</h4>

                    <div class="table-responsive">
                        <div id="mapa" style="height: 400px; width: 100%;"></div>
                    </div>
                </main>
            </div>
        </div>


        <div class="window window_estadisticas" style="display: none;">
            <div class="window-header">
                <span>Estadisticas</span>
                <div class="window-controls">
                    <button class="btn-minimize"><i class="fa-solid fa-window-minimize"></i></button>
                    <button class="btn-maximize"><i class="fa-solid fa-window-maximize"></i></button>
                    <button class="btn-close"><i class="fa-solid fa-xmark"></i></button>
                </div>
            </div>
            <div class="window-content h-100 d-flex">
                <!-- Sidebar -->
                <aside class="bg-light border-end p-3" style="width: 220px;">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary mb-3" id="btnUsuarios">
                            <i class="fas fa-chart-line  me-2"></i> usuarios
                        </button>
                        <button class="btn btn-outline-primary mb-3" id="btnBuses">
                            <i class="fas fa-chart-line  me-2"></i> Buses
                        </button>
                        <button class="btn btn-outline-primary mb-3" id="btnRutas">
                            <i class="fas fa-chart-line  me-2"></i> Rutas
                        </button>
                        <button class="btn btn-outline-primary mb-3" id="btnReservas">
                            <i class="fas fa-chart-line  me-2"></i> Reservas
                        </button>
                        <button class="btn btn-outline-primary mb-3" id="btnVentas">
                            <i class="fas fa-chart-line  me-2"></i> Ventas
                        </button>
                        <button class="btn btn-outline-primary mb-3" id="btnViajes">
                            <i class="fas fa-chart-line  me-2"></i> Viajes
                        </button>
                        <button class="btn btn-outline-primary mb-3" id="btnIngresos">
                            <i class="fas fa-chart-line  me-2"></i> Ingresos
                        </button>
                    </div>
                </aside>

                <!-- Contenido central -->
                <main class="flex-grow-1 p-4 overflow-auto">
                    <h4 class="mb-4"></h4>

                    <div class="table-responsive px-3 py-4">

                        <div class="container-fluid px-4 py-3">
                            <div class="card shadow-lg border-0 rounded-4 bg-body-secondary w-100">
                                <div class="card-body" style="height: 270px;">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="card-title mb-0 text-primary fw-semibold">
                                            <i class="fas fa-chart-bar me-2"></i>Comparativa Semanal de Agencias
                                        </h5>
                                        <span class="badge bg-dark-subtle text-secondary fw-medium">Semana actual</span>
                                    </div>

                                    <!-- Gráfico barras horizontales -->
                                    <div style="height: 200px;">
                                        <canvas id="chartUsuarios"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>



                </main>
            </div>
        </div>


        <div class="window window_usuarios" style="display: none;">
            <div class="window-header">
                <span>Gestion de Usuarios</span>
                <div class="window-controls">
                    <button class="btn-minimize"><i class="fa-solid fa-window-minimize"></i></button>
                    <button class="btn-maximize"><i class="fa-solid fa-window-maximize"></i></button>
                    <button class="btn-close"><i class="fa-solid fa-xmark"></i></button>
                </div>
            </div>
            <div class="window-content h-100 d-flex">
                <!-- Sidebar -->
                <aside class="bg-light border-end p-3" style="width: 220px;">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary mb-3" id="btnNuevoUsuarios">
                            <i class="fa-solid fa-user-plus"></i> Nuevo
                        </button>
                        <button class="btn btn-outline-primary mb-3" id="btnNuevoEmpleado">
                            <i class="fa-solid fa-user-plus"></i> Empleado
                        </button>
                        <button class="btn btn-outline-primary mb-3" id="btnusuarios">
                            <i class="fa-solid fa-user"></i> Usuarios
                        </button>
                        <button class="btn btn-outline-primary mb-3" id="btnClientes">
                            <i class="fa-solid fa-user"></i> Clientes
                        </button>
                    </div>
                </aside>

                <!-- Contenido central -->
                <main class="flex-grow-1 p-4 overflow-auto">
                    <h4 class="mb-4">Gestion de Usuarios</h4>
                    <style>
                        .table img {
                            object-fit: cover;
                            border: 2px solid #dee2e6;
                        }
                    </style>

                    <div class="table-responsive" id="tablaUsuarios">
                        <table class="table table-bordered table-hover align-middle text-center">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Imagen</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Apellidos</th>
                                    <th scope="col">Edad</th>
                                    <th scope="col">DNI</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Teléfono</th>
                                    <th scope="col">Fecha Registro</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyUsuarios">
                                <!-- Los datos se cargan dinámicamente aquí -->
                            </tbody>
                        </table>
                    </div>

                    <div class="table-responsive d-none" id="tablaCliendo">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">First</th>
                                    <th scope="col">Last</th>
                                    <th scope="col">Handle</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>cliente</td>
                                    <td>Otto</td>
                                    <td>@mdo</td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>Jacob</td>
                                    <td>Thornton</td>
                                    <td>@fat</td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>John</td>
                                    <td>Doe</td>
                                    <td>@social</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <form id="formRegistroUsuario" method="$_POST" class="d-none" novalidate>
                        <div class="row g-3">

                            <!-- Nombre -->
                            <div class="col-md-6">
                                <label class="form-label">Nombre</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" name="nombre" id="nombreUsuario" class="form-control campo-validacion" required>
                                    <span class="input-group-text icono-validacion"><i class="fas fa-circle"></i></span>
                                </div>
                            </div>

                            <!-- Apellidos -->
                            <div class="col-md-6">
                                <label class="form-label">Apellidos</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                    <input type="text" name="apellidos" class="form-control campo-validacion" required>
                                    <span class="input-group-text icono-validacion"><i class="fas fa-circle"></i></span>
                                </div>
                            </div>

                            <!-- Edad -->
                            <div class="col-md-4">
                                <label class="form-label">Edad</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-birthday-cake"></i></span>
                                    <input type="number" name="edad" class="form-control campo-validacion" required min="1">
                                    <span class="input-group-text icono-validacion"><i class="fas fa-circle"></i></span>
                                </div>
                            </div>

                            <!-- DNI -->
                            <div class="col-md-4">
                                <label class="form-label">DNI</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                    <input type="text" name="dni" class="form-control campo-validacion" required pattern="[0-9]{8}[A-Za-z]">
                                    <span class="input-group-text icono-validacion"><i class="fas fa-circle"></i></span>
                                </div>
                            </div>

                            <!-- Teléfono -->
                            <div class="col-md-4">
                                <label class="form-label">Teléfono</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="tel" name="telefono" class="form-control campo-validacion" required pattern="[0-9\-]+">
                                    <span class="input-group-text icono-validacion"><i class="fas fa-circle"></i></span>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" name="email" id="email-user" class="form-control campo-validacion" required>
                                    <span class="input-group-text icono-validacion"><i class="fas fa-circle"></i></span>
                                </div>
                            </div>

                            <!-- Imagen -->
                            <div class="col-md-12">
                                <label class="form-label">Imagen</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-image"></i></span>
                                    <input type="file" name="imagen" class="form-control campo-validacion" required>
                                    <input type="text" name="agencia" value="<?= htmlspecialchars($agencia['id']) ?>" class="d-none">
                                    <span class="input-group-text icono-validacion"><i class="fas fa-circle"></i></span>
                                </div>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="mt-4 d-flex justify-content-between">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-user-plus me-1"></i> Registrar Usuario
                            </button>
                            <button type="button" class="btn btn-secondary" id="cancelar-usuario">
                                <i class="fas fa-times me-1"></i> Cancelar
                            </button>
                        </div>
                    </form>

                    <form id="formRegistroEmpleado" method="$_POST" class="d-none formEmpleados" novalidate>
                        <div class="row g-3 futuristic-form">

                            <!-- Nombre -->
                            <div class="col-md-6">
                                <label class="form-label">Nombre</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" name="nombre" class="form-control campo-validacion" required>
                                    <span class="input-group-text icono-validacion"><i class="fas fa-circle"></i></span>
                                </div>
                            </div>

                            <!-- Apellidos -->
                            <div class="col-md-6">
                                <label class="form-label">Apellidos</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                    <input type="text" name="apellidos" class="form-control campo-validacion" required>
                                    <span class="input-group-text icono-validacion"><i class="fas fa-circle"></i></span>
                                </div>
                            </div>

                            <!-- Edad -->
                            <div class="col-md-4">
                                <label class="form-label">Edad</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-birthday-cake"></i></span>
                                    <input type="number" name="edad" class="form-control campo-validacion" required min="1">
                                    <span class="input-group-text icono-validacion"><i class="fas fa-circle"></i></span>
                                </div>
                            </div>

                            <!-- Fecha de nacimiento -->
                            <div class="col-md-4">
                                <label class="form-label">Fecha de Nacimiento</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    <input type="date" name="fecha_nacimiento" class="form-control campo-validacion" required>
                                    <span class="input-group-text icono-validacion"><i class="fas fa-circle"></i></span>
                                </div>
                            </div>

                            <!-- DNI -->
                            <div class="col-md-4">
                                <label class="form-label">DNI</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                    <input type="text" name="dni" class="form-control campo-validacion" required pattern="[0-9]{8}[A-Za-z]">
                                    <span class="input-group-text icono-validacion"><i class="fas fa-circle"></i></span>
                                </div>
                            </div>

                            <!-- Teléfono -->
                            <div class="col-md-4">
                                <label class="form-label">Teléfono</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="tel" name="telefono" class="form-control campo-validacion" required pattern="[0-9\-]+">
                                    <span class="input-group-text icono-validacion"><i class="fas fa-circle"></i></span>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-md-4">
                                <label class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" name="email" class="form-control campo-validacion" required>
                                    <span class="input-group-text icono-validacion"><i class="fas fa-circle"></i></span>
                                </div>
                            </div>

                            <!-- Rol -->
                            <div class="col-md-4">
                                <label class="form-label">Rol</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user-cog"></i></span>
                                    <select name="rol" class="form-select campo-validacion" required>
                                        <option value="">Seleccione un rol</option>
                                        <option value="admin">Admin</option>
                                        <option value="empleado">Empleado</option>
                                        <option value="conductor">Conductor</option>
                                    </select>
                                    <span class="input-group-text icono-validacion"><i class="fas fa-circle"></i></span>
                                </div>
                            </div>

                            <!-- Imagen -->
                            <div class="col-md-12">
                                <label class="form-label">Imagen</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-image"></i></span>
                                    <input type="file" name="imagen" class="form-control campo-validacion" required>
                                    <input type="text" name="agencia" value="<?= htmlspecialchars($agencia['id']) ?>" class="d-none">
                                    <span class="input-group-text icono-validacion"><i class="fas fa-circle"></i></span>
                                </div>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="mt-4 d-flex justify-content-between">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-user-plus me-1"></i> Registrar Empleado
                            </button>
                            <button type="button" class="btn btn-secondary" id="cancelar-empleado">
                                <i class="fas fa-times me-1"></i> Cancelar
                            </button>
                        </div>

                    </form>

                    <script>
                        document.getElementById('btnNuevoEmpleado').addEventListener('click', function() {
                            document.getElementById('formRegistroEmpleado').classList.remove('d-none');
                            document.getElementById('formRegistroUsuario').classList.add('d-none');
                            document.getElementById('tablaUsuarios').classList.add('d-none');
                            document.getElementById('tablaCliendo').classList.add('d-none');
                        });
                    </script>

                </main>

                <!-- Contenedor de animación -->
                <div id="envioAnimacion" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:#0009; z-index:9999; justify-content:center; align-items:center;">
                    <div style="text-align:center;">
                        <div class="envoltorio">
                            <div class="sobre"></div>
                            <div class="papel"></div>
                        </div>
                        <p style="color:white; font-size:1.2em; margin-top:1em;">Enviando datos...</p>
                    </div>
                </div>

                <style>
                    .envoltorio {
                        position: relative;
                        width: 100px;
                        height: 60px;
                        margin: auto;
                        animation: volar 3s ease-in-out;
                    }

                    .sobre {
                        position: absolute;
                        width: 100px;
                        height: 60px;
                        background: #f4f4f4;
                        border: 2px solid #333;
                        border-radius: 5px;
                        transform: rotate(0deg);
                        z-index: 2;
                    }

                    .papel {
                        position: absolute;
                        top: -10px;
                        left: 10px;
                        width: 80px;
                        height: 40px;
                        background: #ff6;
                        z-index: 1;
                        transform: rotate(-10deg);
                    }

                    @keyframes volar {
                        0% {
                            transform: translateY(0) rotate(0deg);
                        }

                        25% {
                            transform: translateY(-20px) rotate(-10deg);
                        }

                        50% {
                            transform: translateY(-40px) rotate(10deg);
                        }

                        75% {
                            transform: translateY(-20px) rotate(-5deg);
                        }

                        100% {
                            transform: translateY(0) rotate(0deg);
                        }
                    }
                </style>


            </div>
        </div>

        <div class="window window_ganancias" style="display: none;">
            <div class="window-header">
                <span>Gestion de Ganancias</span>
                <div class="window-controls">
                    <button class="btn-minimize"><i class="fa-solid fa-window-minimize"></i></button>
                    <button class="btn-maximize"><i class="fa-solid fa-window-maximize"></i></button>
                    <button class="btn-close"><i class="fa-solid fa-xmark"></i></button>
                </div>
            </div>
            <div class="window-content h-100 d-flex flex-column">

                <div class="action-buttons mb-3 d-flex gap-3">
                    <button id="btn-pagos" class="btn btn-primary">
                        <i class="fas fa-credit-card"></i> Registrar Pago
                    </button>
                    <button id="btn-gastos" class="btn btn-danger">
                        <i class="fas fa-file-invoice-dollar"></i> Registrar Gasto
                    </button>
                </div>

                <!-- Pestañas -->
                <div class="tabs" role="tablist" aria-label="Periodo de ganancias">
                    <button class="tab-btn active" data-target="tab-dia" role="tab" aria-selected="true">Día</button>
                    <button class="tab-btn" data-target="tab-semana" role="tab" aria-selected="false">Semana</button>
                    <button class="tab-btn" data-target="tab-mes" role="tab" aria-selected="false">Mes</button>
                    <button class="tab-btn" data-target="tab-ano" role="tab" aria-selected="false">Año</button>
                </div>

                <!-- Contenido pestañas -->
                <div class="tab-panels" style="flex-grow:1; overflow:auto;">
                    <!-- Día -->
                    <section id="tab-dia" class="tab-panel" role="tabpanel" aria-hidden="false">
                        <div class="dashboard-grid">
                            <div class="card">
                                <h3>Ingresos del Día</h3>
                                <div class="value" id="ingresos-dia">$0.00</div>
                                <small>Ganancias totales del día actual</small>
                            </div>
                            <div class="card">
                                <h3>Gastos del Día</h3>
                                <div class="value" id="gastos-dia">$0.00</div>
                                <small>Costos operativos y gastos</small>
                            </div>
                            <div class="card card-pagos">
                                <h3>Pagos a Empleados</h3>
                                <div class="value" id="pagos-dia">$0.00</div>
                                <small>Total pagado a empleados en el día</small>
                            </div>
                            <div class="card">
                                <h3>Saldo Neto</h3>
                                <div class="value" id="saldo-dia">$0.00</div>
                                <small>Ingresos - Gastos - Pagos</small>
                            </div>
                            <div class="card">
                                <h3>Resumen Diario</h3>
                                <div id="resumen-dia">Sin datos</div>
                            </div>
                        </div>
                    </section>

                    <!-- Semana -->
                    <section id="tab-semana" class="tab-panel" role="tabpanel" aria-hidden="true" style="display:none;">
                        <div class="dashboard-grid">
                            <div class="card">
                                <h3>Ingresos de la Semana</h3>
                                <div class="value" id="ingresos-semana">$0.00</div>
                                <small>Ganancias totales últimos 7 días</small>
                            </div>
                            <div class="card">
                                <h3>Gastos de la Semana</h3>
                                <div class="value" id="gastos-semana">$0.00</div>
                                <small>Costos operativos y gastos</small>
                            </div>
                            <div class="card card-pagos">
                                <h3>Pagos a Empleados</h3>
                                <div class="value" id="pagos-semana">$0.00</div>
                                <small>Total pagado a empleados en la semana</small>
                            </div>
                            <div class="card">
                                <h3>Saldo Neto</h3>
                                <div class="value" id="saldo-semana">$0.00</div>
                                <small>Ingresos - Gastos - Pagos</small>
                            </div>
                            <div class="card">
                                <h3>Resumen Semanal</h3>
                                <div id="resumen-semana">Sin datos</div>
                            </div>
                        </div>
                    </section>

                    <!-- Mes -->
                    <section id="tab-mes" class="tab-panel" role="tabpanel" aria-hidden="true" style="display:none;">
                        <div class="dashboard-grid">
                            <div class="card">
                                <h3>Ingresos del Mes</h3>
                                <div class="value" id="ingresos-mes">$0.00</div>
                                <small>Ganancias totales del mes actual</small>
                            </div>
                            <div class="card">
                                <h3>Gastos del Mes</h3>
                                <div class="value" id="gastos-mes">$0.00</div>
                                <small>Costos operativos y gastos</small>
                            </div>
                            <div class="card card-pagos">
                                <h3>Pagos a Empleados</h3>
                                <div class="value" id="pagos-mes">$0.00</div>
                                <small>Total pagado a empleados en el mes</small>
                            </div>
                            <div class="card">
                                <h3>Saldo Neto</h3>
                                <div class="value" id="saldo-mes">$0.00</div>
                                <small>Ingresos - Gastos - Pagos</small>
                            </div>
                            <div class="card">
                                <h3>Resumen Mensual</h3>
                                <div id="resumen-mes">Sin datos</div>
                            </div>
                        </div>
                    </section>

                    <!-- Año -->
                    <section id="tab-ano" class="tab-panel" role="tabpanel" aria-hidden="true" style="display:none;">
                        <div class="dashboard-grid">
                            <div class="card">
                                <h3>Ingresos del Año</h3>
                                <div class="value" id="ingresos-ano">$0.00</div>
                                <small>Ganancias totales año actual</small>
                            </div>
                            <div class="card">
                                <h3>Gastos del Año</h3>
                                <div class="value" id="gastos-ano">$0.00</div>
                                <small>Costos operativos y gastos</small>
                            </div>
                            <div class="card card-pagos">
                                <h3>Pagos a Empleados</h3>
                                <div class="value" id="pagos-ano">$0.00</div>
                                <small>Total pagado a empleados en el año</small>
                            </div>
                            <div class="card">
                                <h3>Saldo Neto</h3>
                                <div class="value" id="saldo-ano">$0.00</div>
                                <small>Ingresos - Gastos - Pagos</small>
                            </div>
                            <div class="card">
                                <h3>Resumen Anual</h3>
                                <div id="resumen-ano">Sin datos</div>
                            </div>
                        </div>
                    </section>
                </div>

            </div>
            <!-- Formularios ocultos por defecto -->
            <div id="form-pagos" class="form-popup" style="display:none;">
                <form id="pago-form" class="form-corporate">
                    <h4><i class="fas fa-credit-card"></i> Registrar Pago a Empleado</h4>
                    <label for="empleado">Empleado</label>
                    <select id="empleado" name="empleado" required>
                        <option value="">Selecciona un empleado</option>
                        <!-- Opciones serán insertadas dinámicamente -->
                    </select>

                    <label for="monto-pago">Monto</label>
                    <input type="number" id="monto-pago" name="monto" min="0" step="0.01" placeholder="0.00 XAF" required>

                    <label for="fecha-pago">Fecha de Pago</label>
                    <input type="date" id="fecha-pago" name="fecha" required>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check"></i> Confirmar Pago
                        </button>
                        <button type="button" id="cancel-pago" class="btn btn-secondary">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>

            <div id="form-gastos" class="form-popup" style="display:none;">
                <form id="gasto-form" class="form-corporate">
                    <h4><i class="fas fa-file-invoice-dollar"></i> Registrar Gasto</h4>

                    <label for="descripcion-gasto">Descripción</label>
                    <input type="text" id="descripcion-gasto" name="descripcion" placeholder="Descripción del gasto" required>

                    <label for="monto-gasto">Monto</label>
                    <input type="number" id="monto-gasto" name="monto" min="0" step="0.01" placeholder="0.00 XAF" required>

                    <label for="fecha-gasto">Fecha del Gasto</label>
                    <input type="date" id="fecha-gasto" name="fecha" required>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-check"></i> Confirmar Gasto
                        </button>
                        <button type="button" id="cancel-gasto" class="btn btn-secondary">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="window window_ajustes" style="display: none;">
            <div class="window-header">
                <span>Viajes</span>
                <div class="window-controls">
                    <button class="btn-minimize"><i class="fa-solid fa-window-minimize"></i></button>
                    <button class="btn-maximize"><i class="fa-solid fa-window-maximize"></i></button>
                    <button class="btn-close"><i class="fa-solid fa-xmark"></i></button>
                </div>
            </div>

            <div class="window-content h-100 d-flex">
                <!-- Sidebar -->
                <aside class="bg-light border-end p-3" style="width: 220px;">
                    <button class="btn btn-outline-primary mb-2 setting-btn" data-target="modificar">
                        <i class="fa-solid fa-user-gear"></i> Modificar
                    </button>
                    <button class="btn btn-outline-primary mb-2 setting-btn" data-target="dispositivos">
                        <i class="fa-solid fa-mobile-screen-button"></i> Dispositivos Móviles
                    </button>
                    <button class="btn btn-outline-primary mb-2 setting-btn" data-target="red">
                        <i class="fa-solid fa-wifi"></i> Red e Internet
                    </button>
                    <button class="btn btn-outline-primary mb-2 setting-btn" data-target="personalizacion">
                        <i class="fa-solid fa-paint-roller"></i> Personalización
                    </button>
                    <button class="btn btn-outline-primary mb-2 setting-btn" data-target="hora">
                        <i class="fa-solid fa-clock"></i> Hora e Idioma
                    </button>
                    <button class="btn btn-outline-primary mb-2 setting-btn" data-target="accesibilidad">
                        <i class="fa-solid fa-universal-access"></i> Accesibilidad
                    </button>
                    <button class="btn btn-outline-primary mb-2 setting-btn" data-target="buscar">
                        <i class="fa-solid fa-magnifying-glass"></i> Buscar
                    </button>
                    <button class="btn btn-outline-primary mb-2 setting-btn" data-target="privacidad">
                        <i class="fa-solid fa-shield-halved"></i> Privacidad
                    </button>
                    <button class="btn btn-outline-primary mb-2 setting-btn" data-target="actualizaciones">
                        <i class="fa-solid fa-arrows-rotate"></i> Actualizaciones y Seguridad
                    </button>
                </aside>

                <!-- Main Content Area -->
                <main class="flex-grow-1 p-4 overflow-auto">
                    <div class="setting-section container py-4" id="modificar">
                        <h3 class="mb-3">Modificar Usuarios</h3>
                        <p class="text-muted">Aquí puedes modificar la información de los usuarios registrados, cambiar contraseñas y gestionar permisos.</p>

                        <!-- Buscador de usuarios -->
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" id="buscarUsuario" class="form-control" placeholder="Buscar por nombre, email o DNI">
                            <button class="btn btn-outline-primary" onclick="buscarUsuario()">Buscar</button>
                        </div>

                        <!-- Tabla de usuarios -->
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Imagen</th>
                                        <th>Nombre completo</th>
                                        <th>Email</th>
                                        <th>Teléfono</th>
                                        <th>Permiso</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaUsuarios">
                                    <!-- Aquí se insertarán dinámicamente los usuarios -->
                                    <!-- Ejemplo: -->
                                    <tr>
                                        <td><img src="" class="rounded-circle" width="40" alt="foto"></td>
                                        <td>Juan Pérez</td>
                                        <td>juan@example.com</td>
                                        <td>+240 555 123456</td>
                                        <td><span class="badge bg-success">Usuario</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-warning me-1" onclick="abrirEditarUsuario(1)"><i class="fas fa-edit"></i></button>
                                            <button class="btn btn-sm btn-danger me-1" onclick="eliminarUsuario(1)"><i class="fas fa-trash-alt"></i></button>
                                            <button class="btn btn-sm btn-secondary" onclick="abrirCambiarClave(1)"><i class="fas fa-key"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Modal para editar usuario -->
                        <div class="modal fade" id="modalEditarUsuario" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form id="formEditarUsuario">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title">Editar Usuario</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" id="editUserId">
                                            <div class="mb-3">
                                                <label for="editNombre" class="form-label">Nombre</label>
                                                <input type="text" class="form-control" id="editNombre" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="editEmail" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="editEmail" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="editTelefono" class="form-label">Teléfono</label>
                                                <input type="text" class="form-control" id="editTelefono">
                                            </div>
                                            <div class="mb-3">
                                                <label for="editPermiso" class="form-label">Permiso</label>
                                                <select class="form-select" id="editPermiso">
                                                    <option value="usuario">Usuario</option>
                                                    <option value="admin">Administrador</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-success">Guardar Cambios</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal para cambiar contraseña -->
                        <div class="modal fade" id="modalCambiarClave" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form id="formCambiarClave">
                                        <div class="modal-header bg-dark text-white">
                                            <h5 class="modal-title">Cambiar Contraseña</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" id="claveUserId">
                                            <div class="mb-3">
                                                <label for="nuevaClave" class="form-label">Nueva Contraseña</label>
                                                <input type="password" class="form-control" id="nuevaClave" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="confirmarClave" class="form-label">Confirmar Contraseña</label>
                                                <input type="password" class="form-control" id="confirmarClave" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-primary">Actualizar Clave</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="setting-section container py-4 d-none" id="dispositivos">
                        <h3 class="mb-3">Dispositivos Móviles</h3>
                        <p class="text-muted">Administra los dispositivos vinculados a tu cuenta. Puedes ver el estado, eliminar o agregar nuevos.</p>

                        <!-- Botón para agregar nuevo dispositivo -->
                        <div class="mb-3 text-end">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgregarDispositivo">
                                <i class="fas fa-plus-circle me-1"></i> Añadir nuevo dispositivo
                            </button>
                        </div>

                        <!-- Tabla de dispositivos -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nombre del Dispositivo</th>
                                        <th>Tipo</th>
                                        <th>Sistema Operativo</th>
                                        <th>Último Acceso</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaDispositivos">
                                    <!-- Dispositivos se insertan dinámicamente aquí -->
                                    <!-- Ejemplo de fila -->
                                    <tr>
                                        <td>Samsung Galaxy A20</td>
                                        <td>Móvil</td>
                                        <td>Android 11</td>
                                        <td>2025-06-20 09:12</td>
                                        <td><span class="badge bg-success">Activo</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-danger" onclick="eliminarDispositivo(1)">
                                                <i class="fas fa-trash-alt"></i> Quitar
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Modal para agregar nuevo dispositivo -->
                        <div class="modal fade" id="modalAgregarDispositivo" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form id="formAgregarDispositivo">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title">Añadir Dispositivo</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="nombreDispositivo" class="form-label">Nombre del Dispositivo</label>
                                                <input type="text" class="form-control" id="nombreDispositivo" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="tipoDispositivo" class="form-label">Tipo</label>
                                                <select class="form-select" id="tipoDispositivo" required>
                                                    <option value="">Seleccionar...</option>
                                                    <option value="Móvil">Móvil</option>
                                                    <option value="Tablet">Tablet</option>
                                                    <option value="Portátil">Portátil</option>
                                                    <option value="Otro">Otro</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="sistemaOperativo" class="form-label">Sistema Operativo</label>
                                                <input type="text" class="form-control" id="sistemaOperativo" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-success">Agregar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="setting-section container py-4 d-none" id="red">
                        <h3 class="mb-3">Red e Internet</h3>
                        <p class="text-muted">Configura tu conexión Wi-Fi, Ethernet o VPN. Verifica el estado de la red actual.</p>

                        <!-- Navegación de pestañas -->
                        <ul class="nav nav-tabs mb-3" id="networkTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="wifi-tab" data-bs-toggle="tab" data-bs-target="#wifi" type="button" role="tab">Wi-Fi</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="ethernet-tab" data-bs-toggle="tab" data-bs-target="#ethernet" type="button" role="tab">Ethernet</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="vpn-tab" data-bs-toggle="tab" data-bs-target="#vpn" type="button" role="tab">VPN</button>
                            </li>
                        </ul>

                        <!-- Contenido de pestañas -->
                        <div class="tab-content" id="networkTabsContent">

                            <!-- Wi-Fi -->
                            <div class="tab-pane fade show active" id="wifi" role="tabpanel">
                                <h5>Red Wi-Fi actual: <span class="badge bg-success">Ndong_Oficial</span></h5>
                                <div class="table-responsive mt-3">
                                    <table class="table table-hover table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Señal</th>
                                                <th>Seguridad</th>
                                                <th>Estado</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tablaWifi">
                                            <tr>
                                                <td>Ndong_Oficial</td>
                                                <td>Fuerte</td>
                                                <td>WPA2</td>
                                                <td><span class="badge bg-success">Conectado</span></td>
                                                <td><button class="btn btn-sm btn-danger">Desconectar</button></td>
                                            </tr>
                                            <tr>
                                                <td>Invitados_Ndong</td>
                                                <td>Media</td>
                                                <td>Abierta</td>
                                                <td><span class="badge bg-secondary">Disponible</span></td>
                                                <td><button class="btn btn-sm btn-primary">Conectar</button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Ethernet -->
                            <div class="tab-pane fade" id="ethernet" role="tabpanel">
                                <h5>Estado Ethernet: <span class="badge bg-secondary">No Conectado</span></h5>
                                <p class="mt-3">Conecta un cable Ethernet para establecer una conexión por cable.</p>
                            </div>

                            <!-- VPN -->
                            <div class="tab-pane fade" id="vpn" role="tabpanel">
                                <h5>VPNs configuradas</h5>
                                <ul class="list-group my-3" id="listaVPN">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        VPN de trabajo
                                        <span>
                                            <button class="btn btn-sm btn-success me-2">Conectar</button>
                                            <button class="btn btn-sm btn-danger">Eliminar</button>
                                        </span>
                                    </li>
                                </ul>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgregarVPN">
                                    <i class="fas fa-plus-circle me-1"></i> Añadir VPN
                                </button>
                            </div>
                        </div>

                        <!-- Modal para agregar VPN -->
                        <div class="modal fade" id="modalAgregarVPN" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form id="formAgregarVPN">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title">Nueva conexión VPN</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="vpnNombre" class="form-label">Nombre de la VPN</label>
                                                <input type="text" class="form-control" id="vpnNombre" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="vpnServidor" class="form-label">Servidor</label>
                                                <input type="text" class="form-control" id="vpnServidor" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="vpnUsuario" class="form-label">Usuario</label>
                                                <input type="text" class="form-control" id="vpnUsuario" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="vpnPassword" class="form-label">Contraseña</label>
                                                <input type="password" class="form-control" id="vpnPassword" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-success">Guardar VPN</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="setting-section container py-4 d-none" id="personalizacion">
                        <h3 class="mb-3">Personalización</h3>
                        <p class="text-muted">Cambia el tema, colores, fondo de pantalla y diseño del sistema para personalizar tu experiencia.</p>

                        <!-- Selector de tema -->
                        <div class="mb-4">
                            <h5><i class="fas fa-adjust me-2"></i>Tema del sistema</h5>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tema" id="temaClaro" value="claro" checked>
                                <label class="form-check-label" for="temaClaro">Claro</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tema" id="temaOscuro" value="oscuro">
                                <label class="form-check-label" for="temaOscuro">Oscuro</label>
                            </div>
                        </div>

                        <!-- Selector de color -->
                        <div class="mb-4">
                            <h5><i class="fas fa-palette me-2"></i>Color principal</h5>
                            <div class="d-flex flex-wrap gap-3">
                                <div class="color-option bg-primary" data-color="#0d6efd" title="Azul"></div>
                                <div class="color-option bg-success" data-color="#198754" title="Verde"></div>
                                <div class="color-option bg-danger" data-color="#dc3545" title="Rojo"></div>
                                <div class="color-option bg-warning" data-color="#ffc107" title="Amarillo"></div>
                                <div class="color-option bg-dark" data-color="#212529" title="Negro"></div>
                            </div>
                        </div>

                        <!-- Fondo de pantalla -->
                        <div class="mb-4">
                            <h5><i class="fas fa-image me-2"></i>Fondo de pantalla</h5>
                            <input type="file" class="form-control" id="fondoPantalla" accept="image/*">
                            <div class="mt-3">
                                <label class="form-label">Vista previa:</label>
                                <div class="border rounded" style="height: 150px; background-size: cover; background-position: center;" id="previewFondo"></div>
                            </div>
                        </div>

                        <!-- Guardar cambios -->
                        <div class="text-end mt-4">
                            <button class="btn btn-success" onclick="guardarPersonalizacion()">
                                <i class="fas fa-save me-1"></i> Guardar Cambios
                            </button>
                        </div>
                        <style>
                            .color-option {
                                width: 40px;
                                height: 40px;
                                border-radius: 50%;
                                cursor: pointer;
                                border: 2px solid transparent;
                            }

                            .color-option:hover {
                                border-color: #000;
                            }

                            .color-option.selected {
                                border: 3px solid #000;
                            }
                        </style>

                    </div>


                    <div class="setting-section container py-4 d-none" id="hora">
                        <h3 class="mb-3">Hora e Idioma de Guinea Ecuatorial</h3>
                        <p class="text-muted">Ajusta la zona horaria y el idioma del sistema específicamente para usuarios de Guinea Ecuatorial.</p>

                        <!-- Zona Horaria de Guinea Ecuatorial -->
                        <div class="mb-4">
                            <h5><i class="fas fa-globe-africa me-2"></i>Zona Horaria</h5>
                            <select class="form-select" id="zonaHoraria">
                                <option value="Africa/Malabo" selected>🇬🇶 África/Malabo (UTC+1)</option>
                            </select>
                            <div class="form-text">Hora oficial de Guinea Ecuatorial (misma que Europa Central).</div>
                        </div>

                        <!-- Formato de hora -->
                        <div class="mb-4">
                            <h5><i class="fas fa-clock me-2"></i>Formato de Hora</h5>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="formatoHora" id="formato12h" value="12" checked>
                                <label class="form-check-label" for="formato12h">12 Horas (AM/PM)</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="formatoHora" id="formato24h" value="24">
                                <label class="form-check-label" for="formato24h">24 Horas</label>
                            </div>
                        </div>

                        <!-- Idioma -->
                        <div class="mb-4">
                            <h5><i class="fas fa-language me-2"></i>Idioma Preferido</h5>
                            <select class="form-select" id="idiomaSistema">
                                <option value="es" selected>🇬🇶 Español (Guinea Ecuatorial)</option>
                                <option value="fr">🇫🇷 Francés</option>
                                <option value="pt">🇵🇹 Portugués</option>
                            </select>
                            <div class="form-text">Idiomas oficiales reconocidos en Guinea Ecuatorial.</div>
                        </div>

                        <!-- Guardar -->
                        <div class="text-end mt-4">
                            <button class="btn btn-primary" onclick="guardarHoraIdioma()">
                                <i class="fas fa-save me-1"></i> Guardar Cambios
                            </button>
                        </div>
                        <script>
                            function guardarHoraIdioma() {
                                const zona = document.getElementById('zonaHoraria').value;
                                const idioma = document.getElementById('idiomaSistema').value;
                                const formato = document.querySelector('input[name="formatoHora"]:checked').value;

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Configuración guardada',
                                    html: `
                                    <b>Zona horaria:</b> ${zona}<br>
                                    <b>Formato:</b> ${formato} horas<br>
                                    <b>Idioma:</b> ${idioma.toUpperCase()}
                                `,
                                    confirmButtonText: 'Aceptar'
                                });
                            }
                        </script>

                    </div>


                    <div class="setting-section container py-4 d-none" id="accesibilidad">
                        <h3 class="mb-3">Accesibilidad</h3>
                        <p class="text-muted">Activa opciones para mejorar la experiencia de usuarios con necesidades especiales.</p>

                        <!-- Texto grande -->
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="textoGrande">
                            <label class="form-check-label" for="textoGrande">
                                Texto grande
                            </label>
                        </div>

                        <!-- Alto contraste -->
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="altoContraste">
                            <label class="form-check-label" for="altoContraste">
                                Alto contraste (modo oscuro fuerte)
                            </label>
                        </div>

                        <!-- Narrador (simulado) -->
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="narrador">
                            <label class="form-check-label" for="narrador">
                                Narrador (lectura de texto)
                            </label>
                        </div>

                        <!-- Botón de guardar -->
                        <div class="text-end mt-4">
                            <button class="btn btn-primary" onclick="guardarAccesibilidad()">
                                <i class="fas fa-universal-access me-1"></i> Guardar Cambios
                            </button>
                        </div>
                        <style>
                            body.texto-grande {
                                font-size: 1.25rem;
                            }

                            body.alto-contraste {
                                background-color: #000 !important;
                                color: #fff !important;
                            }

                            body.alto-contraste a {
                                color: #00ffff !important;
                            }
                        </style>
                        <script>
                            function guardarAccesibilidad() {
                                const textoGrande = document.getElementById('textoGrande').checked;
                                const altoContraste = document.getElementById('altoContraste').checked;
                                const narrador = document.getElementById('narrador').checked;

                                // Aplicar clases al <body>
                                document.body.classList.toggle('texto-grande', textoGrande);
                                document.body.classList.toggle('alto-contraste', altoContraste);

                                // Narrador simulado
                                if (narrador) {
                                    const mensaje = "La accesibilidad ha sido activada. Texto grande, alto contraste y narrador están activos.";
                                    const speech = new SpeechSynthesisUtterance(mensaje);
                                    speech.lang = "es-ES";
                                    window.speechSynthesis.speak(speech);
                                }

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Accesibilidad actualizada',
                                    text: 'Tus preferencias han sido aplicadas correctamente.'
                                });
                            }
                        </script>
                    </div>

                    <div class="setting-section container py-4 d-none" id="buscar">
                        <h3 class="mb-3">Buscar</h3>
                        <p class="text-muted">Gestiona cómo y dónde se realizan las búsquedas dentro del sistema.</p>

                        <!-- Activar búsqueda en tiempo real -->
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="busquedaTiempoReal">
                            <label class="form-check-label" for="busquedaTiempoReal">
                                Activar búsqueda en tiempo real
                            </label>
                        </div>

                        <!-- Activar historial de búsqueda -->
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="historialBusqueda">
                            <label class="form-check-label" for="historialBusqueda">
                                Guardar historial de búsqueda
                            </label>
                        </div>

                        <!-- Filtros de búsqueda -->
                        <div class="mb-3">
                            <label for="filtroBusqueda" class="form-label">Áreas donde buscar:</label>
                            <select class="form-select" id="filtroBusqueda" multiple>
                                <option value="usuarios">Usuarios</option>
                                <option value="rutas">Rutas</option>
                                <option value="buses">Buses</option>
                                <option value="agencias">Agencias</option>
                                <option value="reservas">Reservas</option>
                            </select>
                            <small class="form-text text-muted">Mantén pulsado Ctrl (o Cmd en Mac) para seleccionar múltiples áreas.</small>
                        </div>

                        <!-- Botón Guardar -->
                        <div class="text-end mt-4">
                            <button class="btn btn-primary" onclick="guardarConfiguracionBusqueda()">
                                <i class="fas fa-search me-1"></i> Guardar Configuración
                            </button>
                        </div>
                        <script>
                            function guardarConfiguracionBusqueda() {
                                const tiempoReal = document.getElementById('busquedaTiempoReal').checked;
                                const historial = document.getElementById('historialBusqueda').checked;
                                const filtro = Array.from(document.getElementById('filtroBusqueda').selectedOptions).map(opt => opt.value);

                                // Simular guardado (localStorage, backend, etc.)
                                console.log("Configuración de búsqueda guardada:", {
                                    tiempoReal,
                                    historial,
                                    filtro
                                });

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Configuración guardada',
                                    text: 'Tus preferencias de búsqueda han sido actualizadas.'
                                });

                                // Opcional: guardar en localStorage
                                localStorage.setItem('configBusqueda', JSON.stringify({
                                    tiempoReal,
                                    historial,
                                    filtro
                                }));
                            }
                        </script>

                    </div>

                    <div class="setting-section container py-4 d-none" id="privacidad">
                        <h3 class="mb-3">Privacidad</h3>
                        <p class="text-muted">Controla qué información compartes con el sistema y las aplicaciones. Gestiona permisos.</p>

                        <!-- Compartir ubicación -->
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="compartirUbicacion" checked>
                            <label class="form-check-label" for="compartirUbicacion">Compartir mi ubicación</label>
                        </div>

                        <!-- Permitir acceso a cámara -->
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="accesoCamara" checked>
                            <label class="form-check-label" for="accesoCamara">Permitir acceso a la cámara</label>
                        </div>

                        <!-- Permitir acceso a micrófono -->
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="accesoMicrofono" checked>
                            <label class="form-check-label" for="accesoMicrofono">Permitir acceso al micrófono</label>
                        </div>

                        <!-- Compartir datos con terceros -->
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="compartirDatosTerceros">
                            <label class="form-check-label" for="compartirDatosTerceros">Compartir datos con terceros</label>
                        </div>

                        <!-- Botón para guardar -->
                        <div class="text-end mt-4">
                            <button class="btn btn-primary" onclick="guardarPrivacidad()">
                                <i class="fas fa-save me-1"></i> Guardar Preferencias
                            </button>
                        </div>
                    </div>

                    <script>
                        function guardarPrivacidad() {
                            const privacidad = {
                                compartirUbicacion: document.getElementById('compartirUbicacion').checked,
                                accesoCamara: document.getElementById('accesoCamara').checked,
                                accesoMicrofono: document.getElementById('accesoMicrofono').checked,
                                compartirDatosTerceros: document.getElementById('compartirDatosTerceros').checked
                            };

                            console.log('Configuración de privacidad guardada:', privacidad);

                            // Aquí puedes añadir guardado en backend o localStorage

                            Swal.fire({
                                icon: 'success',
                                title: 'Configuración guardada',
                                text: 'Tus preferencias de privacidad han sido actualizadas.'
                            });
                        }
                    </script>

                    <div class="setting-section container py-4 d-none" id="actualizaciones">
                        <h3 class="mb-3">Actualizaciones y Seguridad</h3>
                        <p class="text-muted">Comprueba actualizaciones del sistema, crea copias de seguridad y ajusta opciones de seguridad.</p>

                        <!-- Estado de actualizaciones -->
                        <div class="mb-3">
                            <h5>Estado de Actualizaciones</h5>
                            <p id="estadoActualizaciones" class="text-success">Tu sistema está actualizado.</p>
                            <button class="btn btn-outline-primary" onclick="verificarActualizaciones()">
                                <i class="fas fa-sync-alt me-1"></i> Buscar actualizaciones
                            </button>
                        </div>

                        <!-- Copias de seguridad -->
                        <div class="mb-3">
                            <h5>Copias de Seguridad</h5>
                            <p>Realiza una copia de seguridad de tus datos para evitar pérdidas.</p>
                            <button class="btn btn-outline-success" onclick="crearCopiaSeguridad()">
                                <i class="fas fa-cloud-upload-alt me-1"></i> Crear copia de seguridad
                            </button>
                        </div>

                        <!-- Opciones de seguridad -->
                        <div class="mb-3">
                            <h5>Opciones de Seguridad</h5>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="activarFirewall" checked>
                                <label class="form-check-label" for="activarFirewall">
                                    Activar firewall del sistema
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="notificacionesSeguridad" checked>
                                <label class="form-check-label" for="notificacionesSeguridad">
                                    Recibir notificaciones de seguridad
                                </label>
                            </div>
                        </div>

                        <div class="text-end mt-4">
                            <button class="btn btn-primary" onclick="guardarConfiguracionSeguridad()">
                                <i class="fas fa-save me-1"></i> Guardar configuración
                            </button>
                        </div>
                    </div>

                    <script>
                        function verificarActualizaciones() {
                            // Simulación de búsqueda de actualizaciones
                            document.getElementById('estadoActualizaciones').textContent = 'Buscando actualizaciones...';

                            setTimeout(() => {
                                // Resultado simulado
                                document.getElementById('estadoActualizaciones').textContent = 'Tu sistema está actualizado.';
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Actualizaciones',
                                    text: 'No hay nuevas actualizaciones disponibles.'
                                });
                            }, 2000);
                        }

                        function crearCopiaSeguridad() {
                            Swal.fire({
                                icon: 'info',
                                title: 'Copia de Seguridad',
                                text: 'Creando copia de seguridad, por favor espera...',
                                didOpen: () => {
                                    Swal.showLoading()
                                },
                                allowOutsideClick: false
                            });

                            setTimeout(() => {
                                Swal.close();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Copia creada',
                                    text: 'La copia de seguridad se ha creado correctamente.'
                                });
                            }, 3000);
                        }

                        function guardarConfiguracionSeguridad() {
                            const configuracion = {
                                firewall: document.getElementById('activarFirewall').checked,
                                notificaciones: document.getElementById('notificacionesSeguridad').checked,
                            };

                            console.log('Configuración de seguridad guardada:', configuracion);

                            Swal.fire({
                                icon: 'success',
                                title: 'Configuración guardada',
                                text: 'Tus preferencias de seguridad han sido actualizadas.'
                            });
                        }
                    </script>

                </main>
            </div>
        </div>

        <!-- JavaScript para alternar visibilidad -->
        <script>
            document.querySelectorAll('.setting-btn').forEach(button => {
                button.addEventListener('click', () => {
                    const targetId = button.getAttribute('data-target');
                    document.querySelectorAll('.setting-section').forEach(section => {
                        section.classList.add('d-none');
                    });
                    document.getElementById(targetId).classList.remove('d-none');
                });
            });
        </script>


        <div class="window window_manual" style="display: none;">
            <div class="window-header">
                <span>Manual de ayuda <i class="fas fa-question-circle"></i></span>
                <div class="window-controls">
                    <button class="btn-minimize"><i class="fa-solid fa-window-minimize"></i></button>
                    <button class="btn-maximize"><i class="fa-solid fa-window-maximize"></i></button>
                    <button class="btn-close"><i class="fa-solid fa-xmark"></i></button>
                </div>
            </div>
            <div class="window-content h-100 d-flex">
                <div class="manual-content" style="padding: 25px; color: #222; font-size: 15px; line-height: 1.7;">
                    <h2 style="margin-bottom: 15px;">
                        <i class="fas fa-question-circle" style="color: #005eff;"></i> Manual de Ayuda del Sistema
                    </h2>
                    <p><strong>Bienvenido al sistema de gestión.</strong> A continuación, encontrarás una descripción completa de cada botón del panel principal, para que puedas navegar y operar eficientemente la plataforma.</p>

                    <ul style="list-style: none; padding-left: 0; margin-top: 25px;">
                        <li style="margin-bottom: 15px;">
                            <i class="fa-solid fa-house-chimney" style="color:#005eff;"></i>
                            <strong>Inicio:</strong><br>
                            Accede a la <strong>pantalla principal</strong> o <em>dashboard</em>, donde podrás obtener una visión general del sistema: estadísticas rápidas, accesos directos y notificaciones importantes.
                        </li>

                        <li style="margin-bottom: 15px;">
                            <i class="fa-solid fa-user-plus" style="color:#005eff;"></i>
                            <strong>Usuarios:</strong><br>
                            Gestiona los <strong>usuarios del sistema</strong>. Puedes <strong>registrar nuevos usuarios</strong>, editar sus datos o eliminar perfiles. Este módulo es esencial para el control de acceso y permisos.
                        </li>

                        <li style="margin-bottom: 15px;">
                            <i class="fa-solid fa-road" style="color:#005eff;"></i>
                            <strong>Rutas:</strong><br>
                            Administra las diferentes <strong>rutas de transporte</strong>. Aquí puedes <strong>crear recorridos nuevos</strong>, editar paradas y asignar trayectos a agencias o buses específicos.
                        </li>

                        <li style="margin-bottom: 15px;">
                            <i class="fa-solid fa-bus" style="color:#005eff;"></i>
                            <strong>Buses:</strong><br>
                            Control total sobre la <strong>flota de autobuses</strong>. Podrás registrar buses nuevos, ver su estado, disponibilidad y asignarlos a rutas según programación.
                        </li>

                        <li style="margin-bottom: 15px;">
                            <i class="fa-solid fa-ticket" style="color:#005eff;"></i>
                            <strong>Reservas:</strong><br>
                            Visualiza y gestiona las <strong>reservas activas o pendientes</strong> de los usuarios. Puedes <strong>confirmar, editar o cancelar</strong> reservas, y verificar detalles como tipo de servicio, horario y ruta asociada.
                        </li>

                        <li style="margin-bottom: 15px;">
                            <i class="fa-solid fa-map-location-dot" style="color:#005eff;"></i>
                            <strong>Viajes:</strong><br>
                            Módulo para el <strong>seguimiento y control de los viajes</strong> en curso. Aquí podrás <strong>iniciar, pausar o finalizar</strong> un viaje, así como monitorear su estado en tiempo real.
                        </li>

                        <li style="margin-bottom: 15px;">
                            <i class="fa-solid fa-map" style="color:#005eff;"></i>
                            <strong>Mapa:</strong><br>
                            Accede a un <strong>mapa interactivo</strong> donde se representan rutas, estaciones, agencias y la posición actual de los buses, en caso de contar con geolocalización habilitada.
                        </li>

                        <li style="margin-bottom: 15px;">
                            <i class="fa-solid fa-sack-dollar" style="color:#005eff;"></i>
                            <strong>Ganancias:</strong><br>
                            Consulta las <strong>ganancias económicas</strong> obtenidas por el sistema. Podrás ver reportes diarios, semanales o mensuales, así como estadísticas de ingreso por servicio.
                        </li>

                        <li style="margin-bottom: 15px;">
                            <i class="fa-solid fa-ranking-star" style="color:#005eff;"></i>
                            <strong>Estadísticas:</strong><br>
                            Muestra gráficas y reportes analíticos del <strong>uso y rendimiento del sistema</strong>: número de reservas, usuarios activos, rutas más usadas, y comparativas mensuales.
                        </li>

                        <li style="margin-bottom: 15px;">
                            <i class="fa-solid fa-circle-user" style="color:#005eff;"></i>
                            <strong>Perfil:</strong><br>
                            Aquí podrás <strong>ver y editar tus datos personales</strong>, cambiar tu contraseña, actualizar tu imagen de perfil o cerrar sesión de forma segura.
                        </li>

                        <li style="margin-bottom: 15px;">
                            <i class="fas fa-question-circle" style="color:#005eff;"></i>
                            <strong>Manual:</strong><br>
                            Este botón abre la <strong>ventana de ayuda</strong> que estás viendo, donde se explica cada función y módulo del sistema para facilitar tu experiencia.
                        </li>
                    </ul>

                    <p style="margin-top: 30px;"><strong>¿Tienes dudas?</strong> No dudes en consultar esta sección cuando necesites una guía rápida.</p>
                </div>

            </div>
        </div>


        <div id="ventanas-minimizadas"></div>


        <!-- Agrega más ventanas como esta con diferentes clases: window_rutas, window_buses, etc. -->
    </main>


    <footer class="footer-navbar">
        <nav class="navbar-dock">
            <!-- Icono de la app o sistema -->
            <div class="logo-section">
                <strong>
                    <h style="color:white;"><?= htmlspecialchars($agencia['nombre']) ?></h4>
                </strong>
            </div>


            <!-- Buscador de ayuda -->
            <div class="search-help">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" placeholder="Ayuda rápida...">
            </div>

            <!-- Botones de acciones -->
            <div class="dock-buttons">
                <button class="dock-btn" id="refresAll">
                    <i class="fa-solid fa-house-chimney"></i>
                    <span class="tooltip-text">Inicio</span>
                </button>
                <button class="dock-btn" data-nombre="usuarios">
                    <i class="fa-solid fa-user-plus"></i>
                    <span class="tooltip-text">Usuarios</span>
                </button>
                <button class="dock-btn" data-nombre="rutas">
                    <i class="fa-solid fa-road"></i>
                    <span class="tooltip-text">Rutas</span>
                </button>
                <button class="dock-btn" data-nombre="buses">
                    <i class="fa-solid fa-bus"></i>
                    <span class="tooltip-text">Buses</span>
                </button>
                <button class="dock-btn" data-nombre="reservas">
                    <i class="fa-solid fa-ticket"></i>
                    <span class="tooltip-text">Reservas</span>
                </button>
                <button class="dock-btn" data-nombre="viajes">
                    <i class="fa-solid fa-map-location-dot"></i>
                    <span class="tooltip-text">Viajes</span>
                </button>
                <button class="dock-btn" data-nombre="mapas">
                    <i class="fa-solid fa-map"></i>
                    <span class="tooltip-text">Mapa</span>
                </button>
                <button class="dock-btn" data-nombre="ganancias">
                    <i class="fa-solid fa-sack-dollar"></i>
                    <span class="tooltip-text">Ganancias</span>
                </button>
                <button class="dock-btn" data-nombre="estadisticas">
                    <i class="fa-solid fa-ranking-star"></i>
                    <span class="tooltip-text">Estadísticas</span>
                </button>
                <button class="dock-btn" data-nombre="ajustes">
                    <i class="fas fa-gear"></i>
                    <span class="tooltip-text">Ajustes</span>
                </button>
                <button class="dock-btn" data-nombre="manual">
                    <i class="fas fa-question-circle"></i>
                    <span class="tooltip-text">Manual</span>
                </button>
            </div>
        </nav>
        <button class="dock-btn off" id="Sesion-close" title="Cerrar Sesion">
            <i style="color: red;" class="fa-solid fa-power-off"></i>
        </button>
    </footer>


    <script>
        setTimeout(() => {
            const bienvenida = document.getElementById("pantalla-bienvenida");
            const contenido = document.getElementById("contenido");
            bienvenida.style.display = "none";
            contenido.style.display = "block";
        }, 6000); // un segundo extra para terminar la animación
    </script>

    <script>
        const tarjeta = document.getElementById("targeta");
        let isDragging = false;
        let offsetX, offsetY;

        tarjeta.addEventListener("mousedown", (e) => {
            isDragging = true;
            offsetX = e.clientX - tarjeta.getBoundingClientRect().left;
            offsetY = e.clientY - tarjeta.getBoundingClientRect().top;
            tarjeta.style.cursor = "grabbing";
        });

        document.addEventListener("mousemove", (e) => {
            if (isDragging) {
                tarjeta.style.left = `${e.clientX - offsetX}px`;
                tarjeta.style.top = `${e.clientY - offsetY}px`;
                tarjeta.style.transform = "none"; // Para cancelar el centrado inicial al mover
            }
        });

        document.addEventListener("mouseup", () => {
            isDragging = false;
            tarjeta.style.cursor = "grab";
        });
    </script>



    <script src="../../../controllers/js/bootstrap.min.js"></script>
    <script src="../../../controllers/js/sweetalert2.js"></script>
    <script src="../../../controllers/js/admin_controlers2.js"></script>
    <script src="../../../controllers/js/sub_controlers.js"></script>
    <script async
        src="https://maps.googleapis.com/maps/api/js?key=TU_CLAVE_API&callback=initMap">
    </script>
</body>

</html>