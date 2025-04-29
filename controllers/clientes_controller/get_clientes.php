<?php
include "../../database/conexion.php";

$sql = "SELECT * FROM clientes";
$result = mysqli_query($conn, $sql);

$clientes = [];
while ($row = mysqli_fetch_assoc($result)) {
    $clientes[] = $row;
}

echo json_encode($clientes);
?>