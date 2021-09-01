@extends('principal')

@section('content')

	
			<div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">	
				<div class="container">
					<div class="row">
						<div class="col s10 m6 l6">
							<h5 class="breadcrumbs-title mt-0 mb-0">Errores</h5>
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
									
										<div class="row">
											<div class="col s12">
											  <table id="data-table-simple" class="display" width="100%">
												<thead>
												  <tr>
													<th></th>
													<th>Número</th>
													<th>Descripción</th>
													<th>Descuento</th>
													<th>Estado</th>
												  </tr>
												</thead>
												
											  </table>
											</div>
										</div>

										<div class="row">
											<div class="input-field col s12">
												<button class="btn waves-effect waves-light right gradient-45deg-indigo-purple gradient-shadow sidenav-trigger" data-target="slide-out-right" type="button">Nuevo
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
										 <h5>Nuevo</h5>
									  </div>
								   </div>
								</div>
							 </div>
							 <div class="slide-out-right-body">
								<div class="col s12">
										
									<form class="formValidate" id="formErroresNuevo" method="post">
																							
											{{ csrf_field() }}		
											<div class="input-field col s12">
												<label for="txtDescripcionNuevo">Descripción</label>
												<input id="txtDescripcionNuevo" name="descripcion" type="text" maxlength="100" data-error=".errorTxt1" placeholder="">
												<div class="errorTxt1"></div>
											</div>

											<div class="input-field col s12">
												<label for="txtDescuentoNuevo">Descuento</label>
												<input id="txtDescuentoNuevo" name="descuento" type="number" maxlength="10" data-error=".errorTxt2" placeholder="">
												<div class="errorTxt2"></div>
											</div>
										
										
											<div class="col s12">
												<label for="cmbEstadoNuevo">Estado</label>
												<select class="error browser-default" id="cmbEstadoNuevo" name="estado" data-error=".errorTxt3">
													<option value="" disabled selected>Seleccione</option>
													<option value="A">Activo</option>
													<option value="I">Inactivo</option>
												</select>
												<div class="input-field">
													<div class="errorTxt3"></div>
												</div>
											</div>


											<div class="input-field col s12">
												<button class="btn waves-effect waves-light right submit gradient-45deg-indigo-purple gradient-shadow" type="submit" name="action">Guardar
													<i class="material-icons right">save</i>
												</button>
											</div>
										
									</form>
										
							   </div>
							</div>
						 </div>
					  </div>
					</aside>
					<!-- END RIGHT SIDEBAR NAV -->

					<!-- START RIGHT SIDEBAR NAV -->
						<aside id="right-sidebar-nav-">
							<div id="slide-out-right-second" class="slide-out-right-sidenav sidenav rightside-navigation">
						  <div class="row">
							 <div class="slide-out-right-title">
								<div class="col s12 border-bottom-1 pb-0 pt-1">
								   <div class="row">
									  <div class="col s2 pr-0 center">
										 <i class="material-icons vertical-text-middle"><a href="#" class="sidenav-close">clear</a></i>
									  </div>
									  <div class="col s10 pl-0">
										 <h5>Editar</h5>
									  </div>
								   </div>
								</div>
							 </div>
							 <div class="slide-out-right-second-body">
								<div class="col s12">
										
									<form class="formValidate" id="formErroresEditar" method="post">
																							
											{{ csrf_field() }}		
											<div class="input-field col s12">
												<label for="txtNumeroEditar">Número</label>
												<input readonly id="txtNumeroEditar" name="numero" type="text" data-error=".errorTxt4" placeholder="">
												<div class="errorTxt4"></div>
											</div>

											<div class="input-field col s12">
												<label for="txtDescripcionEditar">Descripción</label>
												<input id="txtDescripcionEditar" name="descripcion" type="text" maxlength="200" data-error=".errorTxt5" placeholder="">
												<div class="errorTxt5"></div>
											</div>

											<div class="input-field col s12">
												<label for="txtDescuentoEditar">Descuento</label>
												<input id="txtDescuentoEditar" name="descuento" type="number" maxlength="10" data-error=".errorTxt6" placeholder="">
												<div class="errorTxt6"></div>
											</div>
										
										
											<div class="col s12">
												<label for="cmbEstadoEditar">Estado</label>
												<select class="error browser-default" id="cmbEstadoEditar" name="estado" data-error=".errorTxt7">
													<option value="" disabled selected>Seleccione</option>
													<option value="A">Activo</option>
													<option value="I">Inactivo</option>
												</select>
												<div class="input-field">
													<div class="errorTxt7"></div>
												</div>
											</div>

											<div class="input-field col s12">
												<button class="btn waves-effect waves-light right submit gradient-45deg-indigo-purple gradient-shadow" type="submit" name="action">Guardar
													<i class="material-icons right">save</i>
												</button>
											</div>
										
									</form>
										
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
	<script src="js/errores.js" type="text/javascript"></script>
    <script src="app-assets/js/scripts/data-tables.js" type="text/javascript"></script>
	

@endsection