<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location:views/login/index.php');
    exit;
}

$username = $_SESSION['usuario'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Frances</h1>
</body>
</html>