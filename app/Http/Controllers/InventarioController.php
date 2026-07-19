<?php

namespace App\Http\Controllers;

use App\Http\Resources\InventarioResource;
use App\Models\Inventario;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    public function index(Request $request)
    {
        $sucursalId = $request->attributes->get('sucursal_activa')->sucursal_id;

        $inventario = Inventario::where('sucursal_id', $sucursalId)
            ->with('ingrediente.unidadMedida')
            ->get()
            ->sortBy('ingrediente.nombre')
            ->values();

        return InventarioResource::collection($inventario);
    }
}