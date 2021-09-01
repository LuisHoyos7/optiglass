<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MensajesTexto extends Model
{
    protected $table = 'mensajes_texto';

    protected $fillable = [
        'codigo','texto','estado'
    ];
}
