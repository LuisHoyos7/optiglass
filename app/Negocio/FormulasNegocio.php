<?php
namespace App\Negocio;


class FormulasNegocio
{

	public static function validarFormula($formula)
    {


        $formula[] =  array('distancia' => 'LEJOS'
                           ,'ojo' => 'DERECHO'
                           ,'esfera' => "<input type='number' name='esferaLejosDerecho' value=''>"
                           ,'cilindro' => "<input type='number' name='cilindroLejosDerecho' value=''>"
                           ,'eje' => "<input type='number' name='ejeLejosDerecho' value=''>"
                           ,'av' =>  "<input type='number' name='avLejosDerecho' value=''>"
                           );
   
        $formula[] =  array('distancia' => 'LEJOS'
                           ,'ojo' => 'IZQUIERDO'
                           ,'esfera' => "<input type='number' name='esferaLejosIzquierdo' value=''>"
                           ,'cilindro' => "<input type='number' name='cilindroLejosIzquierdo' value=''>"
                           ,'eje' => "<input type='number' name='ejeLejosIzquierdo' value=''>"
                           ,'av' =>  "<input type='number' name='avLejosIzquierdo' value=''>"
                          );
   
        $formula[] =  array('distancia' => 'CERCA'
                           ,'ojo' => 'DERECHO'
                           ,'esfera' => "<input type='number' name='esferaCercaDerecho' value=''>"
                           ,'cilindro' => "<input type='number' name='cilindroCercaDerecho' value=''>"
                           ,'eje' => "<input type='number' name='ejeCercaDerecho' value=''>"
                           ,'av' =>  ""
                           );
 
        $formula[] =  array('distancia' => 'CERCA'
                           ,'ojo' => 'IZQUIERDO'
                           ,'esfera' => "<input type='number' name='esferaCercaIzquierdo' value=''>"
                           ,'cilindro' => "<input type='number' name='cilindroCercaIzquierdo' value=''>"
                           ,'eje' => "<input type='number' name='ejeCercaIzquierdo' value=''>"
                           ,'av' =>  ""
                           );

        return $formula;

    }

    public static function validarAdicion($adicion)
    {


        $adicion[] =  array('ojoDerecho' => 'DERECHO'
                           ,'adicionDerecho' => "<input type='number' name='adicionDerecho' value=''>"
                           ,'ojoIzquierdo' => "IZQUIERDO"
                           ,'adicionIzquierdo' => "<input type='number' name='adicionIzquierdo' value=''>"
                           );

        return $adicion;

    }

}