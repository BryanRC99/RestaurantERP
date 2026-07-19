<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PagoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'tipo_pago' => $this->tipo_pago,
            'monto' => $this->monto,
            'referencia' => $this->referencia,
            'fecha_pago' => $this->fecha_pago,
        ];
    }
}