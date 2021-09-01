@extends('principal')

@section('content')

	
			<div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">	
				<div class="container">
					<div class="row">
						<div class="col s10 m6 l6">
							<h5 class="breadcrumbs-title mt-0 mb-0">Parámetros de gastos</h5>
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
													<th>Código</th>
													<th>Afiliaciones mínimas</th>
													<th>Afiliaciones máximas</th>
													<th>Pagadas</th>
													<th>Desayuno</th>
													<th>Almuerzo</th>
													<th>Cena</th>
													<th>Hotel</th>
													<th>Transporte</th>
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
										
									<form class="formValidate" id="formParametroNuevo" method="post">
																							
										{{ csrf_field() }}		
										<div class="col s12">
											<label for="cmbEstadoNuevo">Estado</label>
											<select class="error browser-default" id="cmbEstadoNuevo" name="estado" data-error=".errorTxt1">
												<option value="" disabled selected>Seleccione</option>
												<option value="A">Activo</option>
												<option value="I">Inactivo</option>
											</select>
											<div class="input-field">
												<div class="errorTxt1"></div>
											</div>
										</div>
										
										<p style="margin-left: 5px;">Afiliaciones</p>

										<div class="input-field col s12">
											<label for="txtMinimaNuevo">Minima</label>
											<input type="number" name="minima" id="txtMinimaNuevo" data-error=".errorTxt2">
											<div class="errorTxt2"></div>
										</div>
										
										<div class="input-field col s12">
											<label for="txtMaximaNuevo">Máxima</label>
											<input type="number" name="maxima" id="txtMaximaNuevo" data-error=".errorTxt3">
											<div class="errorTxt3"></div>
										</div>

										<div class="input-field col s12">
											<label for="txtPagadasNuevo">Pagadas</label>
											<input type="number" name="pagadas" id="txtPagadasNuevo" data-error=".errorTxt4">
											<div class="errorTxt4"></div>
										</div>
											
										<p style="margin-left: 5px;">Desayuno</p>
									
									
										<div class="input-field col s5">
											<div class="switch">
								              <label>
								                No
								                <input id="DesayunoNuevo" name="aplicaDesayuno" type="checkbox">
								                <span class="lever"></span>
								                Si
								              </label>
							            	</div>	
							            </div>							            

							            <div class="input-field col s7 offset s3">
											<input readonly type="number" placeholder="Cantidad" name="desayuno" id="txtDesayunoNuevo">
										</div>	

										<p style="margin-left: 5px;">Almuerzo</p>
									
									
										<div class="input-field col s5">
											<div class="switch">
								              <label>
								                No
								                <input id="AlmuerzoNuevo" name="aplicaAlmuerzo" type="checkbox">
								                <span class="lever"></span>
								                Si
								              </label>
							            	</div>	
							            </div>							            

							            <div class="input-field col s7 offset s3">
											<input readonly type="number" placeholder="Cantidad" name="almuerzo" id="txtAlmuerzoNuevo">
										</div>

										<p style="margin-left: 5px;">Cena</p>

										<div class="input-field col s5">
											<div class="switch">
								              <label>
								                No
								                <input id="CenaNuevo" name="aplicaCena" type="checkbox">
								                <span class="lever"></span>
								                Si
								              </label>
							            	</div>	
							            </div>							            

							            <div class="input-field col s7 offset s3">
											<input readonly type="number" placeholder="Cantidad" name="cena" id="txtCenaNuevo">
										</div>

										<p style="margin-left: 5px;">Hotel</p>

										<div class="input-field col s5">
											<div class="switch">
								              <label>
								                No
								                <input id="HotelNuevo" name="aplicaHotel" type="checkbox">
								                <span class="lever"></span>
								                Si
								              </label>
							            	</div>	
							            </div>							            

							            <div class="input-field col s7 offset s3">
											<input readonly type="number" placeholder="Cantidad" name="hotel" id="txtHotelNuevo">
										</div>

										<p style="margin-left: 5px;">Transporte</p>

										<div class="input-field col s5">
											<div class="switch">
								              <label>
								                No
								                <input id="TransporteNuevo" name="aplicaTransporte" type="checkbox">
								                <span class="lever"></span>
								                Si
								              </label>
							            	</div>	
							            </div>							            

							            <div class="input-field col s7 offset s3">
											<input readonly type="number" placeholder="Cantidad" name="transporte" id="txtTransporteNuevo">
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

									<form class="formValidate" id="formParametroEditar" method="post">
																							
											{{ csrf_field() }}	
											<div class="input-field col s12">
												<label for="txtCodigoEditar">Código</label>
												<input readonly type="number" name="codigo" id="txtCodigoEditar" data-error=".errorTxt13" placeholder="">
												<div class="errorTxt13"></div>
											</div>

											<div class="col s12">
												<label for="cmbEstadoEditar">Estado</label>
												<select class="error browser-default" id="cmbEstadoEditar" name="estado" data-error=".errorTxt14" >
													<option value="" disabled selected>Seleccione</option>
													<option value="A">Activo</option>
													<option value="I">Inactivo</option>
												</select>
												<div class="input-field">
													<div class="errorTxt14"></div>
												</div>
											</div>
											
											<p style="margin-left: 5px;">Afiliaciones</p>

											<div class="input-field col s12">
												<label for="txtMinimaEditar">Minima</label>
												<input type="number" name="minima" id="txtMinimaEditar" data-error=".errorTxt15" placeholder="">
												<div class="errorTxt15"></div>
											</div>
											
											<div class="input-field col s12">
												<label for="txtMaximaEditar">Máxima</label>
												<input type="number" name="maxima" id="txtMaximaEditar" data-error=".errorTxt16" placeholder="">
												<div class="errorTxt16"></div>
											</div>

											<div class="input-field col s12">
												<label for="txtPagadasEditar">Pagadas</label>
												<input type="number" name="pagadas" id="txtPagadasEditar" placeholder="" data-error=".errorTxt17">
												<div class="errorTxt17"></div>
											</div>

											<p style="margin-left: 5px;">Desayuno</p>
											
												<div class="input-field col s5">
													<div class="switch">
										              <label>
										                No
										                <input id="DesayunoEditar" name="aplicaDesayuno" type="checkbox">
										                <span class="lever"></span>
										                Si
										              </label>
									            	</div>	
									            </div>							            

									            <div class="input-field col s7 offset s3">
													<input type="number" placeholder="Cantidad" name="desayuno" id="txtDesayunoEditar">
												</div>
											
												<p style="margin-left: 5px;">Almuerzo</p>
											
												<div class="input-field col s5">
													<div class="switch">
										              <label>
										                No
										                <input id="AlmuerzoEditar" name="aplicaAlmuerzo" type="checkbox">
										                <span class="lever"></span>
										                Si
										              </label>
									            	</div>	
									            </div>							            

									            <div class="input-field col s7 offset s3">
													<input type="number" placeholder="Cantidad" name="almuerzo" id="txtAlmuerzoEditar">
												</div>

												<p style="margin-left: 5px;">Cena</p>

												<div class="input-field col s5">
													<div class="switch">
										              <label>
										                No
										                <input id="CenaEditar" name="aplicaCena" type="checkbox">
										                <span class="lever"></span>
										                Si
										              </label>
									            	</div>	
									            </div>							            

									            <div class="input-field col s7 offset s3">
													<input type="number" placeholder="Cantidad" name="cena" id="txtCenaEditar">
												</div>

												<p style="margin-left: 5px;">Hotel</p>

												<div class="input-field col s5">
													<div class="switch">
										              <label>
										                No
										                <input id="HotelEditar" name="aplicaHotel" type="checkbox">
										                <span class="lever"></span>
										                Si
										              </label>
									            	</div>	
									            </div>							            

									            <div class="input-field col s7 offset s3">
													<input type="number" placeholder="Cantidad" name="hotel" id="txtHotelEditar">
												</div>

												<p style="margin-left: 5px;">Transporte</p>

												<div class="input-field col s5">
													<div class="switch">
										              <label>
										                No
										                <input id="TransporteEditar" name="aplicaTransporte" type="checkbox">
										                <span class="lever"></span>
										                Si
										              </label>
									            	</div>	
									            </div>							            

									            <div class="input-field col s7 offset s3">
													<input type="number" placeholder="Cantidad" name="transporte" id="txtTransporteEditar">
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
	<script src="js/parametrosGastos.js" type="text/javascript"></script>
    <script src="app-assets/js/scripts/data-tables.js" type="text/javascript"></script>
	

@endsection