<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Cabine;
use App\Models\Abonnement;

class AdminController extends Controller
{


    public function index()
    {
        $cabines = Cabine::withCount('users')->latest()->paginate(10);
        $utilisateurs = User::with('cabine')->latest()->paginate(10);

        $stats = [
            'totalCabines' => Cabine::count(),
            'cabinesActives' => Cabine::where('est_actif', true)->count(),
            'totalUtilisateurs' => User::count(),
            'cabinesSaturees' => Cabine::get()->filter(function($cabine) {
                return !$cabine->peutAccepterUtilisateurs();
            })->count()
        ];

        return view('admin.dashboard', compact('cabines', 'utilisateurs', 'stats'));
    }

    public function savedCabineUsers()
    {
        $cabines = Cabine::orderBy('code', 'asc')->get();
        $utilisateurs = User::with('cabine')->latest()->paginate(10);

        $stats = [
            'totalCabines' => Cabine::count(),
            'cabinesActives' => Cabine::where('est_actif', true)->count(),
            'totalUtilisateurs' => User::count(),
            'cabinesSaturees' => Cabine::get()->filter(function($cabine) {
                return !$cabine->peutAccepterUtilisateurs();
            })->count()
        ];

        return view('admin.users', compact('cabines', 'utilisateurs', 'stats'));
    }

    public function store(Request $request)
    {
        if (!in_array(Auth::user()->role, ['superadmin', 'admin'])) {
            abort(403, 'Action non autorisée');
        }

        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'numero' => 'required|string',
            'cabine_id' => 'required|exists:cabines,id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            User::create([
                'nom' => $request->nom,
                'email' => $request->email,
                'numero' => $request->numero,
                'password' => Hash::make('Wimo@4045'),
                'cabine_id' => $request->cabine_id,
                'role' => 'responsable'
            ]);   
            
            return redirect()->back()->with('success', 'Utilisateur créé avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la création : ' . $e->getMessage())
                ->withInput();
        }
    }

    
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        $cabines = Cabine::orderBy('code', 'asc')->get();
        return view('admin.edit_user', compact('user','cabines'));
    }
   
public function update(Request $request, $id)
{
    if (!in_array(Auth::user()->role, ['superadmin', 'admin'])) {
        abort(403, 'Action non autorisée');
    }
    $user = User::findOrFail($id);

    $validator = Validator::make($request->all(), [
        'nom' => 'required|string|max:255',
        'email' => 'required|string|email|unique:users,email,' . $user->id, // exclure l’email actuel
        'numero' => 'required|string',
        'role' => 'required|in:user,responsable,admin,superadmin',
        'cabine_id' => 'required|exists:cabines,id',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    try {
        $user->update([
            'nom' => $request->nom,
            'email' => $request->email,
            'numero' => $request->numero,
            'role' => $request->role,
            'cabine_id' => $request->cabine_id,
        ]);

        return redirect()->route('admin.users')->with('success', 'Utilisateur mis à jour avec succès.');
    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Erreur lors de la mise à jour : ' . $e->getMessage())
            ->withInput();
    }
}

    public function destroy($id)
    {
        
    if (Auth::user()->role !== 'superadmin') {
        abort(403, 'Action non autorisée');
    }
        $user = User::findOrFail($id);

        try {
            if($user->role === 'superadmin')
            return back()->with('error', 'Impossible de supprimer le super Administrateur');
        
            $user->delete();
            return redirect()->back()->with('success', 'Utilisateur supprimé avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }
    }
   
public function resetPassword($id)
{
    if (Auth::user()->role !== 'superadmin') {
        abort(403, 'Action non autorisée');
    }

    $user = User::findOrFail($id);

    // Ne pas autoriser la réinitialisation du mot de passe d'un superadmin cible
    if ($user->role === 'superadmin') {
        return back()->with('error', 'Impossible de réinitialiser ce mot de passe.');
    }

    $user->password = Hash::make('Wimo@4045');
    $user->save();

    return redirect()->back()->with('success', 'Mot de passe réinitialisé avec succès.');
}
   
}
