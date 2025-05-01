<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Grade;

class GradeSeeder extends Seeder
{
    public function run()
    {
        $grades = ['Technicien', 'Ingénieur', 'Administrateur', 'Étudiant'];
        foreach ($grades as $nom) {
            Grade::create(['nom' => $nom]);
        }
    }
}
