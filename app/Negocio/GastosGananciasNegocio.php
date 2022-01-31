<?php
namespace App\Negocio;

use App\Comunes\Respuesta;

class GastosGananciasNegocio
{	

	public static function validar($campos) 
	{
		
		$respuesta = new Respuesta();

		$respuesta->setEstado("OK");

		if (empty($campos->valor))
		{
			if (empty($campos->valor))
			{
				$respuesta->setEstado("ERROR");
	    		$respuesta->setMsgError("El valor de las afiliaciones no debe estar vacio o ser cero");	

	    		return $respuesta;
			}	
			
		}

	/*	if ($campos->restante > $campos->entrega)
      {{--  {   
            
	        $respuesta->setEstado("ERROR");
	        $respuesta->setMsgError("El valor restante es mayor al entregado");

	        return $respuesta;
        }--}}
*/
		return $respuesta;
	}

	public static function calcularPrestamo($gastos,$parametros) 
	{
			
		$prestamo = 0;

		if ($gastos != null)
		{		
			if ($parametros != null)  
			{	
				if ($parametros->aplica_desayuno == 0)
				{
					$prestamo = $prestamo + $gastos->desayuno_promotor;	
				}
			
				if ($parametros->aplica_almuerzo == 0)
				{
					$prestamo = $prestamo + $gastos->almuerzo_promotor;	
				}

				if ($parametros->aplica_cena == 0)
				{
					$prestamo = $prestamo + $gastos->cena_promotor;	
				}

				if ($parametros->aplica_hotel == 0)
				{
					$prestamo = $prestamo + $gastos->hotel_promotor;	
				}

				if ($parametros->aplica_transporte == 0)
				{
					$prestamo = $prestamo + $gastos->transporte_promotor;	
				}
			}
			else 
			{
				$prestamo = $gastos->desayuno_promotor + 
							$gastos->almuerzo_promotor + 
							$gastos->cena_promotor + 
							$gastos->hotel_promotor + 
							$gastos->transporte;	
			}	

		}
		
		return $prestamo;
	}

	public static function calcularGanancia($afiliaciones,$gastos,$parametros) 
	{
			
		$ganancia = 0;
		$gananciaDesayuno = 0;
		$gananciaAlmuerzo = 0;
		$gananciaCena = 0;
		$gananciaHotel = 0;
		$gananciaTransporte = 0;

		if ($gastos != null)
		{		
			if ($parametros != null) 
			{

				if ($parametros->aplica_almuerzo == 1)
				{
					$ganancia = $ganancia + ($gastos->almuerzo_promotor*$parametros->cantidad_almuerzo);	
					$gananciaAlmuerzo = $gastos->almuerzo_promotor*$parametros->cantidad_almuerzo;
				}

				if ($parametros->aplica_cena == 1)
				{
					$ganancia = $ganancia + ($gastos->cena_promotor*$parametros->cantidad_cena);	
					$gananciaCena = $gastos->cena_promotor*$parametros->cantidad_cena;	
				}

				if ($parametros->aplica_transporte == 1)
				{
					$ganancia = $ganancia + ($gastos->transporte_promotor*$parametros->cantidad_transporte);	
					$gananciaTransporte = $gastos->transporte_promotor*$parametros->cantidad_transporte;	
				}
				
			}	

		}

		$respuesta = array('ganancia' => $ganancia
							, 'gananciaAlmuerzo' => $gananciaAlmuerzo
							, 'gananciaCena' => $gananciaCena
							, 'gananciaTransporte' => $gananciaTransporte
							 );

		return (object) $respuesta;
	}

}