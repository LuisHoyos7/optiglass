<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Afiliaciones</title>
  </head>

@foreach($encabezados as $encabezado)
<table style="border-collapse: collapse;">
<tbody>
	<tr>
		<td style="border: solid;width: 100px">
			FECHA
		</td>
		<td style="border: solid;width: 250px">
			{{$encabezado->fecha}}
		</td>
	</tr>
	<tr>
		<td style="border: solid;">
			BRIGADA
		</td>
		<td style="border: solid;">
			{{$encabezado->brigadaDescripcion}}
		</td>
	</tr>
	<tr>
		<td style="border: solid;">
			PROMOTOR
		</td>
		<td style="border: solid;">
			{{$encabezado->promotorNombre}}
		</td>
	</tr>
</tbody>
</table>

<body>
  <table style="width: 100%;border-collapse: collapse;text-align: center;margin-top: 10px;margin-bottom: 20px;">
  	<thead>
	  <tr>
		<th style="border: solid;">CÓDIGO</th>
		<th style="border: solid;">NOMBRE</th>
		<th style="border: solid;">CELULAR</th>
		<th style="border: solid;">TELÉFONO</th>
		<th style="border: solid;">ABONO</th>
		<th style="border: solid;">SALDO</th>
	  </tr>
	</thead>
	<tbody>
		@foreach($afiliaciones as $afiliacion)
		@if($encabezado->promotor == $afiliacion->promotor)
		@if($encabezado->brigada  == $afiliacion->brigada)
		@if($encabezado->fecha    == $afiliacion->fecha)
		<tr>
			<td style="border: solid;width: 100px">{{$afiliacion->codigo}}</td>
			<td style="border: solid;width: 250px">{{$afiliacion->nombre}}</td>
			<td style="border: solid;">{{$afiliacion->celular}}</td>
			<td style="border: solid;">{{$afiliacion->telefono}}</td>
			<td style="border: solid;">{{$afiliacion->abono}}</td>
			<td style="border: solid;">{{$afiliacion->saldo}}</td>
		</tr>	
		@endif
		@endif
		@endif	
		@endforeach
	</tbody>
  </table>
</body>
@endforeach
</html>