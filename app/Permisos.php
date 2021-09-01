<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permisos extends Model
{
    protected $table = 'permisos';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'opcion','descripcion'
    ];
}
