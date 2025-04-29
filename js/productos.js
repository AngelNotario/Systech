document.addEventListener("DOMContentLoaded", () => {
  const tabla = new DataTable("#tabla", {
    processing: true,
    serverSide: true,
    ajax: "../controllers/productos_controller/fetch_productos.php",
    columns: [
      {
        data: "8",
        className: "text-center", 
        render: function (data) {
          return `<img src="../assets/images/productos/${data}" class="img-thumbnail" style="width: 100px;">`;
        }
      },
      { data: "0", className: "text-center" },
      { data: "1", className: "text-center" },
      { data: "2", className: "text-center" },
      { data: "3", className: "text-center" },
      { data: "4", className: "text-center" },
      { data: "5", className: "text-center" },
      { data: "6", className: "text-center" },
      { data: "7", className: "text-center" },
      { data: "9", className: "text-center", orderable: false  },
    ],
    columnDefs: [
      {
        targets: "no-export",
        visible: true,
      },
    ],
    paging: true,
    pageLength: 5,
    lengthMenu: [5, 10, 25, 50, 100],
    language: {
      paginate: {
        next: "Siguiente",
        previous: "Anterior",
      },
      lengthMenu: "Mostrar _MENU_ registros por página",
      info: "Mostrando página _PAGE_ de _PAGES_",
      infoEmpty: "No hay registros disponibles",
      infoFiltered: "(filtrado de _MAX_ registros totales)",
      zeroRecords: "No se encontraron registros coincidentes",
      search: "Buscar:",
    },
  });

  const fillSelect = async (url, selectId) => {
    try {
      const response = await fetch(url);
      if (!response.ok) throw new Error("Error fetching data");
      const data = await response.json();
      const select = document.getElementById(selectId);
      select.innerHTML = ""; // Vaciar el select antes de rellenarlo
      data.data.forEach((item) => {
         
        const option = document.createElement("option");
        option.value = item.id;
        option.textContent = item.nombre;
        select.appendChild(option);
      });
    } catch (error) {
      console.error("Error:", error);
    }
  };

  document
    .querySelectorAll(
      '[data-bs-target="#modalRegistrarCategoria"], [data-bs-target="#modalRegistrarCategoria"]'
    )
    .forEach(function (button) {
      button.addEventListener("click", function () {
        var modalproductos = new bootstrap.Modal(
          document.getElementById("modalRegistrarProducto")
        );
        modalproductos.hide();
      });
    });

  document
    .querySelectorAll(
      "#modalRegistrarCategoria .btn-close, #modalRegistrarCategoria .btn-secondary"
    )
    .forEach(function (button) {
      button.addEventListener("click", function () {
        var modalproductos = new bootstrap.Modal(
          document.getElementById("modalRegistrarProducto")
        );
        modalproductos.show();
      });
    });

  document
    .getElementById("modalRegistrarProducto")
    .addEventListener("show.bs.modal", () => {
      fillSelect(
        "../controllers/categorias_controller/get_all_categorias.php",
        "categoriaProducto"
      );

    });
  
  document
    .getElementById("modalEditarProducto")
    .addEventListener("show.bs.modal", () => {
      fillSelect(
        "../controllers/categorias_controller/get_all_categorias.php",
        "editarCategoriaProducto"
      );
    });

  $("#formRegistrarProducto").submit((e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    fetch("../controllers/productos_controller/productos_acciones.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => {
        if (!response.ok) throw new Error("Error processing request");
        return response.json();
      })
      .then((data) => {
        if (data.success) {
          $("#modalRegistrarProducto").modal("hide");
          tabla.ajax.reload();
          Swal.fire({
            icon: "success",
            title: "Éxito",
            text: data.message,
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: data.message,
          });
        }
      })
      .catch((error) => {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "Ocurrió un error al procesar la solicitud.",
        });
        console.error("Error:", error);
      });
  });

  $("#modalEditarProducto").on("show.bs.modal", function (event) {
    var button = $(event.relatedTarget); // Botón que abrió el modal
    var id_producto = button.data("id"); // Extraer el ID de los datos del botón

    // Obtener los datos del producto
    $.ajax({
      url: "../controllers/productos_controller/get_producto.php",
      type: "GET",
      data: { id_producto: id_producto },
      dataType: "json",
      success: function (data) {
        if (data.error) {
          console.error(data.error);
          return;
        }
        $("#editarProductoId").val(data.producto_id);
        $("#editarNombreProducto").val(data.nombre);
        $("#editarDescripcionProducto").val(data.descripcion);
        $("#editarCategoriaProducto").val(data.categoria_id);
        $("#editarPrecioCompraProducto").val(data.precio_compra);
        $("#editarPrecioVentaProducto").val(data.precio_venta);
        $("#editarStockProducto").val(data.stock);
        $("#editarCodigoBarrasProducto").val(data.codigo_barras);
      },
      error: function (error) {
        console.error("Error:", error);
      },
    });
  });


  $("#modalEditarProducto form").on("submit", async function (event) {
    event.preventDefault();
    var id_producto = $("#editarProductoId").val();
    var nombre = $("#editarNombreProducto").val();
    var descripcion = $("#editarDescripcionProducto").val();
    var categoria_id = $("#editarCategoriaProducto").val();
    var precio_compra = $("#editarPrecioCompraProducto").val();
    var precio_venta = $("#editarPrecioVentaProducto").val();
    var stock = $("#editarStockProducto").val();
    var codigo_barras = $("#editarCodigoBarrasProducto").val();
    var accion = "editar";
    var fileInput = document.getElementById("editarImagenProducto");
    var imagen = fileInput && fileInput.files.length > 0 ? fileInput.files[0] : null;

    try {
      const formData = new FormData();
      formData.append("id_producto", id_producto);
      formData.append("nombre", nombre);
      formData.append("descripcion", descripcion);
      formData.append("categoria_id", categoria_id);

      formData.append("precio_compra", precio_compra);
      formData.append("precio_venta", precio_venta);
      formData.append("stock", stock);
      formData.append("codigo_barras", codigo_barras);
      formData.append("accion", accion);
      if (imagen) {
        formData.append("imagen", imagen);
      }

      const response = await fetch(
        "../controllers/productos_controller/productos_acciones.php",
        {
          method: "POST",
          body: formData,
        }
      );
      const data = await response.json();
      if (data.success) {
        Swal.fire({
          icon: "success",
          title: "Éxito",
          timer: 1000,
          showConfirmButton: false,
          text: data.message,
        }).then(() => {
          window.location.reload();
        });
      } else {
        Swal.fire({
          icon: "error",
          title: "Error",
          timer: 1000,
          showConfirmButton: false,
          text: data.message,
        });
      }
    } catch (error) {
      console.error("Error:", error);
      Swal.fire({
        icon: "error",
        title: "Error",
        timer: 1000,
        showConfirmButton: false,
        text: "Ocurrió un error al intentar actualizar el producto",
      });
    }
  });

  $("#modalEliminarProducto").on("show.bs.modal", function (event) {
    var button = $(event.relatedTarget); // Botón que abrió el modal
    var id_producto = button.data("id"); // Extraer el ID de los datos del botón
    $("#modalEliminarProducto form").on("submit", async function (event) {
      event.preventDefault();
      try {
        const response = await fetch(
          "../controllers/productos_controller/productos_acciones.php",
          {
            method: "POST",
            headers: {
              "Content-Type": "application/x-www-form-urlencoded",
            },
            body: `producto_id=${id_producto}&accion=eliminar`,
          }
        );
        const data = await response.json();
        if (data.success) {
          Swal.fire({
            icon: "success",
            title: "Éxito",
            timer: 1000,
            showConfirmButton: false,
            text: "Producto eliminado correctamente",
          }).then(() => {
            tabla.ajax.reload();
            
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "Error",
            timer: 1000,
            showConfirmButton: false,
            text: "No se pudo eliminar el producto",
          });
        }
      } catch (error) {
        console.error("Error:", error);
        Swal.fire({
          icon: "error",
          title: "Error",
          timer: 1000,
          showConfirmButton: false,
          text: "Ocurrió un error al intentar eliminar el producto",
        });
      }
    });
  });


document.getElementById('buscarProducto').addEventListener('input', function () {
    var searchValue = this.value.toLowerCase();
    var options = document.querySelectorAll('select[name="producto"] option');
    options.forEach(function (option) {
        var text = option.textContent.toLowerCase();
        option.style.display = text.includes(searchValue) ? '' : 'none';
    });
});

fetch('../controllers/productos_controller/obtener_productos.php')
    .then(response => response.json())
    .then(data => {
        var selectProducto = document.getElementById('producto');
        selectProducto.innerHTML = '<option value="">Seleccionar Producto</option>';
        data.productos.forEach(producto => {
            selectProducto.innerHTML += `<option value="${producto.producto_id}">${producto.nombre} ${producto.descripcion}</option>`;
        });
    })
    .catch(error => console.error('Error al obtener los productos:', error));

    $("#formRegistrarCategoria").submit((e) => {
      e.preventDefault();
      const formData = new FormData(e.target);
      fetch("../controllers/categorias_controller/categorias_acciones.php", {
        method: "POST",
        body: formData,
      })
        .then((response) => {
          if (!response.ok) throw new Error("Error processing request");
          return response.json();
        })
        .then((data) => {
          if (data.success) {
            $("#modalRegistrarCategoria").modal("hide");
            $("#modalRegistrarProducto").modal("show");
            fillSelect("../controllers/categorias_controller/get_all_categorias.php", "categoriaProducto");
            Swal.fire({
              icon: "success",
              title: "Éxito",
              text: data.message,
              timer: 1000,
              showConfirmButton: false,
            });
          } else {
            Swal.fire({
              icon: "error",
              title: "Error",
              text: data.message,
            });
          }
        })
        .catch((error) => {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: "Ocurrió un error al procesar la solicitud.",
          });
          console.error("Error:", error);
        });
    });
    
    

});
