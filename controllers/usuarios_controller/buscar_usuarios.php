<?php
include  "../database/config.php";
if (isset($_GET['busqueda'])) {
    $busqueda = $_GET['busqueda'];
    $query = $conn->prepare("SELECT id_usuario, nombre_usuario FROM usuarios WHERE nombre_usuario LIKE ?");
    $query->bind_param("s", $param_busqueda);
    $param_busqueda = "%$busqueda%";
    $query->execute();
    $result = $query->get_result();
    $usuarios = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode(['usuarios' => $usuarios]);
}