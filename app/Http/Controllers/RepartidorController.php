<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRepartidorRequest;
use App\Http\Resources\RepartidorResource;
use App\Models\Repartidor;

class RepartidorController extends Controller
{
    public function index()
    {
        return RepartidorResource::collection(
            Repartidor::where('activo', true)->orderBy('nombre')->get()
        );
    }

    public function store(StoreRepartidorRequest $request)
    {
        $repartidor = Repartidor::create($request->validated());

        return new RepartidorResource($repartidor);
    }
}