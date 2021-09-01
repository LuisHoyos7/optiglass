<?php
namespace App\Negocio;
use App\Comunes\MensajesTexto;
use App\Comunes\BaseDatos;
use App\Comunes\Utilidades;

class RevisionAfiliacionesNegocio
{	

	public static function consultarBrigada($campos)
    {

    	$brigadas = null;

        $baseDatos = new BaseDatos();           
        $baseDatos->conectarBaseDatos();
        
        $listaCampos  = "  SUBSTRING(b.descripcion,1,29) as descripcion ";
    	$listaCampos .= ", b.fecha_inicio as fechaInicio";
        $listaCampos .= ", b.hora_inicio as horaInicio";
    	
        $tabla = "afiliaciones a, brigadas b";
        
        $condiciones  = " where a.brigada = b.numero ";
        $condiciones .= " and   a.id = '" . $campos->consecutivo . "'";
      
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
			if ($campos->subestado == "RP")
			{
				$mensaje = Utilidades::obtenerMensaje("1");
				
				if (!empty($mensaje))
				{	
					$brigada = RevisionAfiliacionesNegocio::consultarBrigada($campos);

					if (!empty($brigada))
					{	 
						$mensaje = str_replace("#fecha#", $brigada->fechaInicio, $mensaje);
						$mensaje = str_replace("#hora#", $brigada->horaInicio, $mensaje);
						$mensaje = str_replace("#brigada#", $brigada->descripcion, $mensaje);

						MensajesTexto::enviarSMS($campos->celular,$mensaje);
					}
					
				}
			}
		}	

	}

}