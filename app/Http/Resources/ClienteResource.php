<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClienteResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'nombre_completo' => $this->nombreCompleto(),
            'cedula' => $this->cedula,
            'telefono' => $this->telefono,
            'email' => $this->email,
            'activo' => $this->activo,
        ];
    }
}