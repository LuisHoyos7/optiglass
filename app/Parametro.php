<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parametro extends Model
{

    protected $table = 'parametros_sistema';
    protected $primaryKey = 'codigo';

    protected $fillable = [
        'opcion', 'descripcion', 'valor', 'estado'
    ];
}
