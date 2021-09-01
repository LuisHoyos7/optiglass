<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comunes\BaseDatos;

class ComunesControlador extends Controller
{
     public function consultarPromotores()
    {

        $baseDatos = new BaseDatos();           
        $baseDatos->conectarBaseDatos();
        
        $listaCampos  = " codigo ";
        $listaCampos .= ", nombre ";
        
        $tabla = " usuarios ";
        
        $condiciones  = " where estado = 'A'";
        $condiciones .= " and rol = 'PT'";
      
        $baseDatos->consultarRegistros($listaCampos, $tabla, $condiciones);
        
        $promotores = "<option value='' disabled selected>Seleccione</option>";
        while ($fila = mysqli_fetch_assoc($baseDatos->getResultado() ))
        {
            $promotores .= "<option value='" . $fila["codigo"] . "'>" . ucwords(strtolower($fila["nombre"])) . "</option>";
        }
    
        $baseDatos->liberarResultado();
        
        $baseDatos->desconectarBaseDatos(); 

        echo $promotores;

    }

}
