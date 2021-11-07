<?php

namespace App\Repositorios;

use Illuminate\Http\Request;

use App\Comunes\Respuesta;
use App\Afiliacion;
use App\ClienteAfiliacion;
use Illuminate\Support\Facades\DB;


class AfiliacionesRepositorio
{
    public function store(Request $request)
    {
      
        $afiliacion = new Afiliacion;
        DB::transaction(function () use ($afiliacion, $request) {
            $afiliacion->consecutivo = $request->consecutivo;
            $afiliacion->observaciones = $request->observaciones;
            $afiliacion->promotor = $request->promotor;
            $afiliacion->brigada = $request->brigada;
            $afiliacion->abono = $request->abono;
            $afiliacion->saldo = $request->saldo;
            $afiliacion->estado =  'CR';
            $afiliacion->subestado =  'CS';
            $afiliacion->usuario_crea = request()->user()->codigo;
            $afiliacion->fecha_registro = Date('Y-m-d');
            $afiliacion->fecha = Date('Y-m-d H:i:s');
            $afiliacion->save();

            $cliente = new ClienteAfiliacion;
            $cliente->afiliacion = $request->consecutivo;
            $cliente->numero_documento = $request->numeroDocumento;
            $cliente->nombres = strtoupper($request->nombres);
            $cliente->apellidos = strtoupper($request->apellidos);
            $cliente->sexo = $request->sexo;
            $cliente->celular = $request->celular;
            $cliente->telefono = $request->telefono;
            $cliente->parroquia = $request->parroquia;
            $cliente->direccion = strtoupper($request->direccion);
            $cliente->id_integrante_principal = $request->idIntegrantePrincipal;
            $cliente->usuario_crea = request()->user()->codigo;
            $cliente->fecha = Date('Y-m-d H:i:s');
            $cliente->edad = $request->edad;
            $cliente->celular2 = $request->celular2;
            $cliente->telefono2 = $request->telefono2;
            $afiliacion->rCliente()->save($cliente);
        });

        return $afiliacion;
    }
}
