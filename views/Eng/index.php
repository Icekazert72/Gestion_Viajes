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
    <title>Ingles ndong_traves</title>
</head>
<body>
    <h1>Ingles</h1>
    <h5>waiting the upgrades ...</h5>
</body>
</html>