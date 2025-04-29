<?php
include "../../database/conexion.php";
// Obtener los parámetros de la solicitud
$request = $_REQUEST;
$columna = ['membresia_id', 'nombre_cliente', 'tipo_membresia', 'fecha_inicio', 'fecha_fin', 'estado', 'costo'];

// Construir la consulta base con INNER JOIN
$sql = "SELECT membresias.membresia_id, membresias.cliente_id, CONCAT(clientes.nombre, ' ', clientes.apellidos) AS nombre_cliente, membresias.tipo_membresia, membresias.fecha_inicio, membresias.fecha_fin, membresias.estado, membresias.costo 
    FROM membresias 
    INNER JOIN clientes ON membresias.cliente_id = clientes.cliente_id
    WHERE membresias.estado = 'Activa'";

// Añadir búsqueda si se proporciona
if (!empty($request['search']['value'])) {
    $sql .= " AND (membresias.membresia_id LIKE '%" . $request['search']['value'] . "%' ";
    $sql .= " OR CONCAT(clientes.nombre, ' ', clientes.apellidos) LIKE '%" . $request['search']['value'] . "%' ";
    $sql .= " OR membresias.tipo_membresia LIKE '%" . $request['search']['value'] . "%' ";
    $sql .= " OR membresias.fecha_inicio LIKE '%" . $request['search']['value'] . "%' ";
    $sql .= " OR membresias.fecha_fin LIKE '%" . $request['search']['value'] . "%' ";
    $sql .= " OR membresias.estado LIKE '%" . $request['search']['value'] . "%' ";
    $sql .= " OR membresias.costo LIKE '%" . $request['search']['value'] . "%' )";
}

// Añadir ordenamiento
if (isset($request['order'])) {
    $sql .= " ORDER BY " . $columna[$request['order'][0]['column']] . " " . $request['order'][0]['dir'];
} else {
    $sql .= " ORDER BY membresias.membresia_id DESC";
}

// Añadir paginación
$sql .= " LIMIT " . $request['start'] . " ," . $request['length'] . " ";

// Ejecutar la consulta
$query = mysqli_query($conn, $sql);

// Obtener el número total de registros sin filtros
$sqlTotal = "SELECT COUNT(*) FROM membresias WHERE estado = 'Activa'";
$queryTotal = mysqli_query($conn, $sqlTotal);
$totalData = mysqli_fetch_array($queryTotal)[0];

// Obtener el número total de registros con filtros
$sqlFiltered = "SELECT COUNT(*) FROM membresias 
    INNER JOIN clientes ON membresias.cliente_id = clientes.cliente_id
    WHERE membresias.estado = 'Activa'";
if (!empty($request['search']['value'])) {
    $sqlFiltered .= " AND (membresias.membresia_id LIKE '%" . $request['search']['value'] . "%' ";
    $sqlFiltered .= " OR CONCAT(clientes.nombre, ' ', clientes.apellidos) LIKE '%" . $request['search']['value'] . "%' ";
    $sqlFiltered .= " OR membresias.tipo_membresia LIKE '%" . $request['search']['value'] . "%' ";
    $sqlFiltered .= " OR membresias.fecha_inicio LIKE '%" . $request['search']['value'] . "%' ";
    $sqlFiltered .= " OR membresias.fecha_fin LIKE '%" . $request['search']['value'] . "%' ";
    $sqlFiltered .= " OR membresias.estado LIKE '%" . $request['search']['value'] . "%' ";
    $sqlFiltered .= " OR membresias.costo LIKE '%" . $request['search']['value'] . "%' )";
}
$queryFiltered = mysqli_query($conn, $sqlFiltered);
$totalFiltered = mysqli_fetch_array($queryFiltered)[0];

// Preparar los datos para la respuesta
$data = [];
while ($row = mysqli_fetch_array($query)) {
    $subdata = [];
    $subdata[] = $row['membresia_id'];
    $subdata[] = "<a href='membresias.php?id_cliente=" . $row['cliente_id'] . "'>" . $row['nombre_cliente'] . "</a>";
    $subdata[] = $row['tipo_membresia'];
    $subdata[] = $row['fecha_inicio'];
    $subdata[] = $row['fecha_fin'];
   
    $subdata[] = $row['costo'];
    $subdata[] = $row['estado'];
    $data[] = $subdata;
}

// Crear la respuesta en formato JSON
$json_data = [
    "draw" => intval($request['draw']),
    "recordsTotal" => intval($totalData),
    "recordsFiltered" => intval($totalFiltered),
    "data" => $data
];

echo json_encode($json_data);
