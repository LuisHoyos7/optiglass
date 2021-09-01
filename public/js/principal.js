jQuery(function ($) {
    $(".modal").modal();

    $(".datepicker").datepicker({
        format: "yyyy-mm-dd",
        i18n: {
            months: [
                "Enero",
                "Febrero",
                "Marzo",
                "Abril",
                "Mayo",
                "Junio",
                "Julio",
                "Agosto",
                "Septiembre",
                "Octubre",
                "Noviembre",
                "Diciembre",
            ],
            monthsShort: [
                "Ene",
                "Feb",
                "Mar",
                "Abr",
                "May",
                "Jun",
                "Jul",
                "Ago",
                "Set",
                "Oct",
                "Nov",
                "Dic",
            ],
            weekdays: [
                "Domingo",
                "Lunes",
                "Martes",
                "Miércoles",
                "Jueves",
                "Viernes",
                "Sábado",
            ],
            weekdaysShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
            weekdaysAbbrev: ["D", "L", "M", "M", "J", "V", "S"],
            cancel: "Cancelar",
            today: "Hoy",
            clear: "Limpiar",
            close: "Ok",
        },
    });

    $(".timepicker").timepicker();
});

window.onload = function () {
    $("#preloader").fadeOut("slow");
};

function alerta(tipo, titulo, msg) {
    let span = document.createElement("span");
    span.innerHTML = msg;
    if (tipo == "Error") {
        swal({
            title: "Error",
            text: msg,
            icon: "error",
        });
    } else if (tipo == "Success") {
        swal({
            title: "Genial",
            content: span,
            icon: "success",
        });
    }
}
