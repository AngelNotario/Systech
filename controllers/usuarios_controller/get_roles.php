<?php
include "../../database/conexion.php";

$sql = "SELECT rol_id, nombre_rol, descripcion FROM roles";
$result =  mysqli_query($conn, $sql);

$roles = [];
while ($row = mysqli_fetch_assoc($result)) {
    $roles[] = $row;
}

echo json_encode( $roles);
 
?>