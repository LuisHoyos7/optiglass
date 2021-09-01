<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comunes\BaseDatos;
use App\Comunes\Respuesta;
use App\Comunes\Utilidades;
use App\Negocio\RevisionAfiliacionesNegocio;

class RevisionAfiliacionesControlador extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return Utilidades::validarPermiso('revisionAfiliaciones');
    }
    
    public function guardar(Request $request)
    {
            $respuesta = new Respuesta();

            $baseDatos = new BaseDatos();
            $baseDatos->conectarBaseDatos();

            $listaCampos  = "  estado       = 'RE'";
            $listaCampos .= ", subestado    = '" . request()->subestado . "'";
            $listaCampos .= ", usuario_modifica = '" . request()->user()->codigo . "'"; 
            $listaCampos .= ", usuario_revision = '" . request()->user()->codigo . "'"; 
            $listaCampos .= ", observacion_revision  = '" . strtoupper($request->observacion) . "'"; 
            $listaCampos .= ", fecha = '" . Date('Y-m-d H:i:s') . "'";

            $condiciones = " id = '" . request()->consecutivo . "'";
                            
            $tabla = "afiliaciones";
                            
            $baseDatos->actualizarRegistro($listaCampos, $tabla, $condiciones);    

            $baseDatos->desconectarBaseDatos();

            RevisionAfiliacionesNegocio::enviarSMS($request);

            $respuesta->setEstado('OK');

            return response()->json($respuesta);
    }

    public function guardarLote()
    {

            $respuesta = new Respuesta();
            
            $baseDatos = new BaseDatos();
            $baseDatos->conectarBaseDatos();

            $afiliacionesObjeto = json_decode(request()->afiliaciones);

            foreach ($afiliacionesObjeto as $afiliacion) 
            {
              
                $listaCampos  = "  estado       = 'RE'";
                $listaCampos .= ", subestado    = '" . request()->subestado . "'";
                $listaCampos .= ", usuario_modifica = '" . request()->user()->codigo . "'"; 
                $listaCampos .= ", usuario_revision = '" . request()->user()->codigo . "'"; 
                $listaCampos .= ", observacion_revision  = '" . strtoupper(request()->observacion) . "'"; 
                $listaCampos .= ", fecha            = '" . Date('Y-m-d H:i:s') . "'";

                $condiciones = " id = '" . $afiliacion->consecutivo . "'";
                                
                $tabla = "afiliaciones";
                                
                $baseDatos->actualizarRegistro($listaCampos, $tabla, $condiciones);  
                
                RevisionAfiliacionesNegocio::enviarSMS($afiliacion);  

            }

            $baseDatos->desconectarBaseDatos();

            $respuesta->setEstado('OK');

            return response()->json($respuesta);
    }

    public function consultar()
    { 

    	$resultado = null;

        if (!empty(request()->promotor))
        {    
            $baseDatos = new BaseDatos();           
            $baseDatos->conectarBaseDatos();

            $listaCampos  = "  a.id as consecutivo";
            $listaCampos .= ", a.fecha_registro as fecha";
            $listaCampos .= ", (select b.descripcion from brigadas b where b.numero = a.brigada) as brigada ";
        	$listaCampos .= ", (select u.nombre from usuarios u where u.codigo = a.promotor) as promotor";
            $listaCampos .= ", a.abono ";
            $listaCampos .= ", a.saldo ";
            $listaCampos .= ", a.subestado ";
            $listaCampos .= ", (select s.descripcion from subestados s where s.codigo_estado = a.estado and s.codigo = a.subestado) as  subestadoDescripcion ";
            $listaCampos .= ", a.observacion_revision as observacion ";
        	$listaCampos .= ", c.nombres";
        	$listaCampos .= ", c.apellidos";
        	$listaCampos .= ", concat(c.nombres,' ',c.apellidos) nombreCompleto";
        	$listaCampos .= ", c.celular";
        	$listaCampos .= ", c.telefono";
        	$listaCampos .= ", c.provincia";
        	$listaCampos .= ", c.canton";
        	$listaCampos .= ", c.parroquia";
        	$listaCampos .= ", c.direccion";
          
            $tabla = "afiliaciones a, clientes_afiliacion c, brigadas b";
            
            $condiciones  = " where a.id = c.id ";
            $condiciones .= " and   a.brigada    = b.numero";
            $condiciones .= " and   a.promotor  = '". request()->promotor ."'";
            $condiciones .= " and   b.estado     = 'P'";

            if (!empty(request()->brigada))
            {
                $condiciones .= " and   a.brigada = '". request()->brigada ."'";   
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

}
