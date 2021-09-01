/*================================================================================
	Item Name: Materialize - Material Design Admin Template
	Version: 5.0
	Author: PIXINVENT
	Author URL: https://themeforest.net/user/pixinvent/portfolio
================================================================================

NOTE:
------
PLACE HERE YOUR OWN JS CODES AND IF NEEDED.
WE WILL RELEASE FUTURE UPDATES SO IN ORDER TO NOT OVERWRITE YOUR CUSTOM SCRIPT IT'S BETTER LIKE THIS. */
//$(document).ready(function() {	

	//table = $('#data-table-simple').DataTable();
	
	$('#data-table-simple').dataTable({
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
		"columns": [
			{ "width": "5%" },
			{ "width": "15%" },
			{ "width": "20%" },
			{ "width": "20%" },
			{ "width": "20%" },
			{ "width": "20%" }
		]

				
						
	});
	
	$('.btn-row').on('click',function(){
		
	});
	
	function prueba(Fila){
			
		
			var data = $('#data-table-simple').DataTable().row(Fila).data();
			alert(data[0]);
	
	}
	
	
	
	$.fn.dataTable.ext.errMode = 'none';

//} );
		
			
	
		

