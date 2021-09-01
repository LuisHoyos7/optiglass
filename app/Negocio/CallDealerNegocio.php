<?php
namespace App\Negocio;
use App\Comunes\MensajesTexto;
use App\Comunes\BaseDatos;
use App\Comunes\Utilidades;

class CallDealerNegocio
{
	public static function consultarBrigada($campos)
    {

    	$brigadas = null;

        $baseDatos = new BaseDatos();           
        $baseDatos->conectarBaseDatos();
        
        $listaCampos  = "  SUBSTRING(b.descripcion,1,19) as descripcion";
    	$listaCampos .= ", b.fecha_inicio as fechaInicio";
        $listaCampos .= ", b.hora_inicio as horaInicio";
        $listaCampos .= ", a.saldo";
    	
        $tabla = "afiliaciones a, brigadas b";
        
        $condiciones  = " where a.brigada = b.numero ";
        $condiciones .= " and   a.id = '" . $campos->codigo . "'";
      
        $baseDatos->consultarRegistros($listaCampos, $tabla, $condiciones);

        $brigadas = mysqli_fetch_assoc($baseDatos->getResultado());
    
        $baseDatos->liberarResultado();
        
        $baseDatos->desconectarBaseDatos(); 

        return json_decode(json_encode($brigadas));

    }

	public static function enviarSMS($campos) 
	{		
		if (!empty(Utilidades::obtenerParametro("5")))
		{
			if ($campos->subestado == "GC")
			{
				$mensaje = Utilidades::obtenerMensaje("2");
				
				if (!empty($mensaje))
				{	
					$brigada = CallDealerNegocio::consultarBrigada($campos);

					if (!empty($brigada))
					{	
						$mensaje = str_replace("#hora#", $brigada->horaInicio, $mensaje);
						$mensaje = str_replace("#brigada#", $brigada->descripcion, $mensaje);
						$mensaje = str_replace("#saldo#", (int) $brigada->saldo, $mensaje);

						MensajesTexto::enviarSMS($campos->celular,$mensaje);
					}
					
				}
			}
		}

	}

}