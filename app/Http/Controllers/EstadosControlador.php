<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comunes\BaseDatos;
use App\Comunes\Respuesta;
use App\Comunes\Utilidades;
use App\Estado;
use App\Http\Resources\EstadoRecurso;

class EstadosControlador extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->consultar();
        } else {
            return view('estados');
        }
    }

     public function store(Request $request)
    {
     		$respuesta = new Respuesta();

            $estado = new Estado;
        	$estado->codigo = strtoupper($request->codigo);
        	$estado->descripcion = strtoupper($request->descripcion);
            $estado->estado = $request->estado;
            $estado->usuario_crea = request()->user()->codigo; 
            $estado->fecha = Date('Y-m-d H:i:s');
            $estado->save(); 

 			$respuesta->setEstado('OK');

            return response()->json($respuesta);

    }

    public function update(Request $request, $codigo)
    {
            $respuesta = new Respuesta();

            $estado = Estado::find($codigo);
            $estado->descripcion = strtoupper($request->descripcion);
            $estado->estado = $request->estado;
            $estado->usuario_modifica = request()->user()->codigo; 
            $estado->fecha = Date('Y-m-d H:i:s');
            $estado->save();

            $respuesta->setEstado('OK');

            return response()->json($respuesta);
    }

    public function consultar()
    {
    	$estados = Estado::orderBy('codigo')->get();
        return response()->json(EstadoRecurso::collection($estados));
    }

    public function consultarEstadosActivo()
    {
        $estados = Estado::orderBy('descripcion')->where('estado','A')->get();
        return response()->json(EstadoRecurso::collection($estados));
    }

}
