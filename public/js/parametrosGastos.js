
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
                        url : "parametros/consultar",
                      dataSrc: ""
                    },
                  "columns": [
                    {"defaultContent": "<a class='btn-floating btn-small waves-effect waves-light gradient-45deg-indigo-purple gradient-shadow sidenav-trigger' data-target='slide-out-right-second'><i class='material-icons'>edit</i></a>",
                    "orderable": false},
                    { "width": "5%" , data: "id"},
                    { "width": "15%" , data: "minima"},
                    { "width": "15%" , data: "maxima"},
                    { "width": "5%" , data: "pagadas"},
                    { "width": "10%" , data: "descripcionDesayuno"},
                    { "width": "10%" , data: "descripcionAlmuerzo"},
                    { "width": "10%" , data: "descripcionCena"},
                    { "width": "10%" , data: "descripcionHotel"},
                    { "width": "10%" , data: "descripcionTransporte"},
                    { "width": "10%" , data: "descripcionEstado"}
                  ]
                      
              });  
    

    $('#data-table-simple tbody').on( 'click', 'a', function () {
        var data = $('#data-table-simple').DataTable().row( $(this).parents('tr') ).data();
        $("#txtCodigoEditar").val(data.id);
        $('#cmbEstadoEditar').val(data.estado);
        $('#txtMinimaEditar').val(data.minima);
        $('#txtMaximaEditar').val(data.maxima);
        $('#txtPagadasEditar').val(data.pagadas)
        $('#DesayunoEditar').prop('checked',Boolean(Number(data.aplicaDesayuno)));
        $('#txtDesayunoEditar').attr("readonly",!Boolean(Number(data.aplicaDesayuno)))
        $('#txtDesayunoEditar').val(data.desayuno);
        $('#AlmuerzoEditar').prop('checked',Boolean(Number(data.aplicaAlmuerzo)));
        $('#txtAlmuerzoEditar').attr("readonly",!Boolean(Number(data.aplicaAlmuerzo)))
        $('#txtAlmuerzoEditar').val(data.almuerzo);
        $('#CenaEditar').prop('checked',Boolean(Number(data.aplicaCena)));
        $('#txtCenaEditar').attr("readonly",!Boolean(Number(data.aplicaCena)))
        $('#txtCenaEditar').val(data.cena);
        $('#HotelEditar').prop('checked',Boolean(Number(data.aplicaHotel)));
        $('#txtHotelEditar').attr("readonly",!Boolean(Number(data.aplicaHotel)))
        $('#txtHotelEditar').val(data.hotel);
        $('#TransporteEditar').prop('checked',Boolean(Number(data.aplicaTransporte)));
        $('#txtTransporteEditar').attr("readonly",!Boolean(Number(data.aplicaTransporte)))
        $('#txtTransporteEditar').val(data.transporte);
    } );
  
  
  $.fn.dataTable.ext.errMode = 'none'; 
  //Fin dataTable

  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

    //Guardar
    $('#formParametroNuevo').on('submit',function(e) {

      var form = $("#formParametroNuevo");
      form.validate();
      e.preventDefault();

      if (form.valid()) {
        $.ajax({
            data: $('#formParametroNuevo').serialize(),
            url: 'parametros/guardar',
            type: 'post',
            dataType: 'JSON',
            beforeSend: function() {
                $("#preloader").fadeIn();
            }, 
            success: function(respuesta) { 

              if (respuesta.estado == 'OK') {
                alerta('Success','Información del sistema','Registro almacenado exitosamente');
                tabla.ajax.reload();
                $("#formParametroNuevo")[0].reset();
                $('label').attr('class','active');
                $("#txtDesayunoNuevo, #txtAlmuerzoNuevo, #txtCenaNuevo, #txtHotelNuevo, #txtTransporteNuevo").attr("readonly",true);
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

     $("#formParametroNuevo").validate({
      rules: {
        estado: "required",
        minima: "required",
        maxima: "required",
        pagadas: "required"
        },
        //For custom messages
        messages: {
        estado: "Campo requerido",
        minima:"Campo requerido",
        minima:"Campo requerido",
        pagadas: "Campo requerido"
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

     //Guardar
    $('#formParametroEditar').on('submit',function(e) {

      var form = $("#formParametroEditar");
      form.validate();
      e.preventDefault();

      if (form.valid()) {
        $.ajax({
            data: $('#formParametroEditar').serialize(),
            url: 'parametros/editar',
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

     $("#formParametroEditar").validate({
      rules: {
        estado: "required", 
        minima: "required",
        maxima: "required",
        pagadas: "required"
        },
        //For custom messages
        messages: {
        estado: "Campo requerido",
        minima:"Campo requerido",
        minima:"Campo requerido",
        pagadas: "Campo requerido"
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

     $("#DesayunoNuevo, #AlmuerzoNuevo, #CenaNuevo, #HotelNuevo, #TransporteNuevo").change(function(){
          if ($(this).prop('checked')) {
            $('#txt' + $(this).attr('id')).attr("readonly",false);
          } else
          {
            $('#txt' + $(this).attr('id')).attr("readonly","true");
            $('#txt' + $(this).attr('id')).val('');
          }
      });

     $("#DesayunoEditar, #AlmuerzoEditar, #CenaEditar, #HotelEditar, #TransporteEditar").change(function(){
          if ($(this).prop('checked')) {
            $('#txt' + $(this).attr('id')).attr("readonly",false);
          } else
          {
            $('#txt' + $(this).attr('id')).attr("readonly","true");
            $('#txt' + $(this).attr('id')).val('');
          }
      });
 
	