@extends('principal')

@section('content')

	
			<div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">	
				<div class="container">
					<div class="row">
						<div class="col s10 m6 l6">
							<h5 class="breadcrumbs-title mt-0 mb-0">Maletín</h5>
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
															<label for="cmbGestor">Gestor</label>
															  <select class="error browser-default" id="cmbGestor" name="gestor">
															  </select>
														</div>
																	
														<div class="col s6 m3">
															<label for="txtFechaAfiliacion">Fecha</label>
															<input id="txtFechaAfiliacion" name="fecha" class="datepicker" type="text" placeholder="" autocomplete="off">
														</div>

														<div class="col s9 m3">
															<label for="cmbBrigada">Brigada</label>
															<select class="error browser-default" id="cmbBrigada">
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
									
										<div class="row">
											<div class="col s12">
											  <table id="data-table-simple" class="display nowrap" style="width:100%">
												<thead>
												  <tr>
													<th></th>
													<th>Fecha</th>
													<th>Brigada</th>
													<th>Promotor</th>
													<th>Nombre</th>
													<th>Subestado</th>
													<th>Gestiones</th>
													<th>Última</th>
													<th>Gestor</th>
												  </tr>
												</thead>
												
											  </table>
											</div>
										</div>
										
									</div>
								</div>						
							</div>
						</div>
						
						<!-- START RIGHT SIDEBAR NAV -->
						<aside id="right-sidebar-nav">
							<div id="slide-out-right-second" class="slide-out-right-sidenav sidenav rightside-navigation">
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
		                           				<a href="#gestion" class="active">
		                              				<span>Gestión</span>
		                           				</a>
		                        			</li>
		                        			<li id="btnHistorial" class="tab col s4 p-0">
		                           				<a href="#historial">
		                              				<span>Historial</span>
		                           				</a>
		                        			</li>
		                     			</ul>
									  </div>
								   </div>
								</div>
							 </div>
							 <div class="slide-out-right-second-body">
								<div id="gestion"  class="col s12">
							        	
									<form class="formValidate" id="formCallDealer" method="post">
																							
											<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}"> 	
											<input type="hidden" id="txtNumeroCelular" name="celular">	
											<div class="input-field col s12">
												<label for="txtConsecutivo">Consecutivo</label>
												<input readonly id="txtConsecutivo" name="consecutivo" type="text" placeholder="">
											</div>
										
											<div class="input-field col s12">
												<label for="txtFecha">Fecha</label>
												<input readonly type="text" name="fecha" id="txtFecha" placeholder="">
											</div>
											
											<div class="input-field col s12">
												<label for="txtBrigada">Brigada</label>
												<input readonly type="text" name="brigada" id="txtBrigada" placeholder="">
											</div>

											<div class="input-field col s12">
												<label for="txtPromotor">Promotor</label>
												<input readonly type="text" name="Promotor" id="txtPromotor" placeholder="">
											</div>

											<div class="input-field col s10">
												<label for="txtCliente">Nombre</label>
												<input readonly type="text" name="cliente" id="txtCliente" placeholder="">
											</div>

											<div class="input-field col s2">
												<a id="btnCliente" class="btn-floating btn-small waves-effect waves-light right gradient-45deg-indigo-purple gradient-shadow sidenav-trigger" data-target="slide-out-right">
													<i class="material-icons">person</i>
												</a>
											</div>

											<div class="input-field col s12">
												<label for="txtAbono">Abono</label>
												<input readonly type="text" name="abono" id="txtAbono" placeholder="">
											</div>

											<div class="input-field col s12">
												<label for="txtSaldo">Saldo</label>
												<input readonly type="text" name="saldo" id="txtSaldo" placeholder="">
											</div>

											<div class="col s12">
												<label for="cmbSubestadoNuevo">Subestado</label>
												<select class="error browser-default" id="cmbSubestadoNuevo" name="subestado" data-error=".errorTxt1">
													
												</select>
												<div class="input-field">
													<div class="errorTxt1"></div>
												</div>
											</div>

											<div class="col s12" style="display: none;" id="divError">
												<label for="cmbError">Error</label>
												<select class="error browser-default" id="cmbError" name="error" data-error=".errorTxt2">
													
												</select>
												<div class="input-field">
													<div class="errorTxt2"></div>
												</div>
											</div>

											<div class="input-field col s12">
												<label for="txtObservacion">Observación</label>
												<textarea name="observacion" id="txtObservacion" class="materialize-textarea" maxlength="500" placeholder=""></textarea>
											</div>

											<div class="input-field col s12">
												<button class="btn waves-effect waves-light right submit gradient-45deg-indigo-purple gradient-shadow" type="submit" name="action">Guardar
													<i class="material-icons right">save</i>
												</button>
											</div>
										
									</form>
								</div>	
								<div id="historial" class="col s12">
									<table id="data-table-historial" class="historial display collapsed dtr-inline" style="width: 100%">
										<thead>
											 <tr>
											 	<th></th>
												<th>Fecha</th>
												<th>Subestado</th>
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

			@include('clientes')
		

	<!-- scripts -->
	<script src="app-assets/vendors/data-tables/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="app-assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js" type="text/javascript"></script>
	<script src="js/callDealer.js" type="module"></script>
    <script src="app-assets/js/scripts/data-tables.js" type="text/javascript"></script>

@endsection


