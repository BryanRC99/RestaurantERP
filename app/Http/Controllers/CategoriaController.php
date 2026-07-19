<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoriaResource;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index(Request $request)
    {
        $categorias = Categoria::where('empresa_id', $request->user()->empresa_id)
            ->where('activo', true)
            ->orderBy('nombre')
            ->get();

        return CategoriaResource::collection($categorias);
    }
}