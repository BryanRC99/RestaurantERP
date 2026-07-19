<?php

namespace App\Actions;

use App\Models\Pago;
use App\Models\Pedido;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class RegistrarPagoAction
{
    public function ejecutar(
        Pedido $pedido,
        string $tipoPago,
        float $monto,
        int $usuarioId,
        ?string $referencia = null,
    ): Pago {
        return DB::transaction(function () use ($pedido, $tipoPago, $monto, $usuarioId, $referencia) {
            if ($monto <= 0) {
                throw new RuntimeException('El monto del pago debe ser mayor a cero.');
            }

            $saldoPendiente = $pedido->saldoPendiente();

            if ($monto > $saldoPendiente + 0.01) { // tolerancia por redondeo de centavos
                throw new RuntimeException("El monto excede el saldo pendiente (\${$saldoPendiente}).");
            }

            $pago = Pago::create([
                'pedido_id' => $pedido->id,
                'tipo_pago' => $tipoPago,
                'monto' => $monto,
                'referencia' => $referencia,
                'usuario_id' => $usuarioId,
                'fecha_pago' => now(),
            ]);

            if ($pedido->saldoPendiente() <= 0.01) {
                $pedido->update(['estado' => 'pagado']);
            }

            return $pago;
        });
    }
}