<?php
namespace App\Comunes;

class Respuesta
{
	public $estado;
	public $msgError;
	public $respuesta;
	public $origen;
	
	public function setEstado($pestado)
	{
		$this->estado = $pestado;
	}
	
	public function setMsgError($pmsgError)
	{
		$this->msgError = $pmsgError;
	}
	
	public function setRespuesta($prespuesta)
	{
		$this->respuesta = $prespuesta;
	}
	
	public function setOrigen($porigen)
	{
		$this->origen = $porigen;
	}
	
	public function getEstado()
	{
		return $this->estado;
	}
	
	public function getMsgError()
	{
		return $this->msgError;
	}
	
	public function getRespuesta()
	{
		return $this->respuesta;
	}
	
	public function getOrigen()
	{
		return $this->origen;
	}
}