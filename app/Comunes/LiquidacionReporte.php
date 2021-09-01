<?php

namespace App\Comunes;

use App\Lib\fpdf181\fpdf;

class LiquidacionReporte extends FPDF
{
	// Tabla simple
	public function basicTable($header)
	{
	    // Cabecera
	    foreach($header as $col)
	    $this->Cell(45,7,$col,1);
	    $this->Ln();
	   
	}

}