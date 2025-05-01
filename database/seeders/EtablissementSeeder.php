<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Etablissement;

class EtablissementSeeder extends Seeder
{
    public function run()
    {
        $data = ['Université de Jendouba', 'ISAMM', 'ENIT', 'IHEC', 'ISG', 'FST'];
        foreach ($data as $name) {
            Etablissement::create(['nom' => $name]);
        }
    }
}
