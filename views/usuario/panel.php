<?php
session_start();

if (isset($_SESSION['usuario']) && isset($_SESSION['tipo'])) {
    if ($_SESSION['tipo'] === 'admin') {
        header('Location:views/admin/index.php');
        exit;
    }
    $username = $_SESSION['usuario']; // Usuario normal
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de usurios</title>
    <link rel="stylesheet" href="../css/all.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/fontawesome.min.css">
    <link rel="stylesheet" href="../css/sweetalert2.css">
    <link rel="stylesheet" href="../css/othersWindows.css">
    <link rel="shortcut icon" href="../../img/index/Logo_viages.png" type="image/x-icon">
</head>

<body>

    <header id="header">
        <div class="logo">
            <div title="Logo" class="img_logo">
                <img src="../../img/index/Logo_viages.png" alt="">
            </div>
            <div class="logo_text">
                <h5 title="Texto del logo">Ndong Viajes</h5>
                <div class="hidenMenu" id="hidenmenu">
                    <div class="list">
                        <div>
                            <h5>Gestión</h5>
                        </div>
                        <div><a href="#">Inicio</a></div>
                        <div><a href="#">Turismo</a></div>
                        <div><a href="views/nosotros.eg/index.php">Nosotros</a></div>
                        <div><a href="views/agencias.eg/index.php">Agencias</a></div>
                        <?php if (isset($_SESSION['usuario']) && $_SESSION['tipo'] === 'usuario'): ?>
                            <!-- Botón de panel de usuario -->
                            <div title="Mis reservas" class="btnPanel">
                                <a href="views/usuario/panel.php" style="color: orange;"><i class="fa-solid fa-calendar-check"></i></a>
                            </div>
                            <!-- Botón de cerrar sesión -->
                            <div title="Cerrar sesión" class="btnSesion">
                                <a href="views/login/logout.php" style="color: red;"><i class="fa-solid fa-right-from-bracket"></i></a>
                            </div>
                        <?php else: ?>
                            <!-- Botón de iniciar sesión -->
                            <div title="Iniciar sesión" class="btn">
                                <a href="views/login/index.php"><i class="fa-solid fa-user"></i></a>
                            </div>
                        <?php endif; ?>
                        <style>
                            .btnSesion:hover {
                                background-color: red;
                                color: white;

                                a {
                                    background-color: red;
                                    color: white;
                                }
                            }

                            .btnPanel:hover {
                                background-color: orange;
                                color: white;

                                a {
                                    background-color: orange;
                                    color: white;
                                }
                            }
                        </style>
                    </div>
                </div>
            </div>
        </div>

        <div class="nav">
            <div class="nav_navegar">
                <div><a href="#" class="active">Inicio</a></div>
                <div><a href="../turismo.eg/index.php">Turismo</a></div>
                <div><a href="../nosotros.eg/index.php">Nosotros</a></div>
                <div><a href="../agencias.eg/index.php">Agencias</a></div>
                <?php if (isset($_SESSION['usuario']) && $_SESSION['tipo'] === 'usuario'): ?>
                    <!-- Botón de panel de usuario -->
                    <div title="Mis reservas" class="btnPanel">
                        <a href="../usuario/panel.php" style="color: orange;"><i class="fa-solid fa-calendar-check"></i></a>
                    </div>
                    <!-- Botón de cerrar sesión -->
                    <div title="Cerrar sesión" class="btnSesion">
                        <a href="../login/logout.php" style="color: red;"><i class="fa-solid fa-right-from-bracket"></i></a>
                    </div>
                <?php else: ?>
                    <!-- Botón de iniciar sesión -->
                    <div title="Iniciar sesión" class="btn">
                        <a href="../../models/publicControler/cerrarSesion.php"><i class="fa-solid fa-user"></i></a>
                    </div>
                <?php endif; ?>
            </div>

            <div class="burgerButton" id="btn_mn">
                <i class="fa-solid fa-bars"></i>
            </div>

            <div title="Cambiar el idioma aquí" class="idioma">
                <img src="../../img/index/bandera.png" alt="">
            </div>
        </div>
    </header>

    <main>
        <div class="container mt-5 mb-5" style="width: 100%; height: 100vh;">
            <div class="container panel-container bg-white shadow-lg rounded-4 p-4">
                <div class="row">
                    <!-- Panel lateral con bienvenida y filtros -->
                    <div class="col-md-4 border-end pe-4">
                        <h2 class="fw-bold mb-3"><i class="fa-solid fa-user-circle text-primary me-2"></i> Bienvenido,</h2>
                        <h5 class="text-muted mb-4"><?php echo htmlspecialchars($username); ?></h5>

                        <p class="fw-bold text-secondary mb-2">Mis Reservas</p>
                        <div class="d-grid gap-2 mb-4">
                            <button class="btn btn-outline-secondary filter-btn active" data-filter="pendiente">
                                <i class="fa-solid fa-clock me-2"></i> Pendientes
                            </button>
                            <button class="btn btn-outline-primary filter-btn" data-filter="confirmada">
                                <i class="fa-solid fa-circle-check me-2"></i> Confirmadas
                            </button>
                            <button class="btn btn-outline-success filter-btn" data-filter="finalizada">
                                <i class="fa-solid fa-check-double me-2"></i> Finalizadas
                            </button>
                            <button class="btn btn-outline-danger filter-btn" data-filter="cancelada">
                                <i class="fa-solid fa-ban me-2"></i> Canceladas
                            </button>

                        </div>

                        <p class="fw-bold text-secondary mb-2">Ajustes de Cuenta</p>
                        <div class="d-grid gap-2">
                            <a href="editar_perfil.php" class="btn btn-outline-primary"><i class="fa-solid fa-pen-to-square me-2"></i> Editar Perfil</a>
                            <a href="cambiar_contrasena.php" class="btn btn-outline-warning"><i class="fa-solid fa-lock me-2"></i> Cambiar Contraseña</a>
                            <button id="cerrarSesionBtn" class="btn btn-outline-danger">
                                <i class="fa-solid fa-sign-out-alt me-2"></i> Cerrar Sesión
                            </button>
                        </div>
                    </div>

                    <!-- Contenido derecho -->
                    <div class="col-md-8" id="reservas-container">
                        <div id="contenedor-reservas"> <!-- === RESERVAS === -->
                            <!-- Pendiente -->
                            <!-- <div class="reserva-card mb-4" data-status="pendientes">
                            <div class="card border-start border-5 border-warning shadow-sm rounded-4">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h5 class="text-warning mb-0"><i class="fa-solid fa-clock me-2"></i> Reserva Pendiente</h5>
                                        <span class="badge bg-warning-subtle text-warning">20/06/2025</span>
                                    </div>
                                    <p class="mb-1"><strong>Destino:</strong> Malabo ➜ Bata</p>
                                    <p class="mb-1"><strong>Servicio:</strong> VIP</p>
                                    <p class="mb-3"><strong>Asiento:</strong> 12A</p>
                                    <div class="text-end">
                                        <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i> Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                            <!-- Confirmada -->
                            <!-- <div class="reserva-card mb-4" data-status="confirmadas">
                            <div class="card border-start border-5 border-primary shadow-sm rounded-4">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h5 class="text-primary mb-0"><i class="fa-solid fa-circle-check me-2"></i> Confirmada</h5>
                                        <span class="badge bg-primary-subtle text-primary">21/06/2025</span>
                                    </div>
                                    <p class="mb-1"><strong>Destino:</strong> Bata ➜ Mongomo</p>
                                    <p class="mb-1"><strong>Servicio:</strong> Económico</p>
                                    <p class="mb-3"><strong>Asiento:</strong> 8B</p>
                                    <div class="text-end">
                                        <button class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-eye"></i> Ver Detalles</button>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                            <!-- Finalizada -->
                            <!-- <div class="reserva-card mb-4" data-status="finalizadas">
                            <div class="card border-start border-5 border-success shadow-sm rounded-4">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h5 class="text-success mb-0"><i class="fa-solid fa-check-double me-2"></i> Finalizada</h5>
                                        <span class="badge bg-success-subtle text-success">10/06/2025</span>
                                    </div>
                                    <p class="mb-1"><strong>Destino:</strong> Ebebiyin ➜ Mongomo</p>
                                    <p class="mb-1"><strong>Servicio:</strong> VIP</p>
                                    <p class="mb-0"><strong>Asiento:</strong> 3C</p>
                                </div>
                            </div>
                        </div> -->

                            <!-- Cancelada -->
                            <!-- <div class="reserva-card mb-4" data-status="canceladas">
                            <div class="card border-start border-5 border-danger shadow-sm rounded-4">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h5 class="text-danger mb-0"><i class="fa-solid fa-ban me-2"></i> Cancelada</h5>
                                        <span class="badge bg-danger-subtle text-danger">14/06/2025</span>
                                    </div>
                                    <p class="mb-1"><strong>Destino:</strong> Malabo ➜ Evinayong</p>
                                    <p class="mb-1"><strong>Servicio:</strong> Económico</p>
                                    <p class="mb-0"><strong>Asiento:</strong> 7A</p>
                                </div>
                            </div>
                        </div> -->
                        </div>

                        <!-- === NUEVAS FUNCIONALIDADES === -->

                        <!-- Buzón de Mensajes -->
                        <div class="card border-0 shadow rounded-4 mb-4">
                            <div class="card-body">
                                <h5 class="card-title text-info"><i class="fa-solid fa-envelope me-2"></i> Buzón de Mensajes</h5>
                                <div class="mb-3">
                                    <label class="form-label">Para:</label>
                                    <input type="text" class="form-control" placeholder="Nombre de usuario destinatario">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Mensaje:</label>
                                    <textarea class="form-control" rows="3" placeholder="Escribe tu mensaje aquí..."></textarea>
                                </div>
                                <button class="btn btn-outline-info"><i class="fa-solid fa-paper-plane"></i> Enviar</button>
                                <hr>
                                <h6 class="text-muted mt-4">Mensajes Recibidos:</h6>
                                <ul class="list-group">
                                    <li class="list-group-item"><strong>@juan92:</strong> ¿Vamos juntos a Bata?</li>
                                    <li class="list-group-item"><strong>@rosa_m:</strong> ¿Cuál fue tu experiencia?</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Compartir Ruta -->
                        <div class="card border-0 shadow rounded-4 mb-4">
                            <div class="card-body">
                                <h5 class="card-title text-secondary"><i class="fa-solid fa-share-nodes me-2"></i> Compartir Ruta</h5>
                                <p class="text-muted">Comparte esta ruta con amigos o redes sociales:</p>
                                <input type="text" class="form-control mb-2" value="https://ndongviajes.com/ruta?id=1234" readonly>
                                <button class="btn btn-outline-success w-100"><i class="fa-solid fa-copy"></i> Copiar enlace</button>
                            </div>
                        </div>

                        <!-- Enviar Reseña -->
                        <div class="card border-0 shadow rounded-4 mb-4">
                            <div class="card-body">
                                <h5 class="card-title text-warning"><i class="fa-solid fa-star me-2"></i> Reseñar Agencia</h5>
                                <form>
                                    <div class="mb-2">
                                        <label class="form-label">Agencia:</label>
                                        <select class="form-select">
                                            <option>Ndong Travel - Bata</option>
                                            <option>Express Malabo</option>
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Puntuación:</label>
                                        <select class="form-select">
                                            <option>⭐️⭐️⭐️⭐️⭐️ - Excelente</option>
                                            <option>⭐️⭐️⭐️⭐️ - Muy buena</option>
                                            <option>⭐️⭐️⭐️ - Normal</option>
                                            <option>⭐️⭐️ - Mala</option>
                                            <option>⭐️ - Muy mala</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Comentario:</label>
                                        <textarea class="form-control" rows="3" placeholder="Describe tu experiencia..."></textarea>
                                    </div>
                                    <button class="btn btn-outline-warning w-100"><i class="fa-solid fa-paper-plane"></i> Enviar Reseña</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ESTILOS PERSONALIZADOS -->
            <style>
                .panel-container {
                    background-color: #ffffff;
                }

                .filter-btn.active {
                    background-color: #0d6efd;
                    color: #fff;
                    font-weight: bold;
                }
                
            </style>

            <!-- JS PARA FILTRO DE RESERVAS -->
            <script>
                document.querySelectorAll('.filter-btn').forEach(button => {
                    button.addEventListener('click', () => {
                        const filter = button.dataset.filter;
                        document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
                        button.classList.add('active');

                        document.querySelectorAll('.reserva-card').forEach(card => {
                            card.style.display = (card.dataset.status === filter) ? 'block' : 'none';
                        });
                    });
                });

                window.addEventListener('DOMContentLoaded', () => {
                    document.querySelectorAll('.reserva-card').forEach(card => {
                        if (card.dataset.status !== 'pendientes') {
                            card.style.display = 'none';
                        }
                    });
                });
            </script>

            <script>
                document.getElementById("cerrarSesionBtn").addEventListener("click", function() {
                    const btn = this;

                    // Mostrar spinner dentro del botón
                    btn.innerHTML = `
                        <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                        Cerrando sesión...
                    `;
                    btn.disabled = true;

                    // Esperar 1 segundo y luego redirigir (simula proceso)
                    setTimeout(() => {
                        window.location.href = "../../models/publicControler/cerrarSesion.php";
                    }, 1000);
                });
            </script>

        </div>
    </main>

    <script src="../../controllers/js/panel.js"></script>
</body>

</html>