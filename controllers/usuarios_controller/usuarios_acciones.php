<?php
include "../../database/conexion.php";
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php?mensaje=Debe iniciar sesión para acceder a esta página&tipo=error");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'];

    if ($accion === 'registrar') {
        // Lógica para registrar un nuevo usuario
        $nombre_usuario = $_POST['nombre_usuario'];
        $contrasena = password_hash($_POST['contraseña'], PASSWORD_BCRYPT);
        $correo = $_POST['correo'];
        $nombre_completo = $_POST['nombre_completo'];
        $rol_id = $_POST['rol'];

        try {
            // Verificar si el nombre de usuario o correo ya existe
            $queryCheck = "SELECT COUNT(*) FROM Usuarios WHERE nombre_usuario = ? OR correo = ?";
            $stmtCheck = $conn->prepare($queryCheck);
            $stmtCheck->bind_param("ss", $nombre_usuario, $correo);
            $stmtCheck->execute();
            $stmtCheck->bind_result($count);
            $stmtCheck->fetch();
            $stmtCheck->close();

            if ($count > 0) {
                echo json_encode(['success' => false, 'message' => 'El nombre de usuario o correo ya existe']);
                exit();
            }

            // Insertar el nuevo usuario
            $query = "INSERT INTO Usuarios (nombre_usuario, contrasena_hash, correo, nombre_completo) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssss", $nombre_usuario, $contrasena, $correo, $nombre_completo);

            if ($stmt->execute()) {
                $usuario_id = $stmt->insert_id;

                // Asignar rol al usuario
                $queryRol = "INSERT INTO RolesUsuarios (usuario_id, rol_id) VALUES (?, ?)";
                $stmtRol = $conn->prepare($queryRol);
                $stmtRol->bind_param("ii", $usuario_id, $rol_id);
                $stmtRol->execute();

                echo json_encode(['success' => true, 'message' => 'Usuario registrado con éxito']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al registrar el usuario']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    } elseif ($accion === 'editar') {
        // Lógica para editar un usuario
        $usuario_id = $_POST['id_usuario'];
        $nombre_usuario = $_POST['nombre_usuario'];
        $contrasena = !empty($_POST['contrasena']) ? password_hash($_POST['contrasena'], PASSWORD_BCRYPT) : null;
        $correo = $_POST['correo'];
        $nombre_completo = $_POST['nombre_completo'];
        $rol_id = $_POST['rol'];
        $estado = $_POST['estado'];

        try {
            // Verificar si el nombre de usuario o correo ya existe para otro usuario
            $queryCheck = "SELECT COUNT(*) FROM Usuarios WHERE (nombre_usuario = ? OR correo = ?) AND usuario_id != ?";
            $stmtCheck = $conn->prepare($queryCheck);
            $stmtCheck->bind_param("ssi", $nombre_usuario, $correo, $usuario_id);
            $stmtCheck->execute();
            $stmtCheck->bind_result($count);
            $stmtCheck->fetch();
            $stmtCheck->close();

            if ($count > 0) {
                echo json_encode(['success' => false, 'message' => 'El nombre de usuario o correo ya existe']);
                exit();
            }

            // Actualizar el usuario
            $query = "UPDATE Usuarios SET nombre_usuario = ?, correo = ?, nombre_completo = ?, estado = ?";
            $params = [$nombre_usuario, $correo, $nombre_completo, $estado];
            $types = "ssss";

            if ($contrasena !== null) {
                $query .= ", contrasena_hash = ?";
                $params[] = $contrasena;
                $types .= "s";
            }

            $query .= " WHERE usuario_id = ?";
            $params[] = $usuario_id;
            $types .= "i";

            $stmt = $conn->prepare($query);
            $stmt->bind_param($types, ...$params);

            if ($stmt->execute()) {
                // Actualizar el rol del usuario
                $queryRol = "UPDATE rolesusuarios SET rol_id = ? WHERE usuario_id = ?";
                $stmtRol = $conn->prepare($queryRol);
                $stmtRol->bind_param("ii", $rol_id, $usuario_id);
                $stmtRol->execute();

                echo json_encode(['success' => true, 'message' => 'Usuario actualizado con éxito']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al actualizar el usuario']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage().'id rol'.$rol_id]);
        }
    } elseif ($accion === 'eliminar') {
        // Lógica para eliminar un usuario
        $usuario_id = $_POST['usuario_id'];

        try {
            // Eliminar el rol del usuario
            $queryRol = "DELETE FROM RolesUsuarios WHERE usuario_id = ?";
            $stmtRol = $conn->prepare($queryRol);
            $stmtRol->bind_param("i", $usuario_id);
            $stmtRol->execute();

            // Eliminar el usuario
            $queryDelete = "DELETE FROM Usuarios WHERE usuario_id = ?";
            $stmtDelete = $conn->prepare($queryDelete);
            $stmtDelete->bind_param("i", $usuario_id);

            if ($stmtDelete->execute()) {
                echo json_encode(['success' => true, 'message' => 'Usuario eliminado con éxito']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al eliminar el usuario']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
