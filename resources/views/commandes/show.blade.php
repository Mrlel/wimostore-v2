@extends('layouts.app')
@section('title', 'Commande ' . $commande->numero_commande)

@section('content')

<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3 flex-wrap">
    <div>
        <a href="{{ route('commandes.boutique') }}" class="btn btn-outline-dark btn-sm mb-2">
            <i class="bi bi-arrow-left me-1"></i> Retour
        </a>
        <h1 class="h2 text-dark fw-bold d-flex align-items-center flex-wrap gap-2">
            <i class="bi bi-bag-check"></i>
            Commande
            <code style="font-size:14px;background:#f0f0f0;padding:4px 10px;border-radius:8px;">
                {{ $commande->numero_commande }}
            </code>
        </h1>
        <p class="text-muted mb-0">{{ $commande->created_at->format('d/m/Y à H:i') }}</p>
    </div>
    <span class="badge rounded-pill px-3 py-2 fs-6"
          style="background:{{ $commande->statut_color }}22;color:{{ $commande->statut_color }};border:1px solid {{ $commande->statut_color }}55;">
        {{ $commande->statut_label }}
    </span>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" style="border-radius:12px;">
    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="row g-4">

    {{-- Colonne gauche --}}
    <div class="col-lg-8">

        {{-- Articles --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;overflow:hidden;">
            <div class="card-header bg-white border-bottom py-3 d-flex align-items-center">
                <i class="bi bi-box-seam me-2" style="color:#fbc926;font-size:18px;"></i>
                <h5 class="mb-0 fw-bold">Articles commandés</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-3">Produit</th>
                            <th class="text-center">Qté</th>
                            <th class="text-end">Prix unit.</th>
                            <th class="text-end pe-3">Sous-total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($commande->lignes as $ligne)
                        <tr>
                            <td class="ps-3">
                                <div class="d-flex align-items-center gap-2">
                                    @php $img = $ligne->produit?->images?->last()?->path; @endphp
                                    @if($img)
                                    <img src="{{ asset('storage/'.$img) }}" alt=""
                                         style="width:44px;height:44px;border-radius:8px;object-fit:cover;">
                                    @else
                                    <div style="width:44px;height:44px;background:#f0f0f0;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                        <i class="bi bi-box-seam text-muted"></i>
                                    </div>
                                    @endif
                                    <div>
                                        <div class="fw-semibold">{{ $ligne->produit?->nom ?? 'Produit supprimé' }}</div>
                                        <small class="text-muted">{{ $ligne->produit?->code }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center fw-bold">{{ $ligne->quantite }}</td>
                            <td class="text-end">{{ number_format($ligne->prix_unitaire, 0, ',', ' ') }} FCFA</td>
                            <td class="text-end pe-3 fw-bold">{{ number_format($ligne->sous_total, 0, ',', ' ') }} FCFA</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-dark">
                        <tr>
                            <td colspan="3" class="text-end fw-bold ps-3">Total</td>
                            <td class="text-end pe-3 fw-bold fs-5">
                                {{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- Notes --}}
        @if($commande->notes)
        <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;">
            <div class="card-body">
                <h6 class="fw-bold mb-2">
                    <i class="bi bi-sticky me-2" style="color:#fbc926;"></i>Notes du client
                </h6>
                <p class="mb-0 text-muted">{{ $commande->notes }}</p>
            </div>
        </div>
        @endif

        {{-- Changer statut --}}
        <div class="card border-0 shadow-sm" style="border-radius:12px;">
            <div class="card-body">
                <h6 class="fw-bold mb-3">
                    <i class="bi bi-pencil-square me-2" style="color:#fbc926;"></i>Changer le statut
                </h6>
                <form method="POST" action="{{ route('commandes.statut', $commande->id) }}"
                      class="d-flex gap-2 flex-wrap align-items-center">
                    @csrf @method('PATCH')
                    <select name="statut" class="form-select border-1 border-dark" style="max-width:260px;">
                        @foreach(['en_attente'=>'En attente','confirmee'=>'Confirmée','en_preparation'=>'En préparation','expediee'=>'Expédiée','livree'=>'Livrée','annulee'=>'Annulée'] as $val=>$label)
                        <option value="{{ $val }}" {{ $commande->statut===$val?'selected':'' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn fw-bold" style="background-color:#fbc926;">
                        <i class="bi bi-check-lg me-1"></i> Enregistrer
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Colonne droite --}}
    <div class="col-lg-4">

        {{-- Infos client --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-person-circle me-2" style="color:#fbc926;"></i>Informations client
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted d-block">Nom</small>
                    <span class="fw-semibold">{{ $commande->nom_client }}</span>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block">Téléphone</small>
                    <a href="tel:{{ $commande->telephone_client }}"
                       class="fw-semibold text-dark text-decoration-none">
                        <i class="bi bi-telephone me-1 text-muted"></i>{{ $commande->telephone_client }}
                    </a>
                </div>
                @if($commande->email_client)
                <div class="mb-3">
                    <small class="text-muted d-block">Email</small>
                    <span class="fw-semibold">{{ $commande->email_client }}</span>
                </div>
                @endif
                @if($commande->adresse_livraison)
                <div class="mb-3">
                    <small class="text-muted d-block">Adresse de livraison</small>
                    <span class="fw-semibold">{{ $commande->adresse_livraison }}</span>
                </div>
                @endif
                <div class="d-flex gap-2 mt-3">
                    <a href="tel:{{ $commande->telephone_client }}"
                       class="btn btn-sm btn-outline-dark flex-fill">
                        <i class="bi bi-telephone me-1"></i> Appeler
                    </a>
                    <a href="https://wa.me/{{ preg_replace('/\D/', '', $commande->telephone_client) }}?text={{ urlencode('Bonjour ' . $commande->nom_client . ', concernant votre commande ' . $commande->numero_commande . '...') }}"
                       target="_blank"
                       class="btn btn-sm flex-fill fw-bold"
                       style="background:#25D366;color:#fff;border:none;">
                        <i class="bi bi-whatsapp me-1"></i> WhatsApp
                    </a>
                </div>
            </div>
        </div>

        {{-- Récapitulatif commande --}}
        <div class="card border-0 shadow-sm" style="border-radius:12px;">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-info-circle me-2" style="color:#fbc926;"></i>Détails commande
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <small class="text-muted">Date</small>
                    <small class="fw-semibold">{{ $commande->created_at->format('d/m/Y à H:i') }}</small>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <small class="text-muted">Mode de paiement</small>
                    <small class="fw-semibold">
                        {{ match($commande->mode_paiement) {
                            'a_la_livraison' => 'À la livraison',
                            'mobile_money'   => 'Mobile Money',
                            default          => 'Autre'
                        } }}
                    </small>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <small class="text-muted">Nombre d'articles</small>
                    <small class="fw-semibold">{{ $commande->lignes->count() }}</small>
                </div>
                <div class="d-flex justify-content-between border-top pt-2 mt-2">
                    <span class="fw-bold">Total</span>
                    <span class="fw-bold">{{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA</span>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
