<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductoResource;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $sucursalId = $request->attributes->get('sucursal_activa')->sucursal_id;

        $productos = Producto::where('empresa_id', $request->user()->empresa_id)
            ->where('activo', true)
            ->when($request->filled('categoria_id'), fn ($q) => $q->where('categoria_id', $request->categoria_id))
            ->with(['productoSucursal' => fn ($q) => $q->where('sucursal_id', $sucursalId)])
            ->orderBy('nombre')
            ->get()
            ->filter(fn (Producto $producto) => $producto->productoSucursal->isNotEmpty())
            ->values();

        return ProductoResource::collection($productos);
    }
}