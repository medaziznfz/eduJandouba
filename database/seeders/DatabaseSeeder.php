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
        // D'abord, créer les établissements et les grades
        $this->call([
            EtablissementSeeder::class,
            GradeSeeder::class,
        ]);

        // Récupération du premier établissement pour lier les utilisateurs "etab", "forma" et "user"
        $etablissement = Etablissement::first(); // ou choisir un ID spécifique

        // 👤 Validateur d’établissement
        User::create([
            'prenom'           => 'Valideur',
            'nom'              => 'Etablissement',
            'email'            => 'etab@onpc.tn',
            'cin'              => '88888888',
            'telephone'        => '98765432',
            'password'         => Hash::make('etab123'),
            'role'             => 'etab',
            'etablissement_id' => $etablissement->id,
        ]);

        // 👤 Validateur universitaire
        User::create([
            'prenom'           => 'Valideur',
            'nom'              => 'Université',
            'email'            => 'univ@onpc.tn',
            'cin'              => '77777777',
            'telephone'        => '87654321',
            'password'         => Hash::make('univ123'),
            'role'             => 'univ',
            'etablissement_id' => null, // voit tout
        ]);

        // 👤 Formateur
        User::create([
            'prenom'           => 'Formateur',
            'nom'              => 'OnPC',
            'email'            => 'formateur@onpc.tn',
            'cin'              => '66666666',
            'telephone'        => '76543210',
            'password'         => Hash::make('forma123'),
            'role'             => 'forma',
            'etablissement_id' => $etablissement->id,
        ]);

        // 👤 Utilisateur simple
        User::create([
            'prenom'           => 'Utilisateur',
            'nom'              => 'Simple',
            'email'            => 'user@onpc.tn',
            'cin'              => '55555555',
            'telephone'        => '65432109',
            'password'         => Hash::make('user123'),
            'role'             => 'user',
            'etablissement_id' => 1, // pas d'établissement
            'grade_id' => 1,
        ]);
    }
}
