<?php

namespace Database\Seeders;

use App\Models\MissionVehicule;
use App\Models\ConsommationCarburant;
use App\Models\Vehicule;
use App\Models\User;
use Illuminate\Database\Seeder;

class MissionVehiculeSeeder extends Seeder
{
    public function run(): void
    {
        $chauffeur1 = User::where('email', 'a.diallo@msi-bf.org')->first();
        $chauffeur2 = User::where('email', 'w.compaore@msi-bf.org')->first();
        $gestFlotte = User::where('role', 'gestionnaire_flotte')->first();
        $admin      = User::where('role', 'admin')->first();

        $v1 = Vehicule::where('immatriculation','11A1234BF')->first();
        $v2 = Vehicule::where('immatriculation','22B5678BF')->first();
        $v4 = Vehicule::where('immatriculation','44D3456BF')->first();

        $missions = [
            [
                'reference'          => 'MSN-2026-001',
                'vehicule_id'        => $v1->id,
                'chauffeur_id'       => $chauffeur1->id,
                'demandeur_id'       => $admin->id,
                'destination'        => 'Koudougou (Région du Centre-Ouest)',
                'objet'              => 'Supervision clinique partenaire et formation équipe',
                'date_depart'        => '2026-04-07',
                'heure_depart'       => '07:00',
                'date_retour_prevue' => '2026-04-08',
                'date_retour_reelle' => '2026-04-08',
                'km_depart'          => 82100,
                'km_retour'          => 82650,
                'statut'             => 'terminee',
                'observations'       => 'Mission effectuée sans incident. 550 km parcourus.',
            ],
            [
                'reference'          => 'MSN-2026-002',
                'vehicule_id'        => $v2->id,
                'chauffeur_id'       => $chauffeur2->id,
                'demandeur_id'       => $gestFlotte->id,
                'destination'        => 'Bobo Dioulasso (Hauts-Bassins)',
                'objet'              => 'Approvisionnement intrants sanitaires clinique régionale Ouest',
                'date_depart'        => '2026-05-12',
                'heure_depart'       => '05:30',
                'date_retour_prevue' => '2026-05-14',
                'date_retour_reelle' => '2026-05-14',
                'km_depart'          => 61000,
                'km_retour'          => 62620,
                'statut'             => 'terminee',
                'observations'       => '1620 km parcourus. Livraison effectuée intégralement.',
            ],
            [
                'reference'          => 'MSN-2026-003',
                'vehicule_id'        => $v4->id,
                'chauffeur_id'       => $chauffeur1->id,
                'demandeur_id'       => $admin->id,
                'destination'        => 'Banfora + Gaoua (Cascades / Sud-Ouest)',
                'objet'              => 'Visite supervision équipes régionales Sud-Ouest',
                'date_depart'        => '2026-05-26',
                'heure_depart'       => '06:00',
                'date_retour_prevue' => '2026-05-29',
                'date_retour_reelle' => null,
                'km_depart'          => 27800,
                'km_retour'          => null,
                'statut'             => 'en_cours',
                'observations'       => 'Mission en cours - retour prévu le 29 mai 2026.',
            ],
            [
                'reference'          => 'MSN-2026-004',
                'vehicule_id'        => $v2->id,
                'chauffeur_id'       => $chauffeur2->id,
                'demandeur_id'       => $gestFlotte->id,
                'destination'        => 'Tenkodogo (Région du Centre-Est)',
                'objet'              => 'Formation prestataires de santé - SR et planification familiale',
                'date_depart'        => '2026-06-10',
                'heure_depart'       => '07:30',
                'date_retour_prevue' => '2026-06-12',
                'date_retour_reelle' => null,
                'km_depart'          => null,
                'km_retour'          => null,
                'statut'             => 'planifiee',
                'observations'       => null,
            ],
        ];

        foreach ($missions as $m) {
            MissionVehicule::firstOrCreate(['reference' => $m['reference']], $m);
        }

        // Consommation liée à la mission 2
        $msn2 = MissionVehicule::where('reference','MSN-2026-002')->first();
        if ($msn2 && $chauffeur2) {
            ConsommationCarburant::firstOrCreate(
                ['vehicule_id'=>$v2->id,'date'=>'2026-05-12','station'=>'Total Koubri (RN1)'],
                ['mission_id'=>$msn2->id,'user_id'=>$chauffeur2->id,'quantite_litres'=>65,'prix_litre'=>700,'montant_total'=>45500,'km_compteur'=>61280]
            );
            ConsommationCarburant::firstOrCreate(
                ['vehicule_id'=>$v2->id,'date'=>'2026-05-13','station'=>'Shell Bobo Dioulasso'],
                ['mission_id'=>$msn2->id,'user_id'=>$chauffeur2->id,'quantite_litres'=>50,'prix_litre'=>700,'montant_total'=>35000,'km_compteur'=>62100]
            );
        }
    }
}
