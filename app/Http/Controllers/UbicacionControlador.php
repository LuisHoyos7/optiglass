<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comunes\BaseDatos;
use App\Comunes\Respuesta;
use App\Provincia;
use App\Canton;
use App\Parroquia;

class UbicacionControlador extends Controller
{
    public function consultarProvincias()
    {
       $provincias = Provincia::orderBy('nombre')->get();
       return response()->json($provincias);
    }

    public function consultarCantones()
    {
        $cantones = Canton::orderBy('nombre')->get();
        return response()->json($cantones);
    }

    public function consultarParroquias()
    {
        $parroquias = Parroquia::orderBy('nombre')->get();
        return response()->json($parroquias);
    }

}
