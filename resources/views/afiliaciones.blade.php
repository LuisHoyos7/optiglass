@extends('principal')

@section('content')

<div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
	<div class="container">
		<div class="row">
			<div class="col s6">
				<h5 class="breadcrumbs-title mt-0 mb-0">Afiliación</h5>
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

							<div id="view-validations">
								<form class="formValidate" id="formAfiliacion" method="post">
									{{ csrf_field() }}
									<div class="row">
										<div class="input-field col s12 m6">
											<label for="txtConsecutivo">Consecutivo</label>
											<input id="txtConsecutivo" name="consecutivo" type="text" maxlength="10" data-error=".errorTxt1" placeholder=" ">
											<div class="errorTxt1"></div>
										</div>

										<div class="input-field col s12 m4">
											<label for="txtNumeroDocumento">No documento</label>
											<input id="txtNumeroDocumento" name="numeroDocumento" type="text" maxlength="20" placeholder=" ">
										</div>
										<div class="input-field col s12 m2">
											<label for="txtNumeroDocumento">Edad</label>
											<input id="txtEdad" name="edad" type="text" maxlength="20" placeholder=" ">
										</div>
									</div>

									<div class="row">
										<div class="input-field col s12 m6">
											<label for="txtNombres">Nombres</label>
											<input id="txtNombres" name="nombres" type="text" data-error=".errorTxt2" maxlength="50" placeholder="">
											<div class="errorTxt2"></div>
										</div>

										<div class="input-field col s12 m6">
											<label for="txtApellidos">Apellidos</label>
											<input id="txtApellidos" name="apellidos" type="text" data-error=".errorTxt3" maxlength="50" placeholder="">
											<div class="errorTxt3"></div>
										</div>
									</div>

									<div class="row">
										<div class="input-field col s12 m3">
											<label for="txtCelular">Celular Principal</label>
											<input id="txtCelular" name="celular" type="tel" data-error=".errorTxt4" minlength="10" maxlength="10" placeholder="">
											<div class="errorTxt4"></div>
										</div>

										<div class="input-field col s12 m3">
											<label for="txtCelular">Celular Secundario</label>
											<input id="txtCelular2" name="celular2" type="tel" data-error=".errorTxt4" minlength="10" maxlength="10" placeholder="">
											<div class="errorTxt4"></div>
										</div>

										<div class="input-field col s12 m3">
											<label for="txtTelefono">Teléfono Principal</label>
											<input id="txtTelefono" name="telefono" type="tel" maxlength="10" placeholder="">
										</div>

										<div class="input-field col s12 m3">
											<label for="txtTelefono">Teléfono secundario</label>
											<input id="txtTelefono2" name="telefono2" type="tel" maxlength="10" placeholder="">
										</div>
									</div>

									<div class="row">
										<div class="input-field col s12 m12">
											<label for="txtCelular">Observaciones</label>
											<input id="observaciones" name="observaciones" type="text" data-error=".errorTxt4">
											<div class="errorTxt4"></div>
										</div>
									</div>

									<div class="row">
										<div class="col s12 m6">
											<label for="cmbPromotor">Promotor</label>
											<select class="error browser-default" id="cmbPromotor" name="promotor" data-error=".errorTxt5">
											</select>
											<div class="input-field">
												<div class="errorTxt5"></div>
											</div>
										</div>

										<div class="col s12 m6">
											<label for="cmbBrigada">Brigada</label>
											<select class="error browser-default" id="cmbBrigada" name="brigada" data-error=".errorTxt6">
											</select>
											<div class="input-field">
												<div class="errorTxt6"></div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col s12 m6">
											<label for="cmbProvincia">Provincia</label>
											<select class="error browser-default" id="cmbProvincia" name="provincia" data-error=".errorTxt7">
												<option value="" disabled selected>Seleccione</option>
											</select>
											<div class="input-field">
												<div class="errorTxt7"></div>
											</div>
										</div>

										<div class="col s12 m6">
											<label for="cmbCanton">Cantón</label>
											<select class="error browser-default" id="cmbCanton" name="canton" data-error=".errorTxt8">
												<option value="" disabled selected>Seleccione</option>
											</select>
											<div class="input-field">
												<div class="errorTxt8"></div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col s12 m6">
											<label for="cmbParroquia">Parroquia</label>
											<select class="error browser-default" id="cmbParroquia" name="parroquia" data-error=".errorTxt9">
												<option value="" disabled selected>Seleccione</option>
											</select>
											<div class="input-field">
												<div class="errorTxt9"></div>
											</div>
										</div>

										<div class="input-field col s12 m6">
											<label for="txtDireccion">Direccion</label>
											<input id="txtDireccion" name="direccion" type="text" data-error=".errorTxt10" maxlength="100" placeholder="">
											<div class="errorTxt10"></div>
										</div>
									</div>


									<div class="row">
										<div class="input-field col s12 m6">
											<label for="txtAbono">Abono</label>
											<input id="txtAbono" name="abono" type="number" data-error=".errorTxt11" maxlength="10" placeholder=" " min="1">
											<div class="errorTxt11"></div>
										</div>

										<div class="input-field col s12 m6 ">
											<label for="txtSaldo">Saldo</label>
											<input readonly id="txtSaldo" name="saldo" type="number" data-error=".errorTxt12" maxlength="10" placeholder=" ">
											<div class="errorTxt12"></div>
										</div>
									</div>

									<div class="input-field col s12 right-align two-button-container">
										<button id="btnIntegrantes" class="btn waves-effect waves-light submit gradient-45deg-indigo-purple gradient-shadow sidenav-trigger" data-target='slide-out-right'>Integrantes
											<i class="material-icons right">group_add</i>
										</button>
										<button id="btnGuardar" class="btn waves-effect waves-light submit gradient-45deg-indigo-purple gradient-shadow" type="submit" name="action">Guardar
											<i class="material-icons right">save</i>
										</button>
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

@include('asides/integrantes')

<!-- Scripts -->
<script src="app-assets/vendors/data-tables/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="js/afiliaciones.js" type="module"></script>
<script src="app-assets/js/scripts/data-tables.js" type="text/javascript"></script>

@endsection