<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
      $this->call([
        EmpresaSeeder::class,
        RolesSeeder::class,
        SucursalSeeder::class,
        CargosSeeder::class,
        CategoriasSeeder::class,
        ProductosSeeder::class,
        UnidadesMedidaSeeder::class,
        IngredientesSeeder::class,
        ProductoSucursalSeeder::class,
        RecetasSeeder::class,
        ProveedoresSeeder::class,
        InventarioSeeder::class,
        MesasSeeder::class,
        RepartidoresSeeder::class,
        PromocionesSeeder::class,
        CuponesSeeder::class,
      ]);
    }
}
