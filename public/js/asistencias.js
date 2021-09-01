import BrigadaServicio from "./service/brigadaServicio.js";
import UbicacionServicio from "./service/ubicacionServicio.js";
import UbicacionUtilidad from "./util/ubicacionUtilidad.js";

let provincias = [];
UbicacionServicio.provincias()
    .then((data) => {
        provincias = data;
        mostrarProvincias();
    })
    .catch((error) => {});

let cantones = [];
UbicacionServicio.cantones()
    .then((data) => {
        cantones = data;
    })
    .catch((error) => {});

let parroquias = [];
UbicacionServicio.parroquias()
    .then((data) => {
        parroquias = data;
    })
    .catch((error) => {});

function mostrarProvincias() {
    let select = "<option value='' disabled selected>Seleccione</option>";
    provincias.map((provincia) => {
        select += `<option value='${provincia.codigo}'>${provincia.nombre}</option>`;
    });
    $("#cmbProvincia").html(select);
}

$("#cmbProvincia").on("change", function () {
    let select = "<option value='' disabled selected>Seleccione</option>";
    UbicacionUtilidad.filtroCanton(cantones, $("#cmbProvincia").val()).map(
        (canton) => {
            select += `<option value='${canton.codigo}'>${canton.nombre}</option>`;
        }
    );
    $("#cmbCanton").html(select);
    $("#cmbParroquia").html(
        "<option value='' disabled selected>Seleccione</option>"
    );
});

$("#cmbCanton").on("change", function () {
    let select = "<option value='' disabled selected>Seleccione</option>";
    UbicacionUtilidad.filtroParroquia(parroquias, $("#cmbCanton").val()).map(
        (parroquia) => {
            select += `<option value='${parroquia.codigo}'>${parroquia.nombre}</option>`;
        }
    );
    $("#cmbParroquia").html(select);
});

function seleccionarCanton(provincia, canton) {
    let select = "<option value='' disabled>Seleccione</option>";
    UbicacionUtilidad.filtroCanton(cantones, provincia).map((item) => {
        if (canton === item.codigo) {
            select += `<option selected value='${item.codigo}'>${item.nombre}</option>`;
        } else {
            select += `<option value='${item.codigo}'>${item.nombre}</option>`;
        }
    });
    $("#cmbCanton").html(select);
}

function seleccionarParroquia(canton, parroquia) {
    let select = "<option value='' disabled>Seleccione</option>";
    UbicacionUtilidad.filtroParroquia(parroquias, canton).map((item) => {
        if (parroquia === item.codigo) {
            select += `<option selected value='${item.codigo}'>${item.nombre}</option>`;
        } else {
            select += `<option value='${item.codigo}'>${item.nombre}</option>`;
        }
    });
    $("#cmbParroquia").html(select);
}

let brigadas = [];
BrigadaServicio.filter("A")
    .then((data) => {
        brigadas = data;
    })
    .catch((error) => {});

function mostrarBrigadas() {
    let select = "<option value=''>Seleccione</option>";
    brigadas.map((brigada) => {
        select += `<option value='${brigada.id}'>${brigada.descripcion}</option>`;
    });
    $("#cmbBrigada").html(select);
    $("#cmbBrigadaNuevo").html(select);
}

function seleccionarBrigada(brigada) {
    mostrarBrigadas();
    //Eliminamos otras opciones
    $("#cmbBrigada option").each(function () {
        if ($(this).val() != brigada) {
            $(this).remove();
        }
    });
}

function consultarUbicacionBrigada() {
    BrigadaServicio.findById($("#cmbBrigada").val())
        .then((data) => {
            $("#cmbProvincia").val(data.provincia);
            seleccionarCanton(data.provincia, data.canton);
            seleccionarParroquia(data.canton, data.parroquia);
        })
        .catch((error) => {});
}

var cuota;
$.ajax({
    data: null,
    url: "afiliaciones/obtenerValorCuota",
    success: function (respuesta) {
        cuota = Number(respuesta);
    },
});

prepararTabla();

var tabla;
function prepararTabla() {
    tabla = $("#data-table-simple").DataTable({
        scrollY: "30vh",
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
        responsive: true,
        dom: "frt",
        bAutoWidth: true,
    });
}

function cargarAfiliaciones() {
    tabla = $("#data-table-simple").DataTable({
        scrollY: "30vh",
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
        paging: false,
        responsive: false,
        dom: "frt",
        bAutoWidth: true,
        scrollX: true,
        ajax: {
            url: "asistencias/consultar",
            dataSrc: "",
        },
        columns: [
            {
                defaultContent:
                    "<a class='btn-floating btn-small waves-effect waves-light gradient-45deg-indigo-purple gradient-shadow modal-close'><i class='material-icons'>check</i></a>",
                orderable: false,
            },
            { width: "10%", data: "consecutivo" },
            { width: "60%", data: "nombreCompleto" },
            { width: "30%", data: "brigadaDescripcion" },
        ],
    });
}

$.fn.dataTable.ext.errMode = "none";

$("#btnNuevo").on("click", function () {
    $("#preloader").fadeIn();
    $("#preloader").fadeOut(1000);
    tabla.destroy();
    cargarAfiliaciones();
});

let afiliacion;
$("#data-table-simple tbody").on("click", "a", function () {
    var data = $("#data-table-simple")
        .DataTable()
        .row($(this).parents("tr"))
        .data();
    afiliacion = data.id;
    $("#txtConsecutivo").val(data.consecutivo);
    $("#txtNumeroDocumento").val(data.numeroDocumento);
    $("#txtNombres").val(data.nombres);
    $("#txtApellidos").val(data.apellidos);
    $("#txtSexo").val("");
    $("#txtCelular").val(data.celular);
    $("#txtTelefono").val(data.telefono);
    $("#cmbProvincia").val(data.provincia);
    seleccionarCanton(data.provincia, data.canton);
    seleccionarParroquia(data.canton, data.parroquia);
    $("#txtDireccion").val(data.direccion);
    seleccionarBrigada(data.brigada);
    $("#txtPromotor").val(data.promotor);
    $("#txtAbono").val(data.abono);
    $("#txtSaldo").val(data.saldo);
    $("#txtPendiente").val(data.pendiente);
});

$("#formAsistencia").on("submit", function (e) {
    var form = $("#formAsistencia");
    form.validate();
    e.preventDefault();

    if (form.valid()) {
        let data = $("#formAsistencia").serializeArray();
        data.push({
            name: "afiliacion",
            value: afiliacion,
        });
        $.ajax({
            data: data,
            url: "asistencias/guardar",
            type: "POST",
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
                    afiliacion = null;
                    $("#formAsistencia")[0].reset();
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
$("#formAsistencia").validate({
    rules: {
        consecutivo: "required",
        numeroDocumento: "required",
        nombres: "required",
        apellidos: "required",
        celular: "required",
        provincia: "required",
        canton: "required",
        parroquia: "required",
        direccion: "required",
        brigada: "required",
        pendiente: "required",
    },
    //For custom messages
    messages: {
        consecutivo: "Campo requerido",
        numeroDocumento: "Campo requerido",
        nombres: "Campo requerido",
        apellidos: "Campo requerido",
        celular: "Campo requerido",
        provincia: "Campo requerido",
        canton: "Campo requerido",
        parroquia: "Campo requerido",
        direccion: "Campo requerido",
        brigada: "Campo requerido",
        pendiente: "Campo requerido",
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

$("#btnNuevaAfiliacion").click(function () {
    mostrarBrigadas();
    $("#formNuevo")[0].reset();
    $("label").attr("class", "active");
});

$("#formNuevo").on("submit", function (e) {
    var form = $("#formNuevo");
    form.validate();
    e.preventDefault();

    if (form.valid()) {
        $.ajax({
            data: $("#formNuevo").serialize(),
            url: "asistencias/validar",
            type: "post",
            dataType: "JSON",
            beforeSend: function () {
                $("#preloader").fadeIn();
            },
            success: function (respuesta) {
                if (respuesta.estado == "OK") {
                    $("#txtConsecutivo").val($("#txtConsecutivoNuevo").val());
                    $("#txtNumeroDocumento").val("");
                    $("#txtNombres").val("");
                    $("#txtApellidos").val("");
                    $("#txtApellidos").val("");
                    $("#txtSexo").val("");
                    $("#txtCelular").val("");
                    $("#txtTelefono").val("");
                    $("#cmbProvincia").val("");
                    $("#cmbCanton").val("");
                    $("#cmbParroquia").val("");
                    $("#txtDireccion").val("");
                    seleccionarBrigada($("#cmbBrigadaNuevo").val());
                    $("#txtPromotor").val("BRIGADA");
                    consultarUbicacionBrigada();
                    $("#txtAbono").val("0");
                    $("#txtSaldo").val(cuota);
                    $("#txtPendiente").val("");
                    $("#dlgNuevo").modal("close");
                    $("#dlgAfiliaciones").modal("close");
                } else {
                    alerta(
                        "Error",
                        "Iconvenientes agregando registro:",
                        respuesta.msgError
                    );
                }

                $("#preloader").fadeOut();
            },
            error: function (jqXHR) {
                alerta(
                    "Error",
                    "Iconvenientes agregando registro:",
                    jqXHR.responseText
                );
                $("#preloader").fadeOut();
            },
        });
    }
});

//Validaciones
$("#formNuevo").validate({
    rules: {
        consecutivo: "required",
        brigada: "required",
    },
    //For custom messages
    messages: {
        consecutivo: "Campo requerido",
        brigada: "Campo requerido",
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
