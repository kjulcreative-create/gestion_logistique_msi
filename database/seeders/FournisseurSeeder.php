<?php

namespace Database\Seeders;

use App\Models\Fournisseur;
use Illuminate\Database\Seeder;

class FournisseurSeeder extends Seeder
{
    public function run(): void
    {
        $fournisseurs = [
            ['code'=>'F001','nom'=>'CFAO Burkina Faso','contact'=>'M. Ouédraogo Théophile','telephone'=>'+226 25 30 60 00','email'=>'burkina@cfao.com','adresse'=>'Avenue du Président Sangoule Lamizana','ville'=>'Ouagadougou','pays'=>'Burkina Faso','type_fourniture'=>'Matériel informatique et bureautique'],
            ['code'=>'F002','nom'=>'SONAPOST','contact'=>'Service Commercial','telephone'=>'+226 25 30 68 00','email'=>'commercial@sonapost.bf','adresse'=>'Avenue de la Nation, BP 99','ville'=>'Ouagadougou','pays'=>'Burkina Faso','type_fourniture'=>'Fournitures de bureau et imprimerie'],
            ['code'=>'F003','nom'=>'Pharmacie MSI/Direction','contact'=>'Mme Sawadogo Alice','telephone'=>'+226 25 36 40 00','email'=>'pharmacie@msi-bf.org','adresse'=>'Secteur 10, Ouagadougou','ville'=>'Ouagadougou','pays'=>'Burkina Faso','type_fourniture'=>'Médicaments et consommables médicaux'],
            ['code'=>'F004','nom'=>'TOTAL Energies BF','contact'=>'Service Entreprises','telephone'=>'+226 25 31 10 00','email'=>'entreprises.bf@total.com','adresse'=>'Avenue du Président Aboubakar Sangoulé Lamizana','ville'=>'Ouagadougou','pays'=>'Burkina Faso','type_fourniture'=>'Carburant et lubrifiants'],
            ['code'=>'F005','nom'=>'SHELL Burkina','contact'=>'M. Barro Mamadou','telephone'=>'+226 25 33 45 00','email'=>'m.barro@shell.bf','adresse'=>'Zone industrielle de Gounghin','ville'=>'Ouagadougou','pays'=>'Burkina Faso','type_fourniture'=>'Carburant'],
            ['code'=>'F006','nom'=>'Garage Central Peugeot','contact'=>'M. Nikiéma Paul','telephone'=>'+226 25 30 50 25','email'=>'garage.peugeot@gmail.com','adresse'=>'Route de Pô, Secteur 23','ville'=>'Ouagadougou','pays'=>'Burkina Faso','type_fourniture'=>'Pièces auto et réparation véhicules'],
            ['code'=>'F007','nom'=>'ONATEL/ORANGE BF','contact'=>'Service Entreprises','telephone'=>'+226 25 33 33 00','email'=>'entreprises@orange.bf','adresse'=>'Avenue de l\'Indépendance','ville'=>'Ouagadougou','pays'=>'Burkina Faso','type_fourniture'=>'Télécommunications et internet'],
            ['code'=>'F008','nom'=>'BRAKINA - Régie','contact'=>'Mme Compaoré Awa','telephone'=>'+226 25 36 22 00','email'=>'regie@brakina.bf','adresse'=>'Zone industrielle','ville'=>'Ouagadougou','pays'=>'Burkina Faso','type_fourniture'=>'Eau potable et boissons'],
            ['code'=>'F009','nom'=>'Imprimerie GRAPHIX PLUS','contact'=>'M. Traoré Siaka','telephone'=>'+226 70 55 66 77','email'=>'graphixplus@gmail.com','adresse'=>'Secteur 15, Rue 15.73','ville'=>'Ouagadougou','pays'=>'Burkina Faso','type_fourniture'=>'Impression et communication'],
            ['code'=>'F010','nom'=>'SONABEL','contact'=>'Direction Clientèle Entreprises','telephone'=>'+226 25 30 61 00','email'=>'client.entreprises@sonabel.bf','adresse'=>'Avenue Nelson Mandela','ville'=>'Ouagadougou','pays'=>'Burkina Faso','type_fourniture'=>'Fourniture d\'électricité'],
            ['code'=>'F011','nom'=>'Médical Import BF','contact'=>'Dr. Kaboré Jean-Pierre','telephone'=>'+226 70 22 33 44','email'=>'medical.import@gmail.com','adresse'=>'Secteur 22, Gounghin','ville'=>'Ouagadougou','pays'=>'Burkina Faso','type_fourniture'=>'Équipements et consommables médicaux'],
            ['code'=>'F012','nom'=>'SN-CITEC','contact'=>'Service Commercial','telephone'=>'+226 25 34 12 00','email'=>'commercial@sncitec.bf','adresse'=>'Bobo-Dioulasso, Zone Industrielle','ville'=>'Bobo Dioulasso','pays'=>'Burkina Faso','type_fourniture'=>'Produits alimentaires et d\'hygiène'],
        ];

        foreach ($fournisseurs as $f) {
            Fournisseur::firstOrCreate(['code' => $f['code']], $f);
        }
    }
}
