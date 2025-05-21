<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Etablissement;

class EtablissementSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'FSJEGJ', 'INTEK', 'ISSHJ', 'ISLAIB', 'ISIKEF',
            'ISEAHK', 'ISAMS', 'ISMTK', 'ISPT', 'ESAK',
            'ESIM', 'ISSEPK', 'ISSIK', 'ISBB'
        ];

        foreach ($data as $name) {
            Etablissement::create([
                'nom'         => $name,
                'description' => "Description pour l'établissement {$name}."
            ]);
        }
    }
}
