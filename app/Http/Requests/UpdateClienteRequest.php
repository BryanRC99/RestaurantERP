<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:100'],
            'apellido' => ['nullable', 'string', 'max:100'],
            'cedula' => [
                'nullable', 'string', 'max:20',
                Rule::unique('clientes', 'cedula')->ignore($this->route('cliente')),
            ],
            'telefono' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:150'],
            'activo' => ['boolean'],
        ];
    }
}