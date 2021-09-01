@extends('principal')

@section('content')

	
			<div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">	
				<div class="container">
					<div class="row">
						<div class="col s10 m6 l6">
							<h5 class="breadcrumbs-title mt-0 mb-0">Reportes de liquidación</h5>
						</div>
					</div>
				</div>
			</div>
			
			<div class="col s12">
				<div class="container">
					<div class="section">
						
						<div class="row">
							<div class="col s12">
								<div id="validations" class="card card-tabs">
									<div class="card-content">
										
										<ul class="collapsible collapsible-accordion" data-collapsible="accordion">
											<li class="active">
											   <div class="collapsible-header"><i class="material-icons">search</i> Búsqueda</div>
											   <div class="collapsible-body" style="padding-top:0;padding-bottom:0;">
											   
													<div class="row">
											   
														<div class="col s6 m3">
															<label for="cmbPromotor">Promotor</label>
															  <select class="error browser-default" id="cmbPromotor" name="promotor">
															  </select>
														</div>
																	
														<div class="col s6 m3">
															<label for="txtFechaInicio">Fecha inicio</label>
															<input id="txtFechaInicio" name="fechaInicio" class="datepicker" type="text" placeholder="" autocomplete="off">
														</div>

														<div class="col s9 m3">
															<label for="txtFechaFin">Fecha fin</label>
															<input id="txtFechaFin" name="fechaFin" class="datepicker" type="text" placeholder="" autocomplete="off">
														</div>
												
														<div class="input-field col s3 m1">
															<a class="btn-floating btn-medium waves-effect waves-light right gradient-45deg-indigo-purple gradient-shadow" id="btnBuscar"  href="#" data-target="slide-out-right">
																<i class="material-icons">search</i>
															</a>
														</div>
													
													</div>
													
											   </div>
											</li>
										</ul>
                                        <input type="hidden" name="_token" id="txtToken" value="{{ csrf_token() }}">
										<div class="row">
											<div class="col s12">
											  <table id="data-table-simple" class="display nowrap" width="100%">
												<thead>
												  <tr>
													<th>Promotor</th>
													<th>Fecha incio</th>
													<th>Fecha fin</th>
													<th>Afiliaciones</th>
													<th>Ganancia</th>
													<th>Prestamo</th>
													<th>Errores</th>
													<th>Valor errores</th>
													<th>Total</th>
												  </tr>
												</thead>
												
											  </table>
											</div>
										</div>

										<div class="row">
											<div class="input-field col s12">
												<button class="btn waves-effect waves-light right gradient-45deg-indigo-purple gradient-shadow" type="button" data-target='slide-out-right' id="btnImprimir">Imprimir
													<i class="material-icons right">print</i>
												</button>
											</div>
										</div>
										
									</div>
								</div>						
							</div>
						</div>
						
					</div>	
				</div>
			</div>

	<!-- scripts -->
	<script src="app-assets/vendors/data-tables/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="app-assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js" type="text/javascript"></script>
	<script src="app-assets/vendors/data-tables/js/dataTables.select.min.js" type="text/javascript"></script>
	<script src="app-assets/vendors/data-tables/js/dataTables.buttons.min.js" type="text/javascript"></script>
    <script src="app-assets/js/custom/jszip.min.js" type="text/javascript"></script>
    <script src="app-assets/js/custom/pdfmake.min.js" type="text/javascript"></script>
    <script src="app-assets/js/custom/vfs_fonts.js" type="text/javascript"></script>
    <script src="app-assets/js/custom/buttons.html5.min.js" type="text/javascript"></script>
	<script src="js/reportesLiquidacion.js" type="module"></script>
    <script src="app-assets/js/scripts/data-tables.js" type="text/javascript"></script>
 
@endsection