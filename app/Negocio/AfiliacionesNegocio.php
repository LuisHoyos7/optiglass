<?php

namespace App\Negocio;

use App\Comunes\Respuesta;
use App\Comunes\BaseDatos;
use App\Afiliacion;
use App\ClienteAfiliacion;

class AfiliacionesNegocio
{
    public static function validar($request, $edit)
    {

        $respuesta = new Respuesta();
        $respuesta->setEstado("OK");

        if (!$edit) {
            $afiliacion = Afiliacion::where('consecutivo', $request->consecutivo)->first();
            if ($afiliacion != null) {
                $respuesta->setEstado("ERROR");
                $respuesta->setMsgError("El consecutivo " . $request->consecutivo . " ya existe");
                return $respuesta;
            }

            /*
            if (strlen($request->celular) == 10)
            {	    	
                $cliente = ClienteAfiliacion::where('celular',$request->celular)
                                            ->orWhere('telefono',$request->celular)
                                            ->first();
                if ($cliente != null)
                {
                    $respuesta->setEstado("ERROR");
                    $respuesta->setMsgError("El número de celular " . $request->celular . " ya existe");
                    return $respuesta;
                }
            }   

            if (strlen($request->telefono) == 10)
            {	    	
                $cliente = ClienteAfiliacion::where('celular',$request->telefono)
                                            ->orWhere('telefono',$request->telefono)
                                            ->first();
                if ($cliente != null)
                {
                    $respuesta->setEstado("ERROR");
                    $respuesta->setMsgError("El número de celular " . $request->celular . " ya existe");
                    return $respuesta;
                }
            }   
            */
        }

        return $respuesta;
    }

    public static function validarConsecutivo($campos)
    {

        $respuesta = new Respuesta();

        $baseDatos = new BaseDatos();
        $baseDatos->conectarBaseDatos();

        $listaCampos = " id ";

        $tabla = "afiliaciones";

        $condiciones  = " where id = '" . $campos->consecutivo . "'";

        $baseDatos->consultarRegistros($listaCampos, $tabla, $condiciones);

        $registros = mysqli_fetch_array($baseDatos->getResultado());

        if (empty($registros)) {
            $respuesta->setEstado("OK");
            $respuesta->setMsgError("");
        } else {
            $respuesta->setEstado("ERROR");
            $respuesta->setMsgError("Consecutivo ya existe");
        }

        $baseDatos->liberarResultado();

        $baseDatos->desconectarBaseDatos();

        return $respuesta;
    }

    public static function validarCliente($campos)
    {

        $respuesta = new Respuesta();

        $baseDatos = new BaseDatos();
        $baseDatos->conectarBaseDatos();

        $listaCampos = " numero_documento ";

        $tabla = "clientes_brigadas";

        $condiciones  = " where numero_documento = '" . $campos->numeroDocumento . "'";

        $baseDatos->consultarRegistros($listaCampos, $tabla, $condiciones);

        $registros = mysqli_fetch_array($baseDatos->getResultado());

        if (empty($registros)) {
            $respuesta->setEstado("OK");
            $respuesta->setMsgError("");
        } else {
            $respuesta->setEstado("ERROR");
            $respuesta->setMsgError("");
        }

        $baseDatos->liberarResultado();

        $baseDatos->desconectarBaseDatos();

        return $respuesta;
    }

    public static function validarPendiente($campos)
    {

        $respuesta = new Respuesta();

        $respuesta->setEstado("OK");

        if ($campos->saldo != $campos->pendiente) {
            if ($campos->saldo != 0) {
                $respuesta->setEstado("ERROR");
                $respuesta->setMsgError("El valor pendiente no coincide con el saldo");
            }
        }

        return $respuesta;
    }
}
