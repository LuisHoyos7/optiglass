<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClienteAfiliacionTelefonoRecurso extends JsonResource
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
            'numeroDocumento' => $this->numero_documento,
            'nombres' => $this->nombres,
            'apellidos' => $this->apellidos,
            'celular' => $this->celular,
            'telefono' => $this->telefono,
            'provincia' => $this->provincia,
            'canton' => $this->canton,
            'parroquia' => $this->parroquia,
            'direccion' => $this->direccion,
            'idIntegrantePrincipal' => $this->id_integrante_principal,
            'consecutivo' => $this->consecutivo,
            'idBrigada' => $this->idBrigada,
            'descripcionBrigada' => $this->descripcionBrigada
        ];
    }
}
