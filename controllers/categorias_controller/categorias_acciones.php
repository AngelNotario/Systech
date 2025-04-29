<?php
include "../../database/conexion.php";
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'];

    if ($accion == 'registrar') {
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        if (empty($nombre) || empty($descripcion)) {
            echo json_encode(['success' => 'false', 'message' => 'Todos los campos son obligatorios']);
            exit();
        }
        $sql = "INSERT INTO categorias (nombre, descripcion) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $nombre, $descripcion);
        if ($stmt->execute()) {
            echo json_encode(['success' => 'true', 'message' => 'Categoría registrada correctamente']);
        } else {
            echo json_encode(['success' => 'false', 'message' => 'Error al registrar la categoría']);
        }


    } elseif ($accion == 'editar') {
        $id_categoria = $_POST['id_categoria'];
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        if (empty($nombre) || empty($descripcion)) {
            echo json_encode(['success' => 'false', 'message' => 'Todos los campos son obligatorios']);
            exit();
        }
        $sql = "UPDATE categorias SET nombre = ?, descripcion = ? WHERE categoria_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssi', $nombre, $descripcion, $id_categoria);
        if ($stmt->execute()) {
            echo json_encode(['success' => 'true', 'message' => 'Categoría actualizada correctamente']);
        } else {
            echo json_encode(['success' => 'false', 'message' => 'Error al actualizar la categoría']);
        }
        
    } elseif ($accion == 'eliminar') {
        $id = $_POST['id_categoria'];
        $sql = "DELETE FROM categorias WHERE categoria_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);
        if ($stmt->execute()) {
            echo json_encode(['success' => 'true', 'message' => 'Categoría eliminada correctamente']);
        } else {
            echo json_encode(['success' => 'false', 'message' => 'Error al eliminar la categoría']);
        }
        
    }

} else {
    header("Location: ../login.php");
    exit();
}