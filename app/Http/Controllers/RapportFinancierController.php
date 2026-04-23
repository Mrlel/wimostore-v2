<?php

namespace App\Http\Controllers;

use App\Models\RapportFinancier;
use App\Models\Cabine;
use App\Services\RapportFinancierService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RapportFinancierController extends Controller
{
    protected $rapportService;

    public function __construct(RapportFinancierService $rapportService)
    {
        $this->rapportService = $rapportService;
    }

    /**
     * Afficher la liste des rapports financiers
     */
    public function index(Request $request)
    {
        $query = RapportFinancier::with(['cabine', 'user', 'validePar'])->where('cabine_id', auth()->user()->cabine_id);

        // Filtres
        if ($request->filled('cabine_id')) {
            $query->where('cabine_id', $request->cabine_id);
        }

        if ($request->filled('type_rapport')) {
            $query->where('type_rapport', $request->type_rapport);
        }

        if ($request->filled('date_debut')) {
            $query->where('date_debut', '>=', $request->date_debut);
        }

        if ($request->filled('date_fin')) {
            $query->where('date_fin', '<=', $request->date_fin);
        }

        if ($request->filled('est_valide')) {
            $query->where('est_valide', $request->est_valide);
        }

        $rapports = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('rapports_financiers.index', compact('rapports'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        $typesRapport = ['quotidien', 'hebdomadaire', 'mensuel', 'annuel', 'personnalise'];
        
        return view('rapports_financiers.create', compact('typesRapport'));
    }

    /**
 * Créer un nouveau rapport financier
 */
public function store(Request $request)
{
    $request->validate([
        'date_debut' => 'required|date',
        'date_fin' => 'required|date|after_or_equal:date_debut',
        'type_rapport' => 'required|in:quotidien,hebdomadaire,mensuel,annuel,personnalise',
        'loyer' => 'nullable|numeric|min:0|max:1000000',
        'electricite' => 'nullable|numeric|min:0|max:100000',
        'eau' => 'nullable|numeric|min:0|max:50000',
        'internet' => 'nullable|numeric|min:0|max:50000',
        'maintenance' => 'nullable|numeric|min:0|max:100000',
        'autres_charges' => 'nullable|numeric|min:0|max:500000',
    ]);

    try {
        DB::beginTransaction();

        $coutsFixes = [
            'loyer' => $request->loyer ?? 0,
            'electricite' => $request->electricite ?? 0,
            'eau' => $request->eau ?? 0,
            'internet' => $request->internet ?? 0,
            'maintenance' => $request->maintenance ?? 0,
            'autres_charges' => $request->autres_charges ?? 0,
        ];

        // CORRECTION : Vérifier les limites des coûts fixes
        $totalCoutsFixes = array_sum($coutsFixes);
        if ($totalCoutsFixes > 1000000) {
            return back()->withInput()
                ->with('error', 'Le total des coûts fixes dépasse la limite autorisée.');
        }

        // Calculer les données financières
        $donneesFinancieres = $this->rapportService->calculerDonneesFinancieres(
            auth()->user()->cabine_id,
            $request->date_debut,
            $request->date_fin,
            $coutsFixes
        );

        // NOTE : On n'interdit plus une marge brute négative (peut représenter une perte réelle).
        // Si tu souhaites alerter l'utilisateur, ajoute une notification plutôt qu'une erreur bloquante.

        // Valider uniquement les taux totalement aberrants (>100% ou <-100%)
        if (isset($donneesFinancieres['taux_marge_brute']) && ($donneesFinancieres['taux_marge_brute'] > 100 || $donneesFinancieres['taux_marge_brute'] < -100)) {
            return back()->withInput()
                ->with('error', 'Données incohérentes : taux de marge brute hors limites.');
        }
        
        // Créer le rapport
        $rapport = RapportFinancier::create([
            'cabine_id' => auth()->user()->cabine_id,
            'user_id' => Auth::id(),
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'type_rapport' => $request->type_rapport,
            'loyer' => $coutsFixes['loyer'],
            'electricite' => $coutsFixes['electricite'],
            'eau' => $coutsFixes['eau'],
            'internet' => $coutsFixes['internet'],
            'maintenance' => $coutsFixes['maintenance'],
            'autres_charges' => $coutsFixes['autres_charges'],
            'remarques' => $request->remarques,
            ...$donneesFinancieres
        ]);

        DB::commit();

        return redirect()->route('rapports-financiers.show', $rapport)
            ->with('success', 'Rapport financier créé avec succès !');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withInput()
            ->with('error', 'Erreur lors de la création du rapport : ' . $e->getMessage());
    }
}

    /**
     * Afficher un rapport financier
     */
    public function show(RapportFinancier $rapport)
    {
        $rapport->load(['cabine', 'user', 'validePar']);
        
        return view('rapports_financiers.show', compact('rapport'));
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(RapportFinancier $rapport)
    {
        if ($rapport->est_valide) {
            return back()->with('error', 'Impossible de modifier un rapport validé.');
        }
        $typesRapport = ['quotidien', 'hebdomadaire', 'mensuel', 'annuel', 'personnalise'];
        
        return view('rapports_financiers.edit', compact('rapport','typesRapport'));
    }

    /**
     * Mettre à jour un rapport financier
     */
    public function update(Request $request, RapportFinancier $rapport)
    {
        if ($rapport->est_valide) {
            return back()->with('error', 'Impossible de modifier un rapport validé.');
        }

        $request->validate([
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'type_rapport' => 'required|in:quotidien,hebdomadaire,mensuel,annuel,personnalise',
            'loyer' => 'nullable|numeric|min:0',
            'electricite' => 'nullable|numeric|min:0',
            'eau' => 'nullable|numeric|min:0',
            'internet' => 'nullable|numeric|min:0',
            'maintenance' => 'nullable|numeric|min:0',
            'autres_charges' => 'nullable|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            // Recalculer les données financières
            $coutsFixes = [
                'loyer' => $request->loyer,
                'electricite' => $request->electricite,
                'eau' => $request->eau,
                'internet' => $request->internet,
                'maintenance' => $request->maintenance,
                'autres_charges' => $request->autres_charges,
            ];

            $donneesFinancieres = $this->rapportService->calculerDonneesFinancieres(
                auth()->user()->cabine_id,
                $request->date_debut,
                $request->date_fin,
                $coutsFixes
            );

            // Mettre à jour le rapport
            $rapport->update([
                'date_debut' => $request->date_debut,
                'date_fin' => $request->date_fin,
                'type_rapport' => $request->type_rapport,
                'loyer' => $request->loyer ?? 0,
                'electricite' => $request->electricite ?? 0,
                'eau' => $request->eau ?? 0,
                'internet' => $request->internet ?? 0,
                'maintenance' => $request->maintenance ?? 0,
                'autres_charges' => $request->autres_charges ?? 0,
                'remarques' => $request->remarques,
                ...$donneesFinancieres
            ]);

            DB::commit();

            return redirect()->route('rapports-financiers.show', $rapport)
                ->with('success', 'Rapport financier mis à jour avec succès !');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Erreur lors de la mise à jour du rapport : ' . $e->getMessage());
        }
    }

    /**
     * Valider un rapport financier
     */
    public function valider(Request $request, RapportFinancier $rapport)
    {
        $request->validate([
            'remarques' => 'nullable|string|max:1000'
        ]);

        $rapport->update([
            'est_valide' => true,
            'date_validation' => now(),
            'valide_par' => auth()->user()->id,
            'remarques' => $request->remarques ?? $rapport->remarques
        ]);

        return back()->with('success', 'Rapport validé avec succès !');
    }

    /**
     * Annuler la validation d'un rapport
     */
    public function annulerValidation(RapportFinancier $rapport)
    {
        $rapport->update([
            'est_valide' => false,
            'date_validation' => null,
            'valide_par' => null
        ]);

        return back()->with('success', 'Validation du rapport annulée !');
    }

    /**
     * Supprimer un rapport financier
     */
    public function destroy(RapportFinancier $rapport)
    {
        if ($rapport->est_valide) {
            return back()->with('error', 'Impossible de supprimer un rapport validé.');
        }

        $rapport->delete();

        return redirect()->route('rapports-financiers.index')
            ->with('success', 'Rapport financier supprimé avec succès !');
    }

    /**
     * Exporter un rapport en PDF
     */
   public function exportPdf(RapportFinancier $rapport)
{
    $rapport->load(['cabine', 'user', 'validePar']);

    $pdf = Pdf::loadView('rapports_financiers.pdf', compact('rapport'))
        ->setPaper('a4', 'portrait');

    $fileName = 'rapport_financier_' . ($rapport->cabine->nom_cab ?? 'cabine') . '_' .
        ($rapport->date_debut ? $rapport->date_debut->format('Ymd') : 'debut') . '_' .
        ($rapport->date_fin ? $rapport->date_fin->format('Ymd') : 'fin') . '.pdf';

    return $pdf->download($fileName);
}

public function exportExcel(RapportFinancier $rapport)
{
    $rapport->load(['cabine', 'user', 'validePar']);

    $filename = 'rapport_financier_' . ($rapport->cabine->nom_cab ?? 'cabine') . '_' .
        ($rapport->date_debut ? $rapport->date_debut->format('Ymd') : 'debut') . '_' .
        ($rapport->date_fin ? $rapport->date_fin->format('Ymd') : 'fin') . '.csv';

    $headers = [
        'Content-Type' => 'text/csv; charset=UTF-8',
        'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        'Cache-Control' => 'no-store, no-cache',
    ];

    $rows = [
        ['Boutique', $rapport->cabine->nom_cab ?? ''],
        ['Période', ($rapport->date_debut ? $rapport->date_debut->format('d/m/Y') : '') . ' - ' . ($rapport->date_fin ? $rapport->date_fin->format('d/m/Y') : '')],
        ['Généré par', $rapport->user->nom ?? ''],
        [],
        ["Chiffre d'Affaires Total", $rapport->chiffre_affaires_total ?? 0],
        ['Marge Brute', $rapport->marge_brute ?? 0],
        ['Taux Marge Brute (%)', $rapport->taux_marge_brute ?? 0],
        ['Marge Nette', $rapport->marge_nette ?? 0],
        ['Taux Marge Nette (%)', $rapport->taux_marge_nette ?? 0],
        [],
        ['Charges - Loyer', $rapport->loyer ?? 0],
        ['Charges - Electricité', $rapport->electricite ?? 0],
        ['Charges - Eau', $rapport->eau ?? 0],
        ['Charges - Internet', $rapport->internet ?? 0],
        ['Charges - Maintenance', $rapport->maintenance ?? 0],
        ['Charges - Autres', $rapport->autres_charges ?? 0],
        [],
        ['Indicateurs - Nombre de Ventes', $rapport->nombre_ventes ?? 0],
        ['Indicateurs - Articles Vendus', $rapport->nombre_produits_vendus ?? 0],
        ['Indicateurs - Panier Moyen', $rapport->panier_moyen ?? 0],
        ['Indicateurs - Articles/Vente', $rapport->produit_moyen_vendu ?? 0],
        [],
        ['Encaissements - Espèces', $rapport->ventes_especes ?? 0],
        ['Encaissements - Carte', $rapport->ventes_carte ?? 0],
        ['Encaissements - Mobile Money', $rapport->ventes_mobile ?? 0],
        ['Encaissements - Virement', $rapport->ventes_virement ?? 0],
        ['Encaissements - Autres', $rapport->ventes_autre ?? 0],
        [],
        ['Total coûts', ($rapport->cout_achats_total ?? 0) + ($rapport->couts_fixes_total ?? 0)],
        [],
        ['Validé', $rapport->est_valide ? 'Oui' : 'Non'],
        ['Date Validation', $rapport->date_validation ? $rapport->date_validation->format('d/m/Y H:i') : ''],
        ['Remarques', $rapport->remarques ?? ''],
    ];

    $handle = fopen('php://temp', 'w+');
    fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM UTF-8
    foreach ($rows as $row) {
        fputcsv($handle, $row, ';');
    }
    rewind($handle);
    $csv = stream_get_contents($handle);
    fclose($handle);

    return response($csv, 200, $headers);
}
}
