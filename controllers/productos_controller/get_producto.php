<?php
include "../../database/conexion.php";

if (isset($_GET['id_producto'])) {
    $id_producto = intval($_GET['id_producto']);

    $sql = "SELECT productos.*, categorias.nombre AS categoria 
            FROM productos 
            INNER JOIN categorias ON productos.categoria_id = categorias.categoria_id 
            WHERE producto_id = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id_producto);
        $stmt->execute();
        $result = $stmt->get_result();
        $producto = $result->fetch_assoc();
        $stmt->close();

        echo json_encode($producto);
    } else {
        echo json_encode(['error' => 'Failed to prepare statement.']);
    }
} else {
    echo json_encode(['error' => 'Invalid product ID.']);
}
?>
