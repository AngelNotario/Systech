<?php
include "../../database/conexion.php";
// Obtener los parámetros de la solicitud
$request = $_REQUEST;
$columna = ['nombre', 'descripcion', 'precio_compra', 'precio_venta', 'stock', 'codigo_barras', 'categoria', 'imagen', 'fecha_creacion'];

// Construir la consulta base

$sql = "SELECT 
            p.producto_id, 
            p.nombre, 
            p.descripcion, 
            p.precio_compra, 
            p.precio_venta, 
            p.stock, 
            p.codigo_barras, 
            p.fecha_creacion,
            p.imagen,
            c.nombre AS categoria
        FROM Productos p
        LEFT JOIN Categorias c ON p.categoria_id = c.categoria_id";

// Filtro de búsqueda
if (!empty($request['search']['value'])) {
    $sql .= " WHERE (p.nombre LIKE '%".$conn->real_escape_string($request['search']['value'])."%' ";
    $sql .= " OR p.descripcion LIKE '%".$conn->real_escape_string($request['search']['value'])."%' ";
    $sql .= " OR p.precio_compra LIKE '%".$conn->real_escape_string($request['search']['value'])."%' ";
    $sql .= " OR p.precio_venta LIKE '%".$conn->real_escape_string($request['search']['value'])."%' ";
    $sql .= " OR p.stock LIKE '%".$conn->real_escape_string($request['search']['value'])."%' ";
    $sql .= " OR p.codigo_barras LIKE '%".$conn->real_escape_string($request['search']['value'])."%' ";
    $sql .= " OR c.nombre LIKE '%".$conn->real_escape_string($request['search']['value'])."%' ";
    $sql .= " OR p.fecha_creacion LIKE '%".$conn->real_escape_string($request['search']['value'])."%' )";
}

// Ordenar
$ordenColumna = isset($request['order'][0]['column']) ? $request['order'][0]['column'] : '';
$ordenDir = isset($request['order'][0]['dir']) ? $request['order'][0]['dir'] : 'ASC';
if ($ordenColumna !== '') {
    $sql .= " ORDER BY ".$columna[$ordenColumna]." ".$ordenDir." ";
} else {
    $sql .= " ORDER BY p.nombre ASC";
}

// Limitar registros para paginación
$start = intval($request['start']);
$length = intval($request['length']);
$sql .= " LIMIT {$start}, {$length}";

$query = $conn->query($sql);
$data = [];
while ($row = $query->fetch_assoc()) {
    $subarray = [];
    $subarray[] = $row['nombre'];
    $subarray[] = $row['descripcion'];
    $subarray[] = "$" . $row['precio_compra'];
    $subarray[] = "$" . $row['precio_venta'];
    $subarray[] = $row['categoria'];
    $subarray[] = $row['stock'];
    $subarray[] = $row['codigo_barras'];
    $subarray[] = isset($row['fecha_creacion']) ? $row['fecha_creacion'] : 'No disponible';
    $subarray[] = $row['imagen'];
    $subarray[] = '<button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditarProducto" data-id="'.$row['producto_id'].'"><i class="bi bi-pencil-square"></i></button>
                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalEliminarProducto" data-id="'.$row['producto_id'].'"><i class="bi bi-trash"></i></button>';
    $data[] = $subarray;
}

// Contar el total de registros sin filtros
$sqlTotal = "SELECT COUNT(*) AS total FROM Productos";
$totalRecords = $conn->query($sqlTotal)->fetch_assoc()['total'];

// Contar el total de registros con filtros
$sqlFiltered = "SELECT COUNT(*) AS total FROM Productos p
LEFT JOIN Categorias c ON p.categoria_id = c.categoria_id";
if (!empty($request['search']['value'])) {
    $sqlFiltered .= " WHERE (p.nombre LIKE '%".$conn->real_escape_string($request['search']['value'])."%' ";
    $sqlFiltered .= " OR p.descripcion LIKE '%".$conn->real_escape_string($request['search']['value'])."%' ";
    $sqlFiltered .= " OR p.precio_compra LIKE '%".$conn->real_escape_string($request['search']['value'])."%' ";
    $sqlFiltered .= " OR p.precio_venta LIKE '%".$conn->real_escape_string($request['search']['value'])."%' ";
    $sqlFiltered .= " OR p.stock LIKE '%".$conn->real_escape_string($request['search']['value'])."%' ";
    $sqlFiltered .= " OR p.codigo_barras LIKE '%".$conn->real_escape_string($request['search']['value'])."%' ";
    $sqlFiltered .= " OR c.nombre LIKE '%".$conn->real_escape_string($request['search']['value'])."%' ";
    $sqlFiltered .= " OR p.fecha_creacion LIKE '%".$conn->real_escape_string($request['search']['value'])."%' )";
}
$totalFilteredRecords = $conn->query($sqlFiltered)->fetch_assoc()['total'];

// Preparar la respuesta en formato JSON
$response = [
    "draw" => intval($request['draw']),
    "recordsTotal" => intval($totalRecords),
    "recordsFiltered" => intval($totalFilteredRecords),
    "data" => $data
];

// Enviar respuesta JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
