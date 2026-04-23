@extends('layouts.app')
@section('title', 'Commandes boutique')

@section('content')

<div class="stats-grid">

  <!-- Card 1 : Chiffre d'affaires -->
  <div class="stat-card">
    <div class="d-flex align-items-start justify-content-between mb-3">
      <div style="width:38px;height:38px;border-radius:8px;background:rgba(240,198,29,0.12);border:1px solid rgba(240,198,29,0.2);display:flex;align-items:center;justify-content:center;">
        <i class="bi bi-bag-check" style="color:#f0c61d;font-size:1rem;"></i>
      </div>
      <span class="badge" style="background:rgba(45,180,90,0.15);color:#4ecb71;font-size:0.7rem;font-weight:600;padding:4px 10px;border-radius:20px;">
        ↑ 
      </span>
    </div>
    <div class="stat-info">
      <h3>Total Commandes</h3>
    </div>
    <div class="stat-value">{{ $stats['total'] }}</div>
    <div class="stat-footer">
      <i class="bi bi-bag" style="font-size:0.75rem;"></i>
      Tout mes commandes
    </div>
  </div>

  <!-- Card 2 : Ventes du mois -->
  <div class="stat-card">
    <div class="d-flex align-items-start justify-content-between mb-3">
      <div style="width:38px;height:38px;border-radius:8px;background:rgba(240,198,29,0.12);border:1px solid rgba(240,198,29,0.2);display:flex;align-items:center;justify-content:center;">
        <i class="bi bi-clock" style="color:#f0c61d;font-size:1rem;"></i>
      </div>
      <span class="badge" style="background:rgba(45,180,90,0.15);color:#4ecb71;font-size:0.7rem;font-weight:600;padding:4px 10px;border-radius:20px;">
        ↑ 
      </span>
    </div>
    <div class="stat-info">
      <h3>Commande en attente</h3>
    </div>
    <div class="stat-value">{{ $stats['en_attente'] }}</div>
    <div class="stat-footer">
      <i class="bi bi-clock" style="font-size:0.75rem;"></i>
      en attente....
    </div>
  </div>

  <!-- Card 3 : Commandes en attente -->
  <div class="stat-card">
    <div class="d-flex align-items-start justify-content-between mb-3">
      <div style="width:38px;height:38px;border-radius:8px;background:rgba(240,198,29,0.12);border:1px solid rgba(240,198,29,0.2);display:flex;align-items:center;justify-content:center;">
        <i class="bi bi-check-circle" style="color:#f0c61d;font-size:1rem;"></i>
      </div>
      <span class="badge" style="background:rgba(255,80,80,0.12);color:#ff8080;font-size:0.7rem;font-weight:600;padding:4px 10px;border-radius:20px;">
        ↓ 
      </span>
    </div>
    <div class="stat-info">
      <h3>Commandes livrées</h3>
    </div>
    <div class="stat-value">{{ $stats['livrees'] }}</div>
    <div class="stat-footer">
      <i class="bi bi-check-circle" style="font-size:0.75rem;"></i>
      Total commandes déjà livrée
    </div>
  </div>

</div>
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
    <div>
        <h1 class="h2 text-dark fw-bold d-flex align-items-center">
            <i class="bi bi-bag-check me-2"></i> Commandes boutique
        </h1>
        <p class="text-muted mb-0">Gérez les commandes passées depuis votre boutique en ligne</p>
    </div>
    <a href="{{ route('cabine.public', auth()->user()->cabine->code) }}" target="_blank"
       class="btn btn-outline-dark fw-bold">
        <i class="bi bi-box-arrow-up-right me-1"></i> Voir la boutique
    </a>
</div>

{{-- Filtres --}}
<div class="card border-0 bg-light mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('commandes.boutique') }}">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Rechercher</label>
                    <input type="text" name="search" class="form-control border-1 border-dark"
                           placeholder="Numéro, client, téléphone..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Statut</label>
                    <select name="statut" class="form-select border-1 border-dark">
                        <option value="">Tous</option>
                        @foreach(['en_attente'=>'En attente','confirmee'=>'Confirmée','en_preparation'=>'En préparation','expediee'=>'Expédiée','livree'=>'Livrée','annulee'=>'Annulée'] as $val=>$label)
                        <option value="{{ $val }}" {{ request('statut')===$val?'selected':'' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Date début</label>
                    <input type="date" name="date_debut" class="form-control border-1 border-dark" value="{{ request('date_debut') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Date fin</label>
                    <input type="date" name="date_fin" class="form-control border-1 border-dark" value="{{ request('date_fin') }}">
                </div>
                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn fw-bold w-100" style="background-color:#fbc926;">
                        <i class="bi bi-funnel me-1"></i> Filtrer
                    </button>
                    <a href="{{ route('commandes.boutique') }}" class="btn btn-outline-dark">
                        <i class="bi bi-arrow-clockwise"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Table --}}
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
        <h5 class="mb-0 text-dark fw-bold">
            <i class="bi bi-list-ul me-2"></i> Liste des commandes
        </h5>
        <span class="badge bg-dark fs-6">{{ $commandes->total() }} résultat(s)</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 table-card-mobile">
                <thead class="table-dark">
                    <tr>
                        <th>N° Commande</th>
                        <th>Client</th>
                        <th>Articles</th>
                        <th class="text-end">Total</th>
                        <th class="text-center">Statut</th>
                        <th>Date</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($commandes as $commande)
                    <tr>
                        <td class="align-middle" data-label="N° Commande">
                            <span class="fw-bold text-dark" style="font-family:monospace;font-size:12px;">
                                {{ $commande->numero_commande }}
                            </span>
                        </td>
                        <td class="align-middle" data-label="Client">
                            <div class="fw-semibold">{{ $commande->nom_client }}</div>
                            <small class="text-muted">{{ $commande->telephone_client }}</small>
                        </td>
                        <td class="align-middle" data-label="Articles">
                            <span class="badge rounded-pill" style="color:#181818;background:#6665657c;">
                                {{ $commande->lignes->count() }} article(s)
                            </span>
                        </td>
                        <td class="align-middle text-end fw-bold" data-label="Total">
                            {{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA
                        </td>
                        <td class="align-middle text-center" data-label="Statut">
                            <span class="badge rounded-pill px-3"
                                  style="background:{{ $commande->statut_color }}22;color:{{ $commande->statut_color }};border:1px solid {{ $commande->statut_color }}55;font-size:11px;">
                                {{ $commande->statut_label }}
                            </span>
                        </td>
                        <td class="align-middle" data-label="Date">
                            <small>{{ $commande->created_at->format('d/m/Y') }}</small><br>
                            <small class="text-muted">{{ $commande->created_at->format('H:i') }}</small>
                        </td>
                        <td class="align-middle text-center">
                            <div class="btn-group" role="group">
                                <a href="{{ route('commandes.show', $commande->id) }}"
                                   class="btn btn-sm btn-outline-dark" title="Voir détails">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-dark dropdown-toggle" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="border-radius:12px;font-size:13px;">
                                        @foreach(['en_attente'=>'En attente','confirmee'=>'Confirmée','en_preparation'=>'En préparation','expediee'=>'Expédiée','livree'=>'Livrée','annulee'=>'Annulée'] as $val=>$label)
                                        <li>
                                            <form method="POST" action="{{ route('commandes.statut', $commande->id) }}">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="statut" value="{{ $val }}">
                                                <button type="submit" class="dropdown-item {{ $commande->statut===$val?'fw-bold':'' }}">
                                                    @if($commande->statut===$val)<i class="bi bi-check me-1"></i>@endif{{ $label }}
                                                </button>
                                            </form>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="bi bi-bag fs-1 text-muted d-block mb-2"></i>
                            <h5 class="text-muted">Aucune commande trouvée</h5>
                            <p class="text-muted small">Les commandes passées depuis votre boutique apparaîtront ici.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($commandes->hasPages())
    <div class="d-flex justify-content-between align-items-center p-3">
        <small class="text-muted">Page {{ $commandes->currentPage() }} sur {{ $commandes->lastPage() }}</small>
        {{ $commandes->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>

@endsection
