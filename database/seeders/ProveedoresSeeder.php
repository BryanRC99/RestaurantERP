<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProveedoresSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('proveedores')->insert([
            'empresa_id' => 1,
            'nombre' => 'Distribuidora La Favorita',
            'ruc' => '1790000000002',
            'telefono' => '022222224',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}