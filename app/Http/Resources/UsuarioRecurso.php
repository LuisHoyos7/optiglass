<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\RolRecurso;

class UsuarioRecurso extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {   
        $rol = $this->whenLoaded('rRol');
       
        return [
            'codigo' => $this->codigo,
            'nombre' => $this->nombre,
            'celular' => $this->celular,
            'telefono' => $this->telefono,
            'email' => $this->email,
            'rol' => isset($rol->codigo) ? $rol->codigo : '', 
            'rolDescripcion' => isset($rol->descripcion) ? $rol->descripcion : '',
            'estado' => $this->estado,
            'estadoDescripcion' =>  $this->estado == 'A' ? 'ACTIVO' : 'INACTIVO',
        ];
    }
}