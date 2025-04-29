<?php

// Verificar si la sesión está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['id_usuario'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/DataTables/datatables.min.css" rel="stylesheet">
    <script type="text/javascript" src="../assets/DataTables/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background: linear-gradient(to right, #87CEEB, #4682B4);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background: #ffffff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
        }

        .login-container img {
            max-width: 200px;
            margin-bottom: 10px;
        }

        .input-group-text {
            background: #007bff;
            color: white;
            border: none;
        }

        .form-control {
            border-left: none;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #007bff;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            font-weight: bold;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow-lg" style="max-width: 400px; width: 100%;">
            <div style="display: flex; justify-content: center;">
                <img src="../assets/images/logo.jpg" alt="Logo del Gimnasio" style="max-width: 250px; margin-bottom: 20px;">
            </div>
            <h3 class="text-center mb-4">Iniciar Sesión</h3>
            <form id="loginForm">
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" id="usuario" name="usuario" class="form-control"
                            placeholder="Ingresa tu usuario" required>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" id="password" name="password" class="form-control"
                            placeholder="Ingresa tu contraseña" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100">Ingresar</button>
            </form>
        </div>
    </div>

    <script src="../js/login.js"></script>
    <script type="text/javascript" src="../assets/js/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>