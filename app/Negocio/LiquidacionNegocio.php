<?php
namespace App\Negocio;

use App\Comunes\Respuesta;

class LiquidacionNegocio
{
	public static function validarFormulario($campos) 
	{
		
		$respuesta = new Respuesta();

		$respuesta->setEstado("OK");

		if ($campos->liquidada == 'Si')
		{
			$respuesta->setEstado("ERROR");
    		$respuesta->setMsgError("Las afiliaciones ya se encuentran liquidadas");	
			
		}

		return $respuesta;
	}

}