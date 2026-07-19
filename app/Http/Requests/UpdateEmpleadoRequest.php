<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmpleadoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cedula' => [
                'required', 'string', 'max:20',
                Rule::unique('empleados', 'cedula')->ignore($this->route('empleado')),
            ],
            'nombre' => ['required', 'string', 'max:100'],
            'apellido' => ['required', 'string', 'max:100'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'direccion' => ['nullable', 'string'],
            'fecha_nacimiento' => ['nullable', 'date'],
            'email' => ['nullable', 'email', 'max:150'],
            'activo' => ['boolean'],
        ];
    }
}