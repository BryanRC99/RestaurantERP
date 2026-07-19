<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PromocionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'tipo_promocion' => $this->tipo_promocion,
            'valor' => $this->valor,
            'porcentaje' => $this->porcentaje,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'vigente' => $this->vigente(),
            'productos' => $this->whenLoaded('productos', fn () => $this->productos->pluck('nombre')),
            'categorias' => $this->whenLoaded('categorias', fn () => $this->categorias->pluck('nombre')),
            'cupones' => $this->whenLoaded('cupones', fn () => $this->cupones->map(fn ($c) => [
                'id' => $c->id,
                'codigo' => $c->codigo,
                'usos_actuales' => $c->usos_actuales,
                'limite_uso' => $c->limite_uso,
                'activo' => $c->activo,
            ])),
        ];
    }
}