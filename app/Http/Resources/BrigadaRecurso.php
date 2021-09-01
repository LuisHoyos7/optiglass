<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BrigadaRecurso extends JsonResource
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
            'numero' => $this->id,
            'descripcion' => $this->descripcion,
            'fechaPreventa' => $this->fecha_preventa,
            'fechaInicio' => $this->fecha_inicio,
            'horaInicio' => $this->hora_inicio,
            'fechaCierre' => $this->fecha_cierre,
            'telefonos' => $this->telefonos,
            'provincia' => !empty($this->parroquia) ? $parroquia->rCanton->rProvincia->codigo : null,
            'canton' => !empty($this->parroquia) ? $parroquia->rCanton->codigo : null,
            'parroquia' => $this->parroquia,
            'direccion' => $this->direccion,
            'estado' => $this->estado,
            'estadoDescripcion' =>  $this->estado == 'A' ? 'ACTIVA' : ($this->estado == 'P' ? 'PREVENTA' : 'CERRADA'),
            'desayunoPromotor' => $this->desayuno_promotor,
            'almuerzoPromotor' => $this->almuerzo_promotor,
            'cenaPromotor' => $this->cena_promotor,
            'hotelPromotor' => $this->hotel_promotor,
            'transportePromotor' => $this->transporte_promotor,
            'desayunoCoordinador' => $this->desayuno_coordinador,
            'almuerzoCoordinador' => $this->almuerzo_coordinador,
            'cenaCoordinador' => $this->cena_coordinador,
            'hotelCoordinador' => $this->hotel_coordinador,
            'transporteCoordinador' => $this->transporte_coordinador,
        ];
    }
}