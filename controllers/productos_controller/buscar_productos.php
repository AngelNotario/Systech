<?php 
include "../../database/conexion.php";

header('Content-Type: application/json');

$busqueda = $_GET['busqueda'] ;

if (!empty($busqueda)) {
    $query = $conn->prepare("
        SELECT productos.*, categorias.nombre as categoria FROM productos 
        INNER JOIN categorias ON productos.categoria_id = categorias.categoria_id 
        WHERE productos.nombre LIKE ? 
        OR productos.descripcion LIKE ? 
        OR productos.codigo_barras LIKE ?
    ");
    $parametro = '%' . $busqueda . '%';
    $query->bind_param('sss', $parametro, $parametro, $parametro);
    $query->execute();
    $result = $query->get_result();

    $productos = [];
    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }

    echo json_encode($productos);
} else {
    echo json_encode(['error' => 'Error en el parametro de busqueda']);
}