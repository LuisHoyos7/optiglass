<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GastoGanancia extends Model
{
     protected $table = 'gastos_ganancias';
     public $timestamps = false;

    public function rBrigada()
    {
        return $this->belongsTo('App\Brigada','brigada');
    }

    public function rPromotor()
    {
        return $this->belongsTo('App\Usuario','promotor');
    }

    public function rAfiliaciones()
    {
        return $this->hasMany('App\Afiliacion','gasto_ganancia');
    }

}
