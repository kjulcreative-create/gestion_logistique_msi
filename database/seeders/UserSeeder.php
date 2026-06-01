<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name'      => 'Administrateur Système',
                'email'     => 'admin@msi-bf.org',
                'password'  => Hash::make('Admin@2026'),
                'role'      => 'admin',
                'telephone' => '+226 25 36 01 01',
                'poste'     => 'Administrateur Système',
            ],
            [
                'name'      => 'Koné Ibrahim',
                'email'     => 'i.kone@msi-bf.org',
                'password'  => Hash::make('MSIbf@2026'),
                'role'      => 'gestionnaire_achats',
                'telephone' => '+226 70 12 34 56',
                'poste'     => 'Responsable Achats et Approvisionnements',
            ],
            [
                'name'      => 'Traoré Aïssata',
                'email'     => 'a.traore@msi-bf.org',
                'password'  => Hash::make('MSIbf@2026'),
                'role'      => 'gestionnaire_stocks',
                'telephone' => '+226 76 23 45 67',
                'poste'     => 'Gestionnaire de Stocks',
            ],
            [
                'name'      => 'Ouédraogo Seydou',
                'email'     => 's.ouedraogo@msi-bf.org',
                'password'  => Hash::make('MSIbf@2026'),
                'role'      => 'gestionnaire_equipements',
                'telephone' => '+226 71 34 56 78',
                'poste'     => 'Responsable Équipements et Patrimoine',
            ],
            [
                'name'      => 'Sawadogo Rasmané',
                'email'     => 'r.sawadogo@msi-bf.org',
                'password'  => Hash::make('MSIbf@2026'),
                'role'      => 'gestionnaire_flotte',
                'telephone' => '+226 78 45 67 89',
                'poste'     => 'Gestionnaire Parc Automobile',
            ],
            [
                'name'      => 'Diallo Aminata',
                'email'     => 'a.diallo@msi-bf.org',
                'password'  => Hash::make('MSIbf@2026'),
                'role'      => 'utilisateur',
                'telephone' => '+226 65 56 78 90',
                'poste'     => 'Chauffeur Senior',
            ],
            [
                'name'      => 'Compaoré Wendpanga',
                'email'     => 'w.compaore@msi-bf.org',
                'password'  => Hash::make('MSIbf@2026'),
                'role'      => 'utilisateur',
                'telephone' => '+226 72 67 89 01',
                'poste'     => 'Chauffeur',
            ],
            [
                'name'      => 'Zongo Fatimata',
                'email'     => 'f.zongo@msi-bf.org',
                'password'  => Hash::make('MSIbf@2026'),
                'role'      => 'utilisateur',
                'telephone' => '+226 66 78 90 12',
                'poste'     => 'Coordinatrice Régionale - Bobo Dioulasso',
            ],
            [
                'name'      => 'Barry Adama',
                'email'     => 'a.barry@msi-bf.org',
                'password'  => Hash::make('MSIbf@2026'),
                'role'      => 'utilisateur',
                'telephone' => '+226 73 89 01 23',
                'poste'     => 'Responsable Informatique',
            ],
        ];

        foreach ($users as $userData) {
            User::firstOrCreate(['email' => $userData['email']], $userData);
        }
    }
}
