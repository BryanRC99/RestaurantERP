<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::where('username', $request->username)
            ->orWhere('email', $request->username)
            ->first();

        if (! $user || ! $user->activo || ! Auth::validate([
            'id' => $user->id,
            'password' => $request->password,
        ])) {
            throw ValidationException::withMessages([
                'username' => ['Las credenciales no son validas.'],
            ]);
        }

        Auth::login($user);
        $request->session()->regenerate();

        $user->update(['ultimo_login' => now()]);

        return response()->json([
            'user' => $user,
            'sucursales' => $user->usuarioSucursal()
                ->with('sucursal', 'rol')
                ->where('activo', true)
                ->get(),
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->noContent();
    }

    public function me(Request $request)
    {
        return response()->json([
            'user' => $request->user(),
            'sucursales' => $request->user()->usuarioSucursal()
                ->with('sucursal', 'rol')
                ->where('activo', true)
                ->get(),
            'sucursal_activa_id' => $request->session()->get('sucursal_activa_id'),
        ]);
    }
}
