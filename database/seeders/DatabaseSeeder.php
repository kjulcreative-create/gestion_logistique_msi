<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            FournisseurSeeder::class,
            CategorieArticleSeeder::class,
            ArticleSeeder::class,
            CommandeAchatSeeder::class,
            MouvementStockSeeder::class,
            EquipementSeeder::class,
            VehiculeSeeder::class,
            MissionVehiculeSeeder::class,
        ]);
    }
}
