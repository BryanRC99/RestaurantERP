<?php

namespace App\Http\Controllers;

use App\Http\Resources\MesaResource;
use App\Models\Mesa;
use Illuminate\Http\Request;

class MesaController extends Controller
{
    public function index(Request $request)
    {
        $sucursalId = $request->attributes->get('sucursal_activa')->sucursal_id;

        $mesas = Mesa::where('sucursal_id', $sucursalId)
            ->where('activo', true)
            ->orderBy('numero')
            ->get();

        return MesaResource::collection($mesas);
    }
}