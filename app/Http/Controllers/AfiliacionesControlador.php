<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comunes\BaseDatos;
use App\Comunes\Respuesta;
use App\Comunes\Utilidades;
use App\Negocio\ClientesNegocio;
use App\Negocio\AfiliacionesNegocio;
use App\Repositorios\AfiliacionesRepositorio;
use Illuminate\Support\Facades\Session;
use App\Afiliacion;
use App\ClienteAfiliacion;
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
        $afiliaciones = Afiliacion::with('rCliente', 'rBrigada', 'rPromotor', 'rSubestado');

        if ($request->input('promotor') != null) {
            $afiliaciones = $afiliaciones->where('promotor', $request->input('promotor'));
        }
        if (!is_null($request->input('brigada'))) {
            $afiliaciones = $afiliaciones->where('brigada', $request->input('brigada'));
        }
        if (!is_null($request->input('estadobrigada'))) {
            $afiliaciones = $afiliaciones->whereHas('rBrigada', function (Builder $query) use ($request) {
                $query->where('estado', $request->input('estadobrigada'));
            });
        }
        $afiliaciones = $afiliaciones->orderBy('usuario_revision')->orderBy('fecha_registro')->get();

        return response()->json(AfiliacionRecurso::collection($afiliaciones));
    }

    public function store(Request $request)
    {
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

    public function update(Request $request, $id)
    {
        $respuesta = new Respuesta();

        $afiliacion = Afiliacion::find($id);
        $afiliacion->estado = 'RE';
        $afiliacion->subestado = request()->subestado;
        $afiliacion->usuario_modifica = request()->user()->codigo;
        $afiliacion->usuario_revision = request()->user()->codigo;
        $afiliacion->observacion_revision  = strtoupper($request->observacion);
        $afiliacion->fecha = Date('Y-m-d H:i:s');
        $afiliacion->save();

        //RevisionAfiliacionesNegocio::enviarSMS($request);

        $respuesta->setEstado('OK');

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
}
