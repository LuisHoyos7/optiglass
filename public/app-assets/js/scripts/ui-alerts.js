/*
 * UI - Alerts
 */

$(".card-alert .close").click(function () {
    $(this)
        .closest(".card-alert")
        .fadeOut("slow");
});
 
function alerta(tipo,titulo,msg) {

	if (tipo == 'Error') {
	    html = '';
		html += " <div id='alertError' class='card-alert card gradient-45deg-red-pink right' style='z-index: 1500; position: fixed'>";
	    html += "   <div class='card-content white-text'>";
	    html += "        <i class='material-icons'>error</i> "+ titulo +" </p>";
	    html += "       <p id='msgError' style='padding-left: 25px;'>"+ msg +"</p>";
	    html += "    </div>";
	  	html += " </div>";

	  	$('#alerta').html(html);
		$("#alertError").fadeIn();
	    $("#alertError").fadeOut(15000);
	} else if (tipo == 'Success') {
	    html = '';
		html += " <div id='alertSuccess' class='card-alert card gradient-45deg-green-teal right' style='z-index: 1500; position: fixed'>";
	    html += "   <div class='card-content white-text'>";
	    html += "        <i class='material-icons'>check</i> "+ titulo +"</p>";
	    html += "       <p id='msgError' style='padding-left: 25px;'>"+ msg +"</p>";
	    html += "    </div>";
	  	html += " </div>";

	  	$('#alerta').html(html);
		$("#alertSuccess").fadeIn();
	    $("#alertSuccess").fadeOut(15000);
	}
	
}