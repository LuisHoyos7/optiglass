<?php

namespace App\Negocio;

use App\Afiliacion;
use App\Comunes\Respuesta;
use App\Comunes\BaseDatos;

class AsistenciasNegocio
{

    public static function validarConsecutivo($campos)
    {

        $respuesta = new Respuesta();

        $baseDatos = new BaseDatos();
        $baseDatos->conectarBaseDatos();

        $listaCampos = " consecutivo ";

        $tabla = "afiliaciones";

        $condiciones  = " where consecutivo = '" . $campos->consecutivo . "'";

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

    public static function validarClienteAfiliacion($campos)
    {

        $respuesta = new Respuesta();

        $baseDatos = new BaseDatos();
        $baseDatos->conectarBaseDatos();

        $listaCampos = " numero_documento ";

        $tabla = "clientes_afiliacion";

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

    public static function validarIdAfiliacion($campos)
    {

        $respuesta = new Respuesta();

        if (isEmpty($campos->afiliacion)) {
            $respuesta->setEstado("OK");
            $respuesta->setMsgError("");
            return $respuesta;
        }

        $baseDatos = new BaseDatos();
        $baseDatos->conectarBaseDatos();

        $listaCampos = " afiliacion ";

        $tabla = "clientes_afiliacion";

        $condiciones  = " where numero_documento = '" . $campos->afiliacion . "'";

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
