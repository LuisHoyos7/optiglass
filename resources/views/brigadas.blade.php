@extends('principal')

@section('content')

	
			<div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">	
				<div class="container">
					<div class="row">
						<div class="col s10 m6 l6">
							<h5 class="breadcrumbs-title mt-0 mb-0">Brigadas</h5>
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
													<th>Número</th>
													<th>Descripción</th>
													<th>Fecha preventa</th>
													<th>Fecha inicio</th>
													<th>Fecha cierre</th>
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
										
									<form class="formValidate" id="formBrigadaNuevo" method="post">
																							
											{{ csrf_field() }}		
											<div class="input-field col s12">
												<label for="txtDescripcionNuevo">Descripción</label>
												<input id="txtDescripcionNuevo" name="descripcion" type="text" maxlength="100" data-error=".errorTxt1" placeholder="">
												<div class="errorTxt1"></div>
											</div>
										
											<div class="input-field col s12">
												<label for="txtFechaInicioNuevo">Fecha inicio</label>
												<input type="text" name="fechaInicio" id="txtFechaInicioNuevo" class="datepicker" data-error=".errorTxt2" placeholder="">
												<div class="errorTxt2"></div>
											</div>	

											<div class="input-field col s12">
												<label for="txtHoraInicioNuevo">Hora inicio</label>
												<input type="text" name="horaInicio" id="txtHoraInicioNuevo" class="timepicker" placeholder="">
											</div>	

											<div class="input-field col s12">
												<label for="txtTelefonosNuevo">Teléfonos</label>
												<input type="text" name="telefonos" id="txtTelefonosNuevo" data-error=".errorTxt3" maxlength="50" placeholder="">
												<div class="errorTxt3"></div>
											</div>
											
											<div class="col s12">
												<label for="cmbProvinciaNuevo">Provincia</label>
												<select class="error browser-default" id="cmbProvinciaNuevo" name="provincia" data-error=".errorTxt4">
													
												</select>
												<div class="input-field">
													<div class="errorTxt4"></div>
												</div>
											</div>
											
											<div class="col s12">
												<label for="cmbCantonNuevo">Cantón</label>
												<select class="error browser-default" id="cmbCantonNuevo" name="canton" data-error=".errorTxt5">
													
												</select>
												<div class="input-field">
													<div class="errorTxt5"></div>
												</div>
											</div>
											
											<div class="col s12">
												<label for="cmbParroquiaNuevo">Parroquia</label>
												<select class="error browser-default" id="cmbParroquiaNuevo" name="parroquia" data-error=".errorTxt6">
													
												</select>
												<div class="input-field">
													<div class="errorTxt6"></div>
												</div>
											</div>
											

											<div class="input-field col s12">
												<label for="txtDireccionNuevo">Dirección</label>
												<input id="txtDireccionNuevo" name="direccion" type="text" maxlength="100" data-error=".errorTxt7" placeholder="">
												<div class="errorTxt7"></div>
											</div>

											<p>Gastos promotor</p>
											
											<div class="input-field col s12">
												<label for="txtDesayunoPromotorNuevo">Desayuno</label>
												<input id="txtDesayunoPromotorNuevo" name="desayunoPromotor" type="number" placeholder="$" maxlength="10" data-error=".errorTxt9">
												<div class="errorTxt9"></div>
											</div>

											<div class="input-field col s12">
												<label for="txtAlmuerzoPromotorNuevo">Almuerzo</label>
												<input id="txtAlmuerzoPromotorNuevo" name="almuerzoPromotor" type="number" placeholder="$" maxlength="10" data-error=".errorTxt10">
												<div class="errorTxt10"></div>
											</div>

											<div class="input-field col s12">
												<label for="txtCenaPromotorNuevo">Cena</label>
												<input id="txtCenaPromotorNuevo" name="cenaPromotor" type="number" placeholder="$" maxlength="10" data-error=".errorTxt11">
												<div class="errorTxt11"></div>
											</div>

											<div class="input-field col s12">
												<label for="txtHotelPromotorNuevo">Hotel</label>
												<input id="txtHotelPromotorNuevo" name="hotelPromotor" type="number" placeholder="$" maxlength="10" data-error=".errorTxt12">
												<div class="errorTxt12"></div>
											</div>

											<div class="input-field col s12">
												<label for="txtTransportePromotorNuevo">Transporte</label>
												<input id="txtTransportePromotorNuevo" name="transportePromotor" type="number" placeholder="$" maxlength="10" data-error=".errorTxt13">
												<div class="errorTxt13"></div>
											</div>

											<p>Gastos coordinador</p>
											
											<div class="input-field col s12">
												<label for="txtDesayunoCoordinadorNuevo">Desayuno</label>
												<input id="txtDesayunoCoordinadorNuevo" name="desayunoCoordinador" type="number" placeholder="$" maxlength="10" data-error=".errorTxt14">
												<div class="errorTxt14"></div>
											</div>

											<div class="input-field col s12">
												<label for="txtAlmuerzoCoordinadorNuevo">Almuerzo</label>
												<input id="txtAlmuerzoCoordinadorNuevo" name="almuerzoCoordinador" type="number" placeholder="$" maxlength="10" data-error=".errorTxt15">
												<div class="errorTxt15"></div>
											</div>

											<div class="input-field col s12">
												<label for="txtCenaCoordinadorNuevo">Cena</label>
												<input id="txtCenaCoordinadorNuevo" name="cenaCoordinador" type="number" placeholder="$" maxlength="10" data-error=".errorTxt16">
												<div class="errorTxt16"></div>
											</div>

											<div class="input-field col s12">
												<label for="txtHotelCoordinadorNuevo">Hotel</label>
												<input id="txtHotelCoordinadorNuevo" name="hotelCoordinador" type="number" placeholder="$" maxlength="10" data-error=".errorTxt17">
												<div class="errorTxt17"></div>
											</div>

											<div class="input-field col s12">
												<label for="txtTransporteCoordinadorNuevo">Transporte</label>
												<input id="txtTransporteCoordinadorNuevo" name="transporteCoordinador" type="number" placeholder="$" maxlength="10" data-error=".errorTxt18">
												<div class="errorTxt18"></div>
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
										
									<form class="formValidate" id="formBrigadaEditar" method="put">
																							
											{{ csrf_field() }}		
											<div class="input-field col s12">
												<label for="txtNumeroEditar">Número</label>
												<input readonly id="txtNumeroEditar" name="numero" type="text" placeholder="">
											</div>
											<div class="input-field col s12">
												<label for="txtDescripcionEditar">Descripción</label>
												<input id="txtDescripcionEditar" name="descripcion" type="text" data-error=".errorTxt19" maxlength="100" placeholder="">
												<div class="errorTxt19"></div>
											</div>
										
											<div class="input-field col s12">
												<label for="txtFechaInicioEditar">Fecha inicio</label>
												<input type="text" name="fechaInicio" id="txtFechaInicioEditar" class="datepicker" data-error=".errorTxt20" placeholder="">
												<div class="errorTxt20"></div>
											</div>

											<div class="input-field col s12">
												<label for="txtHoraInicioEditar">Hora inicio</label>
												<input type="text" name="horaInicio" id="txtHoraInicioEditar" class="timepicker" placeholder="">
											</div>	

											<div class="input-field col s12">
												<label for="txtTelefonosEditar">Teléfonos</label>
												<input type="text" name="telefonos" id="txtTelefonosEditar" data-error=".errorTxt21" maxlength="50" placeholder="">
												<div class="errorTxt21"></div>
											</div>
										
											<div class="col s12">
												<label for="cmbProvinciaEditar">Provincia</label>
												<select class="error browser-default" id="cmbProvinciaEditar" name="provincia" data-error=".errorTxt22">
													
												</select>
												<div class="input-field">
													<div class="errorTxt22"></div>
												</div>
											</div>
											
											<div class="col s12">
												<label for="cmbCantonEditar">Cantón</label>
												<select class="error browser-default" id="cmbCantonEditar" name="canton" data-error=".errorTxt23">
													
												</select>
												<div class="input-field">
													<div class="errorTxt23"></div>
												</div>
											</div>
											
											<div class="col s12">
												<label for="cmbParroquiaEditar">Parroquia</label>
												<select class="error browser-default" id="cmbParroquiaEditar" name="parroquia" data-error=".errorTxt24">
													
												</select>
												<div class="input-field">
													<div class="errorTxt24"></div>
												</div>
											</div>
											

											<div class="input-field col s12">
												<label for="txtDireccionEditar">Dirección</label>
												<input id="txtDireccionEditar" name="direccion" type="text" data-error=".errorTxt25" maxlength="100" placeholder="">
												<div class="errorTxt25"></div>
											</div>

											<div class="col s12">
												<label for="cmbEstadoEditar">Estado</label>
												<select class="error browser-default" id="cmbEstadoEditar" name="estado" data-error=".errorTxt26">
													<option value="" disabled selected>Seleccione</option>
													<option value="P">Preventa</option>
													<option value="A">Activa</option>
													<option value="C">Cerrada</option>
												</select>
												<div class="input-field">
													<div class="errorTxt26"></div>
												</div>
											</div>

											<p>Gastos promotor</p>
											
											<div class="input-field col s12">
												<label for="txtDesayunoPromotorEditar">Desayuno</label>
												<input id="txtDesayunoPromotorEditar" name="desayunoPromotor" type="number" placeholder="$" maxlength="10" data-error=".errorTxt27">
												<div class="errorTxt27"></div>
											</div>

											<div class="input-field col s12">
												<label for="txtAlmuerzoPromotorEditar">Almuerzo</label>
												<input id="txtAlmuerzoPromotorEditar" name="almuerzoPromotor" type="number" placeholder="$" maxlength="10" data-error=".errorTxt28">
												<div class="errorTxt28"></div>
											</div>

											<div class="input-field col s12">
												<label for="txtCenaPromotorEditar">Cena</label>
												<input id="txtCenaPromotorEditar" name="cenaPromotor" type="number" placeholder="$" maxlength="10" data-error=".errorTxt29">
												<div class="errorTxt29"></div>
											</div>

											<div class="input-field col s12">
												<label for="txtHotelPromotorEditar">Hotel</label>
												<input id="txtHotelPromotorEditar" name="hotelPromotor" type="number" placeholder="$" maxlength="10" data-error=".errorTxt30">
												<div class="errorTxt30"></div>
											</div>

											<div class="input-field col s12">
												<label for="txtTransportePromotorEditar">Transporte</label>
												<input id="txtTransportePromotorEditar" name="transportePromotor" type="number" placeholder="$" maxlength="10" data-error=".errorTxt31">
												<div class="errorTxt31"></div>
											</div>

											<p>Gastos coordinador</p>

											<div class="input-field col s12">
												<label for="txtDesayunoCoordinadorEditar">Desayuno</label>
												<input id="txtDesayunoCoordinadorEditar" name="desayunoCoordinador" type="number" placeholder="$" maxlength="10" data-error=".errorTxt32">
												<div class="errorTxt32"></div>
											</div>
											

											<div class="input-field col s12">
												<label for="txtAlmuerzoCoordinadorEditar">Almuerzo</label>
												<input id="txtAlmuerzoCoordinadorEditar" name="almuerzoCoordinador" type="number" placeholder="$" maxlength="10" data-error=".errorTxt33">
												<div class="errorTxt33"></div>
											</div>

											<div class="input-field col s12">
												<label for="txtCenaCoordinadorEditar">Cena</label>
												<input id="txtCenaCoordinadorEditar" name="cenaCoordinador" type="number" placeholder="$" maxlength="10" data-error=".errorTxt34">
												<div class="errorTxt34"></div>
											</div>

											<div class="input-field col s12">
												<label for="txtHotelCoordinadorEditar">Hotel</label>
												<input id="txtHotelCoordinadorEditar" name="hotelCoordinador" type="number" placeholder="$" maxlength="10" data-error=".errorTxt35">
												<div class="errorTxt35"></div>
											</div>

											<div class="input-field col s12">
												<label for="txtTransporteCoordinadorEditar">Transporte</label>
												<input id="txtTransporteCoordinadorEditar" name="transporteCoordinador" type="number" placeholder="$" maxlength="10" data-error=".errorTxt36">
												<div class="errorTxt36"></div>
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
	<script src="js/brigadas.js" type="module"></script>
    <script src="app-assets/js/scripts/data-tables.js" type="text/javascript"></script>
	

@endsection