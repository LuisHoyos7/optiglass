<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GastoGananciaRecurso extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {   
        $promotor = $this->whenLoaded('rPromotor');
       
        return [
            'id' => $this->id,
            'promotor' => $this->promotor,
            'nombrePromotor' => $promotor->nombre,
            'brigada' => $this->brigada,
            'fecha' => $this->fecha_operacion,
            'cantidad' => $this->afiliaciones,
            'abonos' => $this->abonos,
            'valor' => $this->valor,
            'gananciaValor' => $this->ganancia_valor,
            'desayuno' => $this->desayuno,
            'gananciaDesayuno' => $this->ganancia_desayuno,
            'prestamoDesayuno' => $this->prestamo_desayuno,
            'almuerzo' => $this->almuerzo,
            'gananciaAlmuerzo' => $this->ganancia_almuerzo,
            'prestamoAlmuerzo' => $this->prestamo_almuerzo,
            'cena' => $this->cena,
            'gananciaCena' => $this->ganancia_cena,
            'prestamoCena' => $this->prestamo_cena,
            'hotel' => $this->hotel,
            'gananciaHotel' => $this->ganancia_hotel,
            'prestamoHotel' => $this->prestamo_hotel,
            'transporte' => $this->transporte,
            'gananciaTransporte' => $this->ganancia_transporte,
            'prestamoTransporte' => $this->prestamo_transporte,
            'otrosPrestamos' => $this->otros_prestamos,
            'otrosPrestamosObservacion' => $this->otros_prestamos_observacion,
            'prestamo' => $this->prestamo,
            'ganancia' => ($this->ganancia_almuerzo + $this->ganancia_cena + $this->ganancia_transporte),
            'entrega' => $this->entrega,
        ];
    }
}