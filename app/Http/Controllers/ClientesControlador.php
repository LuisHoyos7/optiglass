<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comunes\BaseDatos;
use App\Comunes\Respuesta;
use App\Negocio\ClientesNegocio;

class ClientesControlador extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function registrar()
    {

        //Si no existe id, el cliente es nuevo
        if (!empty(request()->consecutivo)) {
            return $this->editar();
        } else {
            return $this->guardar();
        }
    }

    public function guardar()
    {

        $respuesta = ClientesNegocio::validarCelular(request(), '');

        if ($respuesta->getEstado() != 'OK') {
            return response()->json($respuesta);
        }

        $baseDatos = new BaseDatos();
        $baseDatos->conectarBaseDatos();

        $listaCampos  = "  id ";
        $listaCampos .= ", nombres ";
        $listaCampos .= ", apellidos ";
        $listaCampos .= ", sexo ";
        $listaCampos .= ", celular ";
        $listaCampos .= ", telefono ";
        $listaCampos .= ", provincia ";
        $listaCampos .= ", canton ";
        $listaCampos .= ", parroquia ";
        $listaCampos .= ", direccion ";
        $listaCampos .= ", usuario_crea ";
        $listaCampos .= ", fecha ";

        $listaValores  = "  '" . request()->consecutivo . "'";
        $listaValores .= ", '" . strtoupper(request()->nombres) . "'";
        $listaValores .= ", '" . strtoupper(request()->apellidos) . "'";
        $listaValores .= ", '" . request()->sexo . "'";
        $listaValores .= ", '" . request()->celular . "'";
        $listaValores .= ", '" . request()->telefono . "'";
        $listaValores .= ", '" . request()->provincia . "'";
        $listaValores .= ", '" . request()->canton . "'";
        $listaValores .= ", '" . request()->parroquia . "'";
        $listaValores .= ", '" . strtoupper(request()->direccion) . "'";
        $listaValores .= ", '" . request()->user()->codigo . "'";
        $listaValores .= ", '" . Date('Y-m-d H:i:s') . "'";

        $tabla = "clientes_afiliacion";

        $baseDatos->insertarRegistroExplicito($listaCampos, $listaValores, $tabla);

        $baseDatos->desconectarBaseDatos();

        $respuesta->setEstado('OK');

        return response()->json($respuesta);
    }

    public function editar()
    {
        $respuesta = ClientesNegocio::validarCelular(request(), '');

        if ($respuesta->getEstado() != 'OK') {
            return response()->json($respuesta);
        }

        $baseDatos = new BaseDatos();
        $baseDatos->conectarBaseDatos();

        $listaCampos  = "  nombres   = '" . strtoupper(request()->nombres) . "'";
        $listaCampos .= ", apellidos = '" . strtoupper(request()->apellidos) . "'";
        $listaCampos .= ", sexo      = '" . request()->sexo . "'";
        $listaCampos .= ", celular   = '" . request()->celular . "'";
        $listaCampos .= ", telefono  = '" . request()->telefono . "'";
        $listaCampos .= ", provincia = '" . request()->provincia . "'";
        $listaCampos .= ", canton    = '" . request()->canton . "'";
        $listaCampos .= ", parroquia = '" . request()->parroquia . "'";
        $listaCampos .= ", direccion = '" . strtoupper(request()->direccion) . "'";
        $listaCampos .= ", usuario_modifica ='" . request()->user()->codigo . "'";
        $listaCampos .= ", fecha     = '" . Date('Y-m-d H:i:s') . "'";

        $condiciones = " id = " . request()->consecutivo;

        $tabla = "clientes_afiliacion";

        $baseDatos->actualizarRegistro($listaCampos, $tabla, $condiciones);

        $baseDatos->desconectarBaseDatos();

        $respuesta->setEstado('OK');

        return response()->json($respuesta);
    }

    public function consultarTelefonosDuplicados()
    {

        $resultado = null;

        $baseDatos = new BaseDatos();
        $baseDatos->conectarBaseDatos();

        $listaCampos  = "  concat(nombres,' ',apellidos) as nombreCompleto ";

        $tabla = "clientes";

        $condiciones  = " where celular = '" . request()->celular . "'";

        if (!empty(request()->telefono)) {
            $condiciones  = " where telefono = '" . request()->telefono . "'";
        }

        $condiciones .= " and  id != '" . request()->id . "'";

        $baseDatos->consultarRegistros($listaCampos, $tabla, $condiciones);


        $html  = "<li>
                    <h5>Teléfono duplicado</h6>
                     <h6 style='text-align: center'>";
        $html .=  empty(request()->celular) ? request()->telefono : request()->celular;
        $html .= "  </h6>
                  </li>
                  <li class='divider'></li>";

        $html2 = '';
        while ($fila = mysqli_fetch_assoc($baseDatos->getResultado())) {
            $html2 .= "<li style='margin-bottom: 10px;margin-top: 10px'>
                            <span style='margin-right: 10px;' class='material-icons icon-bg-circle cyan medium'>person</span>";
            $html2 .=            ucwords(strtolower($fila['nombreCompleto']));
            $html2 .= "</li>";
        }

        if (!empty($html2)) {
            $html .= $html2;
        } else {
            $html = '';
        }

        $baseDatos->liberarResultado();

        $baseDatos->desconectarBaseDatos();

        return $html;
    }
}
