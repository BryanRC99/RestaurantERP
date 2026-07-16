<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recetas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained('productos')->cascadeOnDelete();
            $table->foreignId('ingrediente_id')->constrained('ingredientes')->cascadeOnDelete();
            $table->decimal('cantidad', 10, 3);
            $table->foreignId('unidad_medida_id')->constrained('unidades_medida');
            // Cuantas unidades base del ingrediente (ingredientes.unidad_medida_id)
            // equivale 1 unidad de esta receta. Ej: receta en gramos, ingrediente
            // controlado en kg => factor_conversion = 0.001
            $table->decimal('factor_conversion', 10, 4)->default(1);
            $table->timestamps();

            $table->unique(['producto_id', 'ingrediente_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recetas');
    }
};