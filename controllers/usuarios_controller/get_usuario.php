<?php
include "../../database/conexion.php";
if (isset($_GET['id_usuario'])) {
    $id_usuario = intval($_GET['id_usuario']);
    $sql = "SELECT 
                u.usuario_id, 
                u.nombre_usuario, 
                u.contrasena_hash as contraseña, 
                u.correo, 
                u.nombre_completo, 
                u.estado, 
                u.fecha_registro, 
                r.rol_id 
            FROM usuarios u
            LEFT JOIN RolesUsuarios ru ON u.usuario_id = ru.usuario_id
            LEFT JOIN Roles r ON ru.rol_id = r.rol_id
            WHERE u.usuario_id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $usuario = $result->fetch_assoc();
        $stmt->close();
        echo json_encode($usuario);
    } else {
        echo json_encode(['error' => 'Failed to prepare statement.']);
    }
} else {
    echo json_encode(['error' => 'Invalid user ID.']);
}
?>
