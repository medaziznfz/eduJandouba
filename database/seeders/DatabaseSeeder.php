<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Etablissement;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // D'abord, créer les établissements
        $this->call([
            EtablissementSeeder::class,
            GradeSeeder::class,
        ]);

        // Récupération de l’établissement pour associer à l'etab
        $etablissement = Etablissement::first(); // ou choisir un ID spécifique

        // 👤 Super utilisateur
        User::create([
            'prenom' => 'Admin',
            'nom' => 'Principal',
            'email' => 'admin@admin.com',
            'cin' => '12345678',
            'telephone' => '99999999',
            'password' => Hash::make('admin123'),
            'role' => 'super',
            'etablissement_id' => null, // optionnel
        ]);

        // 👤 Validateur d’établissement
        User::create([
            'prenom' => 'Valideur',
            'nom' => 'Etablissement',
            'email' => 'etab@onpc.tn',
            'cin' => '88888888',
            'telephone' => '98765432',
            'password' => Hash::make('etab123'),
            'role' => 'etab',
            'etablissement_id' => $etablissement->id, // obligatoire
        ]);

        // 👤 Validateur universitaire
        User::create([
            'prenom' => 'Valideur',
            'nom' => 'Université',
            'email' => 'univ@onpc.tn',
            'cin' => '77777777',
            'telephone' => '87654321',
            'password' => Hash::make('univ123'),
            'role' => 'univ',
            'etablissement_id' => null, // facultatif, il voit tout
        ]);
    }
}
