<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comunes\BaseDatos;
use App\Comunes\Respuesta;
use App\Comunes\Utilidades;
use PDF;
use Illuminate\Support\Collection;

class ReportesLiquidacionControlador extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return Utilidades::validarPermiso('reportesLiquidacion');
    }

     public function consultar()
    {

    	$resultado = null;

    	if (!empty(request()->promotor))
        {

	        $baseDatos = new BaseDatos();           
	        $baseDatos->conectarBaseDatos();            

	        $listaCampos  = "  l.id ";
	        $listaCampos .= ", l.promotor ";
	        $listaCampos .= ", (select u.nombre from usuarios u where u.codigo = l.promotor) as nombrePromotor";
			$listaCampos .= ", l.fecha_inicio fechaInicio ";
	        $listaCampos .= ", l.fecha_fin fechaFin ";
	        $listaCampos .= ", l.afiliaciones";
	    	$listaCampos .= ", l.ganancia";
	    	$listaCampos .= ", l.prestamo";
	    	$listaCampos .= ", l.errores";
	        $listaCampos .= ", l.valor_errores as valorErrores";
	        $listaCampos .= ", l.total";                  

	        $tabla = " liquidaciones l ";
	        
	        $condiciones  = " where promotor = '" . request()->promotor . "'";

	        if (!empty(request()->fechaInicio) && !empty(request()->fechaFin))
	        {
				$condiciones .= " and date(fecha) >= '". request()->fechaInicio ."'";
				$condiciones .= " and date(fecha) <= '". request()->fechaFin ."'";
			} 
			
			if (!empty(request()->fechaInicio) && empty(request()->fechaFin))
	        {
	        	$condiciones .= " and date(fecha) >= '". request()->fechaInicio ."'";
			}  
			
			if (empty(request()->fechaInicio) && !empty(request()->fechaFin))
	        {
	        	$condiciones .= " and date(fecha) <= '". request()->fechaFin ."'";
			}  

	        $condiciones .= " order by fecha ";
	      
	        $baseDatos->consultarRegistros($listaCampos, $tabla, $condiciones);

	        while ($fila = mysqli_fetch_assoc($baseDatos->getResultado() ))
			{
			    $resultado[] = $fila;
			    
			}
	    
	        $baseDatos->liberarResultado();
	        
	        $baseDatos->desconectarBaseDatos(); 
    	}

        return response()->json($resultado);

    }

    public function imprimir() 
    {
    
	   $liquidacion = json_decode(request()->registros,false);
       $errores =  json_decode(json_encode($this->consultarErrores(json_decode(request()->registros,false))),false);
       $resumen =  $this->calcularResumen($liquidacion);
        $data = [
          'liquidaciones' => $liquidacion
		  ,'errores' => $errores
		  ,'resumen' => $resumen
        ];

		$pdf = PDF::loadView('reports.liquidacion', $data);  
        ob_end_clean();
        return $pdf->stream('liquidacion.pdf');
    }

    public function consultarErrores($registros)
    {

        $errores = null;
     	
        if ($registros != null)
        {

	        $baseDatos = new BaseDatos();           
	        $baseDatos->conectarBaseDatos();
	        
	        foreach ($registros as $fila) 
	        { 
				$listaCampos  = "  l.id as liquidacion ";
		        $listaCampos .= ", q.fecha_registro as fecha ";
		        $listaCampos .= ", a.consecutivo ";
		        $listaCampos .= ", (select b.descripcion from brigadas b where b.id = a.brigada) as brigada ";
		        $listaCampos .= ", (select e.descripcion from errores e where e.numero = q.error) as error";

		        $tabla = "afiliaciones a, gastos_ganancias g, liquidaciones l, quejas q";
		        
		        $condiciones  = " where a.gasto_ganancia    = g.id ";
		        $condiciones .= " and   g.lote 		        = l.id ";
		        $condiciones .= " and   a.id 		        = q.afiliacion ";
		        $condiciones .= " and   l.id      	        = '" . $fila->id . "'";
		        $condiciones .= " and   q.estado 	        = 'A'";

		        $baseDatos->consultarRegistros($listaCampos, $tabla, $condiciones);

		        while ($fila = mysqli_fetch_assoc($baseDatos->getResultado() ))
		        {
		            $errores[] = $fila;
		            
		        }

		    }
	    
	        $baseDatos->liberarResultado();
	        
	        $baseDatos->desconectarBaseDatos(); 
        
        }

        return $errores;

	}
	
	public function calcularResumen($registros)
	{
		$collection = collect($registros);
		$resumen = array("fechaInicio" => $collection->min('fechaInicio'),
						"fechaFin" => $collection->max('fechaFin'),
						"ganancia" => $collection->sum('ganancia'),
						"prestamo" => $collection->sum('prestamo'),
						"valorErrores" => $collection->sum('valorErrores'),
						"total" => $collection->sum('total'));
		
		return (object) $resumen;
	}


}
