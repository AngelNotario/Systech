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
        // Lógica para registrar un nuevo cliente
        $nombre = trim($_POST['nombre']);
        $apellidos = trim($_POST['apellidos']);
        $telefono = $_POST['telefono'];
        $email = trim($_POST['email']);
        $estado = $_POST['estado'];

        try {
            // Insertar el nuevo cliente
            $query = "INSERT INTO clientes (nombre, apellidos, telefono, email, estado, fecha_registro) VALUES (?, ?, ?, ?, ?, now())";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sssss", $nombre, $apellidos, $telefono, $email, $estado);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Cliente registrado con éxito']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al registrar el cliente']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    } elseif ($accion === 'editar') {
        // Lógica para editar un cliente
        $cliente_id = $_POST['id_cliente'];
        $nombre = trim($_POST['nombre']);
        $apellidos = trim($_POST['apellidos']);
        $telefono = $_POST['telefono'];
        $email = trim($_POST['email']);
        $estado = $_POST['estado'];

        try {
            // Actualizar el cliente
            $query = "UPDATE clientes SET nombre = ?, apellidos = ?, telefono = ?, email = ?, estado = ? WHERE cliente_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sssssi", $nombre, $apellidos, $telefono, $email, $estado, $cliente_id);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Cliente actualizado con éxito']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al actualizar el cliente']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    } elseif ($accion === 'eliminar') {
        // Lógica para eliminar un cliente
        $cliente_id = $_POST['id_cliente'];

        try {
            // Eliminar el cliente
            $queryDelete = "DELETE FROM clientes WHERE cliente_id = ?";
            $stmtDelete = $conn->prepare($queryDelete);
            $stmtDelete->bind_param("i", $cliente_id);

            if ($stmtDelete->execute()) {
                echo json_encode(['success' => true, 'message' => 'Cliente eliminado con éxito']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al eliminar el cliente']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
