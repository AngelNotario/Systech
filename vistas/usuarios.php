<?php
require_once __DIR__ . "/header.php";
?>


<div class="container">
    <div class="row">
        <div class="col">
            <h1 class="text-center">Usuarios</h1>
        </div>
    </div>
    <div class="row">
        <div class="d-flex justify-content-between align-items-center m-2 mb-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                data-bs-target="#modalRegistrarUsuario">
                Registrar Nuevo Usuario
            </button>
        </div>

    </div>

    <!-- Tabla -->
    <div class="table-responsive mb-3">
        <table class="table-primary text-center" id="tabla">
            <thead>
                <tr class="bg-primary text-white">
                    <th>Nombre de usuario <i class="bi bi-person"></i></th>
                    <th>Correo <i class="bi bi-envelope"></i></th>
                    <th>Nombre completo <i class="bi bi-card-text"></i></th>
                    <th>Estado <i class="bi bi-toggle-on"></i></th>
                    <th class="no-export">Acciones <i class="bi bi-gear"></i></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal para registrar un nuevo usuario -->
<div class="modal fade" id="modalRegistrarUsuario" tabindex="-1" aria-labelledby="modalRegistrarUsuarioLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h3 class="modal-title text-white" id="modalRegistrarUsuarioLabel">Registrar Nuevo Usuario</h3>
                <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formRegistrarUsuario">
                    <div class="mb-3">
                        <label for="nombre_usuario" class="form-label">Nombre de usuario</label>
                        <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" required>
                    </div>
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo</label>
                        <input type="email" class="form-control" id="correo" name="correo" required>
                    </div>
                    <div class="mb-3">
                        <label for="nombre_completo" class="form-label">Nombre completo</label>
                        <input type="text" class="form-control" id="nombre_completo" name="nombre_completo" required>
                    </div>
                    <div class="mb-3">
                        <label for="contraseña" class="form-label">Contraseña</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="contraseña" name="contraseña" required>
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <i class="bi bi-eye-slash" id="toggleIcon"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="rol" class="form-label">Puesto</label>
                        <select class="form-select" id="rol" name="rol" required>
                           
                        </select>
                    </div>
                    <div class="d-grid gap">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para editar un usuario -->
<div class="modal fade" id="modalEditarUsuario" tabindex="-1" aria-labelledby="modalEditarUsuarioLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h3 class="modal-title text-white" id="modalEditarUsuarioLabel">Editar Usuario</h3>
                <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditarUsuario">
                    <input type="hidden" id="id_usuario" name="id_usuario">
                    <div class="mb-3">
                        <label for="editar_nombre_usuario" class="form-label">Nombre de usuario</label>
                        <input type="text" class="form-control" id="editar_nombre_usuario" name="nombre_usuario"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="editar_correo" class="form-label">Correo</label>
                        <input type="email" class="form-control" id="editar_correo" name="correo" required>
                    </div>
                    <div class="mb-3">
                        <label for="editar_nombre_completo" class="form-label">Nombre completo</label>
                        <input type="text" class="form-control" id="editar_nombre_completo" name="nombre_completo"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="editar_contraseña" class="form-label">Contraseña</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="editar_contraseña" name="contraseña"
                                >
                            <button class="btn btn-outline-secondary" type="button" id="togglePasswordEdit">
                                <i class="bi bi-eye-slash" id="toggleIconEdit"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="editar_rol" class="form-label">Puesto</label>
                        <select class="form-select" id="editar_rol" name="rol" required>  
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editar_estado" class="form-label">Estado</label>
                        <select class="form-select" id="editar_estado" name="estado" required>
                            <option value="">Selecciona un estado</option>
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
                        </select>
                    </div>
                    <div class="d-grid gap">
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para eliminar un usuario -->
<div class="modal fade" id="modalEliminarUsuario" tabindex="-1" aria-labelledby="modalEliminarUsuarioLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h3 class="modal-title text-white" id="modalEliminarUsuarioLabel">Eliminar Usuario</h3>
                <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEliminarUsuario">
                    <input type="hidden" id="eliminar_id_usuario" name="id_usuario">
                    <p>¿Estás seguro de que deseas eliminar este usuario?</p>
                    <div class="d-grid gap">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script src="../js/usuarios.js"></script>



<?php require_once __DIR__ . "/footer.php"; ?>