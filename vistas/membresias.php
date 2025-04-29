<?php
require_once __DIR__ . "/header.php";
?>
<div class="container-fluid">

            <h2 class="text-center mb-4">Membresias</h2>

            <div class="table-responsive">
                <table class="table table-striped" id="tablaMembresias">
                    <thead>
                        <tr>
                            <th scope="col">ID Membresia <i class="bi bi-card-text"></i></th>
                            <th scope="col">Cliente <i class="bi bi-person"></i></th>
                            <th scope="col">Tipo Membresia <i class="bi bi-tag"></i></th>
                            <th scope="col">Fecha Inicio <i class="bi bi-calendar-event"></i></th>
                            <th scope="col">Fecha Fin <i class="bi bi-calendar-check"></i></th>
                            <th scope="col">Costo <i class="bi bi-currency-dollar"></i></th>
                            <th scope="col">Estado <i class="bi bi-info-circle"></i></th>
                        </tr>
                    </thead>
                </table>
            </div>
            
</div>


<script src="../js/membresias.js"></script>

<?php require_once __DIR__ . "/footer.php"; ?>