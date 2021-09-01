<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\RolRecurso;

class SubestadoRecurso extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {   
        $estado = $this->whenLoaded('rEstado');

        return [
            'codigoEstado' => isset($estado->codigo) ? $estado->codigo : '', 
            'estadoDescripcion' => isset($estado->descripcion) ? $estado->descripcion : '', 
            'codigo' => $this->codigo,
            'descripcion' => $this->descripcion,
            'estado' => $this->estado,
            'estadoSubestado' =>  $this->estado == 'A' ? 'ACTIVO' : 'INACTIVO',
        ];
    }
}