<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmpleadoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $asignacionActiva = $this->empleadoSucursal->firstWhere('activo', true);

        return [
            'id' => $this->id,
            'cedula' => $this->cedula,
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'nombre_completo' => $this->nombreCompleto(),
            'telefono' => $this->telefono,
            'email' => $this->email,
            'fecha_ingreso' => $this->fecha_ingreso,
            'activo' => $this->activo,
            'asignacion_actual' => $asignacionActiva ? [
                'id' => $asignacionActiva->id,
                'sucursal' => $asignacionActiva->sucursal->nombre,
                'cargo' => $asignacionActiva->cargo->nombre,
                'salario' => $asignacionActiva->salario,
            ] : null,
        ];
    }
}