<?php
namespace App\Negocio;

use App\Comunes\Respuesta;

class UsuariosNegocio
{
	public static function validarFormulario($campos) 
	{
		
		$respuesta = new Respuesta();

		$respuesta->setEstado("OK");

		if (empty($campos->celular))
		{
			if (empty($campos->telefono))
			{
				$respuesta->setEstado("ERROR");
	    		$respuesta->setMsgError("Debe ingresar un número de celular o teléfono");	
			}	
			
		}

		return $respuesta;
	}

}