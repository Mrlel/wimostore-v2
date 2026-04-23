@extends('layouts.app')
@section('title', 'Gestion des Ventes')
@section('content')


<div class="container-fluid px-4">
    <!-- En-tête -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-4 w-100 w-md-auto">
        <div>
            <h1 class="h2 text-dark fw-bold d-flex align-items-center flex-wrap">
                <i class="bi bi-cart-check me-2" style="color: #000000;"></i>
                Gestion des Ventes
            </h1>
            <p class="text-muted mb-0">Consultez et gérez l'historique de vos ventes</p>
        </div>
        <div class="col-12 col-md-auto text-md-end">
            <a href="{{ route('ventes.create') }}" class="btn w-100 w-md-auto text-dark fw-bold" style="background-color: #fbc926;">
                <i class="bi bi-plus-circle me-1"></i>Enregistrer une vente
            </a>
        </div>
</div>


    <!-- Filtres -->
    <div class="card border-0 bg-light mb-4">
        
        <div class="card-body">
            <form method="GET" action="{{ route('ventes.index') }}">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="date_debut" class="form-label fw-semibold">Date début</label>
                        <input type="date" id="date_debut" name="date_debut" 
                            value="{{ request('date_debut') }}"
                            class="form-control border-1 border-dark">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="date_fin" class="form-label fw-semibold">Date fin</label>
                        <input type="date" id="date_fin" name="date_fin" 
                            value="{{ request('date_fin') }}"
                            class="form-control border-1 border-dark">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="user_id" class="form-label fw-semibold">Gestionnaire</label>
                        <select id="user_id" name="user_id" class="form-control border-1 border-dark">
                            <option value="">Tous les gestionnaires</option>
                            @foreach(($users ?? []) as $u)
                                <option value="{{ $u->id }}" {{ (string)request('user_id') === (string)$u->id ? 'selected' : '' }}>
                                    {{ $u->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                  <div class="col-md-3 mb-3 d-flex align-items-end">
                        <button type="submit" class="btn me-2 w-100" style="background-color: #fbc926;">
                            <i class="bi bi-funnel me-1"></i>Filtrer
                        </button>
                        <a href="{{ route('ventes.index') }}" class="btn btn-outline-dark">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="search" class="form-label fw-semibold">Recherche une vente</label>
                        <input type="text" id="search" name="search" 
                            class="form-control border-1 border-dark w-100"
                            placeholder="Nom, marque ou description...">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tableau des ventes -->
    <div class="card border-0">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-dark fw-bold">
                <i class="bi bi-list-ul me-2" style="color: #000000;"></i>
                Historique des ventes
            </h5>
            <span class="badge bg-dark fs-6">{{ $ventes->total() }} résultat(s)</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 table-card-mobile">
                    <thead class="table-dark">
                        <tr>
                            <th class="border-dark">N° Vente</th>
                            <th class="border-dark">Date</th>
                            <th class="border-dark">Produits</th>
                            <th class="text-end border-dark">Montant</th>
                            <th class="text-center border-dark">Paiement</th>
                            <th class="text-center border-dark">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ventes as $vente)
                        <tr>
                            <td class="align-middle" data-label="N° Vente">
                                <span class="fw-bold text-dark">{{ $vente->numero_vente }}</span>
                            </td>
                            <td class="align-middle" data-label="Date">
                                <small>{{ $vente->created_at->format('d/m/Y') }}</small>
                                <br>
                                <small class="text-muted">{{ $vente->created_at->format('H:i') }}</small>
                            </td>
                            <td class="align-middle" data-label="Produits">
                                <div>
                                    <span class="badge rounded-pill me-1" style="color: #181818ff; background-color: #6665657c">
                                        {{ $vente->lignes->sum('quantite') }} article(s)
                                    </span>
                                    @foreach($vente->lignes->take(2) as $ligne)
                                        <small class="d-block text-truncate" style="max-width: 200px;">
                                            {{ $ligne->produit->nom }}
                                        </small>
                                    @endforeach
                                    @if($vente->lignes->count() > 2)
                                        <small class="text-muted">+{{ $vente->lignes->count() - 2 }} autre(s)</small>
                                    @endif
                                </div>
                            </td>
                            <td class="text-end align-middle" data-label="Montant">
                                <span class="fw-bold text-dark">{{ number_format($vente->montant_total) }} FCFA</span>
                                @if($vente->montant_total > $vente->montant_regle)
                                    <br>
                                    <small class="text-danger">
                                        Dû: {{ number_format($vente->montant_total - $vente->montant_regle) }} FCFA
                                    </small>
                                @endif
                            </td>
                            <td class="text-center align-middle" data-label="Paiement">
                                <span class="badge bg-light text-dark text-capitalize">
                                    {{ $vente->mode_paiement }}
                                </span>
                            </td>
                            <td class="text-center align-middle">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('ventes.show', $vente) }}" 
                                       class="btn btn-sm btn-outline-dark"
                                       data-bs-toggle="tooltip" data-bs-title="Voir détails">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('ventes.imprimer', $vente) }}" 
                                       class="btn btn-sm btn-outline-dark"
                                       data-bs-toggle="tooltip" data-bs-title="Voir le réçu">
                                        <i class="bi bi-receipt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="py-4">
                                    <i class="bi bi-cart-x fs-1 text-muted"></i>
                                    <h5 class="text-muted mt-3">Aucune vente trouvée</h5>
                                    <p class="text-muted">
                                        @if(request()->anyFilled(['date_debut', 'date_fin', 'type_client', 'mode_paiement', 'search', 'produit']))
                                            Aucune vente ne correspond à vos critères de recherche.
                                        @else
                                            Commencez par enregistrer votre première vente.
                                        @endif
                                    </p>
                                    <a href="{{ route('ventes.create') }}" class="btn text-dark mt-2" style="background-color: #fbc926;">
                                        <i class="bi bi-plus-circle me-1"></i>Créer une vente
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($ventes->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="text-muted small">
                Page {{ $ventes->currentPage() }} sur {{ $ventes->lastPage() }}
            </div>
            <div>
                {{ $ventes->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @endif
    </div>
</div>

<script>
    // Initialiser les tooltips Bootstrap
    document.addEventListener('DOMContentLoaded', function() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Définir les dates par défaut (30 derniers jours)
        const today = new Date();
        const thirtyDaysAgo = new Date();
        thirtyDaysAgo.setDate(today.getDate() - 30);
        
        if (!document.getElementById('date_debut').value) {
            document.getElementById('date_debut').value = thirtyDaysAgo.toISOString().split('T')[0];
        }
        if (!document.getElementById('date_fin').value) {
            document.getElementById('date_fin').value = today.toISOString().split('T')[0];
        }
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    const tableRows = document.querySelectorAll('tbody tr');

    searchInput.addEventListener('input', function() {
        const query = this.value.trim().toLowerCase();

        tableRows.forEach(row => {
            // Récupère le texte de toutes les cellules pertinentes
            const cellsText = Array.from(row.querySelectorAll('td'))
                .map(td => td.textContent.toLowerCase())
                .join(' ');
            // Affiche ou masque la ligne selon la recherche
            row.style.display = cellsText.includes(query) ? '' : 'none';
        });
    });
});
</script>
@endsection