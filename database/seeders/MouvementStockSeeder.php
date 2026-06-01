<?php

namespace Database\Seeders;

use App\Models\MouvementStock;
use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Seeder;

class MouvementStockSeeder extends Seeder
{
    public function run(): void
    {
        $gestStock = User::where('role', 'gestionnaire_stocks')->first();
        $admin     = User::where('role', 'admin')->first();

        $mouvements = [
            ['article_code'=>'ART001','type'=>'entree','quantite'=>300,'motif'=>'Réception commande BC-2026-003','reference_doc'=>'BC-2026-003','qav'=>0,'qap'=>300,'date'=>'2026-03-22','user_id'=>$gestStock->id],
            ['article_code'=>'ART001','type'=>'sortie','quantite'=>55,'motif'=>'Distribution site Pissy','reference_doc'=>'BS-2026-015','qav'=>300,'qap'=>245,'date'=>'2026-04-10','user_id'=>$gestStock->id],
            ['article_code'=>'ART002','type'=>'entree','quantite'=>240,'motif'=>'Réception commande BC-2026-003','reference_doc'=>'BC-2026-003','qav'=>0,'qap'=>240,'date'=>'2026-03-22','user_id'=>$gestStock->id],
            ['article_code'=>'ART002','type'=>'sortie','quantite'=>60,'motif'=>'Distribution cliniques régionales','reference_doc'=>'BS-2026-016','qav'=>240,'qap'=>180,'date'=>'2026-04-15','user_id'=>$gestStock->id],
            ['article_code'=>'ART003','type'=>'sortie','quantite'=>8,'motif'=>'Programme sensibilisation mars','reference_doc'=>'BS-2026-010','qav'=>20,'qap'=>12,'date'=>'2026-03-30','user_id'=>$gestStock->id],
            ['article_code'=>'ART008','type'=>'entree','quantite'=>500,'motif'=>'Réception commande BC-2026-002','reference_doc'=>'BC-2026-002','qav'=>0,'qap'=>500,'date'=>'2026-02-18','user_id'=>$gestStock->id],
            ['article_code'=>'ART008','type'=>'sortie','quantite'=>160,'motif'=>'Distribution bureaux régionaux','reference_doc'=>'BS-2026-008','qav'=>500,'qap'=>340,'date'=>'2026-03-01','user_id'=>$gestStock->id],
            ['article_code'=>'ART009','type'=>'entree','quantite'=>30,'motif'=>'Réception commande BC-2026-001','reference_doc'=>'BC-2026-001','qav'=>0,'qap'=>30,'date'=>'2026-02-03','user_id'=>$gestStock->id],
            ['article_code'=>'ART009','type'=>'sortie','quantite'=>12,'motif'=>'Remplacement imprimantes bureaux','reference_doc'=>'BS-2026-005','qav'=>30,'qap'=>18,'date'=>'2026-02-15','user_id'=>$gestStock->id],
            ['article_code'=>'ART013','type'=>'entree','quantite'=>10,'motif'=>'Réception commande BC-2026-001','reference_doc'=>'BC-2026-001','qav'=>0,'qap'=>10,'date'=>'2026-02-03','user_id'=>$gestStock->id],
            ['article_code'=>'ART013','type'=>'sortie','quantite'=>6,'motif'=>'Attribution staff terrain','reference_doc'=>'BS-2026-006','qav'=>10,'qap'=>4,'date'=>'2026-02-20','user_id'=>$gestStock->id],
            ['article_code'=>'ART015','type'=>'sortie','quantite'=>12,'motif'=>'Entretien mensuel bureaux Ouaga','reference_doc'=>'BS-2026-020','qav'=>50,'qap'=>38,'date'=>'2026-05-05','user_id'=>$gestStock->id],
            ['article_code'=>'ART018','type'=>'entree','quantite'=>1000,'motif'=>'Approvisionnement carburant parc auto','reference_doc'=>'BC-CARB-006','qav'=>0,'qap'=>1000,'date'=>'2026-01-10','user_id'=>$gestStock->id],
            ['article_code'=>'ART018','type'=>'sortie','quantite'=>500,'motif'=>'Consommation flotte vehicules Jan-Fev 2026','reference_doc'=>'LOG-2026-001','qav'=>1000,'qap'=>500,'date'=>'2026-03-01','user_id'=>$gestStock->id],
        ];

        foreach ($mouvements as $mvt) {
            $article = Article::where('code', $mvt['article_code'])->first();
            if (! $article) {
                continue;
            }
            MouvementStock::firstOrCreate(
                ['article_id'=>$article->id,'reference_doc'=>$mvt['reference_doc'],'date_mouvement'=>$mvt['date'],'type'=>$mvt['type']],
                [
                    'user_id'        => $mvt['user_id'],
                    'quantite'       => $mvt['quantite'],
                    'quantite_avant' => $mvt['qav'],
                    'quantite_apres' => $mvt['qap'],
                    'motif'          => $mvt['motif'],
                    'notes'          => null,
                ]
            );
        }
    }
}
