

      //Inicio dataTable
     var tabla =  $('#data-table-simple').DataTable({
                  "scrollY":        '40vh',
                  "pageLength": 25,
                  "lengthMenu": [ 25, 50, 75, 100 ],
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
                  "scrollX": true,
                  "bAutoWidth": true,
                  ajax: {
                        url : "errores/consultar",
                      dataSrc: ""
                    },
                  "columns": [
                    {"defaultContent": "<a class='btn-floating btn-small waves-effect waves-light gradient-45deg-indigo-purple gradient-shadow sidenav-trigger' data-target='slide-out-right-second'><i class='material-icons'>edit</i></a>",
                      "orderable": false },
                    { "width": "15%" , data: "numero" },
                    { "width": "50%" , data: "descripcion"},
                    { "width": "15%" , data: "descuento"},
                    { "width": "15%" , data: "estadoDescripcion"}
                  ],
                  "order": [[ 1, "asc" ]]
                      
              });  
          
    $('#data-table-simple tbody').on( 'click', 'a', function () {
        var data = $('#data-table-simple').DataTable().row( $(this).parents('tr') ).data();
        $("#txtNumeroEditar").val(data.numero);
        $('#txtDescripcionEditar').val(data.descripcion);
        $('#txtDescuentoEditar').val(data.descuento);
        $('#cmbEstadoEditar').val(data.estado);
    } );
  
  
  $.fn.dataTable.ext.errMode = 'none'; 
  //Fin dataTable


  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
		
		//Nuevo
		$('#formErroresNuevo').on('submit',function(e) {

			var form = $("#formErroresNuevo");
			form.validate();
			e.preventDefault();

			if (form.valid()) {
        $.ajax({
            data: $('#formErroresNuevo').serialize(),
            url: 'errores/guardar',
            type: 'post',
            dataType: 'JSON',
            beforeSend: function() {
                $("#preloader").fadeIn();
            }, 
            success: function(respuesta) { 

              if (respuesta.estado == 'OK') {
                alerta('Success','Información del sistema','Registro almacenado exitosamente');
                tabla.ajax.reload();
                $("#formErroresNuevo")[0].reset();
                $('label').attr('class','active');
              } else {
                alerta('Error','Iconvenientes almacenando registro:',respuesta.msgError);
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

    $("#formErroresNuevo").validate({
      rules: {
        descripcion: "required",
        descuento: "required",
        estado: "required"
        },
        //For custom messages
        messages: {
        descripcion: "Campo requerido",
        descuento: "Campo requerido",
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

    //Editar
    $('#formErroresEditar').on('submit',function(e) {

      var form = $("#formErroresEditar");
      form.validate();
      e.preventDefault();

      if (form.valid()) {
        $.ajax({
            data: $('#formErroresEditar').serialize(),
            url: 'errores/editar',
            type: 'post',
            dataType: 'JSON',
            beforeSend: function() {
                $("#preloader").fadeIn();
            }, 
            success: function(respuesta) { 

              if (respuesta.estado == 'OK') {
                alerta('Success','Información del sistema','Registro editado exitosamente');
                tabla.ajax.reload();
              } else {
                alerta('Error','Iconvenientes editando registro:',respuesta.msgError);
              }

              $("#preloader").fadeOut();
               
            },
            error: function(jqXHR) { 
              alerta('Error','Iconvenientes editando registro:',jqXHR.responseText);
              $("#preloader").fadeOut();
            }
        });
      }
              
   });   

     $("#formErroresEditar").validate({
      rules: {
        numero: "required",
        descripcion: "required",
        descuento: "required",
        estado: "required"
        },
        //For custom messages
        messages: {
        numero: "Campo requerido",
        descripcion: "Campo requerido",
        descuento: "Campo requerido",
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
	