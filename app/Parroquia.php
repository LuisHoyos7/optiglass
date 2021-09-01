<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parroquia extends Model
{
     protected $table = 'parroquias';
     protected $primaryKey = 'codigo';
     public $incrementing = false;
     protected $keyType = 'string';
     public $timestamps = false;

     public function rCanton()
    {
        return $this->belongsTo('App\Canton', 'canton');
    }

}
