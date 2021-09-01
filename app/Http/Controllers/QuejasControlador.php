<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comunes\BaseDatos;
use App\Comunes\Respuesta;
use App\Comunes\Utilidades;
use App\Negocio\QuejasNegocio;

class QuejasControlador extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return Utilidades::validarPermiso('quejas');
    }

    public function guardar(Request $request)
    {
    	if (empty($request->numero))
    	{
    		return $this->guardarError($request);
    	}
    	else
    	{
    		return $this->editarError($request);	
    	}

    }

     public function guardarError(Request $request)
    {
     		$respuesta = QuejasNegocio::validarConsecutivo($request);

     		if ($respuesta->getEstado() != 'OK')
            {   
                return response()->json($respuesta);
            }

        	$baseDatos = new BaseDatos();
        	$baseDatos->conectarBaseDatos();

        	$listaCampos  = "  consecutivo ";
        	$listaCampos .= ", error ";
        	$listaCampos .= ", estado ";
        	$listaCampos .= ", usuario_crea ";
            $listaCampos .= ", fecha_registro ";
        	$listaCampos .= ", fecha ";

        	$listaValores  = "  '" . $request->consecutivo . "'";
        	$listaValores .= ", '" . $request->error . "'";
            $listaValores .= ", '" . $request->estado . "'";
            $listaValores .= ", '" . request()->user()->codigo . "'"; 
            $listaValores .= ", '" . Date('Y-m-d') . "'";
            $listaValores .= ", '" . Date('Y-m-d H:i:s') . "'";
                            
            $tabla = "quejas";
      
            $baseDatos->insertarRegistroExplicito($listaCampos, $listaValores, $tabla);    

            $baseDatos->desconectarBaseDatos();

 			$respuesta->setEstado('OK');

            return response()->json($respuesta);

    }

    public function editarError(Request $request)
    {
            $respuesta = new Respuesta();

            $baseDatos = new BaseDatos();
            $baseDatos->conectarBaseDatos();

            $listaCampos  = "  error 		= '" . $request->error . "'";
            $listaCampos .= ", estado 		= '" . $request->estado . "'";
            $listaCampos .= ", usuario_modifica = '" . request()->user()->codigo . "'"; 
            $listaCampos .= ", fecha     	= '" . Date('Y-m-d H:i:s') . "'";

            $condiciones = " numero = '" . request()->numero . "'";
                            
            $tabla = "quejas";
                            
            $baseDatos->actualizarRegistro($listaCampos, $tabla, $condiciones);    

            $baseDatos->desconectarBaseDatos();

            $respuesta->setEstado('OK');

            return response()->json($respuesta);
    }

    public function consultar()
    {

    	$respuesta = new Respuesta();

        $baseDatos = new BaseDatos();           
        $baseDatos->conectarBaseDatos();
        

        $listaCampos  = "  a.id as consecutivo";
        $listaCampos .= ", a.numero_documento as numeroDocumento";
        $listaCampos .= ", (select b.descripcion from brigadas b where b.numero = a.brigada) brigada";
    	$listaCampos .= ", (select u.nombre from usuarios u where u.codigo = a.promotor) promotor";
    	$listaCampos .= ", c.nombres";
    	$listaCampos .= ", c.apellidos";

      
        $tabla = "afiliaciones a, clientes_afiliacion c";
        
        $condiciones  = " where a.id = c.id ";
        $condiciones .= " and   a.id = '" . request()->consecutivo . "'";
      
        $baseDatos->consultarRegistros($listaCampos, $tabla, $condiciones);

        $resultado = mysqli_fetch_assoc($baseDatos->getResultado());
        
        if (!empty($resultado))
        {
            $respuesta->setEstado("OK");
            $respuesta->setMsgError("");
            $respuesta->setRespuesta($resultado);
            
        }else
        {
            $respuesta->setEstado("ERROR");
            $respuesta->setMsgError("Numero de consecutivo no encontrado");
        }
    
        $baseDatos->liberarResultado();
        
        $baseDatos->desconectarBaseDatos(); 

        return response()->json($respuesta);

    }

    public function consultarErrores()
    {

    	$resultado = null;

        $baseDatos = new BaseDatos();           
        $baseDatos->conectarBaseDatos();
        

        $listaCampos  = "  q.numero";
        $listaCampos .= ", q.error";
        $listaCampos .= ", (select e.descripcion from errores e where e.numero = q.error) errorDescripcion";
    	$listaCampos .= ", estado ";
        $listaCampos .= ", (case when estado = 'A' then 'ACTIVO' else 'INACTIVO' end) as estadoDescripcion ";
      
        $tabla = "quejas q";
        
        $condiciones  = " where q.consecutivo = '" . request()->consecutivo . "'";
      
        $baseDatos->consultarRegistros($listaCampos, $tabla, $condiciones);

        while ($fila = mysqli_fetch_assoc($baseDatos->getResultado() ))
		{
		    $resultado[] = $fila;
		}
    
        $baseDatos->liberarResultado();
        
        $baseDatos->desconectarBaseDatos(); 

        return response()->json($resultado);

    }
}
