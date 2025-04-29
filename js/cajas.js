$(document).ready(function() {
    $('#formRegistroCaja').on('submit', function(e) {
        e.preventDefault();

        Swal.fire({
            title: '¿Registrar caja?',
            text: 'Confirma el monto inicial de efectivo: $' + $('#inicio_efectivo').val(),
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Confirmar'
        }).then((result) => {
            if (result.isConfirmed) {
                console.log($(this).serialize());
                $.ajax({
                    url: "../controllers/cajas_controller/cajas_acciones.php",
                    method: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json'
                }).done(function(res) {

                    if (res.success) {
                        Swal.fire('Éxito', res.mensaje, 'success').then(() => {
                            window.location.href = "../vistas/principal.php";
                        });
                    } else {

                        Swal.fire('Error', res.mensaje, 'error');
                    }
                }).fail(function(res) {

                    Swal.fire('Error', 'Error en el servidor: ' + res.responseText, 'error');
                });
            }
        });
    });
});