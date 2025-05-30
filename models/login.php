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

    // 🔐 Generar contraseña alfanumérica automática de 5 caracteres
    function generarPasswordAlfanumerica($longitud = 5)
    {
        $caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        return substr(str_shuffle(str_repeat($caracteres, ceil($longitud / strlen($caracteres)))), 0, $longitud);
    }

    $passwordAuto = generarPasswordAlfanumerica(5);
    $passwordHash = password_hash($passwordAuto, PASSWORD_DEFAULT);

    // Procesar imagen
    $imagenNombre = null;
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
        $directorio = '../uploads/';
        if (!is_dir($directorio)) {
            mkdir($directorio, 0777, true);
        }
        $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        $imagenNombre = uniqid('img_') . '.' . $ext;
        $rutaDestino = $directorio . $imagenNombre;

        if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
            http_response_code(500);
            echo "Error al subir la imagen.";
            exit;
        }
    }

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

            // Devuelve solo la contraseña generada
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
