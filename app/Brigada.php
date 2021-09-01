<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brigada extends Model
{
     protected $table = 'brigadas';
     public $timestamps = false;

     public function rParroquia()
    {
        return $this->belongsTo('App\Parroquia', 'parroquia');
    }

}
