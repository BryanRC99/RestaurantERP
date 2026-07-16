<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sucursal_id')->constrained('sucursales')->cascadeOnDelete();
            $table->foreignId('ingrediente_id')->constrained('ingredientes')->cascadeOnDelete();
            $table->decimal('stock_actual', 10, 3)->default(0);
            $table->decimal('stock_minimo', 10, 3)->default(0);
            $table->decimal('stock_maximo', 10, 3)->nullable();
            $table->timestamps();

            $table->unique(['sucursal_id', 'ingrediente_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventario');
    }
};