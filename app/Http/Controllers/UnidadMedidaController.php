<?php

namespace App\Http\Controllers;

use App\Http\Resources\UnidadMedidaResource;
use App\Models\UnidadMedida;

class UnidadMedidaController extends Controller
{
    public function index()
    {
        return UnidadMedidaResource::collection(
            UnidadMedida::where('activo', true)->orderBy('nombre')->get()
        );
    }
}