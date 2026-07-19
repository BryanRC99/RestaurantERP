<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $productoSucursal = $this->productoSucursal->first();

        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'imagen' => $this->imagen,
            'categoria_id' => $this->categoria_id,
            'tiempo_preparacion' => $this->tiempo_preparacion,
            'precio' => $productoSucursal?->precio,
            'disponible' => $productoSucursal?->disponible ?? false,
        ];
    }
}