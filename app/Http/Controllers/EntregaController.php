<?php

namespace App\Http\Controllers;

use App\Http\Requests\AsignarRepartidorRequest;
use App\Http\Resources\EntregaResource;
use App\Models\Entrega;
use Illuminate\Http\Request;

class EntregaController extends Controller
{
    public function index(Request $request)
    {
        $sucursalId = $request->attributes->get('sucursal_activa')->sucursal_id;

        $entregas = Entrega::whereHas('pedido', fn ($q) => $q->where('sucursal_id', $sucursalId))
            ->when($request->filled('estado'), fn ($q) => $q->where('estado', $request->estado))
            ->with(['pedido.cliente', 'repartidor'])
            ->latest('created_at')
            ->get();

        return EntregaResource::collection($entregas);
    }

    public function asignar(AsignarRepartidorRequest $request, Entrega $entrega)
    {
        $this->autorizarSucursal($request, $entrega);

        $entrega->update([
            'repartidor_id' => $request->repartidor_id,
            'estado' => 'asignado',
            'hora_asignacion' => now(),
        ]);

        return new EntregaResource($entrega->fresh('repartidor', 'pedido.cliente'));
    }

    public function entregar(Request $request, Entrega $entrega)
    {
        $this->autorizarSucursal($request, $entrega);

        abort_if($entrega->estado !== 'asignado', 422, 'La entrega debe estar asignada a un repartidor antes de marcarla como entregada.');

        $entrega->update([
            'estado' => 'entregado',
            'hora_entrega' => now(),
        ]);

        $entrega->pedido->update(['estado' => 'entregado']);

        return new EntregaResource($entrega->fresh('repartidor', 'pedido.cliente'));
    }

    private function autorizarSucursal(Request $request, Entrega $entrega): void
    {
        $sucursalId = $request->attributes->get('sucursal_activa')->sucursal_id;

        abort_unless($entrega->pedido->sucursal_id === $sucursalId, 403, 'Esta entrega no pertenece a tu sucursal activa.');
    }
}