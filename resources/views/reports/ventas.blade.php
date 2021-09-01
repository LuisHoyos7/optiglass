<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Ventas</title>
  </head>

<body>

<table style="width: 100%">
	<tr>
		<td style="width: 20%"><img src="app-assets/images/logo/logo-opti-glass-nuevo-color.png" width="200" height="100"/></td>
		<td style="width: 80%;text-align: center"><h2>PLANTILLAS DE VENTAS</h2></td>
	</tr>
 </table>

 @foreach($encabezados as $encabezado)
  <table style="width: 100%;border-collapse: collapse; font-weight: bold">
  	<tr>
  		<td style="border: solid; width: 20%">CONVENIO</td>
  		<td style="border: solid; width: 40%">{{$encabezado->brigadaDescripcion}}</td>
  		<td style="border: solid; width: 20%">FECHA VENTA</td>
  		<td style="border: solid; width: 20%">{{$encabezado->fecha}}</td>
  	</tr>
  	<tr>
  		<td style="border: solid;">LUGAR DE ENTREGA</td>
  		<td style="border: solid;">{{$encabezado->brigadaDescripcion}}</td>
  		<td style="border: solid;">FECHA ENTREGA</td>
  		<td style="border: solid;"></td>
  	</tr>
  	<tr>
  		<td style="border: solid;">JORNADA</td>
  		<td style="border: solid;"></td>
  		<td style="border: solid;">HORA DE ENTREGA</td>
  		<td style="border: solid;"></td>
  	</tr>
  </table>

  <table style="width: 100%;border-collapse: collapse;text-align: center; margin-top: 15px">
  	<thead>
  		<tr>
	  		<th style="border: solid; width: 30%">NOMBRE</th>
	  		<th style="border: solid; width: 20%">CELULARES</th>
	  		<th style="border: solid; width: 10%">ABONO</th>
	  		<th style="border: solid; width: 10%">SALDO</th>
	  		<th style="border: solid; width: 30%">LENTE</th>
	  	</tr>
 	</thead>
 	<tbody>
 		@foreach($ventas as $venta)
    @if($encabezado->brigada  == $venta->brigada)
    @if($encabezado->fecha    == $venta->fecha)
 		<tr> 
 			<td style="border: solid;">{{$venta->nombreCompleto}}</td>
 			<td style="border: solid;">{{$venta->celular}}{{empty($venta->telefono) ? '' : '-' . $venta->telefono}}</td>
 			<td style="border: solid;">{{$venta->abono}}</td>
 			<td style="border: solid;">{{$venta->saldo}}</td>
 			<td style="border: solid;">{{$venta->lenteDescripcion}}</td>
 		</tr>
    @endif
    @endif
 		@endforeach
 	</tbody>
 </table>
 @endforeach
</body>


</html>