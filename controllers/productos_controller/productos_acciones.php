<?php
include "../../database/conexion.php";
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
    exit();
}

$directorioImagenes = "../../assets/images/productos/";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'];

    if ($accion === 'registrar') {
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $categoria_id = $_POST['categoria_id'];
        $precio_compra = $_POST['precio_compra'];
        $precio_venta = $_POST['precio_venta'];
        $stock = $_POST['stock'];
        $codigo_barras = $_POST['codigo_barras'];

        if (empty($nombre) || empty($categoria_id) || empty($precio_compra) || empty($precio_venta) || empty($stock) || empty($_FILES['imagen']['name'])) {
            echo json_encode(['status' => 'error', 'message' => 'Todos los campos son obligatorios']);
            exit();
        }

        // Procesar imagen
        $nombreImagen = uniqid() . "-" . basename($_FILES['imagen']['name']);
        $rutaImagen = $directorioImagenes . $nombreImagen;
        $rutaBD = $nombreImagen;

        if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaImagen)) {
            echo json_encode(['status' => 'error', 'message' => 'Error al subir la imagen']);
            exit();
        }

        $sql = "INSERT INTO Productos (nombre, descripcion, categoria_id, precio_compra, precio_venta, stock, codigo_barras,fecha_creacion , imagen) VALUES (?, ?, ?, ?, ?, ?, ?, now() , ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssiiddss", $nombre, $descripcion, $categoria_id, $precio_compra, $precio_venta, $stock, $codigo_barras, $rutaBD);

        if ($stmt->execute()) {
            $stmt->close();
            echo json_encode(['success' => 'true', 'message' => 'Producto registrado correctamente']);
        } else {
            $stmt->close();
            echo json_encode(['success' => 'false', 'message' => 'Error al registrar el producto: ' . $conn->error]);
        }
        exit();

    } elseif ($accion === 'editar') {

        $id_producto = $_POST['id_producto'];
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $categoria_id = $_POST['categoria_id'];
        $precio_compra = $_POST['precio_compra'];
        $precio_venta = $_POST['precio_venta'];
        $stock = $_POST['stock'];
        $codigo_barras = $_POST['codigo_barras'];

        if (empty($id_producto) || empty($nombre) || empty($categoria_id) || empty($precio_compra) || empty($precio_venta) || empty($stock)) {
            echo json_encode(['status' => 'error', 'message' => 'Todos los campos obligatorios deben ser completados']);
            exit();
        }

        if (isset($_FILES['imagen']) && is_uploaded_file($_FILES['imagen']['tmp_name'])) {
            $nombreImagen = uniqid() . "-" . basename($_FILES['imagen']['name']);
            $rutaImagen = $directorioImagenes . $nombreImagen;
            $rutaBD = $nombreImagen;

            if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaImagen)) {
                echo json_encode(['status' => 'error', 'message' => 'Error al subir la nueva imagen']);
                exit();
            }

            $sql = "UPDATE Productos SET nombre = ?, descripcion = ?, categoria_id = ?, precio_compra = ?, precio_venta = ?, stock = ?, codigo_barras = ?, imagen = ? WHERE producto_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssiddsssi", $nombre, $descripcion, $categoria_id, $precio_compra, $precio_venta, $stock, $codigo_barras, $rutaBD, $id_producto);
        } else {
            $sql = "UPDATE Productos SET nombre = ?, descripcion = ?, categoria_id = ?, precio_compra = ?, precio_venta = ?, stock = ?, codigo_barras = ? WHERE producto_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssiddssi", $nombre, $descripcion, $categoria_id, $precio_compra, $precio_venta, $stock, $codigo_barras, $id_producto);
        }

        if ($stmt->execute()) {
            $stmt->close();
            echo json_encode(['success' => 'true', 'message' => 'Producto actualizado correctamente']);
        } else {
            $stmt->close();
            echo json_encode(['success' => 'false', 'message' => 'Error al actualizar el producto: ' . $conn->error]);
        }
        exit();


    } elseif ($accion === 'eliminar') {
        $id_producto = $_POST['producto_id'];

        if (empty($id_producto)) {
            echo json_encode(['status' => 'error', 'message' => 'El ID del producto es obligatorio']);
            exit();
        }

        $sql = "DELETE FROM Productos WHERE producto_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_producto);
        if ($stmt->execute()) {
            $stmt->close();
            echo json_encode(['success' => 'true', 'message' => 'Producto eliminado correctamente']);
            exit();
        } else {
            $stmt->close();
            echo json_encode(['success' => 'false', 'message' => 'Ocurrió un error al eliminar el producto: ' . $conn->error]);
            exit();
        }
    }

} else {
    header("Location: ../login.php");
    exit();
}
?>