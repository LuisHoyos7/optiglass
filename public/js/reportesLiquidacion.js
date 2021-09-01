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
      cargarLiquidaciones();  

     var tabla; 
     function cargarLiquidaciones(){
         tabla =  $('#data-table-simple').DataTable({
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
                  "dom": "Brtip",
                  ajax: {
                        data: {promotor:$('#cmbPromotor').val(),fechaInicio:$('#txtFechaInicio').val(),fechaFin:$('#txtFechaFin').val()},
                        url : "reportesLiquidacion/consultar",
                      dataSrc: ""
                    },
                  "columns":[
                    { "width": "30%" , data: "nombrePromotor", "orderable":false },
                    { "width": "10%" , data: "fechaInicio", "orderable":false },
                    { "width": "10%" , data: "fechaFin", "orderable":false },
                    { "width": "10%" , data: "afiliaciones", "orderable":false},
                    { "width": "10%" , data: "ganancia", "orderable":false},
                    { "width": "10%" , data: "prestamo", "orderable":false},
                    { "width": "10%" , data: "errores", "orderable":false},
                    { "width": "10%" , data: "valorErrores", "orderable":false},
                    { "width": "10%" , data: "total", "orderable":false}
                  ],
                  buttons: [
                      {
                          extend: 'excel',
                          title: 'LIQUIDACIONES',
                          exportOptions: {
                              columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8 ]
                          }
                      },
                      {
                          extend: 'pdf',
                          title: 'LIQUIDACIONES',
                          exportOptions: {
                              columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8 ]
                          }
                      }
                  ]
              });  
     }

  
  
  $.fn.dataTable.ext.errMode = 'none'; 

  $('#btnBuscar').click(function(){
      tabla.destroy();
      cargarLiquidaciones();    
  });


$('#btnImprimir').on('click',function(){

        if (tabla.rows({ selected: true }).count() == 0) {
          return false;
        }

        var datos = {};
        tabla.rows().every(function(index){
          datos[index] = this.data(); 
        });
       
          $.ajax({
            data: {'_token':$('#txtToken').val(),registros:JSON.stringify(datos)},
            url: 'reportesLiquidacion/imprimir',
            type: 'post',
            xhrFields: {
              responseType: 'blob'
            },
            success: function (response) {
              var link = document.createElement('a');
              link.href = window.URL.createObjectURL(response);
              link.download = "liquidacion.pdf";
              link.click();
                console.log(response);
              },
              error: function(jqXHR) { 
              alerta('Error','Iconvenientes almacenando registro:',jqXHR.responseText);
             
            }
    
          });
        
  }); 

    
    
 