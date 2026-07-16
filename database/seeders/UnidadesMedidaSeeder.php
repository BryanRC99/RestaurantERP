<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnidadesMedidaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('unidades_medida')->insert([
            ['nombre' => 'Kilogramo', 'abreviatura' => 'kg', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Gramo', 'abreviatura' => 'g', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Litro', 'abreviatura' => 'l', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Mililitro', 'abreviatura' => 'ml', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Unidad', 'abreviatura' => 'u', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}