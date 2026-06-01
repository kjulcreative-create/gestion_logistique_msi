<?php

namespace Database\Seeders;

use App\Models\Equipement;
use App\Models\MaintenanceEquipement;
use App\Models\User;
use Illuminate\Database\Seeder;

class EquipementSeeder extends Seeder
{
    public function run(): void
    {
        $respInfo = User::where('email', 'a.barry@msi-bf.org')->first();
        $respEq   = User::where('role', 'gestionnaire_equipements')->first();
        $admin    = User::where('role', 'admin')->first();

        $equipements = [
            ['code'=>'EQ-001','designation'=>'Ordinateur portable Dell Latitude 5540','marque'=>'Dell','modele'=>'Latitude 5540','numero_serie'=>'DELL5540BF001','date_acquisition'=>'2023-06-15','valeur_acquisition'=>850000,'fournisseur_acquisition'=>'CFAO Burkina','statut'=>'en_service','localisation'=>'Bureau DR - Ouagadougou','affectation'=>'Direction Représentante','responsable_id'=>$admin->id,'date_prochain_entretien'=>'2026-06-15'],
            ['code'=>'EQ-002','designation'=>'Ordinateur portable HP ProBook 450','marque'=>'HP','modele'=>'ProBook 450 G9','numero_serie'=>'HPG9BF002','date_acquisition'=>'2023-09-10','valeur_acquisition'=>650000,'fournisseur_acquisition'=>'CFAO Burkina','statut'=>'en_service','localisation'=>'Bureau Achats','affectation'=>'Responsable Achats','responsable_id'=>$respEq->id,'date_prochain_entretien'=>'2026-09-10'],
            ['code'=>'EQ-003','designation'=>'Imprimante laser HP LaserJet MFP M234dw','marque'=>'HP','modele'=>'LaserJet MFP M234dw','numero_serie'=>'HPM234BF003','date_acquisition'=>'2024-01-20','valeur_acquisition'=>380000,'fournisseur_acquisition'=>'CFAO Burkina','statut'=>'en_service','localisation'=>'Secrétariat - RDC','affectation'=>'Usage commun','responsable_id'=>$respInfo->id,'date_prochain_entretien'=>'2026-01-20'],
            ['code'=>'EQ-004','designation'=>'Climatiseur Split Gree 12000 BTU','marque'=>'Gree','modele'=>'SPLIT 12000','numero_serie'=>'GREE12BF004','date_acquisition'=>'2022-04-05','valeur_acquisition'=>320000,'fournisseur_acquisition'=>'Conforama BF','statut'=>'en_maintenance','localisation'=>'Salle de réunion principale','affectation'=>'Usage commun','responsable_id'=>$respEq->id,'date_prochain_entretien'=>'2026-06-05'],
            ['code'=>'EQ-005','designation'=>'Groupe électrogène Kirloskar 15 KVA','marque'=>'Kirloskar','modele'=>'KG2-15AS','numero_serie'=>'KG215BF005','date_acquisition'=>'2021-11-30','valeur_acquisition'=>3200000,'fournisseur_acquisition'=>'Indus Energy BF','statut'=>'en_service','localisation'=>'Local technique - Arrière-cour','affectation'=>'Alimentation secours','responsable_id'=>$respEq->id,'date_prochain_entretien'=>'2026-06-30'],
            ['code'=>'EQ-006','designation'=>'Photocopieur Canon imageRUNNER 2625i','marque'=>'Canon','modele'=>'imageRUNNER 2625i','numero_serie'=>'CAN2625BF006','date_acquisition'=>'2023-03-14','valeur_acquisition'=>1450000,'fournisseur_acquisition'=>'CFAO Burkina','statut'=>'en_service','localisation'=>'Reprographie - 1er étage','affectation'=>'Usage commun','responsable_id'=>$respInfo->id,'date_prochain_entretien'=>'2026-03-14'],
            ['code'=>'EQ-007','designation'=>'Serveur NAS Synology DS923+','marque'=>'Synology','modele'=>'DS923+','numero_serie'=>'SYN923BF007','date_acquisition'=>'2024-02-28','valeur_acquisition'=>2100000,'fournisseur_acquisition'=>'CFAO Burkina','statut'=>'en_service','localisation'=>'Salle serveur - RDC','affectation'=>'Sauvegarde données','responsable_id'=>$respInfo->id,'date_prochain_entretien'=>'2027-02-28'],
            ['code'=>'EQ-008','designation'=>'Réfrigérateur médicaments Vestfrost +2/+8°C','marque'=>'Vestfrost','modele'=>'MediFridge MF25','numero_serie'=>'VF25BF008','date_acquisition'=>'2022-08-10','valeur_acquisition'=>890000,'fournisseur_acquisition'=>'Médical Import BF','statut'=>'en_service','localisation'=>'Stock médicaments - Magasin froid','affectation'=>'Conservation intrants SR','responsable_id'=>$respEq->id,'date_prochain_entretien'=>'2026-08-10'],
            ['code'=>'EQ-009','designation'=>'Tensiomètre électronique Omron M3','marque'=>'Omron','modele'=>'M3','numero_serie'=>'OMR3BF009','date_acquisition'=>'2024-05-01','valeur_acquisition'=>45000,'fournisseur_acquisition'=>'Médical Import BF','statut'=>'en_service','localisation'=>'Clinique Pissy','affectation'=>'Consultations prénatales','responsable_id'=>$respEq->id,'date_prochain_entretien'=>null],
            ['code'=>'EQ-010','designation'=>'Onduleur APC Smart-UPS 1500VA','marque'=>'APC','modele'=>'Smart-UPS 1500VA','numero_serie'=>'APCSUPS15BF010','date_acquisition'=>'2023-11-15','valeur_acquisition'=>280000,'fournisseur_acquisition'=>'CFAO Burkina','statut'=>'hors_service','localisation'=>'Salle serveur - RDC','affectation'=>'Protection serveur','responsable_id'=>$respInfo->id,'date_prochain_entretien'=>null,'notes'=>'Batterie hors service - remplacement en attente'],
        ];

        foreach ($equipements as $eq) {
            Equipement::firstOrCreate(['code' => $eq['code']], $eq);
        }

        // Maintenances historiques
        $eq4 = Equipement::where('code', 'EQ-004')->first();
        $eq5 = Equipement::where('code', 'EQ-005')->first();
        $eq6 = Equipement::where('code', 'EQ-006')->first();

        if ($eq4 && $respEq) {
            MaintenanceEquipement::firstOrCreate(
                ['equipement_id'=>$eq4->id,'date_maintenance'=>'2026-05-15'],
                ['type_maintenance'=>'corrective','cout'=>45000,'prestataire'=>'Froid Services BF','description'=>'Panne compresseur - remplacement filtre et recharge gaz','prochain_entretien'=>'2026-11-15','user_id'=>$respEq->id]
            );
        }
        if ($eq5 && $respEq) {
            MaintenanceEquipement::firstOrCreate(
                ['equipement_id'=>$eq5->id,'date_maintenance'=>'2026-03-20'],
                ['type_maintenance'=>'preventive','cout'=>85000,'prestataire'=>'Techno Power BF','description'=>'Révision semestrielle - vidange et vérification alternateur','prochain_entretien'=>'2026-09-20','user_id'=>$respEq->id]
            );
        }
        if ($eq6 && $respInfo) {
            MaintenanceEquipement::firstOrCreate(
                ['equipement_id'=>$eq6->id,'date_maintenance'=>'2026-04-02'],
                ['type_maintenance'=>'preventive','cout'=>35000,'prestataire'=>'Canon Service Center','description'=>'Nettoyage tambour, remplacement kit de fusion','prochain_entretien'=>'2026-10-02','user_id'=>$respInfo->id]
            );
        }
    }
}
