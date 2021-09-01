@extends('principal')

@section('content')

	
			<div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">	
				<div class="container">
					<div class="row">
						<div class="col s10 m6 l6">
							<h5 class="breadcrumbs-title mt-0 mb-0">Liquidación</h5>
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
											   
														<div class="col s12 m3">
															<label for="cmbGestor">Promotor</label>
															  <select class="error browser-default" id="cmbPromotor" name="promotor">
															  </select>
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
													<th></th>
													<th>Promotor</th>
													<th>Fecha</th>
													<th>Brigada</th>
													<th>Afiliaciones</th>
													<th>Valor Afiliaciones</th>
													<th>Ganancia Afiliaciones</th>
													<th>Prestamo</th>
													<th>Errores</th>
													<th>Valor errores</th>
												  </tr>
												</thead>
												
											  </table>
											</div>
										</div>

										<div class="row">
											<div class="input-field col s12">
												<button class="btn waves-effect waves-light right gradient-45deg-indigo-purple gradient-shadow sidenav-trigger" type="button" data-target='slide-out-right' id="btnLiquidar">Liquidar
													<i class="material-icons right">note_add</i>
												</button>
											</div>
										</div>
										
									</div>
								</div>						
							</div>
						</div>
						
						<!-- START RIGHT SIDEBAR NAV -->
						<aside id="right-sidebar-nav">
							<div id="slide-out-right" class="slide-out-right-sidenav sidenav rightside-navigation">
						  <div class="row">
							 <div class="slide-out-right-title">
								<div class="col s12 border-bottom-1 pb-0 pt-1">
								   <div class="row">
									  <div class="col s2 pr-0 center">
										 <i class="material-icons vertical-text-middle"><a href="#" class="sidenav-close">clear</a></i>
									  </div>
									  <div class="col s10 pl-0">
									  	<ul class="tabs">
		                        			<li class="tab col s4 p-0">
		                           				<a href="#liquidar" class="active">
		                              				<span>Liquidar</span>
		                           				</a>
		                        			</li>
		                        			<li id="btnErrores" class="tab col s4 p-0">
		                           				<a href="#errores">
		                              				<span>Errores</span>
		                           				</a>
		                        			</li>
		                     			</ul>
									  </div>
								   </div>
								</div>
							 </div>
							 <div class="slide-out-right-body">
								<div id="liquidar" class="col s12">
										
									<form class="formValidate" id="formLiquidacion" method="post">
																							
											{{ csrf_field() }}		
											<div class="input-field col s12">
												<label for="txtPromotor">Promotor</label>
												<input id="txtPromotor" name="promotor" type="hidden">
												<input readonly id="txtNombrePromotor" name="promotorNombre" type="text" placeholder="">
											</div>
										
											<div class="input-field col s12">
												<label for="txtFechaInicio">Fecha inicio</label>
												<input readonly type="text" name="fechaInicio" id="txtFechaInicio" placeholder="">
											</div>
											
											<div class="input-field col s12">
												<label for="txtFechaFin">Fecha fin</label>
												<input readonly type="text" name="fechaFin" id="txtFechaFin" placeholder="">
											</div>

											<div class="input-field col s12">
												<label for="txtAfiliaciones">Afiliaciones</label>
												<input readonly type="number" name="afiliaciones" id="txtAfiliaciones" placeholder="">
											</div>

											<div class="input-field col s12">
												<label for="txtGanancia">Ganancia</label>
												<input readonly type="number" name="ganancia" id="txtGanancia" placeholder="">
											</div>


											<div class="input-field col s12">
												<label for="txtPrestamo">Prestamo</label>
												<input readonly type="number" name="prestamo" id="txtPrestamo" placeholder="">
											</div>

											<div class="col s12">
												<label style="font-size: 20px">Subtotal</label>
												<label id="lblSubtotal" style="font-size: 20px" class="right"></label>
											</div>

											<div class="input-field col s12">
												<label for="txtErrores">Errores</label>
												<input readonly type="number" name="errores" id="txtErrores" placeholder="">
											</div>

											<div class="input-field col s12">
												<label for="txtValorErrores">Valor errores</label>
												<input readonly type="number" name="valorErrores" id="txtValorErrores" placeholder="">
											</div>

											<div class="col s12">
												<label style="font-size: 20px">Total</label>
												<label id="lblTotal" style="font-size: 20px" class="right"></label>
											</div>

											<div class="input-field col s12">
												<button class="btn waves-effect waves-light right submit gradient-45deg-indigo-purple gradient-shadow" type="submit" name="action">Guardar
													<i class="material-icons right">save</i>
												</button>
											</div>

									</form>
										
							   </div>
							   <div id="errores" class="col s12">
								<table id="data-table-errores" class="display nowrap collapsed dtr-inline" style="width: 100%">
									<thead>
										 <tr>
										 	<th></th>
											<th>Fecha</th>
											<th>Consecutivo</th>
											<th>Brigada</th>
										 </tr>
									</thead>		
								</table>
							   </div>

							</div>
						 </div>
					  </div>
					</aside>
					<!-- END RIGHT SIDEBAR NAV -->
						
					</div>	
				</div>
			</div>

	<!-- scripts -->
	<script src="app-assets/vendors/data-tables/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="app-assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js" type="text/javascript"></script>
    <script src="app-assets/vendors/data-tables/js/dataTables.select.min.js" type="text/javascript"></script>
    <script src="app-assets/vendors/data-tables/js/dataTables.buttons.min.js" type="text/javascript"></script>
	<script src="js/liquidacion.js" type="module"></script>
    <script src="app-assets/js/scripts/data-tables.js" type="text/javascript"></script>

@endsection