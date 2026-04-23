<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Cabine;

class GestionnaireController extends Controller
{
    public function store(Request $request)
    {
        Gate::authorize('manage-gestionnaires');

        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'numero' => [
            'required',
            'string',
            'max:20',
            'regex:/^[\d\s\-\+\(\)]+$/',
        ],
        'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-z])(?=.*\d)(?=.*[\W_]).+$/', 'confirmed'],
        'role' => ['required', Rule::in(['user', 'responsable'])],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        try {
            $current = Auth::user();
            if (!$current || !$current->cabine_id) {
                return redirect()->back()->with('error', "Boutique introuvable pour l'utilisateur courant.");
            }
    
            $cabine = $current->cabine;

            // Vérifier si la cabine peut accepter de nouveaux utilisateurs
            if (!$cabine->peutAccepterUtilisateurs()) {
                return redirect()->back()->with('error', 'La boutique a atteint le nombre maximum de gestionnaires, Obtenez une certification pour enregistrer plus de gestionnaire.');
            }
    
            User::create([
                'nom' => $request->nom,
                'email' => $request->email,
                'numero' => $request->numero,
                'role' => $request->role,
                'password' => Hash::make($request->password),
                'password_changed_at' => now(),
                'cabine_id' => $current->cabine_id,
            ]);
    
            return redirect()->back()->with('success', 'Gestionnaire créé avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la création : ' . $e->getMessage())
                ->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        Gate::authorize('manage-gestionnaires');

        $current = Auth::user();
        if (!$current || !$current->cabine_id) {
            return redirect()->back()->with('error', "Boutique introuvable pour l'utilisateur courant.");
        }

        $gestionnaire = User::where('id', $id)
            ->where('cabine_id', $current->cabine_id)
            ->first();

        if (!$gestionnaire) {
            return redirect()->back()->with('error', 'Gestionnaire introuvable.');
        }

        // Règles de validation (email unique sauf pour lui-même, password optionnel)
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                Rule::unique('users', 'email')->ignore($gestionnaire->id),
            ],
            
            'numero' => [
            'required',
            'string',
            'max:20',
            'regex:/^[\d\s\-\+\(\)]+$/',
        ],
            'role' => ['required', Rule::in(['user', 'responsable'])],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $updateData = [
                'nom' => $request->nom,
                'email' => $request->email,
                'numero' => $request->numero,
                'role' => $request->role,
            ];

            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($request->password);
            }

            $gestionnaire->update($updateData);

            return redirect()->back()->with('success', 'Gestionnaire mis à jour avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour : ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        Gate::authorize('manage-gestionnaires');

        $current = Auth::user();
        if (!$current || !$current->cabine_id) {
            return redirect()->back()->with('error', "Boutique introuvable pour l'utilisateur courant.");
        }

        $gestionnaire = User::where('id', $id)
            ->where('cabine_id', $current->cabine_id)
            ->first();

        if (!$gestionnaire) {
            return redirect()->back()->with('error', 'Gestionnaire introuvable.');
        }

        if ($gestionnaire->id === $current->id) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        try {
            $gestionnaire->delete();
            return redirect()->back()->with('success', 'Gestionnaire supprimé avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }
    }
}
