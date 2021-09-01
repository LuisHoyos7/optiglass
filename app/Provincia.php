<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
     protected $table = 'provincias';
     protected $primaryKey = 'codigo';
     public $incrementing = false;
     protected $keyType = 'string';
     public $timestamps = false;

}
