<?php 
include "../../database/conexion.php";
$sql = "SELECT categoria_id as id, nombre, descripcion FROM categorias";
$result = mysqli_query($conn, $sql);
$categorias = [];
while ($row = mysqli_fetch_assoc($result)) {
    $categorias[] = $row;
}
echo json_encode(['data' => $categorias]);