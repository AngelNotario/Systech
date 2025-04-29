<?php 
include "../../database/conexion.php";

// Verificar si se ha enviado el ID del cliente
if (!isset($_GET['id_cliente'])) {
    echo json_encode(['error' => 'ID de cliente no proporcionado']);
    exit;
} else {
    $id_cliente = $_GET['id_cliente'];
}

$sql = "SELECT * FROM clientes WHERE cliente_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_cliente);
$stmt->execute();
$result = $stmt->get_result();
$cliente = $result->fetch_assoc();
$stmt->close();

echo json_encode($cliente);