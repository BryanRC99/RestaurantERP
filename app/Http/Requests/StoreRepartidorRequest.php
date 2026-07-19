<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRepartidorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:100'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'empleado_id' => ['nullable', 'exists:empleados,id'],
        ];
    }
}