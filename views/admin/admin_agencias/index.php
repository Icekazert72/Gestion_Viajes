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
$sql = "SELECT id, nombre, direccion, telefono, email, usuario, imagen FROM agencias WHERE id = ?";
$stmt = $conn->prepare($sql);
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

        <div class="window window_agencias" style="display: none;">
            <div class="window-header">
                <span>Agencias</span>
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
                            <i class="fas fa-plus-circle me-2"></i>
                        </button>
                    </div>
                </aside>

                <!-- Contenido central -->
                <main class="flex-grow-1 p-4 overflow-auto">
                    <h4 class="mb-4">Agencias registradas</h4>

                    <div class="table-responsive" id="tablaAgencias">
                        <table class="table table-hover align-middle table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Ubicación</th>
                                    <th>Teléfono</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Agencia Central</td>
                                    <td>Ciudad Principal</td>
                                    <td>123-456-789</td>
                                    <td><span class="badge bg-success">Activa</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <form id="formNuevaAgencia" class="d-none" novalidate>
                        <div class="row g-3">

                            <!-- Nombre -->
                            <div class="col-md-6">
                                <label class="form-label">Nombre de Agencia</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-building"></i></span>
                                    <input type="text" class="form-control campo-validacion" required>
                                    <span class="input-group-text icono-validacion"><i class="fas fa-circle"></i></span>
                                </div>
                            </div>

                            <!-- Dirección -->
                            <div class="col-md-6">
                                <label class="form-label">Dirección</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    <input type="text" class="form-control campo-validacion" required>
                                    <span class="input-group-text icono-validacion"><i class="fas fa-circle"></i></span>
                                </div>
                            </div>

                            <!-- Teléfono -->
                            <div class="col-md-6">
                                <label class="form-label">Teléfono</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="tel" class="form-control campo-validacion" required pattern="[0-9\-]+">
                                    <span class="input-group-text icono-validacion"><i class="fas fa-circle"></i></span>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control campo-validacion" required>
                                    <span class="input-group-text icono-validacion"><i class="fas fa-circle"></i></span>
                                </div>
                            </div>

                            <!-- Usuario -->
                            <div class="col-md-6">
                                <label class="form-label">Usuario</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control campo-validacion" required>
                                    <span class="input-group-text icono-validacion"><i class="fas fa-circle"></i></span>
                                </div>
                            </div>

                            <!-- Contraseña -->
                            <div class="col-md-6">
                                <label class="form-label">Contraseña</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control campo-validacion" required minlength="6">
                                    <span class="input-group-text icono-validacion"><i class="fas fa-circle"></i></span>
                                </div>
                            </div>

                            <!-- Imagen -->
                            <div class="col-md-12">
                                <label class="form-label">Imagen</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-image"></i></span>
                                    <input type="file" class="form-control campo-validacion" required>
                                    <span class="input-group-text icono-validacion"><i class="fas fa-circle"></i></span>
                                </div>
                            </div>

                        </div>

                        <!-- Botones -->
                        <div class="mt-4 d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Guardar Agencia
                            </button>
                            <button type="button" class="btn btn-secondary" id="cancelar-agencia">
                                <i class="fas fa-times me-1"></i> Cancelar
                            </button>
                        </div>
                    </form>

                </main>

            </div>

        </div>
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
                    <div class="container my-5 d-none" id="formRutas">
                        <div class="card shadow-lg p-4">
                            <h4 class="mb-4"><i class="fas fa-road text-primary me-2"></i>Registro de Ruta</h4>
                            <form id="rutaForm" novalidate>
                                <div class="row g-3">
                                    <!-- Origen -->
                                    <div class="col-md-6">
                                        <label for="origen" class="form-label"><i class="fas fa-map-marker-alt me-1 text-primary"></i>Origen</label>
                                        <input type="text" class="form-control" id="origen" required>
                                        <span class="valid-span text-success d-none"><i class="fas fa-check-circle"></i> ¡Correcto!</span>
                                        <span class="invalid-span text-danger d-none"><i class="fas fa-exclamation-circle"></i> Campo requerido.</span>
                                    </div>

                                    <!-- Destino -->
                                    <div class="col-md-6">
                                        <label for="destino" class="form-label"><i class="fas fa-location-arrow me-1 text-success"></i>Destino</label>
                                        <input type="text" class="form-control" id="destino" required>
                                        <span class="valid-span text-success d-none"><i class="fas fa-check-circle"></i> ¡Correcto!</span>
                                        <span class="invalid-span text-danger d-none"><i class="fas fa-exclamation-circle"></i> Campo requerido.</span>
                                    </div>

                                    <!-- Horario -->
                                    <div class="col-md-6">
                                        <label for="horario" class="form-label"><i class="fas fa-clock me-1 text-warning"></i>Horario</label>
                                        <input type="text" class="form-control" id="horario" placeholder="Ej: 08:00 - 14:00" required>
                                        <span class="valid-span text-success d-none"><i class="fas fa-check-circle"></i> ¡Correcto!</span>
                                        <span class="invalid-span text-danger d-none"><i class="fas fa-exclamation-circle"></i> Campo requerido.</span>
                                    </div>

                                    <!-- Precio -->
                                    <div class="col-md-6">
                                        <label for="precio" class="form-label"><i class="fas fa-money-bill me-1 text-success"></i>Precio</label>
                                        <input type="number" class="form-control" id="precio" min="0" step="0.01" required>
                                        <span class="valid-span text-success d-none"><i class="fas fa-check-circle"></i> ¡Correcto!</span>
                                        <span class="invalid-span text-danger d-none"><i class="fas fa-exclamation-circle"></i> Ingrese un precio válido.</span>
                                    </div>

                                    <!-- Región -->
                                    <div class="col-md-6">
                                        <label for="region" class="form-label"><i class="fas fa-globe-africa me-1 text-info"></i>Región</label>
                                        <select class="form-select" id="region" required>
                                            <option value="">Seleccione una opción</option>
                                            <option value="continental">Continental</option>
                                            <option value="insular">Insular</option>
                                        </select>
                                        <span class="valid-span text-success d-none"><i class="fas fa-check-circle"></i> ¡Correcto!</span>
                                        <span class="invalid-span text-danger d-none"><i class="fas fa-exclamation-circle"></i> Seleccione una región.</span>
                                    </div>
                                </div>

                                <div class="mt-4 text-end">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Registrar Ruta</button>
                                </div>
                            </form>
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
                        <button class="btn btn-outline-primary mb-3" id="btnBuses">
                            <i class="fa-solid fa-bus"></i> Buses
                        </button>
                        <button class="btn btn-outline-primary mb-3" id="btnConductores">
                            <i class="fa-solid fa-user-group"></i> Condutores
                        </button>
                    </div>
                </aside>

                <main class="flex-grow-1 p-4 overflow-auto">
                    <h4 class="mb-4"> Control de Buses </h4>

                    <div class="table-responsive" id="buses">
                        <div class="container my-5">
                            <div class="bus-card">
                                <!-- Cabecera -->
                                <div class="bus-card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-bus text-primary me-2"></i>
                                        <strong>Bus Nº 25 - Placa: AB123CD</strong>
                                    </div>
                                    <div>
                                        <button class="btn btn-outline-primary rounded-circle me-2" title="Editar">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <button class="btn btn-outline-danger rounded-circle" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Cuerpo con líneas -->
                                <div class="bus-card-body">
                                    <div class="bus-info-row">
                                        <div><i class="fas fa-cogs me-2 text-secondary"></i><strong>Modelo:</strong></div>
                                        <div>Mercedes Sprinter</div>
                                    </div>
                                    <div class="bus-info-row">
                                        <div><i class="fas fa-users me-2 text-secondary"></i><strong>Capacidad:</strong></div>
                                        <div>18 pasajeros</div>
                                    </div>
                                    <div class="bus-info-row">
                                        <div><i class="fas fa-building me-2 text-secondary"></i><strong>Agencia:</strong></div>
                                        <div>Ndong Viajes</div>
                                    </div>
                                    <div class="bus-info-row">
                                        <div><i class="fas fa-check-circle me-2 text-secondary"></i><strong>Estado:</strong></div>
                                        <div><span class="status-pill active-pill">Activo</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive d-none" id="conductos">
                        <div class="container my-5 d-flex justify-content-center">
                            <div class="dni-card-wide">
                                <!-- Foto lateral -->
                                <div class="dni-photo-side">
                                    <i class="fas fa-user"></i>
                                </div>

                                <!-- Información -->
                                <div class="dni-details">
                                    <h4>Juan Pedro Mba</h4>
                                    <p><i class="fas fa-id-card me-1 text-secondary"></i> <strong>ID:</strong> 20203040</p>
                                    <p><i class="fas fa-birthday-cake me-1 text-secondary"></i> <strong>Edad:</strong> 35 años</p>
                                    <p><i class="fas fa-phone me-1 text-secondary"></i> <strong>Tel:</strong> +240 555 123456</p>
                                    <p><i class="fas fa-envelope me-1 text-secondary"></i> <strong>Email:</strong> juan.pedro@email.com</p>
                                    <p><i class="fas fa-home me-1 text-secondary"></i> <strong>Domicilio:</strong> Barrio Paraíso, Malabo</p>
                                    <p><i class="fas fa-address-card me-1 text-secondary"></i> <strong>Licencia:</strong> LCN-45210</p>
                                    <p><i class="fas fa-bus me-1 text-secondary"></i> <strong>Asignación:</strong> Bus Nº 25</p>
                                    <p><i class="fas fa-bus me-1 text-secondary"></i> <strong>Agencia:</strong> Forama</p>

                                    <!-- Botones -->
                                    <div class="dni-buttons">
                                        <a href="https://wa.me/240555123456" target="_blank" class="btn btn-whatsapp">
                                            <i class="fab fa-whatsapp"></i> WhatsApp
                                        </a>
                                        <a href="mailto:juan.pedro@email.com" class="btn btn-email">
                                            <i class="fas fa-envelope"></i> Email
                                        </a>
                                    </div>
                                </div>

                                <!-- Estado -->
                                <div class="dni-status">
                                    <span class="status-pill active-pill">Activo</span>
                                </div>
                            </div>
                        </div>
                    </div>


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
                    <h4 class="mb-4">Gestion de reservas</h4>

                    <div class="table-responsive" id="comprados">
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

                                    <!-- Tipo de servicio -->
                                    <div class="mt-3">
                                        <span class="badge bg-warning text-dark fs-6 px-3 py-2">
                                            <i class="fa-solid fa-star me-1"></i> Servicio: Oro
                                        </span>
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
                        <button class="btn btn-outline-primary mb-3" id="btnLista">
                            <i class="fas fa-map-marked-alt  me-2"></i> lista
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
                        <div class="container my-4">
                            <div class="card shadow-lg rounded-4 overflow-hidden" style="height: 275px; max-width: 1000px; margin: auto;">
                                <div class="row h-100 g-0">

                                    <!-- Columna izquierda: Info del viaje -->
                                    <div class="col-md-8 bg-white p-4 d-flex flex-column justify-content-between">
                                        <!-- Encabezado -->
                                        <div class="mb-2">
                                            <h5 class="fw-bold mb-1 text-primary">
                                                <strong>Forama</strong><br>
                                                <i class="fas fa-bus me-2"></i> Viaje en Bus Nº 25
                                            </h5>
                                            <span class="text-muted small"><i class="fas fa-road me-1"></i>Ruta Malabo - Bata</span>
                                        </div>

                                        <!-- Datos principales -->
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

                                    <!-- Columna derecha: Progreso y acción -->
                                    <div class="col-md-4 bg-light-subtle d-flex flex-column justify-content-between p-4">
                                        <!-- Contadores -->
                                        <div>
                                            <p class="text-muted text-uppercase small mb-1">Trámite de viaje</p>
                                            <div class="progress mb-2" style="height: 6px;">
                                                <div class="progress-bar bg-success" style="width: 72%;"></div>
                                            </div>
                                            <p class="small text-success fw-semibold mb-3">72% Completado</p>

                                            <p class="text-muted text-uppercase small mb-1">Distancia restante</p>
                                            <p class="fw-bold">Total: 158 km <i class="fas fa-location-arrow me-2 text-info"></i> 89 km</p>
                                        </div>

                                        <!-- Botones -->
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
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive d-none" id="tablaLista">
                        <div class="container my-3">
                            <div class="card shadow-sm rounded-3 border-0 p-3" style="max-width: 80%; margin: auto;">

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

                            </div>
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
                        <button class="btn btn-outline-primary mb-3" id="btnUsuarios">
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

                    <div class="table-responsive" id="tablaUsuarios">
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
                                    <td>Mark</td>
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

                    <form id="formRegistroUsuario" class="d-none" novalidate>
                        <div class="row g-3">

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
                                    <input type="email" name="email" class="form-control campo-validacion" required>
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
                <button class="dock-btn">
                    <i class="fa-solid fa-house-chimney"></i>
                    <span class="tooltip-text">Inicio</span>
                </button>
                <button class="dock-btn" data-nombre="usuarios">
                    <i class="fa-solid fa-user-plus"></i>
                    <span class="tooltip-text">Usuarios</span>
                </button>
                <button class="dock-btn" data-nombre="agencias">
                    <i class="fa-solid fa-building"></i>
                    <span class="tooltip-text">Agencias</span>
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
                <button class="dock-btn" data-nombre="estadisticas">
                    <i class="fa-solid fa-ranking-star"></i>
                    <span class="tooltip-text">Estadísticas</span>
                </button>
                <button class="dock-btn" data-nombre="perfil">
                    <i class="fa-solid fa-circle-user"></i>
                    <span class="tooltip-text">Perfil</span>
                </button>
                <button class="dock-btn" data-nombre="ajustes">
                    <i class="fa-solid fa-gear"></i>
                    <span class="tooltip-text">Ajustes</span>
                </button>
            </div>
        </nav>
        <button class="dock-btn off" title="Cerrar Sesion">
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


    <script src="../../../controllers/js/bootstrap.min.js"></script>
    <script src="../../../controllers/js/sweetalert2.js"></script>
    <script src="../../../controllers/js/admin_controlers.js"></script>
    <script src="../../../controllers/js/sub_controlers.js"></script>
    <script async
        src="https://maps.googleapis.com/maps/api/js?key=TU_CLAVE_API&callback=initMap">
    </script>
</body>

</html>