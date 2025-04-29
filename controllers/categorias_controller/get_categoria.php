<?php 
include "../../database/conexion.php";
session_start();
$id= $_GET['id_categoria'];

$sql = "SELECT categoria_id as id, nombre, descripcion FROM categorias where categoria_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$categoria = $result->fetch_assoc();
echo json_encode($categoria);
?>