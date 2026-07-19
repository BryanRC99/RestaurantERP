<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PagoResource;

class PedidoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'pagos' => $this->whenLoaded('pagos', fn() => PagoResource::collection($this->pagos)),
            'tipo_pedido' => $this->tipo_pedido,
            'estado' => $this->estado,
            'mesa' => $this->whenLoaded('mesa', fn() => [
                'id' => $this->mesa->id,
                'numero' => $this->mesa->numero,
            ]),
            'entrega' => $this->whenLoaded('entrega', fn() => $this->entrega ? [
                'id' => $this->entrega->id,
                'estado' => $this->entrega->estado,
                'direccion' => $this->entrega->direccion,
                'repartidor' => $this->entrega->repartidor?->nombre,
            ] : null),
            'cliente' => $this->whenLoaded('cliente', fn() => $this->cliente ? [
                'id' => $this->cliente->id,
                'nombre' => $this->cliente->nombreCompleto(),
            ] : null),
            'subtotal' => $this->subtotal,
            'descuento' => $this->descuento,
            'impuesto' => $this->impuesto,
            'total' => $this->total,
            'saldo_pendiente' => $this->saldoPendiente(),
            'fecha_pedido' => $this->fecha_pedido,
            'items' => $this->whenLoaded('detalle', fn() => $this->detalle->map(fn($linea) => [
                'id' => $linea->id,
                'producto_id' => $linea->producto_id,
                'producto_nombre' => $linea->producto->nombre,
                'cantidad' => $linea->cantidad,
                'precio_unitario' => $linea->precio_unitario,
                'subtotal' => $linea->subtotal,
                'observacion' => $linea->observacion,
            ])),
        ];
    }
}
