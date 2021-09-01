@extends('principal')

@section('content')

<div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
	<div class="container">
		<div class="row">
			<div class="col s6">
				<h5 class="breadcrumbs-title mt-0 mb-0">Asistencia</h5>
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
								<form class="formValidate" id="formAsistencia" method="post">
									{{ csrf_field() }}
									<div class="row">
										<div class="input-field col s12 m6">
											<label for="txtConsecutivo">Consecutivo</label>
											<input readonly id="txtConsecutivo" name="consecutivo" type="text" data-error=".errorTxt1" placeholder=" ">
											<div class="errorTxt1"></div>
										</div>

										<div class="input-field col s12 m6">
											<label for="txtNumeroDocumento">No documento</label>
											<input id="txtNumeroDocumento" name="numeroDocumento" data-error=".errorTxt2" type="text" maxlength="20" placeholder=" ">
											<div class="errorTxt2"></div>
										</div>
									</div>

									<div class="row">
										<div class="input-field col s12 m6">
											<label for="txtNombres">Nombres</label>
											<input id="txtNombres" name="nombres" type="text" data-error=".errorTxt3" maxlength="50" placeholder="">
											<div class="errorTxt3"></div>
										</div>

										<div class="input-field col s12 m6">
											<label for="txtApellidos">Apellidos</label>
											<input id="txtApellidos" name="apellidos" type="text" data-error=".errorTxt4" maxlength="50" placeholder="">
											<div class="errorTxt4"></div>
										</div>
									</div>

									<div class="row">
										<div class="input-field col s12 m6">
											<label for="txtCelular">Celular</label>
											<input id="txtCelular" name="celular" type="tel" data-error=".errorTxt5" minlength="10" maxlength="10" placeholder="">
											<div class="errorTxt5"></div>
										</div>

										<div class="input-field col s12 m6">
											<label for="txtTelefono">Teléfono</label>
											<input id="txtTelefono" name="telefono" type="tel" maxlength="10" placeholder="">
										</div>
									</div>

									<div class="row">
										<div class="input-field col s12 m6">
											<label for="txtPromotor">Promotor</label>
											<input readonly id="txtPromotor" name="promotor" type="text" maxlength="50" placeholder="">
										</div>

										<div class="col s12 m6">
											<label for="cmbBrigada">Brigada</label>
											<select class="error browser-default" id="cmbBrigada" name="brigada" data-error=".errorTxt6">
												<option value="" disabled selected>Seleccione</option>
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
										<div class="input-field col s12 m4">
											<label for="txtAbono">Abono</label>
											<input readonly id="txtAbono" name="abono" type="number" maxlength="10" placeholder=" ">
										</div>

										<div class="input-field col s12 m4 ">
											<label for="txtSaldo">Saldo</label>
											<input readonly id="txtSaldo" name="saldo" type="number" maxlength="10" placeholder=" ">
										</div>

										<div class="input-field col s12 m4 ">
											<label for="txtPendiente">Pendiente</label>
											<input id="txtPendiente" name="pendiente" type="number" data-error=".errorTxt11" maxlength="10" placeholder=" ">
											<div class="errorTxt11"></div>
										</div>
									</div>

									<div class="input-field col s12 m3 l3 xl2 offset-m6 offset-l6 offset-xl8">
										<button id="btnGuardar" class="col s12 btn waves-effect waves-light submit gradient-45deg-indigo-purple gradient-shadow" type="submit" name="action">Guardar
											<i class="material-icons right">save</i>
										</button>
									</div>

									<div class="input-field col s12 m3 l3 xl2">
										<button id="btnNuevo" class="col s12 btn waves-effect waves-light submit gradient-45deg-indigo-purple gradient-shadow modal-trigger" data-target="dlgAfiliaciones" type="button" name="action">Clientes
											<i class="material-icons right">person</i>
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

<div id="dlgAfiliaciones" class="modal">
	<div class="modal-content">
		<a href="#" class="modal-close  waves-light gradient-45deg-indigo-purple gradient-shadow btn btn-floating right"><i class="material-icons right">close</i></a>
		<h5>Afiliaciones</h5>

		<div class="row">
			<div class="col s12">
				<table id="data-table-simple" class="display nowrap">
					<thead>
						<tr>
							<th></th>
							<th>Consecutivo</th>
							<th>Nombre</th>
							<th>Brigada</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
		<div class="row">
			<div class="input-field col s12">
				<button id="btnNuevaAfiliacion" class="btn waves-effect right waves-light submit gradient-45deg-indigo-purple gradient-shadow modal-trigger" data-target="dlgNuevo" type="button" name="action">Nuevo
					<i class="material-icons right">add_box</i>
				</button>
			</div>
		</div>

	</div>
</div>

<div id="dlgNuevo" class="modal modal-small">
	<div class="modal-content">
		<a href="#" class="modal-close  waves-light gradient-45deg-indigo-purple gradient-shadow btn btn-floating right"><i class="material-icons right">close</i></a>
		<h5>Nuevo</h5>

		<form class="formValidate" id="formNuevo" method="post">
			{{ csrf_field() }}
			<div class="input-field col s12">
				<label for="txtConsecutivoNuevo">Consecutivo</label>
				<input id="txtConsecutivoNuevo" name="consecutivo" type="text" data-error=".errorTxt20" placeholder=" ">
				<div class="errorTxt20"></div>
			</div>
			<div class="col s12">
				<label for="cmbBrigadaNuevo">Brigada</label>
				<select class="error browser-default" id="cmbBrigadaNuevo" name="brigada" data-error=".errorTxt21">
				</select>
				<div class="input-field">
					<div class="errorTxt21"></div>
				</div>
			</div>
			<div class="input-field col s12" style="text-align: right;">
				<button id="btnAgregar" class="btn waves-effect waves-light submit gradient-45deg-indigo-purple gradient-shadow" type="submit" name="action">Agregar
					<i class="material-icons right">add_box</i>
				</button>
			</div>
		</form>

	</div>
</div>


<!-- Scripts -->
<script src="app-assets/vendors/data-tables/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="js/asistencias.js" type="module"></script>
<script src="app-assets/js/scripts/data-tables.js" type="text/javascript"></script>

@endsection