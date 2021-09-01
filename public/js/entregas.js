import SubestadoServicio from "./service/subestadoServicio.js";

let subestados = [];
SubestadoServicio.filter("CL")
    .then((data) => {
        subestados = data;
        mostrarSubestados();
    })
    .catch((error) => {});

function mostrarSubestados() {
    let select = "<option value=''>Seleccione</option>";
    subestados.map((subestado) => {
        select += `<option value='${subestado.codigo}'>${subestado.descripcion}</option>`;
    });
    $("#cmbSubestado").html(select);

    $("#cmbSubestado option").each(function () {
        if ($(this).val() != "CE") {
            $(this).remove();
        }
    });
}

cargarVentas();

//Inicio dataTable
var tabla;
function cargarVentas() {
    tabla = $("#data-table-simple").DataTable({
        scrollY: "40vh",
        language: {
            sProcessing: "Procesando...",
            sLengthMenu: "Mostrar _MENU_ registros",
            sZeroRecords: "No se encontraron resultados",
            sEmptyTable: "Ningún dato disponible en esta tabla",
            sInfo:
                "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            sInfoEmpty:
                "Mostrando registros del 0 al 0 de un total de 0 registros",
            sInfoFiltered: "",
            sInfoPostFix: "",
            sSearch: "Buscar:",
            sSearchPlaceholder: "Dato a buscar",
            sUrl: "",
            sInfoThousands: ",",
            sLoadingRecords: "Cargando...",
            oPaginate: {
                sFirst: "Primero",
                sLast: "Último",
                sNext: "Siguiente",
                sPrevious: "Anterior",
            },
            oAria: {
                sSortAscending:
                    ": Activar para ordenar la columna de manera ascendente",
                sSortDescending:
                    ": Activar para ordenar la columna de manera descendente",
            },
        },
        responsive: false,
        dom: "rtp",
        bAutoWidth: true,
        scrollX: true,
        ajax: {
            data: {
                consecutivoBusqueda: $("#txtConsecutivoBusqueda").val(),
                fechaBusqqueda: $("#txtFechaBusqueda").val(),
            },
            url: "entregas/consultar",
            dataSrc: "",
        },
        columns: [
            {
                defaultContent:
                    "<a class='btn-floating btn-small waves-effect waves-light gradient-45deg-indigo-purple gradient-shadow sidenav-trigger' data-target='slide-out-right'><i class='material-icons'>edit</i></a>",
                orderable: false,
            },
            { width: "10%", data: "consecutivo" },
            { width: "10%", data: "fecha" },
            { width: "20%", data: "brigada" },
            { width: "30%", data: "nombre" },
            { width: "15%", data: "abono" },
            { width: "15%", data: "saldo" },
            { width: "10%", data: "lente" },
            { width: "10%", data: "subestadoDescripcion" },
        ],
    });
}

$("#data-table-simple tbody").on("click", "a", function () {
    var data = $("#data-table-simple")
        .DataTable()
        .row($(this).parents("tr"))
        .data();
    $("#txtConsecutivo").val(data.consecutivo);
    $("#txtFecha").val(data.fecha);
    $("#txtBrigada").val(data.brigada);
    $("#txtNombre").val(data.nombre);
    $("#txtAbono").val(data.abono);
    $("#txtSaldo").val(data.saldo);
    $("#txtPendiente").val(data.pendiente);
    $("#cmbSubestado").val(data.subestado);
});

$.fn.dataTable.ext.errMode = "none";
//Fin dataTable

$("#btnBuscar").click(function () {
    tabla.destroy();
    cargarVentas();
});

$("#formEntrega").on("submit", function (e) {
    var form = $("#formEntrega");
    form.validate();
    e.preventDefault();

    if (form.valid()) {
        $.ajax({
            data: $("#formEntrega").serialize(),
            url: "entregas/guardar",
            type: "post",
            dataType: "JSON",
            beforeSend: function () {
                $("#preloader").fadeIn();
            },
            success: function (respuesta) {
                if (respuesta.estado == "OK") {
                    alerta(
                        "Success",
                        "Información del sistema",
                        "Registro editado exitosamente"
                    );
                    tabla.ajax.reload();
                } else {
                    alerta(
                        "Error",
                        "Iconvenientes editando registro:",
                        respuesta.msgError
                    );
                }

                $("#preloader").fadeOut();
            },
            error: function (jqXHR) {
                alerta(
                    "Error",
                    "Iconvenientes editando registro:",
                    jqXHR.responseText
                );
                $("#preloader").fadeOut();
            },
        });
    }
});

$("#formEntrega").validate({
    rules: {
        consecutivo: "required",
        pendiente: "required",
        subestado: "required",
    },
    //For custom messages
    messages: {
        consecutivo: "Campo requerido",
        pendiente: "Campo requerido",
        subestado: "Campo requerido",
    },
    errorElement: "div",
    errorPlacement: function (error, element) {
        var placement = $(element).data("error");
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    },
});
