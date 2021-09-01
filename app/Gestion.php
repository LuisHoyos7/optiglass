<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gestion extends Model
{
     protected $table = 'gestiones';
     public $timestamps = false;

     public function rSubestado()
    {
        return $this->belongsTo('App\Subestado','subestado');
    }

}
