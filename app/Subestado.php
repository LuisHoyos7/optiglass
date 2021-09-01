<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subestado extends Model
{
     protected $table = 'subestados';
     protected $primaryKey = 'codigo';
     public $incrementing = false;
     protected $keyType = 'string';
     public $timestamps = false;

     public function rEstado()
    {
        return $this->belongsTo('App\Estado', 'codigo_estado');
    }
}
