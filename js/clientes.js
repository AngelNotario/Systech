document.addEventListener("DOMContentLoaded", () => {
  const tablaInstance = new DataTable("#tabla", {
    processing: true,
    serverSide: true,
    ajax: "../controllers/clientes_controller/fetch_clientes.php",
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
    {
      data: "3",
      className: "text-center",
    },
    {
      data: "4",
      className: "text-center", orderable: false,
    },
    {
      data: "5",
      className: "text-center",
    },
    {
      data: "6",
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

  $("#formRegistrarCliente").submit(function (e) {
    e.preventDefault(); // Evitar el envío normal del formulario
    const formData = new FormData(this); // Crear un objeto FormData con los datos del formulario
    $.ajax({
    url: "../controllers/clientes_controller/clientes_acciones.php",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (response) {
      const result = JSON.parse(response);
      if (result.success) {
      $("#modalRegistrarCliente").modal("hide"); // Ocultar el modal
      tablaInstance.ajax.reload(); // Recargar la tabla
      Swal.fire({
        icon: "success",
        title: "Éxito",
        text: result.message,
        timer: 1000,
        showConfirmButton: false,
      });
      } else {
      Swal.fire({
        icon: "error",
        title: "Error",
        text: result.message,
        timer: 1000,
        showConfirmButton: false,
      });
      }
    },
    });
  });

  $("#modalEditarCliente").on("show.bs.modal", function (event) {
    const button = $(event.relatedTarget); // Botón que abrió el modal
    const id_cliente = button.data("id"); // Extraer el ID de los datos del botón

    // Obtener los datos del cliente
    $.ajax({
    url: "../controllers/clientes_controller/get_cliente.php",
    type: "GET",
    data: { id_cliente: id_cliente },
    dataType: "json",
    success: function (data) {
      if (data.error) {
      console.error(data.error);
      return;
      }
      // Rellenar los campos del formulario con los datos obtenidos
      $("#editar_id_cliente").val(data.cliente_id);
      $("#editar_nombre").val(data.nombre);
      $("#editar_apellidos").val(data.apellidos);
      $("#editar_email").val(data.email);
      $("#editar_telefono").val(data.telefono);
      $("#editar_estado").val(data.estado);
    },
    });
  });

  $("#formEditarCliente").submit(function (e) {
    e.preventDefault(); // Evitar el envío normal del formulario
    const formData = new FormData(this); // Crear un objeto FormData con los datos del formulario
    $.ajax({
    url: "../controllers/clientes_controller/clientes_acciones.php",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (response) {
      const result = JSON.parse(response);
      if (result.success) {
      $("#modalEditarCliente").modal("hide"); // Ocultar el modal
      tablaInstance.ajax.reload(); // Recargar la tabla
      Swal.fire({
        icon: "success",
        title: "Éxito",
        text: result.message,
        timer: 1000,
        showConfirmButton: false,
      });
      } else {
      Swal.fire({
        icon: "error",
        title: "Error",
        text: result.message,
        timer: 1000,
        showConfirmButton: false,
      });
      }
    },
    });
  });

  $("#modalEliminarCliente").on("show.bs.modal", function (event) {
    const button = $(event.relatedTarget); // Botón que abrió el modal
    const id_cliente = button.data("id"); // Extraer el ID de los datos del botón
    $("#id_cliente_eliminar").val(id_cliente); // Rellenar el campo oculto con el ID del cliente
  });

  $("#formEliminarCliente").submit(function (e) {
    e.preventDefault(); // Evitar el envío normal del formulario
    const formData = new FormData(this); // Crear un objeto FormData con los datos del formulario
    $.ajax({
    url: "../controllers/clientes_controller/clientes_acciones.php",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (response) {
      const result = JSON.parse(response);
      if (result.success) {
      $("#modalEliminarCliente").modal("hide"); // Ocultar el modal
      tablaInstance.ajax.reload(); // Recargar la tabla
      Swal.fire({
        icon: "success",
        title: "Éxito",
        text: result.message,
        timer: 1000,
        showConfirmButton: false,
      });
      } else {
      Swal.fire({
        icon: "error",
        title: "Error",
        text: result.message,
        timer: 1000,
        showConfirmButton: false,
      });
      }
    },
    });
  });
  
});