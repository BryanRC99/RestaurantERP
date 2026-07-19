<?php

namespace App\Http\Controllers;

use App\Http\Resources\IngredienteResource;
use App\Models\Ingrediente;
use Illuminate\Http\Request;

class IngredienteController extends Controller
{
    public function index(Request $request)
    {
        $ingredientes = Ingrediente::where('empresa_id', $request->user()->empresa_id)
            ->where('activo', true)
            ->with('unidadMedida')
            ->orderBy('nombre')
            ->get();

        return IngredienteResource::collection($ingredientes);
    }
}