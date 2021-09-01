<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GestionRecurso extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {   
        $subestado = $this->whenLoaded('rSubestado');
       
        return [
            'fecha' => $this->fecha,
            'subestado' => $subestado->descripcion,
            'observacion' => $this->observacion,
        ];

    }
}