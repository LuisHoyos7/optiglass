<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comunes\BaseDatos;
use App\Comunes\Respuesta;
use App\Comunes\Utilidades;
use App\Brigada;
use App\Afiliacion;
use App\Http\Resources\BrigadaRecurso;
use App\Http\Resources\BrigadaAfiliacionRecurso;
use Illuminate\Database\Eloquent\Builder;

class BrigadasControlador extends Controller
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
            return view('brigadas');
        }
    }

    public function store(Request $request)
    {
        $respuesta = new Respuesta();

        $brigada = new Brigada;

        $brigada->descripcion = strtoupper($request->descripcion);
        $brigada->fecha_preventa =  Date('Y-m-d');
        $brigada->fecha_inicio = $request->fechaInicio; 
        $brigada->hora_inicio = $request->horaInicio; 
        $brigada->telefonos = $request->telefonos; 
        $brigada->parroquia = $request->parroquia; 
        $brigada->direccion = strtoupper($request->direccion);  
        $brigada->estado = 'P';
        $brigada->desayuno_promotor = $request->desayunoPromotor;
        $brigada->almuerzo_promotor = $request->almuerzoPromotor;
        $brigada->cena_promotor = $request->cenaPromotor;
        $brigada->hotel_promotor = $request->hotelPromotor;
        $brigada->transporte_promotor = $request->transportePromotor;
        $brigada->desayuno_coordinador = $request->desayunoCoordinador;
        $brigada->almuerzo_coordinador = $request->almuerzoCoordinador;
        $brigada->cena_coordinador = $request->cenaCoordinador;
        $brigada->hotel_coordinador = $request->hotelCoordinador;
        $brigada->transporte_coordinador = $request->transporteCoordinador;
        $brigada->usuario_crea = request()->user()->codigo; 
        $brigada->fecha = Date('Y-m-d H:i:s');
        $brigada->otros_gastos_brigada = $request->otros_gastos_brigada;
        $brigada->descripcion_otros_gastos = $request->descripcion_otros_gastos;
        
        $brigada->save();

        $respuesta->setEstado('OK');

        return response()->json($respuesta);

    }

    public function update(Request $request, $codigo)
    {
        $respuesta = new Respuesta();

        $brigada = Brigada::find($codigo);
        $brigada->descripcion = strtoupper($request->descripcion);
        $brigada->fecha_preventa =  Date('Y-m-d');
        $brigada->fecha_inicio = $request->fechaInicio; 
        $brigada->hora_inicio = $request->horaInicio; 
        if ($request->estado == 'C')
        {
            $brigada->fecha_cierre = Date('Y-m-d');     
        }
        $brigada->telefonos = $request->telefonos; 
        $brigada->parroquia = $request->parroquia; 
        $brigada->direccion = strtoupper($request->direccion);  
        $brigada->estado = $request->estado;
        $brigada->desayuno_promotor = $request->desayunoPromotor;
        $brigada->almuerzo_promotor = $request->almuerzoPromotor;
        $brigada->cena_promotor = $request->cenaPromotor;
        $brigada->hotel_promotor = $request->hotelPromotor;
        $brigada->transporte_promotor = $request->transportePromotor;
        $brigada->desayuno_coordinador = $request->desayunoCoordinador;
        $brigada->almuerzo_coordinador = $request->almuerzoCoordinador;
        $brigada->cena_coordinador = $request->cenaCoordinador;
        $brigada->hotel_coordinador = $request->hotelCoordinador;
        $brigada->transporte_coordinador = $request->transporteCoordinador;
        $brigada->usuario_modifica = request()->user()->codigo; 
        $brigada->fecha = Date('Y-m-d H:i:s');
        $brigada->otros_gastos_brigada = $request->otros_gastos_brigada;
        $brigada->descripcion_otros_gastos = $request->descripcion_otros_gastos;
        
        $brigada->save();

        $respuesta->setEstado('OK');

        return response()->json($respuesta);
    }

    public function consultar()
    {
        $brigadas = Brigada::with('rParroquia.rCanton.rProvincia')->orderBy('estado')
                            ->orderBy('fecha_inicio','desc')
                            ->get();
  
        return response()->json(BrigadaRecurso::collection($brigadas));
    }

    public function show($id)
    {
        $brigada = Brigada::with('rParroquia.rCanton.rProvincia')->find($id);
        return response()->json(new BrigadaRecurso($brigada));
    }

    public function consultarBrigadas(Request $request)
    {
        $brigadas = Brigada::select('id','descripcion')
                        ->where('estado',$request->input('estado'))
                        ->orderBy('descripcion')
                        ->get();
        return response()->json($brigadas);
    }

    public function ConsultaBrigadasAfiliacion(Request $request)
    {
        $brigadas = Afiliacion::with('rBrigada')->select('brigada');
        if (!is_null($request->input('fecha')))
        {
            $brigadas = $brigadas->where('fecha_registro',$request->input('fecha'));
        }
        if (!is_null($request->input('fecha')))
        {
            $brigadas = $brigadas->where('promotor',$request->input('promotor'));   
        }
        $brigadas = $brigadas->groupBy('brigada')
                             ->orderBy(
                                Brigada::select('descripcion')
                                ->whereColumn('id', 'afiliaciones.brigada')
                                ->orderBy('descripcion')
                                ->limit(1)
                               )
                             ->get();

        return response()->json(BrigadaAfiliacionRecurso::collection($brigadas));

    }
}
