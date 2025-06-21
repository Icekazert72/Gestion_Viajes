<?php
// Mostrar todos los errores (solo para desarrollo)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Solo permitir solicitudes POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Validar los campos obligatorios
    if (empty($_POST['email']) || empty($_POST['password'])) {
        http_response_code(400);
        echo "❌ Faltan datos para enviar el correo.";
        exit;
    }

    // Sanitizar entrada del usuario
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = htmlspecialchars(trim($_POST['password']));

    // Asunto del correo
    $asunto = "Bienvenido a NDONG VIAGES";

    // Mensaje HTML personalizado
    $mensaje = '
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Bienvenido a NDONG VIAGES</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f6f8;
                margin: 0;
                padding: 0;
                color: #333;
            }
            .container {
                max-width: 600px;
                margin: 30px auto;
                background-color: #ffffff;
                border-radius: 8px;
                overflow: hidden;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            }
            .header {
                background-color: #2b5f9e;
                color: #ffffff;
                padding: 20px 30px;
                text-align: center;
            }
            .header h1 {
                margin: 0;
                font-size: 26px;
            }
            .content {
                padding: 30px;
            }
            .content h2 {
                font-size: 20px;
                color: #2b5f9e;
                margin-top: 0;
            }
            .info-box {
                background-color: #f0f4fa;
                border-left: 4px solid #2b5f9e;
                padding: 15px;
                margin: 20px 0;
                font-size: 16px;
            }
            .btn {
                display: inline-block;
                padding: 12px 25px;
                background-color: #2b5f9e;
                color: #ffffff;
                text-decoration: none;
                border-radius: 5px;
                margin-top: 20px;
            }
            .footer {
                background-color: #f4f6f8;
                text-align: center;
                padding: 15px;
                font-size: 13px;
                color: #777;
            }
            .footer a {
                color:rgb(255, 255, 255);
                text-decoration: none;
            }
        </style>
    </head>
    <body>
    <div class="container">
        <div class="header">
            <h1>NDONG VIAGES</h1>
        </div>
        <div class="content">
            <h2>¡Bienvenido!</h2>
            <p>Gracias por registrarte con nosotros. A continuación, te enviamos tus datos de acceso:</p>

            <div class="info-box">
                <strong>Correo electrónico:</strong> ' . htmlspecialchars($email) . '<br>
                <strong>Contraseña :</strong> ' . htmlspecialchars($password) . '
            </div>

            <p>Por tu seguridad, te recomendamos cambiar esta contraseña una vez hayas iniciado sesión.</p>

            <a class="btn" href="https://www.ndongviages.com/login" target="_blank">Acceder a mi cuenta</a>
        </div>
        <div class="footer">
            © ' . date('Y') . ' NDONG VIAGES. Todos los derechos reservados.<br>
            ¿Necesitas ayuda? Escríbenos a <a href="mailto:soporte@ndongviages.com">soporte@ndongviages.com</a>
        </div>
    </div>
    </body>
    </html>
    ';

    // Cabeceras
    $cabeceras  = "MIME-Version: 1.0\r\n";
    $cabeceras .= "Content-type: text/html; charset=UTF-8\r\n";
    $cabeceras .= "From: NDONG VIAGES <no-reply@ndongviages.com>\r\n";

    // Envío del correo
    if (mail($email, $asunto, $mensaje, $cabeceras)) {
        http_response_code(200);
        echo "Correo enviado correctamente.";
    } else {
        http_response_code(500);
        echo "No se pudo enviar el correo.";
    }

    exit;

} else {
    http_response_code(405);
    echo "Método no permitido.";
    exit;
}
