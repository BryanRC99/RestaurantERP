<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pedido_promocion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->constrained('pedidos')->cascadeOnDelete();
            $table->foreignId('promocion_id')->constrained('promociones');
            // Codigo de cupon especifico usado (si la promocion se aplico via cupon).
            $table->foreignId('cupon_id')->nullable()->constrained('cupones')->nullOnDelete();
            $table->decimal('descuento_aplicado', 10, 2);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedido_promocion');
    }
};