import ParametroServicio from "./service/parametroServicio.js";
import Initialization from "./initialization.js";

let cuota;
ParametroServicio.findById(1)
    .then((data) => {
        cuota = Number(data.valor);
    })
    .catch((error) => {});

let saldo = $("#formIntegrante :input[name='saldo']");
let abono = $("#formIntegrante :input[name='abono']");
$(abono).change(function () {
    if (Number($(this).val()) > cuota) {
        $(this).val("");
        saldo.val("");
    } else {
        saldo.val(cuota - $(this).val());
    }
});

const dropdown = (id) => `<ul id='${id}' class='dropdown-content'>
<li><a href="#!"><i class="material-icons">delete</i>Eliminar</a></li>
<li><a href="#!"><i class="material-icons">edit</i>Editar</a></li>
</ul>`;

let isEdit = false;
let idCount = 0;
let integrante = {};
let integrantes = [];
const addRow = (data) => {
    const tbl = document
        .getElementById("tblIntegrante")
        .getElementsByTagName("tbody")[0];
    const newRow = tbl.insertRow(-1);
    newRow.setAttribute("data-row-id", data.id);
    let newCell = newRow.insertCell(0);
    newCell.appendChild(document.createTextNode(data.consecutivo));
    newCell = newRow.insertCell(1);
    newCell.appendChild(
        document.createTextNode(data.nombres + " " + data.apellidos)
    );
    newCell = newRow.insertCell(2);
    let icon = document.createElement("i");
    icon.setAttribute("class", "dropdown-trigger material-icons");
    icon.setAttribute("data-target", `dropdown${idCount}`);
    icon.append("more_vert");
    newCell.append(icon);
    newCell.innerHTML += dropdown(`dropdown${idCount}`);
    let btnEliminar = document.getElementById(`dropdown${idCount}`)
        .firstElementChild.firstElementChild;
    btnEliminar.addEventListener("click", function () {
        eliminarIntegrante(data.id, this);
    });
    let btnEditar = document.getElementById(`dropdown${idCount}`)
        .lastElementChild.firstElementChild;
    btnEditar.addEventListener("click", function () {
        isEdit = true;
        editarIntegrante(data);
    });
    idCount++;
    Initialization.dropdownTrigger();
};

const existeId = (id) => {
    const solicitud = integrantes.filter((e) => e.id === id).length;
    return solicitud > 0;
};

const existeConsecutivo = (consecutivo) => {
    const solicitud = integrantes.filter((e) => e.consecutivo === consecutivo)
        .length;
    return solicitud > 0;
};

function eliminarIntegrante(id) {
    const row = $("#tblIntegrante").find('tr[data-row-id="' + id + '"]');
    row.remove();
    const newList = integrantes.filter((e) => e.id !== id);
    integrantes = newList;
}

const editarIntegrante = (data) => {
    integrante = { ...data };
    $("#formIntegrante :input[name='consecutivo']").val(integrante.consecutivo);
    $("#formIntegrante :input[name='numeroDocumento']").val(
        integrante.numeroDocumento
    );
    $("#formIntegrante :input[name='nombres']").val(integrante.nombres);
    $("#formIntegrante :input[name='apellidos']").val(integrante.apellidos);
    $("#formIntegrante :input[name='abono']").val(integrante.abono);
    $("#formIntegrante :input[name='saldo']").val(integrante.saldo);
};

const inicializarIntegrante = () => {
    integrante = {
        id: null,
        consecutivo: "",
        numeroDocumento: "",
        nombres: "",
        apellidos: "",
        abono: null,
        saldo: null,
    };
    editarIntegrante(integrante);
};

$("#formIntegrante").validate({
    rules: {
        consecutivo: "required",
        nombres: "required",
        apellidos: "required",
        abono: "required",
        saldo: "required",
    },
    //For custom messages
    messages: {
        consecutivo: "Campo requerido",
        nombres: "Campo requerido",
        apellidos: "Campo requerido",
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

$("#formIntegrante").on("submit", function (e) {
    let form = $("#formIntegrante");
    form.validate();
    e.preventDefault();

    if (form.valid()) {
        integrante = {
            ...integrante,
            consecutivo: $("#formIntegrante :input[name='consecutivo']").val(),
            numeroDocumento: $(
                "#formIntegrante :input[name='numeroDocumento']"
            ).val(),
            nombres: $("#formIntegrante :input[name='nombres']").val(),
            apellidos: $("#formIntegrante :input[name='apellidos']").val(),
            abono: $("#formIntegrante :input[name='abono']").val(),
            saldo: $("#formIntegrante :input[name='saldo']").val(),
        };
        if (!isEdit) {
            integrante = { ...integrante, id: integrante.consecutivo };
        }

        const existe = existeId(integrante.id);
        if (!isEdit && !existe) {
            integrantes.push(integrante);
            addRow(integrante);
        } else if (isEdit && existe) {
            eliminarIntegrante(integrante.id);
            integrante = { ...integrante, id: integrante.consecutivo };
            integrantes.push(integrante);
            addRow(integrante);
            isEdit = false;
        } else if (
            isEdit &&
            !existe & !existeConsecutivo(integrante.consecutivo)
        ) {
            integrante = { ...integrante, id: integrante.consecutivo };
            integrantes.push(integrante);
            addRow(integrante);
        } else {
            M.toast({ html: "El consecutivo ya existe" });
            return;
        }
        $("#formIntegrante").validate().resetForm();
        inicializarIntegrante();
    }
});

const limpiarFormulario = () => {
    integrantes.forEach((e) => {
        eliminarIntegrante(e.id);
    });
};

const getIntegrantes = () => integrantes;

export default { getIntegrantes, limpiarFormulario };
