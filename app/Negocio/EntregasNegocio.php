<?php
namespace App\Negocio;

use App\Comunes\Respuesta;

class EntregasNegocio
{
	public static function validarFormulario($campos) 
	{
		
		$respuesta = new Respuesta();

		$respuesta->setEstado("OK");

		if ($campos->saldo != $campos->pendiente)
		{
			$respuesta->setEstado("ERROR");
    		$respuesta->setMsgError("El valor pendiente no coincide con el saldo");		
			
		}

		return $respuesta;
	}

}