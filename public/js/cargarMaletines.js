import CargarMaletinServicio from './service/cargarMaletinServicio.js';

cargarAfiliaciones();
 
//Inicio dataTable
var tabla;
function cargarAfiliaciones() {
    tabla =  $('#data-table-simple').DataTable({
            "scrollY":        '45vh',
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
                  url : "cargarmaletines",
                dataSrc: ""
              },
            "columns": [
              {
                  className: "select-checkbox"
              },
              { "width": "10%" , data: "id" },  
              { "width": "80%" , data: "descripcion" },
              { "width": "10%" , data: "carga" }
            ],
            select: {
                style:    'multi',
                selector: 'td:first-child'
            }
                
        });  

}
  
  
$.fn.dataTable.ext.errMode = 'none'; 

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('#formCarga').on('submit',function(e) {
  
  if(tabla.rows( { selected: true } ).count() == 0) {
      return false;
  }
  e.preventDefault();
  
  var datos = {};
  tabla.rows({ selected: true }).every(function(index){
    datos[index] = this.data(); 
  });
  let asignaciones = Object.keys(datos).map((key) => datos[key].id );
  let data = {'_token': $('#token').val(),
              asignaciones:JSON.stringify(asignaciones)};

  $("#preloader").fadeIn();
  CargarMaletinServicio.create(data)
  .then((respuesta) => {
    if (respuesta.estado == 'OK') {
      alerta('Success','Información del sistema','Registros almacenados exitosamente');
      tabla.ajax.reload();
    } else {
      alerta('Error','Iconvenientes almacenando registro:',respuesta.msgError);
    }

    $("#preloader").fadeOut();
  })
  .catch((error) => {
    alerta('Error','Iconvenientes almacenando registro:',error.responseText);
    $("#preloader").fadeOut();
  })
            
});   