<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('empresa_id')->nullable()->after('id')
                ->constrained('empresa')->nullOnDelete();
            $table->foreignId('empleado_id')->nullable()->after('empresa_id')
                ->constrained('empleados')->nullOnDelete();
            $table->string('username', 100)->nullable()->unique()->after('name');
            $table->timestamp('ultimo_login')->nullable()->after('password');
            $table->boolean('activo')->default(true)->after('ultimo_login');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('empresa_id');
            $table->dropConstrainedForeignId('empleado_id');
            $table->dropColumn(['username', 'ultimo_login', 'activo']);
        });
    }
};