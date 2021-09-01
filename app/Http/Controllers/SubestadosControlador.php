<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comunes\BaseDatos;
use App\Comunes\Respuesta;
use App\Comunes\Utilidades;
use App\Subestado;
use App\Http\Resources\SubestadoRecurso;

class SubestadosControlador extends Controller
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
            return view('subestados');
        }
    }

    public function store(Request $request)
    {
        $respuesta = new Respuesta();

        $subestado = new Subestado;
        $subestado->codigo_estado = $request->codigoEstado;
        $subestado->codigo = strtoupper($request->codigo);
        $subestado->descripcion = strtoupper($request->descripcion);
        $subestado->estado = $request->estado;
        $subestado->usuario_crea = request()->user()->codigo; 
        $subestado->fecha = Date('Y-m-d H:i:s');
        $subestado->save();                

        $respuesta->setEstado('OK');

        return response()->json($respuesta);
    } 

    public function update(Request $request, $codigo)
    {
        $respuesta = new Respuesta();

        $subestado = Subestado::find($codigo);
        
        $subestado->codigo_estado = $request->codigoEstado;
        $subestado->descripcion = strtoupper($request->descripcion);
        $subestado->estado = $request->estado;
        $subestado->usuario_modifica = request()->user()->codigo; 
        $subestado->fecha = Date('Y-m-d H:i:s');
        $subestado->save();

        $respuesta->setEstado('OK');

        return response()->json($respuesta);
    }

    public function consultar()
    {
        $subestados = Subestado::with('rEstado')->orderBy('codigo_estado')->get();
        return response()->json(SubestadoRecurso::collection($subestados));
    }

    public function consultarSubestados(Request $request)
    {
        $subestados = Subestado::select('codigo','descripcion')->where('estado','A');
        if (!is_null($request->input('estado')))
        {
            $subestados = $subestados->where('codigo_estado',$request->input('estado'));
        }
        $subestados = $subestados->orderBy('descripcion')->get();
        return response()->json($subestados);
    }

}
