document.addEventListener("DOMContentLoaded", function () {
    new DataTable("#tablaMembresias", {
        processing: true,
        serverSide: true,
        ajax: "../controllers/membresias_controller/fetch_membresias.php",
        columns: [
            { data: "0", className: "text-center" },
            { data: "1", className: "text-center" },
            { data: "2", className: "text-center" },
            { data: "3", className: "text-center" },
            { data: "4", className: "text-center" },
            { data: "5", className: "text-center" },
            { data: "6", className: "text-center" },
        ],
        columnDefs: [{ targets: "no-export", visible: true }],
        paging: true,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50, 100],
        language: {
            paginate: {
                next: "Siguiente",
                previous: "Anterior",
            },
            lengthMenu: "Mostrar _MENU_ registros por página",
            info: "Mostrando página _PAGE_ de _PAGES_",
            infoEmpty: "No hay registros disponibles",
            search: "Buscar:",
        },
    });
});
