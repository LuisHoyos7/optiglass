

      //Inicio dataTable
     let tabla =  $('#data-table-simple').DataTable({
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
                  "bAutoWidth": true,
                  "scrollX": true,
                  ajax: {
                        url : "estados",
                      dataSrc: ""
                    },
                  "columns": [
                    {"defaultContent": "<a class='btn-floating btn-small waves-effect waves-light gradient-45deg-indigo-purple gradient-shadow sidenav-trigger' data-target='slide-out-right-second'><i class='material-icons'>edit</i></a>",
                      "orderable": false},
                    { "width": "15%" , data: "codigo" },
                    { "width": "60%" , data: "descripcion"},
                    { "width": "20%" , data: "estadoDescripcion"}
                  ],
                   "order": [[ 1, "asc" ]]
                      
              });  
          
    let data;          
    $('#data-table-simple tbody').on( 'click', 'a', function () {
        data = $('#data-table-simple').DataTable().row( $(this).parents('tr') ).data();
        $("#txtCodigoEditar").val(data.codigo);
        $('#txtDescripcionEditar').val(data.descripcion);
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
		$('#formEstadoNuevo').on('submit',function(e) {

			let form = $("#formEstadoNuevo");
			form.validate();
			e.preventDefault();

			if (form.valid()) {
        $.ajax({
            data: $('#formEstadoNuevo').serialize(),
            url: 'estados',
            type: 'post',
            dataType: 'JSON',
            beforeSend: function() {
                $("#preloader").fadeIn();
            }, 
            success: function(respuesta) { 

              if (respuesta.estado == 'OK') {
                alerta('Success','Información del sistema','Registro almacenado exitosamente');
                tabla.ajax.reload();
                $("#formEstadoNuevo")[0].reset();
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

    $("#formEstadoNuevo").validate({
      rules: {
        codigo: "required",
        descripcion:"required",
        estado: "required"
        },
        //For custom messages
        messages: {
        codigo: "Campo requerido",
        descripcion:"Campo requerido",
        estado:"Campo requerido"
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
    $('#formEstadoEditar').on('submit',function(e) {

      let form = $("#formEstadoEditar");
      form.validate();
      e.preventDefault();

      if (form.valid()) {
        $.ajax({
            data: $('#formEstadoEditar').serialize(),
            url: 'estados/'+data.codigo,
            type: 'put',
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

     $("#formEstadoEditar").validate({
      rules: {
        codigo: "required",
        descripcion:"required",
        estado: "required"
        },
        //For custom messages
        messages: {
        codigo: "Campo requerido",
        descripcion:"Campo requerido",
        estado:"Campo requerido"
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
		
	
     
	