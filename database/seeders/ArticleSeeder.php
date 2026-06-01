<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\CategorieArticle;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $catIds = CategorieArticle::pluck('id', 'nom');

        $articles = [
            // Consommables médicaux
            ['code'=>'ART001','designation'=>'Gants d\'examen latex (boîte 100)','unite'=>'boîte','quantite_stock'=>245,'seuil_alerte'=>50,'prix_unitaire'=>3500,'localisation'=>'Magasin Central - Étagère A1','categorie_id'=>$catIds['Consommables médicaux'] ?? 1],
            ['code'=>'ART002','designation'=>'Seringues 5ml (boîte 100)','unite'=>'boîte','quantite_stock'=>180,'seuil_alerte'=>40,'prix_unitaire'=>4200,'localisation'=>'Magasin Central - Étagère A2','categorie_id'=>$catIds['Consommables médicaux'] ?? 1],
            ['code'=>'ART003','designation'=>'Préservatifs masculins PRUDENCE (carton 1000)','unite'=>'carton','quantite_stock'=>12,'seuil_alerte'=>20,'prix_unitaire'=>45000,'localisation'=>'Magasin Central - Étagère A3','categorie_id'=>$catIds['Consommables médicaux'] ?? 1],
            ['code'=>'ART004','designation'=>'Compresses stériles 10x10 (boîte 100)','unite'=>'boîte','quantite_stock'=>95,'seuil_alerte'=>20,'prix_unitaire'=>2800,'localisation'=>'Magasin Central - Étagère A4','categorie_id'=>$catIds['Consommables médicaux'] ?? 1],
            // Médicaments et intrants
            ['code'=>'ART005','designation'=>'Implant Jadelle (lot 10)','unite'=>'lot','quantite_stock'=>8,'seuil_alerte'=>15,'prix_unitaire'=>85000,'localisation'=>'Magasin froid - Étagère B1','categorie_id'=>$catIds['Médicaments et intrants'] ?? 2],
            ['code'=>'ART006','designation'=>'DIU Cuivre T380A (boîte 5)','unite'=>'boîte','quantite_stock'=>45,'seuil_alerte'=>10,'prix_unitaire'=>12500,'localisation'=>'Magasin froid - Étagère B2','categorie_id'=>$catIds['Médicaments et intrants'] ?? 2],
            ['code'=>'ART007','designation'=>'Misoprostol 200mcg (boîte 100cp)','unite'=>'boîte','quantite_stock'=>22,'seuil_alerte'=>8,'prix_unitaire'=>18000,'localisation'=>'Magasin froid - Étagère B3','categorie_id'=>$catIds['Médicaments et intrants'] ?? 2],
            // Fournitures de bureau
            ['code'=>'ART008','designation'=>'Rame de papier A4 80g (500 feuilles)','unite'=>'rame','quantite_stock'=>340,'seuil_alerte'=>60,'prix_unitaire'=>2500,'localisation'=>'Magasin Bureau - Étagère C1','categorie_id'=>$catIds['Fournitures de bureau'] ?? 3],
            ['code'=>'ART009','designation'=>'Cartouche encre HP LaserJet noir','unite'=>'pièce','quantite_stock'=>18,'seuil_alerte'=>5,'prix_unitaire'=>28000,'localisation'=>'Magasin Bureau - Étagère C2','categorie_id'=>$catIds['Fournitures de bureau'] ?? 3],
            ['code'=>'ART010','designation'=>'Stylos bille bleus (boîte 50)','unite'=>'boîte','quantite_stock'=>35,'seuil_alerte'=>10,'prix_unitaire'=>3500,'localisation'=>'Magasin Bureau - Étagère C3','categorie_id'=>$catIds['Fournitures de bureau'] ?? 3],
            ['code'=>'ART011','designation'=>'Classeurs A4 dos 80mm','unite'=>'pièce','quantite_stock'=>120,'seuil_alerte'=>25,'prix_unitaire'=>1500,'localisation'=>'Magasin Bureau - Étagère C4','categorie_id'=>$catIds['Fournitures de bureau'] ?? 3],
            ['code'=>'ART012','designation'=>'Chemises à rabat kraft (paquet 100)','unite'=>'paquet','quantite_stock'=>28,'seuil_alerte'=>10,'prix_unitaire'=>4500,'localisation'=>'Magasin Bureau - Étagère C5','categorie_id'=>$catIds['Fournitures de bureau'] ?? 3],
            // Matériel informatique
            ['code'=>'ART013','designation'=>'Clé USB 32Go Kingston','unite'=>'pièce','quantite_stock'=>4,'seuil_alerte'=>5,'prix_unitaire'=>8500,'localisation'=>'Salle Informatique','categorie_id'=>$catIds['Matériel informatique'] ?? 4],
            ['code'=>'ART014','designation'=>'Souris optique USB Logitech','unite'=>'pièce','quantite_stock'=>12,'seuil_alerte'=>5,'prix_unitaire'=>7000,'localisation'=>'Salle Informatique','categorie_id'=>$catIds['Matériel informatique'] ?? 4],
            // Produits d'entretien
            ['code'=>'ART015','designation'=>'Javel concentrée 5L','unite'=>'bidon','quantite_stock'=>38,'seuil_alerte'=>10,'prix_unitaire'=>2200,'localisation'=>'Magasin Entretien','categorie_id'=>$catIds["Produits d'entretien"] ?? 5],
            ['code'=>'ART016','designation'=>'Savon liquide désinfectant 5L','unite'=>'bidon','quantite_stock'=>22,'seuil_alerte'=>8,'prix_unitaire'=>4800,'localisation'=>'Magasin Entretien','categorie_id'=>$catIds["Produits d'entretien"] ?? 5],
            ['code'=>'ART017','designation'=>'Sacs poubelle (rouleau 25 sacs)','unite'=>'rouleau','quantite_stock'=>55,'seuil_alerte'=>15,'prix_unitaire'=>1200,'localisation'=>'Magasin Entretien','categorie_id'=>$catIds["Produits d'entretien"] ?? 5],
            // Carburant (suivi en litres)
            ['code'=>'ART018','designation'=>'Gasoil (diesel)','unite'=>'litre','quantite_stock'=>500,'seuil_alerte'=>200,'prix_unitaire'=>700,'localisation'=>'Citerne principale','categorie_id'=>$catIds['Carburant et lubrifiants'] ?? 7],
            ['code'=>'ART019','designation'=>'Huile moteur 15W40 (bidon 5L)','unite'=>'bidon','quantite_stock'=>15,'seuil_alerte'=>5,'prix_unitaire'=>12000,'localisation'=>'Atelier mécanique','categorie_id'=>$catIds['Carburant et lubrifiants'] ?? 7],
        ];

        foreach ($articles as $art) {
            Article::firstOrCreate(['code' => $art['code']], $art);
        }
    }
}
