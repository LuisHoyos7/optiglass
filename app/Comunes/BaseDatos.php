<?php
namespace App\Comunes;

class BaseDatos{
	
	 private $usuario;
     private $contrasena;
	 private $servidor;
	 private $basedatos;
	 private $conexion;
	 private $resultado;
	 
	 public function __construct()
	{
		$this->usuario 	  = 'subohatn_Optiglass';
        $this->contrasena = '^I7f)3BH(5GY';
	    $this->servidor   = 'localhost';
	    $this->basedatos  = 'subohatn_webapp';

	}

	public function setConexion($pconexion)
	 {
		 $this->conexion = $pconexion;
	 }
	
	 public function getConexion()
	 {
	 	return $this->conexion;
	 }

	 public function setResultado($presultado)
	 {
		 $this->resultado = $presultado;
	 }
	
	 public function getResultado()
	 {
	 	return $this->resultado;
	 }
	
	public function conectarBaseDatos()
	{
		
		$this->conexion = mysqli_connect( $this->servidor, $this->usuario, $this->contrasena, $this->basedatos ) 
						  or die ( "Inconveniente conectando base de datos " . mysqli_connect_error());
						  
		mysqli_set_charset($this->conexion, "utf8");				  
		
	}	

	public function desconectarBaseDatos()
	{
		$this->conexion->close();
	}	
	
	public function insertarRegistro($listaCampos, $tabla)
	{
		$sql = "Insert into " . $tabla . " values ( " . $listaCampos . ")";
		
		if (mysqli_query($this->conexion, $sql)) {
			 
		} else {
			  if (mysqli_errno($this->conexion) == 1062)
			  {
			  	die ("Registro duplicado");
			  }
			  else
			  {
			  	die (mysqli_error($this->conexion));
			  }
		}
		
	}

	public function insertarRegistroExplicito($listaCampos,$listaValores, $tabla)
	{
		$sql = "Insert into " . $tabla . " ( " . $listaCampos . " ) " . " values ( " . $listaValores . ")";
		
		if (mysqli_query($this->conexion, $sql)) {
			 
		} else {
 			  if (mysqli_errno($this->conexion) == 1062)
			  {
			  	die ("Registro duplicado");
			  }
			  else
			  {
			  	die (mysqli_error($this->conexion));
			  }
			  
		}
		
	}
	
	public function actualizarRegistro($listaCampos, $tabla, $condiciones)
	{
		$sql = "Update " . $tabla . " set " . $listaCampos . " Where " . $condiciones;
		
		if (mysqli_query($this->conexion, $sql)) {
			 
		} else {
			  die (mysqli_error($this->conexion));
		}
		
	}
	
	public function consultarRegistros($listaCampos, $tabla, $condiciones) 
	{
		
		$sql = "Select " . $listaCampos. " From " . $tabla . " " . $condiciones;
		
		$this->resultado = mysqli_query($this->conexion, $sql) or die ( "Inconvenientes consultando registros. Error: " . mysqli_error($this->conexion));
		
	}
	
	public function liberarResultado() 
	{
		mysqli_free_result($this->resultado);
	}
	
	
	
}


?>