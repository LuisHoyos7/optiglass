<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClienteAfiliacionRecurso extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $parroquia = $this->whenLoaded('rParroquia');

        return [
            'id' => $this->id,
            'nombres' => $this->nombres,
            'apellidos' => $this->apellidos,
            'celular' => $this->celular,
            'telefono' => $this->telefono,
            'provincia' => $parroquia->rCanton->rProvincia->codigo,
            'canton' => $parroquia->rCanton->codigo,
            'parroquia' => $this->parroquia,
            'direccion' => $this->direccion,
            'idIntegrantePrincipal' => $this->id_integrante_principal,
        ];
    }
}
