<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SucursalSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('sucursales')->insert([
            'empresa_id' => 1,
            'nombre' => 'Sucursal Matriz',
            'codigo' => 'SUC-001',
            'direccion' => 'Av. Principal y Secundaria',
            'telefono' => '022222223',
            'ciudad' => 'Quito',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}