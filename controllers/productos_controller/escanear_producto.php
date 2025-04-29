<?php
include "../../database/conexion.php";

// Decode the JSON payload
$data = json_decode(file_get_contents("php://input"), true);
$codigo_barras = $data['codigo'] ?? null;

if ($codigo_barras) {
    $sql = "SELECT productos.*, categorias.nombre AS categoria 
                FROM productos 
                INNER JOIN categorias ON productos.categoria_id = categorias.categoria_id 
                WHERE codigo_barras = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $codigo_barras);
    $stmt->execute();
    $result = $stmt->get_result();
    $producto = $result->fetch_assoc();

    if ($producto) {
        $response = array(
            'status' => 'success',
            'producto' => $producto
        );
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Producto no encontrado'
        );
    }
} else {
    $response = array(
        'status' => 'error',
        'message' => 'Código de barras no proporcionado'
    );
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);