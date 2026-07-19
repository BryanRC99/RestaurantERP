<?php

namespace App\Http\Controllers;

use App\Actions\RegistrarPedidoAction;
use App\Http\Requests\StorePedidoRequest;
use App\Http\Resources\PedidoResource;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PedidoController extends Controller
{
    public function index(Request $request)
    {
        $sucursalId = $request->attributes->get('sucursal_activa')->sucursal_id;

        $pedidos = Pedido::where('sucursal_id', $sucursalId)
            ->when($request->filled('estado'), fn ($q) => $q->where('estado', $request->estado))
            ->with(['mesa', 'cliente', 'detalle.producto'])
            ->latest('fecha_pedido')
            ->paginate(20);

        return PedidoResource::collection($pedidos);
    }

    public function show(Request $request, Pedido $pedido)
    {
        $this->autorizarSucursal($request, $pedido);

        return new PedidoResource($pedido->load(['mesa', 'cliente', 'detalle.producto', 'pagos']));
    }

    public function store(StorePedidoRequest $request, RegistrarPedidoAction $action)
    {
        $sucursalId = $request->attributes->get('sucursal_activa')->sucursal_id;

        try {
            $pedido = $action->ejecutar(
                sucursalId: $sucursalId,
                usuarioId: $request->user()->id,
                tipoPedido: $request->tipo_pedido,
                clienteId: $request->cliente_id,
                mesaId: $request->mesa_id,
                items: $request->items,
                direccionDelivery: $request->direccion_delivery,
                cuponCodigo: $request->cupon_codigo, // <- Enviamos el cupón mapeado desde el request
            );
        } catch (\InvalidArgumentException|\RuntimeException $e) {
            throw ValidationException::withMessages(['items' => [$e->getMessage()]]);
        }

        return new PedidoResource($pedido);
    }

    private function autorizarSucursal(Request $request, Pedido $pedido): void
    {
        $sucursalId = $request->attributes->get('sucursal_activa')->sucursal_id;

        abort_unless($pedido->sucursal_id === $sucursalId, 403, 'Este pedido no pertenece a tu sucursal activa.');
    }
}