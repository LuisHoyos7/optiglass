@extends('principal')

@section('content')

	
			<div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">	
				<div class="container">
					<div class="row">
						<div class="col s10 m6 l6">
							<h5 class="breadcrumbs-title mt-0 mb-0">Cargar maletines</h5>
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
										
										<form class="formValidate" id="formCarga" method="post">
											<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
											<div class="row">
												<div class="col s12">
												  <table id="data-table-simple" class="display nowrap" width="100%">
													<thead>
													  <tr>
														<th></th>
														<th>Número</th>
														<th>Brigada</th>
														<th>Carga</th>
													  </tr>
													</thead>
													
												  </table>
												</div>
											</div>

											<div class="row">
												<div class="input-field col s12">
													<button id="btnCargar" class="btn waves-effect waves-light right gradient-45deg-indigo-purple gradient-shadow" type="submit">Cargar
														<i class="material-icons right">note_add</i>
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

	<!-- scripts -->
	<script src="app-assets/vendors/data-tables/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="app-assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js" type="text/javascript"></script>
    <script src="app-assets/vendors/data-tables/js/dataTables.select.min.js" type="text/javascript"></script>
	<script src="js/cargarMaletines.js" type="module"></script>
    <script src="app-assets/js/scripts/data-tables.js" type="text/javascript"></script>

@endsection


