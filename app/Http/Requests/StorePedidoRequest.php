<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePedidoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tipo_pedido' => ['required', 'in:salon,para_llevar,delivery'],
            'cliente_id' => ['nullable', 'exists:clientes,id'],
            'mesa_id' => ['nullable', 'exists:mesas,id', 'required_if:tipo_pedido,salon'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.producto_id' => ['required', 'exists:productos,id'],
            'items.*.cantidad' => ['required', 'integer', 'min:1'],
            'items.*.observacion' => ['nullable', 'string', 'max:255'],
            'direccion_delivery' => ['required_if:tipo_pedido,delivery', 'nullable', 'string', 'max:255'],
            
            // Regla añadida para el código del cupón
            'cupon_codigo' => ['nullable', 'string', 'max:50'],
        ];
    }
}