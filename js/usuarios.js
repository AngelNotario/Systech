document.addEventListener("DOMContentLoaded", () => {
  const table = new DataTable("#tabla", {
    processing: true,
    serverSide: true,
    ajax: "../controllers/usuarios_controller/fetch_usuarios.php",
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
        orderable: false,
        className: "text-center",
      },
      {
        data: "4",
        orderable: false,
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

  $("#modalEditarUsuario").on("show.bs.modal", function (event) {
    var button = $(event.relatedTarget); // Botón que abrió el modal
    var id_usuario = button.data("id"); // Extraer el ID de los datos del botón

    const selectRol = document.querySelector("#modalEditarUsuario #editar_rol");

     // Fetch and populate roles

    fetch("../controllers/usuarios_controller/get_roles.php")
    .then((response) => response.json())
    .then((data) => {
      selectRol.innerHTML = ""; // Limpiar opciones existentes
      data.forEach((rol) => {
        selectRol.innerHTML += `<option value="${rol.rol_id}">${rol.nombre_rol}</option>`;
      });
      return $.ajax({
      url: "../controllers/usuarios_controller/get_usuario.php",
      type: "GET",
      data: { id_usuario: id_usuario },
      dataType: "json",
      success: function (data) {
        if (data.error) {
          console.error(data.error);
          return;
        }
        // Rellenar los campos del formulario con los datos obtenidos
        $('#modalEditarUsuario input[name="id_usuario"]').val(data.usuario_id);
        $('#modalEditarUsuario input[name="nombre_usuario"]').val(
          data.nombre_usuario
        );
        $('#modalEditarUsuario input[name="correo"]').val(data.correo);
        $('#modalEditarUsuario input[name="nombre_completo"]').val(
          data.nombre_completo
        );
        $('#modalEditarUsuario input[name="contraseña"]').val("");
        $('#modalEditarUsuario select[name="rol"]').val(data.rol_id);
        console.log("Rolll "+data.rol_id);
        $('#modalEditarUsuario select[name="estado"]').val(data.estado);
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error: " + status + error);
      },
    });
    }
    ).catch((error) => {
      console.error("Error al cargar los roles:", error);
    });
    
  });


  $("#modalRegistrarUsuario").on("show.bs.modal", function () {
    fetch("../controllers/usuarios_controller/get_roles.php")
      .then((response) => response.json())
      .then((data) => {
        const selectRol = document.querySelector("#rol");
        if (selectRol) {
          selectRol.innerHTML = ""; // Limpiar opciones existentes
          data.forEach((rol) => {
            const option = document.createElement("option");
            option.value = rol.rol_id;
            option.textContent = rol.nombre_rol;
            selectRol.appendChild(option);
          });
        } else {
          console.error("Elemento #registrar_rol no encontrado.");
        }
      })
      .catch((error) => {
        console.error("Error al cargar los roles:", error);
      });
  });


  $("#modalEditarUsuario form").on("submit", async function (event) {
    event.preventDefault();
    var id_usuario = $('#modalEditarUsuario input[name="id_usuario"]').val();
    var nombre_usuario = $(
      '#modalEditarUsuario input[name="nombre_usuario"]'
    ).val();
    var correo = $('#modalEditarUsuario input[name="correo"]').val();
    var nombre_completo = $(
      '#modalEditarUsuario input[name="nombre_completo"]'
    ).val();
    var contraseña = $('#modalEditarUsuario input[name="contraseña"]').val();
    var rol = $('#modalEditarUsuario select[name="rol"]').val();
    var estado = $('#modalEditarUsuario select[name="estado"]').val();
    var accion = "editar";

    console.log(
      id_usuario,
      nombre_usuario,
      correo,
      nombre_completo,
      contraseña,
      rol,
      estado,
      accion
    );

    try {
      const response = await fetch(
        "../controllers/usuarios_controller/usuarios_acciones.php",
        {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: `id_usuario=${id_usuario}&nombre_usuario=${nombre_usuario}&correo=${correo}&nombre_completo=${nombre_completo}&contraseña=${contraseña}&rol=${rol}&estado=${estado}&accion=${accion}`,
        }
      );
      const data = await response.json();
      if (data.success) {
        Swal.fire({
          icon: "success",
          title: "Éxito",
          timer: 3000, // Se cerrará automáticamente después de 3 segundos
          showConfirmButton: false, // Opcional: Oculta el botón de confirmación
          text: "Usuario actualizado correctamente",
        }).then(() => {
          $("#modalEditarUsuario").modal("hide"); // Ocultar el modal
          // Recargar la tabla después de cerrar el modal
          table.ajax.reload();
        });
      } else {
        Swal.fire({
          icon: "error",
          title: "Error",
          timer: 1000, // Se cerrará automáticamente después de 3 segundos
          showConfirmButton: false, // Opcional: Oculta el botón de confirmación
          text: "No se pudo actualizar el usuario",
        });
      }
    } catch (error) {
      console.error("Error:", error);
      Swal.fire({
        icon: "error",
        title: "Error",
        timer: 1000, // Se cerrará automáticamente después de 3 segundos
        showConfirmButton: false, // Opcional: Oculta el botón de confirmación
        text: "Ocurrió un error al intentar actualizar el usuario",
      });
    }
  });

  $("#modalEliminarUsuario").on("show.bs.modal", function (event) {
    var button = $(event.relatedTarget); // Botón que abrió el modal
    var id_usuario = button.data("id"); // Extraer el ID de los datos del botón

    $("#modalEliminarUsuario form").on("submit", async function (event) {
      event.preventDefault();

      try {
        const response = await fetch(
          "../controllers/usuarios_controller/usuarios_acciones.php",
          {
            method: "POST",
            headers: {
              "Content-Type": "application/x-www-form-urlencoded",
            },
            body: `usuario_id=${id_usuario}&accion=eliminar`,
          }
        );
        const data = await response.json();
        if (data.success) {
          Swal.fire({
            icon: "success",
            title: "Éxito",
            timer: 1000, // Se cerrará automáticamente después de 3 segundos
            showConfirmButton: false, // Opcional: Oculta el botón de confirmación
            text: "Usuario eliminado correctamente",
          }).then(() => {
            window.location.reload();
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "Error",
            timer: 1000, // Se cerrará automáticamente después de 3 segundos
            showConfirmButton: false, // Opcional: Oculta el botón de confirmación
            text: "No se pudo eliminar el usuario",
          });
        }
      } catch (error) {
        console.error("Error:", error);
        Swal.fire({
          icon: "error",
          title: "Error",
          timer: 1000, // Se cerrará automáticamente después de 3 segundos
          showConfirmButton: false, // Opcional: Oculta el botón de confirmación
          text: "Ocurrió un error al intentar eliminar el usuario",
        });
      }
    });
  });

  const togglePasswordButtons = document.querySelectorAll(
    '[id^="togglePassword"]'
  );
  togglePasswordButtons.forEach((toggleButton) => {
    toggleButton.addEventListener("click", function () {
      const passwordField = toggleButton
        .closest(".input-group")
        .querySelector('input[type="password"], input[type="text"]');
      const icon = toggleButton.querySelector("i");

      // Toggle the type attribute
      const type =
        passwordField.getAttribute("type") === "password" ? "text" : "password";
      passwordField.setAttribute("type", type);

      // Toggle the icon
      icon.classList.toggle("bi-eye");
      icon.classList.toggle("bi-eye-slash");
    });
  });

  document.querySelector("form").addEventListener("submit", async (event) => {
    event.preventDefault();
    const usuario = document.querySelector("#nombre_usuario").value;
    const contraseña = document.querySelector("#contraseña").value;
    const rol = document.querySelector("#rol").value;
    const correo = document.querySelector("#correo").value;
    const nombre_completo = document.querySelector("#nombre_completo").value;

    const response = await fetch(
      "../controllers/usuarios_controller/usuarios_acciones.php",
      {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `nombre_usuario=${usuario}&contraseña=${contraseña}&accion=registrar&rol=${rol}&correo=${correo}&nombre_completo=${nombre_completo}`,
      }
    );
    const data = await response.json();
    if (data.success) {
      Swal.fire({
        icon: "success",
        title: "Éxito",
        timer: 1000, // Se cerrará automáticamente después de 3 segundos
        showConfirmButton: false, // Opcional: Oculta el botón de confirmación
        text: "Usuario registrado correctamente",
      }).then(() => {
        window.location.reload();
      });
    } else {
      Swal.fire({
        icon: "error",
        title: "Error",
        timer: 1000, // Se cerrará automáticamente después de 3 segundos
        showConfirmButton: false, // Opcional: Oculta el botón de confirmación
        text: "Usuario o contraseña incorrectos",
      });
    }
  });
});
