<?php
require_once "header.php";
?>

<h1 class="text-center"> <i class="bi bi-cart-check" style="margin: 20px; "></i>Punto de Venta</h1>

<div class="container mt-5">

    <div class="d-flex flex-column flex-md-row align-items-center gap-3 mb-2">
        <div class="input-group" style="max-width: 400px;">
            <input type="text" class="form-control" id="escanear_producto" placeholder="Escanear Producto" aria-label="Escanear Producto" aria-describedby="button-addon2" autofocus>
        </div>

        <button class="btn btn-primary" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#modalBuscarProducto">
            <i class="bi bi-box-seam"></i> Buscar Producto
        </button>

        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalArtComun">
            <i class="bi bi-box"></i> Articulo Común
        </button>

        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalSalidaEfectivo">
            <i class="bi bi-cash-stack"></i> Salidas
        </button>

        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCorteCaja">
            <i class="bi bi-clipboard-check"></i> Corte de Caja
        </button>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalMovimientos">
            <i class="bi bi-clock-history"></i> Historial de Movimientos
        </button>
    
    </div>

    <h2>Detalle de la Compra</h2>

    <div class="table-responsive">
        <table id="carrito" class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Imagen</th>
                    <th>Producto</th>
                    <th>Categoria</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>

    <h3>Total: $<span id="totalCarrito">0.00</span></h3>

    <button id="realizarVenta" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalConfirmarVenta"
        disabled>Realizar Venta
    </button>

</div>

<!-- Modal para buscar productos -->
<div class="modal fade" id="modalBuscarProducto" tabindex="-1" aria-labelledby="modalBuscarProductoLabel">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalBuscarProductoLabel">Buscar Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <input type="text" class="form-control" id="buscarProducto" placeholder="Buscar producto">
            </div>
            <table class="table table-striped table-bordered text-center" id="tablaProductos">
                <thead class="table-dark">
                    <tr>
                        <th>Código</th>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Aquí se llenarán los productos -->
                </tbody>
            </table>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Confirmar Venta -->
<div class="modal fade" id="modalConfirmarVenta" tabindex="-1" aria-labelledby="modalConfirmarVentaLabel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalConfirmarVentaLabel">Confirmar Venta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formVenta">
                    <div class="mb-3">
                        <label for="tipoPagoSelect" class="form-label">Tipo de Pago</label>
                        <select class="form-select" id="tipoPagoSelect" name="tipo_pago">
                            <option value="1">Efectivo</option>
                            <option value="2">Transferencia</option>
                            <option value="3">A Crédito</option>
                        </select>
                    </div>
                    <div id="referenciaDiv" class="mb-3" style="display:none;">
                        <label for="referencia" class="form-label">Referencia</label>
                        <input type="text" class="form-control" id="referencia" name="referencia">
                    </div>

                   
                    <div id="referenciaDiv" class="mb-3" style="display:none;">
                        <label for="referencia" class="form-label">Referencia</label>
                        <input type="text" class="form-control" id="referencia" name="referencia">
                    </div>
                    <div id="clienteCredito" class="mb-3">
                        <label for="clienteCreditoSelect" class="form-label">Seleccione Cliente</label>
                        <!-- Botón para agregar cliente -->
                        <button type="button" class="btn btn-link" data-bs-toggle="modal"
                            data-bs-target="#modalRegistrarCliente">
                            <i class="bi bi-plus-circle"></i>
                        </button>
                        <select class="form-select" name="id_cliente" id="clienteCreditoSelect">
                            <!-- Los clientes con crédito serán cargados aquí -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Información de la Venta</label>
                        <p id="informacionVenta">Total: <strong>$0.00</strong></p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" id="btnVenderSinImprimir" class="btn btn-primary">Vender Sin
                            Imprimir</button>
                        <button type="button" id="btnVenderConImprimir" class="btn btn-success">Vender e
                            Imprimir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Registrar Cliente -->
<div class="modal fade" id="modalRegistrarCliente" tabindex="-1" aria-labelledby="modalRegistrarClienteLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalRegistrarClienteLabel">Registrar Nuevo Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formRegistrarCliente">
                    <input type="hidden" name="accion" value="registrar">
                    <div class="mb-3">
                        <label for="nombre_cliente" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="apellidos_cliente" class="form-label">Apellidos</label>
                        <input type="text" class="form-control" id="apellidos" name="apellidos"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="telefono_cliente" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono"
                            pattern="\d{10,}" title="ingresa un numero de telefono valido" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" form="formRegistrarCliente" class="btn btn-primary">Registrar Cliente</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para salida de efectivo -->
<div class="modal fade" id="modalSalidaEfectivo" tabindex="-1" aria-labelledby="modalSalidaEfectivoLabel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalSalidaEfectivoLabel">Salida de Efectivo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formSalidaEfectivo" action="./cajas_controller/cajas_acciones.php" method="POST">
                    <div class="mb-3">
                        <label for="montoSalida" class="form-label">Monto</label>
                        <input type="number" class="form-control" id="montoSalida" name="monto_salida" required>
                    </div>
                    <div class="mb-3">
                        <label for="motivoSalida" class="form-label">Motivo</label>
                        <textarea class="form-control" id="motivoSalida" name="motivo_salida" rows="3"
                            required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Registrar Salida</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para articulo comun -->
<div class="modal fade" id="modalArtComun" tabindex="-1" aria-labelledby="modalArtComunLabel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalArtComunLabel">Articulo Comun</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formArtComun">
                    <div class="mb-3">
                        <label for="descripcionArtComun" class="form-label">Descripción</label>
                        <input type="text" class="form-control" id="descripcionArtComun" name="descripcion" required>
                    </div>
                    <div class="mb-3">
                        <label for="cantidadArtComun" class="form-label">Cantidad</label>
                        <input type="number" class="form-control" id="cantidadArtComun" name="cantidad" min="1"
                            value="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="precioArtComun" class="form-label">Precio</label>
                        <input type="number" class="form-control" id="precioArtComun" name="precio" min="0.01" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" id="btnAgregarArtComun" class="btn btn-primary">Agregar al
                            Carrito</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="../js/ventas.js"></script>

<?php
require_once "footer.php";
?>