<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePagoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tipo_pago' => ['required', 'in:efectivo,tarjeta,transferencia,mixto'],
            'monto' => ['required', 'numeric', 'min:0.01'],
            'referencia' => ['nullable', 'string', 'max:100'],
        ];
    }
}