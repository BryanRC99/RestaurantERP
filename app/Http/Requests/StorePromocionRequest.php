<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePromocionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:150'],
            'descripcion' => ['nullable', 'string'],
            'tipo_promocion' => ['required', 'in:descuento_producto,descuento_categoria'],
            'valor' => ['required', 'numeric', 'min:0'],
            'porcentaje' => ['required', 'boolean'],
            'fecha_inicio' => ['required', 'date'],
            'fecha_fin' => ['required', 'date', 'after_or_equal:fecha_inicio'],
            'producto_ids' => ['required_if:tipo_promocion,descuento_producto', 'array'],
            'producto_ids.*' => ['exists:productos,id'],
            'categoria_ids' => ['required_if:tipo_promocion,descuento_categoria', 'array'],
            'categoria_ids.*' => ['exists:categorias,id'],
        ];
    }
}