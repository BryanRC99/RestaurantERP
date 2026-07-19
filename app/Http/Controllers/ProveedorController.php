<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProveedorResource;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    public function index(Request $request)
    {
        $proveedores = Proveedor::where('empresa_id', $request->user()->empresa_id)
            ->where('activo', true)
            ->orderBy('nombre')
            ->get();

        return ProveedorResource::collection($proveedores);
    }
}