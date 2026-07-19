<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCuponRequest;
use App\Models\Cupon;

class CuponController extends Controller
{
    public function store(StoreCuponRequest $request)
    {
        $cupon = Cupon::create([
            'promocion_id' => $request->promocion_id,
            'codigo' => strtoupper($request->codigo),
            'limite_uso' => $request->limite_uso,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
        ]);

        return response()->json(['data' => $cupon]);
    }
}