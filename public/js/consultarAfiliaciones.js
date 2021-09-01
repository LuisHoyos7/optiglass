      
      $.ajax({
          data: null,
          url: '/usuarios/consultarPromotores',
          success: function(respuesta) {
              $('#cmbPromotor').append(respuesta);
          }
       });

 //Inicio dataTable
    var tabla = $('#data-table-simple').DataTable({
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
                    responsive: true,
                    "bAutoWidth": true,
                    "dom": "rtp"
                        
                }); 
   //  var tabla;
     function cargarAfiliaciones() {

        tabla.destroy();

        tabla = $('#data-table-simple').DataTable({
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
                    "scrollX": true,    
                    responsive: true,
                    "bAutoWidth": true,
                    "dom": "rtip",
                    ajax: {
                          data: {promotor:$('#cmbPromotor').val(), fecha:$('#txtFecha').val()},
                          url : "/consultarAfiliaciones/consultar",
                          dataSrc: ""
                      },
                    "columns": [
                      { data: "codigo" },
                      { data: "fecha"},
                      { data: "brigadaDescripcion"},
                      { data: "promotorNombre"},
                      { data: "nombre"},
                      { data: "celular"},
                      { data: "telefono"},
                      { data: "abono"},
                      { data: "saldo"}
                    ]
                        
                }); 
       
     }

      $.fn.dataTable.ext.errMode = 'none'; 
      //Fin dataTable

      $('#btnBuscar').click(function(){
          cargarAfiliaciones();    
          tabla.ajax.reload();
      });

      $('#btnImprimir').on('click',function(){
        var datos = {};
        tabla.rows().every(function(index){
          datos[index] = this.data(); 
        });
       // alert(JSON.stringify(datos));
        window.location.href = "consultarAfiliaciones/imprimir/"+JSON.stringify(datos);
      });