<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Negocio\CargarMaletinesNegocio;
use App\Comunes\BaseDatos;
use App\Comunes\Respuesta;
use App\Comunes\Utilidades;
use App\Negocio\ClientesNegocio;
use App\Negocio\AfiliacionesNegocio;
use App\Repositorios\AfiliacionesRepositorio;
use Illuminate\Support\Facades\Session;
use App\Afiliacion;
use App\Brigada;
use App\ClienteAfiliacion;
use App\GastoGanancia;
use App\Usuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\AfiliacionRecurso;

class AfiliacionesControlador extends Controller
{

    private $repositorio;

    public function __construct()
    {
        $this->middleware('auth');
        $this->repositorio = new AfiliacionesRepositorio();
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->consultar($request);
        } else {
            return view('afiliaciones');
        }
    }

    public function consultar(Request $request)
    {
        $afiliaciones = GastoGanancia::with('rBrigada');

       //$afiliaciones = 'select distinct from gastos_ganancias as gg inner join
                       //afiliaciones as a on a.brigada = gg.brigada 
                       // where a.estado = "RE"';
        
        if (!is_null($request->input('brigada'))) {
            $afiliaciones = $afiliaciones->where('brigada', $request->input('brigada'));
        }
       
        $afiliaciones = $afiliaciones->get();

        return response()->json($afiliaciones);
        
    }
        
        //$afiliaciones = $afiliaciones->orderBy('usuario_revision')->orderBy('fecha_registro')->get();

       















         // if ($request->input('promotor') != null) {
       //     $afiliaciones = $afiliaciones->where('promotor', $request->input('promotor'));
       // }
        //if (!is_null($request->input('estadobrigada'))) {
        //    $afiliaciones = $afiliaciones->whereHas('rBrigada', function (Builder $query) use ($request) {
          //      $query->where('estado', $request->input('estadobrigada'));
          //  });
        //} 
         
    

    public function store(Request $request)
    {

            if($request->celular <> null)
            {

                $respuesta = new Respuesta();
                $respuesta->setEstado("OK");	    	
                $cliente = ClienteAfiliacion::where('celular',$request->celular)
                                            ->orWhere('celular2',$request->celular)
                                            ->orWhere('telefono',$request->celular)
                                            ->orWhere('telefono2',$request->celular)
                                            ->first();


                if ($cliente != null)
                {
                    $respuesta->setEstado("ERROR");
                    $respuesta->setMsgError("El número de celular o Telefono ya Existe");
                    return response()->json($respuesta);
                }
            }

            if($request->celular2 <> null)
            {

                $respuesta = new Respuesta();
                $respuesta->setEstado("OK");            
                $cliente = ClienteAfiliacion::where('celular2',$request->celular2)
                                            ->orWhere('celular',$request->celular2)
                                            ->orWhere('telefono',$request->celular2)
                                            ->orWhere('telefono2',$request->celular2)
                                            ->first();


                if ($cliente != null)
                {
                    $respuesta->setEstado("ERROR");
                    $respuesta->setMsgError("El número de celular o Telefono ya Existe");
                    return response()->json($respuesta);
                }
            }

            if($request->telefono <> null)
            {

                $respuesta = new Respuesta();
                $respuesta->setEstado("OK");            
                $cliente = ClienteAfiliacion::where('telefono',$request->telefono)
                                            ->orWhere('celular2',$request->telefono)
                                            ->orWhere('celular',$request->telefono)
                                            ->orWhere('telefono2',$request->telefono)
                                            ->first();


                if ($cliente != null)
                {
                    $respuesta->setEstado("ERROR");
                    $respuesta->setMsgError("El número de celular o Telefono ya Existe");
                    return response()->json($respuesta);
                }
            }

            if($request->telefono2 <> null)
            {

                $respuesta = new Respuesta();
                $respuesta->setEstado("OK");            
                $cliente = ClienteAfiliacion::where('telefono2',$request->telefono2)
                                            ->orWhere('celular2',$request->telefono2)
                                            ->orWhere('telefono',$request->telefono2)
                                            ->orWhere('celular',$request->telefono2)
                                            ->first();


                if ($cliente != null)
                {
                    $respuesta->setEstado("ERROR");
                    $respuesta->setMsgError("El número de celular o Telefono ya Existe");
                    return response()->json($respuesta);
                }
            }


        if( ($request->celular == null) && ($request->celular2 == null) && ($request->telefono == null) &&  ($request->telefono2 == null))
        {   
            $respuesta = New Respuesta;
            
            $errores = [];

            $errores[] = "Debe Exisitir un Numero celular o un numero de Telefono para completar el Registro";

            $respuesta->setMsgError($errores);

            return response()->json($respuesta);    
        }else {
      
            $respuesta = AfiliacionesNegocio::validar(request(), false);

            if ($respuesta->getEstado() != 'OK') {
                return response()->json($respuesta);
            }
        
            $afiliacion = $this->repositorio->store($request);

            $integrantes = json_decode(request()->integrantes);
      
            $erroresIntegrantes = [];
            foreach ($integrantes as $integrante) {
                try {
                    $respuestaIntegrante = AfiliacionesNegocio::validar($integrante, false);
                    if ($respuestaIntegrante->getEstado() != 'OK') {
                        $erroresIntegrantes[] = $respuestaIntegrante->getMsgError();
                        continue;
                    }
                    $dto = new Request;
                    $dto->consecutivo           = $integrante->consecutivo;
                    $dto->numero_documento      = $integrante->numeroDocumento;
                    $dto->edad                  = $integrante->edad;
                    $dto->nombres               = $integrante->nombres;
                    $dto->apellidos             = $integrante->apellidos;
                    $dto->celular               = $request->celular;
                    $dto->telefono              = $request->telefono;
                    $dto->parroquia             = $request->parroquia;
                    $dto->direccion             = $request->direccion;
                    $dto->promotor              = $request->promotor;
                    $dto->brigada               = $request->brigada;
                    $dto->abono                 = $integrante->abono;
                    $dto->saldo                 = $integrante->saldo;
                    $dto->idIntegrantePrincipal = $afiliacion->id;
                    $this->repositorio->store($dto);
                } catch (\Exception $e) {
                    $erroresIntegrantes[] = "No se pudo procesar el registro del consecutivo " + $integrante->consecutivo;
                }
            }
            $respuesta->setMsgError($erroresIntegrantes);

            return response()->json($respuesta);
        }
    }
    
    public function update(Request $request, $id)
    {
        $cargas = $this->consultarCargaGestores();
        
        $respuesta = CargarMaletinesNegocio::validarCargas($cargas);
    
        $respuesta = new Respuesta();

        $brigada = GastoGanancia::find($id);

        $afiliaciones = Afiliacion::where('brigada',$brigada->brigada)->get();

        foreach($afiliaciones as $afiliacion){
            $gestor = CargarMaletinesNegocio::obtenerGestor($cargas);
        $afiliacion->estado = 'GE';
        $afiliacion->subestado =  'GN';//request()->subestado;
        $afiliacion->usuario_gestion = $gestor;  
        $afiliacion->usuario_modifica = request()->user()->codigo;
        $afiliacion->usuario_revision = request()->user()->codigo;
        $afiliacion->observacion_revision  = strtoupper($request->observacion);
        $afiliacion->fecha = Date('Y-m-d H:i:s');
        $afiliacion->save();
        }
        //RevisionAfiliacionesNegocio::enviarSMS($request);

        //$respuesta->setEstado('OK');

        return response()->json($respuesta);
    }

    public function editarLote(Request $request)
    {
        
        $respuesta = new Respuesta();

        $afiliacionesObjeto = json_decode(request()->afiliaciones);

        foreach ($afiliacionesObjeto as $afiliacion) {
            $dto = new Request;
            $dto->subestado = $request->subestado;
            $dto->observacion = $request->observacion;

            $this->update($dto, $afiliacion);
        }

        $respuesta->setEstado('OK');

        return response()->json($respuesta);
    }

    public function obtenerValorCuota()
    {
        $cuota = Utilidades::obtenerParametro("1");

        return empty($cuota) ? 0 : $cuota;
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
