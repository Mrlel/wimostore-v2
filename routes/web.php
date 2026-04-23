<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\CabineController;
use App\Http\Controllers\NumeroController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\RechargeController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\MouvementStockController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\MouvementController;
use App\Http\Controllers\VenteController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InventaireController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\DashboardVendeurController;
use App\Http\Controllers\BoutiqueController;
use App\Http\Controllers\RapportFinancierController;
use App\Http\Controllers\PasswordChangeController;
use App\Http\Controllers\GestionnaireController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\AbonnementController;
use App\Http\Controllers\MarketplaceController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Http\Controllers\CertificationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ParrainageController;
use App\Http\Controllers\AbonnementPaiementController;
use App\Http\Controllers\CommandeController;







// Renouvellement mensuel
Route::get('/cabine/{cabine}/renouveler', [AbonnementPaiementController::class, 'renouveler'])->name('abonnement.renouveler');
Route::post('/cabine/{cabine}/initier-renouvellement', [AbonnementPaiementController::class, 'initierRenouvellement'])->name('abonnement.initierRenouvellement');
Route::get('/paiement/checkout/{paiement}', [AbonnementPaiementController::class, 'checkout'])->name('paiement.checkout');
Route::get('/paiement/verify', [AbonnementPaiementController::class, 'verify'])->name('paiement.verify');
Route::get('/paiement/failed/{paiement}', [AbonnementPaiementController::class, 'failed'])->name('paiement.failed');
Route::get('/abonnement/success/{abonnement}', [AbonnementPaiementController::class, 'success'])->name('abonnement.success');

// Webhook
Route::post('/api/webhook/fedapay', [AbonnementPaiementController::class, 'webhook'])->name('paiement.webhook');

Route::get('/recu/{vente}', [VenteController::class, 'voirRecuPublic'])
    ->name('recu.public');
    
Route::get('/marketplace', [MarketplaceController::class, 'index'])->name('marketplace');
Route::get('/panier', [MarketplaceController::class, 'panier'])->name('panier');

Route::get('password/forgot', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [PasswordResetController::class, 'reset'])->name('reset.password');


Route::middleware('auth')->group(function () {
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/dashboard', [DashboardVendeurController::class, 'dashboard'])->name('dashboard');
});
// Route pour vérifier l'email quand l'utilisateur clique sur le lien
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('dashboard')->with('success', 'Email vérifié avec succès');
})->middleware(['auth','signed'])->name('verification.verify');

// Re-envoyer l'email de vérification
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Email de vérification renvoyé.');
})->middleware(['auth','throttle:6,1'])->name('verification.send');


Route::middleware(['auth'])->group(function () {
    Route::get('/paiement', [PaiementController::class, 'form'])->name('paiements.form');
});

Route::get('/paiement/success', [PaiementController::class, 'success'])->name('paiements.success');
Route::post('/paiement/success', [PaiementController::class, 'success']); // accepter POST aussi

Route::post('/paiement/checkout', [PaiementController::class, 'checkout'])
    ->middleware('auth')
    ->name('paiements.checkout');

Route::post('/certification/checkout', [PaiementController::class, 'checkoutCertification'])->name('certification.checkout');
// Optionnel: endpoint manuel pour vérifier un statut par token
// Route::post('/paiement/check/{abonnement}', [PaiementController::class, 'checkStatus'])->name('paiements.check');


Route::get('/comptebloque', function() {
    $user = auth()->user();
    $cabine = $user->cabine ?? null;
    return view('comptebloque', compact('cabine'));
})->name('comptebloque');


Route::get('/comptesuspendu', function () {
    return view('comptesuspendu');
})->name('comptesuspendu');

Route::get('/offline', function () {
    return view('public.offline');
})->name('off');

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
});

// Page publique "En savoir plus"
Route::get('/en-savoir-plus', function () {
    return view('en_savoir_plus');
})->name('about');

// Authentification
Route::get('/login', [UserAuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [UserAuthController::class, 'login'])->name('login')->middleware('throttle:5,1');
Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');
Route::get('/register', [UserAuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [UserAuthController::class, 'register'])->name('register');
Route::view('/politique-confidentialite', 'politique')->name('politique.confidentialite');


// Routes pour le changement de mot de passe obligatoire
Route::middleware(['auth'])->group(function () {
    Route::get('/password/change', [PasswordChangeController::class, 'showChangeForm'])->name('password.change');
    Route::post('/password/change', [PasswordChangeController::class, 'updatePassword'])->name('password.update')->middleware('throttle:5,1');
});

// Espace public accessible sans connexion
Route::get('/boutique/{code}', [BoutiqueController::class, 'showPublic'])
     ->middleware('track.visits')
     ->name('cabine.public');
     
Route::get('/boutique/{code}/produits', [BoutiqueController::class, 'showPublicProduits'])
     ->middleware('track.visits')
     ->name('cabine.public.produits');

Route::get('/boutique/{code}/produits/{id}', [BoutiqueController::class, 'showDetailsProduit'])
     ->middleware('track.visits')
     ->name('details.produit');

// ─── Panier & Commandes (publiques, basées sur session) ───────────────────
Route::prefix('boutique/{code}')->name('boutique.')->group(function () {
    Route::get('/panier',                [CommandeController::class, 'voirPanier'])->name('panier');
    Route::get('/commander',             [CommandeController::class, 'checkout'])->name('checkout');
    Route::get('/suivi',                 [CommandeController::class, 'suivi'])->name('suivi');
    Route::get('/confirmation/{numero}', [CommandeController::class, 'confirmation'])->name('commande.confirmation');
    Route::get('/panier/count',          [CommandeController::class, 'countPanier'])->name('panier.count');
    Route::get('/panier/data',           [CommandeController::class, 'getPanier'])->name('panier.data');

    Route::post('/panier/ajouter',   [CommandeController::class, 'ajouterAuPanier'])->name('panier.ajouter');
    Route::post('/panier/mettre-a-jour', [CommandeController::class, 'mettreAJour'])->name('panier.update');
    Route::post('/panier/supprimer', [CommandeController::class, 'supprimerDuPanier'])->name('panier.supprimer');
    Route::post('/commander',        [CommandeController::class, 'passerCommande'])->name('commande.passer');
});

// Routes publiques pour les produits
Route::get('/produits/search', [ProduitController::class, 'search'])
    ->name('produits.search');

// Routes pour les cabines (publiques) - AJOUT DE UPDATE

// Routes pour les pages de cabine (protégées par auth)
Route::middleware(['auth'])->group(function () {
    Route::resource('cabine_pages', BoutiqueController::class)->except(['show']);
    Route::resource('cabines', CabineController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy']);
    Route::get('/gestion/cabine', [CabineController::class, 'gestion'])->name('gestion.cabine');

});

// Redirection de compatibilité après les routes resource pour éviter de matcher 'create', 'edit', etc.
Route::get('/cabine_pages/{code}', function ($code) {
    return redirect()->route('cabine.public', ['code' => $code]);
})->where('code', '[A-Za-z0-9\-]+');

Route::prefix('admin')->middleware(['auth', 'force.password.change'])->group(function () {

    Route::get('/parrainage', [ParrainageController::class, 'index'])->name('parrainage.index');
    Route::post('/abonnements/{id}/renouveler-manuel', [AbonnementController::class, 'renouvelerManuellement'])
    ->name('abonnements.renouveler.manuel');

    Route::get('users/{id}/reset-password', [AdminController::class, 'resetPassword'])->name('reset-password');
    Route::get('users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/users', [AdminController::class, 'savedCabineUsers'])->name('admin.users');
    Route::patch('/cabines/{cabine}/toggle', [CabineController::class, 'toggleCabine'])->name('admin.cabines.toggle');
    Route::post('/cabines/{cabine}', [CabineController::class, 'updateCabine'])->name('admin.cabines.update');
    Route::get('/cabines/{cabine}/edit', [CabineController::class, 'edit'])->name('cabines.edit');
    Route::resource('/users', AdminController::class)->only(['store','update','destroy','show'])->names('admin.users');
    Route::resource('/cabines', CabineController::class)->only(['store','destroy','show'])->names('admin.cabines');
    Route::get('/cabines/{cabine}/qr', [CabineController::class, 'downloadQr'])->name('cabines.qr.download');
    Route::get('/cabines/{cabine}/users', [AdminController::class, 'getCabineUsers'])->name('admin.cabines.users');

    Route::post('/certifierAdmin/{id}', [CertificationController::class, 'certifierParAdmin'])->name('certification.certifierAdmin');    
    Route::post('/desertifierAdmin/{id}', [CertificationController::class, 'desertifierParAdmin'])->name('certification.desertifierAdmin');    
});

// Routes pour les abonnements
Route::get('/abonnements', [AbonnementController::class, 'userAbonnement'])->name('admin.abonnements');


// API: Renouvellement manuel d'un abonnement (JSON)
Route::post('/abonnements/renouveler', [AbonnementController::class, 'renew'])
    ->middleware(['auth'])
    ->name('abonnements.renew');

// Groupe protégé par abonnement actif
Route::middleware(['auth', 'force.password.change', 'check.abonnement'])->group(function () {
    Route::get('/certification', [CertificationController::class, 'index'])->name('certification.index');
    Route::post('/certification/demander', [CertificationController::class, 'demander'])->name('certification.demander');
    Route::get('/certification/verifier-eligibilite/{id}', [CertificationController::class, 'verifierEligibilite'])->name('certification.verifier-eligibilite');

    
    Route::get('/boutique/{code}/visites', [BoutiqueController::class, 'visites'])
     ->name('visites');
    Route::resource('gestionnaires', GestionnaireController::class)->except(['show'])->middleware('can:manage-gestionnaires');
    Route::get('Ma_boutique', [BoutiqueController::class, 'Ma_boutique'])->name('Ma_boutique');
    Route::get('Ma_boutique/create', [BoutiqueController::class, 'Ma_boutique_create'])->name('Ma_boutique.create');
    Route::post('Ma_boutique', [BoutiqueController::class, 'Ma_boutique_store'])->name('Ma_boutique.store');
    Route::get('Ma_boutique/{boutique}/edit', [BoutiqueController::class, 'Ma_boutique_edit'])->name('Ma_boutique.edit');
    Route::put('Ma_boutique/{boutique}', [BoutiqueController::class, 'Ma_boutique_update'])->name('Ma_boutique.update');

    // Commandes boutique (admin)
    Route::get('/commandes-boutique', [CommandeController::class, 'adminIndex'])->name('commandes.boutique');
    Route::get('/commandes-boutique/{commande}', [CommandeController::class, 'adminShow'])->name('commandes.show');
    Route::patch('/commandes-boutique/{commande}/statut', [CommandeController::class, 'updateStatut'])->name('commandes.statut');
    Route::get('/commandes-boutique/api/nouvelles', [CommandeController::class, 'nouvellesCommandes'])->name('commandes.nouvelles');
    Route::get('ventes/{vente}/imprimer', [VenteController::class, 'imprimer'])
    ->name('ventes.imprimer');
    
    Route::get('/dashboard', [DashboardVendeurController::class, 'dashboard'])->name('dashboard');

    Route::get('notif', [NotificationsController::class, 'notification'])->name('notifications');
    Route::post('/notifications/mark-as-read', [NotificationsController::class, 'markAllAsRead'])->name('notifications.markAsRead');
    Route::post('/notifications/{id}/mark-as-read', [NotificationsController::class, 'markAsRead'])->name('notifications.markAsReadSingle');
    Route::delete('/notifications/{id}', [NotificationsController::class, 'destroy'])->name('notifications.destroy');
    
    Route::get('/inventaire', [InventaireController::class, 'inventaire'])->name('inventaire');
    Route::get('/details_inventaire', [InventaireController::class, 'details_inventaire'])->name('details_inventaire');
    Route::get('/inventaire/pdf', [InventaireController::class, 'inventairePdf'])->name('inventaire.pdf');
    Route::delete('produits/images/{image}', [ProduitController::class, 'destroyImage'])
    ->name('produits.destroyImage');
    
    Route::resource('produits', ProduitController::class);
    Route::post('produits/{produit}/ajuster-stock', [ProduitController::class, 'ajusterStock'])
        ->name('produits.ajuster-stock');
        
    Route::post('produits/{produit}/publier', [ProduitController::class, 'publier'])
        ->name('produits.publier');
    Route::post('produits/{produit}/despublier', [ProduitController::class, 'despublier'])
        ->name('produits.despublier');
    Route::resource('ventes', VenteController::class)->except(['edit', 'update']);
    Route::get('ventes/{vente}/edit', [VenteController::class, 'edit'])->name('ventes.edit');
    Route::put('ventes/{vente}', [VenteController::class, 'update'])->name('ventes.update');

    Route::resource('categories', CategorieController::class)
    ->parameters(['categories' => 'categorie']);
    Route::resource('mouvements', MouvementController::class)->except(['edit', 'update']);
    Route::post('produits/{produit}/reapprovisionner', [MouvementController::class, 'reapprovisionner'])
        ->name('produits.reapprovisionner');
        
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::get('/profile', function () {
        return view('profile.show');
    })->name('profile.show');

    Route::get('/guide', function () {
        return view('guide');
    })->name('guide');

    // Routes pour les reçus
    Route::prefix('receipts')->group(function () {
        Route::get('/', [ReceiptController::class, 'index'])->name('receipts.index');
        Route::get('/stats', [ReceiptController::class, 'stats'])->name('receipts.stats');
        Route::get('/{hash}', [ReceiptController::class, 'show'])->name('receipts.show');
        Route::get('/{hash}/download', [ReceiptController::class, 'download'])->name('receipts.download');
        Route::post('/{hash}/viewed', [ReceiptController::class, 'markAsViewed'])->name('receipts.viewed');
        Route::post('/{hash}/email', [ReceiptController::class, 'sendEmail'])->name('receipts.email');
    });

    // Routes pour les rapports financiers
    Route::prefix('rapports-financiers')->name('rapports-financiers.')->group(function () {
        Route::get('/', [RapportFinancierController::class, 'index'])->name('index');
        Route::get('/create', [RapportFinancierController::class, 'create'])->name('create');
        Route::post('/', [RapportFinancierController::class, 'store'])->name('store');
        Route::get('/{rapport}', [RapportFinancierController::class, 'show'])->name('show');
        Route::get('/{rapport}/edit', [RapportFinancierController::class, 'edit'])->name('edit');
        Route::put('/{rapport}', [RapportFinancierController::class, 'update'])->name('update');
        Route::delete('/{rapport}', [RapportFinancierController::class, 'destroy'])->name('destroy');
        Route::post('/{rapport}/valider', [RapportFinancierController::class, 'valider'])->name('valider');
        Route::post('/{rapport}/annuler-validation', [RapportFinancierController::class, 'annulerValidation'])->name('annuler-validation');
        Route::get('/{rapport}/export-pdf', [RapportFinancierController::class, 'exportPdf'])->name('export-pdf');
        Route::get('/{rapport}/export-excel', [RapportFinancierController::class, 'exportExcel'])->name('export-excel');
    });
});
