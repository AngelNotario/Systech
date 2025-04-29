<?php
require_once __DIR__ . "/header.php";
?>
<div class="container">
    <h1 class="text-center mt-3">Clientes</h1>

    <div class="d-flex flex-column flex-md-row align-items-center gap-3 mb-2">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalRegistrarCliente">
            Registrar Nuevo Cliente
        </button>
    </div>

    <!-- Tabla -->
    <div class="table-responsive mb-3">
        <table class="table-primary text-center" id="tabla">
            <thead>
                <tr class="bg-primary text-white">
                    <th>Nombre <i class="bi bi-person"></i></th>
                    <th>Apellidos <i class="bi bi-envelope"></i></th>
                    <th>Teléfono <i class="bi bi-telephone"></i></th>
                    <th>Correo <i class="bi bi-envelope"></i></th>
                    <th>Fecha Registro <i class="bi bi-calendar"></i></th>
                    <th>Estado <i class="bi bi-check-circle"></i></th>
                    <th class="no-export">Acciones <i class="bi bi-gear"></i></th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>

<!-- Modal Registrar Cliente -->
<div class="modal fade" id="modalRegistrarCliente" tabindex="-1" aria-labelledby="modalRegistrarClienteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalRegistrarClienteLabel">Registrar Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formRegistrarCliente">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="apellidos" class="form-label">Apellidos</label>
                        <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-select" id="estado" name="estado" required>
                            <option value="Activo">Activo</option>
                            <option value="Inactivo">Inactivo</option>
                        </select>
                    </div>
                    <input type="hidden" name="accion" value="registrar">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formRegistrarCliente" class="btn btn-primary">Registrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar Cliente -->
<div class="modal fade" id="modalEditarCliente" tabindex="-1" aria-labelledby="modalEditarClienteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditarClienteLabel">Editar Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditarCliente">
                    
                    <div class="mb-3">
                        <label for="editar_nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="editar_nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="editar_apellidos" class="form-label">Apellidos</label>
                        <input type="text" class="form-control" id="editar_apellidos" name="apellidos" required>
                    </div>
                    <div class="mb-3">
                        <label for="editar_telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="editar_telefono" name="telefono">
                    </div>
                    <div class="mb-3">
                        <label for="editar_email" class="form-label">Correo</label>
                        <input type="email" class="form-control" id="editar_email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="editar_estado" class="form-label">Estado</label>
                        <select class="form-select" id="editar_estado" name="estado" required>
                            <option value="Activo">Activo</option>
                            <option value="Inactivo">Inactivo</option>
                        </select>
                    </div>
                    <input type="hidden" id="editar_id_cliente" name="id_cliente">
                    <input type="hidden" name="accion" value="editar">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formEditarCliente" class="btn btn-primary">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Eliminar Cliente -->
<div class="modal fade" id="modalEliminarCliente" tabindex="-1" aria-labelledby="modalEliminarClienteLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEliminarClienteLabel">Eliminar Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas eliminar este cliente?</p>
                <form id="formEliminarCliente">
                    <input type="hidden" name="accion" value="eliminar">
                    <input type="hidden" id="id_cliente_eliminar" name="id_cliente">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formEliminarCliente" class="btn btn-danger">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<script src="../js/clientes.js"></script>

<?php
require_once __DIR__ . "/footer.php";
?>