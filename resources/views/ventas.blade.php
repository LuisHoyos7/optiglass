@extends('principal')

@section('content')


<div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
	<div class="container">
		<div class="row">
			<div class="col s10 m6 l6">
				<h5 class="breadcrumbs-title mt-0 mb-0">Ventas</h5>
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
								<div class="col s10 pl-0">
									<ul class="tabs">
										<li id="btnVenta" class="tab col s4 p-0">
											<a href="#venta" class="active">
												<span>Venta</span>
											</a>
										</li>
										<li id="btnHistorial" class="tab col s4 p-0">
											<a href="#historial">
												<span>Historial</span>
											</a>
										</li>
									</ul>
								</div>

								<div id="venta" class="col s12" style="padding-top: 10px">

									<form class="formValidate" id="formVenta" method="post">
										{{ csrf_field() }}
										<input type="hidden" name="venta" id="txtVenta">
										<div class="row">
											<div class="input-field col s9 m5">
												<label for="txtConsecutivo">Consecutivo</label>
												<input id="txtConsecutivo" name="consecutivo" type="text" data-error=".errorTxt1" placeholder=" ">
												<div class="errorTxt1"></div>
											</div>

											<div class="input-field col s3 m1">
												<button id="btnBuscar" class="btn btn-floating waves-effect waves-light submit gradient-45deg-indigo-purple gradient-shadow" type="button" name="action">
													<i class="material-icons right">search</i>
												</button>
											</div>

											<div class="input-field col s12 m6">
												<label for="txtNumeroDocumento">No documento</label>
												<input readonly id="txtNumeroDocumento" name="numeroDocumento" data-error=".errorTxt2" type="text" maxlength="20" placeholder=" ">
												<div class="errorTxt2"></div>
											</div>
										</div>

										<div class="row">
											<div class="input-field col s12 m6">
												<label for="txtNombres">Nombres</label>
												<input readonly id="txtNombres" name="nombres" type="text" data-error=".errorTxt3" maxlength="50" placeholder="">
												<div class="errorTxt3"></div>
											</div>

											<div class="input-field col s12 m6">
												<label for="txtApellidos">Apellidos</label>
												<input readonly id="txtApellidos" name="apellidos" type="text" data-error=".errorTxt4" maxlength="50" placeholder="">
												<div class="errorTxt4"></div>
											</div>
										</div>

										<div class="row">
											<div class="input-field col s12 m6">
												<label for="txtCelular">Celular</label>
												<input readonly id="txtCelular" name="celular" type="tel" data-error=".errorTxt5" maxlength="10" placeholder="">
												<div class="errorTxt5"></div>
											</div>

											<div class="input-field col s12 m6">
												<label for="txtTelefono">Teléfono</label>
												<input readonly id="txtTelefono" name="telefono" type="tel" maxlength="10" placeholder="">
											</div>
										</div>

										<div class="row">
											<div class="input-field col s12 m6">
												<label for="txtBrigada">Brigada</label>
												<input readonly id="txtBrigada" name="brigada" type="text" data-error=".errorTxt6" placeholder="">
												<div class="errorTxt6"></div>
											</div>

											<div class="col s12 m6">
												<label for="cmbLente">Lente</label>
												<select class="error browser-default" id="cmbLente" name="lente" data-error=".errorTxt7">
												</select>
												<div class="input-field">
													<div class="errorTxt7"></div>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col s12">

												<table id="data-table-simple" class="cell-border" style="width: 100%;border-top: solid 0.5px;">
													<thead>
														<tr>
															<th>Distancia</th>
															<th>Ojo</th>
															<th>Esfera</th>
															<th>Cilindro</th>
															<th>Eje</th>
															<th>A.V.</th>
														</tr>
													</thead>
												</table>
											</div>
										</div>
										<div class="row">
											<div class="col s12" style="margin-top: 20px;margin-bottom: 20px">

												<table id="data-table-simple-2" class="cell-border" style="width: 100%;border-top: solid 0.5px;">
													<thead>
														<tr>
															<th>Ojo</th>
															<th>Adición</th>
															<th>Ojo</th>
															<th>Adición</th>
														</tr>
													</thead>
												</table>
											</div>
										</div>

										<div class="row">
											<div class="input-field col s12 m6">
												<label for="txtAbono">Abono</label>
												<input id="txtAbono" name="abono" type="number" maxlength="10" min="1" data-error=".errorTxt8" placeholder=" ">
												<div class="errorTxt8"></div>
											</div>

											<div class="input-field col s12 m6 ">
												<label for="txtSaldo">Saldo</label>
												<input id="txtSaldo" name="saldo" type="number" maxlength="10" data-error=".errorTxt9" placeholder=" ">
												<div class="errorTxt9"></div>
											</div>
										</div>

										<div class="input-field col s12" style="text-align: right;">
											<button id="btnGuardar" class="btn waves-effect waves-light submit gradient-45deg-indigo-purple gradient-shadow" type="submit" name="action">Guardar
												<i class="material-icons right">save</i>
											</button>
										</div>

									</form>

								</div>
							</div>

							<div id="historial" class="col s12" style="padding-top: 10px">

								<ul class="collapsible collapsible-accordion" data-collapsible="accordion">
									<li class="active">
										<div class="collapsible-header"><i class="material-icons">search</i> Búsqueda</div>
										<div class="collapsible-body" style="padding-top:0;padding-bottom:0;">

											<div class="row">

												<div class="col s12 m3">
													<label for="cmbBrigada">Brigada</label>
													<select class="error browser-default" id="cmbBrigada" name="brigada">
													</select>
												</div>

												<div class="col s9 m3">
													<label for="txtFecha">Fecha</label>
													<input id="txtFecha" name="fecha" class="datepicker" type="text" placeholder="" autocomplete="off">
												</div>

												<div class="input-field col s3 m1">
													<a class="btn-floating btn-medium waves-effect waves-light right gradient-45deg-indigo-purple gradient-shadow" id="btnBuscarVenta" href="#" data-target="slide-out-right">
														<i class="material-icons">search</i>
													</a>
												</div>

											</div>

										</div>
									</li>
								</ul>

								<form class="formValidate" id="formHistorial" method="post">
									<input type="hidden" name="_token" id="txtToken" value="{{ csrf_token() }}">
									<div class="row">
										<div class="col s12">
											<table id="data-table-simple-3" class="display nowrap" style="width: 100%">
												<thead>
													<tr>
														<th></th>
														<th>Consecutivo</th>
														<th>Fecha</th>
														<th>Brigada</th>
														<th>Nombre</th>
														<th>Abono</th>
														<th>Saldo</th>
														<th>Lente</th>
													</tr>
												</thead>

											</table>
										</div>
									</div>

									<div class="row">
										<div class="input-field col s12">
											<button class="btn waves-effect waves-light right gradient-45deg-indigo-purple gradient-shadow" type="submit" id="btnImprimir">Imprimir
												<i class="material-icons right">print</i>
											</button>
										</div>
									</div>
								</form>


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
<script src="js/ventas.js" type="module"></script>
<script src="app-assets/js/scripts/data-tables.js" type="text/javascript"></script>

@endsection