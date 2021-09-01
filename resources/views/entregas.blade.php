@extends('principal')

@section('content')


<div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
	<div class="container">
		<div class="row">
			<div class="col s10 m6 l6">
				<h5 class="breadcrumbs-title mt-0 mb-0">Entregas</h5>
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
												<label for="txtConsecutivoBusqueda">Consecutivo</label>
												<input id="txtConsecutivoBusqueda" name="consecutivoBusqueda" type="text" placeholder="" s>
											</div>

											<div class="col s9 m3">
												<label for="txtFechaBusqueda">Fecha</label>
												<input id="txtFechaBusqueda" name="fechaBusqqueda" class="datepicker" type="text" placeholder="" autocomplete="off">
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
									<table id="data-table-simple" class="display nowrap" style="width:100%">
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
												<th>Subestado</th>
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
				<div id="slide-out-right" class="slide-out-right-sidenav sidenav rightside-navigation">
					<div class="row">
						<div class="slide-out-right-title">
							<div class="col s12 border-bottom-1 pb-0 pt-1">
								<div class="row">
									<div class="col s2 pr-0 center">
										<i class="material-icons vertical-text-middle"><a href="#" class="sidenav-close">clear</a></i>
									</div>
									<div class="col s10 pl-0">
										<h5>Entrega</h5>
									</div>
								</div>
							</div>
						</div>
						<div class="slide-out-right-body">
							<div class="col s12">

								<form class="formValidate" id="formEntrega" method="post">

									{{ csrf_field() }}
									<div class="input-field col s12">
										<label for="txtConsecutivo">Consecutivo</label>
										<input readonly id="txtConsecutivo" name="consecutivo" type="text" data-error=".errorTxt1" placeholder="">
										<div class="errorTxt1"></div>
									</div>

									<div class="input-field col s12">
										<label for="txtFecha">Fecha venta</label>
										<input readonly type="text" name="fecha" id="txtFecha" placeholder="">
									</div>

									<div class="input-field col s12">
										<label for="txtBrigada">Brigada</label>
										<input readonly id="txtBrigada" name="brigada" type="text" placeholder="">
									</div>

									<div class="input-field col s12">
										<label for="txtNombre">Nombre</label>
										<input readonly id="txtNombre" name="nombre" type="text" placeholder="">
									</div>

									<div class="input-field col s12">
										<label for="txtAbono">Abono</label>
										<input readonly id="txtAbono" name="abono" type="text" placeholder="">
									</div>

									<div class="input-field col s12">
										<label for="txtSaldo">Saldo</label>
										<input readonly id="txtSaldo" name="saldo" type="text" placeholder="">
									</div>

									<div class="input-field col s12">
										<label for="txtPendiente">Pendiente</label>
										<input id="txtPendiente" name="pendiente" type="number" maxlength="10" data-error=".errorTxt2" placeholder="">
										<div class="errorTxt2"></div>
									</div>

									<div class="col s12">
										<label for="cmbSubestado">Subestado</label>
										<select class="error browser-default" id="cmbSubestado" name="subestado" data-error=".errorTxt3">

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


		</div>
	</div>
</div>




<!-- scripts -->
<script src="app-assets/vendors/data-tables/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="app-assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js" type="text/javascript"></script>
<script src="js/entregas.js" type="module"></script>
<script src="app-assets/js/scripts/data-tables.js" type="text/javascript"></script>

@endsection