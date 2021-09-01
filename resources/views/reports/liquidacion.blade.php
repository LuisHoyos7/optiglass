<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Liquidación</title>
  </head>

<body>
  @foreach($liquidaciones as $liquidacion)	
  <h4>PROMOTOR: {{ $liquidacion->nombrePromotor }}</h4>
  <table style="width: 100%;border-collapse: collapse;text-align: center;">
  	<thead>
	  <tr>
		<th style="border: solid;">FECHA INICIO</th>
		<th style="border: solid;">FECHA FIN</th>
		<th style="border: solid;">GANANCIA</th>
		<th style="border: solid;">PRESTAMO</th>
		<th style="border: solid;">SALDO A PAGAR</th>
	  </tr>
	</thead>
	<tbody>
		    <tr>
		    	<td style="border: solid;">{{ $liquidacion->fechaInicio }}</td>
			    <td style="border: solid;">{{ $liquidacion->fechaFin }}</td>
			    <td style="border: solid;">{{ $liquidacion->ganancia }}</td>
			    <td style="border: solid;">{{ $liquidacion->prestamo }}</td>
			    <td style="border: solid;">{{ $liquidacion->ganancia - $liquidacion->prestamo }}</td>
			</tr>
	</tbody>
	<tfoot>
		<tr>
	    	<td></td>
		    <td></td>
		    <td></td>
		    <td style="border: solid; font-weight: bold;">SUBTOTAL</td>
		    <td style="border: solid;">$ {{ $liquidacion->ganancia - $liquidacion->prestamo }}</td>
		</tr>
		<tr>
	    	<td></td>
		    <td></td>
		    <td></td>
		    <td style="border: solid;font-weight: bold;">ERRORES</td>
		    <td style="border: solid;">$ {{ $liquidacion->valorErrores }}</td>
		</tr>
		<tr>
	    	<td></td>
		    <td></td>
		    <td></td>
		    <td style="border: solid;font-weight: bold;">TOTAL</td>
		    <td style="border: solid;">$ {{ $liquidacion->total }}</td>
		</tr>
	</tfoot>
  </table>
  @if($errores != null)
  <h5>LISTA DE ERRORES</h5>
  <table style="width: 100%;border-collapse: collapse;text-align: center;">
  	<thead>
  		<tr>
	  		<th style="border: solid;">FECHA</th>
	  		<th style="border: solid;">CONSECUTIVO</th>
	  		<th style="border: solid;">BRIGADA</th>
	  		<th style="border: solid;">ERROR</th>
	  	</tr>
  	</thead>
  	<tbody style="font-size: 12px">
		@foreach($errores as $error)
		@if($error->liquidacion == $liquidacion->id)	
  		<tr>
	    	<td style="border: solid;">{{ $error->fecha }}</td>
		    <td style="border: solid;">{{ $error->consecutivo }}</td>
		    <td style="border: solid;">{{ $error->brigada }}</td>
		    <td style="border: solid;">{{ $error->error }}</td>
		</tr>
		@endif
		@endforeach
  	</tbody>
  </table>
  <P style="text-align: center;">------------------------------------------------------------------------------------------------------------------</p>
  @endif
  @endforeach
  @if($resumen != null)
  <h4>Resumen</h4>
  <table style="width: 100%;border-collapse: collapse;text-align: center;">
  	<thead>
	  <tr>
		<th style="border: solid;">FECHA INICIO</th>
		<th style="border: solid;">FECHA FIN</th>
		<th style="border: solid;">GANANCIA</th>
		<th style="border: solid;">PRESTAMO</th>
		<th style="border: solid;">SALDO A PAGAR</th>
	  </tr>
	</thead>
	<tbody>
		    <tr>
		    	<td style="border: solid;">{{ $resumen->fechaInicio }}</td>
			    <td style="border: solid;">{{ $resumen->fechaFin }}</td>
			    <td style="border: solid;">{{ $resumen->ganancia }}</td>
			    <td style="border: solid;">{{ $resumen->prestamo }}</td>
			    <td style="border: solid;">{{ $resumen->ganancia - $resumen->prestamo }}</td>
			</tr>
	</tbody>
	<tfoot>
		<tr>
	    	<td></td>
		    <td></td>
		    <td></td>
		    <td style="border: solid; font-weight: bold;">SUBTOTAL</td>
		    <td style="border: solid;">$ {{ $resumen->ganancia - $resumen->prestamo }}</td>
		</tr>
		<tr>
	    	<td></td>
		    <td></td>
		    <td></td>
		    <td style="border: solid;font-weight: bold;">ERRORES</td>
		    <td style="border: solid;">$ {{ $resumen->valorErrores }}</td>
		</tr>
		<tr>
	    	<td></td>
		    <td></td>
		    <td></td>
		    <td style="border: solid;font-weight: bold;">TOTAL</td>
		    <td style="border: solid;">$ {{ $resumen->total }}</td>
		</tr>
	</tfoot>
  </table>
  @endif
</body>
</html>