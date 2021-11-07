import BrigadaServicio from './service/brigadaServicio.js';
import Ubicacion from "./ubicacion.js";

let provincias = [];
Ubicacion.provincias()
.then((data) => {
  provincias = data;
  mostrarProvincias();
})
.catch((error) => {});

let cantones = [];
Ubicacion.cantones()
.then((data) => {
  cantones = data;
})
.catch((error) => {});

let parroquias = [];
Ubicacion.parroquias()
.then((data) => {
  parroquias = data;
})
.catch((error) => {});

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
                url : "brigadas",
              dataSrc: ""
            },
          "columns": [
            {"defaultContent": "<a class='btn-floating btn-small waves-effect waves-light gradient-45deg-indigo-purple gradient-shadow sidenav-trigger' data-target='slide-out-right-second'><i class='material-icons'>edit</i></a>",
              "orderable": false },
            { "width": "15%" , data: "numero" },
            { "width": "30%" , data: "descripcion"},
            { "width": "15%" , data: "fechaPreventa"},
            { "width": "15%" , data: "fechaInicio"},
            { "width": "15%" , data: "fechaCierre"},
            { "width": "15%" , data: "estadoDescripcion"}
          ],
          "order": [[ 1, "desc" ]]
              
      });  
      

let data;
$('#data-table-simple tbody').on( 'click', 'a', function () {
    data = $('#data-table-simple').DataTable().row( $(this).parents('tr') ).data();
    console.log(data);
    $("#txtNumeroEditar").val(data.numero);
    $('#txtDescripcionEditar').val(data.descripcion);
    $('#txtFechaInicioEditar').val(data.fechaInicio);
    $('#txtHoraInicioEditar').val(data.horaInicio);
    $('#txtFechaFinEditar').val(data.fechaFin);
    $('#txtTelefonosEditar').val(data.telefonos);
    $('#cmbProvinciaEditar').val(data.provincia);
    seleccionarCanton(data.provincia,data.canton);
    seleccionarParroquia(data.canton,data.parroquia);
    $('#txtDireccionEditar').val(data.direccion);
    $('#cmbEstadoEditar').val(data.estado);
    $('#txtDesayunoPromotorEditar').val(data.desayunoPromotor);
    $('#txtAlmuerzoPromotorEditar').val(data.almuerzoPromotor);
    $('#txtCenaPromotorEditar').val(data.cenaPromotor);
    $('#txtHotelPromotorEditar').val(data.hotelPromotor);
    $('#txtTransportePromotorEditar').val(data.transportePromotor);
    $('#txtDesayunoCoordinadorEditar').val(data.desayunoCoordinador);
    $('#txtAlmuerzoCoordinadorEditar').val(data.almuerzoCoordinador);
    $('#txtCenaCoordinadorEditar').val(data.cenaCoordinador);
    $('#txtHotelCoordinadorEditar').val(data.hotelCoordinador);
    $('#txtTransporteCoordinadorEditar').val(data.transporteCoordinador);
    $('#txtOtrosGastosEditar').val(data.otros_gastos_brigada);
    $('#txtDescripcionOtrosGastosEditar').val(data.descripcion_otros_gastos);
} );


$.fn.dataTable.ext.errMode = 'none'; 
//Fin dataTable


$.ajaxSetup({
  headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

//Nuevo
$('#formBrigadaNuevo').on('submit',function(e) {

  var form = $("#formBrigadaNuevo");
  form.validate();
  e.preventDefault();

  if (form.valid()) {
    let data = $('#formBrigadaNuevo').serialize();
    $("#preloader").fadeIn();
    BrigadaServicio.create(data)
    .then((respuesta) => {
      if (respuesta.estado == 'OK') {
        alerta('Success','Información del sistema','Registro almacenado exitosamente');
        tabla.ajax.reload();
        $("#formBrigadaNuevo")[0].reset();
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

$("#formBrigadaNuevo").validate({
  rules: {
    descripcion: "required",
    fechaInicio:"required",
    horaInicio:"required",
    telefonos:"required",
    provincia:"required",
    canton: "required",
    parroquia: "required",
    direccion: "required",
    desayunoPromotor: "required",
    almuerzoPromotor: "required",
    cenaPromotor: "required",
    hotelPromotor: "required",
    transportePromotor: "required",
    desayunoCoordinador: "required",
    almuerzoCoordinador: "required",
    cenaCoordinador: "required",
    hotelCoordinador: "required",
    transporteCoordinador: "required"
    },
    //For custom messages
    messages: {
    descripcion: "Campo requerido",
    fechaInicio:"Campo requerido",
    horaInicio:"Campo requerido",
    telefonos:"Campo requerido",
    provincia:"Campo requerido",
    canton: "Campo requerido",
    parroquia: "Campo requerido",
    direccion: "Campo requerido",
    desayunoPromotor: "Campo requerido",
    almuerzoPromotor: "Campo requerido",
    cenaPromotor: "Campo requerido",
    hotelPromotor: "Campo requerido",
    transportePromotor: "Campo requerido",
    desayunoCoordinador: "Campo requerido",
    almuerzoCoordinador: "Campo requerido",
    cenaCoordinador: "Campo requerido",
    hotelCoordinador: "Campo requerido",
    transporteCoordinador: "Campo requerido"
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
$('#formBrigadaEditar').on('submit',function(e) {

  let form = $("#formBrigadaEditar");
  form.validate();
  e.preventDefault();

  if (form.valid()) {
    let payload = $('#formBrigadaEditar').serialize();
    $("#preloader").fadeIn();
    BrigadaServicio.update(payload, data.numero)
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

  $("#formBrigadaEditar").validate({
  rules: {
    descripcion: "required",
    fechaInicio:"required",
    horaInicio:"required",
    telefonos:"required",
    provincia:"required",
    canton: "required",
    parroquia: "required",
    direccion: "required",
    estado: "required",
    desayunoPromotor: "required",
    almuerzoPromotor: "required",
    cenaPromotor: "required",
    hotelPromotor: "required",
    transportePromotor: "required",
    desayunoCoordinador: "required",
    almuerzoCoordinador: "required",
    cenaCoordinador: "required",
    hotelCoordinador: "required",
    transporteCoordinador: "required"
    },
    //For custom messages
    messages: {
    descripcion: "Campo requerido",
    fechaInicio:"Campo requerido",
    horaInicio:"Campo requerido",
    telefonos:"Campo requerido",
    provincia:"Campo requerido",
    canton: "Campo requerido",
    parroquia: "Campo requerido",
    direccion: "Campo requerido",
    estado: "Campo requerido",
    desayunoPromotor: "Campo requerido",
    almuerzoPromotor: "Campo requerido",
    cenaPromotor: "Campo requerido",
    hotelPromotor: "Campo requerido",
    transportePromotor: "Campo requerido",
    desayunoCoordinador: "Campo requerido",
    almuerzoCoordinador: "Campo requerido",
    cenaCoordinador: "Campo requerido",
    hotelCoordinador: "Campo requerido",
    transporteCoordinador: "Campo requerido"
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

function mostrarProvincias(){
  let select = "<option value=''>Seleccione</option>";
  provincias.map((provincia) => {
    select+= `<option value='${provincia.codigo}'>${provincia.nombre}</option>`;
  })
  $('#cmbProvinciaNuevo').html(select);
  $('#cmbProvinciaEditar').html(select);
} 

$('#cmbProvinciaNuevo').on('change',function(){
  let select = "<option value='' disabled selected>Seleccione</option>";
  Ubicacion.filtroCanton(cantones, $('#cmbProvinciaNuevo').val()).map((canton) => {
    select+= `<option value='${canton.codigo}'>${canton.nombre}</option>`;
  })
  $('#cmbCantonNuevo').html(select);
  $('#cmbParroquiaNuevo').html("<option value='' disabled selected>Seleccione</option>");
})

$('#cmbCantonNuevo').on('change',function(){
  let select = "<option value='' disabled selected>Seleccione</option>";
  Ubicacion.filtroParroquia(parroquias, $('#cmbCantonNuevo').val()).map((parroquia) => {
    select+= `<option value='${parroquia.codigo}'>${parroquia.nombre}</option>`;
  })
  $('#cmbParroquiaNuevo').html(select);
})

$('#cmbProvinciaEditar').on('change',function(){
  let select = "<option value='' disabled selected>Seleccione</option>";
  Ubicacion.filtroCanton(cantones, $('#cmbProvinciaEditar').val()).map((canton) => {
    select+= `<option value='${canton.codigo}'>${canton.nombre}</option>`;
  })
  $('#cmbCantonEditar').html(select);
  $('#cmbParroquiaEditar').html("<option value='' disabled selected>Seleccione</option>");
})

$('#cmbCantonEditar').on('change',function(){
  let select = "<option value='' disabled selected>Seleccione</option>";
  Ubicacion.filtroParroquia(parroquias, $('#cmbCantonEditar').val()).map((parroquia) => {
    select+= `<option value='${parroquia.codigo}'>${parroquia.nombre}</option>`;
  })
  $('#cmbParroquiaEditar').html(select);
})

function seleccionarCanton(provincia, canton){
  let select = "<option value='' disabled>Seleccione</option>";
  Ubicacion.filtroCanton(cantones, provincia).map((item) => {
    if (canton === item.codigo){
      select+= `<option selected value='${item.codigo}'>${item.nombre}</option>`;
    } else {
      select+= `<option value='${item.codigo}'>${item.nombre}</option>`;
    }
  })
  $('#cmbCantonEditar').html(select);
} 

function seleccionarParroquia(canton, parroquia){
  let select = "<option value='' disabled>Seleccione</option>";
  Ubicacion.filtroParroquia(parroquias, canton).map((item) => {
    if (parroquia === item.codigo){
      select+= `<option selected value='${item.codigo}'>${item.nombre}</option>`;
    } else {
      select+= `<option value='${item.codigo}'>${item.nombre}</option>`;
    }
  })
  $('#cmbParroquiaEditar').html(select);
} 