<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Http\Resources\ClienteResource;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $clientes = Cliente::where('empresa_id', $request->user()->empresa_id)
            ->when($request->filled('buscar'), function ($q) use ($request) {
                $termino = $request->buscar;
                $q->where(function ($sub) use ($termino) {
                    $sub->where('nombre', 'like', "%{$termino}%")
                        ->orWhere('apellido', 'like', "%{$termino}%")
                        ->orWhere('cedula', 'like', "%{$termino}%");
                });
            })
            ->orderBy('nombre')
            ->paginate(20);

        return ClienteResource::collection($clientes);
    }

    public function show(Request $request, Cliente $cliente)
    {
        $this->autorizarEmpresa($request, $cliente);

        return new ClienteResource($cliente);
    }

    public function store(StoreClienteRequest $request)
    {
        $cliente = Cliente::create([
            ...$request->validated(),
            'empresa_id' => $request->user()->empresa_id,
        ]);

        return new ClienteResource($cliente);
    }

    public function update(UpdateClienteRequest $request, Cliente $cliente)
    {
        $this->autorizarEmpresa($request, $cliente);

        $cliente->update($request->validated());

        return new ClienteResource($cliente);
    }

    public function destroy(Request $request, Cliente $cliente)
    {
        $this->autorizarEmpresa($request, $cliente);

        // Baja logica: un cliente con pedidos historicos no se puede borrar
        // fisicamente sin romper la trazabilidad de pedidos/facturas pasadas.
        $cliente->update(['activo' => false]);

        return response()->noContent();
    }

    private function autorizarEmpresa(Request $request, Cliente $cliente): void
    {
        abort_unless($cliente->empresa_id === $request->user()->empresa_id, 403);
    }
}