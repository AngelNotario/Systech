<?php
include "../../database/conexion.php";  
header('Content-Type: application/json');

$sql = 'SELECT 
            producto_id , 
            nombre, 
            descripcion, 
            precio_compra, 
            precio_venta, 
            stock, 
            categoria_id, 
            proveedor_id, 
            codigo_barras, 
            fecha_creacion 
        FROM productos';
$result = mysqli_query($conn, $sql);

$productos = [];
while ($row = mysqli_fetch_assoc($result)) {
    $productos[] = $row;
}

echo json_encode(['productos' => $productos]);

mysqli_close($conn);
?>
