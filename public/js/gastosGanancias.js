import UsuarioServicio from './service/usuarioServicio.js';
import BrigadaServicio from './service/brigadaServicio.js';
import GastoGananciaServicio from  './service/gastoGananciaServicio.js';

let promotores = [];
UsuarioServicio.filter('PT')
.then((data)=>{
  promotores = data;
  mostrarPromotores();
})
.catch((error)=>{});

function mostrarPromotores() {
  let select = "<option value='' disabled selected>Seleccione</option>";
  promotores.map((promotor) => {
    select+= `<option value='${promotor.codigo}'>${promotor.nombre}</option>`;
  })
  $('#cmbPromotorNuevo').html(select);
  $('#cmbPromotorEditar').html(select);
}

let prestamo = 0;
let ganancia = 0;  
let oPrestamo = 0;  
let restante = 0;
let prestamoEditar = 0;    
let gananciaEditar = 0;
let oPrestamoEditar = 0;
let brigada;
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
    "scrollX": true,
    "bAutoWidth": true,
    ajax: {
          url : "gastosganancias",
        dataSrc: ""
      },
    "columns": [
      {"defaultContent": "<a class='btn-floating btn-small waves-effect waves-light gradient-45deg-indigo-purple gradient-shadow sidenav-trigger' data-target='slide-out-right-second'><i class='material-icons'>edit</i></a>"},
      { "width": "10%" , data: "id" },
      { "width": "15%" , data: "fecha" },
      { "width": "30%" , data: "nombrePromotor"},
      { "width": "20%" , data: "cantidad"},
      { "width": "20%" , data: "abonos"}
    ],
    columnDefs: [ {
        orderable: false,
        targets:   0
    } ],
        
});  
          
let data;
$('#data-table-simple tbody').on( 'click', 'a', function () {
    data = $('#data-table-simple').DataTable().row( $(this).parents('tr') ).data();
    $("#txtNumeroEditar").val(data.id);
    $("#txtFechaEditar").val(data.fecha);
    $('#txtPromotorEditar').val(data.promotor);
    $('#cmbPromotorEditar').val(data.promotor);
    $('#txtBrigadaEditar').val(data.brigada);
    $('#txtCantidadEditar').val(data.cantidad);
    $('#txtAbonosEditar').val(data.abonos);
    $('#txtValorEditar').val(data.valor);
    $('#txtDesayunoEditar').val(data.desayuno);
    $('#txtAlmuerzoEditar').val(data.almuerzo);
    $('#txtCenaEditar').val(data.cena);
    $('#txtHotelEditar').val(data.hotel);
    $('#txtTransporteEditar').val(data.transporte);
    $('#txtValorGananciaEditar').val(data.gananciaValor);
    $('#txtAlmuerzoGananciaEditar').val(data.gananciaAlmuerzo);
    $('#txtCenaGananciaEditar').val(data.gananciaCena);
    $('#txtTransporteGananciaEditar').val(data.gananciaTransporte);
    $('#txtOtrosPrestamosEditar').val(data.otrosPrestamos);
    oPrestamoEditar = data.otrosPrestamos;
    $('#txtOtrosPrestamosObservacionEditar').val(data.otrosPrestamosObservacion);
    $('#txtPrestamoEditar').val(data.prestamo);
    $('#txtEntregaEditar').val(data.entrega);
    prestamoEditar = data.prestamo;
    gananciaEditar = data.ganancia;
    $('#txtRestanteEditar').val(Math.round(((Number(data.abonos)-Number(prestamoEditar))-Number(gananciaEditar))*100)/100);

    $('#DesayunoEditar').prop('checked',Boolean(Number(data.prestamoDesayuno)));
    $('#DesayunoEditarHidden').prop('checked',Boolean(Number(data.prestamoDesayuno)));
    $('#AlmuerzoEditar').prop('checked',Boolean(Number(data.prestamoAlmuerzo)));
    $('#CenaEditar').prop('checked',Boolean(Number(data.prestamoCena)));
    $('#HotelEditar').prop('checked',Boolean(Number(data.prestamoHotel)));
    $('#HotelEditarHidden').prop('checked',Boolean(Number(data.prestamoHotel)));
    $('#TransporteEditar').prop('checked',Boolean(Number(data.prestamoTransporte)));

    $('#DesayunoEditar').attr('disabled',true)
    $('#AlmuerzoEditar').attr('disabled',Boolean(Number(data.gananciaAlmuerzo)))
    $('#CenaEditar').attr('disabled',Boolean(Number(data.gananciaCena)));
    $('#HotelEditar').attr('disabled',true);
    $('#TransporteEditar').attr('disabled',Boolean(Number(data.gananciaTransporte)));

    brigada = data.brigada;
    const param = `promotor=${data.promotor}&fecha=${data.fecha}`;
    consultarBrigadas(param);
} );
  
  
  $.fn.dataTable.ext.errMode = 'none'; 
  //Fin dataTable


$.ajaxSetup({
  headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

$('#btnNuevo').on('click',function(){
  $("#formGastosGananciasNuevo")[0].reset();
  $('#DesayunoNuevo').attr('disabled',false)
  $('#AlmuerzoNuevo').attr('disabled',false)
  $('#CenaNuevo').attr('disabled',false);
  $('#HotelNuevo').attr('disabled',false);
  $('#TransporteNuevo').attr('disabled',false);
  prestamo = 0;
  ganancia = 0;    
  restante = 0;
  oPrestamo = 0;
  restablecerLabel();
  let select = "<option value='' disabled selected>Seleccione</option>";
  $('#cmbBrigadaNuevo').html(select);

})

//Nuevo
$('#formGastosGananciasNuevo').on('submit',function(e) {

  let form = $("#formGastosGananciasNuevo");
  form.validate();
  e.preventDefault();

  if (form.valid()) {
    let data = $('#formGastosGananciasNuevo').serialize();
    $("#preloader").fadeIn();
    GastoGananciaServicio.create(data)
    .then((respuesta) => {
      if (respuesta.estado == 'OK') {
        alerta('Success','Información del sistema','Registro almacenado exitosamente');
        tabla.ajax.reload();
        $("#formGastosGananciasNuevo")[0].reset();
        $('#DesayunoNuevo').attr('disabled',false)
        $('#AlmuerzoNuevo').attr('disabled',false)
        $('#CenaNuevo').attr('disabled',false);
        $('#HotelNuevo').attr('disabled',false);
        $('#TransporteNuevo').attr('disabled',false);
        prestamo = 0;
        ganancia = 0;    
        restante = 0;
        oPrestamo = 0;
        restablecerLabel();
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
   

$("#formGastosGananciasNuevo").validate({
    rules: {
      fecha: "required",
      promotor:"required",
      brigada:"required",
      cantidad:"required",
      valor:"required",
      desayuno:"required",
      almuerzo: "required",
      cena: "required",
      hotel: "required",
      transporte: "required",
      prestamo: "required",
      ganancia: "required",
      entrega: "required"
      },
      //For custom messages
      messages: {
      fecha: "Campo requerido",
      promotor:"Campo requerido",
      brigada:"Campo requerido",
      cantidad:"Campo requerido",
      valor:"Campo requerido",
      desayuno:"Campo requerido",
      almuerzo: "Campo requerido",
      cena: "Campo requerido",
      hotel: "Campo requerido",
      transporte: "Campo requerido",
      prestamo: "Campo requerido",
      ganancia: "Campo requerido",
      entrega: "Campo requerido"
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
$('#formGastosGananciasEditar').on('submit',function(e) {

  let form = $("#formGastosGananciasEditar");
  form.validate();
  e.preventDefault();

  if (form.valid()) {
    let payload = $('#formGastosGananciasEditar').serialize();
    $("#preloader").fadeIn();
    GastoGananciaServicio.update(payload,data.id)
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


$("#formGastosGananciasEditar").validate({
    rules: {
      fecha: "required",
      promotor:"required",
      brigada:"required",
      cantidad:"required",
      valor:"required",
      almuerzo: "required",
      cena: "required",
      hotel: "required",
      transporte: "required",
      prestamo: "required",
      ganancia: "required",
      entrega: "required"
      },
      //For custom messages
      messages: {
      fecha: "Campo requerido",
      promotor:"Campo requerido",
      brigada:"Campo requerido",
      cantidad:"Campo requerido",
      valor:"Campo requerido",
      almuerzo: "Campo requerido",
      cena: "Campo requerido",
      hotel: "Campo requerido",
      transporte: "Campo requerido",
      prestamo: "Campo requerido",
      ganancia: "Campo requerido",
      entrega: "Campo requerido"
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
    
let brigadas = [];
function mostrarBrigadas() {
  let select = "<option value='' disabled selected>Seleccione</option>";
  brigadas.map((brigada) => {
    select+= `<option value='${brigada.id}'>${brigada.descripcion}</option>`;
  })
  $('#cmbBrigadaNuevo').html(select);
  $('#cmbBrigadaEditar').html(select);
  if (brigada){
    seleccionarBrigada();
  }
}

function consultarBrigadas(queryParam){
  BrigadaServicio.getBridasAfiliacion(queryParam)
  .then((data) => {
    brigadas = data;
    mostrarBrigadas();
  })
  .catch((error) => {})
}

$('#txtFechaNuevo, #cmbPromotorNuevo').on('change',function() {
    $('#cmbBrigadaNuevo').html("<option value='' disabled selected>Seleccione</option>");
    if ($('#txtFechaNuevo').val() != '') {
      if ($('#cmbPromotorNuevo').val() != null) {
        const param = `promotor=${$('#cmbPromotorNuevo').val()}&fecha=${$('#txtFechaNuevo').val()}`;
        consultarBrigadas(param);
      }
    }
});

$('#txtFechaNuevo, #cmbPromotorNuevo, #cmbBrigadaNuevo').on('change',function() {
  $('#txtCantidadNuevo').val('');
  $('#txtValorNuevo').val('');
  $('#txtDesayunoNuevo').val('');
  $('#txtAlmuerzoNuevo').val('');
  $('#txtCenaNuevo').val('');
  $('#txtHotelNuevo').val('');
  $('#txtTransporteNuevo').val('');
  $('#txtPrestamoNuevo').val('');
  $('#txtGananciaNuevo').val('');
  $('#txtEntregaNuevo').val('');
  if ($('#txtFechaNuevo').val() != '') {
    if ($('#cmbPromotorNuevo').val() != null) {
      if ($('#cmbBrigadaNuevo').val() != null) {
        const param = `promotor=${$('#cmbPromotorNuevo').val()}&fecha=${$('#txtFechaNuevo').val()}&brigada=${$('#cmbBrigadaNuevo').val()}`;
        $("#preloader").fadeIn();
        GastoGananciaServicio.getConfiguracion(param)
        .then((respuesta) => {
            $('#txtCantidadNuevo').val(respuesta.cantidad);
            $('#txtAbonosNuevo').val(respuesta.abonos);
            $('#txtValorNuevo').val(respuesta.valor);
            $('#txtValorGananciaNuevo').val(respuesta.valor * respuesta.cantidad);
            $('#txtDesayunoNuevo').val(respuesta.desayuno);
            $('#txtAlmuerzoNuevo').val(respuesta.almuerzo);
            $('#txtCenaNuevo').val(respuesta.cena);
            $('#txtHotelNuevo').val(respuesta.hotel);
            $('#txtTransporteNuevo').val(respuesta.transporte);
            $('#txtAlmuerzoGananciaNuevo').val(respuesta.gananciaAlmuerzo);
            $('#txtCenaGananciaNuevo').val(respuesta.gananciaCena);
            $('#txtTransporteGananciaNuevo').val(respuesta.gananciaTransporte);
            $('#txtOtrosPrestamosNuevo').val('');
            $('#txtOtrosPrestamosObservacionNuevo').val('');
            $('#txtEntregaNuevo').val('');
            $('#txtPrestamoNuevo').val(respuesta.prestamo);
            prestamo = respuesta.prestamo;
            ganancia = respuesta.ganancia;
            $('#txtRestanteNuevo').val(Math.round(((Number(respuesta.abonos)-Number(prestamo))-Number(respuesta.ganancia))*100)/100);

            $('#DesayunoNuevo').prop('checked',!Boolean(Number(respuesta.aplicaDesayuno)));
            $('#DesayunoNuevoHidden').prop('checked',!Boolean(Number(respuesta.aplicaDesayuno)));
            $('#AlmuerzoNuevo').prop('checked',!Boolean(Number(respuesta.aplicaAlmuerzo)));
            $('#CenaNuevo').prop('checked',!Boolean(Number(respuesta.aplicaCena)));
            $('#HotelNuevo').prop('checked',!Boolean(Number(respuesta.aplicaHotel)));
            $('#HotelNuevoHidden').prop('checked',!Boolean(Number(respuesta.aplicaHotel)));
            $('#TransporteNuevo').prop('checked',!Boolean(Number(respuesta.aplicaTransporte)));

            $('#DesayunoNuevo').attr('disabled',true)
            $('#AlmuerzoNuevo').attr('disabled',Boolean(Number(respuesta.aplicaAlmuerzo)))
            $('#CenaNuevo').attr('disabled',Boolean(Number(respuesta.aplicaCena)));
            $('#HotelNuevo').attr('disabled',true);
            $('#TransporteNuevo').attr('disabled',Boolean(Number(respuesta.aplicaTransporte)));

            $("#preloader").fadeOut();
        })
        .catch((error) => {
            alerta('Error','Iconvenientes consultado Información de gastos:',error.responseText);
            $("#preloader").fadeOut();
        })
      }
    }
  }
});
    
$('#txtOtrosPrestamosNuevo').on('blur',function(){
  prestamo = Math.round((Number(prestamo) - Number(oPrestamo))*100)/100;
  prestamo = Math.round((Number(prestamo) + Number($(this).val()))*100)/100;
  oPrestamo = Number($(this).val());
  $('#txtPrestamoNuevo').val(prestamo);
  $('#txtRestanteNuevo').val(Math.round(((Number($('#txtAbonosNuevo').val()) - Number(prestamo))-ganancia)*100)/100);
})

$('#AlmuerzoNuevo, #CenaNuevo, #TransporteNuevo').on('change',function(){
      
      if ($(this).prop('checked')) {
          prestamo = Math.round((Number(prestamo) + Number($('#txt' + $(this).attr('id')).val()))*100)/100;
          $('#txtPrestamoNuevo').val(prestamo);
          $('#txtRestanteNuevo').val(Math.round(((Number($('#txtAbonosNuevo').val()) - Number(prestamo))-ganancia)*100)/100);
      } else {
          prestamo = Math.round((Number(prestamo) - Number($('#txt' + $(this).attr('id')).val()))*100)/100;
          $('#txtPrestamoNuevo').val(prestamo);
          $('#txtRestanteNuevo').val(Math.round(((Number($('#txtAbonosNuevo').val()) - Number(prestamo))-ganancia)*100)/100);
      }
      
});
      
     //Información adicional editar
function seleccionarBrigada(){
  let select = "<option value='' disabled>Seleccione</option>";
  brigadas.map((item) => {
    if (brigada === item.id){
      select+= `<option selected value='${item.id}'>${item.descripcion}</option>`;
    } else {
      select+= `<option value='${item.id}'>${item.descripcion}</option>`;
    }
  })
  $('#cmbBrigadaEditar').html(select);
  brigada = null;
}

    
     /*
    $('#txtFechaEditar, #cmbPromotorEditar, #cmbBrigadaEditar').on('change',function() {
      $('#txtCantidadEditar').val('');
      $('#txtValorEditar').val('');
      $('#txtAlmuerzoEditar').val('');
      $('#txtCenaEditar').val('');
      $('#txtHotelEditar').val('');
      $('#txtTransporteEditar').val('');
      $('#txtValorGananciaEditar').val('');
      $('#txtAlmuerzoGananciaEditar').val('');
      $('#txtCenaGananciaEditar').val('');
      $('#txtHotelGananciaEditar').val('');
      $('#txtTransporteGananciaEditar').val('');
      $('#txtPrestamoEditar').val('');
      $('#txtGananciaEditar').val('');

      $('#AlmuerzoEditar').prop('checked',false);
      $('#CenaEditar').prop('checked',false);
      $('#HotelEditar').prop('checked',false);
      $('#TransporteEditar').prop('checked',false);

      $('#AlmuerzoEditar').attr('disabled',false)
      $('#CenaEditar').attr('disabled',false);
      $('#HotelEditar').attr('disabled',false);
      $('#TransporteEditar').attr('disabled',false);

      if ($('#txtFechaEditar').val() != '') {
        if ($('#cmbPromotorEditar').val() != null) {
          if ($('#cmbBrigadaEditar').val() != null) {
            $.ajax({
              data: $('#formGastosGananciasEditar').serialize(),
              url: '/gastosGanancias/obtenerInformacion',
              type: 'get',
              dataType: 'JSON',
              beforeSend: function() {
                  $("#preloader").fadeIn();
              }, 
              success: function(respuesta) { 

                $('#txtCantidadEditar').val(respuesta.cantidad);
                $('#txtValorEditar').val(respuesta.valor);
                $('#txtValorGananciaEditar').val(respuesta.valor * respuesta.cantidad);
                $('#txtAlmuerzoEditar').val(respuesta.almuerzo);
                $('#txtCenaEditar').val(respuesta.cena);
                $('#txtHotelEditar').val(respuesta.hotel);
                $('#txtTransporteEditar').val(respuesta.transporte);
                $('#txtAlmuerzoGananciaEditar').val(respuesta.gananciaAlmuerzo);
                $('#txtCenaGananciaEditar').val(respuesta.gananciaCena);
                $('#txtHotelGananciaEditar').val(respuesta.gananciaHotel);
                $('#txtTransporteGananciaEditar').val(respuesta.gananciaTransporte);
                $('#txtPrestamoEditar').val(respuesta.prestamo);
                prestamoEditar = respuesta.prestamo;
                gananciaEditar = respuesta.ganancia;
                $('#txtGananciaEditar').val(gananciaEditar - prestamoEditar);

                $('#AlmuerzoEditar').prop('checked',!Boolean(Number(respuesta.aplicaAlmuerzo)));
                $('#CenaEditar').prop('checked',!Boolean(Number(respuesta.aplicaCena)));
                $('#HotelEditar').prop('checked',!Boolean(Number(respuesta.aplicaHotel)));
                $('#TransporteEditar').prop('checked',!Boolean(Number(respuesta.aplicaTransporte)));

                $('#AlmuerzoEditar').attr('disabled',Boolean(Number(respuesta.aplicaAlmuerzo)))
                $('#CenaEditar').attr('disabled',Boolean(Number(respuesta.aplicaCena)));
                $('#HotelEditar').attr('disabled',Boolean(Number(respuesta.aplicaHotel)));
                $('#TransporteEditar').attr('disabled',Boolean(Number(respuesta.aplicaTransporte)));

                $("#preloader").fadeOut();
                 
              },
              error: function(jqXHR) { 
                alerta('Error','Iconvenientes consultado Información de gastos:',jqXHR.responseText);
                $("#preloader").fadeOut();
              }
            });
          }
        }
      }
    });
    */
   
    $('#txtOtrosPrestamosEditar').on('blur',function(){
      prestamoEditar = Math.round((Number(prestamoEditar) - Number(oPrestamoEditar))*100)/100;
      prestamoEditar = Math.round((Number(prestamoEditar) + Number($(this).val()))*100)/100;
      oPrestamoEditar = Number($(this).val());
      $('#txtPrestamoEditar').val(prestamoEditar);
      $('#txtRestanteEditar').val(Math.round(((Number($('#txtAbonosEditar').val()) - Number(prestamoEditar))-gananciaEditar)*100)/100);
    })

     $('#AlmuerzoEditar, #CenaEditar, #TransporteEditar').on('change',function(){
            
            if ($(this).prop('checked')) {
                prestamoEditar = Math.round((Number(prestamoEditar) + Number($('#txt' + $(this).attr('id')).val()))*100)/100;
                $('#txtPrestamoEditar').val(prestamoEditar);
                $('#txtRestanteEditar').val(Math.round(((Number($('#txtAbonosEditar').val()) - Number(prestamoEditar))-gananciaEditar)*100)/100);
            } else {
                prestamoEditar = Math.round((Number(prestamoEditar) - Number($('#txt' + $(this).attr('id')).val()))*100)/100;
                $('#txtPrestamoEditar').val(prestamoEditar);
                $('#txtRestanteEditar').val(Math.round(((Number($('#txtAbonosEditar').val()) - Number(prestamoEditar))-gananciaEditar)*100)/100);
            }
            
      });

     
    function restablecerLabel(){
        $('label').attr('class','active');
    }
     

    
    
 