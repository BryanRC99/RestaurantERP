<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmpresaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('empresa')->insert([
            'nombre' => 'Mi Restaurante',
            'razon_social' => 'Mi Restaurante S.A.',
            'ruc' => '1790000000001',
            'telefono' => '022222222',
            'email' => 'contacto@mirestaurante.com',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}