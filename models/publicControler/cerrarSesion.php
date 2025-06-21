<?php
session_start();

// Limpiar todas las variables de sesión
$_SESSION = [];

// Si usas cookies de sesión, eliminarla también
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destruir la sesión
session_destroy();

// Redirigir a página principal o login
header('Location: ../../index.php'); // Cambia 'login.php' por tu página real de login o inicio
exit;
