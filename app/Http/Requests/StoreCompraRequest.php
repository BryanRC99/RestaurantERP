<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompraRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'proveedor_id' => ['required', 'exists:proveedores,id'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.ingrediente_id' => ['required', 'exists:ingredientes,id'],
            'items.*.cantidad' => ['required', 'numeric', 'min:0.001'],
            'items.*.unidad_medida_id' => ['required', 'exists:unidades_medida,id'],
            'items.*.factor_conversion' => ['required', 'numeric', 'min:0.0001'],
            'items.*.precio_unitario' => ['required', 'numeric', 'min:0'],
        ];
    }
}