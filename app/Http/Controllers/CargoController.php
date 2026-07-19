<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCargoRequest;
use App\Http\Resources\CargoResource;
use App\Models\Cargo;
use Illuminate\Http\Request;

class CargoController extends Controller
{
    public function index(Request $request)
    {
        $cargos = Cargo::where('empresa_id', $request->user()->empresa_id)
            ->where('activo', true)
            ->orderBy('nombre')
            ->get();

        return CargoResource::collection($cargos);
    }

    public function store(StoreCargoRequest $request)
    {
        $cargo = Cargo::create([
            ...$request->validated(),
            'empresa_id' => $request->user()->empresa_id,
        ]);

        return new CargoResource($cargo);
    }
}