<?php

namespace App\Http\Controllers;

use App\Actions\RegistrarCompraAction;
use App\Http\Requests\StoreCompraRequest;
use App\Http\Resources\CompraResource;
use App\Models\Compra;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CompraController extends Controller
{
    public function index(Request $request)
    {
        $sucursalId = $request->attributes->get('sucursal_activa')->sucursal_id;

        $compras = Compra::where('sucursal_id', $sucursalId)
            ->with(['proveedor', 'detalle.ingrediente'])
            ->latest('fecha_compra')
            ->paginate(20);

        return CompraResource::collection($compras);
    }

    public function store(StoreCompraRequest $request, RegistrarCompraAction $action)
    {
        $sucursalId = $request->attributes->get('sucursal_activa')->sucursal_id;

        try {
            $compra = $action->ejecutar(
                sucursalId: $sucursalId,
                proveedorId: $request->proveedor_id,
                usuarioId: $request->user()->id,
                items: $request->items,
            );
        } catch (\InvalidArgumentException $e) {
            throw ValidationException::withMessages(['items' => [$e->getMessage()]]);
        }

        return new CompraResource($compra);
    }
}