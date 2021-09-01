import UsuarioServicio from './service/usuarioServicio.js';
import SubestadoServicio from './service/subestadoServicio.js';
import CallDealerServicio from './service/callDealerServicio.js';
import BrigadaServicio from './service/brigadaServicio.js';
import ErrorServicio from './service/errorServicio.js';
import Clientes from './clientes.js';

let userLogin = {user:null,rol:null};

let gestores = [];
UsuarioServicio.filter('GT')
.then((data)=>{
  gestores = data;
  return UsuarioServicio.getUserLogin();
})
.then((data) => {
  userLogin.user = data.usuario;
  userLogin.rol = data.rol;
})
.catch((error)=>{})
.finally(() => {
  mostrarGestores();
})

let subestados = [];
SubestadoServicio.filter('GE')
.then((data)=>{
  subestados = data;
  mostrarSubestados();
})
.catch((error)=>{});

let brigadas = [];
BrigadaServicio.filter('P')
.then((data)=>{
  brigadas = data;
  mostrarBrigadas();
})
.catch((error)=>{});

let errores = [];
ErrorServicio.filter()
.then((data)=>{
  errores = data;
  mostrarErrores();
})
.catch((error)=>{});

function mostrarSubestados() {
  let select = "<option value=''>Seleccione</option>";
  subestados.map((subestado) => {
    select+= `<option value='${subestado.codigo}'>${subestado.descripcion}</option>`;
  })
  $('#cmbSubestadoNuevo').html(select);
}

function mostrarGestores() {
  let select = "<option value=''>Seleccione</option>";
  if (userLogin.rol === 'GT') {
    gestores = gestores.filter(item => item.codigo === userLogin.user); 
    select = '';
  }
  gestores.map((gestor) => {
    select+= `<option value='${gestor.codigo}'>${gestor.nombre}</option>`;
  })
  $('#cmbGestor').html(select); 
}

function mostrarBrigadas() {
  let select = "<option value=''>Seleccione</option>";
  brigadas.map((brigada) => {
    select+= `<option value='${brigada.id}'>${brigada.descripcion}</option>`;
  })
  $('#cmbBrigada').html(select);
}

function mostrarErrores() {
  let select = "<option value=''>Seleccione</option>";
  errores.map((error) => {
    select+= `<option value='${error.numero}'>${error.descripcion}</option>`;
  })
  $('#cmbError').html(select);
}

$('#btnBuscar').click(function(){
  tabla.destroy();
  cargarAfiliaciones();
})
       
function queryParam() {
  let gestor = $('#cmbGestor').val() != null ? $('#cmbGestor').val() : '';
  const fecha = $('#txtFechaAfiliacion').val() != null ?  $('#txtFechaAfiliacion').val() : '';
  const brigada = $('#cmbBrigada').val() != null ? $('#cmbBrigada').val() : '';
  if (userLogin.rol === 'GT') {
    gestor = userLogin.user;
  }
  return `gestor=${gestor}&fecha=${fecha}&brigada=${brigada}`;
}

cargarAfiliaciones();

//Inicio dataTable
var tabla;
function cargarAfiliaciones() {
console.log("hola");
tabla =  $('#data-table-simple').DataTable({
            "scrollY":        '40vh',
            "pageLength": 25,
            "lengthMenu": [ 25, 50, 75, 100 ],
            "createdRow": function( row, data, dataIndex){
                            if (data.gestiones===0){
                              $(row).addClass("row-gestion");
                            }
                          },
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
            "dom": "rtip",
            "bAutoWidth": true,
            ajax: {
                  url : `callsdealer?${queryParam()}`,
                dataSrc: ""
              },
            "columns": [
              {"defaultContent": "<a class='btn-floating btn-small waves-effect waves-light gradient-45deg-indigo-purple gradient-shadow sidenav-trigger' data-target='slide-out-right-second'><i class='material-icons'>call</i></a>",
                "orderable": false},
              { "width": "10%" , data: "fecha" },
              { "width": "20%" , data: "brigada"},
              { "width": "20%" , data: "promotor"},
              { "width": "20%" , data: "nombreCompleto"},
              { "width": "10%" , data: "subestado"},
              { "width": "10%" , data: "gestiones"},
              { "width": "10%" , data: "ultimaGestion"},
              { "width": "20%" , data: "gestor"}
            ],
                
        });
}

$.fn.dataTable.ext.errMode = 'none'; 
 
var historial;          
let data;
$('#data-table-simple tbody').on( 'click', 'a', function () {
    data = $('#data-table-simple').DataTable().row( $(this).parents('tr') ).data();
    $("#txtConsecutivo").val(data.consecutivo);
    $('#txtFecha').val(data.fecha);
    $('#txtBrigada').val(data.brigada);
    $('#txtCliente').val(data.nombreCompleto);
    $('#txtPromotor').val(data.promotor);
    $('#txtAbono').val(data.abono);
    $('#txtSaldo').val(data.saldo);
    $('#cmbSubestadoNuevo').val(''); 
    $('#txtObservacion').val('');
    $('#txtNumeroCelular').val(data.celular);
    $('#divError').css("display","none");

    historial = $('#data-table-historial').DataTable();
    prepararTabla();
} );

$('#btnCliente').on('click',function(){
  Clientes.findById(data.idCliente);
});

$('#btnHistorial').on('click',function(){
    prepararTabla(); 
});

function prepararTabla() {
    $("#preloader").fadeIn();
    $("#preloader").fadeOut(1000);
    historial.destroy();
    cargarHistorial();
}

function cargarHistorial(){
  
    historial = $('#data-table-historial').DataTable({
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
        responsive: false,
        ajax: {
              url : `callDealer/${data.id}/historial`,
              dataSrc: ""
          },
        "columns": [
          {
            "className":      'details-control',
            "orderable":      false,
            "defaultContent": ''
          },
          { data: "fecha", "orderable":      false, },
          { data: "subestado", "orderable":      false,}  
        ]

            
    });

}

  function formatoDetallesHistorial( data ) {
      return '<table cellspacing="0" border="0";">'+
          '<tr>'+
              '<td>Observación:</td>'+
              '<td>'+data.observacion+'</td>'+
          '</tr>'+
      '</table>';
  }

  // Add event listener for opening and closing details
  $('#data-table-historial').on('click', 'td.details-control', function () {
      var tr = $(this).closest('tr');
      var row = historial.row( tr );

      if ( row.child.isShown() ) {
          // This row is already open - close it
          row.child.hide();
          tr.removeClass('shown');
      }
      else {
          // Open this row
          row.child( formatoDetallesHistorial(row.data()) ).show();
          tr.addClass('shown');
      }
      
  } ); 
  
  
  //Fin dataTable


  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

$('#cmbSubestadoNuevo').on('change',function(){
  if ($(this).val() == 'GE'){
    $('#divError').css("display","block");
  } else {
    $('#divError').css("display","none");
  }
  $('#cmbError').val('');
});
		
//Nuevo
$('#formCallDealer').on('submit',function(e) {

  let form = $("#formCallDealer");
  form.validate();
  e.preventDefault();

  if (form.valid()) {
    let payload = {'_token': $('#token').val(),
                   subestado:$('#cmbSubestadoNuevo').val(),
                   observacion:$('#txtObservacion').val(),
                   error:$('#cmbError').val(),
                   afiliacion:data.id};
    $("#preloader").fadeIn();
    CallDealerServicio.create(payload)
    .then((respuesta) => {

      if (respuesta.estado == 'OK') {
        alerta('Success','Información del sistema','Registro almacenado exitosamente');
        tabla.ajax.reload();
        $('#cmbSubestadoNuevo').val('');
        $('#txtObservacion').val('');
        $('#cmbError').val('');
        $('#divError').css("display","none");
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

    $("#formCallDealer").validate({
      rules: {
        subestado: "required",
        error: "required",
        observacion: "required"
        },
        //For custom messages
        messages: {
        subestado: "Campo requerido",
        error: "Campo requerido",
        observacion:"Campo requerido"
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
      
/*
    $(".celular").click(function(){
      $.ajax({
          data: {celular: $('#txtCelular').val(), id: $('#txtId').val(), brigada: brigada},
          url: '/clientes/consultarTelefonosDuplicados',
          success: function(respuesta) {
              $('#ulNotificacion').html(respuesta);
              $('#dlgTelefonoNotificacion').modal({opacity: 0});
              $('#dlgTelefonoNotificacion').attr('style','width: max-content;left: auto;right: 20');
              $('#dlgTelefonoNotificacion').modal('open');
              

          }
       });
    })

    function celularDuplicado(){
      $.ajax({
          data: {celular: $('#txtCelular').val(), id: $('#txtId').val(), brigada: brigada},
          url: '/clientes/consultarTelefonosDuplicados',
          success: function(respuesta) {
              if (respuesta == '') {
                $(".celular").css('display','none');
              }
              else
              {
                $(".celular").css('display','block'); 
              }
          }
       });
    }

    $(".telefono").click(function(){
      $.ajax({
          data: {telefono: $('#txtTelefono').val(), id: $('#txtId').val(), brigada: brigada},
          url: '/clientes/consultarTelefonosDuplicados',
          success: function(respuesta) {
              $('#ulNotificacion').html(respuesta);
              $('#dlgTelefonoNotificacion').modal({opacity: 0});
              $('#dlgTelefonoNotificacion').attr('style','width: max-content;left: auto;right: 20');
              $('#dlgTelefonoNotificacion').modal('open');
              

          }
       });
    })

    function telefonoDuplicado(){
      $.ajax({
          data: {telefono: $('#txtTelefono').val(), id: $('#txtId').val(), brigada: brigada},
          url: '/clientes/consultarTelefonosDuplicados',
          success: function(respuesta) {
            if (respuesta == '') {
              $(".telefono").css('display','none');
            }
            else
            {
              $(".telefono").css('display','block'); 
            }  
 
          }
       });
    }

		
	*/
     
	