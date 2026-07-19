<?php

namespace App\Http\Controllers;

use App\Models\UsuarioSucursal;
use Illuminate\Http\Request;

class SucursalActivaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'sucursal_id' => ['required', 'integer'],
        ]);

        $acceso = UsuarioSucursal::where('user_id', $request->user()->id)
            ->where('sucursal_id', $request->sucursal_id)
            ->where('activo', true)
            ->with('sucursal', 'rol')
            ->first();

        if (! $acceso) {
            return response()->json([
                'message' => 'No tienes acceso a esa sucursal.',
            ], 403);
        }

        $request->session()->put('sucursal_activa_id', $acceso->sucursal_id);

        return response()->json(['sucursal_activa' => $acceso]);
    }
}