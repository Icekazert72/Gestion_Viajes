<?php
require_once 'conexion.php'; // contiene clase Database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();
    $conn = $db->getConexion();

    // 1. Captura de datos en orden de la tabla
    $nombre     = $_POST['nombre'];
    $apellidos  = $_POST['apellidos'];
    $edad       = $_POST['edad'];
    $dni        = $_POST['dni'];
    $email      = $_POST['email'];
    $telefono   = $_POST['telefono'];
    $agencia    = $_POST['agencia'];

    // 2. Generar contraseña aleatoria de 5 dígitos
    $password_generada = str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);

    // 3. Validar formato de contraseña
    if (!preg_match('/^\d{5}$/', $password_generada)) {
        echo "Error: La contraseña generada no es válida.";
        exit;
    }

    // 4. Encriptar contraseña
    $password_hash = password_hash($password_generada, PASSWORD_DEFAULT);

    // 5. Manejo de imagen
    $imagenNombre = basename($_FILES['imagen']['name']);
    $imagenRuta = '../uploads/' . $imagenNombre;
    move_uploaded_file($_FILES['imagen']['tmp_name'], $imagenRuta);

    // 6. Preparar y ejecutar inserción
    $stmt = $conn->prepare("INSERT INTO usuarios 
        (nombre, apellidos, edad, DNI, email, telefono, PASSWORD_HASH, imagen, agencia) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if ($stmt) {
        $stmt->bind_param("ssisssssi", $nombre, $apellidos, $edad, $dni, $email, $telefono, $password_hash, $imagenRuta, $agencia);
        if ($stmt->execute()) {
            echo "<h3>Usuario registrado correctamente.</h3>";
            echo "<p>Contraseña generada (guárdala): <strong>$password_generada</strong></p>";
        } else {
            echo "Error al registrar usuario: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta.";
    }

    $conn->close();
    exit;
}
