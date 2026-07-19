<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCuponRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'promocion_id' => ['required', 'exists:promociones,id'],
            'codigo' => ['required', 'string', 'max:50', 'unique:cupones,codigo'],
            'limite_uso' => ['nullable', 'integer', 'min:1'],
            'fecha_inicio' => ['nullable', 'date'],
            'fecha_fin' => ['nullable', 'date', 'after_or_equal:fecha_inicio'],
        ];
    }
}