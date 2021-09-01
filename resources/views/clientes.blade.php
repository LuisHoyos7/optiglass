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
						<div class="col s8 pl-0">
							<h5>Cliente</h5>
						</div>
						<div class="col s2 pr-0 center">
							<a class="waves-effect waves-block waves-light  dropdown-trigger" data-target="notifications-dropdown">
								<i id="alert-icon" style="font-size: 2.5rem;" class="material-icons vertical-text-middle">notifications_none</i>
							</a>
						</div>
					</div>
				</div>
			</div>
			<div class="slide-out-right-body">
				<div class="col s12">

					<form class="formValidate" id="formCliente" method="put">

						{{ csrf_field() }}
						<div class="input-field col s12">
							<label for="txtNombres">Nombres</label>
							<input id="txtNombres" name="nombres" type="text" data-error=".errorTxt11" maxlength="50" placeholder="">
							<div class="errorTxt11"></div>
						</div>

						<div class="input-field col s12">
							<label for="txtApellidos">Apellidos</label>
							<input id="txtApellidos" name="apellidos" type="text" data-error=".errorTxt12" maxlength="50" placeholder="">
							<div class="errorTxt12"></div>
						</div>

						<div class="input-field col s12">
							<label for="txtCelular">Celular</label>
							<input id="txtCelular" name="celular" type="tel" minlength="10" maxlength="10" placeholder="">
							<i style="color: red;cursor: pointer;display: none;" class="celular material-icons right">notifications_active</i>
						</div>

						<div class="input-field col s12">
							<label for="txtTelefono">Teléfono</label>
							<input id="txtTelefono" name="telefono" type="tel" maxlength="10" placeholder="">
							<i style="color: red;cursor: pointer;display: none;" class="telefono material-icons right">notifications_active</i>
						</div>

						<div class="col s12">
							<label for="cmbProvincia">Provincia</label>
							<select class="error browser-default" id="cmbProvincia" name="provincia" data-error=".errorTxt13">
								<option value="" disabled selected>Seleccione</option>
							</select>
							<div class="input-field">
								<div class="errorTxt13"></div>
							</div>
						</div>

						<div class="col s12">
							<label for="cmbCanton">Cantón</label>
							<select class="error browser-default" id="cmbCanton" name="canton" data-error=".errorTxt14">
								<option value="" disabled selected>Seleccione</option>
							</select>
							<div class="input-field">
								<div class="errorTxt14"></div>
							</div>
						</div>

						<div class="col s12">
							<label for="cmbParroquia">Parroquia</label>
							<select class="error browser-default" id="cmbParroquia" name="parroquia" data-error=".errorTxt15">
								<option value="" disabled selected>Seleccione</option>
							</select>
							<div class="input-field">
								<div class="errorTxt15"></div>
							</div>
						</div>


						<div class="input-field col s12">
							<label for="txtDireccion">Direccion</label>
							<input id="txtDireccion" name="direccion" type="text" data-error=".errorTxt16" maxlength="100" placeholder="">
							<div class="errorTxt16"></div>
						</div>


						<div class="input-field col s12">
							<button class="btn waves-effect waves-light right submit gradient-45deg-indigo-purple gradient-shadow" type="submit">Guardar
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

<ul id='notifications-dropdown' class='dropdown-content'>
	<li>
		<h6>ALERTA</h6>
	</li>
	<li class="divider" tabindex="0"></li>
	<div id="notificationContent">

	</div>
</ul>

<div id="dlgTelefonoNotificacion" class="modal">
	<div class="modal-content">

		<ul id="ulNotificacion">

		</ul>


	</div>
</div>

<!-- Scripts -->
<script src="js/clientes.js" type="module"></script>