<?php

namespace App\Http\Controllers;

use App\Actions\RegistrarAsistenciaAction;
use App\Http\Requests\MarcarAsistenciaRequest;
use App\Models\Asistencia;
use App\Models\EmpleadoSucursal;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AsistenciaController extends Controller
{
    public function index(Request $request)
    {
        $sucursalId = $request->attributes->get('sucursal_activa')->sucursal_id;

        $asignaciones = EmpleadoSucursal::where('sucursal_id', $sucursalId)
            ->where('activo', true)
            ->with('empleado', 'cargo')
            ->get();

        $asistenciasHoy = Asistencia::whereIn('empleado_sucursal_id', $asignaciones->pluck('id'))
            ->whereDate('fecha', now()->toDateString())
            ->get()
            ->keyBy('empleado_sucursal_id');

        return response()->json([
            'data' => $asignaciones->map(function (EmpleadoSucursal $asignacion) use ($asistenciasHoy) {
                $asistencia = $asistenciasHoy->get($asignacion->id);

                return [
                    'empleado_sucursal_id' => $asignacion->id,
                    'empleado_nombre' => $asignacion->empleado->nombreCompleto(),
                    'cargo' => $asignacion->cargo->nombre,
                    'hora_entrada' => $asistencia?->hora_entrada,
                    'hora_salida' => $asistencia?->hora_salida,
                    'estado' => $asistencia?->estado ?? 'sin_marcar',
                ];
            }),
        ]);
    }

    public function marcarEntrada(MarcarAsistenciaRequest $request, RegistrarAsistenciaAction $action)
    {
        try {
            $action->marcarEntrada($request->empleado_sucursal_id);
        } catch (\RuntimeException $e) {
            throw ValidationException::withMessages(['empleado_sucursal_id' => [$e->getMessage()]]);
        }

        return response()->noContent();
    }

    public function marcarSalida(MarcarAsistenciaRequest $request, RegistrarAsistenciaAction $action)
    {
        try {
            $action->marcarSalida($request->empleado_sucursal_id);
        } catch (\RuntimeException $e) {
            throw ValidationException::withMessages(['empleado_sucursal_id' => [$e->getMessage()]]);
        }

        return response()->noContent();
    }
}