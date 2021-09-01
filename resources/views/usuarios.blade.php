@extends('principal')

@section('content')

	
			<div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">	
				<div class="container">
					<div class="row">
						<div class="col s10 m6 l6">
							<h5 class="breadcrumbs-title mt-0 mb-0">Usuarios</h5>
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
											  <table id="data-table-simple" class="display nowrap" width="100%">
												<thead>
				 								  <tr>
													<th></th>
													<th></th>
													<th>Código</th>
													<th>Nombre</th>
													<th>Rol</th>
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
										
									<form class="formValidate" id="formUsuarioNuevo" method="post">
																							
											{{ csrf_field() }}		
											<div class="input-field col s12">
												<label for="txtCodigoNuevo">Código</label>
												<input id="txtCodigoNuevo" name="codigo" type="text" data-error=".errorTxt1" maxlength="15" placeholder="">
												<div class="errorTxt1"></div>
											</div>
										
											<div class="input-field col s12">
												<label for="txtNombreNuevo">Nombre</label>
												<input type="text" name="nombre" id="txtNombreNuevo" data-error=".errorTxt2" maxlength="70" placeholder="">
												<div class="errorTxt2"></div>
											</div>

											<div class="input-field col s12">
												<label for="txtCelularNuevo">Celular</label>
												<input type="tel" name="celular" id="txtCelularNuevo" maxlength="10" placeholder="">
											</div>

											<div class="input-field col s12">
												<label for="txtTelefonoNuevo">Teléfono</label>
												<input type="tel" name="telefono" id="txtTelefonoNuevo" maxlength="10" placeholder="">
											</div>

											<div class="input-field col s12">
												<label for="txtEmailNuevo">Email</label>
												<input type="email" name="email" id="txtEmailNuevo" maxlength="50" placeholder="">
											</div>
											
											<div class="col s12">
												<label for="cmbRolNuevo">Rol</label>
												<select class="error browser-default" id="cmbRolNuevo" name="rol" data-error=".errorTxt3">
													
												</select>
												<div class="input-field">
													<div class="errorTxt3"></div>
												</div>
											</div>

											<div class="input-field col s12">
												<label for="txtClaveNuevo">Clave</label>
												<input type="password" name="clave" id="txtClaveNuevo" data-error=".errorTxt4" maxlength="15" placeholder="">
												<div class="errorTxt4"></div>
											</div>

											<div class="input-field col s12">
												<label for="txtRepetirClaveNuevo">Repetir clave</label>
												<input type="password" name="repetirClave" id="txtRepetirClaveNuevo" data-error=".errorTxt5" maxlength="15" placeholder="">
												<div class="errorTxt5"></div>
											</div>
										

											<div class="col s12">
												<label for="cmbEstadoNuevo">Estado</label>
												<select class="error browser-default" id="cmbEstadoNuevo" name="estado" data-error=".errorTxt6">
													<option value="" disabled selected>Seleccione</option>
													<option value="A">Activo</option>
													<option value="I">Inactivo</option>
												</select>
												<div class="input-field">
													<div class="errorTxt6"></div>
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
										
									<form class="formValidate" id="formUsuarioEditar" method="put">
																							
											{{ csrf_field() }}		
											<div class="input-field col s12">
												<label for="txtCodigoEditar">Código</label>
												<input readonly id="txtCodigoEditar" name="codigo" type="text" data-error=".errorTxt10" maxlength="15" placeholder="">
												<div class="errorTxt10"></div>
											</div>
										
											<div class="input-field col s12">
												<label for="txtNombreEditar">Nombre</label>
												<input type="text" name="nombre" id="txtNombreEditar" data-error=".errorTxt11" maxlength="70" placeholder="">
												<div class="errorTxt11"></div>
											</div>

											<div class="input-field col s12">
												<label for="txtCelularEditar">Celular</label>
												<input type="tel" name="celular" id="txtCelularEditar" maxlength="10" placeholder="">
											</div>

											<div class="input-field col s12">
												<label for="txtTelefonoEditar">Teléfono</label>
												<input type="tel" name="telefono" id="txtTelefonoEditar" maxlength="10" placeholder="">
											</div>

											<div class="input-field col s12">
												<label for="txtEmailEditar">Email</label>
												<input type="email" name="email" id="txtEmailEditar" maxlength="50" placeholder="">
											</div>
											
											<div class="col s12">
												<label for="cmbRolEditar">Rol</label>
												<select class="error browser-default" id="cmbRolEditar" name="rol" data-error=".errorTxt12">
													
												</select>
												<div class="input-field">
													<div class="errorTxt12"></div>
												</div>
											</div>

									
											<div class="col s12">
												<label for="cmbEstadoEditar">Estado</label>
												<select class="error browser-default" id="cmbEstadoEditar" name="estado" data-error=".errorTxt13">
													<option value="" disabled selected>Seleccione</option>
													<option value="A">Activo</option>
													<option value="I">Inactivo</option>
												</select>
												<div class="input-field">
													<div class="errorTxt13"></div>
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

			<div id="dlgCambiarClave" class="modal modal-small">
			    <div class="modal-content">
			    	 <a href="#" class="modal-close  waves-light gradient-45deg-indigo-purple gradient-shadow btn btn-floating right"><i class="material-icons right">close</i></a>
			    	 <h5>Cambiar clave</h5>
			    	 
			    	 <form class="formValidate" id="formCambiarClave" method="put">																

			    	 		{{ csrf_field() }}

							<div class="input-field col s12">
								<label for="txtClaveNueva">Clave nueva</label>
								<input type="password" name="claveNueva" id="txtClaveNueva" data-error=".errorTxt21" maxlength="15" placeholder="">
								<div class="errorTxt21"></div>
							</div>

							<div class="input-field col s12">
								<label for="txtRepetirClaveNueva">Repetir clave</label>
								<input type="password" name="repetirClaveNueva" id="txtRepetirClaveNueva" data-error=".errorTxt22" maxlength="15" placeholder="">
								<div class="errorTxt22"></div>
							</div>
						

							<div class="input-field col s12">
								<button class="btn waves-effect waves-light right submit gradient-45deg-indigo-purple gradient-shadow" type="submit" name="action">Guardar
									<i class="material-icons right">save</i>
								</button>
							</div>
						
					</form>
											
				    
			    </div>
		   </div>
		

	<!-- scripts -->
	<script src="app-assets/vendors/data-tables/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="app-assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js" type="text/javascript"></script>
	<script src="js/usuarios.js" type="module"></script>
    <script src="app-assets/js/scripts/data-tables.js" type="text/javascript"></script>

@endsection