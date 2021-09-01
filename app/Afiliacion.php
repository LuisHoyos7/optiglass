<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Afiliacion extends Model
{
     protected $table = 'afiliaciones';
     public $timestamps = false;

     public function rCliente()
    {
        return $this->hasOne('App\ClienteAfiliacion','afiliacion');
    }

    public function rBrigada()
    {
        return $this->belongsTo('App\Brigada','brigada');
    }

    public function rPromotor()
    {
        return $this->belongsTo('App\Usuario','promotor');
    }

    public function rSubestado()
    {
        return $this->belongsTo('App\Subestado','subestado');
    }

    public function rGestiones()
    {
        return $this->hasMany('App\Gestion','afiliacion');
    }

    public function rGestor()
    {
        return $this->belongsTo('App\Usuario','usuario_gestion');
    }

}
