document.addEventListener("DOMContentLoaded", () => {
  const carritoBody = document.querySelector("#carrito tbody");
  const totalCarrito = document.getElementById("totalCarrito");
  const realizarVenta = document.getElementById("realizarVenta");

  const tipoPagoSelect = document.getElementById("tipoPagoSelect");
  const referenciaDiv = document.getElementById("referenciaDiv");

  tipoPagoSelect.addEventListener("change", () => {
    if (tipoPagoSelect.value == "2") {
      referenciaDiv.style.display = "block";
      document.getElementById("referencia").required = true;
    } else {
      referenciaDiv.style.display = "none";
      document.getElementById("referencia").required = false;
    }
  });

  document
    .getElementById("escanear_producto")
    .addEventListener("keyup", function () {
      const producto = this.value.trim();
      if (producto.length > 5) {
        try {
          fetch("../controllers/productos_controller/escanear_producto.php", {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({ codigo: producto }),
          })
            .then((response) => response.json())
            .then((data) => {
              if (data.status == "success") {
                // Limpiar el campo de entrada
                document.getElementById("escanear_producto").value = "";

                // Crear una nueva fila para el producto
                const tr = document.createElement("tr");
                tr.innerHTML = `
                                <td>${data.producto.producto_id}</td>
                                <td><img src="../assets/images/productos/${data.producto.imagen}" class="img-thumbnail" style="width: 100px;"></td>
                                <td>${data.producto.nombre}</td>
                                <td>${data.producto.categoria}</td>
                                <td><input type="number" value="${data.producto.precio_venta}" class="form-control" min="0" step="1.00" onchange="actualizarTotal(this, true)"></td>
                                <td><input type="number" value="1" class="form-control" min="1" onchange="if(this.value < 1) this.value = 1; actualizarTotal(this)"></td>
                                <td>$${data.producto.precio_venta}</td>
                                <td><button class="btn btn-danger" onclick="eliminarItem(this)">Eliminar</button></td>
                            `;
                carritoBody.appendChild(tr);

                // Actualizar el total del carrito
                actualizarTotal(tr.querySelector("input[type='number']"), true);

                // Habilitar el botón de realizar venta
                realizarVenta.disabled = false;
              } else {
                document.getElementById("escanear_producto").value = "";
                Swal.fire({
                  icon: "error",
                  title: "Producto no encontrado",
                  text: "El producto que buscas no está registrado.",
                });
              }
            })
            .catch((error) => console.error("Error:", error));
        } catch (error) {
          console.error("Error al escanear el producto:", error);
        }
      }
    });

  document
    .getElementById("modalConfirmarVenta")
    .addEventListener("show.bs.modal", () => {
     actualizarselectClientes();
    });

  document
    .getElementById("formRegistrarCliente")
    .addEventListener("submit", function (e) {
      e.preventDefault();

      const formData = new FormData(this);

      fetch("../controllers/clientes_controller/clientes_acciones.php", {
        method: "POST",
        body: formData,
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            Swal.fire({
              icon: "success",
              title: "Cliente registrado",
              text: "El cliente ha sido registrado exitosamente.",
            });

            // Limpiar el formulario
            this.reset();

           

            // Cerrar el modal
            const modal = bootstrap.Modal.getInstance(
              document.getElementById("modalRegistrarCliente")
            );
            modal.hide();

            // Abirr modal de confirmar venta
            const modalConfirmarVenta = new bootstrap.Modal(
              document.getElementById("modalConfirmarVenta")
            );
            modalConfirmarVenta.show();

            actualizarselectClientes();

          } else {
            Swal.fire({
              icon: "error",
              title: "Error",
              text: data.message || "No se pudo registrar el cliente.",
            });
          }
        })
        .catch((error) => {
          console.error("Error al registrar el cliente:", error);
          Swal.fire({
            icon: "error",
            title: "Error",
            text: "Ocurrió un error al registrar el cliente.",
          });
        });
    });

    document.getElementById("buscarProducto").addEventListener("keyup", function () {
       const producto = this.value.trim();
         if (producto.length > 1) {
            buscarProducto(producto);
         }
    });



    document.getElementById('btnAgregarArtComun').addEventListener('click', () => {
      const descripcion = document.getElementById('descripcionArtComun').value;
      const cantidad = parseInt(document.getElementById('cantidadArtComun').value);
      const precio = parseFloat(document.getElementById('precioArtComun').value);
      const total = cantidad * precio;

      const carritoBody = document.getElementById("carrito").getElementsByTagName("tbody")[0];
      const totalCarrito = document.getElementById("totalCarrito");

      // Crear una nueva fila para el artículo común
      const newRow = document.createElement("tr");
      newRow.innerHTML = `
          <td>0</td>
          <td><i class="bi bi-box" style="font-size: 4rem;"></i></td>
          <td>Articulo Comun</td>
          <td>${descripcion}</td>
          <td><input type="number" value="${precio}.00" class="form-control" min="0" step="1.00" onchange="actualizarTotal(this, true)"></td>
          <td><input type="number" value="${cantidad}" class="form-control" min="1" onchange="if(this.value < 1) this.value = 1; actualizarTotal(this)"></td>
          <td>$${total.toFixed(2)}</td>
          <td><button type="button" class="btn btn-danger" onclick="eliminarItem(this)">Eliminar</button></td>
      `;
      carritoBody.appendChild(newRow);

      // Actualizar el total del carrito
      let totalCarritoValue = parseFloat(totalCarrito.textContent);
      totalCarritoValue += total;
      totalCarrito.textContent = totalCarritoValue.toFixed(2);

      // Habilitar el botón de realizar venta
      document.getElementById("realizarVenta").disabled = false;

      // Cerrar el modal
      const modalArtComun = bootstrap.Modal.getInstance(document.getElementById('modalArtComun'));
      modalArtComun.hide();

      // Limpiar el formulario
      const formulario = document.getElementById('formArtComun');
      formulario.reset();
    });
     
});




// Función para actualizar el total del carrito
function actualizarTotal(input, isPrecio = false) {
  const fila = input.closest("tr");
  const precio = parseFloat(fila.children[4].querySelector("input").value);
  const cantidad = parseInt(fila.children[5].querySelector("input").value);

  // Actualizar el subtotal de la fila
  const subtotal = precio * cantidad;
  fila.children[6].textContent = `$${subtotal.toFixed(2)}`;

  // Recalcular el total del carrito
  let total = 0;
  document.querySelectorAll("#carrito tbody tr").forEach((row) => {
    const precioFila = parseFloat(row.children[4].querySelector("input").value);
    const cantidadFila = parseInt(row.children[5].querySelector("input").value);
    total += precioFila * cantidadFila;
  });

  // Actualizar el total en el DOM
  document.getElementById("totalCarrito").textContent = total.toFixed(2);
}

function actualizarselectClientes() {
  const clienteCreditoSelect = document.getElementById("clienteCreditoSelect");
  clienteCreditoSelect.innerHTML = '<option value="">Cargando...</option>';

  fetch("../controllers/clientes_controller/get_clientes.php")
    .then((response) => response.json())
    .then((data) => {
      clienteCreditoSelect.innerHTML =
        '<option value="">Seleccione un cliente</option>';
      data.forEach((clientes) => {
        const option = document.createElement("option");
        option.value = clientes.cliente_id;
        option.textContent = clientes.nombre + " " + clientes.apellidos;
        clienteCreditoSelect.appendChild(option);
      });
    })
    .catch((error) => {
      console.error("Error al cargar los clientes:", error);
      clienteCreditoSelect.innerHTML =
        '<option value="">Error al cargar clientes</option>';
    });
}

// Función para eliminar un producto del carrito
function eliminarItem(button) {
  const fila = button.closest("tr");
  fila.remove();

  // Recalcular el total del carrito
  actualizarTotal(fila);

  // Deshabilitar el botón de realizar venta si el carrito está vacío
  const carritoBody = document.querySelector("#carrito tbody");
  const realizarVenta = document.getElementById("realizarVenta");
  if (carritoBody.children.length === 0) {
    realizarVenta.disabled = true;
  }
}

function buscarProducto(producto) {
    fetch(`../controllers/productos_controller/buscar_productos.php?busqueda=${producto}`)
        .then((response) => response.json())
        .then((data) => {
            const tablaProductos = document.querySelector("#tablaProductos tbody");
            tablaProductos.innerHTML = ""; // Limpiar la tabla antes de llenarla

            if (data.length > 0) {
                data.forEach((producto) => {
                    const tr = document.createElement("tr");
                    tr.innerHTML = `
                        <td>${producto.codigo_barras}</td>
                        <td><img src="../assets/images/productos/${producto.imagen}" class="img-thumbnail" style="width: 100px;"></td>
                        <td>${producto.nombre}</td>
                        <td>$${producto.precio_venta}</td>
                        <td><button class="btn btn-primary" onclick="agregarAlCarrito(${producto.producto_id}, '${producto.nombre}', '${producto.categoria}', ${producto.precio_venta},'${producto.imagen}')">Agregar</button></td>
                    `;
                    tablaProductos.appendChild(tr);
                });
            } else {
                tablaProductos.innerHTML = `
                    <tr>
                        <td colspan="4">No se encontraron productos.</td>
                    </tr>
                `;
            }
        })
        .catch((error) => console.error("Error al buscar productos:", error));
}

function agregarAlCarrito(id, nombre, categoria, precio, imagen) {
    const carritoBody = document.querySelector("#carrito tbody");
    const realizarVenta = document.getElementById("realizarVenta");
    console.log(id, nombre, categoria, precio, imagen);

    // Crear una nueva fila para el producto
    const tr = document.createElement("tr");
    tr.innerHTML = `
        <td>${id}</td>
        <td><img src="../assets/images/productos/${imagen}" class="img-thumbnail" style="width: 100px;"></td>
        <td>${nombre}</td>
        <td>${categoria}</td>
        <td><input type="number" value="${precio}.00" class="form-control" min="0" step="1.00" onchange="actualizarTotal(this, true)"></td>
        <td><input type="number" value="1" class="form-control" min="1" onchange="if(this.value < 1) this.value = 1; actualizarTotal(this)"></td>
        <td>$${precio}</td>
        <td><button class="btn btn-danger" onclick="eliminarItem(this)">Eliminar</button></td>
    `;
    carritoBody.appendChild(tr);

    // Actualizar el total del carrito
    actualizarTotal(tr.querySelector("input[type='number']"), true);

    // Habilitar el botón de realizar venta
    realizarVenta.disabled = false;
}