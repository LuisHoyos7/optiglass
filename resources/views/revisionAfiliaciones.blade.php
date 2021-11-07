@extends('principal')

@section('content')


<div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
	<div class="container">
		<div class="row">
			<div class="col s10 m6 l6">
				<h5 class="breadcrumbs-title mt-0 mb-0">Revisión de afiliaciones</h5>
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
												<label for="cmbPromotor">Promotor</label>
												<select class="error browser-default" id="cmbPromotor" name="promotor">
												</select>
											</div>

											<div class="col s9 m3">
												<label for="cmbBrigada">Brigada</label>
												<select class="error browser-default" id="cmbBrigada" name="brigada">
												</select>
											</div>

											<div class="input-field col s3 m1">
												<a class="btn-floating btn-medium waves-effect waves-light right gradient-45deg-indigo-purple gradient-shadow" id="btnBuscar" href="#" data-target="slide-out-right">
													<i class="material-icons">search</i>
												</a>
											</div>

										</div>

									</div>
								</li>
							</ul>

							<div class="row">
								<div class="col s12">
									<table id="data-table-simple" class="display nowrap" width="100%">
										<thead>
											<tr>
												<th></th>
												<th></th>
												<th>Brigada</th>
												<th>Promotor</th>
												<th>Afiliaciones</th>
												<th>Abonos</th>
												<th>Prestamo</th>
												<th>Entrega</th>
											</tr>
										</thead>

									</table>
								</div>
							</div>

							<div class="row">
								<div class="input-field col s12">
									<button id="btnDefinir" class="btn waves-effect waves-light right gradient-45deg-indigo-purple gradient-shadow" type="button">Definir
										<i class="material-icons right">note_add</i>
									</button>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>

			<div id="dlgDefinicion" class="modal modal-small">
				<div class="modal-content">
					<a href="#" class="modal-close  waves-light gradient-45deg-indigo-purple gradient-shadow btn btn-floating right"><i class="material-icons right">close</i></a>
					<h5>Definición</h5>

					<form class="formValidate" id="formDefinicion" method="post">

						<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
						<div class="col s12">
							<label for="cmbSubestado">Subestado</label>
							<select class="error browser-default" id="cmbSubestado" name="subestado" data-error=".errorTxt1">

							</select>
							<div class="input-field">
								<div class="errorTxt1"></div>
							</div>
						</div>

						<div class="input-field col s12">
							<label for="txtObservacion">Observación</label>
							<textarea name="observacion" id="txtObservacion" class="materialize-textarea" maxlength="500" data-error=".errorTxt2" placeholder=""></textarea>
							<div class="errorTxt2"></div>
						</div>

						<div class="input-field col s12">
							<button class="btn waves-effect waves-light right submit gradient-45deg-indigo-purple gradient-shadow" type="submit" name="action">Guardar
								<i class="material-icons right">save</i>
							</button>
						</div>

					</form>

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
										<h5>Revision</h5>
									</div>
								</div>
							</div>
						</div>
						<div class="slide-out-right-second-body">
							<div class="col s12">

								<form class="formValidate" id="formRevision" method="put">

									{{ csrf_field() }}
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
										<label for="cmbSubestadoEditar">Subestado</label>
										<select class="error browser-default" id="cmbSubestadoEditar" name="subestado" data-error=".errorTxt3">
											<option value='' disabled selected>Seleccione</option>
										</select>
										<div class="input-field">
											<div class="errorTxt3"></div>
										</div>
									</div>

									<div class="input-field col s12">
										<label for="txtObservacionEditar">Observación</label>
										<textarea name="observacion" id="txtObservacionEditar" class="materialize-textarea" data-error=".errorTxt4" maxlength="500" placeholder=""></textarea>
										<div class="errorTxt4"></div>
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

@include('clientes')


<!-- scripts -->
<script src="app-assets/vendors/data-tables/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="app-assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js" type="text/javascript"></script>
<script src="app-assets/vendors/data-tables/js/dataTables.select.min.js" type="text/javascript"></script>
<script src="app-assets/vendors/data-tables/js/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="app-assets/js/custom/jszip.min.js" type="text/javascript"></script>
<script src="app-assets/js/custom/pdfmake.min.js" type="text/javascript"></script>
<script src="app-assets/js/custom/vfs_fonts.js" type="text/javascript"></script>
<script src="app-assets/js/custom/buttons.html5.min.js" type="text/javascript"></script>
<script src="js/revisionAfiliaciones.js" type="module"></script>
<script src="app-assets/js/scripts/data-tables.js" type="text/javascript"></script>

@endsection