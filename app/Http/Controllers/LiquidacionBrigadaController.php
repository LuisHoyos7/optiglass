<?php

namespace App\Http\Controllers;
use App\Brigada;
use App\GastoGanancia;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LiquidacionBrigadaController extends Controller
{
   public function index (Request $request)
   {    

   		$brigadas = Brigada::all();

   		$liquidacionBrigadas = GastoGanancia::with('rBrigada');

   		
            							
              $liquidacionBrigadas = $liquidacionBrigadas->get();

        return view('liquidacionBrigada', compact('liquidacionBrigadas', 'brigadas'));

   }

   public function store(Request $request)
   {

   		$brigadas = Brigada::all();

   		$liquidacionBrigadas = GastoGanancia::with('rBrigada');

   		
            							
              $liquidacionBrigadas = $liquidacionBrigadas
              						->where('brigada', $request->input('brigada'));

              $liquidacionBrigadas = $liquidacionBrigadas->get();

         $gastos = "select sum(desayuno) as gasto_desayuno, sum(hotel) as gasto_hotel, sum(transporte) as gasto_transporte, sum(afiliaciones) as numero_afiliaciones, sum(entrega) as valor_afiliaciones
from gastos_ganancias gg 
where brigada = $request->brigada";

$gastos_coordinador = Brigada::where('id', $request->input('brigada'))->first();

$gastos = DB::select($gastos);


        return view('liquidacionBrigada', compact('liquidacionBrigadas', 'brigadas', 'gastos','gastos_coordinador'));

   }
}
