<?php
include '../database/config.php';

$sql = "SELECT * FROM usuarios";
$result = mysqli_query($conn, $sql);

$usuarios = [];
while ($row = mysqli_fetch_assoc($result)) {
    $usuarios[] = $row;
}

echo json_encode(['usuarios' => $usuarios]);
?>