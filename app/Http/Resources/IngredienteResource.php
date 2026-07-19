<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IngredienteResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'unidad_medida_id' => $this->unidad_medida_id,
            'unidad_medida_abreviatura' => $this->unidadMedida->abreviatura,
        ];
    }
}