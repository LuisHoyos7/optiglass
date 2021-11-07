import UsuarioServicio from './service/usuarioServicio.js';
import BrigadaServicio from './service/brigadaServicio.js';
import SubestadoServicio from './service/subestadoServicio.js';
import Clientes from './clientes.js';
import AfiliacionServicio from './service/afiliacionServicio.js';

let promotores = [];
UsuarioServicio.filter('PT')
.then((data)=>{
  promotores = data;
  mostrarPromotores();
})
.catch((error)=>{});

let brigadas = [];
BrigadaServicio.filter('P')
.then((data)=>{
  brigadas = data;
  mostrarBrigadas();
})
.catch((error)=>{});

let subestados = [];
SubestadoServicio.filter('RE')
.then((data)=>{
  subestados = data;
  mostrarSubestados();
})
.catch((error)=>{});

function mostrarPromotores() {
  let select = "<option value=''>Seleccione</option>";
  promotores.map((promotor) => {
    select+= `<option value='${promotor.codigo}'>${promotor.nombre}</option>`;
  })
  $('#cmbPromotor').html(select); 
}

function mostrarBrigadas() {
  let select = "<option value=''>Seleccione</option>";
  brigadas.map((brigada) => {
    select+= `<option value='${brigada.id}'>${brigada.descripcion}</option>`;
  })
  $('#cmbBrigada').html(select);
}

function mostrarSubestados() {
  let select = "<option value=''>Seleccione</option>";
  subestados.map((subestado) => {
    select+= `<option value='${subestado.codigo}'>${subestado.descripcion}</option>`;
  })
  $('#cmbSubestado').html(select);
  $('#cmbSubestadoEditar').html(select);
}

cargarAfiliaciones();
function queryParam() {
  const promotor = $('#cmbPromotor').val() != null ? $('#cmbPromotor').val() : '';
  const brigada = $('#cmbBrigada').val() != null ?  $('#cmbBrigada').val() : '';
  return `promotor=${promotor}&brigada=${brigada}&estadobrigada=P`;
}
//Inicio dataTable
var tabla = $('#data-table-simple').DataTable();
function cargarAfiliaciones() {
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
            "dom": "Brtip",
            "bAutoWidth": true,
            "scrollX": true,
            ajax: {
                  url : `afiliaciones?${queryParam()}`,
                dataSrc: ""
              },
            "columns": [
              {
                  className: "select-checkbox",
                  "orderable": false

              },
              {"defaultContent": "<a class='btn-floating btn-small waves-effect waves-light gradient-45deg-indigo-purple gradient-shadow sidenav-trigger' data-target='slide-out-right-second'><i class='material-icons'>edit</i></a>",
                "orderable": false},
              { data: "brigada" },
              { data: "promotor" },
              { data: "afiliaciones" },
              { data: "abonos" },
              { data: "prestamo"},
              { data: "entrega"}
            ],
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
                },
                {
                    extend: 'excel',
                    title: 'AFILIACIONES',
                    exportOptions: {
                        columns: [ 2, 3, 4, 5, 6, 7, 8, 9, 10, 11 ]
                    }
                },
                {
                    extend: 'pdf',
                    title: 'AFILIACIONES',
                    orientation: 'landscape',
                    exportOptions: {
                        columns: [ 2, 3, 4, 5, 6, 7, 8, 9, 10, 11 ]
                    }
                }
            ]
                
        });  

}

$('#btnDefinir').click(function(){
    if(tabla.rows( { selected: true } ).count() > 0) {
      $('#dlgDefinicion').modal('open');
    }
});  

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
    $('#cmbSubestadoEditar').val(data.subestado);
    $('#txtObservacionEditar').val(data.observacion); 
    $('#txtNumeroCelular').val(data.celular);
} );
  
  
  $.fn.dataTable.ext.errMode = 'none'; 
  //Fin dataTable

$('#btnBuscar').click(function(){
    tabla.destroy();
    cargarAfiliaciones();    
});

$('#btnCliente').on('click',function(){
  Clientes.findById(data.idCliente);
});

$('#formDefinicion').on('submit',function(e) {
  
  let form = $("#formDefinicion");
  form.validate();
  e.preventDefault();

  if (form.valid()) {
    let datos = {};
    tabla.rows({ selected: true }).every(function(index){
      datos[index] = this.data(); 
    });
    let afiliaciones = Object.keys(datos).map((key) => datos[key].id );
    let data = {'_token': $('#token').val(),
                subestado:$('#cmbSubestado').val(),
                observacion:$('#txtObservacion').val(),
                afiliaciones:JSON.stringify(afiliaciones)};
        
    $("#preloader").fadeIn();            
    AfiliacionServicio.updateLote(data)
    .then((respuesta) => {

      if (respuesta.estado == 'OK') {
        alerta('Success','Información del sistema','Registro editado exitosamente');
        tabla.ajax.reload();
        $("#formDefinicion")[0].reset();
        $('label').attr('class','active');
        $('#dlgDefinicion').modal('close');
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

$("#formDefinicion").validate({
    rules: {
      subestado: "required",
      observacion: "required"
      },
      //For custom messages
      messages: {
      subestado: "Campo requerido",
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
		

//Guardar
$('#formRevision').on('submit',function(e) {

  let form = $("#formRevision");
  form.validate();
  e.preventDefault();

  if (form.valid()) {
    let payload = $('#formRevision').serialize();
    $("#preloader").fadeIn();
    AfiliacionServicio.update(payload, data.id)
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

$("#formRevision").validate({
    rules: {
      subestado: "required",
      observacion: "required"
      },
      //For custom messages
      messages: {
      subestado: "Campo requerido",
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

     
	