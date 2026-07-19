<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MarcarAsistenciaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'empleado_sucursal_id' => ['required', 'exists:empleado_sucursal,id'],
        ];
    }
}