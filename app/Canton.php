<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Canton extends Model
{
     protected $table = 'cantones';
     protected $primaryKey = 'codigo';
     public $incrementing = false;
     protected $keyType = 'string';
     public $timestamps = false;

     public function rProvincia()
    {
        return $this->belongsTo('App\Provincia', 'provincia');
    }
}
