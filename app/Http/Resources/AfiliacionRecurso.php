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
        $brigada = $this->whenLoaded('rBrigada');
        $promotor = $this->whenLoaded('rPromotor');
        $cliente = $this->whenLoaded('rCliente');
        $subestado = $this->whenLoaded('rSubestado');
       
        return [
            'id' => $this->id,
            'consecutivo' => $this->consecutivo,
            'fecha' => $this->fecha_registro,
            'brigada' => $brigada->descripcion,
            'promotor' => $promotor->nombre,
            'abono' => $this->abono,
            'saldo' => $this->saldo,
            'subestado' => $this->subestado,
            'subestadoDescripcion' => $subestado->descripcion,
            'observacion' => $this->observacion_revision,
            'idCliente' => $cliente->id,
            'nombres' => $cliente->nombres,
            'apellidos' => $cliente->apellidos,
            'nombreCompleto' => ($cliente->nombres . ' ' . $cliente->apellidos), 
            'celular' => $cliente->celular,
            'telefono' => $cliente->telefono,
            'direccion' => $cliente->direccion,
        ];

    }
}