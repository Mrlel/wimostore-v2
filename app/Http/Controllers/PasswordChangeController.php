<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PasswordChangeController extends Controller
{
    /**
     * Afficher le formulaire de changement de mot de passe obligatoire
     */
    public function showChangeForm()
    {
        return view('auth.force-password-change');
    }

    /**
     * Traiter le changement de mot de passe obligatoire
     */
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*\d)(?=.*[\W_]).+$/',
            'accept_politique' => 'required',
        ], [
            'current_password.required' => 'Le mot de passe actuel est requis.',
            'password.required' => 'Le nouveau mot de passe est requis.',
            'password.min' => 'Le nouveau mot de passe doit contenir au moins 8 caractères.',
            'password.regex' => 'Le nouveau mot de passe doit contenir au moins une minuscule, un chiffre et un caractère spécial (@$!%*?&).',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            'accept_politique.required' => 'Vous devez accepter la politique de confidentialité.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();

        // Vérifier le mot de passe actuel
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Le mot de passe actuel est incorrect.'
            ])->withInput();
        }

        // Mettre à jour le mot de passe et marquer comme changé
        $user->update([
            'password' => Hash::make($request->password),
            'password_changed_at' => now(),
            'accept_politique' => $request->accept_politique,
        ]);

        if($user->role === 'superadmin' || $user->role === 'admin'){
            return redirect()->route('admin.dashboard')->with('success', 'Mot de passe changé avec succès ! Bienvenue dans votre espace.');
        }
        return redirect()->route('dashboard')->with('success', 'Mot de passe changé avec succès ! Bienvenue dans votre espace.');
    }
}
