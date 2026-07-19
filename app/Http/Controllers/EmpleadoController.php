<?php

namespace App\Http\Controllers;

use App\Actions\RegistrarEmpleadoAction;
use App\Http\Requests\StoreEmpleadoRequest;
use App\Http\Requests\UpdateEmpleadoRequest;
use App\Http\Resources\EmpleadoResource;
use App\Models\Empleado;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    public function index(Request $request)
    {
        $sucursalId = $request->attributes->get('sucursal_activa')->sucursal_id;

        $empleados = Empleado::whereHas('empleadoSucursal', function ($q) use ($sucursalId) {
                $q->where('sucursal_id', $sucursalId)->where('activo', true);
            })
            ->with(['empleadoSucursal' => fn ($q) => $q->where('activo', true)->with('cargo', 'sucursal')])
            ->orderBy('nombre')
            ->get();

        return EmpleadoResource::collection($empleados);
    }

    public function show(Empleado $empleado)
    {
        return new EmpleadoResource(
            $empleado->load('empleadoSucursal.cargo', 'empleadoSucursal.sucursal')
        );
    }

    public function store(StoreEmpleadoRequest $request, RegistrarEmpleadoAction $action)
    {
        $empleado = $action->ejecutar(
            datosEmpleado: $request->only([
                'cedula', 'nombre', 'apellido', 'telefono', 'direccion', 'fecha_nacimiento', 'fecha_ingreso', 'email',
            ]),
            sucursalId: $request->sucursal_id,
            cargoId: $request->cargo_id,
            salario: (float) $request->salario,
        );

        return new EmpleadoResource($empleado);
    }

    public function update(UpdateEmpleadoRequest $request, Empleado $empleado)
    {
        $empleado->update($request->validated());

        return new EmpleadoResource($empleado->fresh('empleadoSucursal.cargo', 'empleadoSucursal.sucursal'));
    }
}