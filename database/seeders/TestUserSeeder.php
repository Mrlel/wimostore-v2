<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Cabine;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer une cabine de test si elle n'existe pas
        $cabine = Cabine::firstOrCreate(
            ['nom' => 'Cabine Test'],
            [
                'nom' => 'Cabine Test',
                'adresse' => 'Adresse Test',
                'est_actif' => true,
                'code' => 'TEST001'
            ]
        );

        // Créer un utilisateur de test avec mot de passe par défaut
        User::firstOrCreate(
            ['numero' => '+2250700000000'],
            [
                'nom' => 'Utilisateur Test',
                'email' => 'test@example.com',
                'numero' => '+2250700000000',
                'password' => Hash::make('password123'), // Mot de passe par défaut
                'role' => 'user',
                'cabine_id' => $cabine->id,
                'password_changed_at' => null, // Doit changer le mot de passe
            ]
        );

        // Créer un admin de test avec mot de passe par défaut
        User::firstOrCreate(
            ['numero' => '+2250700000001'],
            [
                'nom' => 'Admin Test',
                'email' => 'admin@example.com',
                'numero' => '+2250700000001',
                'password' => Hash::make('admin123'), // Mot de passe par défaut
                'role' => 'admin',
                'cabine_id' => $cabine->id,
                'password_changed_at' => null, // Doit changer le mot de passe
            ]
        );
    }
}
