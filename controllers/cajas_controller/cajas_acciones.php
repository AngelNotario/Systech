<?php
session_start();
include "../../database/conexion.php";


header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'];

    if ($accion === 'registrar_caja') {

        $id_usuario = $_SESSION['id_usuario'];
        $efectivo_inicial = filter_input(INPUT_POST, 'inicio_efectivo', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

        // Insertar en caja
        $sql = "INSERT INTO cajas (
            estatus, 
            hora_apertura, 
            usuario, 
            efectivo_inicial,
            efectivo_final
        ) VALUES (
            'abierta', 
            now(), 
            ?,
            ?, 
            ?
        )";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param('idd', $id_usuario, $efectivo_inicial, $efectivo_inicial);

            if ($stmt->execute()) {
                // Obtener el ID de la caja registrada
                $_SESSION['id_caja'] = $stmt->insert_id;

                echo json_encode([
                    'success' => true,
                    'mensaje' => 'Caja registrada correctamente'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'mensaje' => "Error al ejecutar la consulta: {$stmt->error}"
                ]);
            }

            $stmt->close();
        } else {
            echo json_encode([
                'success' => false,
                'mensaje' => "Error en la preparación: {$conn->error}"
            ]);
        }
    } else if ($accion === 'abrir_caja') {
        $id_usuario = $_SESSION['id_usuario'];
        $id_caja = $_POST['id_caja'];
        $efectivo_inicial = filter_input(INPUT_POST, 'inicio_efectivo', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $sqlUpdateCaja = "UPDATE cajas SET estatus = 'abierta', hora_apertura = now(),hora_cierre = null,  efectivo_inicial = ?, efectivo_final = ? WHERE id_caja = ?";
        if ($stmt = $conn->prepare($sqlUpdateCaja)) {
            $stmt->bind_param('ddi',  $efectivo_inicial, $efectivo_inicial, $id_caja);
            if ($stmt->execute()) {
                echo json_encode([
                    'success' => true,
                    'mensaje' => 'Caja abierta correctamente'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'mensaje' => "Error al ejecutar la consulta: {$stmt->error}"
                ]);
            }
            $stmt->close();
        } else {
            echo json_encode([
                'success' => false,
                'mensaje' => "Error en la preparación: {$conn->error}"
            ]);
        }
    } else if ($accion === 'salida_efectivo') {
        $monto_salida = filter_input(INPUT_POST, 'monto_salida', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $motivo_salida = filter_input(INPUT_POST, 'motivo_salida', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $id_caja = $_SESSION['id_caja'];

        // Validar que los campos no estén vacíos
        if (empty($monto_salida) || empty($motivo_salida)) {
            echo json_encode([
                'success' => false,
                'mensaje' => 'Todos los campos son obligatorios'
            ]);
            exit;
        }
        // Obtener el efectivo final actual
        $sql_select = "SELECT efectivo_final FROM cajas WHERE id_caja = ?";
        if ($stmt_select = $conn->prepare($sql_select)) {
            $stmt_select->bind_param('i', $id_caja);
            $stmt_select->execute();
            $stmt_select->bind_result($efectivo_final);
            $stmt_select->fetch();
            $stmt_select->close();
        }

        // Validar que el monto de salida no exceda el efectivo final
        if ($monto_salida > $efectivo_final) {
            echo json_encode([
                'success' => false,
                'mensaje' => 'El monto de salida excede el efectivo disponible en la caja'
            ]);
        } else {
            // Insertar en salidas
            $sql = "INSERT INTO salidas (
                monto, 
                concepto, 
                fecha_hora, 
                caja
            ) VALUES (
                ?, 
                ?, 
                now(), 
                ?
            )";
            if ($stmt_insert = $conn->prepare($sql)) {
                $stmt_insert->bind_param('dsi', $monto_salida, $motivo_salida, $id_caja);
                $stmt_insert->execute();
                $stmt_insert->close();
            }

            // Actualizar efectivo final en la tabla cajas
            $sql_update = "UPDATE cajas SET efectivo_final = efectivo_final - ? WHERE id_caja = ?";
            if ($stmt_update = $conn->prepare($sql_update)) {
                $stmt_update->bind_param('di', $monto_salida, $id_caja);
                $stmt_update->execute();
                $stmt_update->close();
            }

            echo json_encode([
                'success' => true,
                'mensaje' => 'Salida de efectivo registrada correctamente',
                'efectivo_actualizado' => $efectivo_final - $monto_salida
            ]);
        }
    }
}