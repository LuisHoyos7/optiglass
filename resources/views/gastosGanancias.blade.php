@extends('principal')

@section('content')

	
			<div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">	
				<div class="container">
					<div class="row">
						<div class="col s10 m6 l6">
							<h5 class="breadcrumbs-title mt-0 mb-0">Gastos y ganancias</h5>
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
													<th>Fecha</th>
													<th>Promotor</th>
													<th>Afiliaciones</th>
													<th>Abonos</th>
												  </tr>
												</thead>
												
											  </table>
											</div>
										</div>

										<div class="row">
											<div class="input-field col s12">
												<button id="btnNuevo" class="btn waves-effect waves-light right gradient-45deg-indigo-purple gradient-shadow sidenav-trigger" data-target="slide-out-right" type="button">Nuevo
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
										
									<form class="formValidate" id="formGastosGananciasNuevo" method="post">
																							
											{{ csrf_field() }}		
											<div class="input-field col s12">
												<label for="txtFechaNuevo">Fecha</label>
												<input id="txtFechaNuevo" name="fecha" type="text" class="datepicker" data-error=".errorTxt1" placeholder="">
												<div class="errorTxt1"></div>
											</div>

											<div class="col s12">
											  <label for="cmbPromotorNuevo">Promotor</label>
											  <select class="error browser-default" id="cmbPromotorNuevo" name="promotor" data-error=".errorTxt2">
												
											  </select>
											  <div class="input-field">
												<div class="errorTxt2"></div>
											  </div>
											</div>

											<div class="col s12">
											  <label for="cmbBrigadaNuevo">Brigada</label>
											  <select class="error browser-default" id="cmbBrigadaNuevo" name="brigada" data-error=".errorTxt3">
												<option value='' disabled selected>Seleccione</option>
											  </select>
											  <div class="input-field">
												<div class="errorTxt3"></div>
											  </div>
											</div>

											<div class="col s12" style="padding: 5px">
												<p style="margin: 0px;">Afiliaciones</p>
											</div>

											<div class="input-field col s9">
												<label for="txtCantidadNuevo">Cantidad</label>
												<input readonly type="number" name="cantidad" id="txtCantidadNuevo" data-error=".errorTxt4" placeholder="">
												<div class="errorTxt4"></div>
											</div>

											<div class="input-field col s3">
												<label for="txtAbonosNuevo">Abonos</label>
												<input readonly type="number"  name="abonos" id="txtAbonosNuevo" placeholder="">
											</div>
											
											<div class="input-field col s9">
												<label for="txtValorNuevo">Valor</label>
												<input readonly type="number" name="valor" id="txtValorNuevo" data-error=".errorTxt5" placeholder="">
												<div class="errorTxt5"></div>
											</div>

											<div class="input-field col s3">
												<label for="txtValorGananciaNuevo">Ganancia</label>
												<input readonly type="number"  name="gananciaValor" id="txtValorGananciaNuevo" placeholder="">
											</div>
											
											<div class="col s12" style="padding: 5px">
												<p style="margin: 0px;">Gastos</p>
											</div>

											<!-- Desayuno -->
											<div class="input-field col s7">
												<label for="txtDesayunoNuevo">Desayuno</label>
												<input readonly type="number" name="desayuno" id="txtDesayunoNuevo" data-error=".errorTxt6" placeholder="">
												<div class="errorTxt6"></div>
											</div>

											<div class="input-field col s3">
												<label for="txtDesayunoGananciaNuevo">Ganancia</label>
												<input readonly type="number" name="gananciaDesayuno" id="txtDesayunoGananciaNuevo" placeholder="">
											</div>

											<div class="input-field col s2">
												<label>
													<input id="DesayunoNuevoHidden"  name="prestamoDesayuno" type="checkbox" class="filled-in chkNuevo"
													style="display: none" />
											        <input id="DesayunoNuevo"  type="checkbox" class="filled-in chkNuevo"/>
											        <span></span>
											    </label>
											</div>

											<!-- Almuerzo -->
											<div class="input-field col s7">
												<label for="txtAlmuerzoNuevo">Almuerzo</label>
												<input readonly type="number" name="almuerzo" id="txtAlmuerzoNuevo" data-error=".errorTxt7" placeholder="">
												<div class="errorTxt7"></div>
											</div>

											<div class="input-field col s3">
												<label for="txtAlmuerzoGananciaNuevo">Ganancia</label>
												<input readonly type="number" name="gananciaAlmuerzo" id="txtAlmuerzoGananciaNuevo" placeholder="">
											</div>

											<div class="input-field col s2">
												<label>
											        <input id="AlmuerzoNuevo"  name="prestamoAlmuerzo" type="checkbox" class="filled-in chkNuevo"/>
											        <span></span>
											    </label>
											</div>
											
											<!-- Cena -->
											<div class="input-field col s7">
												<label for="txtCenaNuevo">Cena</label>
												<input readonly type="number" name="cena" id="txtCenaNuevo" data-error=".errorTxt8" placeholder="">
												<div class="errorTxt8"></div>
											</div>

											<div class="input-field col s3">
												<label for="txtCenaGananciaNuevo">Ganancia</label>
												<input readonly type="number" name="gananciaCena" id="txtCenaGananciaNuevo" placeholder="">
											</div>

											<div class="input-field col s2">
												<label>
											        <input id="CenaNuevo" name="prestamoCena" type="checkbox" class="filled-in chkNuevo" />
											        <span></span>
											    </label>
											</div>

											<!-- Hotel -->
											<div class="input-field col s7">
												<label for="txtHotelNuevo">Hotel</label>
												<input readonly type="number" name="hotel" id="txtHotelNuevo" data-error=".errorTxt9" placeholder="">
												<div class="errorTxt9"></div>
											</div>

											<div class="input-field col s3">
												<label for="txtHotelGananciaNuevo">Ganancia</label>
												<input readonly type="number" name="gananciaHotel" id="txtHotelGananciaNuevo" placeholder="">
											</div>

											<div class="input-field col s2">
												<label>
													<input id="HotelNuevoHidden" name="prestamoHotel" type="checkbox" class="filled-in chkNuevo" style="display: none" />
											        <input id="HotelNuevo" type="checkbox" class="filled-in chkNuevo" />
											        <span></span>
											    </label>
											</div>
											
											<!-- Transporte -->
											<div class="input-field col s7">
												<label for="txtTransporteNuevo">Transporte</label>
												<input readonly type="number" name="transporte" id="txtTransporteNuevo" data-error=".errorTxt10" placeholder="">
												<div class="errorTxt10"></div>
											</div>

											<div class="input-field col s3">
												<label for="txtTransporteGananciaNuevo">Ganancia</label>
												<input readonly type="number" name="gananciaTransporte" id="txtTransporteGananciaNuevo" placeholder="">
											</div>

											<div class="input-field col s2">
												<label>
											        <input id="TransporteNuevo" name="prestamoTransporte" type="checkbox" class="filled-in chkNuevo" />
											        <span></span>
											    </label>
											</div>

											<div class="input-field col s12">
												<label for="txtTransporteNuevo">Transporte Regreso</label>
												<input readonly type="number" name="transporte" id="txtTransporteRegresoNuevo" data-error=".errorTxt10" placeholder="">
												<div class="errorTxt10"></div>
											</div>

											<div class="input-field col s12">
												<label for="txtOtrosPrestamosNuevo">Otros prestamos</label>
												<input type="number" name="otrosPrestamos"  id="txtOtrosPrestamosNuevo" min="0" maxlength="10" placeholder="$">
											</div>

											<div class="input-field col s12">
												<label for="txtOtrosPrestamosObservacionNuevo">Observación otros prestamos</label>
												<textarea name="otrosPrestamosObservacion" id="txtOtrosPrestamosObservacionNuevo" class="materialize-textarea" maxlength="200" placeholder=""></textarea>
											</div>

											<div class="col s12" style="padding: 5px">
												<p style="margin: 0;">Prestamo</p>
											</div>
											
											<div class="input-field col s12">
												<input readonly type="number" name="prestamo" placeholder="Prestamo" id="txtPrestamoNuevo" data-error=".errorTxt11">
												<div class="errorTxt11"></div>
											</div>

											<div class="col s12" style="padding: 5px">
												<p style="margin: 0px;">Restante</p>
											</div>

											<div class="input-field col s12">
												<input readonly type="number" name="restante" placeholder="Restante" id="txtRestanteNuevo" data-error=".errorTxt12">
												<div class="errorTxt12"></div>
											</div>

											<div class="col s12" style="padding: 5px">
												<p style="margin: 0px;">Entrega</p>
											</div>

											<div class="input-field col s12">
												<input readonly type="number" name="entrega" placeholder="Entrega" id="txtEntregaNuevo"  data-error=".errorTxt13"> 
												<div class="errorTxt13"></div>
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
										 <h5>Editar</h5>
									  </div>
								   </div>
								</div>
							 </div>
							 <div class="slide-out-right-second-body">
								<div class="col s12">
										
									<form class="formValidate" id="formGastosGananciasEditar" method="post">
																							
											{{ csrf_field() }}		
											<div class="input-field col s12">
												<label for="txtNumeroEditar">Número</label>
												<input readonly id="txtNumeroEditar" name="numero" type="text" placeholder="">
											</div>

											<div class="input-field col s12">
												<label for="txtFechaEditar">Fecha</label>
												<input readonly id="txtFechaEditar" name="fecha" type="text" data-error=".errorTxt14" placeholder="">
												<div class="errorTxt14"></div>
											</div>
											
											<div class="col s12">
											  <label for="cmbPromotorEditar">Promotor</label>
											  <input type="hidden" name="promotor" id="txtPromotorEditar">
											  <select disabled class="error browser-default" id="cmbPromotorEditar" name="promotorDescripcion" data-error=".errorTxt15">
												
											  </select>
											  <div class="input-field">
												<div class="errorTxt15"></div>
											  </div>
											</div>

											<div class="col s12">
											  <label for="cmbBrigadaEditar">Brigada</label>
											  <input type="hidden" name="brigada" id="txtBrigadaEditar">
											  <select disabled readonly class="error browser-default" id="cmbBrigadaEditar" name="brigadaDescripcion" data-error=".errorTxt16">
												<option value='' disabled selected>Seleccione</option>
											  </select>
											  <div class="input-field">
												<div class="errorTxt16"></div>
											  </div>
											</div>

											<p style="margin-left: 5px;">Afiliaciones</p>

											<div class="input-field col s9">
												<label for="txtCantidadEditar">Cantidad</label>
												<input readonly type="number" name="cantidad" id="txtCantidadEditar" data-error=".errorTxt17" placeholder="">
												<div class="errorTxt17"></div>
											</div>

											<div class="input-field col s3">
												<label for="txtAbonosEditar">Abonos</label>
												<input readonly type="number"  name="abonos" id="txtAbonosEditar" placeholder="">
											</div>
											
											<div class="input-field col s9">
												<label for="txtValorEditar">Valor</label>
												<input readonly type="number" name="valor" id="txtValorEditar" data-error=".errorTxt18" placeholder="">
												<div class="errorTxt18"></div>
											</div>

											<div class="input-field col s3">
												<label for="txtValorGananciaEditar">Ganancia</label>
												<input readonly type="number" id="txtValorGananciaEditar" placeholder="">
											</div>
											
											<p style="margin-left: 5px;">Gastos</p>

											<!-- Desayuno -->
											<div class="input-field col s7">
												<label for="txtDesayunoEditar">Desayuno</label>
												<input readonly type="number" name="desayuno" id="txtDesayunoEditar" data-error=".errorTxt19" placeholder="">
												<div class="errorTxt19"></div>
											</div>

											<div class="input-field col s3">
												<label for="txtDesayunoGananciaEditar">Ganancia</label>
												<input readonly type="number" name="gananciaDesayuno" id="txtDesayunoGananciaEditar" placeholder="">
											</div>

											<div class="input-field col s2">
												<label>
													<input id="DesayunoEditarHidden"  name="prestamoDesayuno" type="checkbox" class="filled-in chkNuevo" style="display: none" />
											        <input id="DesayunoEditar" type="checkbox" class="filled-in chkNuevo"/>
											        <span></span>
											    </label>
											</div>

											<!-- Almmuerzo -->
											<div class="input-field col s7">
												<label for="txtAlmuerzoEditar">Almuerzo</label>
												<input readonly type="number" name="almuerzo" id="txtAlmuerzoEditar" data-error=".errorTxt20" placeholder="">
												<div class="errorTxt20"></div>
											</div>

											<div class="input-field col s3">
												<label for="txtAlmuerzoGananciaEditar">Ganancia</label>
												<input readonly type="number" id="txtAlmuerzoGananciaEditar" placeholder="">
											</div>

											<div class="input-field col s2">
												<label>
											        <input id="AlmuerzoEditar" name="prestamoAlmuerzo" type="checkbox" class="filled-in chkNuevo"/>
											        <span></span>
											    </label>
											</div>
											
											<!-- Cena -->
											<div class="input-field col s7">
												<label for="txtCenaEditar">Cena</label>
												<input readonly type="number" name="cena" id="txtCenaEditar" data-error=".errorTxt21" placeholder="">
												<div class="errorTxt21"></div>
											</div>

											<div class="input-field col s3">
												<label for="txtCenaGananciaEditar">Ganancia</label>
												<input readonly type="number" id="txtCenaGananciaEditar" placeholder="">
											</div>

											<div class="input-field col s2">
												<label>
											        <input id="CenaEditar" name="prestamoCena" type="checkbox" class="filled-in chkNuevo" />
											        <span></span>
											    </label>
											</div>

											<!-- Hotel -->
											<div class="input-field col s7">
												<label for="txtHotelEditar">Hotel</label>
												<input readonly type="number" name="hotel" id="txtHotelEditar" data-error=".errorTxt22" placeholder="">
												<div class="errorTxt22"></div>
											</div>

											<div class="input-field col s3">
												<label for="txtHotelGananciaEditar">Ganancia</label>
												<input readonly type="number" id="txtHotelGananciaEditar" placeholder="">
											</div>

											<div class="input-field col s2">
												<label>
													<input id="HotelEditarHidden" name="prestamoHotel" type="checkbox" class="filled-in chkNuevo" style="display: none" />
											        <input id="HotelEditar" type="checkbox" class="filled-in chkNuevo" />
											        <span></span>
											    </label>
											</div>
											
											<!-- Transporte -->
											<div class="input-field col s7">
												<label for="txtTransporteEditar">Transporte</label>
												<input readonly type="number" name="transporte" id="txtTransporteEditar" data-error=".errorTxt23" placeholder=""> 
												<div class="errorTxt23"></div>
											</div>

											<div class="input-field col s3">
												<label for="txtTransporteGananciaEditar">Ganancia</label>
												<input readonly type="number" id="txtTransporteGananciaEditar" placeholder="">
											</div>

											<div class="input-field col s2">
												<label>
											        <input id="TransporteEditar" name="prestamoTransporte" type="checkbox" class="filled-in chkNuevo" />
											        <span></span>
											    </label>
											</div>

											<div class="input-field col s12">
												<label for="txtOtrosPrestamosEditar">Otros prestamos</label>
												<input type="number" name="otrosPrestamos"  id="txtOtrosPrestamosEditar" min="0" maxlength="10" placeholder="$">
											</div>

											<div class="input-field col s12">
												<label for="txtOtrosPrestamosObservacionEditar">Observación otros prestamos</label>
												<textarea name="otrosPrestamosObservacion" id="txtOtrosPrestamosObservacionEditar" class="materialize-textarea" maxlength="200" placeholder=""></textarea>
											</div>

											<p style="margin-left: 5px;">Prestamo</p>

											<div class="input-field col s12">
												<input readonly type="number" name="prestamo" placeholder="Prestamo" id="txtPrestamoEditar" data-error=".errorTxt24">
												<div class="errorTxt24"></div>
											</div>

											<p style="margin-left: 5px;">Restante</p>

											<div class="input-field col s12">
												<input readonly type="number" name="restante" placeholder="Restante" id="txtRestanteEditar" data-error=".errorTxt12">
												<div class="errorTxt12"></div>
											</div>

											<p style="margin-left: 5px;">Entrega</p>

											<div class="input-field col s12">
												<input type="number" name="entrega" placeholder="Entrega" id="txtEntregaEditar" data-error=".errorTxt26">
												<div class="errorTxt26"></div>
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
	<script src="js/gastosGanancias.js" type="module"></script>
    <script src="app-assets/js/scripts/data-tables.js" type="text/javascript"></script>
	
@endsection