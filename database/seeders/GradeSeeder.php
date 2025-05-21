<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Grade;

class GradeSeeder extends Seeder
{
    public function run()
    {
        $grades = [
            'Enseignant',
            'Technicien supérieur',
            'Technicien',
            'Assistant'
        ];

        foreach ($grades as $nom) {
            Grade::create([
                'nom'         => $nom,
                'description' => "Description pour le grade {$nom}."
            ]);
        }
    }
}
