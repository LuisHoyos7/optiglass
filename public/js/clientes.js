import UbicacionServicio from "./service/ubicacionServicio.js";
import ClienteAfiliacionServicio from "./service/clienteAfiliacionServicio.js";
import UbicacionUtilidad from "./util/ubicacionUtilidad.js";

$(document).ready(function () {
    $(".dropdown-trigger").dropdown({ constrainWidth: false });
});

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

const contenidoNotificacionVacio = `
<li>
<p style="margin: 0">No hay alertas!!</p>
</li>`;

const contenidoNotificacion = (data) => `
<li>
<p style="margin: 0">Consecutivo:</p>
<p id="consecutivoNotificacion" class="grey-text truncate" style="margin: 0; position: relative; top: -25px;">
${data.consecutivo}
</p>
</li>
<li>
<p style="margin: 0">Numero documento:</p>
<p id="numeroDocumentoNotificacion" class="grey-text truncate" style="margin: 0; position: relative; top: -25px;">
${data.numeroDocumento}
</p>
</li>
<li>
<p style="margin: 0">Nombres:</p>
<p id="nombreNotificacion" class="grey-text truncate" style="margin: 0; position: relative; top: -25px;">
${data.nombres + " " + data.apellidos}
</p>
</li>
<li>
<p style="margin: 0">Teléfonos:</p>
<p id="nombreNotificacion" class="grey-text truncate" style="margin: 0; position: relative; top: -25px;">
${data.celular + (data.telefono ? " - " + data.telefono : "")}
</p>
</li>
<li>
<p style="margin: 0">Ubicación:</p>
<p id="ubicacionNotificacion" class="grey-text truncate" style="margin: 0; position: relative; top: -25px;">
${data.parroquia + ", " + data.canton + ", " + data.provincia}
</p>
</li>
<li>
<p style="margin: 0">Dirección:</p>
<p id="direccionNotificacion" class="grey-text truncate" style="margin: 0; position: relative; top: -25px;">
${data.direccion}
</p>
</li>
<li>
<p style="margin: 0">Brigada:</p>
<p id="brigadaNotificacion" class="grey-text truncate" style="margin: 0; position: relative; top: -25px;">
${data.idBrigada + " - " + data.descripcionBrigada}
</p>
</li>`;

let data;
let existeTelefono = false;
function findById($id) {
    ClienteAfiliacionServicio.findById($id)
        .then((respuesta) => {
            data = respuesta;
            $("#txtNombres").val(data.nombres);
            $("#txtApellidos").val(data.apellidos);
            $("#txtSexo").val("");
            $("#txtCelular").val(data.celular);
            $("#txtTelefono").val(data.telefono);
            $("#cmbProvincia").val(data.provincia);
            seleccionarCanton(data.provincia, data.canton);
            seleccionarParroquia(data.canton, data.parroquia);
            $("#txtDireccion").val(data.direccion);
            const filter = `celular=${data.celular}&telefono=${data.telefono}`;
            return ClienteAfiliacionServicio.findByPhonenumber(filter);
        })
        .then((respuesta) => {
            if (
                respuesta.id !== data.id &&
                respuesta.id !== data.idIntegrantePrincipal
            ) {
                existeTelefono = true;
            } else {
                existeTelefono = false;
            }
            setearNotificacion(respuesta);
            activarAlerta();
        })
        .catch((error) => {});
}

function setearNotificacion(data) {
    if (existeTelefono) {
        $("#notificationContent").html(contenidoNotificacion(data));
    } else {
        $("#notificationContent").html(contenidoNotificacionVacio);
    }
}

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

/* Submit loader mask */
$("#formCliente").on("submit", function (e) {
    var form = $("#formCliente");
    form.validate();
    e.preventDefault();

    if (form.valid()) {
        let payload = $("#formCliente").serialize();
        $("#preloader").fadeIn();
        ClienteAfiliacionServicio.update(payload, data.id)
            .then((respuesta) => {
                if (respuesta.estado == "OK") {
                    alerta(
                        "Success",
                        "Información del sistema",
                        "Registro almacenado exitosamente"
                    );
                } else {
                    alerta(
                        "Error",
                        "Iconvenientes almacenando registro:",
                        respuesta.msgError
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

$("#formCliente").validate({
    rules: {
        nombres: "required",
        apellidos: "required",
        sexo: "required",
        celular: "required",
        provincia: "required",
        canton: "required",
        parroquia: "required",
        direccion: "required",
    },
    //For custom messages
    messages: {
        nombres: "Campo requerido",
        apellidos: "Campo requerido",
        sexo: "Campo requerido",
        celular: "Campo requerido",
        provincia: "Campo requerido",
        canton: "Campo requerido",
        parroquia: "Campo requerido",
        direccion: "Campo requerido",
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

const activarAlerta = () => {
    let element = document.getElementById("alert-icon");
    if (existeTelefono) {
        element.innerHTML = "notifications_active";
        element.style.color = "red";
    } else {
        element.innerHTML = "notifications_none";
        element.style.color = "";
    }
};

export default { findById };
