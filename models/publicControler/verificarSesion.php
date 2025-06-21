<?php
session_start();

$response = ['sesion_activa' => false, 'tipo' => null];

if (isset($_SESSION['usuario']) && isset($_SESSION['tipo'])) {
    $response['sesion_activa'] = true;
    $response['tipo'] = $_SESSION['tipo'];
}

header('Content-Type: application/json');
echo json_encode($response);
