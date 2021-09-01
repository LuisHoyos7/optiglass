<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comunes\BaseDatos;
use App\Comunes\Respuesta;
use App\Comunes\Utilidades;
use App\Error;

class ErroresControlador extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return Utilidades::validarPermiso('errores');
    }

     public function guardar(Request $request)
    {
     		$respuesta = new Respuesta();

        	$baseDatos = new BaseDatos();
        	$baseDatos->conectarBaseDatos();

        	$listaCampos  = "  descripcion ";
        	$listaCampos .= ", descuento ";
        	$listaCampos .= ", estado ";
        	$listaCampos .= ", usuario_crea ";
        	$listaCampos .= ", fecha ";

        	$listaValores  = "  '" . strtoupper($request->descripcion) . "'";
        	$listaValores .= ", '" . $request->descuento . "'";
            $listaValores .= ", '" . $request->estado . "'";
            $listaValores .= ", '" . request()->user()->codigo . "'"; 
            $listaValores .= ", '" . Date('Y-m-d H:i:s') . "'";
                            
            $tabla = "errores";
            		        
            $baseDatos->insertarRegistroExplicito($listaCampos, $listaValores, $tabla);    

            $baseDatos->desconectarBaseDatos();

 			$respuesta->setEstado('OK');

            return response()->json($respuesta);

    }

    public function editar(Request $request)
    {   
            $respuesta = new Respuesta();

            $baseDatos = new BaseDatos();
            $baseDatos->conectarBaseDatos();

            $listaCampos  = "  descripcion  = '" . strtoupper($request->descripcion) . "'";
            $listaCampos .= ", descuento	= '" . $request->descuento . "'";
            $listaCampos .= ", estado 		= '" . $request->estado . "'";
            $listaCampos .= ", usuario_modifica = '" . request()->user()->codigo . "'"; 
            $listaCampos .= ", fecha     	= '" . Date('Y-m-d H:i:s') . "'";

            $condiciones = " numero = '" . request()->numero . "'";
                            
            $tabla = "errores";
                            
            $baseDatos->actualizarRegistro($listaCampos, $tabla, $condiciones);    

            $baseDatos->desconectarBaseDatos();

            $respuesta->setEstado('OK');

            return response()->json($respuesta);
    }

    public function consultar()
    {

    	$resultado = null;

        $baseDatos = new BaseDatos();           
        $baseDatos->conectarBaseDatos();
        

        $listaCampos  = "  numero ";
        $listaCampos .= ", descripcion ";
        $listaCampos .= ", descuento ";
    	$listaCampos .= ", estado ";
        $listaCampos .= ", (case when estado = 'A' then 'ACTIVO' else 'INACTIVO' end) as estadoDescripcion ";
      
        $tabla = "errores";
        
        $condiciones  = " ";

      
        $baseDatos->consultarRegistros($listaCampos, $tabla, $condiciones);

        while ($fila = mysqli_fetch_assoc($baseDatos->getResultado() ))
		{
		    $resultado[] = $fila;
		}
    
        $baseDatos->liberarResultado();
        
        $baseDatos->desconectarBaseDatos(); 

        return response()->json($resultado);

    }

    public function consultarErrores()
    {
        $error = Error::select('numero','descripcion')
                        ->where('estado','A')
                        ->orderBy('descripcion')
                        ->get();
        return response()->json($error);
    }
}
