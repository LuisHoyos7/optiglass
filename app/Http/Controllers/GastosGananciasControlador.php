<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comunes\Respuesta;
use App\Negocio\GastosGananciasNegocio;
use App\Afiliacion;
use App\Brigada;
use App\ParametroGasto;
use App\GastoGanancia;
use App\Http\Resources\GastoGananciaRecurso;
use Illuminate\Support\Facades\DB;

class GastosGananciasControlador extends Controller
{
    
     public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->consultar($request);
        } else {
            return view('gastosGanancias');
        }
    }
    
    public function store(Request $request)
    {
        $respuesta = GastosGananciasNegocio::validar($request);

        if ($respuesta->getEstado() != 'OK')
        {
            return response()->json($respuesta);
        }

        DB::transaction(function() use ($request) {
            $gastoGanancia = new GastoGanancia;
            $gastoGanancia->promotor = $request->promotor;
            $gastoGanancia->fecha_operacion = $request->fecha;
            $gastoGanancia->brigada = $request->brigada;
            $gastoGanancia->afiliaciones = $request->cantidad; 
            $gastoGanancia->abonos = $request->abonos; 
            $gastoGanancia->valor = $request->valor;  
            $gastoGanancia->ganancia_valor = $request->gananciaValor;  
            $gastoGanancia->desayuno = $request->desayuno;
            $gastoGanancia->ganancia_desayuno = $request->gananciaDesayuno;
            $gastoGanancia->prestamo_desayuno = !empty($request->prestamoDesayuno);  
            $gastoGanancia->almuerzo = $request->almuerzo;
            $gastoGanancia->ganancia_almuerzo = $request->gananciaAlmuerzo;
            $gastoGanancia->prestamo_almuerzo = !empty($request->prestamoAlmuerzo);  
            $gastoGanancia->cena = $request->cena; 
            $gastoGanancia->ganancia_cena = $request->gananciaCena;  
            $gastoGanancia->prestamo_cena = !empty($request->prestamoCena);
            $gastoGanancia->hotel = $request->hotel;  
            $gastoGanancia->ganancia_hotel = $request->gananciaHotel;  
            $gastoGanancia->prestamo_hotel = !empty($request->prestamoHotel);
            $gastoGanancia->transporte = $request->transporte;
            $gastoGanancia->ganancia_transporte = $request->gananciaTransporte;
            $gastoGanancia->prestamo_transporte = !empty($request->prestamoTransporte);  
            $gastoGanancia->otros_prestamos = $request->otrosPrestamos;
            $gastoGanancia->otros_prestamos_observacion = !is_null($request->otrosPrestamos) ? strtoupper($request->otrosPrestamosObservacion) : null;
            $gastoGanancia->prestamo = $request->prestamo;
            $gastoGanancia->entrega = $request->entrega;
            $gastoGanancia->usuario_crea = request()->user()->codigo; 
            $gastoGanancia->fecha = Date('Y-m-d H:i:s');
            $gastoGanancia->save();

            $afiliaciones = Afiliacion::where('promotor',$request->promotor)
                                        ->where('brigada',$request->brigada)
                                        ->where('fecha_registro',$request->fecha)
                                        ->where('gasto_ganancia',null)
                                        ->get();
            foreach ($afiliaciones as $afiliacion)
            {
                $gastoGanancia->rAfiliaciones()->save($afiliacion);    
            }                            
        });

        return response()->json($respuesta);
    }


    public function update(Request $request,$id)
    {
        $respuesta = GastosGananciasNegocio::validar($request);

        if ($respuesta->getEstado() != 'OK')
        {
            return response()->json($respuesta);
        }

        $gastoGanancia = GastoGanancia::find($id);
        $gastoGanancia->prestamo_desayuno    = !empty($request->prestamoDesayuno);
        $gastoGanancia->prestamo_almuerzo 	= !empty($request->prestamoAlmuerzo);
        $gastoGanancia->prestamo_cena 		= !empty($request->prestamoCena); 
        $gastoGanancia->prestamo_hotel       = !empty($request->prestamoHotel);  
        $gastoGanancia->prestamo_transporte  = !empty($request->prestamoTransporte);
        $gastoGanancia->otros_prestamos = $request->otrosPrestamos;
        $gastoGanancia->otros_prestamos_observacion = !is_null($request->otrosPrestamos) ? strtoupper($request->otrosPrestamosObservacion) : null;
        $gastoGanancia->prestamo        = $request->prestamo;
        $gastoGanancia->entrega         = $request->entrega;
        $gastoGanancia->usuario_crea    = request()->user()->codigo; 
        $gastoGanancia->fecha           = Date('Y-m-d H:i:s');
        $gastoGanancia->save();

        $respuesta->setEstado('OK');

        return response()->json($respuesta);
    }

    public function consultar()
    {   
        $gastosGanancias = GastoGanancia::with('rPromotor')->orderBy('fecha_operacion')->get();
        return response()->json(GastoGananciaRecurso::collection($gastosGanancias));
    }

    public function consultarConfiguracion()
    {
        $respuesta = null;
        $afiliaciones =  $this->obtenerAfiliaciones();
        
        if ($afiliaciones->cantidad > 0)
        {

            $gastos 	  =  $this->obtenerGastos();
            $parametros   =  $this->obtenerParametros($afiliaciones->cantidad);
            $prestamo     =  GastosGananciasNegocio::calcularPrestamo($gastos,$parametros);
        	$ganancia     =  GastosGananciasNegocio::calcularGanancia($afiliaciones,$gastos,$parametros);
           
        	$respuesta 	  = array('cantidad' 	=>  $afiliaciones->cantidad
                                    ,'abonos'   =>  $afiliaciones->abonos
                                    ,'desayuno' =>  $gastos->desayuno_promotor
    					     		,'almuerzo' =>  $gastos->almuerzo_promotor
    					    		,'cena' 	=>  $gastos->cena_promotor
    					    		,'hotel' 	=>  $gastos->hotel_promotor
    					    		,'transporte' =>  $gastos->transporte_promotor
                                    ,'aplicaDesayuno' => isset($parametros->aplica_desayuno) ? $parametros->aplica_desayuno : 0
                                    ,'aplicaAlmuerzo' => isset($parametros->aplica_almuerzo) ? $parametros->aplica_almuerzo : 0
                                    ,'aplicaCena'     => isset($parametros->aplica_cena) ? $parametros->aplica_cena : 0
                                    ,'aplicaHotel'    => isset($parametros->aplica_hotel) ? $parametros->aplica_hotel : 0
                                    ,'aplicaTransporte' => isset($parametros->aplica_transporte) ? $parametros->aplica_transporte : 0
    					    		,'valor'	=>  isset($parametros->valor_afiliaciones) ? $parametros->valor_afiliaciones : 0
    					    		,'prestamo'	=>  $prestamo 
                                    ,'ganancia'   =>  $ganancia->ganancia
                                    ,'gananciaAlmuerzo'   =>  $ganancia->gananciaAlmuerzo
                                    ,'gananciaCena'       =>  $ganancia->gananciaCena
                                    ,'gananciaTransporte' =>  $ganancia->gananciaTransporte
    					    	  );

        }
        else
        {
            $respuesta    = array('cantidad'    =>  0
                                    ,'abonos'   =>  ''
                                    ,'desayuno' =>  ''
                                    ,'almuerzo' =>  ''
                                    ,'cena'     =>  ''
                                    ,'hotel'    =>  ''
                                    ,'transporte' =>  ''
                                    ,'aplicaDesayuno' => null
                                    ,'aplicaAlmuerzo' => null
                                    ,'aplicaCena'     => null
                                    ,'aplicaHotel'    => null
                                    ,'aplicaTransporte' => null
                                    ,'valor'    =>  ''
                                    ,'prestamo' =>  ''
                                    ,'ganancia' =>  ''
                                    ,'gananciaAlmuerzo'   =>  ''
                                    ,'gananciaCena'       =>  ''
                                    ,'gananciaTransporte' =>  ''
                              );
        }

		 return response()->json($respuesta);

    }


    public function obtenerAfiliaciones()
    {
        $afiliaciones = Afiliacion::select(DB::raw('count(1) as cantidad, ifnull(sum(abono),0) as abonos'))
                                  ->where('promotor',request()->input('promotor'))
                                  ->where('brigada',request()->input('brigada'))
                                  ->where('fecha_registro',request()->input('fecha'))
                                  ->where('gasto_ganancia',null)
                                  ->first(1);

        return $afiliaciones;
    }

    public function obtenerGastos()
    {
        $brigada = Brigada::find(request()->input('brigada'));
        return $brigada;
    }

    public function obtenerParametros($cantidad)
    {
        $parametro = ParametroGasto::where('afiliaciones_minimas','<=',$cantidad)
                                    ->where('afiliaciones_maximas','>=',$cantidad)
                                    ->where('estado','A')
                                    ->first();

        return $parametro;
    }

}
