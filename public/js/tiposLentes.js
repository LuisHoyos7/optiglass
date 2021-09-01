import tipoLente from './service/tipoLente.js';
import TipoLenteServicio from './service/tipoLente.js';

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
                  url : "lentes",
                dataSrc: ""
              },
            "columns": [
              {"defaultContent": "<a class='btn-floating btn-small waves-effect waves-light gradient-45deg-indigo-purple gradient-shadow sidenav-trigger' data-target='slide-out-right-second'><i class='material-icons'>edit</i></a>",
                "orderable": false },
              { "width": "15%" , data: "id" },
              { "width": "70%" , data: "descripcion"},
              { "width": "15%" , data: "estadoDescripcion"}
            ],
            "order": [[ 1, "asc" ]]
                
        });  
     
let data;        
$('#data-table-simple tbody').on( 'click', 'a', function () {
    data = $('#data-table-simple').DataTable().row( $(this).parents('tr') ).data();
    $('#txtCodigoEditar').val(data.id);
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
$('#formLenteNuevo').on('submit',function(e) {
    let form = $("#formLenteNuevo");
    form.validate();
    e.preventDefault();

    if (form.valid()) {
      let data = $('#formLenteNuevo').serialize();
      $("#preloader").fadeIn();
      TipoLenteServicio.create(data)
      .then((respuesta) => {
        if (respuesta.estado == 'OK') {
          alerta('Success','Información del sistema','Registro almacenado exitosamente');
          tabla.ajax.reload();
          $("#formLenteNuevo")[0].reset();
          $('label').attr('class','active');
        } else {
          alerta('Error','Iconvenientes almacenando registro:',respuesta.msgError);
        }
        
        $("#preloader").fadeOut();
      })
      .catch((error) => {
        alerta('Error','Iconvenientes almacenando registro:',error.responseText);
        $("#preloader").fadeOut();
      })
    }
});   

$("#formLenteNuevo").validate({
    rules: {
      descripcion: "required",
      estado: "required"
      },
      //For custom messages
      messages: {
      descripcion: "Campo requerido",
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
$('#formLenteEditar').on('submit',function(e) {
  let form = $("#formLenteEditar");
  form.validate();
  e.preventDefault();

  if (form.valid()) {
    let payload = $('#formLenteEditar').serialize();
    $("#preloader").fadeIn(); 
    TipoLenteServicio.update(payload, data.id)
    .then((respuesta) => {
      if (respuesta.estado == 'OK') {
        alerta('Success','Información del sistema','Registro editado exitosamente');
        tabla.ajax.reload();
      } else {
        alerta('Error','Iconvenientes editando registro:',respuesta.msgError);
      }

      $("#preloader").fadeOut();
    })
    .catch((error) => {
      alerta('Error','Iconvenientes editando registro:',error.responseText);
      $("#preloader").fadeOut();
    })
  }
});   

$("#formLenteEditar").validate({
    rules: {
      descripcion: "required",
      estado: "required"
      },
      //For custom messages
      messages: {
      descripcion: "Campo requerido",
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
		
