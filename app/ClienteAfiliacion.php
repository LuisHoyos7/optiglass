<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClienteAfiliacion extends Model
{
     protected $table = 'clientes_afiliacion';
     public $timestamps = false;

     public function rParroquia()
    {
        return $this->belongsTo('App\Parroquia','parroquia');
    }

}
