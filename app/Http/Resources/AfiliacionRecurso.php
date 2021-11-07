<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\RolRecurso;

class AfiliacionRecurso extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {   
        
       
        return [
            'id' => $this->id,
            'fecha' => $this->fecha_registro,
            'abono' => $this->abono,
            'saldo' => $this->saldo,
        ];

    }
}