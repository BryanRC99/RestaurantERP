<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detalle_compra', function (Blueprint $table) {
            $table->id();
            $table->foreignId('compra_id')->constrained('compras')->cascadeOnDelete();
            $table->foreignId('ingrediente_id')->constrained('ingredientes');
            $table->decimal('cantidad', 10, 3);
            // Unidad en la que se compro (puede ser distinta a la unidad base
            // del ingrediente, ej: se compra por "caja" o "saco").
            $table->foreignId('unidad_medida_id')->constrained('unidades_medida');
            $table->decimal('factor_conversion', 10, 4)->default(1)
                ->comment('Unidades base que representa 1 unidad comprada');
            $table->decimal('precio_unitario', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detalle_compra');
    }
};