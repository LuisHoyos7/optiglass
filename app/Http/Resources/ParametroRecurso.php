<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ParametroRecurso extends JsonResource
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
            'valor' => $this->valor,
            'estado' =>  $this->estado == 'A' ? 'ACTIVO' : 'INACTIVO',
        ];
    }
}
