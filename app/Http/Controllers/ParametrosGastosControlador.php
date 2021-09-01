<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comunes\BaseDatos;
use App\Comunes\Respuesta;
use App\Comunes\Utilidades;
use App\ParametroGasto;
use App\Negocio\ParametrosGastosNegocio;

class ParametrosGastosControlador extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return Utilidades::validarPermiso('parametrosGastos');
    }

     public function guardar(Request $request)
    {
     		$respuesta = ParametrosGastosNegocio::validarFormulario($request);

            if ($respuesta->getEstado() != 'OK')
            {   
                return response()->json($respuesta);
            }

            $respuesta = ParametrosGastosNegocio::validarRango($request);

            if ($respuesta->getEstado() != 'OK')
            {
                return response()->json($respuesta);
            }
        
            $parametro = new ParametroGasto;
        	$parametro->estado = $request->estado;
        	$parametro->afiliaciones_minimas = $request->minima;
        	$parametro->afiliaciones_maximas = $request->maxima;
            $parametro->valor_afiliaciones = $request->pagadas;
            $parametro->aplica_desayuno = !empty($request->aplicaDesayuno);
            $parametro->cantidad_desayuno = $request->desayuno;
        	$parametro->aplica_almuerzo = !empty($request->aplicaAlmuerzo);
            $parametro->cantidad_almuerzo = $request->almuerzo;
            $parametro->aplica_cena = !empty($request->aplicaCena);
            $parametro->cantidad_cena = $request->cena;
            $parametro->aplica_hotel = !empty($request->aplicaHotel);
            $parametro->cantidad_hotel = $request->hotel;
            $parametro->aplica_transporte = !empty($request->aplicaTransporte);
            $parametro->cantidad_transporte = $request->transporte;
            $parametro->usuario_crea = request()->user()->codigo;
            $parametro->fecha = Date('Y-m-d H:i:s');
            $parametro->save();

 			$respuesta->setEstado('OK');

            return response()->json($respuesta);

    }

    public function editar(Request $request)
    {
            $respuesta = ParametrosGastosNegocio::validarFormulario($request);

            if ($respuesta->getEstado() != 'OK')
            {
                return response()->json($respuesta);
            }

            $respuesta = ParametrosGastosNegocio::validarRango($request);
            
            if ($respuesta->getEstado() != 'OK')
            {
                return response()->json($respuesta);
            }

            $parametro = ParametroGasto::find(request()->codigo);
        	$parametro->estado = $request->estado;
        	$parametro->afiliaciones_minimas = $request->minima;
        	$parametro->afiliaciones_maximas = $request->maxima;
            $parametro->valor_afiliaciones = $request->pagadas;
            $parametro->aplica_desayuno = !empty($request->aplicaDesayuno);
            $parametro->cantidad_desayuno = $request->desayuno;
        	$parametro->aplica_almuerzo = !empty($request->aplicaAlmuerzo);
            $parametro->cantidad_almuerzo = $request->almuerzo;
            $parametro->aplica_cena = !empty($request->aplicaCena);
            $parametro->cantidad_cena = $request->cena;
            $parametro->aplica_hotel = !empty($request->aplicaHotel);
            $parametro->cantidad_hotel = $request->hotel;
            $parametro->aplica_transporte = !empty($request->aplicaTransporte);
            $parametro->cantidad_transporte = $request->transporte;
            $parametro->usuario_modifica = request()->user()->codigo;
            $parametro->fecha = Date('Y-m-d H:i:s');
            $parametro->save();

            $respuesta->setEstado('OK');

            return response()->json($respuesta);
    }

     public function consultar()
    {

    	$brigadas = null;

        $baseDatos = new BaseDatos();           
        $baseDatos->conectarBaseDatos();
        

        $listaCampos  = "  id ";
        $listaCampos .= ", estado ";
        $listaCampos .= ", (case when estado = 'A' then 'Activo' when estado = 'I' then 'Inactivo' else null end) descripcionEstado";
    	$listaCampos .= ", afiliaciones_minimas as minima";
    	$listaCampos .= ", afiliaciones_maximas as maxima";
        $listaCampos .= ", valor_afiliaciones as pagadas";
        $listaCampos .= ", aplica_desayuno as aplicaDesayuno";
        $listaCampos .= ", if(aplica_desayuno=1,'Si','No') as descripcionDesayuno";
        $listaCampos .= ", cantidad_desayuno as desayuno";
    	$listaCampos .= ", aplica_almuerzo as aplicaAlmuerzo";
        $listaCampos .= ", if(aplica_almuerzo=1,'Si','No') as descripcionAlmuerzo";
    	$listaCampos .= ", cantidad_almuerzo as almuerzo";
    	$listaCampos .= ", aplica_cena as aplicaCena";
        $listaCampos .= ", if(aplica_cena=1,'Si','No') as descripcionCena";
    	$listaCampos .= ", cantidad_cena as cena";
    	$listaCampos .= ", aplica_hotel as aplicaHotel";
        $listaCampos .= ", if(aplica_hotel=1,'Si','No') as descripcionHotel";
    	$listaCampos .= ", cantidad_hotel as hotel";
    	$listaCampos .= ", aplica_transporte as aplicaTransporte";
        $listaCampos .= ", if(aplica_transporte=1,'Si','No') as descripcionTransporte";
    	$listaCampos .= ", cantidad_transporte as transporte";
      
        $tabla = "parametros_gastos";
        
        $condiciones  = " ";
       
      
        $baseDatos->consultarRegistros($listaCampos, $tabla, $condiciones);

        while ($fila = mysqli_fetch_assoc($baseDatos->getResultado() ))
		{
		    $brigadas[] = $fila;
		    
		}
    
        $baseDatos->liberarResultado();
        
        $baseDatos->desconectarBaseDatos(); 

        return response()->json($brigadas);

    }

}
