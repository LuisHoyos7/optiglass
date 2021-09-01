import RolServicio from './service/rolServicio.js'; 
import UsuarioServicio from './service/usuarioServicio.js';   

let roles = [];
RolServicio.findAll()
.then((data) => {
  roles = data;
  mostrarRoles();
})
.catch((error) => {});  

function mostrarRoles(){
  let select = "<option value=''>Seleccione</option>";
  roles.map((rol) => {
    select+= `<option value='${rol.codigo}'>${rol.descripcion}</option>`;
  })
  $('#cmbRolNuevo').html(select);
  $('#cmbRolEditar').html(select);
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
                  url : "usuarios",
                dataSrc: ""
              },
            "columns": [
              {"defaultContent": "<a class='btn-floating btn-small waves-effect waves-light gradient-45deg-indigo-purple gradient-shadow sidenav-trigger' data-target='slide-out-right-second'><i class='material-icons'>edit</i></a>",
                "orderable": false},
              {"defaultContent": "<a class='clave btn-floating btn-small waves-effect waves-light gradient-45deg-indigo-purple gradient-shadow modal-trigger' href='#dlgCambiarClave'><i class='material-icons'>vpn_key</i></a>",
                "orderable": false},
              { "width": "15%" , data: "codigo" },
              { "width": "40%" , data: "nombre"},
              { "width": "20%" , data: "rolDescripcion"},
              { "width": "20%" , data: "estadoDescripcion"}
            ],
              "order": [[ 2, "asc" ]]
                
        });  
          
let data
$('#data-table-simple tbody').on( 'click', 'a', function () {
    data = $('#data-table-simple').DataTable().row( $(this).parents('tr') ).data();
    $("#txtCodigoEditar").val(data.codigo);
    $('#txtNombreEditar').val(data.nombre);
    $('#txtCelularEditar').val(data.celular);
    $('#txtTelefonoEditar').val(data.telefono);
    $('#txtEmailEditar').val(data.email);
    $('#cmbRolEditar').val(data.rol);
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
$('#formUsuarioNuevo').on('submit',function(e) {

  let form = $("#formUsuarioNuevo");
  form.validate();
  e.preventDefault();

  if (form.valid()) {
    let data = $('#formUsuarioNuevo').serialize();
    $("#preloader").fadeIn();
    UsuarioServicio.create(data)
    .then((respuesta) => {

      if (respuesta.estado == 'OK') {
        alerta('Success','Información del sistema','Registro almacenado exitosamente');
        tabla.ajax.reload();
        $("#formUsuarioNuevo")[0].reset();
        $('label').attr('class','active');
      } else {
        alerta('Error','Iconvenientes almacenando registro:',respuesta.msgError);
      }

      $("#preloader").fadeOut();
    })
    .catch((error) => {
      alerta('Error','Iconvenientes almacenando registro:',error.responseText);
      $("#preloader").fadeOut();
    });
  }   
});   

$("#formUsuarioNuevo").validate({
    rules: {
      codigo: "required",
      nombre:"required",
      email: "email",
      rol:"required",
      clave: {required: true, minlength: 5},
      repetirClave: {required: true, equalTo: "#txtClaveNuevo"},
      estado: "required"
      },
      //For custom messages
      messages: {
      codigo: "Campo requerido",
      nombre:"Campo requerido",
      email: "Email no válido",
      rol:"Campo requerido",
      clave: {required: "Campo requerido", minlength: "Ingrese al menos 5 carácteres"},
      repetirClave: {required: "Campo requerido", equalTo: "Clave no coincida"},
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
$('#formUsuarioEditar').on('submit',function(e) {

    let form = $("#formUsuarioEditar");
    form.validate();
    e.preventDefault();

    if (form.valid()) {
      let payload = $('#formUsuarioEditar').serialize();
      $("#preloader").fadeIn();
      UsuarioServicio.update(payload, data.codigo)
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
      });    
    }       
});   

$("#formUsuarioEditar").validate({
    rules: {
      nombre:"required",
      email: "email",
      rol:"required",
      estado: "required"
      },
      //For custom messages
      messages: {
      nombre:"Campo requerido",
      email: "Email no válido",
      rol:"Campo requerido",
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

//Clave
$('#data-table-simple tbody').on('click','.clave',function (e) {
  limpiarClaves();
});
function limpiarClaves() {
    $("#formCambiarClave")[0].reset();
    $('label').attr('class','active');
};

$('#formCambiarClave').on('submit',function(e) {

    let form = $("#formCambiarClave");
    form.validate();
    e.preventDefault();

    if (form.valid()) {
      let payload = $('#formCambiarClave').serialize();
      $("#preloader").fadeIn();
      UsuarioServicio.changePassword(payload, data.codigo)
      .then((respuesta) => {

        if (respuesta.estado == 'OK') {
          alerta('Success','Información del sistema','Clave cambiada exitosamente');
          tabla.ajax.reload();
          $("#formCambiarClave")[0].reset();
          $('label').attr('class','active');
          $('#dlgCambiarClave').modal('close');
        } else {
          alerta('Error','Iconvenientes cambiando clave:',respuesta.msgError);
        }

        $("#preloader").fadeOut();
      })
      .catch((error) => {
        alerta('Error','Iconvenientes cambiando clave:',error.responseText);
        $("#preloader").fadeOut();
      }); 
    }            
});   

$("#formCambiarClave").validate({
    rules: {
      claveNueva: {required: true, minlength: 5},
      repetirClaveNueva: {required: true, equalTo: "#txtClaveNueva"}
      },
      //For custom messages
      messages: {
      claveNueva: {required: "Campo requerido", minlength: "Ingrese al menos 5 carácteres"},
      repetirClaveNueva: {required: "Campo requerido", equalTo: "Clave no coincida"}
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
     
	