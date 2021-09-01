@extends('principal')

@section('content')

	
			<div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">	
				<div class="container">
					<div class="row">
						<div class="col s10 m6 l6">
							<h5 class="breadcrumbs-title mt-0 mb-0">Afiliaciones</h5>
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
											   
														<div class="col s3">
															<label for="cmbPromotor">Promotor</label>
															  <select class="error browser-default" id="cmbPromotor" name="promotor">
															  </select>
														</div>
																	
														<div class="col s3">
															<label for="txtFecha">Fecha</label>
															<input id="txtFecha" name="fecha" class="datepicker" type="text" placeholder="" autocomplete="off">
														</div>
												
														<div class="input-field col s1">
															<a class="btn-floating btn-medium waves-effect waves-light right gradient-45deg-indigo-purple gradient-shadow" id="btnBuscar"  href="#" data-target="slide-out-right">
																<i class="material-icons">search</i>
															</a>
														</div>
													
													</div>
													
											   </div>
											</li>
										</ul>
									
										<div class="row">
											<div class="col s12">
											  <table id="data-table-simple" class="display nowrap" style="width: 100%">
												<thead>
												  <tr>
													<th>Código</th>
													<th>Fecha</th>
													<th>Brigada</th>
													<th>Promotor</th>
													<th>Nombre</th>
													<th>Celular</th>
													<th>Teléfono</th>
													<th>Abono</th>
													<th>Saldo</th>
												  </tr>
												</thead>
												
											  </table>
											</div>
										</div>

										<div class="row">
											<div class="input-field col s12">
												<button class="btn waves-effect waves-light right gradient-45deg-indigo-purple gradient-shadow" type="button" id="btnImprimir">Imprimir
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
	<script src="js/consultarAfiliaciones.js" type="text/javascript"></script>
    <script src="app-assets/js/scripts/data-tables.js" type="text/javascript"></script>
	
	
@endsection