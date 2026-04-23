<?php

namespace App\Services;

use App\Models\Vente;
use App\Models\Mouvement;
use App\Models\Produit;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RapportFinancierService
{
    /**
     * Calculer le chiffre d'affaires avec validation
     */
    private function calculerChiffreAffaires(int $cabineId, Carbon $dateDebut, Carbon $dateFin): array
    {
        $ventes = DB::table('ligne_ventes')
            ->join('ventes', 'ligne_ventes.vente_id', '=', 'ventes.id')
            ->where('ventes.cabine_id', $cabineId)
            ->where('ventes.est_complete', true)
            ->whereBetween('ventes.created_at', [$dateDebut, $dateFin->copy()->endOfDay()])
            ->select(
                DB::raw('SUM(ligne_ventes.prix_unitaire * ligne_ventes.quantite) as total'),
                DB::raw('SUM(CASE WHEN ventes.mode_paiement = "especes" THEN ligne_ventes.prix_unitaire * ligne_ventes.quantite ELSE 0 END) as especes'),
                DB::raw('SUM(CASE WHEN ventes.mode_paiement = "carte" THEN ligne_ventes.prix_unitaire * ligne_ventes.quantite ELSE 0 END) as carte'),
                DB::raw('SUM(CASE WHEN ventes.mode_paiement = "mobile" THEN ligne_ventes.prix_unitaire * ligne_ventes.quantite ELSE 0 END) as mobile'),
                DB::raw('SUM(CASE WHEN ventes.mode_paiement = "virement" THEN ligne_ventes.prix_unitaire * ligne_ventes.quantite ELSE 0 END) as virement'),
                DB::raw('SUM(CASE WHEN ventes.mode_paiement = "autre" THEN ligne_ventes.prix_unitaire * ligne_ventes.quantite ELSE 0 END) as autre')
            )
            ->first();

        return [
            'total' => (float) ($ventes->total ?? 0),
            'especes' => (float) ($ventes->especes ?? 0),
            'carte' => (float) ($ventes->carte ?? 0),
            'mobile' => (float) ($ventes->mobile ?? 0),
            'virement' => (float) ($ventes->virement ?? 0),
            'autre' => (float) ($ventes->autre ?? 0),
        ];
    }

    /**
     * Calculer le coût des marchandises vendues (CMV) SÉCURISÉ
     */
    private function calculerCMV(int $cabineId, Carbon $dateDebut, Carbon $dateFin): float
    {
        // Utilise le prix d'achat enregistré sur la ligne de vente s'il existe,
        // sinon retombe sur produits.prix_achat actuel (fallback).
        $cmv = DB::table('ligne_ventes')
            ->join('ventes', 'ligne_ventes.vente_id', '=', 'ventes.id')
            ->join('produits', 'ligne_ventes.produit_id', '=', 'produits.id')
            ->where('ventes.cabine_id', $cabineId)
            ->where('ventes.est_complete', true)
            ->whereBetween('ventes.created_at', [$dateDebut, $dateFin->copy()->endOfDay()])
            ->selectRaw('SUM(ligne_ventes.quantite * COALESCE(ligne_ventes.prix_achat, produits.prix_achat)) as cmv')
            ->value('cmv');

        $cmv = (float) ($cmv ?? 0);

        // Validation finale : CMV ne peut pas dépasser 95% du CA
        $chiffreAffaires = (float) $this->calculerChiffreAffaires($cabineId, $dateDebut, $dateFin)['total'];
        $cmvMaxAutorise = $chiffreAffaires * 0.95;

        if ($cmv > $cmvMaxAutorise) {
            \Log::warning('CMV corrigé automatiquement', [
                'cmv_calcule' => $cmv,
                'cmv_corrige' => $cmvMaxAutorise,
                'chiffre_affaires' => $chiffreAffaires,
                'cabine_id' => $cabineId,
                'periode' => $dateDebut->format('Y-m-d') . ' à ' . $dateFin->format('Y-m-d')
            ]);
            
            return (float) $cmvMaxAutorise;
        }

        return max(0.0, $cmv);
    }

    /**
     * Calculer les coûts fixes totaux avec validation
     */
    private function calculerCoutsFixesTotaux(array $coutsFixes): float
    {
        return array_sum([
            $coutsFixes['loyer'] ?? 0,
            $coutsFixes['electricite'] ?? 0,
            $coutsFixes['eau'] ?? 0,
            $coutsFixes['internet'] ?? 0,
            $coutsFixes['maintenance'] ?? 0,
            $coutsFixes['autres_charges'] ?? 0
        ]);
    }

    /**
     * Calculer toutes les données financières avec VALIDATIONS - CORRIGÉ
     */
    public function calculerDonneesFinancieres(int $cabineId, string $dateDebut, string $dateFin, array $coutsFixes = []): array
    {
        $dateDebut = Carbon::parse($dateDebut);
        $dateFin = Carbon::parse($dateFin);

        // Validation de la période
        if ($dateDebut->greaterThan($dateFin)) {
            throw new \Exception('La date de début ne peut pas être après la date de fin.');
        }

        // Chiffre d'affaires
        $chiffreAffaires = $this->calculerChiffreAffaires($cabineId, $dateDebut, $dateFin);
        
        // CMV sécurisé (utilise prix d'achat enregistré si présent)
        $cmv = (float) $this->calculerCMV($cabineId, $dateDebut, $dateFin);
        
        // Marges
        $margeBrute = (float) $chiffreAffaires['total'] - $cmv;
        $tauxMargeBrute = $chiffreAffaires['total'] > 0 ? min(100, max(-100, ($margeBrute / $chiffreAffaires['total']) * 100)) : 0;

        // Coûts fixes
        $coutsFixesTotal = $this->calculerCoutsFixesTotaux($coutsFixes);

        // Marge nette
        $margeNette = $margeBrute - (float) $coutsFixesTotal;
        $tauxMargeNette = $chiffreAffaires['total'] > 0 ? min(100, max(-100, ($margeNette / $chiffreAffaires['total']) * 100)) : 0;

        // Achats et Stocks
        $coutAchats = $this->calculerCoutAchats($cabineId, $dateDebut, $dateFin);
        $stocks = $this->calculerStocks($cabineId, $dateDebut, $dateFin);

        // Métriques
        $metriques = $this->calculerMetriques($cabineId, $dateDebut, $dateFin);

        // Log minimal
        $this->loggerValidationFinanciere([
            'cabine_id' => $cabineId,
            'periode' => $dateDebut->format('Y-m-d') . ' à ' . $dateFin->format('Y-m-d'),
            'chiffre_affaires' => (float) $chiffreAffaires['total'],
            'cmv' => $cmv,
            'marge_brute' => $margeBrute,
            'taux_marge_brute' => $tauxMargeBrute,
            'couts_fixes' => $coutsFixesTotal,
            'marge_nette' => $margeNette,
            'taux_marge_nette' => $tauxMargeNette
        ]);

        return [
            'chiffre_affaires_total' => (float) $chiffreAffaires['total'],
            'ventes_especes' => (float) $chiffreAffaires['especes'],
            'ventes_carte' => (float) $chiffreAffaires['carte'],
            'ventes_mobile' => (float) $chiffreAffaires['mobile'],
            'ventes_virement' => (float) $chiffreAffaires['virement'],
            'ventes_autre' => (float) $chiffreAffaires['autre'],

            'cout_marchandises_vendues' => $cmv,
            'couts_fixes_total' => (float) $coutsFixesTotal,
            'marge_brute' => (float) $margeBrute,
            'taux_marge_brute' => round($tauxMargeBrute, 2),
            'marge_nette' => (float) $margeNette,
            'taux_marge_nette' => round($tauxMargeNette, 2),

            'loyer' => $coutsFixes['loyer'] ?? 0,
            'electricite' => $coutsFixes['electricite'] ?? 0,
            'eau' => $coutsFixes['eau'] ?? 0,
            'internet' => $coutsFixes['internet'] ?? 0,
            'maintenance' => $coutsFixes['maintenance'] ?? 0,
            'autres_charges' => $coutsFixes['autres_charges'] ?? 0,

            'cout_achats_total' => (float) ($coutAchats['total'] ?? 0),
            'stock_initial' => (float) ($stocks['initial'] ?? 0),
            'stock_final' => (float) ($stocks['final'] ?? 0),

            'nombre_ventes' => (int) $metriques['nombre_ventes'],
            'nombre_produits_vendus' => (int) $metriques['nombre_produits_vendus'],
            'panier_moyen' => (float) round($metriques['panier_moyen'], 2),
            'produit_moyen_vendu' => (float) round($metriques['produit_moyen_vendu'], 2),
        ];
    }

    /**
     * Logger de validation financière - AMÉLIORÉ
     */
    private function loggerValidationFinanciere(array $data): void
    {
        // Alertes pour incohérences
        if ($data['taux_marge_brute'] < -50) {
            \Log::error('ALERTE: Marge brute très négative', $data);
        }

        if ($data['taux_marge_nette'] < -100) {
            \Log::error('ALERTE: Marge nette catastrophique', $data);
        }

        if ($data['cmv'] > $data['chiffre_affaires'] * 0.9) {
            \Log::warning('CMV élevé détecté', $data);
        }

        if ($data['chiffre_affaires'] > 0 && abs($data['taux_marge_brute']) > 1000) {
            \Log::error('ALERTE: Taux de marge anormal', $data);
        }

        // Log des coûts fixes pour vérification
        \Log::info('Calcul financier complet', [
            'CA' => $data['chiffre_affaires'],
            'CMV' => $data['cmv'],
            'Marge_Brute' => $data['marge_brute'],
            'Taux_Marge_Brute' => $data['taux_marge_brute'],
            'Coûts_Fixes' => $data['couts_fixes'],
            'Marge_Nette' => $data['marge_nette'],
            'Taux_Marge_Nette' => $data['taux_marge_nette']
        ]);
    }

    /**
     * Calculer le coût total des achats avec validation
     */
    private function calculerCoutAchats(int $cabineId, Carbon $dateDebut, Carbon $dateFin): array
    {
        $achats = Mouvement::where('cabine_id', $cabineId)
            ->where('type', 'entree')
            ->where('motif', 'achat')
            ->whereBetween('date_mouvement', [$dateDebut, $dateFin->endOfDay()])
            ->sum('montant_total');

        // Validation des achats
        if ($achats > 10000000) { // 10 millions
            \Log::warning('Achats anormalement élevés détectés', [
                'montant' => $achats,
                'cabine_id' => $cabineId,
                'periode' => $dateDebut->format('Y-m-d') . ' à ' . $dateFin->format('Y-m-d')
            ]);
        }

        return [
            'total' => $achats ?? 0,
        ];
    }

    /**
     * Calculer la valeur des stocks initial et final SÉCURISÉ
     */
    private function calculerStocks(int $cabineId, Carbon $dateDebut, Carbon $dateFin): array
    {
        // Stock initial (au début de la période)
        $stockInitial = DB::table('mouvements')
            ->where('cabine_id', $cabineId)
            ->where('date_mouvement', '<', $dateDebut)
            ->selectRaw('SUM(
                CASE 
                    WHEN type = "entree" THEN quantite * prix_unitaire
                    WHEN type = "sortie" THEN -quantite * prix_unitaire
                    ELSE 0 
                END
            ) as valeur')
            ->value('valeur');

        // Stock final (à la fin de la période)
        $stockFinal = DB::table('mouvements')
            ->where('cabine_id', $cabineId)
            ->where('date_mouvement', '<=', $dateFin->endOfDay())
            ->selectRaw('SUM(
                CASE 
                    WHEN type = "entree" THEN quantite * prix_unitaire
                    WHEN type = "sortie" THEN -quantite * prix_unitaire
                    ELSE 0 
                END
            ) as valeur')
            ->value('valeur');

        // Validation : les stocks ne peuvent pas être négatifs
        $stockInitial = max(0, $stockInitial ?? 0);
        $stockFinal = max(0, $stockFinal ?? 0);

        return [
            'initial' => $stockInitial,
            'final' => $stockFinal,
        ];
    }

    /**
     * Calculer les métriques de performance CORRIGÉ
     */
    private function calculerMetriques(int $cabineId, Carbon $dateDebut, Carbon $dateFin): array
    {
        // Nombre de ventes
        $nombreVentes = Vente::where('cabine_id', $cabineId)
            ->where('est_complete', true)
            ->whereBetween('created_at', [$dateDebut, $dateFin->endOfDay()])
            ->count();

        // Nombre de produits vendus
        $nombreProduitsVendus = DB::table('ligne_ventes')
            ->join('ventes', 'ligne_ventes.vente_id', '=', 'ventes.id')
            ->where('ventes.cabine_id', $cabineId)
            ->where('ventes.est_complete', true)
            ->whereBetween('ventes.created_at', [$dateDebut, $dateFin->endOfDay()])
            ->sum('ligne_ventes.quantite');

        // CORRECTION : Panier moyen calculé depuis la même source que le CA
        $panierMoyen = 0;
        if ($nombreVentes > 0) {
            $chiffreAffairesTotal = DB::table('ligne_ventes')
                ->join('ventes', 'ligne_ventes.vente_id', '=', 'ventes.id')
                ->where('ventes.cabine_id', $cabineId)
                ->where('ventes.est_complete', true)
                ->whereBetween('ventes.created_at', [$dateDebut, $dateFin->endOfDay()])
                ->sum(DB::raw('ligne_ventes.prix_unitaire * ligne_ventes.quantite'));
            
            $panierMoyen = $chiffreAffairesTotal / $nombreVentes;
        }

        // Produit moyen vendu
        $produitMoyenVendu = 0;
        if ($nombreVentes > 0) {
            $produitMoyenVendu = $nombreProduitsVendus / $nombreVentes;
        }

        // Validation des métriques
        if ($panierMoyen > 1000000) { // 1 million
            \Log::warning('Panier moyen anormalement élevé', [
                'panier_moyen' => $panierMoyen,
                'nombre_ventes' => $nombreVentes,
                'cabine_id' => $cabineId
            ]);
        }

        return [
            'nombre_ventes' => $nombreVentes,
            'nombre_produits_vendus' => $nombreProduitsVendus,
            'panier_moyen' => $panierMoyen,
            'produit_moyen_vendu' => $produitMoyenVendu,
        ];
    }

    /**
     * Calculer les marges nettes (après coûts fixes) SÉCURISÉ
     */
    public function calculerMargeNette(array $donneesFinancieres, array $coûtsFixes): array
    {
        $coûtsFixesTotal = array_sum($coûtsFixes);
        
        // Validation des coûts fixes
        if ($coûtsFixesTotal > 1000000) {
            throw new \Exception('Les coûts fixes semblent anormalement élevés.');
        }

        // CORRECTION : Utiliser la marge brute des données financières
        $margeNette = $donneesFinancieres['marge_brute'] - $coûtsFixesTotal;
        
        // Validation de la marge nette
        $tauxMargeNette = $donneesFinancieres['chiffre_affaires_total'] > 0 
            ? min(100, max(-100, ($margeNette / $donneesFinancieres['chiffre_affaires_total']) * 100))
            : 0;

        return [
            'marge_nette' => $margeNette,
            'taux_marge_nette' => round($tauxMargeNette, 2),
            'coûts_fixes_total' => $coûtsFixesTotal,
        ];
    }

    /**
     * Générer un rapport de synthèse SÉCURISÉ - CORRIGÉ
     */
    public function genererRapportSynthese(int $cabineId, Carbon $dateDebut, Carbon $dateFin, array $coutsFixes = []): array
    {
        try {
            // CORRECTION : Inclure les coûts fixes dans le calcul
            $donnees = $this->calculerDonneesFinancieres(
                $cabineId, 
                $dateDebut->format('Y-m-d'), 
                $dateFin->format('Y-m-d'),
                $coutsFixes  // ← COÛTS FIXES AJOUTÉS
            );
            
            // Validation des données avant retour
            if ($donnees['taux_marge_brute'] < -100 || $donnees['taux_marge_brute'] > 100) {
                \Log::error('Données incohérentes dans le rapport de synthèse', $donnees);
                throw new \Exception('Données financières incohérentes détectées.');
            }

            return [
                'periode' => $dateDebut->format('d/m/Y') . ' - ' . $dateFin->format('d/m/Y'),
                'chiffre_affaires' => $donnees['chiffre_affaires_total'],
                'cout_achats' => $donnees['cout_achats_total'],
                'marge_brute' => $donnees['marge_brute'],
                'taux_marge_brute' => $donnees['taux_marge_brute'],
                'marge_nette' => $donnees['marge_nette'],  // ← AJOUTÉ
                'taux_marge_nette' => $donnees['taux_marge_nette'],  // ← AJOUTÉ
                'couts_fixes' => $donnees['couts_fixes_total'],  // ← AJOUTÉ
                'nombre_ventes' => $donnees['nombre_ventes'],
                'panier_moyen' => $donnees['panier_moyen'],
                'statut' => 'valide'
            ];

        } catch (\Exception $e) {
            \Log::error('Erreur génération rapport synthèse', [
                'error' => $e->getMessage(),
                'cabine_id' => $cabineId,
                'periode' => $dateDebut->format('Y-m-d') . ' à ' . $dateFin->format('Y-m-d')
            ]);

            return [
                'periode' => $dateDebut->format('d/m/Y') . ' - ' . $dateFin->format('d/m/Y'),
                'chiffre_affaires' => 0,
                'cout_achats' => 0,
                'marge_brute' => 0,
                'taux_marge_brute' => 0,
                'marge_nette' => 0,
                'taux_marge_nette' => 0,
                'couts_fixes' => 0,
                'nombre_ventes' => 0,
                'panier_moyen' => 0,
                'statut' => 'erreur',
                'erreur' => $e->getMessage()
            ];
        }
    }

    /**
     * Vérifier la cohérence des données avant calcul
     */
    public function verifierCohérenceDonnees(int $cabineId, string $dateDebut, string $dateFin): array
    {
        $dateDebut = Carbon::parse($dateDebut);
        $dateFin = Carbon::parse($dateFin);

        $verifications = [];

        // Vérifier s'il y a des ventes
        $nombreVentes = Vente::where('cabine_id', $cabineId)
            ->where('est_complete', true)
            ->whereBetween('created_at', [$dateDebut, $dateFin->endOfDay()])
            ->count();
        $verifications['ventes_existantes'] = $nombreVentes > 0;

        // Vérifier les produits avec prix incohérents
        $produitsIncoherents = DB::table('produits')
            ->where('cabine_id', $cabineId)
            ->where('actif', true)
            ->where(function($query) {
                $query->where('prix_achat', '<=', 0)
                      ->orWhere('prix_vente', '<=', 0)
                      ->orWhereRaw('prix_achat > prix_vente');
            })
            ->count();
        $verifications['produits_coherents'] = $produitsIncoherents === 0;

        // Vérifier la période
        $verifications['periode_valide'] = !$dateDebut->greaterThan($dateFin);

        return $verifications;
    }
}