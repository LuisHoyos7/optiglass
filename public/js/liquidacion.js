import UsuarioServicio from './service/usuarioServicio.js'; 

let promotores = [];
UsuarioServicio.filter('PT')
.then((data)=>{
  promotores = data;
  mostrarPromotores();
})
.catch((error)=>{});

function mostrarPromotores() {
  let select = "<option value=''>Seleccione</option>";
  promotores.map((promotor) => {
    select+= `<option value='${promotor.codigo}'>${promotor.nombre}</option>`;
  })
  $('#cmbPromotor').html(select); 
}

$('#btnBuscar').click(function(){
    tabla.destroy();
    cargarDias();    
});   

      cargarDias();  

     var tabla; 
     function cargarDias(){
         tabla =  $('#data-table-simple').DataTable({
                  "scrollY":        '40vh',
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
                  "dom": "Brtip",
                  ajax: {
                        data: {promotor:$('#cmbPromotor').val()},
                        url : "liquidacion/consultar",
                      dataSrc: ""
                    },
                  "columns":[
                     {
                        className: "select-checkbox",
                        "orderable":false
                      },
                    { "width": "15%" , data: "nombrePromotor" },
                    { "width": "10%" , data: "fecha" },
                    { "width": "20%" , data: "brigadaDescripcion" },
                    { "width": "10%" , data: "afiliaciones"},
                    { "width": "10%" , data: "valor"},
                    { "width": "10%" , data: "ganancia"},
                    { "width": "10%" , data: "prestamo"},
                    { "width": "5%"  , data: "errores"},
                    { "width": "10%" , data: "valorErrores"},
                  ],
                  order: [[ 2, 'asc' ]],
                  select: {
                      style:    'multi',
                      selector: 'td:first-child'
                  },
                  buttons: [
                      {
                          text: 'Todos',
                          action: function () {
                              tabla.rows().select();
                             
                          }
                      },
                      {
                          text: 'Ninguno',
                          action: function () {
                              tabla.rows().deselect();
                             
                          }
                      }
                  ]
              });  
     }

    $('#btnErrores').on('click',function(){
      $("#preloader").fadeIn();
      $("#preloader").fadeOut(1000);
      errores.destroy();
      cargarErrores();
    });
  
  
  $.fn.dataTable.ext.errMode = 'none'; 

  //Fin dataTable
  var errores;
 function cargarErrores() {
      errores =  $('#data-table-errores').DataTable({
                "scrollY":        '70vh',
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
                "dom": "rt",
                "bAutoWidth": true,
                "scrollX": true,
                responsive: false,
                ajax: {
                      url : "liquidacion/consultarErrores" ,
                      data: {'_token':$('#txtToken').val(),liquidacion:JSON.stringify(datos)},
                      type: "post",
                      dataSrc: ""
                  },
                "columns": [
                  {
                    "className":      'details-control',
                    "orderable":      false,
                    "defaultContent": ''
                  },
                  {"width": "20", data: "fecha", "orderable":      false },
                  {"width": "20", data: "consecutivo", "orderable":      false},
                  {"width": "20", data: "brigada", "orderable":      false}
                  
                ]
                    
            });
  
  }

  function formatoDetallesError( data ) {
      return '<table cellspacing="0" border="0";">'+
          '<tr>'+
              '<td>Error:</td>'+
              '<td>'+data.error+'</td>'+
          '</tr>'+
      '</table>';
  }

  // Add event listener for opening and closing details
  $('#data-table-errores').on('click', 'td.details-control', function () {
      var tr = $(this).closest('tr');
      var row = errores.row( tr );

      if ( row.child.isShown() ) {
          // This row is already open - close it
          row.child.hide();
          tr.removeClass('shown');
      }
      else {
          // Open this row
          row.child( formatoDetallesError(row.data()) ).show();
          tr.addClass('shown');
      }
      
  } ); 


   //Nuevo
    $('#formLiquidacion').on('submit',function(e) {

      var form = $("#formLiquidacion");
      form.validate();
      e.preventDefault();

      if (form.valid()) {
        $.ajax({
            data: $('#formLiquidacion').serialize() + "&liquidacion=" + JSON.stringify(datos), 
            url: 'liquidacion/guardar',
            type: 'post',
            dataType: 'JSON',
            beforeSend: function() {
                $("#preloader").fadeIn();
            }, 
            success: function(respuesta) { 

              if (respuesta.estado == 'OK') {
                alerta('Success','Información del sistema','Registro almacenado exitosamente');
                tabla.ajax.reload();
                $("#txtPromotor").val('');
                $("#txtNombrePromotor").val('');
                $("#txtFechaInicio").val('');
                $('#txtFechaFin').val('');
                $('#txtAfiliaciones').val('');
                $('#txtGanancia').val('');
                $('#txtPrestamo').val('');
                $('#lblSubtotal').text('');
                $('#txtErrores').val('');
                $('#txtValorErrores').val('');
                $('#lblTotal').text('');
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
   

    $("#formLiquidacion").validate({
      rules: {
        promotor: "required",
        fechaInicio:"required",
        fechaFin:"required",
        ganancia:"required",
        prestamo: "required",
        errores: "required",
        valorErrores: "required"
        },
        //For custom messages
        messages: {
        promotor: "Campo requerido",
        fechaFin:"Campo requerido",
        fechaFin:"Campo requerido",
        ganancia:"Campo requerido",
        prestamo:"Campo requerido",
        errores:"Campo requerido",
        valorErrores:"Campo requerido"
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

  var datos = {};
  $('#btnLiquidar').on('click',function(){
    
    var filas = tabla.rows({ selected: true }).count();

    if (filas == 0) {
        return false;
    }

    datos = {};
    var contador = 0;
    var afiliaciones = 0;
    var ganancia = 0;
    var prestamo = 0;
    var error  = 0;
    var valorErrores = 0;
    tabla.rows({ selected: true }).every(function(index){
        datos[index] = this.data(); 
        contador = contador + 1;

        $("#txtPromotor").val(datos[index].promotor);
        $("#txtNombrePromotor").val(datos[index].nombrePromotor);

        if (filas == 1){
            $("#txtFechaInicio").val(datos[index].fecha);
            $('#txtFechaFin').val(datos[index].fecha);
        }else if (contador == 1){
           $("#txtFechaInicio").val(datos[index].fecha);
        } else if (contador = filas){
            $('#txtFechaFin').val(datos[index].fecha);
        }   

        afiliaciones = Number(afiliaciones) + Number(datos[index].afiliaciones);
        $('#txtAfiliaciones').val(afiliaciones);
        ganancia = Math.round((Number(ganancia) + Number(datos[index].ganancia))*100)/100;
        $('#txtGanancia').val(ganancia);
        prestamo = Math.round((Number(prestamo) + Number(datos[index].prestamo))*100)/100;
        $('#txtPrestamo').val(prestamo);
        
        $('#lblSubtotal').text(Math.round((Number(ganancia) - Number(prestamo))*100)/100);

        error = Number(error) + Number(datos[index].errores);
        $('#txtErrores').val(error);
        valorErrores = Math.round((Number(valorErrores) + Number(datos[index].valorErrores))*100)/100;
        $('#txtValorErrores').val(valorErrores);

        $('#lblTotal').text(Math.round(((Number(ganancia) - Number(prestamo)) - Number(valorErrores))*100)/100);

        errores = $('#data-table-errores').DataTable();
        errores.destroy();
        cargarErrores();
        
    });
    
  });

    
    
 