@extends('layouts.app')
@section('title', 'Détails de la Vente')
@section('content')
<div class="container-fluid py-4 bg-white">
    <!-- En-tête -->
    <div class="d-flex flex-column flex-md-row gap-3 justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 text-dark fw-bold">
                <i class="bi bi-receipt me-2" style="color: #fbc926;"></i>
                Détails de la Vente
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('ventes.index') }}">Ventes</a></li>
                    <li class="breadcrumb-item active" aria-current="page">N° {{ $vente->numero_vente }}</li>
                </ol>
            </nav>
        </div>
       
    </div>

    <div class="row">
        <!-- Informations principales -->
        <div class="col-lg-8">
            <!-- Carte des informations de la vente -->
            <div class="card border-0 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 text-dark fw-bold">
                        <i class="bi bi-info-circle me-2" style="color: #fbc926;"></i>
                        Informations de la vente
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Vente enregistrée par </label>
                            <p class="form-control-plaintext text-dark fw-bold">{{ $vente->user->nom }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Date de vente</label>
                            <p class="form-control-plaintext">{{ $vente->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Type de client</label>
                            <p class="form-control-plaintext text-capitalize">{{ $vente->type_client }}</p>
                        </div>
                        @if($vente->nom_client)
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Nom du client</label>
                            <p class="form-control-plaintext">{{ $vente->nom_client }}</p>
                        </div>
                        @endif
                        @if($vente->contact_client)
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Contact</label>
                            <p class="form-control-plaintext">{{ $vente->contact_client }}</p>
                        </div>
                        @endif
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Mode de paiement</label>
                            <p class="form-control-plaintext text-capitalize">{{ $vente->mode_paiement }}</p>
                        </div>
                        
                    </div>
                </div>
            </div>

            <!-- Carte des produits -->
            <div class="card border-0 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 text-dark fw-bold">
                        <i class="bi bi-basket me-2" style="color: #fbc926;"></i>
                        Produits vendus
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th class="border-dark">Produit</th>
                                    <th class="text-center border-dark">Quantité</th>
                                    <th class="text-end border-dark">Prix unitaire</th>
                                    <th class="text-end border-dark">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($vente->lignes as $ligne)
                                <tr>
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 bg-light rounded p-2 me-3">
                                                <i class="bi bi-box" style="color: #fbc926;"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-0">{{ $ligne->produit->nom }}</h6>
                                                <small class="text-muted">
                                                    @if($ligne->produit->marque)
                                                       {{ $ligne->produit->marque }} • {{ $ligne->produit->categorie->nom }}
                                                    @endif
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center align-middle">{{ $ligne->quantite }}</td>
                                    <td class="text-end align-middle">{{ number_format($ligne->prix_unitaire) }} FCFA</td>
                                    <td class="text-end align-middle fw-bold">{{ number_format($ligne->sous_total) }} FCFA</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-dark">
                                <tr>
                                    <td colspan="3" class="text-end fw-bold border-dark">Total</td>
                                    <td class="text-end fw-bold border-dark">{{ number_format($vente->montant_total) }} FCFA</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end fw-bold border-dark">Montant réglé</td>
                                    <td class="text-end fw-bold border-dark">{{ number_format($vente->montant_regle) }} FCFA</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end fw-bold border-dark">Rémise</td>
                                    <td class="text-end fw-bold border-dark">{{ number_format($vente->montant_regle - $vente->montant_total) }} FCFA</td>
                                </tr>

                                @if($vente->montant_total > $vente->montant_regle)
                                <tr class="table-warning">
                                    <td colspan="3" class="text-end fw-bold border-dark">Montant dû</td>
                                    <td class="text-end fw-bold border-dark">{{ number_format($vente->montant_total - $vente->montant_regle) }} FCFA</td>
                                </tr>
                                @endif
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Remarques -->
            @if($vente->remarques)
            <div class="card border-0 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 text-dark fw-bold">
                        <i class="bi bi-chat-dots me-2" style="color: #fbc926;"></i>
                        Remarques
                    </h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $vente->remarques }}</p>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar - Actions et informations -->
        <div class="col-lg-4">
            <!-- Carte des reçus -->
            @if($vente->numero_vente)
            <!-- Carte de génération de reçu -->
            <div class="card border-0 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 text-dark fw-bold">
                        <i class="bi bi-receipt me-2" style="color: #fbc926;"></i>
                        Générer le reçu
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">Cliquez sur le bouton ci-dessous pour voir le reçu de vente.</p>
                    <div class="d-grid gap-2">
                        <button onclick="generateReceipt()" class="btn text-dark fw-bold" style="background-color: #fbc926;">
                            <i class="bi bi-receipt me-2"></i> Voir le reçu
                        </button>
                    </div>
                </div>
            </div>
            
            @endif

            <!-- Carte des actions -->
            <div class="card border-0 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 text-dark fw-bold">
                        <i class="bi bi-lightning me-2" style="color: #fbc926;"></i>
                        Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('ventes.edit', $vente) }}" class="btn btn-outline-dark">
                            <i class="bi bi-pencil me-2"></i>Modifier la vente
                        </a>
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#annulerVenteModal">
                            <i class="bi bi-x-circle me-2"></i>Annuler la vente
                        </button>
                        <a href="{{ route('ventes.create') }}" class="btn btn-outline-dark"> <i class="bi bi-plus-circle me-2"></i>Nouvelle vente</a>
                    </div>
                </div>
            </div>

            <!-- Carte des statistiques 
            <div class="card border mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 text-dark fw-bold">
                        <i class="bi bi-graph-up me-2" style="color: #fbc926;"></i>
                        Statistiques
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Nombre d'articles</span>
                        <span class="fw-bold">{{ $vente->lignes->sum('quantite') }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Moyenne par article</span>
                        <span class="fw-bold">{{ number_format($vente->montant_total / $vente->lignes->sum('quantite')) }} FCFA</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Marge estimée</span>
                        <span class="fw-bold text-success">
                            @php
                                $coutTotal = 0;
                                foreach($vente->lignes as $ligne) {
                                    $coutTotal += $ligne->produit->prix_achat * $ligne->quantite;
                                }
                                $marge = $vente->montant_total - $coutTotal;
                            @endphp
                            +{{ number_format($marge) }} FCFA
                        </span>
                    </div>
                </div>
            </div>-->

            <!-- Carte des informations produit -->
            <div class="card border">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 text-dark fw-bold">
                        <i class="bi bi-box-seam me-2" style="color: #fbc926;"></i>
                        Impact sur le stock
                    </h5>
                </div>
                <div class="card-body">
                    @foreach($vente->lignes as $ligne)
                    <div class="mb-3 pb-2 border-bottom">
                        <h6 class="fw-semibold">{{ $ligne->produit->nom }}</h6>
                        <div class="d-flex justify-content-between">
                            <small class="text-muted">Stock avant:</small>
                            <small>{{ $ligne->produit->quantite_stock + $ligne->quantite }}</small>
                        </div>
                        <div class="d-flex justify-content-between">
                            <small class="text-muted">Stock après:</small>
                            <small class="{{ $ligne->produit->quantite_stock == 0 ? 'text-danger' : ($ligne->produit->quantite_stock <= $ligne->produit->seuil_alerte ? 'text-warning' : 'text-success') }}">
                                {{ $ligne->produit->quantite_stock }}
                                @if($ligne->produit->quantite_stock == 0)
                                    <i class="bi bi-exclamation-triangle"></i>
                                @endif
                            </small>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de partage du reçu -->
@if($vente->receipt_hash)
<div class="modal fade" id="shareReceiptModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">Partager le reçu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="shareUrl" class="form-label">Lien du reçu</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="shareUrl" 
                               value="{{ route('receipts.show', $vente->receipt_hash) }}" readonly>
                        <button class="btn btn-outline-secondary" type="button" onclick="copyShareUrl()">
                            <i class="bi bi-copy"></i>
                        </button>
                    </div>
                </div>
                <div class="d-grid gap-2">
                    <button class="btn btn-primary" onclick="shareReceipt()">
                        <i class="bi bi-share me-2"></i>Partager via l'appareil
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal d'envoi par email -->
<div class="modal fade" id="emailReceiptModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">Envoyer le reçu par email</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('receipts.email', $vente->receipt_hash) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="email" class="form-label">Adresse email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- Modal d'annulation de vente -->
<div class="modal fade" id="annulerVenteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">Annuler la vente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir annuler cette vente ? Cette action réapprovisionnera le stock des produits et ne peut pas être annulée.</p>
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>Attention:</strong> Tous les produits seront remis en stock.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Retour</button>
                <form action="{{ route('ventes.destroy', $vente) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i>Confirmer l'annulation
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

<script>
    // Générer le reçu
    function generateReceipt() {
        if (confirm('Voulez-vous générer un reçu pour cette vente ?')) {
            // Rediriger vers la page de génération de reçu
            window.location.href = "{{ route('ventes.imprimer', $vente) }}";
        }
    }

    // Copier l'URL de partage
    function copyShareUrl() {
        const shareUrl = document.getElementById('shareUrl');
        shareUrl.select();
        document.execCommand('copy');
        
        // Afficher une notification
        const button = event.target.closest('button');
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="bi bi-check"></i>';
        button.classList.add('btn-success');
        button.classList.remove('btn-outline-secondary');
        
        setTimeout(() => {
            button.innerHTML = originalText;
            button.classList.remove('btn-success');
            button.classList.add('btn-outline-secondary');
        }, 2000);
    }

    // Partager le reçu
    function shareReceipt() {
        const shareUrl = "#";
        
        if (navigator.share) {
            navigator.share({
                title: 'Reçu de vente - {{ $vente->receipt_number }}',
                text: 'Voici votre reçu d\'achat',
                url: shareUrl
            }).catch(error => {
                console.log('Erreur de partage:', error);
            });
        } else {
            // Fallback: copier dans le presse-papiers
            copyShareUrl();
        }
    }
</script>

<style>
    .card {
        border: 2px solid #000;
    }
    
    .card-header {
        border-bottom: 2px solid #000 !important;
    }
    
    .table th, .table td {
        border-color: #000 !important;
    }
    
    .btn:hover {
        opacity: 0.9;
    }
    
    .border-bottom {
        border-color: #fbc926 !important;
    }
    
    .breadcrumb {
        background-color: transparent;
        padding: 0;
    }
    
    .badge {
        font-size: 0.85em;
    }
</style>
@endsection