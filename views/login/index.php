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
</head>

<body>


    <div class="container general">
        <div class="title">
            <h4>Iniciar Sesion</h4>
        </div>
        <div class="formLogin" id="formLogin">
            <form action="../../controllers/loginController.php" method="POST">
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" name="username" class="form-control" placeholder="Usuario" required>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <div class="pin-input-container">
                        <input type="password" name="password" maxlength="1" class="pin-input" inputmode="numeric" required>
                        <input type="password" name="password" maxlength="1" class="pin-input" inputmode="numeric" required>
                        <input type="password" name="password" maxlength="1" class="pin-input" inputmode="numeric" required>
                        <input type="password" name="password" maxlength="1" class="pin-input" inputmode="numeric" required>
                        <input type="password" name="password" maxlength="1" class="pin-input" inputmode="numeric" required>
                    </div>
                </div>
                <div class="sms">
                    <p style="color:grey;"><small>Si no tienes una <strong>cuenta</strong> puedes crear la haciendo click en el borton de crear</small></p>
                </div>
                <button type="submit" class="btn">Iniciar Sesión <i class="fa-solid fa-globe"></i></button>
                <button type="button" class="btn" id="btnCrearCuenta">Crear cuenta <i class="fa-solid fa-circle-plus"></i></button>
                <a href="../../index.php" class="btn">Inicio <i class="fa-solid fa-house"></i></a>
            </form>
        </div>

        <div class="formRegister mb-5" id="formRegister" hidden>
            <form action="../../controllers/loginController.php" method="POST" enctype="multipart/form-data">

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
                }, 7000); // 20,000 ms = 20 segundos
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