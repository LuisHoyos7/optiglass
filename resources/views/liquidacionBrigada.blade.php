@extends('principal')

@section('content')


<div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
	<div class="container">
		<div class="row">
			<div class="col s10 m6 l6">
				<h5 class="breadcrumbs-title mt-0 mb-0">Liquidaciones de Brigadas</h5>
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
									<div class="collapsible-body" style="padding-top:0;padding-bottom:10;">

										<div class="row">

										<form class="formValidate" action="{{ route('liquidacionBrigada.store') }}" method="post">
									{{ csrf_field() }}

											<div class="col s9 m6">
												<label for="cmbBrigada">Brigada</label>
												<select class="error browser-default" id="cmbBrigada" name="brigada">
													<option value="">Seleccione..</option>
										@foreach($brigadas as $filas)
											<option value="{{ $filas->id }}">{{ $filas->descripcion }}</option>
										@endforeach
												</select>
											</div>

							
						
											
											<div class="input-field col s3 m1">
												<button type="submit" class="btn-floating btn-medium waves-effect waves-light right gradient-45deg-indigo-purple gradient-shadow" id="btnBuscar" href="#" data-target="slide-out-right">
													<i class="material-icons">search</i>
												</button>
											</div>
										</form>

										</div>

									</div>
								</li>
							</ul>

							<div class="row">
								<div class="col s12">
									<table id="data-table-simple" class="display nowrap" width="100%">
										<thead>
											<tr>
												
												<th>Brigada</th>
												<th>Promotor</th>
												<th>Afiliaciones</th>
												<th>Abonos</th>
												<th>Prestamo</th>
												<th>Entrega</th>
											</tr>
										</thead>
										<tbody>
										@foreach($liquidacionBrigadas as $filas)
										<tr>
											<td>{{ $filas->brigada}}</td>
											<td>{{ $filas->promotor}}</td>
											<td>{{ $filas->afiliaciones}}</td>
											<td>{{ $filas->abonos}}</td>
											<td>{{ $filas->prestamo}}</td>
											<td>{{ $filas->entrega}}</td>

										</tr>
										@endforeach
									</tbody>

									</table>
									
								</div>
							</div>

						

						</div>
					</div>
				</div>
			</div>


		</div>
	</div>
</div>


@if(!empty($gastos))
<div class="col s12">
	<div class="container">
		<div class="section">
			<div id="validations" class="card card-tabs">
						<div class="card-content">
			<p>Numero de Afiliaciones {{$gastos[0]->numero_afiliaciones}}<P>
			<p>Dinero entregado de Afiliaciones $ {{$gastos[0]->valor_afiliaciones}}<P><br>
			<p>Gastos Coordinador $ {{$gastos_coordinador->desayuno_coordinador + 
										$gastos_coordinador->almuerzo_coordinador +
										$gastos_coordinador->cena_coordinador +
										$gastos_coordinador->hotel_coordinador +
										$gastos_coordinador->transporte_coordinador }}</p>
			<p>Desayunos Promotores $ 	{{$gastos[0]->gasto_desayuno}}</p>
			<p>Hotel Prometores $ 		{{$gastos[0]->gasto_hotel}}</p>
			<p>Transporte Promotores $ 	{{$gastos[0]->gasto_transporte}}</p>
			<p>Otros Gastos $ 			{{$gastos_coordinador->otros_gastos_brigada}}</p>
			<p>Descripción Otros Gastos : <b>{{$gastos_coordinador->descripcion_otros_gastos}}</b> </p>
		</div>
		<div class="card-content">
			<p> TOTAL GANANCIA BRIGADA ${{$gastos[0]->valor_afiliaciones - $gastos[0]->gasto_desayuno - $gastos[0]->gasto_hotel - $gastos[0]->gasto_transporte - ($gastos_coordinador->desayuno_coordinador + 
										$gastos_coordinador->almuerzo_coordinador +
										$gastos_coordinador->cena_coordinador +
										$gastos_coordinador->hotel_coordinador +
										$gastos_coordinador->transporte_coordinador +
										$gastos_coordinador->otros_gastos_brigada)}}<P>
			
		</div>
	</div>
		</div>
	</div>
</div>
@endif


<!-- scripts -->
<script src="app-assets/vendors/data-tables/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="app-assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js" type="text/javascript"></script>
<script src="app-assets/vendors/data-tables/js/dataTables.select.min.js" type="text/javascript"></script>
<script src="app-assets/vendors/data-tables/js/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="app-assets/js/custom/jszip.min.js" type="text/javascript"></script>
<script src="app-assets/js/custom/pdfmake.min.js" type="text/javascript"></script>
<script src="app-assets/js/custom/vfs_fonts.js" type="text/javascript"></script>
<script src="app-assets/js/custom/buttons.html5.min.js" type="text/javascript"></script>
<script src="app-assets/js/scripts/data-tables.js" type="text/javascript"></script>

@endsection
