<?php

namespace App\Http\Middleware;

use App\Models\UsuarioSucursal;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSucursalActiva
{
    public function handle(Request $request, Closure $next): Response
    {
        $sucursalId = $request->session()->get('sucursal_activa_id');

        if (! $sucursalId) {
            return response()->json([
                'message' => 'Debes seleccionar una sucursal activa.',
            ], 409);
        }

        $acceso = UsuarioSucursal::where('user_id', $request->user()->id)
            ->where('sucursal_id', $sucursalId)
            ->where('activo', true)
            ->with('rol', 'sucursal')
            ->first();

        if (! $acceso) {
            $request->session()->forget('sucursal_activa_id');

            return response()->json([
                'message' => 'Ya no tienes acceso a la sucursal seleccionada.',
            ], 403);
        }

        // Disponible en el resto del request via $request->attributes->get('sucursal_activa')
        $request->attributes->set('sucursal_activa', $acceso);

        return $next($request);
    }
}