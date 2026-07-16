<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriasSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categorias')->insert([
            ['empresa_id' => 1, 'nombre' => 'Entradas', 'created_at' => now(), 'updated_at' => now()],
            ['empresa_id' => 1, 'nombre' => 'Platos Fuertes', 'created_at' => now(), 'updated_at' => now()],
            ['empresa_id' => 1, 'nombre' => 'Bebidas', 'created_at' => now(), 'updated_at' => now()],
            ['empresa_id' => 1, 'nombre' => 'Postres', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}