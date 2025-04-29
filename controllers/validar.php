<?php
include "../database/conexion.php";
session_start(); 
// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = trim($_POST['usuario']);
    $password = trim($_POST['contraseña']);
    // Verificar si los campos no están vacíos
    if (empty($id_usuario) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Por favor, complete todos los campos']);
        exit();
    }
    // Verificar si el usuario existe
    $stmt = $conn->prepare("SELECT * FROM Usuarios WHERE nombre_usuario = ?");
    $stmt->bind_param("s", $id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
        // Verificar si la contraseña es correcta
        if (password_verify($password, $usuario['contrasena_hash'])) {
            // Obtener los roles del usuario
            $queryRoles = "
                SELECT r.nombre_rol 
                FROM RolesUsuarios ru
                INNER JOIN Roles r ON ru.rol_id = r.rol_id
                WHERE ru.usuario_id = ?";
            $stmtRoles = $conn->prepare($queryRoles);
            $stmtRoles->bind_param("i", $usuario['usuario_id']);
            $stmtRoles->execute();
            $resultRoles = $stmtRoles->get_result();
            $roles = [];
            while ($row = $resultRoles->fetch_assoc()) {
                $roles[] = $row['nombre_rol'];
            }

            // Verificar si el usuario es administrador
            $es_admin = in_array('Administrador', $roles);

            // Configurar la sesión
            $_SESSION['es_admin'] = $es_admin;
            $_SESSION['id_usuario'] = $usuario['usuario_id'];
            $_SESSION['roles'] = $roles;
            $_SESSION['nombre_usuario'] = $usuario['nombre_usuario'];

              // Verificar si el usuario tiene una caja abierta
              $query = "SELECT * FROM cajas WHERE usuario = ? AND hora_cierre IS NULL AND estatus = 'abierta'";
              $stmt = $conn->prepare($query);
              $stmt->bind_param("i", $usuario['usuario_id']);
              $stmt->execute();
              $resultado = $stmt->get_result();
              if ($resultado->num_rows === 1) {
                echo json_encode(['success' => true, 'message' => 'Bienvenido de vuelta', 'redirect' => 'principal.php']);
              } else {
                echo json_encode(['success' => true, 'message' => 'Inicio de Sesion Exitoso', 'redirect' => 'abrir_caja.php']);
              }

          
            exit();
        } else {
            echo json_encode(['success' => false, 'message' => 'Contraseña incorrecta']);
            exit();
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Usuario incorrecto']);
        exit();
    }
}
