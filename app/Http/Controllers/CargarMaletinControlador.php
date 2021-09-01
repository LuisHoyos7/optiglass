<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comunes\Respuesta;
use App\Negocio\CargarMaletinesNegocio;
use App\Afiliacion;
use App\Usuario;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\CargarMaletinRecurso;

class CargarMaletinControlador extends Controller
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
            return view('cargarMaletines');
        }
    }

     public function consultar()
    {
        $cargas = Afiliacion::with('rBrigada:id,descripcion')
                                ->select('brigada',DB::raw('count(*) as carga'))
                                ->where('estado','RE')
                                ->where('subestado','RP')
                                ->where('usuario_gestion',null)
                                ->whereHas('rBrigada', function ($query) {
                                    $query->where('estado','P');
                                })
                                ->groupBy('brigada')
                                ->get();

        return response()->json(CargarMaletinRecurso::collection($cargas));
    }

    public function store(Request $request)
    {

        $respuesta = new Respuesta();
        
        $asignacionesObjeto = json_decode($request->asignaciones);

        //consultamos carga de cada gestor
        $cargas = $this->consultarCargaGestores();
        
        $respuesta = CargarMaletinesNegocio::validarCargas($cargas);
        
        if ($respuesta->getEstado() != 'OK')
        {
            return response()->json($respuesta);
        }
        
        foreach ($asignacionesObjeto as $asignacion) 
        {	
        	//consultamos las afiliaciones de la brigada
            $afiliaciones = $this->consultarAfiliacionesSinGestor($asignacion);

            foreach ($afiliaciones as $afiliacion) 
        	{	
	        	//obtenemos el gestor de menor carga
	        	$gestor = CargarMaletinesNegocio::obtenerGestor($cargas);
                
                $afiliacion = Afiliacion::find($afiliacion->id);
                $afiliacion->estado       = 'GE';
                $afiliacion->subestado    = 'GN';
	            $afiliacion->usuario_gestion = $gestor;  
                $afiliacion->usuario_modifica =  request()->user()->codigo;  
	            $afiliacion->fecha            =  Date('Y-m-d H:i:s');
                $afiliacion->save();
	            //agregamos una afiliacion al gestor asignado
	            CargarMaletinesNegocio::asignarGestor($cargas,$gestor);
        	}

        }

        return response()->json($respuesta);
    }

     public function consultarAfiliacionesSinGestor($brigada)
    {

        $afiliaciones = Afiliacion::select('id')
                                  ->where('brigada',$brigada)
                                  ->where('estado','RE')
                                  ->where('subestado','RP')
                                  ->where('usuario_gestion',null)
                                  ->get();
    	
        return $afiliaciones;
    }

     public function consultarCargaGestores()
    {
        $cargas = Usuario::select('codigo as gestor')
                         ->addSelect(['carga' => function ($query) {
                             $query->select(DB::raw('count(1) as carga'))
                                   ->from('afiliaciones')
                                   ->join('brigadas', 'afiliaciones.brigada', '=', 'brigadas.id')
                                   ->where('brigadas.estado','P')
                                   ->whereColumn('afiliaciones.usuario_gestion', 'usuarios.codigo')
                                   ->limit(1);
                         }])
                         ->where('rol','GT')
                         ->where('estado','A')
                         ->get();
       
        return $cargas;
    }
 
}
