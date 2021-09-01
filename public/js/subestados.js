import Utilidad from './estadosUtilidad.js';

let estados = [];
Utilidad.estados()
.then((data) => {
  estados = data;
  mostrarEstados();
})
.catch((error) => {});  

function mostrarEstados() {
  let select = "<option value=''>Seleccione</option>";
  estados.map((estado) => {
    select+= `<option value='${estado.codigo}'>${estado.descripcion}</option>`;
  })
  $('#cmbCodigoEstadoNuevo').html(select);
  $('#cmbCodigoEstadoEditar').html(select);
}

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
                  url : "subestados",
                dataSrc: ""
              },
            "columns": [
              {"defaultContent": "<a class='btn-floating btn-small waves-effect waves-light gradient-45deg-indigo-purple gradient-shadow sidenav-trigger' data-target='slide-out-right-second'><i class='material-icons'>edit</i></a>",
                "orderable": false},
              { "width": "20%" , data: "estadoDescripcion" },
              { "width": "20%" , data: "codigo" },
              { "width": "40%" , data: "descripcion"},
              { "width": "20%" , data: "estadoSubestado"}
            ],
              "order": [[ 1, "asc" ]]
                
        });  
        
let data;
$('#data-table-simple tbody').on( 'click', 'a', function () {
    data = $('#data-table-simple').DataTable().row( $(this).parents('tr') ).data();
    $("#cmbCodigoEstadoEditar").val(data.codigoEstado);
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
$('#formSubestadoNuevo').on('submit',function(e) {

  let form = $("#formSubestadoNuevo");
  form.validate();
  e.preventDefault();

  if (form.valid()) {
    $.ajax({
        data: $('#formSubestadoNuevo').serialize(),
        url: 'subestados',
        type: 'post',
        dataType: 'JSON',
        beforeSend: function() {
            $("#preloader").fadeIn();
        }, 
        success: function(respuesta) { 

          if (respuesta.estado == 'OK') {
            alerta('Success','Información del sistema','Registro almacenado exitosamente');
            tabla.ajax.reload();
            $("#formSubestadoNuevo")[0].reset();
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

$("#formSubestadoNuevo").validate({
    rules: {
      codigoEstado: "required",
      codigo: "required",
      descripcion:"required",
      estado: "required"
      },
      //For custom messages
      messages: {
      codigoEstado: "Campo requerido",  
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
$('#formSubestadoEditar').on('submit',function(e) {

  let form = $("#formSubestadoEditar");
  form.validate();
  e.preventDefault();

  if (form.valid()) {
    $.ajax({
        data: $('#formSubestadoEditar').serialize(),
        url: 'subestados/'+data.codigo,
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

$("#formSubestadoEditar").validate({
    rules: {
      codigoEstado: "required",
      codigo: "required",
      descripcion:"required",
      estado: "required"
      },
      //For custom messages
      messages: {
      codigoEstado: "Campo requerido",
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