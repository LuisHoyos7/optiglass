<?php

namespace App\Http\Controllers;

use App\Parametro;
use App\Http\Resources\ParametroRecurso;

class ParametrosSistemaControlador extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show($id)
    {
        $parametro = Parametro::find($id);
        return response()->json(new ParametroRecurso($parametro));
    }
}
