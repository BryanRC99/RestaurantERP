<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuario_sucursal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('sucursal_id')->constrained('sucursales')->cascadeOnDelete();
            // Rol que tiene ese usuario EN ESA sucursal (puede variar entre sucursales).
            $table->foreignId('rol_id')->constrained('roles');
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->unique(['user_id', 'sucursal_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuario_sucursal');
    }
};