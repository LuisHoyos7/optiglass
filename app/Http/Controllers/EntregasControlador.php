<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comunes\BaseDatos;
use App\Comunes\Respuesta;
use App\Negocio\EntregasNegocio;
use App\Comunes\Utilidades;

class EntregasControlador extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return Utilidades::validarPermiso('entregas');
    }

    public function guardar(Request $request)
    {

        $respuesta = EntregasNegocio::validarFormulario($request);

        if ($respuesta->getEstado() != 'OK') {
            return response()->json($respuesta);
        }

        $baseDatos = new BaseDatos();
        $baseDatos->conectarBaseDatos();

        /* deshabilitar autocommit */
        mysqli_autocommit($baseDatos->getConexion(), FALSE);

        $listaCampos  = "  pendiente	= '" . $request->pendiente . "'";
        $listaCampos .= ", usuario_modifica = '" . request()->user()->codigo . "'";
        $listaCampos .= ", fecha     	= '" . Date('Y-m-d H:i:s') . "'";

        $condiciones = " consecutivo = " . request()->consecutivo . "";

        $tabla = "ventas";

        $baseDatos->actualizarRegistro($listaCampos, $tabla, $condiciones);

        $respuesta = $this->cambiarEstado($baseDatos);

        if ($respuesta->getEstado() != 'OK') {
            return response()->json($respuesta);
        }

        if ($respuesta->getEstado() == 'OK') {
            /* insertar commit */
            mysqli_commit($baseDatos->getConexion());
        } else {
            /* Revertir */
            mysqli_rollback($baseDatos->getConexion());
        }


        $baseDatos->desconectarBaseDatos();

        return response()->json($respuesta);
    }

    public function cambiarEstado($baseDatos)
    {
        $respuesta = new Respuesta();

        $listaCampos  = "  estado     = 'CL'";
        $listaCampos .= ", subestado  = '" . request()->subestado . "'";
        $listaCampos .= ", usuario_modifica  = '" . request()->user()->codigo . "'";
        $listaCampos .= ", fecha      = '" . Date('Y-m-d H:i:s') . "'";

        $condiciones = " consecutivo = '" . request()->consecutivo . "'";

        $tabla = "afiliaciones";

        $baseDatos->actualizarRegistro($listaCampos, $tabla, $condiciones);

        $respuesta->setEstado('OK');

        return $respuesta;
    }

    public function consultar()
    {

        $resultado = null;

        if (!empty(request()->consecutivoBusqueda) || !empty(request()->fechaBusqqueda)) {
            $baseDatos = new BaseDatos();
            $baseDatos->conectarBaseDatos();

            $listaCampos  = "  a.consecutivo as consecutivo";
            $listaCampos .= ", (select b.descripcion from brigadas b where b.id = a.brigada) as brigada";
            $listaCampos .= ", concat(c.nombres,' ',c.apellidos) nombre";
            $listaCampos .= ", v.fecha_venta as fecha";
            $listaCampos .= ", v.abono ";
            $listaCampos .= ", v.saldo ";
            $listaCampos .= ", v.pendiente ";
            $listaCampos .= ", (select l.descripcion from tipos_lentes l where l.id = v.lente) as lente ";
            $listaCampos .= ",  a.subestado";
            $listaCampos .= ", (select s.descripcion from subestados s where s.codigo_estado = a.estado and s.codigo = a.subestado) as subestadoDescripcion ";

            $tabla = "afiliaciones a, clientes_brigadas c, ventas v";

            $condiciones  = " where a.id               = c.afiliacion ";
            $condiciones .= " and   a.consecutivo      = v.consecutivo ";

            if (!empty(request()->consecutivoBusqueda)) {
                $condiciones .= " and   a.consecutivo = '" . request()->consecutivoBusqueda . "'";
            }

            if (!empty(request()->fechaBusqqueda)) {
                $condiciones .= " and   v.fecha_venta = '" . request()->fechaBusqqueda . "'";
            }


            $baseDatos->consultarRegistros($listaCampos, $tabla, $condiciones);

            while ($fila = mysqli_fetch_assoc($baseDatos->getResultado())) {
                $resultado[] = $fila;
            }

            $baseDatos->liberarResultado();

            $baseDatos->desconectarBaseDatos();
        }

        return response()->json($resultado);
    }
}
