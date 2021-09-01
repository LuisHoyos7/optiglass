<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comunes\BaseDatos;
use App\Comunes\Respuesta;
use App\Comunes\Utilidades;
use App\Negocio\FormulasNegocio;
use PDF;


class VentasControlador extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return Utilidades::validarPermiso('ventas');
    }

    public function guardar(Request $request, $formula)
    {
        if (empty($request->venta)) {
            return $this->guardarVenta($request, $formula);
        } else {
            return $this->editarVenta($request, $formula);
        }
    }

    public function guardarVenta(Request $request, $formula)
    {

        $baseDatos = new BaseDatos();
        $baseDatos->conectarBaseDatos();

        /* deshabilitar autocommit */
        mysqli_autocommit($baseDatos->getConexion(), false);

        $id = $this->obtenerId()['id'];

        $listaCampos  = "  id ";
        $listaCampos .= ", consecutivo ";
        $listaCampos .= ", numero_documento ";
        $listaCampos .= ", lente ";
        $listaCampos .= ", abono ";
        $listaCampos .= ", saldo ";
        $listaCampos .= ", usuario_crea ";
        $listaCampos .= ", fecha_venta ";
        $listaCampos .= ", fecha ";

        $listaValores  = "  '" . $id . "'";
        $listaValores .= ", '" . $request->consecutivo . "'";
        $listaValores .= ", '" . $request->numeroDocumento . "'";
        $listaValores .= ", '" . $request->lente . "'";
        $listaValores .= ", '" . $request->abono . "'";
        $listaValores .= ", '" . $request->saldo . "'";
        $listaValores .= ", '" . request()->user()->codigo . "'";
        $listaValores .= ", '" . Date('Y-m-d') . "'";
        $listaValores .= ", '" . Date('Y-m-d H:i:s') . "'";

        $tabla = "ventas";

        $baseDatos->insertarRegistroExplicito($listaCampos, $listaValores, $tabla);

        $respuesta = $this->guardarFormula($baseDatos, $id);

        if ($respuesta->getEstado() != 'OK') {
            return response()->json($respuesta);
        }

        $respuesta = $this->guardarAdicion($baseDatos, $id);

        if ($respuesta->getEstado() != 'OK') {
            return response()->json($respuesta);
        }

        $respuesta = $this->editarEstado($baseDatos);

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

    public function editarVenta(Request $request, $formula)
    {
        $respuesta = new Respuesta();

        $baseDatos = new BaseDatos();
        $baseDatos->conectarBaseDatos();

        /* deshabilitar autocommit */
        mysqli_autocommit($baseDatos->getConexion(), false);

        $listaCampos  = "  lente  = '" . $request->lente . "'";
        $listaCampos .= ", abono  = '" . $request->abono . "'";
        $listaCampos .= ", saldo  = '" . $request->saldo . "'";
        $listaCampos .= ", usuario_modifica  = '" . request()->user()->codigo . "'";
        $listaCampos .= ", fecha      = '" . Date('Y-m-d H:i:s') . "'";

        $condiciones = " id = '" . request()->venta . "'";

        $tabla = "ventas";

        $baseDatos->actualizarRegistro($listaCampos, $tabla, $condiciones);

        $respuesta = $this->editarFormula($baseDatos);

        if ($respuesta->getEstado() != 'OK') {
            return response()->json($respuesta);
        }

        $respuesta = $this->editarAdicion($baseDatos);

        if ($respuesta->getEstado() == 'OK') {
            /* insertar commit */
            mysqli_commit($baseDatos->getConexion());
        } else {
            /* Revertir */
            mysqli_rollback($baseDatos->getConexion());
        }

        return response()->json($respuesta);
    }

    public function obtenerId()
    {

        $resultado = null;

        $baseDatos = new BaseDatos();
        $baseDatos->conectarBaseDatos();

        $listaCampos  = "  (ifnull(max(id),0) + 1) as id ";


        $tabla = "ventas";

        $condiciones  = " ";

        $baseDatos->consultarRegistros($listaCampos, $tabla, $condiciones);

        while ($fila = mysqli_fetch_assoc($baseDatos->getResultado())) {
            $resultado[] = $fila;
        }

        $baseDatos->liberarResultado();

        $baseDatos->desconectarBaseDatos();


        return $resultado[0];
    }

    public function guardarFormula($baseDatos, $id)
    {

        $respuesta = new Respuesta();

        $listaCampos  = "  id_venta ";
        $listaCampos .= ", consecutivo ";
        $listaCampos .= ", numero_documento ";
        $listaCampos .= ", esfera_lejos_derecho ";
        $listaCampos .= ", cilindro_lejos_derecho ";
        $listaCampos .= ", eje_lejos_derecho";
        $listaCampos .= ", esfera_lejos_izquierdo ";
        $listaCampos .= ", cilindro_lejos_izquierdo ";
        $listaCampos .= ", eje_lejos_izquierdo";
        $listaCampos .= ", esfera_cerca_derecho ";
        $listaCampos .= ", cilindro_cerca_derecho ";
        $listaCampos .= ", eje_cerca_derecho";
        $listaCampos .= ", esfera_cerca_izquierdo ";
        $listaCampos .= ", cilindro_cerca_izquierdo";
        $listaCampos .= ", eje_cerca_izquierdo";
        $listaCampos .= ", av_lejos_derecho";
        $listaCampos .= ", av_lejos_izquierdo";
        $listaCampos .= ", usuario_crea ";
        $listaCampos .= ", fecha ";

        $listaValores  = "  '" . $id . "'";
        $listaValores .= ", '" . request()->consecutivo . "'";
        $listaValores .= ", '" . request()->numeroDocumento . "'";
        $listaValores .= ", '" . request()->esferaLejosDerecho . "'";
        $listaValores .= ", '" . request()->cilindroLejosDerecho . "'";
        $listaValores .= ", '" . request()->ejeLejosDerecho . "'";
        $listaValores .= ", '" . request()->esferaLejosIzquierdo . "'";
        $listaValores .= ", '" . request()->cilindroLejosIzquierdo . "'";
        $listaValores .= ", '" . request()->ejeLejosIzquierdo . "'";
        $listaValores .= ", '" . request()->esferaCercaDerecho . "'";
        $listaValores .= ", '" . request()->cilindroCercaDerecho . "'";
        $listaValores .= ", '" . request()->ejeCercaDerecho . "'";
        $listaValores .= ", '" . request()->esferaCercaIzquierdo . "'";
        $listaValores .= ", '" . request()->cilindroCercaIzquierdo . "'";
        $listaValores .= ", '" . request()->ejeCercaIzquierdo . "'";
        $listaValores .= ", '" . request()->avLejosDerecho . "'";
        $listaValores .= ", '" . request()->avLejosIzquierdo . "'";
        $listaValores .= ", '" . request()->user()->codigo . "'";
        $listaValores .= ", '" . Date('Y-m-d H:i:s') . "'";

        $tabla = "formulas";

        $baseDatos->insertarRegistroExplicito($listaCampos, $listaValores, $tabla);

        $respuesta->setEstado('OK');

        return $respuesta;
    }

    public function editarFormula($baseDatos)
    {
        $respuesta = new Respuesta();

        $listaCampos  = "  esfera_lejos_derecho     = '" . request()->esferaLejosDerecho . "'";
        $listaCampos .= ", cilindro_lejos_derecho   = '" . request()->cilindroLejosDerecho . "'";
        $listaCampos .= ", eje_lejos_derecho        = '" . request()->ejeLejosDerecho . "'";
        $listaCampos .= ", esfera_lejos_izquierdo   = '" . request()->esferaLejosIzquierdo . "'";
        $listaCampos .= ", cilindro_lejos_izquierdo = '" . request()->cilindroLejosIzquierdo . "'";
        $listaCampos .= ", eje_lejos_izquierdo      = '" . request()->ejeLejosIzquierdo . "'";
        $listaCampos .= ", esfera_cerca_derecho     = '" . request()->esferaCercaDerecho . "'";
        $listaCampos .= ", cilindro_cerca_derecho   = '" . request()->cilindroCercaDerecho . "'";
        $listaCampos .= ", eje_cerca_derecho        = '" . request()->ejeCercaDerecho . "'";
        $listaCampos .= ", esfera_cerca_izquierdo   = '" . request()->esferaCercaIzquierdo . "'";
        $listaCampos .= ", cilindro_cerca_izquierdo = '" . request()->cilindroCercaIzquierdo . "'";
        $listaCampos .= ", eje_cerca_izquierdo      = '" . request()->ejeCercaIzquierdo . "'";
        $listaCampos .= ", av_lejos_derecho         = '" . request()->avLejosDerecho . "'";
        $listaCampos .= ", av_lejos_izquierdo       = '" . request()->avLejosIzquierdo . "'";
        $listaCampos .= ", usuario_modifica         = '" . request()->user()->codigo . "'";
        $listaCampos .= ", fecha                    = '" . Date('Y-m-d H:i:s') . "'";

        $condiciones = " id_venta = '" . request()->venta . "'";

        $tabla = "formulas";

        $baseDatos->actualizarRegistro($listaCampos, $tabla, $condiciones);

        $respuesta->setEstado('OK');

        return $respuesta;
    }

    public function guardarAdicion($baseDatos, $id)
    {
        $respuesta = new Respuesta();

        $listaCampos  = "  adicion_derecho   = '" . request()->adicionDerecho . "'";
        $listaCampos .= ", adicion_izquierdo  = '" . request()->adicionIzquierdo . "'";

        $condiciones = " id_venta = '" . $id . "'";

        $tabla = "formulas";

        $baseDatos->actualizarRegistro($listaCampos, $tabla, $condiciones);

        $respuesta->setEstado('OK');

        return $respuesta;
    }

    public function editarAdicion($baseDatos)
    {
        $respuesta = new Respuesta();

        $listaCampos  = "  adicion_derecho     = '" . request()->adicionDerecho . "'";
        $listaCampos .= ", adicion_izquierdo   = '" . request()->adicionIzquierdo . "'";

        $condiciones = " id_venta = '" . request()->venta . "'";

        $tabla = "formulas";

        $baseDatos->actualizarRegistro($listaCampos, $tabla, $condiciones);

        $respuesta->setEstado('OK');

        return $respuesta;
    }

    public function editarEstado($baseDatos)
    {
        $respuesta = new Respuesta();

        $listaCampos  = "  estado     = 'CL'";
        $listaCampos .= ", subestado  = 'CC'";
        $listaCampos .= ", usuario_modifica  = '" . request()->user()->codigo . "'";
        $listaCampos .= ", fecha      = '" . Date('Y-m-d H:i:s') . "'";

        $condiciones = " consecutivo = '" . request()->consecutivo . "'";

        $tabla = "afiliaciones";

        $baseDatos->actualizarRegistro($listaCampos, $tabla, $condiciones);

        $respuesta->setEstado('OK');

        return $respuesta;
    }

    public function consultarFormula()
    {

        $resultado = null;

        $lejosDerecho = false;
        $lejosIzquierdo = false;
        $cercaDerecho = false;
        $cercaIzquierdo = false;

        $baseDatos = new BaseDatos();
        $baseDatos->conectarBaseDatos();


        $listaCampos  = "  esfera_lejos_derecho ";
        $listaCampos .= ", cilindro_lejos_derecho ";
        $listaCampos .= ", eje_lejos_derecho";
        $listaCampos .= ", esfera_lejos_izquierdo ";
        $listaCampos .= ", cilindro_lejos_izquierdo ";
        $listaCampos .= ", eje_lejos_izquierdo";
        $listaCampos .= ", esfera_cerca_derecho ";
        $listaCampos .= ", cilindro_cerca_derecho ";
        $listaCampos .= ", eje_cerca_derecho";
        $listaCampos .= ", esfera_cerca_izquierdo ";
        $listaCampos .= ", cilindro_cerca_izquierdo";
        $listaCampos .= ", eje_cerca_izquierdo";
        $listaCampos .= ", av_lejos_derecho";
        $listaCampos .= ", av_lejos_izquierdo";

        $tabla = "formulas";

        $condiciones  = " where id_venta = '" . request()->venta . "'";

        $baseDatos->consultarRegistros($listaCampos, $tabla, $condiciones);

        while ($fila = mysqli_fetch_assoc($baseDatos->getResultado())) {

            $resultado[] = array(
                'distancia' => 'LEJOS', 'ojo' => 'DERECHO', 'esfera' => "<input type='number' name='esferaLejosDerecho' value='" . $fila['esfera_lejos_derecho'] . "'>", 'cilindro' => "<input type='number' name='cilindroLejosDerecho' value='" . $fila['cilindro_lejos_derecho'] . "'>", 'eje' => "<input type='number' name='ejeLejosDerecho' value='" . $fila['eje_lejos_derecho'] . "'>", 'av' =>  "<input type='number' name='avLejosDerecho' value='" . $fila['av_lejos_derecho'] . "'>"
            );

            $resultado[] = array(
                'distancia' => 'LEJOS', 'ojo' => 'IZQUIERDO', 'esfera' => "<input type='number' name='esferaLejosIzquierdo' value='" . $fila['esfera_lejos_izquierdo'] . "'>", 'cilindro' => "<input type='number' name='cilindroLejosIzquierdo' value='" . $fila['cilindro_lejos_izquierdo'] . "'>", 'eje' => "<input type='number' name='ejeLejosIzquierdo' value='" . $fila['eje_lejos_izquierdo'] . "'>", 'av' =>  "<input type='number' name='avLejosIzquierdo' value='" . $fila['av_lejos_izquierdo'] . "'>"
            );

            $resultado[] = array(
                'distancia' => 'CERCA', 'ojo' => 'DERECHO', 'esfera' => "<input type='number' name='esferaCercaDerecho' value='" . $fila['esfera_cerca_derecho'] . "'>", 'cilindro' => "<input type='number' name='cilindroCercaDerecho' value='" . $fila['cilindro_cerca_derecho'] . "'>", 'eje' => "<input type='number' name='ejeCercaDerecho' value='" . $fila['eje_cerca_derecho'] . "'>", 'av' =>  ""
            );

            $resultado[] = array(
                'distancia' => 'CERCA', 'ojo' => 'IZQUIERDO', 'esfera' => "<input type='number' name='esferaCercaIzquierdo' value='" . $fila['esfera_cerca_izquierdo'] . "'>", 'cilindro' => "<input type='number' name='cilindroCercaIzquierdo' value='" . $fila['cilindro_cerca_izquierdo'] . "'>", 'eje' => "<input type='number' name='ejeCercaIzquierdo' value='" . $fila['eje_cerca_izquierdo'] . "'>", 'av' =>  ""
            );
        }

        if (empty($resultado)) {
            $resultado = FormulasNegocio::validarFormula($resultado);
        }

        $baseDatos->liberarResultado();

        $baseDatos->desconectarBaseDatos();

        return response()->json($resultado);
    }

    public function consultarAdicion()
    {

        $resultado = null;

        $lejosDerecho = false;
        $lejosIzquierdo = false;
        $cercaDerecho = false;
        $cercaIzquierdo = false;

        $baseDatos = new BaseDatos();
        $baseDatos->conectarBaseDatos();


        $listaCampos  = "  adicion_derecho ";
        $listaCampos .= ", adicion_izquierdo ";

        $tabla = "formulas";

        $condiciones  = " where id_venta = '" . request()->venta . "'";

        $baseDatos->consultarRegistros($listaCampos, $tabla, $condiciones);

        while ($fila = mysqli_fetch_assoc($baseDatos->getResultado())) {

            $resultado[] = array(
                'ojoDerecho' => 'DERECHO', 'adicionDerecho' => "<input type='number' name='adicionDerecho' value='" . $fila['adicion_derecho'] . "'>", 'ojoIzquierdo' => 'IZQUIERDO', 'adicionIzquierdo' => "<input type='number' name='adicionIzquierdo' value='" . $fila['adicion_izquierdo'] . "'>"
            );
        }

        if (empty($resultado)) {
            $resultado = FormulasNegocio::validarAdicion($resultado);
        }

        $baseDatos->liberarResultado();

        $baseDatos->desconectarBaseDatos();

        return response()->json($resultado);
    }

    public function consultarCliente()
    {

        $respuesta = new Respuesta();

        $baseDatos = new BaseDatos();
        $baseDatos->conectarBaseDatos();

        $listaCampos  = "  a.consecutivo as consecutivo";
        $listaCampos .= ", (select b.descripcion from brigadas b where b.id = a.brigada) as brigada";
        $listaCampos .= ", c.numero_documento as numeroDocumento";
        $listaCampos .= ", c.nombres";
        $listaCampos .= ", c.apellidos";
        $listaCampos .= ", concat(c.nombres,' ',c.apellidos) nombreCompleto";
        $listaCampos .= ", c.celular";
        $listaCampos .= ", c.telefono";


        $tabla = "afiliaciones a, clientes_brigadas c";

        $condiciones  = " where a.id = c.afiliacion ";
        $condiciones .= " and   a.consecutivo      = '" .  request()->consecutivo . "'";
        $condiciones .= " and   a.estado           = 'CL'";
        $condiciones .= " and   a.subestado        = 'CO'";


        $baseDatos->consultarRegistros($listaCampos, $tabla, $condiciones);

        $resultado = mysqli_fetch_assoc($baseDatos->getResultado());

        if (!empty($resultado)) {
            $respuesta->setEstado("OK");
            $respuesta->setMsgError("");
            $respuesta->setRespuesta($resultado);
        } else {
            $respuesta->setEstado("ERROR");
            $respuesta->setMsgError("Numero de consecutivo no encontrado");
        }

        $baseDatos->liberarResultado();

        $baseDatos->desconectarBaseDatos();

        return response()->json($respuesta);
    }

    public function consultarVentas()
    {

        $resultado = null;

        if (!empty(request()->brigada) || !empty(request()->fecha)) {
            $baseDatos = new BaseDatos();
            $baseDatos->conectarBaseDatos();

            $listaCampos  = "  a.consecutivo as consecutivo";
            $listaCampos .= ", a.brigada";
            $listaCampos .= ", (select b.descripcion from brigadas b where b.id = a.brigada) as brigadaDescripcion";
            $listaCampos .= ", c.numero_documento as numeroDocumento";
            $listaCampos .= ", c.nombres";
            $listaCampos .= ", c.apellidos";
            $listaCampos .= ", concat(c.nombres,' ',c.apellidos) nombreCompleto";
            $listaCampos .= ", c.celular";
            $listaCampos .= ", c.telefono";
            $listaCampos .= ", v.id as venta";
            $listaCampos .= ", v.abono ";
            $listaCampos .= ", v.saldo ";
            $listaCampos .= ", v.lente ";
            $listaCampos .= ", v.fecha_venta as fecha";
            $listaCampos .= ", (select l.descripcion from tipos_lentes l where l.id = v.lente) as lenteDescripcion ";


            $tabla = "afiliaciones a, clientes_brigadas c, ventas v";

            $condiciones  = " where a.id               = c.afiliacion ";
            $condiciones .= " and   a.consecutivo      = v.consecutivo ";

            if (!empty(request()->brigada)) {
                $condiciones .= " and   a.brigada = '" . request()->brigada . "'";
            }

            if (!empty(request()->fecha)) {
                $condiciones .= " and   v.fecha_venta = '" . request()->fecha . "'";
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

    public function consultarEncabezado($fecha)
    {

        $resultado = null;

        $baseDatos = new BaseDatos();
        $baseDatos->conectarBaseDatos();

        $listaCampos  = "  a.brigada";
        $listaCampos .= ", (select b.descripcion from brigadas b where b.id = a.brigada) as brigadaDescripcion ";
        $listaCampos .= ", v.fecha_venta as fecha";

        $tabla = "afiliaciones a, ventas v";

        $condiciones  = " where a.consecutivo      = v.consecutivo ";
        $condiciones .= " and   v.fecha_venta      = '" . $fecha[0] . "'";
        $condiciones .= " group by a.brigada, v.fecha_venta  ";

        $baseDatos->consultarRegistros($listaCampos, $tabla, $condiciones);

        while ($fila = mysqli_fetch_assoc($baseDatos->getResultado())) {
            $resultado[] = $fila;
        }

        $baseDatos->liberarResultado();

        $baseDatos->desconectarBaseDatos();

        return $resultado;
    }

    public function imprimir()
    {
        $fecha = array_unique(array_column(json_decode(request()->ventas, true), 'fecha'));
        $encabezados = json_decode(json_encode($this->consultarEncabezado($fecha), false));

        $data = [
            'encabezados' => $encabezados, 'ventas'  => json_decode(request()->ventas)
        ];

        $pdf = PDF::loadView('reports.ventas', $data);
        $pdf->setPaper('A4', 'landscape');
        ob_end_clean();
        return $pdf->stream('ventas.pdf');
    }
}
