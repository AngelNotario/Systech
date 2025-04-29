<?php
require_once __DIR__ . "/header.php";
?>

<div class="container-fluid">
    <h1 class="text-center mt-3">Productos</h1>

    <div class="d-flex flex-column flex-md-row align-items-center gap-3 mb-2">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalRegistrarProducto">
            Registrar Nuevo Producto
        </button>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgregarExistencias">
            Agregar Existencias
        </button>
    </div>

    <!-- Tabla -->
    <div class="table-responsive mb-3">
        <table class="table table-striped text-center" id="tabla">
            <thead>
                <tr class="bg-primary text-white">
                    <th>Imagen <i class="bi bi-image"></i></th>
                    <th>Nombre <i class="bi bi-tag"></i></th>
                    <th>Descripción <i class="bi bi-card-text"></i></th>
                    <th>Costo <i class="bi bi-currency-dollar"></i></th>
                    <th>Precio Venta <i class="bi bi-currency-dollar"></i></th>
                    <th>Categoría <i class="bi bi-list"></i></th>
                   
                    <th>Existencias <i class="bi bi-box-seam"></i></th>
                    <th>Código de Barras <i class="bi bi-upc-scan"></i></th>
                    <th>Fecha de Creacion <i class="bi bi-calendar"></i></th>
                    <th class="no-export">Acciones <i class="bi bi-gear"></i></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Registrar Producto -->
<div class="modal fade" id="modalRegistrarProducto" tabindex="-1" aria-labelledby="modalRegistrarProductoLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalRegistrarProductoLabel">Registrar Nuevo Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formRegistrarProducto">
                <input type="hidden" name="accion" value="registrar">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nombreProducto" class="form-label">Nombre del Producto</label>
                        <input type="text" class="form-control" id="nombreProducto" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcionProducto" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcionProducto" name="descripcion" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="categoriaProducto" class="form-label">Categoría</label>
                         <!-- Botón para agregar categoría -->
                         <button type="button" class="btn btn-link abrirModalRegistrarCategoria" data-bs-toggle="modal"
                            data-bs-target="#modalRegistrarCategoria">
                            <i class="bi bi-plus-circle"></i>
                        </button>
                        <select class="form-select" id="categoriaProducto" name="categoria_id" required>
                            <option value="" selected disabled>Seleccione una categoría</option>
                            <!-- Opciones dinámicas -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="precioCompraProducto" class="form-label">Precio de Compra</label>
                        <input type="number" class="form-control" id="precioCompraProducto" name="precio_compra" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="precioVentaProducto" class="form-label">Precio de Venta</label>
                        <input type="number" class="form-control" id="precioVentaProducto" name="precio_venta" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="stockProducto" class="form-label">Existencias</label>
                        <input type="number" class="form-control" id="stockProducto" name="stock" required>
                    </div>
                    <div class="mb-3">
                        <label for="codigoBarrasProducto" class="form-label">Código de Barras</label>
                        <input type="text" class="form-control" id="codigoBarrasProducto" name="codigo_barras">
                    </div>
                    <div class="mb-3">
                        <label for="imagenProducto" class="form-label">Imagen del Producto</label>
                        <input type="file" class="form-control" id="imagenProducto" name="imagen" accept="image/*">
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


<!-- Modal Agregar Existencias -->
<div class="modal fade" id="modalAgregarExistencias" tabindex="-1" aria-labelledby="modalAgregarExistenciasLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formAgregarExistencias" method="POST">
                <input type="hidden" name="accion" value="agregar_existencias">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAgregarExistenciasLabel">Agregar Existencias</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="d-flex  align-items-center m-2 mb-3">
                            <label for="producto" class="form-label">Producto</label>
                            <input type="text" id="buscarProducto" class="form-control mb-2"
                                placeholder="Buscar producto..." style=" width: 170px;  margin-left: auto;">
                        </div>
                        <select class="form-control" id="producto" name="producto" required>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="cantidad" class="form-label">Cantidad</label>
                        <input type="number" class="form-control" id="cantidad" name="cantidad" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Agregar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Registrar Categoría -->
<div class="modal fade" id="modalRegistrarCategoria" tabindex="-1" aria-labelledby="modalRegistrarCategoriaLabel">
    <div class="modal-dialog">
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

<!-- Modal Editar Producto -->
<div class="modal fade" id="modalEditarProducto" tabindex="-1" aria-labelledby="modalEditarProductoLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditarProductoLabel">Editar Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditarProducto">
                <input type="hidden" id="editarProductoId" name="id">
            
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editarNombreProducto" class="form-label">Nombre del Producto</label>
                        <input type="text" class="form-control" id="editarNombreProducto" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="editarDescripcionProducto" class="form-label">Descripción</label>
                        <textarea class="form-control" id="editarDescripcionProducto" name="descripcion" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editarCategoriaProducto" class="form-label">Categoría</label>
                        <select class="form-select" id="editarCategoriaProducto" name="categoria_id" required>
                            <option value="" selected disabled>Seleccione una categoría</option>
                            <!-- Opciones dinámicas -->
                        </select>
                    </div>
                
                    <div class="mb-3">
                        <label for="editarPrecioCompraProducto" class="form-label">Precio de Compra</label>
                        <input type="number" class="form-control" id="editarPrecioCompraProducto" name="precio_compra" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="editarPrecioVentaProducto" class="form-label">Precio de Venta</label>
                        <input type="number" class="form-control" id="editarPrecioVentaProducto" name="precio_venta" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="editarStockProducto" class="form-label">Existencias</label>
                        <input type="number" class="form-control" id="editarStockProducto" name="stock" required>
                    </div>
                    <div class="mb-3">
                        <label for="editarCodigoBarrasProducto" class="form-label">Código de Barras</label>
                        <input type="text" class="form-control" id="editarCodigoBarrasProducto" name="codigo_barras">
                    </div>
                    <div class="mb-3">
                        <label for="editarImagenProducto" class="form-label">Imagen del Producto</label>
                        <input type="file" class="form-control" id="editarImagenProducto" name="imagen" accept="image/*">
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

<!-- Modal Eliminar Producto-->
<div class="modal fade" id="modalEliminarProducto" tabindex="-1" aria-labelledby="modalEliminarProductoLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEliminarProductoLabel">Eliminar Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEliminarProducto">
                <input type="hidden" id="eliminarProductoId" name="id_producto">
                <div class="modal-body">
                    <p>¿Está seguro de que desea eliminar este producto?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="../js/productos.js"></script>


<?php require_once __DIR__ . "/footer.php"; ?>
