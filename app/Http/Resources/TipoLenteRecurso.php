<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TipoLenteRecurso extends JsonResource
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
            'descripcion' => $this->descripcion,
            'estado' => $this->estado,
            'estadoDescripcion' => $this->estado == 'A' ? 'ACTIVO' : 'INACTIVO',
        ];

    }
}