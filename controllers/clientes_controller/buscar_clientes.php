<?php
include "../../database/conexion.php";

$busqueda=$_GET['busqueda']??'';

$sql = "SELECT *  
FROM clientes  
WHERE (CONCAT(nombre, ' ', apellidos) LIKE ? OR cliente_id LIKE ?)";
$stmt = $conn->prepare($sql);
$param = "%{$busqueda}%";
$stmt->bind_param('ss', $param, $param);
$stmt->execute();
$result = $stmt->get_result();

$clientes = [];
while ($row = $result->fetch_assoc()) {
    $clientes[] = $row;
}

echo json_encode(['clientes' => $clientes]);