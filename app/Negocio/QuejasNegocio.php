<?php
namespace App\Negocio;

use App\Comunes\Respuesta;
use App\Comunes\BaseDatos;

class QuejasNegocio
{

	public static function validarConsecutivo($campos)
    {

    	$respuesta = new Respuesta();

    	$baseDatos = new BaseDatos();		    
        $baseDatos->conectarBaseDatos();
        
        $listaCampos = " id ";
        
        $tabla = "afiliaciones";
        
        $condiciones  = " where id = '" . $campos->consecutivo . "'";
      
        $baseDatos->consultarRegistros($listaCampos, $tabla, $condiciones);
        
        $registros = mysqli_fetch_array($baseDatos->getResultado());
        
        if (empty($registros))
        {
        	$respuesta->setEstado("ERROR");
        	$respuesta->setMsgError("Consecutivo no existe");	
        }
        else
        {
            $respuesta->setEstado("OK");
        }
        
        $baseDatos->liberarResultado();
    	
	    $baseDatos->desconectarBaseDatos();	

	    return $respuesta;

    }

}