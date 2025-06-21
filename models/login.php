<?php

session_start();
require_once '../models/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requiredFields = ['nombre', 'apellidos', 'edad', 'dni', 'email', 'telefono'];
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            http_response_code(400);
            echo "Falta el campo: $field";
            exit;
        }
    }

    $nombre = trim($_POST['nombre']);
    $apellidos = trim($_POST['apellidos']);
    $edad = (int) $_POST['edad'];
    $dni = trim($_POST['dni']);
    $email = trim($_POST['email']);
    $telefono = trim($_POST['telefono']);

    // Genera contraseña alfanumérica automática de 5 caracteres
    function generarPasswordAlfanumerica($longitud = 5)
    {
        $caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        return substr(str_shuffle(str_repeat($caracteres, ceil($longitud / strlen($caracteres)))), 0, $longitud);
    }

    $passwordAuto = generarPasswordAlfanumerica(5);
    $passwordHash = password_hash($passwordAuto, PASSWORD_DEFAULT);

    $asunto = "Bienvenido a NDONG VIAGES";

    // Plantilla HTML del correo
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
                <strong>Contraseña :</strong> ' . htmlspecialchars($passwordAuto) . '
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

    $cabeceras  = "MIME-Version: 1.0\r\n";
    $cabeceras .= "Content-type: text/html; charset=UTF-8\r\n";
    $cabeceras .= "From: NDONG VIAGES <no-reply@ndongviages.com>\r\n";

    // Intentar enviar el correo
    if (!mail($email, $asunto, $mensaje, $cabeceras)) {
        http_response_code(500);
        echo "Error al enviar el correo. Por favor intenta de nuevo más tarde.";
        exit;
    }


    // ...existing code...
    try {
        // ...todo tu código...
    } catch (Throwable $e) {
        http_response_code(500);
        echo "Error fatal: " . $e->getMessage();
        exit;
    }
    // ...existing code...
    // Procesar imagen (si se envió)
    $imagenNombre = null;
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
        $directorio = '../uploads/';
        if (!is_dir($directorio)) mkdir($directorio, 0777, true);

        $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        $imagenNombre = uniqid('img_') . '.' . $ext;
        $rutaDestino = $directorio . $imagenNombre;

        if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
            http_response_code(500);
            echo "Error al subir la imagen.";
            exit;
        }
    }

    // Registrar usuario en la base de datos
    try {
        $db = new Database();
        $conexion = $db->getConexion();
        $sql = "INSERT INTO usuarios (nombre, apellidos, edad, dni, email, telefono, PASSWORD_HASH, imagen)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ssisssss", $nombre, $apellidos, $edad, $dni, $email, $telefono, $passwordHash, $imagenNombre);

        if ($stmt->execute()) {
            $_SESSION['usuario'] = [
                'nombre' => $nombre,
                'apellidos' => $apellidos,
                'edad' => $edad,
                'dni' => $dni,
                'email' => $email,
                'telefono' => $telefono,
                'imagen' => $imagenNombre
            ];

            // Devuelve la contraseña generada para que el JS la use
            echo $passwordAuto;
        } else {
            http_response_code(500);
            echo "Error al registrar el usuario: " . $stmt->error;
        }

        $stmt->close();
        $conexion->close();
    } catch (Exception $e) {
        http_response_code(500);
        echo "Error del servidor: " . $e->getMessage();
    }
}
