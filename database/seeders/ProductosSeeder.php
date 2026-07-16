<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductosSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('productos')->insert([
            ['empresa_id' => 1, 'categoria_id' => 2, 'nombre' => 'Seco de Pollo', 'tiempo_preparacion' => 20, 'created_at' => now(), 'updated_at' => now()],
            ['empresa_id' => 1, 'categoria_id' => 2, 'nombre' => 'Churrasco', 'tiempo_preparacion' => 25, 'created_at' => now(), 'updated_at' => now()],
            ['empresa_id' => 1, 'categoria_id' => 3, 'nombre' => 'Jugo Natural', 'tiempo_preparacion' => 5, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}