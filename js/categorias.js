document.addEventListener("DOMContentLoaded", () => {
  const tablaInstance = new DataTable("#tabla", {
    processing: true,
    serverSide: true,
    ajax: "../controllers/categorias_controller/fetch_categorias.php",
    columns: [
      {
        data: "0",
        className: "text-center",
      },
      {
        data: "1",
        className: "text-center",
      },
      {
        data: "2",
        className: "text-center",
      },
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

  document
    .getElementById("formRegistrarCategoria")
    .addEventListener("submit", (e) => {
      e.preventDefault();

      const formData = new FormData(e.target);

      fetch("../controllers/categorias_controller/categorias_acciones.php", {
        method: "POST",
        body: formData,
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            Swal.fire({
              icon: "success",
              title: "Éxito",
              timer: 1000, // Se cerrará automáticamente después de 2 segundos
              showConfirmButton: false,
              text: data.message,
            }).then(() => {
              e.target.reset();
              $("#modalRegistrarCategoria").modal("hide");
              tablaInstance.ajax.reload();
            });
          } else {
            Swal.fire({
              icon: "error",
              title: "Error",
              timer: 1000, // Se cerrará automáticamente después de 2 segundos
              showConfirmButton: false,
              text: "Error al registrar la categoría: " + data.message,
            });
          }
        })
        .catch((error) => {
          console.error("Error:", error);
          Swal.fire({
            icon: "error",
            title: "Error",
            text: data.message,
          });
        });
    });


    $("#modalEditarCategoria").on("show.bs.modal", function (event) {
        var button = $(event.relatedTarget); // Botón que abrió el modal
        var id_categoria = button.data("id"); // Extraer el ID de los datos del botón

        // Obtener los datos de la categoría
        $.ajax({
            url: "../controllers/categorias_controller/get_categoria.php",
            type: "GET",
            data: { id_categoria: id_categoria },
            dataType: "json",
            success: function (data) {
                if (data.error) {
                    console.error(data.error);
                    return;
                }
                // Rellenar los campos del formulario con los datos obtenidos
                $('#modalEditarCategoria input[name="id_categoria"]').val(data.id);
                $('#modalEditarCategoria input[name="nombre"]').val(data.nombre);
                $('#modalEditarCategoria textarea[name="descripcion"]').val(data.descripcion);
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error: " + status + error);
            },
        });
    });

    $("#modalEditarCategoria form").on("submit", async function (event) {
        event.preventDefault();
        var id_categoria = $('#modalEditarCategoria input[name="id_categoria"]').val();
        var nombre_categoria = $('#modalEditarCategoria input[name="nombre"]').val();
        var descripcion = $('#modalEditarCategoria textarea[name="descripcion"]').val();
        var accion = "editar";

        try {
            const response = await fetch(
                "../controllers/categorias_controller/categorias_acciones.php",
                {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body: `id_categoria=${id_categoria}&nombre=${nombre_categoria}&descripcion=${descripcion}&accion=${accion}`,
                }
            );
            const data = await response.json();
            if (data.success) {
                Swal.fire({
                    icon: "success",
                    title: "Éxito",
                    timer: 1000, // Se cerrará automáticamente después de 2 segundos
                    text: data.message,
                }).then(() => {
                    $("#modalEditarCategoria").modal("hide");
                    tablaInstance.ajax.reload();
                });
            }
            else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Error al editar la categoría: " + data.message,
                });
            }
        }
        catch (error) {
            console.error("Error:", error);
            Swal.fire({
                icon: "error",
                title: "Error",
                text: data.message,
            });
        }
    });



  $("#modalEliminarCategoria").on("show.bs.modal", function (event) {
    var button = $(event.relatedTarget); // Botón que abrió el modal
    var id_categoria = button.data("id"); // Extraer el ID de los datos del botón

    $("#modalEliminarCategoria form").on("submit", async function (event) {
      event.preventDefault();

      try {
        const response = await fetch(
          "../controllers/categorias_controller/categorias_acciones.php",
          {
            method: "POST",
            headers: {
              "Content-Type": "application/x-www-form-urlencoded",
            },
            body: `id_categoria=${id_categoria}&accion=eliminar`,
          }
        );

        const data = await response.json();

        if (data.success) {
          Swal.fire({
            icon: "success",
            title: "Éxito",
            timer: 1000, // Se cerrará automáticamente después de 2 segundos
            showConfirmButton: false,
            text: "Categoría eliminada correctamente",
          }).then(() => {
            $("#modalEliminarCategoria").modal("hide");
            tablaInstance.ajax.reload();
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "Error",
            timer: 1000, // Se cerrará automáticamente después de 2 segundos
            showConfirmButton: false,
            text: "No se pudo eliminar la categoría",
          });
        }
      } catch (error) {
        console.error("Error:", error);
        Swal.fire({
          icon: "error",
          title: "Error",
          timer: 1000, // Se cerrará automáticamente después de 2 segundos
          showConfirmButton: false,
          text: "Ocurrió un error al intentar eliminar la categoría",
        });
      }
    });
  });
});
