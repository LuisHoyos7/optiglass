<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comunes\BaseDatos;
use App\Comunes\Respuesta;
use App\Negocio\UsuariosNegocio;
use App\Comunes\Utilidades;
use App\Usuario;
use App\Http\Resources\UsuarioRecurso;

class UsuariosControlador extends Controller
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
            return view('usuarios');
        }
    }

     public function store(Request $request)
    {
        $respuesta = UsuariosNegocio::validarFormulario(request());

        if ($respuesta->getEstado() == 'ERROR') 
        {
            return response()->json($respuesta);
        }

        $usuario = new Usuario;

        $usuario->codigo = strtoupper($request->codigo);
        $usuario->nombre = strtoupper($request->nombre);
        $usuario->celular = $request->celular;
        $usuario->telefono = $request->telefono;
        $usuario->email = $request->email;
        $usuario->rol = $request->rol;
        $usuario->clave = $request->clave;
        $usuario->estado = $request->estado;
        $usuario->usuario_crea = request()->user()->codigo;
        $usuario->fecha = Date('Y-m-d H:i:s');
                        
        $usuario->save();
        
        $respuesta->setEstado('OK');

        return response()->json($respuesta);
    }

    public function update(Request $request, $codigo)
    {
            
        $usuario = Usuario::find($codigo);

        $usuario->nombre = strtoupper($request->nombre);
        $usuario->celular = $request->celular;
        $usuario->telefono = $request->telefono;
        $usuario->email = $request->email;
        $usuario->rol = $request->rol;
        $usuario->estado = $request->estado;
        $usuario->usuario_modifica = request()->user()->codigo;
        $usuario->fecha = Date('Y-m-d H:i:s');

        $usuario->save();
        
        $respuesta = new Respuesta();

        $respuesta->setEstado('OK');

        return response()->json($respuesta);
    }

    public function consultar() 
    {
        $usuarios = Usuario::with('rRol')->get();
        return response()->json(UsuarioRecurso::collection($usuarios));
    }

    public function cambiarClave(Request $request, $codigo)
    {
        $usuario = Usuario::find($codigo);
        $usuario->clave = $request->claveNueva;
        $usuario->usuario_modifica = request()->user()->codigo; 
        $usuario->fecha = Date('Y-m-d H:i:s');
        $usuario->save();

        $respuesta = new Respuesta();
        $respuesta->setEstado('OK');

        return response()->json($respuesta);
    }

    public function consultarUsuarios(Request $request)
    {
        $usuarios = Usuario::select('codigo','nombre')->where('estado','A');
        if (!is_null($request->input('rol')))
        {
            $usuarios = $usuarios->where('rol',$request->input('rol'));
        }
        $usuarios = $usuarios->orderBy('nombre')->get();
        return response()->json($usuarios);
    }

    public function consultarUsuarioLogin(){
        return response()->json(array('usuario' => request()->user()->codigo,
                                        'rol' => request()->user()->rol));
    }
}
