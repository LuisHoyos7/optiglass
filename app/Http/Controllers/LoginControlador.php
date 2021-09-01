<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\User;
use App\Permisos;
use App\Parametro;
use App\MensajesTexto;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LoginControlador extends Controller
{

    public function showLogin()
    {
        // Verificamos si hay sesión activa
        if (Auth::check()) {
            // Si tenemos sesión activa mostrará la página de inicio
            return Redirect::to('/');
        }
        // Si no hay sesión activa mostramos el formulario
        return view('login');
    }

    public function login(Request $request)
    {

        $usuario = User::where('codigo', $request->codigo)
            ->where('estado', 'A')
            ->get()->first();

        if (empty($usuario)) {
            return Redirect::back()->with('mensaje_error', 'Datos incorrectos')->withInput();
        } else {
            if ($usuario->clave == $request->clave) {

                Auth::login($usuario);

                $permisos = DB::table('permisos')
                    ->join('opciones_sistemas', 'permisos.opcion', '=', 'opciones_sistemas.codigo')
                    ->where('permisos.rol', '=', $usuario->rol)
                    ->orderBy('opciones_sistemas.orden', 'ASC')
                    ->select('permisos.opcion', 'opciones_sistemas.descripcion')
                    ->get();

                Session::put('permisos', $permisos);

                $parametros = Parametro::where('estado', 'A')
                    ->get();

                Session::put('parametros', $parametros);

                $mensajes = MensajesTexto::where('estado', 'A')
                    ->get();

                Session::put('mensajes', $mensajes);

                return Redirect::intended('/');
            } else {
                return Redirect::back()->with('mensaje_error', 'Datos incorrectos')->withInput();
            }
        }
    }


    public function logOut()
    {
        // Cerramos la sesión
        Auth::logout();
        // Volvemos al login y mostramos un mensaje indicando que se cerró la sesión
        return Redirect::to('login')->with('error_message', 'Logged out correctly');
    }
}
