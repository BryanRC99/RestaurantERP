<?php

namespace App\Actions;

use App\Models\Asistencia;
use App\Models\EmpleadoSucursal;
use RuntimeException;

class RegistrarAsistenciaAction
{
    public function marcarEntrada(int $empleadoSucursalId): Asistencia
    {
        $yaMarcado = Asistencia::where('empleado_sucursal_id', $empleadoSucursalId)
            ->whereDate('fecha', now()->toDateString())
            ->exists();

        if ($yaMarcado) {
            throw new RuntimeException('Ya se registró la entrada de hoy para este empleado.');
        }

        return Asistencia::create([
            'empleado_sucursal_id' => $empleadoSucursalId,
            'fecha' => now()->toDateString(),
            'hora_entrada' => now()->format('H:i:s'),
            'estado' => 'presente',
        ]);
    }

    public function marcarSalida(int $empleadoSucursalId): Asistencia
    {
        $asistencia = Asistencia::where('empleado_sucursal_id', $empleadoSucursalId)
            ->whereDate('fecha', now()->toDateString())
            ->whereNull('hora_salida')
            ->first();

        if (! $asistencia) {
            throw new RuntimeException('No hay una entrada abierta hoy para este empleado.');
        }

        $asistencia->update(['hora_salida' => now()->format('H:i:s')]);

        return $asistencia;
    }
}