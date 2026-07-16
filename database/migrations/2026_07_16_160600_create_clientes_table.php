<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresa')->cascadeOnDelete();
            $table->string('nombre', 100);
            $table->string('apellido', 100)->nullable();
            $table->string('cedula', 20)->nullable()->unique();
            $table->string('telefono', 20)->nullable();
            $table->string('email', 150)->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};