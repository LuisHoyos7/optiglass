<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rol;
use App\Http\Resources\RolRecurso;

class RolesControlador extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        return $this->consultar();
    }

    public function consultar() 
    {
        $usuarios = Rol::where('estado','A')
                        ->orderBy('descripcion')
                        ->get();
        return response()->json(RolRecurso::collection($usuarios));
    }
    
}
