<?php
require_once __DIR__ . "/header.php";
?>

<div class="container-fluid">
    <h1 class="text-center mt-3">Categorías</h1>

    <div class="d-flex flex-column flex-md-row align-items-center gap-3 mb-2">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalRegistrarCategoria">
            Registrar Nueva Categoría
        </button>
    </div>

    <!-- Tabla -->
    <div class="table-responsive mb-3">
        <table class="table-primary text-center" id="tabla">
            <thead>
                <tr class="bg-primary text-white">
                    <th>Nombre <i class="bi bi-tag"></i></th>
                    <th>Descripción <i class="bi bi-card-text"></i></th>
                    <th class="no-export">Acciones <i class="bi bi-gear"></i></th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Registrar Categoría -->
<div class="modal fade" id="modalRegistrarCategoria" tabindex="-1" aria-labelledby="modalRegistrarCategoriaLabel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalRegistrarCategoriaLabel">Registrar Nueva Categoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formRegistrarCategoria">
                <input type="hidden" name="accion" value="registrar">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nombreCategoria" class="form-label">Nombre de la Categoría</label>
                        <input type="text" class="form-control" id="nombreCategoria" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcionCategoria" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcionCategoria" name="descripcion" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Categoría -->
<div class="modal fade" id="modalEditarCategoria" tabindex="-1" aria-labelledby="modalEditarCategoriaLabel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditarCategoriaLabel">Editar Categoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditarCategoria">
                <input type="hidden" name="accion" value="editar">
                <input type="hidden" id="id_categoria" name="id_categoria">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editarNombreCategoria" class="form-label">Nombre de la Categoría</label>
                        <input type="text" class="form-control" id="editarNombreCategoria" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="editarDescripcionCategoria" class="form-label">Descripción</label>
                        <textarea class="form-control" id="editarDescripcionCategoria" name="descripcion" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Eliminar Categoría -->
<div class="modal fade" id="modalEliminarCategoria" tabindex="-1" aria-labelledby="modalEliminarCategoriaLabel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEliminarCategoriaLabel">Eliminar Categoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEliminarCategoria">
                <input type="hidden" name="accion" value="eliminar">
                <input type="hidden" id="idCategoriaEliminar" name="id">
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas eliminar esta categoría?</p>
                    <p>Esta acción no se puede deshacer.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="../js/categorias.js"></script>

<?php require_once __DIR__ . "/footer.php"; ?>