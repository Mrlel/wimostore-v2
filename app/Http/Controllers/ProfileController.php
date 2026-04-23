<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\Abonnement;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class ProfileController extends Controller
{

    public function show()
    {
        $user = auth()->user();
        $abonnement = Abonnement::with('cabine')
        ->where('cabine_id', $user->cabine_id)
        ->latest('date_fin')->get();
        return view('profile.show', compact('user', 'abonnement'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nom' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z0-9\s\-\_àâäéèêëïîôöùûüçÀÂÄÉÈÊËÏÎÔÖÙÛÜÇ&@°+]+$/u'],
            'numero' => ['required', 'string', 'max:255', 'regex:/^[\d\s\-\+\(\)]+$/',],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . auth()->id()],
        ]);

        auth()->user()->update($request->only('nom', 'email', 'numero'));

        return back()->with('success', 'Profil mis à jour avec succès.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'confirmed', 'min:8', 'regex:/^(?=.*[a-z])(?=.*\d)(?=.*[\W_]).+$/'],
        ]);

        auth()->user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Mot de passe changé avec succès.');
    }
}