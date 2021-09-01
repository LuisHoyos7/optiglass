<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
     protected $table = 'roles';
     protected $primaryKey = 'codigo';
     public $incrementing = false;
     protected $keyType = 'string';
     public $timestamps = false;

}
