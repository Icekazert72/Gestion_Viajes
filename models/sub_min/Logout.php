<?php
session_start();

if (isset($_SESSION['user_id'])) {
    session_unset(); // Limpia las variables de sesión
    session_destroy(); // Destruye la sesión
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'No hay sesión activa']);
}
exit;
?>
