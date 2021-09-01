<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\RolRecurso;

class EstadoRecurso extends JsonResource
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
            'codigo' => $this->codigo,
            'descripcion' => $this->descripcion,
            'estado' => $this->estado,
            'estadoDescripcion' =>  $this->estado == 'A' ? 'ACTIVO' : 'INACTIVO',
        ];
    }
}