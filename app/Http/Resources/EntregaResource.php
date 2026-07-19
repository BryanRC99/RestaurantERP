<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EntregaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'pedido_id' => $this->pedido_id,
            'pedido_total' => $this->pedido->total,
            'cliente' => $this->pedido->cliente?->nombreCompleto(),
            'direccion' => $this->direccion,
            'estado' => $this->estado,
            'repartidor' => $this->whenLoaded('repartidor', fn () => $this->repartidor?->nombre),
            'hora_asignacion' => $this->hora_asignacion,
            'hora_entrega' => $this->hora_entrega,
        ];
    }
}