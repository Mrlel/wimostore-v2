<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cabine;
class CabineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cabine::create([
            'nom_cab' => 'WimoStock',
            'localisation' => 'koumassi',
            'code' => 'BTQ-0-admin',
            'type_compte' => 'admin',
            'max_utilisateurs' => 2,
            'certifier' => true,
            'est_actif' => true,
        ]);
    }
}
