<?php

namespace App\Actions;

use App\Models\Empleado;
use App\Models\EmpleadoSucursal;
use Illuminate\Support\Facades\DB;

class RegistrarEmpleadoAction
{
    public function ejecutar(array $datosEmpleado, int $sucursalId, int $cargoId, float $salario): Empleado
    {
        return DB::transaction(function () use ($datosEmpleado, $sucursalId, $cargoId, $salario) {
            $empleado = Empleado::create($datosEmpleado);

            EmpleadoSucursal::create([
                'empleado_id' => $empleado->id,
                'sucursal_id' => $sucursalId,
                'cargo_id' => $cargoId,
                'salario' => $salario,
                'fecha_inicio' => now()->toDateString(),
            ]);

            return $empleado->fresh('empleadoSucursal.cargo', 'empleadoSucursal.sucursal');
        });
    }
}