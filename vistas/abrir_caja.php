<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apertura de caja</title>
  
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/DataTables/datatables.min.css" rel="stylesheet">
    <link href="../assets/css/root.css" rel="stylesheet">
    <script type="text/javascript" src="../assets/DataTables/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-light">

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow p-4" style="max-width: 500px; width: 100%;">
            <h2 class="text-center mb-4">Registro de Caja</h2>
            <form id="formRegistroCaja" action="./cajas_controller/cajas_acciones.php" method="POST">
                <?php
                if (isset($_SESSION['id_caja'])) {
                    echo "<input type=\"hidden\" name=\"accion\" value=\"abrir_caja\">";
                    echo "<input type=\"hidden\" name=\"id_caja\" value=\"{$_SESSION['id_caja']}\">";
                } else {
                    echo "<input type=\"hidden\" name=\"accion\" value=\"registrar_caja\">";
                }
                ?>

                <input type="hidden" name="id_usuario" value="<?php echo $_SESSION['id_usuario']; ?>">

                <div class="mb-3">
                    <label for="inicio_efectivo" class="form-label">Inicio de Efectivo en Caja</label>
                    <input type="number" class="form-control" id="inicio_efectivo" name="inicio_efectivo" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </div>
            </form>
        </div>
    </div>
    <script src="../js/cajas.js">
    </script>
    <footer>
    <script type="text/javascript" src="../assets/js/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" src="../assets/js/bootstrap.bundle.min.js"></script>
    </footer>

</body>

</html>