<?php

namespace Database\Seeders;

use App\Models\CommandeAchat;
use App\Models\LigneCommande;
use App\Models\Fournisseur;
use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommandeAchatSeeder extends Seeder
{
    public function run(): void
    {
        $gestionnaire = User::where('role', 'gestionnaire_achats')->first();
        $admin        = User::where('role', 'admin')->first();

        $commandes = [
            [
                'reference'            => 'BC-2026-001',
                'fournisseur_code'     => 'F001',
                'user_id'              => $gestionnaire->id,
                'date_commande'        => '2026-01-15',
                'date_livraison_prevue'=> '2026-02-01',
                'date_livraison_reelle'=> '2026-02-03',
                'statut'               => 'livree',
                'notes'                => 'Renouvellement parc informatique bureau Ouagadougou',
                'lignes' => [
                    ['article_code'=>'ART013','quantite'=>10,'prix_unitaire'=>8500],
                    ['article_code'=>'ART014','quantite'=>15,'prix_unitaire'=>7000],
                ],
            ],
            [
                'reference'            => 'BC-2026-002',
                'fournisseur_code'     => 'F002',
                'user_id'              => $gestionnaire->id,
                'date_commande'        => '2026-02-10',
                'date_livraison_prevue'=> '2026-02-20',
                'date_livraison_reelle'=> '2026-02-18',
                'statut'               => 'livree',
                'notes'                => 'Fournitures de bureau trimestriel Q1 2026',
                'lignes' => [
                    ['article_code'=>'ART008','quantite'=>200,'prix_unitaire'=>2500],
                    ['article_code'=>'ART010','quantite'=>20,'prix_unitaire'=>3500],
                    ['article_code'=>'ART011','quantite'=>50,'prix_unitaire'=>1500],
                    ['article_code'=>'ART012','quantite'=>15,'prix_unitaire'=>4500],
                ],
            ],
            [
                'reference'            => 'BC-2026-003',
                'fournisseur_code'     => 'F011',
                'user_id'              => $gestionnaire->id,
                'date_commande'        => '2026-03-05',
                'date_livraison_prevue'=> '2026-03-20',
                'date_livraison_reelle'=> '2026-03-22',
                'statut'               => 'livree',
                'notes'                => 'Réapprovisionnement consommables médicaux - sites de Ouaga',
                'lignes' => [
                    ['article_code'=>'ART001','quantite'=>100,'prix_unitaire'=>3500],
                    ['article_code'=>'ART002','quantite'=>80,'prix_unitaire'=>4200],
                    ['article_code'=>'ART004','quantite'=>50,'prix_unitaire'=>2800],
                ],
            ],
            [
                'reference'            => 'BC-2026-004',
                'fournisseur_code'     => 'F003',
                'user_id'              => $gestionnaire->id,
                'date_commande'        => '2026-04-01',
                'date_livraison_prevue'=> '2026-04-15',
                'date_livraison_reelle'=> null,
                'statut'               => 'en_cours',
                'notes'                => 'Commande intrants SR trimestre 2 - urgente',
                'lignes' => [
                    ['article_code'=>'ART005','quantite'=>20,'prix_unitaire'=>85000],
                    ['article_code'=>'ART006','quantite'=>30,'prix_unitaire'=>12500],
                    ['article_code'=>'ART007','quantite'=>15,'prix_unitaire'=>18000],
                ],
            ],
            [
                'reference'            => 'BC-2026-005',
                'fournisseur_code'     => 'F002',
                'user_id'              => $gestionnaire->id,
                'date_commande'        => '2026-05-10',
                'date_livraison_prevue'=> '2026-05-25',
                'date_livraison_reelle'=> null,
                'statut'               => 'validee',
                'notes'                => 'Cartouches imprimantes réseau + toners',
                'lignes' => [
                    ['article_code'=>'ART009','quantite'=>12,'prix_unitaire'=>28000],
                ],
            ],
            [
                'reference'            => 'BC-2026-006',
                'fournisseur_code'     => 'F009',
                'user_id'              => $admin->id,
                'date_commande'        => '2026-05-20',
                'date_livraison_prevue'=> '2026-06-05',
                'date_livraison_reelle'=> null,
                'statut'               => 'brouillon',
                'notes'                => 'Impression rapport annuel 2025 et supports formation',
                'lignes' => [],
            ],
        ];

        foreach ($commandes as $data) {
            $fournisseur = Fournisseur::where('code', $data['fournisseur_code'])->first();
            if (! $fournisseur) {
                continue;
            }

            $montant = collect($data['lignes'])->sum(fn($l) => $l['quantite'] * $l['prix_unitaire']);

            $commande = CommandeAchat::firstOrCreate(
                ['reference' => $data['reference']],
                [
                    'fournisseur_id'        => $fournisseur->id,
                    'user_id'               => $data['user_id'],
                    'date_commande'         => $data['date_commande'],
                    'date_livraison_prevue' => $data['date_livraison_prevue'],
                    'date_livraison_reelle' => $data['date_livraison_reelle'],
                    'statut'                => $data['statut'],
                    'montant_total'         => $montant,
                    'notes'                 => $data['notes'],
                ]
            );

            foreach ($data['lignes'] as $ligne) {
                $article = Article::where('code', $ligne['article_code'])->first();
                if (! $article) {
                    continue;
                }
                LigneCommande::firstOrCreate(
                    ['commande_id' => $commande->id, 'article_id' => $article->id],
                    [
                        'quantite'       => $ligne['quantite'],
                        'quantite_recue' => $data['statut'] === 'livree' ? $ligne['quantite'] : 0,
                        'prix_unitaire'  => $ligne['prix_unitaire'],
                        'montant_ligne'  => $ligne['quantite'] * $ligne['prix_unitaire'],
                    ]
                );
            }
        }
    }
}
