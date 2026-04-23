<?php

namespace App\Services;

use App\Models\Vente;
use App\Models\LigneVente;
use App\Models\Produit;
use App\Models\Mouvement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Notifications_stock;

class VenteService
{
    /**
     * Crée une vente et ses lignes en conservant le prix d'achat au moment de la vente.
     * $data doit contenir : type_client, nom_client, contact_client, mode_paiement, montant_regle, user_id, cabine_id, lignes[]
     * chaque ligne : produit_id, quantite, prix_unitaire
     */
    public function creerVente(array $data): Vente
    {
        return DB::transaction(function () use ($data) {
            $lignes = $data['lignes'] ?? [];

            if (empty($lignes)) {
                throw new \Exception('Aucune ligne de vente fournie.');
            }

            // Utiliser l'utilisateur connecté et sa cabine
            $userId = auth()->id();
            $cabineId = auth()->user()->cabine_id ?? ($data['cabine_id'] ?? null);
            if (!$userId || !$cabineId) {
                throw new \Exception('Utilisateur ou cabine introuvable (authentification requise).');
            }

            $montantTotal = 0;

            $day = Carbon::now()->format('d');
            $increment = Vente::where('numero_vente', 'like', 'VENT-' . $day . '-%')->count() + 1;
            $increment = str_pad($increment, 4, '0', STR_PAD_LEFT);
            
            $vente = Vente::create([
                'numero_vente' =>  'VENT-' . $day . '-' . $increment,
                'receipt_number' => $data['receipt_number'] ?? null,
                'type_client' => $data['type_client'] ?? 'divers',
                'nom_client' => $data['nom_client'] ?? null,
                'contact_client' => $data['contact_client'] ?? null,
                'montant_total' => 0,
                'montant_regle' => isset($data['montant_regle']) ? (float) $data['montant_regle'] : 0,
                'montant_du' => 0,
                'mode_paiement' => $data['mode_paiement'] ?? 'especes',
                'est_complete' => $data['est_complete'] ?? true,
                'remarques' => $data['remarques'] ?? null,
                'user_id' => $userId,
                'cabine_id' => $cabineId,
            ]);

            foreach ($lignes as $ligne) {
                $produit = Produit::lockForUpdate()->find($ligne['produit_id'] ?? null);
                if (!$produit) {
                    throw new \Exception('Produit introuvable : ' . ($ligne['produit_id'] ?? ''));
                }

                $quantite = isset($ligne['quantite']) ? (int) $ligne['quantite'] : 0;
                if ($quantite <= 0) {
                    throw new \Exception("Quantité invalide pour le produit {$produit->nom}.");
                }

                if ($produit->quantite_stock < $quantite) {
                    throw new \Exception("Stock insuffisant pour {$produit->nom}. Disponible : {$produit->quantite_stock}.");
                }

                // prix_unitaire fourni sinon fallback sur prix_vente du produit
                $prixUnitaire = isset($ligne['prix_unitaire']) ? (float) $ligne['prix_unitaire'] : (float) $produit->prix_vente;
                $prixAchat = (float) $produit->prix_achat; // capture prix d'achat courant

                $sousTotal = $prixUnitaire * $quantite;
                $montantTotal += $sousTotal;

                // Créer la ligne en conservant prix_achat
                LigneVente::create([
                    'vente_id' => $vente->id,
                    'produit_id' => $produit->id,
                    'quantite' => $quantite,
                    'prix_unitaire' => $prixUnitaire,
                    'prix_achat' => $prixAchat,
                    'sous_total' => $sousTotal,
                ]);

                // Décrémenter le stock
                $produit->decrement('quantite_stock', $quantite);

                // Enregistrer mouvement stock
                Mouvement::create([
                    'produit_id' => $produit->id,
                    'type' => 'sortie',
                    'quantite' => $quantite,
                    'remarque' => 'Vente #' . $vente->numero_vente,
                    'user_id' => $userId,
                    'cabine_id' => $cabineId,
                ]);
            }

            $this->notifierStock($produit); 
            $vente->update([
                'montant_total' => $montantTotal,
                'montant_du' => max(0, ($vente->montant_regle ?? 0) - $montantTotal),
            ]);

            return $vente->load('lignes.produit', 'user');
        });
    }

     private function notifierStock(Produit $produit): void
    {
        if ($produit->quantite_stock <= 0) {
            Notifications_stock::updateOrCreate([
                'cabine_id' => $produit->cabine_id,
                'produit_id' => $produit->id,
                'type' => 'rupture',
            ], [
                'message' => "Rupture de stock pour le produit : {$produit->nom}",
                'vu' => false,
            ]);
        } elseif ($produit->quantite_stock <= $produit->seuil_alerte) {
            Notifications_stock::updateOrCreate([
                'cabine_id' => $produit->cabine_id,
                'produit_id' => $produit->id,
                'type' => 'faible',
            ], [
                'message' => "Stock faible pour le produit : {$produit->nom}",
                'vu' => false,
            ]);
        }
    }
}
