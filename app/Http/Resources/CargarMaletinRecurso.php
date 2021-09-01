<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CargarMaletinRecurso extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {   
        $brigada = $this->whenLoaded('rBrigada');
       
        return [
            'id' => $this->brigada,
            'descripcion' => $brigada->descripcion,
            'carga' => $this->carga,
        ];

    }
}