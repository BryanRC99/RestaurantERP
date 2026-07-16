<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MesasSeeder extends Seeder
{
    public function run(): void
    {
        $mesas = [];
        for ($i = 1; $i <= 8; $i++) {
            $mesas[] = [
                'sucursal_id' => 1,
                'numero' => $i,
                'capacidad' => $i <= 4 ? 4 : 6,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('mesas')->insert($mesas);
    }
}