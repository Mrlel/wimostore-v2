<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categorie;

class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['nom' => 'Accessoires téléphoniques', 'cabine_id' => 2], // id = 1
            ['nom' => 'Bijoux et montres', 'cabine_id' => 2],         // id = 2
            ['nom' => 'Vêtements', 'cabine_id' => 2],                 // id = 3
            ['nom' => 'Chaussures', 'cabine_id' => 2],                // id = 4
            ['nom' => 'Cosmétiques', 'cabine_id' => 2],               // id = 5
            ['nom' => 'Téléphones portables', 'cabine_id' => 2],      // id = 6
            ['nom' => 'Parfums', 'cabine_id' => 2],                   // id = 7
            ['nom' => 'Sacs à main', 'cabine_id' => 2],               // id = 8
            ['nom' => 'Tous', 'cabine_id' => 2],                      // id = 9 (catégorie par défaut)
        ];

        foreach ($categories as $cat) {
            Categorie::create($cat);
        }
    }
}
