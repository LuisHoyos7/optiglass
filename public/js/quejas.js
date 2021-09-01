$.ajax({
  data: null,
  url: 'errores/consultarErrores',
  success: function(respuesta) {
      $('#cmbError').html(respuesta);
  }
});

cargarErrores('');

var tabla;
function cargarErrores(consecutivo){
tabla =  $('#data-table-simple').DataTable({
              "scrollY":        '20vh',
              "language": {
                     "sProcessing":     "Procesando...",
                     "sLengthMenu":     "Mostrar _MENU_ registros",
                     "sZeroRecords":    "No se encontraron resultados",
                     "sEmptyTable":     "Ningún dato disponible en esta tabla",
                     "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                     "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                     "sInfoFiltered":   "",
                     "sInfoPostFix":    "",
                     "sSearch":         "Buscar:",
                     "sSearchPlaceholder": "Dato a buscar",
                     "sUrl":            "",
                     "sInfoThousands":  ",",
                     "sLoadingRecords": "Cargando...",
                     "oPaginate": {
                      "sFirst":    "Primero",
                      "sLast":     "Último",
                      "sNext":     "Siguiente",
                      "sPrevious": "Anterior"
                     },
                     "oAria": {
                      "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                      "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                     }
                  },
              responsive: false,
              "dom": "rt",
              "bAutoWidth": true,
              "scrollX": true,
              ajax: {
                      data: {consecutivo:consecutivo},
                      url : "quejas/consultarErrores",
                      dataSrc: ""
                    },
              "columns": [
              {"defaultContent": "<a class='btn-floating btn-small waves-effect waves-light gradient-45deg-indigo-purple gradient-shadow'><i class='material-icons'>edit</i></a>",
                      "orderable": false },
                {"width": "15%", data: "numero", "orderable": false},
                {"width": "60%", data: "errorDescripcion", "orderable": false},
                {"width": "20%", data: "estadoDescripcion", "orderable": false}
              ]
                  
          });
}

$.fn.dataTable.ext.errMode = 'none'; 
  //Fin dataTable

//Nuevo
		$('#formQueja').on('submit',function(e) {

			var form = $("#formQueja");
			form.validate();
			e.preventDefault();

			if (form.valid()) {
        $.ajax({
            data: $('#formQueja').serialize(),
            url: 'quejas/guardar',
            type: 'post',
            dataType: 'JSON',
            beforeSend: function() {
                if ($('#txtNombres').val() == ''){
                    alerta('Error','Iconvenientes almacenando registro:','Debe consultar un consecutivo');
                    return false;
                }
                $("#preloader").fadeIn();
            }, 
            success: function(respuesta) { 

              if (respuesta.estado == 'OK') {
                alerta('Success','Información del sistema','Registro almacenado exitosamente');
                tabla.ajax.reload();
              } else {
                alerta('Error','Iconvenientes almacenando registro:',respuesta.estado);
              }

              $("#preloader").fadeOut();
               
            },
            error: function(jqXHR) { 
              alerta('Error','Iconvenientes almacenando registro:',jqXHR.responseText);
              $("#preloader").fadeOut();
            }
        });
      }
              
   });   

    $("#formQueja").validate({
      rules: {
        consecutivo: "required",
        error: "required",
        estado: "required"
        },
        //For custom messages
        messages: {
        consecutivo: "Campo requerido",
        error: "Campo requerido",
        estado: "Campo requerido"
        },
        errorElement : 'div',
        errorPlacement: function(error, element) {
          var placement = $(element).data('error');
          if (placement) {
            $(placement).append(error)
          } else {
        error.insertAfter(element);
        }
      }
  });   

    $("#btnBuscar").click(function(){
        $.ajax({
            data: {consecutivo:$('#txtConsecutivo').val()},
            url: 'quejas/consultar',
            type: 'get',
            dataType: 'JSON',
            beforeSend: function() {
                $("#preloader").fadeIn();
            }, 
            success: function(respuesta) { 

              if (respuesta.estado == 'OK') {
                $("#txtConsecutivo").val(respuesta.respuesta.consecutivo);
                $("#txtNumeroDocumento").val(respuesta.respuesta.numeroDocumento);
                $('#txtNombres').val(respuesta.respuesta.nombres);
                $('#txtApellidos').val(respuesta.respuesta.apellidos);
                $('#txtBrigada').val(respuesta.respuesta.brigada);
                $('#txtPromotor').val(respuesta.respuesta.promotor);
                tabla.destroy();
                cargarErrores($("#txtConsecutivo").val());
                $('#cmbError').val("");
                $('#cmbEstado').val("");
              } else {
                $("#txtNumeroDocumento").val("");
                $('#txtNombres').val("");
                $('#txtApellidos').val("");
                $('#txtBrigada').val("");
                $('#txtPromotor').val("");
                tabla.destroy();
                cargarErrores("");
                alerta('Error','Iconvenientes consultando registro:',respuesta.msgError);
              }

              $("#preloader").fadeOut();
               
            },
            error: function(jqXHR) { 
              alerta('Error','Iconvenientes consultando registro:',jqXHR.responseText);
              $("#preloader").fadeOut();
            }
        });
    });

    $('#data-table-simple tbody').on( 'click', 'a', function () {

      var data = $('#data-table-simple').DataTable().row( $(this).parents('tr') ).data();
      $('#txtNumero').val(data.numero);
      $('#cmbError').val(data.error);
      $('#cmbEstado').val(data.estado);

      $("#txtConsecutivo").attr("readonly","true")
      $("#btnBuscar").attr("style","display: none")
  } );

    $("#btnNuevo").click(function(){
      $("#txtConsecutivo").removeAttr("readonly")
      $("#btnBuscar").attr("style","display: block")
      $("#formQueja")[0].reset();
      $('label').attr('class','active');
      tabla.destroy();
      cargarErrores("");
    })

    $("#txtConsecutivo").on("change",function(){
        $("#txtNumeroDocumento").val("");
        $('#txtNombres').val("");
        $('#txtApellidos').val("");
        $('#txtBrigada').val("");
        $('#txtPromotor').val("");
        tabla.destroy();
        cargarErrores("");
    });
    