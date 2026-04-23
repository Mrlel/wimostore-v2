<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nom' => 'Mrlela Gnawa',
            'email' => 'wimostock@gmail.com',
            'password' => Hash::make('W!m0@2OO2!'),
            'role' => 'admin',
            'numero' => '+2250585986100',
            'password_changed_at' => now(),
            'cabine_id'  => 1
        ]);
        User::create([
            'nom' => 'Mrlela Gnawa',
            'email' => 'dominiklela456@gmail.com',
            'password' => Hash::make('Mrl3l@A119!'),
            'role' => 'superadmin',
            'numero' => '+2250720796688',
            'password_changed_at' => now(),
            'cabine_id'  => 1
        ]);
    }
}
