<?php
include "../../database/conexion.php";

// Obtener los parámetros de la solicitud
$request = $_REQUEST;
$columna = ['nombre', 'descripcion'];

// Construir la consulta base
$sql = "SELECT 
            categoria_id, 
            nombre, 
            descripcion 
        FROM categorias";

// Filtro de búsqueda
if (!empty($request['search']['value'])) {
    $sql .= " WHERE (nombre LIKE '%".$conn->real_escape_string($request['search']['value'])."%' ";
    $sql .= " OR descripcion LIKE '%".$conn->real_escape_string($request['search']['value'])."%')";
}

// Ordenar
$ordenColumna = isset($request['order'][0]['column']) ? $request['order'][0]['column'] : '';
$ordenDir = isset($request['order'][0]['dir']) ? $request['order'][0]['dir'] : 'ASC';
if ($ordenColumna !== '') {
    $sql .= " ORDER BY ".$columna[$ordenColumna]." ".$ordenDir." ";
} else {
    $sql .= " ORDER BY nombre ASC";
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
    $subarray[] = '<button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditarCategoria" data-id="'.$row['categoria_id'].'"><i class="bi bi-pencil-square"></i></button>
                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalEliminarCategoria" data-id="'.$row['categoria_id'].'"><i class="bi bi-trash"></i></button>';
    $data[] = $subarray;
}

// Contar el total de registros sin filtros
$sqlTotal = "SELECT COUNT(*) AS total FROM categorias";
$totalRecords = $conn->query($sqlTotal)->fetch_assoc()['total'];

// Contar el total de registros con filtros
$sqlFiltered = "SELECT COUNT(*) AS total FROM categorias";
if (!empty($request['search']['value'])) {
    $sqlFiltered .= " WHERE (nombre LIKE '%".$conn->real_escape_string($request['search']['value'])."%' ";
    $sqlFiltered .= " OR descripcion LIKE '%".$conn->real_escape_string($request['search']['value'])."%')";
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
