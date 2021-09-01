<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comunes\BaseDatos;
use PDF;

class ConsultarAfiliacionesControlador extends Controller
{
    //
    public function consultarEncabezado($promotores,$fecha)
    {

    	$resultado = null;

        $baseDatos = new BaseDatos();           
        $baseDatos->conectarBaseDatos();
        
        $listaCampos  = "  a.fecha_registro as fecha";
        $listaCampos .= ", a.promotor ";
    	$listaCampos .= ", (select u.nombre from usuarios u where u.codigo = a.promotor) as promotorNombre ";
    	$listaCampos .= ", a.brigada";
    	$listaCampos .= ", (select b.descripcion from brigadas b where b.numero = a.brigada) as brigadaDescripcion ";
        
        $tabla = "afiliaciones a";
        
        $condiciones  = " where a.promotor in ( ";
        for ($indice=0; $indice < count($promotores); $indice++) { 
        	
        	$condiciones .= "'". $promotores[$indice]  ."',";

        	if (($indice+1)==count($promotores)) {
        		$condiciones .= "'')";
        	}

        }
		$condiciones .= " and   a.fecha_registro = '". $fecha[0] . "'";		
      	$condiciones .= " group by a.fecha_registro, a.promotor, a.brigada ";	
      	
        $baseDatos->consultarRegistros($listaCampos, $tabla, $condiciones);

        while ($fila = mysqli_fetch_assoc($baseDatos->getResultado() ))
		{
		    $resultado[] = $fila;
		    
		}
    
        $baseDatos->liberarResultado();
        
        $baseDatos->desconectarBaseDatos(); 
       	
        return $resultado;

    }

    public function consultar()
    {

    	$resultado = null;

    	if ((!empty(request()->promotor) and !empty(request()->fecha))
    		|| (!empty(request()->promotor) and !empty(request()->brigada))
    	 	|| !empty(request()->fecha)	
    	 	|| !empty(request()->brigada))
    	{	
	        $baseDatos = new BaseDatos();           
	        $baseDatos->conectarBaseDatos();
	        
	        $listaCampos  = "  a.id as codigo ";
	        $listaCampos .= ", concat(c.nombres,' ',c.apellidos) as nombre ";
	        $listaCampos .= ", c.celular";
	    	$listaCampos .= ", c.telefono";
	    	$listaCampos .= ", a.abono";
	    	$listaCampos .= ", (5-a.abono) as saldo";
	    	$listaCampos .= ", a.fecha_registro as fecha";
	    	$listaCampos .= ", a.promotor";
	    	$listaCampos .= ", (select u.nombre from usuarios u where u.codigo = a.promotor) as promotorNombre ";
	    	$listaCampos .= ", a.brigada ";
	    	$listaCampos .= ", (select b.descripcion from brigadas b where b.numero = a.brigada) as brigadaDescripcion ";
	        
	        $tabla = "afiliaciones a, clientes c";
	        
	        $condiciones  = " where a.id_cliente = c.id ";
	        if (!empty(request()->promotor))
	        {
	        	$condiciones .= " and   a.promotor   = '". request()->promotor . "'";
	        }
	        if (!empty(request()->fecha))
	        {
	        	$condiciones .= " and   a.fecha_registro = '". request()->fecha . "'";	
	        }	
	        if (!empty(request()->brigada))
	        {
	        	$condiciones .= " and   a.brigada  	  in (select b.numero from brigadas b where b.descripcion like '%". request()->brigada ."%')";	
	        }
	        
	      
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

    public function imprimir($afiliaciones)
    {
    	

	    $arrayPrincipal = json_decode($afiliaciones,true);
	    $promotores = array_unique(array_column($arrayPrincipal, 'promotor'));
	    $fecha 	= array_unique(array_column($arrayPrincipal, 'fecha'));
	 	
	 	$encabezados = json_decode(json_encode($this->consultarEncabezado($promotores,$fecha),false));
	 
	 	$data = [
	 			 'encabezados'  => $encabezados
          		,'afiliaciones' => json_decode($afiliaciones,false)
        		];
        		
        			//dd(json_decode(json_encode($encabezados),false));	
        		
        		
		$pdf = PDF::loadView('reports.afiliaciones',$data);  
	    ob_end_clean();
	    return $pdf->stream('afiliaciones.pdf');
    }
}
