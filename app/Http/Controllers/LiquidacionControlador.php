<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comunes\BaseDatos;
use App\Comunes\Respuesta;
use App\Comunes\Utilidades;

class LiquidacionControlador extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return Utilidades::validarPermiso('liquidacion');
    }

    public function guardar(Request $request)
    {
        
        $respuesta = null;

        $baseDatos = new BaseDatos();
        $baseDatos->conectarBaseDatos();

        /* deshabilitar autocommit */
        mysqli_autocommit($baseDatos->getConexion(), false);

        $listaCampos  = "  promotor";
        $listaCampos .= ", fecha_inicio";
        $listaCampos .= ", fecha_fin";
        $listaCampos .= ", afiliaciones";
        $listaCampos .= ", ganancia";
        $listaCampos .= ", prestamo";
        $listaCampos .= ", errores";
        $listaCampos .= ", valor_errores";
        $listaCampos .= ", total";
        $listaCampos .= ", usuario_crea"; 
        $listaCampos .= ", fecha";

        $listaValores  = "  '" . $request->promotor . "'";
        $listaValores .= ", '" . $request->fechaInicio . "'";
        $listaValores .= ", '" . $request->fechaFin . "'";
        $listaValores .= ", '" . $request->afiliaciones . "'";
        $listaValores .= ", '" . $request->ganancia . "'";
        $listaValores .= ", '" . $request->prestamo . "'";
        $listaValores .= ", '" . $request->errores . "'";
        $listaValores .= ", '" . $request->valorErrores . "'";
        $listaValores .= ", '" . (($request->ganancia - $request->prestamo) - $request->valorErrores) . "'";
        $listaValores .= ", '" . request()->user()->codigo . "'"; 
        $listaValores .= ", '" . Date('Y-m-d H:i:s') . "'";
                        
        $tabla = "liquidaciones";
                        
        $baseDatos->insertarRegistroExplicito($listaCampos, $listaValores, $tabla);    

        $respuesta = $this->agregarLote($baseDatos,$request->liquidacion);
        
        if ($respuesta->getEstado() == 'OK')
        {
            /* insertar commit */
            mysqli_commit($baseDatos->getConexion());
        }
        else
        {
            /* Revertir */
            mysqli_rollback($baseDatos->getConexion());
        }

        $baseDatos->desconectarBaseDatos();

        return response()->json($respuesta);
    }

    public function agregarLote($baseDatos, $liquidacion)
    {
            $respuesta = new Respuesta();

            $lote = $this->obtenerLote()['lote'];
            $liquidacionObjeto = json_decode($liquidacion);
            
            foreach ($liquidacionObjeto as $fila) {
            	
	            $listaCampos  = "  lote  = '" . $lote . "'";
	            $listaCampos .= ", usuario_modifica  = '" . request()->user()->codigo . "'";
	            $listaCampos .= ", fecha  = '" . Date('Y-m-d H:i:s') . "'";
	                            
	            $tabla = "gastos_ganancias";

                $condiciones  = " brigada = '" . $fila->brigada . "'";
                $condiciones .= " and  promotor = '". $fila->promotor ."'";
	            $condiciones .= " and  fecha_operacion = '". $fila->fecha ."'";
	            $condiciones .= " and  lote is null";
	                            
	            $baseDatos->actualizarRegistro($listaCampos, $tabla, $condiciones);    

            }

            $respuesta->setEstado('OK');

            return $respuesta;
    }

    public function obtenerLote()
    {

        $resultado = null;

        $baseDatos = new BaseDatos();           
        $baseDatos->conectarBaseDatos();
        

        $listaCampos  = "  (ifnull(max(id),0) + 1) as lote ";

        $tabla = " liquidaciones ";
        
        $condiciones   = " ";

        $baseDatos->consultarRegistros($listaCampos, $tabla, $condiciones);

        while ($fila = mysqli_fetch_assoc($baseDatos->getResultado() ))
        {
            $resultado[] = $fila;
            
        }
    
        $baseDatos->liberarResultado();
        
        $baseDatos->desconectarBaseDatos(); 

        return $resultado[0];

    }

     public function consultar()
    {

    	$resultado = null;

    	if (!empty(request()->promotor))
        {

	        $baseDatos = new BaseDatos();           
	        $baseDatos->conectarBaseDatos();            

	        $listaCampos  = "  g.promotor ";
	        $listaCampos .= ", (select u.nombre from usuarios u where u.codigo = g.promotor) as nombrePromotor";
			$listaCampos .= ", g.fecha_operacion fecha ";
	        $listaCampos .= ", g.brigada ";
	        $listaCampos .= ", (select b.descripcion from brigadas b where b.id = g.brigada) as brigadaDescripcion";
	        $listaCampos .= ", g.afiliaciones";
	    	$listaCampos .= ", g.valor";
            $listaCampos .= ", g.ganancia_valor ganancia";
	    	$listaCampos .= ", g.prestamo";
	    	$listaCampos .= ", (select count(1) 
	                           from afiliaciones a, quejas q
	                           where a.id = q.afiliacion
	                           and   a.gasto_ganancia = g.id
	                           and   q.estado  = 'A'
	                          ) as errores";
	        $listaCampos .= ", (select ifnull(sum(e.descuento),0)
	                           from afiliaciones a, quejas q, errores e
	                           where a.id = q.id
	                           and   q.error = e.numero
	                           and   a.gasto_ganancia = g.id
	                           and   q.estado = 'A'
	                          ) as valorErrores";                  

	        $tabla = " gastos_ganancias g ";
	        
	        $condiciones  = " where g.lote is null ";
	        $condiciones .= " and   promotor = '" . request()->promotor . "'";
	        $condiciones .= " order by fecha_operacion ";
	       
	      
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

    public function consultarErrores()
    {

        $errores = null;

        $liquidacionObjeto = json_decode(request()->liquidacion,false);
     	
        if ($liquidacionObjeto != null)
        {

	        $baseDatos = new BaseDatos();           
	        $baseDatos->conectarBaseDatos();
	        
	        foreach ($liquidacionObjeto as $fila) 
	        {
	        
		        $listaCampos  = "  q.fecha_registro as fecha ";
		        $listaCampos .= ", a.consecutivo ";
		        $listaCampos .= ", (select b.descripcion from brigadas b where b.id = a.brigada) as brigada ";
		        $listaCampos .= ", (select e.descripcion from errores e where e.numero = q.error) as error";

		        $tabla = "afiliaciones a, gastos_ganancias g, quejas q";
		        
		        $condiciones  = " where a.gasto_ganancia    = g.id "; 
		        $condiciones .= " and   a.id 		   = q.afiliacion ";
                $condiciones .= " and   a.brigada      = '" . $fila->brigada . "'";
                $condiciones .= " and   a.promotor = '". $fila->promotor ."'";
		        $condiciones .= " and   g.fecha_operacion = '" . $fila->fecha . "'";
		        $condiciones .= " and   q.estado 	   = 'A'";

		        $baseDatos->consultarRegistros($listaCampos, $tabla, $condiciones);

		        while ($fila = mysqli_fetch_assoc($baseDatos->getResultado() ))
		        {
		            $errores[] = $fila;
		            
		        }

		    }
	    
	        $baseDatos->liberarResultado();
	        
	        $baseDatos->desconectarBaseDatos(); 
        
        }

        return response()->json($errores);

    }


}
