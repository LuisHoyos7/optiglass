<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comunes\BaseDatos;
use App\Comunes\Respuesta;
use App\Comunes\Utilidades;
use App\Negocio\CallDealerNegocio;
use App\Afiliacion;
use App\Gestion;
use App\Queja;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\CallDealerRecurso;
use App\Http\Resources\GestionRecurso;

class CallDealerControlador extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->consultar($request);
        } else {
            return view('maletin');
        }
    }

     public function store(Request $request)
    {
        DB::transaction(function() use ($request) {
            $afiliacion = Afiliacion::find($request->afiliacion);
            $afiliacion->estado = 'GE';
            $afiliacion->subestado = request()->subestado;
            $afiliacion->usuario_modifica = request()->user()->codigo; 
            $afiliacion->fecha = Date('Y-m-d H:i:s');
            $afiliacion->save();

            $gestion = new Gestion;
            $gestion->afiliacion  = $request->afiliacion;
            $gestion->estado = 'GE'; 
            $gestion->subestado = $request->subestado; 
            $gestion->observacion = strtoupper($request->observacion); 
            $gestion->gestor = request()->user()->codigo;  
            $gestion->fecha = Date('Y-m-d H:i:s');
            $gestion->save();

            if ($request->subestado == 'GE')
            {
                $queja = new Queja;
                $queja->afiliacion = $request->afiliacion;
                $queja->error = $request->error;
                $queja->estado = 'A';
                $queja->usuario_crea = request()->user()->codigo; 
                $queja->fecha_registro = Date('Y-m-d');
                $queja->fecha = Date('Y-m-d H:i:s');
                $queja->save();
            }
        }); 
        
        //CallDealerNegocio::enviarSMS($request);

        $respuesta = new Respuesta();

        $respuesta->setEstado('OK');

        return response()->json($respuesta);
    }

    public function consultar(Request $request)
    {
        $afiliaciones = Afiliacion::with('rCliente','rBrigada','rPromotor','rSubestado','rGestiones','rGestor');

        if (request()->user()->rol == 'GT'){
            $afiliaciones = $afiliaciones->where('usuario_gestion',request()->user()->codigo);
        } 
        else if ($request->input('gestor') != null)
        {
            $afiliaciones = $afiliaciones->where('usuario_gestion',$request->input('gestor'));
        }

        if ($request->input('fecha') != null)
        {
            $afiliaciones = $afiliaciones->where('fecha_registro',$request->input('fecha'));
        }

        if ($request->input('brigada') != null)
        {
            $afiliaciones = $afiliaciones->where('brigada',$request->input('brigada'));
        }

        $afiliaciones = $afiliaciones->whereHas('rBrigada', function ($query) use ($request) {
            $query->where('estado','P');
        });

        $afiliaciones = $afiliaciones->where('usuario_gestion','!=',null)
                                     ->orderBy(
                                        Gestion::select('fecha')
                                        ->whereColumn('afiliacion', 'afiliaciones.id')
                                        ->orderBy('fecha')
                                        ->limit(1)
                                     )
                                     ->get();
         
        return response()->json(CallDealerRecurso::collection($afiliaciones));
    }

     public function consultarHistorial($id)
    {
        $gestiones = Gestion::with('rSubestado')
                           ->where('afiliacion',$id)
                           ->orderBy('fecha','desc')->get();

        return response()->json(GestionRecurso::collection($gestiones));
    }

    
}
