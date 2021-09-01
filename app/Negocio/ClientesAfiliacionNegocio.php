<?php
namespace App\Negocio;

use App\Comunes\Respuesta;
use App\Comunes\BaseDatos;
use App\ClienteAfiliacion;

class ClientesAfiliacionNegocio
{
	
	public static function validar($request, $edit) {

        $respuesta = new Respuesta();
    	$respuesta->setEstado("OK");

        if ($edit)
        {
            if (strlen($request->celular) == 10)
            {	    	
				$cliente = ClienteAfiliacion::where('id','!=',$request->id)
											->where(function($query) use ($request) {
												$query->where('celular',$request->celular)
													  ->orWhere('telefono',$request->celular);
											 })
                                            ->first();
                if ($cliente != null)
                {
                    $respuesta->setEstado("ERROR");
                    $respuesta->setMsgError("El número de celular " . $request->celular . " ya existe");
                    return $respuesta;
                }
            }   

            if (strlen($request->telefono) == 10)
            {	    	
				$cliente = ClienteAfiliacion::where('id','!=',$request->id)
											->where(function($query) use ($request) {
												$query->where('celular',$request->telefono)
													  ->orWhere('telefono',$request->telefono);
											 })
                                            ->first();							
                if ($cliente != null)
                {
                    $respuesta->setEstado("ERROR");
                    $respuesta->setMsgError("El número de celular " . $request->celular . " ya existe");
                    return $respuesta;
                }
            }   
            
        }
           
        return $respuesta;
	}
	
	public static function validarCelular($campos,$origen)
    {

    	$respuesta = new Respuesta();

    	$respuesta->setEstado("OK");

        $baseDatos = new BaseDatos();           
        $baseDatos->conectarBaseDatos();

    	if (strlen($campos->celular) == 10)
    	{	    	

	        $listaCampos  = "  id ";
	      
	        $tabla = " clientes_afiliacion ";

	        if($origen == 'AFILIACION')
	        {
	        	$condiciones  = " where celular = '" . $campos->celular . "'";
	        	$condiciones .= " or   telefono = '" . $campos->celular . "'";
	        }
	        else
	        {
	        	$condiciones  = " where id != '" . $campos->consecutivo . "'";
	        	$condiciones .= " and (celular  = '" . $campos->celular . "'";
	        	$condiciones .= " or   telefono = '" . $campos->celular . "')";
	        }
	        
	        $baseDatos->consultarRegistros($listaCampos, $tabla, $condiciones);

			$registros = mysqli_fetch_array($baseDatos->getResultado());
	        
	        if (!empty($registros))
	        {
	        	$respuesta->setEstado("ERROR");
	        	$respuesta->setMsgError("El número de celular " . $campos->celular . " ya existe");	

	        	$baseDatos->liberarResultado();
	        
	    		$baseDatos->desconectarBaseDatos(); 

	    		return $respuesta;
	        }
	    
        }

        if (strlen($campos->telefono) == 10)
    	{	    	

	        $listaCampos  = "  id ";
	      
	        $tabla = " clientes_afiliacion ";

	        if($origen == 'AFILIACION')
	        {
	        	$condiciones  = " where celular = '" . $campos->telefono . "'";
	        	$condiciones .= " or   telefono = '" . $campos->telefono . "'";
	        }
	        else
	        {
	        	$condiciones  = " where id != '" . $campos->consecutivo . "'";
	        	$condiciones .= " and (celular  = '" . $campos->telefono . "'";
	        	$condiciones .= " or   telefono = '" . $campos->telefono . "')";
	        }
	      
	        $baseDatos->consultarRegistros($listaCampos, $tabla, $condiciones);

			$registros = mysqli_fetch_array($baseDatos->getResultado());
	        
	        if (!empty($registros))
	        {
	        	$respuesta->setEstado("ERROR");
	        	$respuesta->setMsgError("El número de celular " . $campos->telefono . " ya existe");	

	        	$baseDatos->liberarResultado();
	        
	    		$baseDatos->desconectarBaseDatos(); 

	    		return $respuesta;
	        }

        }

        return $respuesta;

    }

}