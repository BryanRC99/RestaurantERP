<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmpleadoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cedula' => ['required', 'string', 'max:20', 'unique:empleados,cedula'],
            'nombre' => ['required', 'string', 'max:100'],
            'apellido' => ['required', 'string', 'max:100'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'direccion' => ['nullable', 'string'],
            'fecha_nacimiento' => ['nullable', 'date'],
            'fecha_ingreso' => ['required', 'date'],
            'email' => ['nullable', 'email', 'max:150'],
            // Datos de la primera asignacion (sucursal/cargo/salario), se resuelven
            // en el mismo request para no obligar a un segundo paso separado.
            'sucursal_id' => ['required', 'exists:sucursales,id'],
            'cargo_id' => ['required', 'exists:cargos,id'],
            'salario' => ['required', 'numeric', 'min:0'],
        ];
    }
}