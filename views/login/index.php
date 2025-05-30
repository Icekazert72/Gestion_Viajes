<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear cuenta</title>
    <link rel="stylesheet" href="../css/all.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/fontawesome.min.css">
    <link rel="stylesheet" href="../css/windows_login.css">
    <link rel="shortcut icon" href="../../img/index/Logo_viages.png" type="image/x-icon">
</head>

<body>


    <div class="container general">
        <div class="title">
            <h4 id="titleText">Iniciar Sesión</h4>
        </div>


        <div class="formLogin" id="formLogin">
            <form action="../../controllers/loginController.php" method="POST" class="login-form">

                <!-- Usuario -->
                <div class="input-group">
                    <span class="input-icon"><i class="fas fa-user"></i></span>
                    <input type="text" name="username" class="form-control" placeholder="Usuario">
                </div>

                <!-- PIN -->
                <div class="input-group">
                    <span class="input-icon"><i class="fas fa-lock"></i></span>
                    <input
                        type="password"
                        name="password"
                        class="pin-input"
                        maxlength="5"
                        inputmode="text"
                        placeholder="PIN de 5 dígitos"
                        required>
                </div>


                <!-- Mensaje informativo -->
                <div class="sms">
                    <p><small>¿No tienes una cuenta? <strong>Crea una</strong> haciendo clic en el botón de abajo.</small></p>
                </div>

                <!-- Botones -->
                <div class="btn-group">
                    <button type="submit" class="btn primary">Iniciar Sesión <i class="fa-solid fa-globe"></i></button>
                    <button type="button" class="btn secondary" id="btnCrearCuenta">Crear cuenta <i class="fa-solid fa-circle-plus"></i></button>
                    <a href="../../index.php" class="btn outline">Inicio <i class="fa-solid fa-house"></i></a>
                </div>
            </form>
        </div>


        <div class="formRegister mb-5" id="formRegister" hidden>
            <form action="../../controllers/loginController.php" method="POST" enctype="multipart/form-data">

                <!-- Nombre -->
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" name="nombre" class="form-control" placeholder="Nombre"">
                    <span class=" input-group-text"><i class="valid-icon fas"></i></span>
                </div>

                <!-- Apellidos -->
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                    <input type="text" name="apellidos" class="form-control" placeholder="Apellidos">
                    <span class="input-group-text"><i class="valid-icon fas"></i></span>
                </div>

                <!-- Edad -->
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fas fa-birthday-cake"></i></span>
                    <input type="number" name="edad" class="form-control" placeholder="Edad">
                    <span class="input-group-text"><i class="valid-icon fas"></i></span>
                </div>

                <!-- DNI -->
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                    <input type="text" name="dni" class="form-control" placeholder="DNI">
                    <span class="input-group-text"><i class="valid-icon fas"></i></span>
                </div>

                <!-- Email -->
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    <input type="email" name="email" class="form-control" placeholder="Correo electrónico">
                    <span class="input-group-text"><i class="valid-icon fas"></i></span>
                </div>

                <!-- Teléfono -->
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                    <input type="tel" name="telefono" class="form-control" placeholder="Teléfono">
                    <span class="input-group-text"><i class="valid-icon fas"></i></span>
                </div>

                <!-- Imagen -->
                <div class="mb-1">

                    <div class="image-preview-container">
                        <div id="imagePreview" class="image-preview">
                            <p>Vista previa de la imagen</p>
                        </div>
                        <div class="input-group mt-2">
                            <span class="input-group-text"><i class="fas fa-image"></i></span>
                            <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*">
                            <span class="input-group-text"><i class="valid-icon fas"></i></span>
                        </div>
                    </div>
                </div>


                <!-- Botón de envío y salir -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary mb-2">Registrar</button>
                    <button type="button" class="btn btn-warning mb-4" id="btnSalir">Cancelar</button>
                </div>

            </form>
        </div>

        <!-- Spinner de carga -->
        <div id="spinnerOverlay" hidden>
            <div class="spinner">
                <i class="fas fa-spinner fa-spin fa-3x"></i>
                <p>Espera un momento...</p>
            </div>
        </div>

        <!-- Spinner Fullscreen + Modal Bootstrap -->
        <div id="overlay-spinner" class="position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-75 d-flex justify-content-center align-items-center d-none" z-index: 1050;">
            <div class="text-center text-white">
                <div class="spinner-border text-light mb-3" style="width: 4rem; height: 4rem;" role="status"></div>
                <div id="resultadoPassword" class="d-none">
                    <div class="card bg-white text-dark shadow-lg rounded-4 p-4" style="min-width: 320px; max-width: 500px;">
                        <div class="card-body text-center">
                            <h4 class="mb-3 fw-bold text-success">Registro Completado</h4>
                            <p class="fs-5 text-secondary">Tu contraseña generada automáticamente es:</p>

                            <div class="d-flex justify-content-center align-items-center my-4">
                                <div class="bg-dark text-white fs-3 fw-bold px-4 py-3 rounded-pill border border-success shadow password-display" id="claveGenerada" style="letter-spacing: 3px;"></div>
                            </div>

                            <div class="alert alert-warning rounded-3">
                                📌 Guarda esta contraseña en un lugar seguro. ¡La necesitarás para iniciar sesión!
                            </div>

                            <a href="../../views/login/index.php" class="btn btn-lg btn-success mt-4 px-5 shadow-sm">
                                Iniciar Sesión
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>





        <script>
            const btnCrearCuenta = document.getElementById('btnCrearCuenta');
            const btnSalir = document.getElementById('btnSalir');
            const formLogin = document.getElementById('formLogin');
            const formRegister = document.getElementById('formRegister');
            const spinnerOverlay = document.getElementById('spinnerOverlay');

            btnCrearCuenta.addEventListener('click', () => {
                // Mostrar spinner
                spinnerOverlay.hidden = false;

                // Ocultar login, mostrar register
                formLogin.hidden = true;
                formRegister.hidden = false;

                // Ocultar spinner después de 20 segundos
                setTimeout(() => {
                    spinnerOverlay.hidden = true;
                }, 1000); // 20,000 ms = 20 segundos
            });

            btnSalir.addEventListener('click', () => {
                formLogin.hidden = false;
                formRegister.hidden = true;
            });
        </script>


    </div>


    <script src="../../controllers/js/bootstrap.min.js"></script>
    <script src="../../controllers/js/login_logout.js"></script>
    <script src="../../controllers/js/sweetalert2.js"></script>
</body>

</html>