import BrigadaServicio from "./service/brigadaServicio.js";

let brigadas = [];
BrigadaServicio.filter("A")
    .then((data) => {
        brigadas = data;
        mostrarBrigadas();
    })
    .catch((error) => {});

function mostrarBrigadas() {
    let select = "<option value=''>Seleccione</option>";
    brigadas.map((brigada) => {
        select += `<option value='${brigada.id}'>${brigada.descripcion}</option>`;
    });
    $("#cmbBrigada").html(select);
}

$.ajax({
    data: null,
    url: "lentes/consultarLentes",
    success: function (respuesta) {
        $("#cmbLente").append(respuesta);
    },
});

$("#txtConsecutivo").change(function () {
    var consecutivo = $("#txtConsecutivo").val();
    $("#txtVenta").val("");
    $("#formVenta")[0].reset();
    $("label").attr("class", "active");
    $("#txtConsecutivo").val(consecutivo);
});

cargarFormula();

var tabla;
function cargarFormula() {
    tabla = $("#data-table-simple").DataTable({
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
        dom: "rt",
        bAutoWidth: true,
        scrollX: true,
        ajax: {
            data: { venta: $("#txtVenta").val() },
            url: "ventas/consultarFormula",
            dataSrc: "",
        },
        columns: [
            { data: "distancia", orderable: false },
            { data: "ojo", orderable: false },
            { data: "esfera", orderable: false },
            { data: "cilindro", orderable: false },
            { data: "eje", orderable: false },
            { data: "av", orderable: false },
        ],
        order: [[0, "desc"]],
    });
}

cargarAdicion();

var tabla2;
function cargarAdicion() {
    tabla2 = $("#data-table-simple-2").DataTable({
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
        dom: "rt",
        bAutoWidth: true,
        scrollX: true,
        ajax: {
            data: { venta: $("#txtVenta").val() },
            url: "ventas/consultarAdicion",
            dataSrc: "",
        },
        columns: [
            { data: "ojoDerecho", orderable: false },
            { data: "adicionDerecho", orderable: false },
            { data: "ojoIzquierdo", orderable: false },
            { data: "adicionIzquierdo", orderable: false },
        ],
    });
}

cargarVentas();

var tabla3;
function cargarVentas() {
    tabla3 = $("#data-table-simple-3").DataTable({
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
                brigada: $("#cmbBrigada").val(),
                fecha: $("#txtFecha").val(),
            },
            url: "ventas/consultarVentas",
            dataSrc: "",
        },
        columns: [
            {
                defaultContent:
                    "<a class='btn-floating btn-small waves-effect waves-light gradient-45deg-indigo-purple gradient-shadow'><i class='material-icons'>edit</i></a>",
                orderable: false,
            },
            { data: "consecutivo" },
            { data: "fecha" },
            { data: "brigadaDescripcion" },
            { data: "nombreCompleto" },
            { data: "abono" },
            { data: "saldo" },
            { data: "lenteDescripcion" },
        ],
    });
}

$.fn.dataTable.ext.errMode = "none";
//Fin dataTable

$("#btnBuscarVenta").click(function () {
    tabla3.destroy();
    cargarVentas();
});

$("#data-table-simple-3 tbody").on("click", "a", function () {
    var data = $("#data-table-simple-3")
        .DataTable()
        .row($(this).parents("tr"))
        .data();
    $("#txtVenta").val(data.venta);
    $("#txtConsecutivo").val(data.consecutivo);
    $("#txtNumeroDocumento").val(data.numeroDocumento);
    $("#txtNombres").val(data.nombres);
    $("#txtApellidos").val(data.apellidos);
    $("#txtCelular").val(data.celular);
    $("#txtTelefono").val(data.telefono);
    $("#txtBrigada").val(data.brigadaDescripcion);
    $("#txtAbono").val(data.abono);
    $("#txtSaldo").val(data.saldo);
    $("#cmbLente").val(data.lente);
    $(".tabs").tabs("select", "venta");
});

$("#btnVenta").click(function () {
    $("#preloader").fadeIn();
    tabla.destroy();
    tabla2.destroy();
    cargarFormula();
    cargarAdicion();
    $("#preloader").fadeOut();
});

$("#btnHistorial").click(function () {
    $("#preloader").fadeIn();
    tabla3.destroy();
    cargarVentas();
    $("#preloader").fadeOut();
});

$("#btnBuscar").click(function () {
    $.ajax({
        data: { consecutivo: $("#txtConsecutivo").val() },
        url: "ventas/consultarCliente",
        type: "get",
        dataType: "JSON",
        beforeSend: function () {
            $("#preloader").fadeIn();
        },
        success: function (respuesta) {
            if (respuesta.estado == "OK") {
                $("#txtNumeroDocumento").val(
                    respuesta.respuesta.numeroDocumento
                );
                $("#txtNombres").val(respuesta.respuesta.nombres);
                $("#txtApellidos").val(respuesta.respuesta.apellidos);
                $("#txtCelular").val(respuesta.respuesta.celular);
                $("#txtTelefono").val(respuesta.respuesta.telefono);
                $("#txtBrigada").val(respuesta.respuesta.brigada);
                tabla.destroy();
                tabla2.destroy();
                cargarFormula();
                cargarAdicion();
            } else {
                $("#txtNumeroDocumento").val("");
                $("#txtNombres").val("");
                $("#txtApellidos").val("");
                $("#txtCelular").val("");
                $("#txtTelefono").val("");
                $("#txtBrigada").val("");
                tabla.destroy();
                tabla2.destroy();
                cargarFormula();
                cargarAdicion();
                alerta(
                    "Error",
                    "Iconvenientes consultando registro:",
                    respuesta.msgError
                );
            }

            $("#preloader").fadeOut();
        },
        error: function (jqXHR) {
            alerta(
                "Error",
                "Iconvenientes consultando registro:",
                jqXHR.responseText
            );
            $("#preloader").fadeOut();
        },
    });
});

$("#formVenta").on("submit", function (e) {
    var form = $("#formVenta");
    form.validate();
    e.preventDefault();

    var data = tabla.$("input").serialize();

    if (form.valid()) {
        $.ajax({
            data: $("#formVenta").serialize(),
            url: "ventas/guardar/" + data,
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
                        "Registro almacenado exitosamente"
                    );
                    $("#txtVenta").val("");
                    $("#formVenta")[0].reset();
                    $("label").attr("class", "active");
                } else {
                    alerta(
                        "Error",
                        "Iconvenientes almacenando registro:",
                        respuesta.msgError
                    );
                }

                $("#preloader").fadeOut();
            },
            error: function (jqXHR) {
                alerta(
                    "Error",
                    "Iconvenientes almacenando registro:",
                    jqXHR.responseText
                );
                $("#preloader").fadeOut();
            },
        });
    }
});

//Validaciones
$("#formVenta").validate({
    rules: {
        consecutivo: "required",
        numeroDocumento: "required",
        lente: "required",
        abono: "required",
        saldo: "required",
    },
    //For custom messages
    messages: {
        consecutivo: "Campo requerido",
        numeroDocumento: "Campo requerido",
        lente: "Campo requerido",
        abono: "Campo requerido",
        saldo: "Campo requerido",
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

$("#formHistorial").on("submit", function (e) {
    e.preventDefault();

    if (tabla3.rows({ selected: true }).count() == 0) {
        return false;
    }

    var datos = {};
    tabla3.rows().every(function (index) {
        datos[index] = this.data();
    });

    $.ajax({
        data: { _token: $("#txtToken").val(), ventas: JSON.stringify(datos) },
        url: "ventas/imprimir",
        type: "post",
        xhrFields: {
            responseType: "blob",
        },
        success: function (response) {
            var link = document.createElement("a");
            link.href = window.URL.createObjectURL(response);
            link.download = "ventas.pdf";
            link.click();
            console.log(response);
        },
        error: function (jqXHR) {
            alerta(
                "Error",
                "Iconvenientes almacenando registro:",
                jqXHR.responseText
            );
        },
    });
});
