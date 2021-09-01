<?php
namespace App\Negocio;
use App\Comunes\Respuesta;

class CargarMaletinesNegocio
{

	public static function validarCargas($cargas) 
	{
		$respuesta = new Respuesta();

		$respuesta->setEstado("OK");

		if ($cargas->isEmpty())
		{
			
			$respuesta->setEstado("ERROR");
    		$respuesta->setMsgError("No existe gestores para asignar cargas");	
		
		}

		return $respuesta;

	}

	public static function obtenerGestor($cargas) 
	{
		$gestor = '';
		$cargaMenor = -1;
		foreach ($cargas as $carga) 
		{
			if ($cargaMenor == -1)
			{
				$cargaMenor = $carga->carga;
				$gestor = $carga->gestor;
			}
			elseif ($cargaMenor > $carga->carga) { 
				$cargaMenor = $carga->carga;
				$gestor = $carga->gestor;
			}

		}

		return $gestor;
	}

	public static function asignarGestor($cargas,$gestor) 
	{

		foreach ($cargas as $carga) 
		{
			if ($carga->gestor == $gestor)
			{
				$carga->carga = $carga->carga+1;
			}			

		}


	}

}