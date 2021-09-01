<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClienteBrigada extends Model
{
    protected $table = 'clientes_brigadas';
    public $timestamps = false;

    public function rParroquia()
    {
        return $this->belongsTo('App\Parroquia', 'parroquia');
    }
}
