<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InventarioResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'ingrediente_id' => $this->ingrediente_id,
            'ingrediente_nombre' => $this->ingrediente->nombre,
            'unidad_abreviatura' => $this->ingrediente->unidadMedida->abreviatura,
            'stock_actual' => $this->stock_actual,
            'stock_minimo' => $this->stock_minimo,
            'stock_maximo' => $this->stock_maximo,
            'bajo_minimo' => $this->bajoMinimo(),
        ];
    }
}