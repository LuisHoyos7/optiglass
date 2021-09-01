<?php
namespace App\Comunes;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class Utilidades
{

	public static function ordenarArray($arrIni, $col, $order = SORT_ASC)
	{
	    $arrAux = array();
	    foreach ($arrIni as $key=> $row)
	    {
	        $arrAux[$key] = is_object($row) ? $arrAux[$key] = $row->$col : $row[$col];
	        $arrAux[$key] = strtolower($arrAux[$key]);
	    }
	    array_multisort($arrAux, $order, $arrIni);
	}

	public static function validarPermiso($vista)
	{
		$existe = 0;
        foreach (Session::get('permisos') as $permiso) 
        {
            if ($permiso->descripcion == $vista)
            {
                $existe = 1;
            }    
        }
      
        if ($existe == 0)
        {	
            return Redirect::intended('/');
        }
        else
        {
        	return view($vista);
        }
	}

    public static function obtenerParametro($codigo)
    {    
        if(Session::has("parametros"))
        {
            foreach (Session::get("parametros") as $parametro) {
                if ($parametro->codigo == $codigo)
                {  
                    return $parametro->valor;
                }
            }
        }


        
        return "";
    }

     public static function obtenerMensaje($codigo)
    {    
        if(Session::has("mensajes"))
        {
            foreach (Session::get("mensajes") as $mensaje) {
                if ($mensaje->codigo == $codigo)
                {  
                    return $mensaje->texto;
                }
            }
        }
        
        return "";
    }
}