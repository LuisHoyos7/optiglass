import BrigadaServicio from "./service/brigadaServicio.js";
import UsuarioServicio from "./service/usuarioServicio.js";
import UbicacionServicio from "./service/ubicacionServicio.js";
import afiliacionServicio from "./service/afiliacionServicio.js";
import UbicacionUtilidad from "./util/ubicacionUtilidad.js";
import ParametroServicio from "./service/parametroServicio.js";
import Integrantes from "./integrantes.js";

let brigadas = [];
BrigadaServicio.filter("P")
    .then((data) => {
        brigadas = data;
        mostrarBrigadas();
    })
    .catch((error) => {});

let promotores = [];
UsuarioServicio.filter("PT")
    .then((data) => {
        promotores = data;
        mostrarPromotores();
    })
    .catch((error) => {});

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

let cuota;
ParametroServicio.findById(1)
    .then((data) => {
        cuota = Number(data.valor);
    })
    .catch((error) => {});

function mostrarBrigadas() {
    let select = "<option value=''>Seleccione</option>";
    brigadas.map((brigada) => {
        select += `<option value='${brigada.id}'>${brigada.descripcion}</option>`;
    });
    $("#cmbBrigada").html(select);
}

function mostrarPromotores() {
    let select = "<option value=''>Seleccione</option>";
    promotores.map((promotor) => {
        select += `<option value='${promotor.codigo}'>${promotor.nombre}</option>`;
    });
    $("#cmbPromotor").html(select);
}

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

$("#cmbBrigada").on("change", function () {
    if ($("#cmbProvincia").val() == null) {
        consultarUbicacionBrigada();
    }
});

function consultarUbicacionBrigada() {
    BrigadaServicio.findById($("#cmbBrigada").val())
        .then((data) => {
            $("#cmbProvincia").val(data.provincia);
            seleccionarCanton(data.provincia, data.canton);
            seleccionarParroquia(data.canton, data.parroquia);
        })
        .catch((error) => {});
}

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

$("#txtAbono").change(function () {
    if (Number($(this).val()) > cuota) {
        $(this).val("");
        $("#txtSaldo").val("");
    } else {
        $("#txtSaldo").val(cuota - $(this).val());
    }
});

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

/* Submit loader mask */
$("#formAfiliacion").on("submit", function (e) {
    let form = $("#formAfiliacion");
    form.validate();
    e.preventDefault();

    if (form.valid()) {
        let data = $("#formAfiliacion").serializeArray();
        data.push({
            name: "integrantes",
            value: JSON.stringify(Integrantes.getIntegrantes()),
        });
        $("#preloader").fadeIn();
        afiliacionServicio
            .create(data)
            .then((data) => {
                if (data.estado == "OK") {
                    let msg = "Registro almacenado exitosamente";
                    if (
                        Integrantes.getIntegrantes().length > 0 &&
                        data.msgError.length > 0
                    ) {
                        msg = `${msg}<br>  
                        Se obtuvieron los siguientes errores de los integrantes:<br>
                        ${data.msgError}`;
                    }
                    alerta("Success", "Información del sistema", msg);
                    $("#formAfiliacion")[0].reset();
                    $("#cmbCanton").html(
                        "<option value='' disabled selected>Seleccione</option>"
                    );
                    $("#cmbParroquia").html(
                        "<option value='' disabled selected>Seleccione</option>"
                    );
                    $("label").attr("class", "active");
                    Integrantes.limpiarFormulario();
                } else {
                    alerta(
                        "Error",
                        "Iconvenientes almacenando registro:",
                        data.msgError
                    );
                }

                $("#preloader").fadeOut();
            })
            .catch((error) => {
                alerta(
                    "Error",
                    "Iconvenientes almacenando registro:",
                    error.responseText
                );
                $("#preloader").fadeOut();
            });
    }
});

//Validaciones
$("#formAfiliacion").validate({
    rules: {
        consecutivo: "required",
        nombres: "required",
        apellidos: "required",
        celular: "required",
        provincia: "required",
        canton: "required",
        parroquia: "required",
        direccion: "required",
        promotor: "required",
        brigada: "required",
        abono: "required",
        saldo: "required",
    },
    //For custom messages
    messages: {
        consecutivo: "Campo requerido",
        nombres: "Campo requerido",
        apellidos: "Campo requerido",
        celular: "Campo requerido",
        provincia: "Campo requerido",
        canton: "Campo requerido",
        parroquia: "Campo requerido",
        direccion: "Campo requerido",
        promotor: "Campo requerido",
        brigada: "Campo requerido",
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

/*
    $('#btnNuevo').on('click',function(){
        $('.dataTables_scrollHeadInner').attr('style','width:100% !important')
        $('.dataTables_scrollHeadInner .display').attr('style','width:100% !important')
        tabla.ajax.reload();
    });
    */
