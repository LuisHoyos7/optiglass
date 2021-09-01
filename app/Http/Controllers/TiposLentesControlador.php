<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comunes\BaseDatos;
use App\Comunes\Respuesta;
use App\Comunes\Utilidades;
use App\TipoLente;
use App\Http\Resources\TipoLenteRecurso;

class TiposLentesControlador extends Controller
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
            return view('tiposLentes');
        }
    }

    public function store(Request $request)
    {
        $tipoLente = new TipoLente;
        $tipoLente->descripcion = strtoupper($request->descripcion);
        $tipoLente->estado = $request->estado;
        $tipoLente->usuario_crea =  request()->user()->codigo;
        $tipoLente->fecha = Date('Y-m-d H:i:s');
        $tipoLente->save();

        $respuesta = new Respuesta();
        $respuesta->setEstado('OK');

        return response()->json($respuesta);
    }

    public function update(Request $request, $id)
    {
        $tipoLente = TipoLente::find($id);
        $tipoLente->descripcion = strtoupper($request->descripcion);
        $tipoLente->estado         =  $request->estado;
        $tipoLente->usuario_modifica = request()->user()->codigo;
        $tipoLente->fecha         =  Date('Y-m-d H:i:s');
        $tipoLente->save();

        $respuesta = new Respuesta();
        $respuesta->setEstado('OK');

        return response()->json($respuesta);
    }

    public function consultar()
    {
        $tipoLentes = TipoLente::all();
        return response()->json(TipoLenteRecurso::collection($tipoLentes));
    }

    public function consultarLentes()
    {

        $baseDatos = new BaseDatos();
        $baseDatos->conectarBaseDatos();

        $listaCampos  = " id ";
        $listaCampos .= ", descripcion ";

        $tabla = " tipos_lentes ";

        $condiciones  = " where estado = 'A'";

        $baseDatos->consultarRegistros($listaCampos, $tabla, $condiciones);

        $lentes = "<option value='' disabled selected>Seleccione</option>";
        while ($fila = mysqli_fetch_assoc($baseDatos->getResultado())) {
            $lentes .= "<option value='" . $fila["id"] . "'>" . ucwords(strtolower($fila["descripcion"])) . "</option>";
        }

        $baseDatos->liberarResultado();

        $baseDatos->desconectarBaseDatos();

        echo $lentes;
    }
}
