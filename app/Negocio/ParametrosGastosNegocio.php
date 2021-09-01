<?php
namespace App\Negocio;

use App\Comunes\Respuesta;
use App\Comunes\BaseDatos;

class ParametrosGastosNegocio
{
	public static function validarFormulario($campos) 
	{
		
		$respuesta = new Respuesta();

		$respuesta->setEstado("OK");

		if (empty($campos->aplicaDesayuno) == false)
		{
			if (empty($campos->desayuno) || $campos->desayuno == 0)
			{
				$respuesta->setEstado("ERROR");
	    		$respuesta->setMsgError("Debe ingresar cantidad ganada de desayunos");	

	    		return $respuesta;
			}	
		}

		if (empty($campos->aplicaAlmuerzo) == false)
		{
			if (empty($campos->almuerzo) || $campos->almuerzo == 0)
			{
				$respuesta->setEstado("ERROR");
	    		$respuesta->setMsgError("Debe ingresar cantidad ganada de almuerzos");	

	    		return $respuesta;
			}	
		}

		if (empty($campos->aplicaCena) == false)
		{
			if (empty($campos->cena) || $campos->cena == 0)
			{
				$respuesta->setEstado("ERROR");
	    		$respuesta->setMsgError("Debe ingresar cantidad ganada de cenas");	

	    		return $respuesta;
			}	
		}

		if (empty($campos->aplicaTransporte) == false)
		{
			if (empty($campos->transporte) || $campos->transporte == 0)
			{
				$respuesta->setEstado("ERROR");
	    		$respuesta->setMsgError("Debe ingresar cantidad ganada de transportes");	

	    		return $respuesta;
			}	
		}

		if ($campos->maxima < $campos->minima)
		{
			
			$respuesta->setEstado("ERROR");
    		$respuesta->setMsgError("El máximo de afiliaciones no debe ser menor que la minima");	

    		return $respuesta;
				
		}

		return $respuesta;
	}

	public static function validarRango($campos)
    {

    	$respuesta = new Respuesta();

        $baseDatos = new BaseDatos();           
        $baseDatos->conectarBaseDatos();

        $listaCampos  = "  id";
      
        $tabla = " parametros_gastos ";

        $condiciones  = " where id != '" . $campos->codigo . "'";
        $condiciones .= " and '" . $campos->minima . "' between afiliaciones_minimas and afiliaciones_maximas";
      
        $baseDatos->consultarRegistros($listaCampos, $tabla, $condiciones);

		$registros = mysqli_fetch_array($baseDatos->getResultado());
        
        if (!empty($registros))
        {
        	$respuesta->setEstado("ERROR");
        	$respuesta->setMsgError("La afiliación mínima se encuentra en un rango existente");	
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