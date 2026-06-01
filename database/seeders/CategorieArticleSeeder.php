<?php

namespace Database\Seeders;

use App\Models\CategorieArticle;
use Illuminate\Database\Seeder;

class CategorieArticleSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['nom' => 'Consommables médicaux',      'description' => 'Gants, seringues, compresses, préservatifs et autres consommables de santé'],
            ['nom' => 'Médicaments et intrants',    'description' => 'Médicaments essentiels, contraceptifs et intrants sanitaires'],
            ['nom' => 'Fournitures de bureau',      'description' => 'Papeterie, cartouches, stylos, classeurs et fournitures administratives'],
            ['nom' => 'Matériel informatique',      'description' => 'Ordinateurs, imprimantes, accessoires et périphériques informatiques'],
            ['nom' => 'Produits d\'entretien',      'description' => 'Produits de nettoyage, désinfectants et hygiène des locaux'],
            ['nom' => 'Équipements de bureau',      'description' => 'Mobilier, climatiseurs, ventilateurs et équipements de bureau'],
            ['nom' => 'Carburant et lubrifiants',   'description' => 'Essence, diesel, huiles moteur et produits d\'entretien véhicule'],
            ['nom' => 'Communication',              'description' => 'Crédit téléphonique, internet, imprimés et matériels de communication'],
            ['nom' => 'Matériel médical',           'description' => 'Équipements médicaux réutilisables (tensiomètres, balances, etc.)'],
            ['nom' => 'Produits alimentaires',      'description' => 'Eau potable, boissons et produits alimentaires pour ateliers et formations'],
        ];

        foreach ($categories as $cat) {
            CategorieArticle::firstOrCreate(['nom' => $cat['nom']], $cat);
        }
    }
}
