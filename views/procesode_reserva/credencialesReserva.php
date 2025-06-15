<?php

session_start();

if (isset($_SESSION['usuario'])) {
    header('Location: ReservarViaje.php');
    exit;
}

$username = $_SESSION['usuario'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserva</title>
    <link rel="stylesheet" href="../css/all.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/fontawesome.min.css">
    <link rel="stylesheet" href="../css/window3.css">
</head>
<header>
    <div class="title">
        <div class="n">
            <h5>Reserva de boletos</h5>
        </div>
        <div class="tk"><i class="fa-solid fa-ticket"></i></div>
    </div>
    <div class="login">
        <div class="icon btn"><i class="fa-solid fa-user"></i></div>
        <div class="help btn"><i class="fa-solid fa-lightbulb"></i></div>
        <div class="exit btn" style="border: solid 1.5px rgb(255, 0, 0);"><a href="../../index.php" style="color: red;"><i class="fa-solid fa-arrow-right-from-bracket"></i></a></div>
    </div>

</header>

<body>

    <div id="cortina-usuario">
        <div class="contenido-cortina">
            <p><i class="fa-solid fa-circle-info"></i> Asegúrate de haber iniciado sesión o creado una cuenta antes de reservar.
                tambien tienes la opcion de reserva rapida al cancelar el inicio de sesion.
            </p>
            <button id="cerrar-cortina" class="btn btn-outline-light mt-3">Cancelar</button>
        </div>

        <script>
            document.getElementById("cerrar-cortina").addEventListener("click", function() {
                const cortina = document.getElementById("cortina-usuario");
                cortina.style.display = "none";
            });
        </script>
    </div>

    <!-- Modal de Usuario -->
    <div class="modal fade" id="modalUsuario" tabindex="-1" aria-labelledby="modalUsuarioLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUsuarioLabel">
                        <i class="fa-solid fa-user-check"></i> Accede o crea tu cuenta
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">

                    <!-- FORMULARIO DE INICIO DE SESIÓN -->
                    <form id="formLogin">
                        <div class="mb-3 position-relative">
                            <label for="usuario" class="form-label">Nombre de usuario</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                                <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Ingresa tu usuario" required>
                                <span class="input-group-text icon-validacion" id="icon-usuario"></span>
                            </div>
                        </div>

                        <div class="mb-3 position-relative">
                            <label for="password" class="form-label">Contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Ingresa tu contraseña" required>
                                <span class="input-group-text icon-validacion" id="icon-password"></span>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mb-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-arrow-right-to-bracket"></i> Iniciar sesión
                            </button>
                        </div>

                        <div class="text-center">
                            <button type="button" class="btn btn-link text-info" id="btnMostrarRegistro">
                                <i class="fa-solid fa-user-plus"></i> Crear nueva cuenta
                            </button>
                        </div>
                    </form>

                    <!-- FORMULARIO DE REGISTRO (INICIALMENTE OCULTO) -->
                    <form id="formRegistro" style="display: none;">
                        <p class="text-center mb-3"><strong>Formulario de registro</strong></p>

                        <!-- Nombre -->
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" name="nombre" class="form-control" placeholder="Nombre" required>
                            <span class="input-group-text"><i class="valid-icon"></i></span>
                        </div>

                        <!-- Apellidos -->
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                            <input type="text" name="apellidos" class="form-control" placeholder="Apellidos" required>
                            <span class="input-group-text"><i class="valid-icon"></i></span>
                        </div>

                        <!-- Edad -->
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-birthday-cake"></i></span>
                            <input type="number" name="edad" class="form-control" placeholder="Edad" required>
                            <span class="input-group-text"><i class="valid-icon"></i></span>
                        </div>

                        <!-- DNI -->
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                            <input type="text" name="dni" class="form-control" placeholder="DNI" required>
                            <span class="input-group-text"><i class="valid-icon"></i></span>
                        </div>

                        <!-- Email -->
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" name="email" class="form-control" placeholder="Correo electrónico" required>
                            <span class="input-group-text"><i class="valid-icon"></i></span>
                        </div>

                        <!-- Teléfono -->
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            <input type="tel" name="telefono" class="form-control" placeholder="Teléfono" required>
                            <span class="input-group-text"><i class="valid-icon"></i></span>
                        </div>

                        <!-- Imagen -->
                        <div class="mb-1">

                            <div class="image-preview-container">
                                <div id="imagePreview" class="image-preview">
                                    <p>Vista previa de la imagen</p>
                                </div>
                                <div class="input-group mt-2">
                                    <span class="input-group-text"><i class="fas fa-image"></i></span>
                                    <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*" required>
                                    <span class="input-group-text"><i class="valid-icon"></i></span>
                                </div>
                            </div>
                        </div>


                        <!-- Botón de envío y salir -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary mb-2">Registrar</button>
                        </div>

                        <div class="d-grid gap-2 mb-2">
                            <button type="button" class="btn btn-secondary" id="btnVolverLogin">
                                <i class="fa-solid fa-arrow-left"></i> Volver a iniciar sesión
                            </button>
                        </div>
                    </form>

                </div>
            </div>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const btnMostrarRegistro = document.getElementById("btnMostrarRegistro");
                    const btnVolverLogin = document.getElementById("btnVolverLogin");
                    const formLogin = document.getElementById("formLogin");
                    const formRegistro = document.getElementById("formRegistro");

                    btnMostrarRegistro.addEventListener("click", function() {
                        formLogin.style.display = "none";
                        formRegistro.style.display = "block";
                    });

                    btnVolverLogin.addEventListener("click", function() {
                        formRegistro.style.display = "none";
                        formLogin.style.display = "block";
                    });
                });
            </script>


        </div>

        <script>
            // Esperar a que el DOM cargue
            document.addEventListener("DOMContentLoaded", function() {
                const btnUsuario = document.querySelector(".icon.btn");

                btnUsuario.addEventListener("click", function() {
                    const modal = new bootstrap.Modal(document.getElementById("modalUsuario"));
                    modal.show();
                });
            });
        </script>


    </div>



    <main class="container container_formulario mt-2">
        <div class="img mb-3">
            <img src="../../img/index/Logo_viages.png" alt="Logo">
        </div>

        <div class="form-container">
            <form id="form_reserva">
                <input type="hidden" name="origen" id="origen">
                <input type="hidden" name="destino" id="destino">
                <input type="hidden" name="viajeros" id="viajeros">
                <input type="hidden" name="tipo" id="tipo">

                <!-- Nombre -->
                <div class="input-group mb-2">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" name="nombre" class="form-control" placeholder="Nombre" required>
                </div>

                <!-- Apellido -->
                <div class="input-group mb-2">
                    <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                    <input type="text" name="apellido" class="form-control" placeholder="Apellido" required>
                </div>

                <!-- Edad -->
                <div class="input-group mb-2">
                    <span class="input-group-text"><i class="fas fa-birthday-cake"></i></span>
                    <input type="number" name="edad" id="edad" class="form-control" placeholder="Edad" required>
                </div>

                <div class="input-group mb-2">
                    <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                    <input type="text" name="contacto_tutor" class="form-control" placeholder="Contacto">
                </div>

                <!-- Info tutor -->
                <div id="tutorInfo" style="display:none;">
                    <div class="input-group mb-2">
                        <span class="input-group-text"><i class="fas fa-user-shield"></i></span>
                        <input type="text" name="nombre_tutor" class="form-control" placeholder="Nombre del tutor">
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                        <input type="text" name="contacto_tutor" class="form-control" placeholder="Contacto del tutor">
                    </div>
                </div>

                <div id="viajerosExtra"></div>

                <!-- Botón enviar -->
                <div class="input-group mt-3">
                    <span class="input-group-text"><i class="fas fa-paper-plane"></i></span>
                    <button type="submit" class="form-control btn btn-success">Enviar reserva</button>
                </div>
            </form>

            <!-- Mensaje de éxito -->
            <div id="mensaje_exito" style="display: none; margin-top: 20px;">
                <h3><i style="color: green;" class="fa-solid fa-circle-check"></i> ¡Reserva realizada con éxito!</h3>
                <button id="descargar_pdf" class="btn btn-danger mt-2">
                    <i class="fa-solid fa-file-pdf"></i> Descargar Ticket
                </button>
            </div>
            <div class="sms mt-2">
                <p>
                    <small style="color: grey;">
                        <i style="color: green;" class="fa-solid fa-circle-info"></i> Es mejor usar una cuenta ( <i class="fa-solid fa-user"></i> ) ya creada para hacer uan reserva.
                        <br>
                        <i style="color: orange;" class="fa-solid fa-circle-info"></i> Recuerda que el ticket es válido solo para el día de la reserva.
                        <br>
                        <i style="color: red;" class="fa-solid fa-circle-info"></i> Si no puedes asistir, se le cancelara la reserva en un intervalo de 15 min antes de iniciar el viaje.
                        <br>
                        <i style="color: blue;" class="fa-solid fa-circle-info"></i> Si tienes alguna duda, no dudes en contactarnos.
                    </small>
                </p>
            </div>
        </div>


    </main>

    <script src="../../controllers/js/bootstrap.min.js"></script>
    <script src="../../controllers/js/sweetalert2.js"></script>
    <script src="../../controllers/js/credencialesReserva.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

</body>

</html>