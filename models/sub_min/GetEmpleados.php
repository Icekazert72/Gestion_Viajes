<?php
require_once '../conexion.php'; // Clase Database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();
    $conn = $db->getConexion();

    // 1. Captura de datos
    $nombre           = $_POST['nombre'];
    $apellidos        = $_POST['apellidos'];
    $telefono          = $_POST['telefono'];
    $edad             = $_POST['edad'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $dni              = $_POST['dni'];
    $email            = $_POST['email'];
    $rol              = $_POST['rol'];
    $agencia          = $_POST['agencia'];

    // 2. Generar contraseña aleatoria de 5 dígitos
    $password_generada = str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);

    // 3. Validar formato
    if (!preg_match('/^\d{5}$/', $password_generada)) {
        echo "Error: La contraseña generada no es válida.";
        exit;
    }

    // 4. Encriptar
    $password_hash = password_hash($password_generada, PASSWORD_DEFAULT);


    // 6. Manejo de imagen
    $imagenNombre = basename($_FILES['imagen']['name']);
    $imagenRuta = '../../uploads/' . $imagenNombre;
    move_uploaded_file($_FILES['imagen']['tmp_name'], $imagenRuta);

    // 7. Preparar consulta
    $stmt = $conn->prepare("INSERT INTO empleados_agencias 
        (nombre, apellidos, telefono, edad, fecha_nacimiento, DNI, email, imagen, agencia, PASSWORD_HASH, rol) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if ($stmt) {
        $stmt->bind_param("sssisssssis", 
            $nombre, $apellidos, $telefono, $edad, $fecha_nacimiento, $dni, $email,
            $imagenRuta, $agencia, $password_hash, $rol
        );

        if ($stmt->execute()) {
            echo "<h3>Empleado registrado correctamente.</h3>";
            echo "<p>Contraseña generada (guárdala): <strong>$password_generada</strong></p>";
        } else {
            echo "Error al registrar empleado: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta.";
    }

    $conn->close();
    exit;
}
?>
