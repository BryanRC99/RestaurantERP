<?php

namespace App\Http\Controllers;

use App\Actions\RegistrarPagoAction;
use App\Http\Requests\StorePagoRequest;
use App\Http\Resources\PedidoResource;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PagoController extends Controller
{
    public function store(StorePagoRequest $request, Pedido $pedido, RegistrarPagoAction $action)
    {
        $sucursalId = $request->attributes->get('sucursal_activa')->sucursal_id;
        abort_unless($pedido->sucursal_id === $sucursalId, 403, 'Este pedido no pertenece a tu sucursal activa.');

        try {
            $action->ejecutar(
                pedido: $pedido,
                tipoPago: $request->tipo_pago,
                monto: (float) $request->monto,
                usuarioId: $request->user()->id,
                referencia: $request->referencia,
            );
        } catch (\RuntimeException $e) {
            throw ValidationException::withMessages(['monto' => [$e->getMessage()]]);
        }

        return new PedidoResource($pedido->fresh(['mesa', 'cliente', 'detalle.producto', 'pagos']));
    }
}