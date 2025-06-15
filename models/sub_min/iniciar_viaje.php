<?php
if (!isset($_POST['id'])) {
    echo "error";
    exit;
}

$id = intval($_POST['id']);
$conn = new mysqli("localhost", "root", "", "db_ndong_viajes");

if ($conn->connect_error) {
    echo "error";
    exit;
}

$stmt = $conn->prepare("UPDATE viajes SET estado = 'activo' WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "ok";
} else {
    echo "error";
}

$stmt->close();
$conn->close();
?>
