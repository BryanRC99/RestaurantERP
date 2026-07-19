<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePromocionRequest;
use App\Http\Resources\PromocionResource;
use App\Models\Promocion;
use Illuminate\Http\Request;

class PromocionController extends Controller
{
    public function index(Request $request)
    {
        $promociones = Promocion::where('empresa_id', $request->user()->empresa_id)
            ->where('activo', true)
            ->with(['productos', 'categorias', 'cupones'])
            ->latest()
            ->get();

        return PromocionResource::collection($promociones);
    }

    public function store(StorePromocionRequest $request)
    {
        $promocion = Promocion::create([
            ...$request->only(['nombre', 'descripcion', 'tipo_promocion', 'valor', 'porcentaje', 'fecha_inicio', 'fecha_fin']),
            'empresa_id' => $request->user()->empresa_id,
        ]);

        if ($request->tipo_promocion === 'descuento_producto') {
            $promocion->productos()->sync($request->producto_ids);
        } else {
            $promocion->categorias()->sync($request->categoria_ids);
        }

        return new PromocionResource($promocion->fresh(['productos', 'categorias', 'cupones']));
    }
}