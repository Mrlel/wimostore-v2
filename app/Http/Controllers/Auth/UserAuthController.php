<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
{
    // Règles de validation
    $rules = [
        'nom' => 'required|string|min:2|max:50',
        'numero' => [
            'required',
            'string',
            'max:20',
            'regex:/^[\d\s\-\+\(\)]+$/',
        ],
        'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-z])(?=.*\d)(?=.*[\W_]).+$/', 'confirmed'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
        'nom_cab' => ['required', 'string', 'max:255'],
        'localisation' => ['required', 'string', 'max:255'],
        'accept_politique' => ['required', 'boolean'],
    ];

    // Messages d'erreur personnalisés
    $messages = [
        'nom.required' => 'Le nom complet est obligatoire.',
        'nom.regex' => 'Le nom ne doit contenir que des lettres et des espaces.',
        'nom.max' => 'Le nom ne peut pas dépasser 255 caractères.',
        
        'numero.required' => 'Le numéro de téléphone est obligatoire.',
        'numero.unique' => 'Ce numéro de téléphone est déjà utilisé.',
        'numero.regex' => 'Le format du numéro de téléphone est invalide. Exemples valides : +22501234567, 07012345, 01234567',
        'numero.max' => 'Le numéro ne peut pas dépasser 20 caractères.',
        
        'password.required' => 'Le mot de passe est obligatoire.',
        'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
        'password.regex' => 'Le mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre et un caractère spécial (@$!%*?&).',
        'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        
        'email.email' => 'L\'adresse email doit être valide.',
        'email.unique' => 'Cette adresse email est déjà utilisée.',
        'email.max' => 'L\'email ne peut pas dépasser 255 caractères.',
        
        'nom_cab.required' => 'Le nom de la boutique est obligatoire.',
        'nom_cab.max' => 'Le nom de la boutique ne peut pas dépasser 255 caractères.',
        
        'localisation.required' => 'La localisation est obligatoire.',
        'localisation.max' => 'La localisation ne peut pas dépasser 255 caractères.',
        
        'accept_politique.required' => 'Vous devez accepter la politique de confidentialité.',
        'accept_politique.boolean' => 'La valeur d\'acceptation de la politique est invalide.',
    ];

    $validated = $request->validate($rules, $messages);

    // Récupérer le code de parrainage si fourni
    $codeParrain = $request->input('code_parrain');
    $parrain = null;
    
    if ($codeParrain) {
        $parrain = User::where('code_parrain', $codeParrain)->first();
        if (!$parrain) {
            return back()->withErrors(['code_parrain' => 'Code de parrainage invalide.'])->withInput();
        }
    }

    $user = \Illuminate\Support\Facades\DB::transaction(function () use ($validated, $parrain) {
        // Création de la cabine
        $cabine = \App\Models\Cabine::create([
            'nom_cab' => $validated['nom_cab'],
            'localisation' => $validated['localisation'],
            'est_actif' => true,
            'type_compte' => 'standard',
            'max_utilisateurs' => 2,
        ]);

        // Créer un abonnement par défaut
        \App\Models\Abonnement::create([
            'cabine_id' => $cabine->id,
            'date_debut' => \Carbon\Carbon::now(),
            'date_fin' => \Carbon\Carbon::now()->addWeek(2),
            'statut' => 'actif',
            'montant' => 0,
        ]);

        // Création de l'utilisateur
        $user = User::create([
            'nom' => $validated['nom'],
            'numero' => $validated['numero'],
            'password' => $validated['password'],
            'role' => 'responsable',
            'cabine_id' => $cabine->id,
            'email' => $validated['email'],
            'password_changed_at' => \Carbon\Carbon::now(),
            'accept_politique' => $validated['accept_politique'],
            'parrain_id' => $parrain?->id,
        ]);

        // Générer le code de parrainage pour le nouvel utilisateur
        $user->genererCodeParrainage();

        // Créer le parrainage si un parrain existe
        if ($parrain) {
            \App\Models\Parrainage::create([
                'parrain_id' => $parrain->id,
                'filleul_id' => $user->id,
                'statut' => 'en_attente',
                'recompense_parrain' => 0, // À définir selon vos règles
                'recompense_filleul' => 0, // À définir selon vos règles
            ]);

            // Activer le parrainage après vérification (par exemple, après premier paiement)
            // Vous pouvez activer automatiquement ou après certaines conditions
        }

        return $user;
    });

    Auth::login($user);
    $request->session()->regenerate();

    return redirect()->route('dashboard')
        ->with('success', 'Inscription réussie ! Bienvenue sur votre tableau de bord.');
}



    public function showLoginForm()
    {
        return view('auth.login');
    }

   public function login(Request $request)
{
    // Validation des champs
    $credentials = $request->validate([
        'email' => ['required', 'string', 'email'],
        'password' => [
            'required',
            'string',
            'min:8',
            'regex:/^(?=.*[a-z])(?=.*\d)(?=.*[\W_]).+$/'
        ],
        'remember' => ['nullable'], 
    ]);

    $credentials = $request->validate([
    'email' => 'required|email|exists:users,email',
    'password' => 'required'
]);

        if (Auth::attempt($credentials, $request->has('remember'))) {
        $user = Auth::user(); // récupère l'utilisateur connecté
        $request->session()->regenerate();
        
        if (method_exists($user, 'mustChangePassword') && $user->mustChangePassword()) {
            return redirect()->route('password.change');
        }
        if ($user->role === 'admin' || $user->role === 'superadmin') {
            return redirect()->route('admin.dashboard');
        }
        if (($user->role === 'user' || $user->role === 'responsable')
            && $user->cabine
            && $user->cabine->est_actif === false
        ) {
            Auth::logout();
            return redirect()->route('comptebloque')->with('error', 'Connexion impossible! Veuillez contacter l\'administrateur');
        }

        return redirect()->route('dashboard')->with('success', 'Connexion réussie ! Bienvenue');
    }
    
    return back()->withErrors([
        'email' => 'Identifiants incorrects.',
    ])->withInput($request->only('email'));
}



    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.form');
    }

}
