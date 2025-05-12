<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Grade;

class GradeSeeder extends Seeder
{
    public function run()
    {
        $grades = ['Enseignant', 'technicien supérieur', 'technicien', 'Assistant'];
        foreach ($grades as $nom) {
            Grade::create(['nom' => $nom]);
        }
    }
}
