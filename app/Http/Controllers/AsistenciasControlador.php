<?php

namespace App\Http\Controllers;

use App\Afiliacion;
use App\ClienteAfiliacion;
use App\ClienteBrigada;
use Illuminate\Http\Request;
use App\Comunes\BaseDatos;
use App\Comunes\Respuesta;
use App\Negocio\AsistenciasNegocio;
use App\Comunes\Utilidades;
use App\Negocio\ClientesNegocio;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Echo_;

class AsistenciasControlador extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return Utilidades::validarPermiso('asistencias');
    }

    public function consultar()
    {

        $resultado = null;

        $baseDatos = new BaseDatos();
        $baseDatos->conectarBaseDatos();

        $listaCampos  = "  a.id";
        $listaCampos .= ", a.consecutivo";
        $listaCampos .= ", a.brigada ";
        $listaCampos .= ", b.descripcion as brigadaDescripcion ";
        $listaCampos .= ", (select u.nombre from usuarios u where u.codigo = a.promotor) promotor";
        $listaCampos .= ", a.abono ";
        $listaCampos .= ", a.saldo ";
        $listaCampos .= ", a.pendiente ";
        $listaCampos .= ", c.numero_documento as numeroDocumento";
        $listaCampos .= ", c.nombres";
        $listaCampos .= ", c.apellidos";
        $listaCampos .= ", concat(c.nombres,' ',c.apellidos) nombreCompleto";
        $listaCampos .= ", c.celular";
        $listaCampos .= ", c.telefono";
        $listaCampos .= ", p.codigo as provincia";
        $listaCampos .= ", t.codigo as canton";
        $listaCampos .= ", c.parroquia";
        $listaCampos .= ", c.direccion";

        $tabla = "afiliaciones a, clientes_afiliacion c, brigadas b, provincias p, cantones t, parroquias r";

        $condiciones  = " where a.id = c.afiliacion ";
        $condiciones .= " and   a.brigada    = b.id";
        $condiciones .= " and   b.estado     = 'A'";
        $condiciones .= " and   p.codigo     = t.provincia";
        $condiciones .= " and   t.codigo     = r.canton";
        $condiciones .= " and   r.codigo     = c.parroquia";

        $baseDatos->consultarRegistros($listaCampos, $tabla, $condiciones);

        while ($fila = mysqli_fetch_assoc($baseDatos->getResultado())) {
            $resultado[] = $fila;
        }

        $baseDatos->liberarResultado();

        $baseDatos->desconectarBaseDatos();

        return response()->json($resultado);
    }

    public function validarConsecutivo(Request $request)
    {
        return response()->json(AsistenciasNegocio::validarConsecutivo($request));
    }

    public function guardar(Request $request)
    {
        $respuesta = AsistenciasNegocio::validarConsecutivo($request);

        if ($respuesta->getEstado() != 'OK') {
            return $this->editarAfiliacion($request);
        } else {
            return $this->guardarAfiliacion($request);
        }
    }

    public function editarAfiliacion(Request $request)
    {
        return DB::transaction(function () use ($request) {

            $respuesta = AsistenciasNegocio::validarPendiente($request);

            if ($respuesta->getEstado() != 'OK') {
                return response()->json($respuesta);
            }

            $afiliacion = Afiliacion::find($request->afiliacion);
            $afiliacion->pendiente = $request->pendiente;
            $afiliacion->estado =  'CL';
            $afiliacion->subestado =  'CO';
            $afiliacion->usuario_modifica = request()->user()->codigo;
            $afiliacion->fecha = Date('Y-m-d H:i:s');
            $afiliacion->save();

            $respuesta = $this->editarClienteAfiliacion();

            if ($respuesta->getEstado() != 'OK') {
                return response()->json($respuesta);
            }

            $respuesta = AsistenciasNegocio::validarCliente($request);

            if ($respuesta->getEstado() != 'OK') {
                $respuesta = $this->editarCliente();
            } else {
                $respuesta = $this->guardarCliente($request->afiliacion);
            }

            if ($respuesta->getEstado() != 'OK') {
                return response()->json($respuesta);
            }

            return response()->json($respuesta);
        });
    }

    public function guardarAfiliacion(Request $request)
    {

        return DB::transaction(function () use ($request) {

            $respuesta = AsistenciasNegocio::validarPendiente($request);

            if ($respuesta->getEstado() != 'OK') {
                return response()->json($respuesta);
            }

            $afiliacion = new Afiliacion;
            $afiliacion->consecutivo = $request->consecutivo;
            $afiliacion->promotor = $request->promotor;
            $afiliacion->brigada = $request->brigada;
            $afiliacion->pendiente = $request->pendiente;
            $afiliacion->estado =  'CL';
            $afiliacion->subestado =  'CO';
            $afiliacion->usuario_crea = request()->user()->codigo;
            $afiliacion->fecha_registro = Date('Y-m-d');
            $afiliacion->fecha = Date('Y-m-d H:i:s');
            $afiliacion->save();

            $respuesta = $this->guardarClienteAfiliacion($afiliacion->id);

            if ($respuesta->getEstado() != 'OK') {
                return response()->json($respuesta);
            }

            $respuesta = AsistenciasNegocio::validarCliente($request);

            if ($respuesta->getEstado() != 'OK') {
                $respuesta = $this->editarCliente();
            } else {
                $respuesta = $this->guardarCliente($afiliacion->id);
            }

            return response()->json($respuesta);
        });
    }

    public function guardarClienteAfiliacion($afiliacion)
    {

        $respuesta = new Respuesta();

        /*if ($respuesta->getEstado() != 'OK') {
            return $respuesta;
        }*/

        $cliente = new ClienteAfiliacion;
        $cliente->afiliacion = $afiliacion;
        $cliente->numero_documento = request()->numeroDocumento;
        $cliente->nombres = strtoupper(request()->nombres);
        $cliente->apellidos = strtoupper(request()->apellidos);
        $cliente->sexo = request()->sexo;
        $cliente->celular = request()->celular;
        $cliente->telefono = request()->telefono;
        $cliente->parroquia = request()->parroquia;
        $cliente->direccion = strtoupper(request()->direccion);
        $cliente->usuario_crea = request()->user()->codigo;
        $cliente->fecha = Date('Y-m-d H:i:s');
        $cliente->save();

        $respuesta->setEstado('OK');

        return $respuesta;
    }

    public function editarClienteAfiliacion()
    {
        $respuesta = new Respuesta();

        $cliente = ClienteAfiliacion::where("afiliacion", request()->afiliacion)->first();
        $cliente->numero_documento = request()->numeroDocumento;
        $cliente->nombres = strtoupper(request()->nombres);
        $cliente->apellidos = strtoupper(request()->apellidos);
        $cliente->sexo = request()->sexo;
        $cliente->celular = request()->celular;
        $cliente->telefono = request()->telefono;
        $cliente->parroquia = request()->parroquia;
        $cliente->direccion = strtoupper(request()->direccion);
        $cliente->usuario_modifica = request()->user()->codigo;
        $cliente->fecha = Date('Y-m-d H:i:s');
        $cliente->save();

        $respuesta->setEstado('OK');

        return $respuesta;
    }

    public function guardarCliente($afiliacion)
    {

        $respuesta = new Respuesta();

        $cliente = new ClienteBrigada;
        $cliente->afiliacion = $afiliacion;
        $cliente->numero_documento = request()->numeroDocumento;
        $cliente->nombres = strtoupper(request()->nombres);
        $cliente->apellidos = strtoupper(request()->apellidos);
        $cliente->sexo = request()->sexo;
        $cliente->celular = request()->celular;
        $cliente->telefono = request()->telefono;
        $cliente->parroquia = request()->parroquia;
        $cliente->direccion = strtoupper(request()->direccion);
        $cliente->usuario_crea = request()->user()->codigo;
        $cliente->fecha = Date('Y-m-d H:i:s');
        $cliente->save();

        $respuesta->setEstado('OK');

        return $respuesta;
    }

    public function editarCliente()
    {
        $respuesta = new Respuesta();

        $cliente = ClienteBrigada::where("numero_documento", request()->numeroDocumento)->first();
        $cliente->nombres = strtoupper(request()->nombres);
        $cliente->apellidos = strtoupper(request()->apellidos);
        $cliente->sexo = request()->sexo;
        $cliente->celular = request()->celular;
        $cliente->telefono = request()->telefono;
        $cliente->parroquia = request()->parroquia;
        $cliente->direccion = strtoupper(request()->direccion);
        $cliente->usuario_modifica = request()->user()->codigo;
        $cliente->fecha = Date('Y-m-d H:i:s');
        $cliente->save();

        $respuesta->setEstado('OK');

        return $respuesta;
    }
}
