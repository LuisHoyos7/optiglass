<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comunes\BaseDatos;
use App\Comunes\Respuesta;
use App\Comunes\Utilidades;
use App\Negocio\ClientesAfiliacionNegocio;
use App\Negocio\AfiliacionesNegocio;
use Illuminate\Support\Facades\Session;
use App\ClienteAfiliacion;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ClienteAfiliacionRecurso;
use App\Http\Resources\ClienteAfiliacionTelefonoRecurso;

class ClientesAfiliacionControlador extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show($id)
    {
        $cliente = ClienteAfiliacion::with('rParroquia.rCanton.rProvincia')->find($id);
        return response()->json(new ClienteAfiliacionRecurso($cliente));
    }

    public function update(Request $request, $id)
    {
        $request->id = $id;
        //$respuesta = ClientesAfiliacionNegocio::validar($request,true);
        $respuesta = new Respuesta();

        /*if ($respuesta->getEstado() != 'OK')
        {   
            return response()->json($respuesta);
        }*/

        $cliente = ClienteAfiliacion::find($id);

        $cliente->nombres   = strtoupper(request()->nombres);
        $cliente->apellidos = strtoupper(request()->apellidos);
        $cliente->sexo      = request()->sexo;
        $cliente->celular   = request()->celular;
        $cliente->telefono  = request()->telefono;
        $cliente->parroquia = request()->parroquia;
        $cliente->direccion = strtoupper(request()->direccion);
        $cliente->usuario_modifica = request()->user()->codigo;
        $cliente->fecha     = Date('Y-m-d H:i:s');
        $cliente->save();

        $respuesta->setEstado('OK');

        return response()->json($respuesta);
    }

    public function findByPhonenumber(Request $request)
    {
        $cliente = null;
        if ($request->input('celular') != null) {
            $cliente = DB::table('clientes_afiliacion')
                ->select(
                    'clientes_afiliacion.*',
                    'afiliaciones.consecutivo',
                    'brigadas.id as idBrigada',
                    'brigadas.descripcion as descripcionBrigada',
                    'parroquias.nombre as parroquia',
                    'cantones.nombre as canton',
                    'provincias.nombre as provincia'
                )
                ->join('afiliaciones', 'clientes_afiliacion.afiliacion', '=', 'afiliaciones.id')
                ->join('brigadas', 'afiliaciones.brigada', '=', 'brigadas.id')
                ->join('parroquias', 'clientes_afiliacion.parroquia', '=', 'parroquias.codigo')
                ->join('cantones', 'parroquias.canton', '=', 'cantones.codigo')
                ->join('provincias', 'cantones.provincia', '=', 'provincias.codigo')
                ->where(function ($query) use ($request) {
                    $query->where('celular', $request->input('celular'))
                        ->orWhere('telefono', $request->input('celular'));
                })->orderBy('id', 'asc')->first();
        }

        if ($cliente == null && $request->input('telefono') != null) {
            $cliente = DB::table('clientes_afiliacion')
                ->select(
                    'clientes_afiliacion.*',
                    'afiliaciones.consecutivo',
                    'brigadas.id as idBrigada',
                    'brigadas.descripcion as descripcionBrigada',
                    'parroquias.nombre as parroquia',
                    'cantones.nombre as canton',
                    'provincias.nombre as provincia'
                )
                ->join('afiliaciones', 'clientes_afiliacion.afiliacion', '=', 'afiliaciones.id')
                ->join('brigadas', 'afiliaciones.brigada', '=', 'brigadas.id')
                ->join('parroquias', 'clientes_afiliacion.parroquia', '=', 'parroquias.codigo')
                ->join('cantones', 'parroquias.canton', '=', 'cantones.codigo')
                ->join('provincias', 'cantones.provincia', '=', 'provincias.codigo')
                ->where(function ($query) use ($request) {
                    $query->where('celular', $request->input('telefono'))
                        ->orWhere('telefono', $request->input('telefono'));
                })->orderBy('id', 'asc')->first();
        }
        return response()->json(new ClienteAfiliacionTelefonoRecurso($cliente));
    }
}
