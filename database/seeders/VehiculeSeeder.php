<?php

namespace Database\Seeders;

use App\Models\Vehicule;
use App\Models\MaintenanceVehicule;
use App\Models\ConsommationCarburant;
use App\Models\User;
use Illuminate\Database\Seeder;

class VehiculeSeeder extends Seeder
{
    public function run(): void
    {
        $chauffeur1  = User::where('email', 'a.diallo@msi-bf.org')->first();
        $chauffeur2  = User::where('email', 'w.compaore@msi-bf.org')->first();
        $gestFlotte  = User::where('role', 'gestionnaire_flotte')->first();

        $vehicules = [
            ['immatriculation'=>'11A1234BF','marque'=>'Toyota','modele'=>'Land Cruiser 200','annee'=>2020,'type_carburant'=>'diesel','couleur'=>'Blanc','numero_chassis'=>'JT5J3HY1JK5127834','kilometrage_actuel'=>87420,'statut'=>'disponible','affectation'=>'Direction Nationale - Ouagadougou','chauffeur_id'=>$chauffeur1->id,'date_acquisition'=>'2020-03-10','valeur_acquisition'=>28000000,'date_expiration_assurance'=>'2026-12-31','date_expiration_visite_technique'=>'2026-06-30','prochain_entretien_date'=>'2026-07-10','prochain_entretien_km'=>90000],
            ['immatriculation'=>'22B5678BF','marque'=>'Toyota','modele'=>'HiLux Double Cab','annee'=>2021,'type_carburant'=>'diesel','couleur'=>'Blanc','numero_chassis'=>'MR0EX32G204025891','kilometrage_actuel'=>64380,'statut'=>'en_mission','affectation'=>'Équipe terrain - Régions','chauffeur_id'=>$chauffeur2->id,'date_acquisition'=>'2021-07-20','valeur_acquisition'=>18500000,'date_expiration_assurance'=>'2026-11-30','date_expiration_visite_technique'=>'2026-09-15','prochain_entretien_date'=>'2026-06-20','prochain_entretien_km'=>65000],
            ['immatriculation'=>'33C9012BF','marque'=>'Nissan','modele'=>'Patrol GRX','annee'=>2019,'type_carburant'=>'diesel','couleur'=>'Gris','numero_chassis'=>'VSkjRY61U00427123','kilometrage_actuel'=>112500,'statut'=>'en_maintenance','affectation'=>'Bobo Dioulasso - Équipe Régionale Ouest','chauffeur_id'=>null,'date_acquisition'=>'2019-11-05','valeur_acquisition'=>22000000,'date_expiration_assurance'=>'2026-10-31','date_expiration_visite_technique'=>'2026-04-30','prochain_entretien_date'=>null,'prochain_entretien_km'=>115000,'notes'=>'En maintenance au garage Peugeot - révision moteur'],
            ['immatriculation'=>'44D3456BF','marque'=>'Toyota','modele'=>'RAV4 Hybride','annee'=>2023,'type_carburant'=>'hybride','couleur'=>'Blanc','numero_chassis'=>'JTMH31FV3PD123456','kilometrage_actuel'=>28600,'statut'=>'disponible','affectation'=>'Représentante Résidente','chauffeur_id'=>$chauffeur1->id,'date_acquisition'=>'2023-02-15','valeur_acquisition'=>19800000,'date_expiration_assurance'=>'2027-01-31','date_expiration_visite_technique'=>'2027-02-28','prochain_entretien_date'=>'2026-08-15','prochain_entretien_km'=>30000],
            ['immatriculation'=>'55E7890BF','marque'=>'Mitsubishi','modele'=>'L200 Triton','annee'=>2022,'type_carburant'=>'diesel','couleur'=>'Blanc','numero_chassis'=>'MMBJNKB40NF123789','kilometrage_actuel'=>45200,'statut'=>'disponible','affectation'=>'Koudougou - Équipe Régionale Centre','chauffeur_id'=>null,'date_acquisition'=>'2022-05-30','valeur_acquisition'=>16500000,'date_expiration_assurance'=>'2026-08-31','date_expiration_visite_technique'=>'2026-11-30','prochain_entretien_date'=>'2026-08-30','prochain_entretien_km'=>50000],
        ];

        foreach ($vehicules as $v) {
            Vehicule::firstOrCreate(['immatriculation' => $v['immatriculation']], $v);
        }

        // Maintenances
        $v1 = Vehicule::where('immatriculation','11A1234BF')->first();
        $v3 = Vehicule::where('immatriculation','33C9012BF')->first();

        if ($v1 && $gestFlotte) {
            MaintenanceVehicule::firstOrCreate(
                ['vehicule_id'=>$v1->id,'date_maintenance'=>'2026-04-10'],
                ['type_maintenance'=>'vidange','km_effectue'=>85000,'cout'=>75000,'prestataire'=>'Garage Central Toyota','description'=>'Vidange + filtre huile + filtre air + contrôle freins','prochain_entretien_date'=>'2026-10-10','prochain_entretien_km'=>90000,'user_id'=>$gestFlotte->id]
            );
        }
        if ($v3 && $gestFlotte) {
            MaintenanceVehicule::firstOrCreate(
                ['vehicule_id'=>$v3->id,'date_maintenance'=>'2026-05-20'],
                ['type_maintenance'=>'reparation','km_effectue'=>112500,'cout'=>450000,'prestataire'=>'Garage Central Peugeot','description'=>'Révision moteur - remplacement joints de culasse et courroie distribution','prochain_entretien_date'=>'2026-11-20','prochain_entretien_km'=>125000,'user_id'=>$gestFlotte->id]
            );
        }

        // Consommations carburant
        if ($v1 && $chauffeur1) {
            ConsommationCarburant::firstOrCreate(
                ['vehicule_id'=>$v1->id,'date'=>'2026-05-05','station'=>'Total Ouaga 2000'],
                ['mission_id'=>null,'user_id'=>$chauffeur1->id,'quantite_litres'=>60,'prix_litre'=>700,'montant_total'=>42000,'km_compteur'=>86800]
            );
            ConsommationCarburant::firstOrCreate(
                ['vehicule_id'=>$v1->id,'date'=>'2026-04-18','station'=>'Shell Zone du Bois'],
                ['mission_id'=>null,'user_id'=>$chauffeur1->id,'quantite_litres'=>55,'prix_litre'=>700,'montant_total'=>38500,'km_compteur'=>85200]
            );
        }
    }
}
