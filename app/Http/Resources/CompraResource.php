<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompraResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'proveedor' => $this->whenLoaded('proveedor', fn () => [
                'id' => $this->proveedor->id,
                'nombre' => $this->proveedor->nombre,
            ]),
            'fecha_compra' => $this->fecha_compra,
            'subtotal' => $this->subtotal,
            'impuesto' => $this->impuesto,
            'total' => $this->total,
            'estado' => $this->estado,
            'items' => $this->whenLoaded('detalle', fn () => $this->detalle->map(fn ($linea) => [
                'id' => $linea->id,
                'ingrediente_id' => $linea->ingrediente_id,
                'ingrediente_nombre' => $linea->ingrediente->nombre,
                'cantidad' => $linea->cantidad,
                'unidad_medida_id' => $linea->unidad_medida_id,
                'precio_unitario' => $linea->precio_unitario,
                'subtotal' => $linea->subtotal,
            ])),
        ];
    }
}