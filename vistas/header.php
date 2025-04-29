<?php
// Verificar si la sesión está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Si no hay una sesión activa, redirigir al login
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

$nombre_usuario = $_SESSION['nombre_usuario'];
$es_admin = $_SESSION['es_admin'];
$rol = $_SESSION['roles'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accesorios Brenda</title>

    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/DataTables/datatables.min.css" rel="stylesheet">
    <link href="../assets/css/root.css" rel="stylesheet">
    <script type="text/javascript" src="../assets/DataTables/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body >

    <nav class="navbar navbar-expand-lg bg-dark navbar-dark border-bottom p-3">
        <a class="navbar-brand d-flex align-items-center" href="principal.php">
            <img src="../assets/images/logo.jpg" alt="PcelFix Logo" width="50" height="50">
            <span class="ms-2">Pilot's Gym</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="principal.php">
                        <i class="bi bi-basket3-fill"></i> Punto de Venta
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="membresias.php">
                        <i class="bi bi-credit-card-2-front"></i> Membresías
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-box-seam"></i> Productos
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="productos.php"><i class="bi bi-box-seam"></i> Productos</a>
                        </li>
                        <li><a class="dropdown-item" href="categorias.php"><i class="bi bi-tags"></i> Categorías</a>
                        </li>
                        
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="clientes.php">
                        <i class="bi bi-person"></i> Clientes
                    </a>
                </li>
                <?php if ($es_admin): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="usuarios.php">
                            <i class="bi bi-people"></i> Usuarios
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="reportesDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-graph-up"></i> Reportes
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="reportesDropdown">
                            <li>
                                <a href="reportes_ventas.php" class="dropdown-item">
                                    <i class="bi bi-graph-up"></i> Reportes de Ventas
                                </a>
                            </li>
                            <li>
                                <a href="selecionar_usuario.php" class="dropdown-item">
                                    <i class="bi bi-graph-up"></i> Cortes de Caja
                                </a>
                            </li>
                            <li>
                                <a href="movimientos.php" class="dropdown-item">
                                    <i class="bi bi-arrow-left-right"></i> Movimientos
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

            </ul>

            <div class="d-flex align-items-center">
                <a href="perfil.php" class="text-light me-3"><i class="bi bi-person-circle fs-5"></i>
                    <?php echo $nombre_usuario ?></a>
                <a href="../controllers/logout.php" class="btn btn-danger btn-sm"><i class="bi bi-box-arrow-right"></i>
                    Salir</a>
            </div>
        </div>
        </div>
    </nav>