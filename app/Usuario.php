<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
     protected $table = 'usuarios';
     protected $primaryKey = 'codigo';
     public $incrementing = false;
     protected $keyType = 'string';
     public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'codigo', 'clave'
    ];

    public function rRol()
    {
        return $this->belongsTo('App\Rol', 'rol');
    }

}
