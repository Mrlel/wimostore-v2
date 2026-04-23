@extends('layouts.app')

@section('title', 'Rapports Financiers')

@section('content')
<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-4 w-100 w-md-auto">
        <div>
            <h1 class="h2 text-dark fw-bold d-flex align-items-center flex-wrap">
                <i class="bi bi-graph-up me-2" style="color: #fbc926;"></i>
                Rapports Financiers
            </h1>
            <p class="text-muted mb-0">Consultez et gérez vos rapports financiers</p>
        </div>
        <div class="col-12 col-md-auto text-md-end">
            <a href="{{ route('rapports-financiers.create') }}" class="btn w-100 w-md-auto text-dark fw-bold" style="background-color: #fbc926;">
                <i class="bi bi-plus-circle me-1"></i>Nouveau Rapport
            </a>
        </div>
    </div>

    <!-- Filtres -->
    <div class="card border-0 mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('rapports-financiers.index') }}">
                <div class="row">
                    <div class="col-md-2 mb-3">
                        <label for="type_rapport" class="form-label fw-semibold">Type</label>
                        <select name="type_rapport" id="type_rapport" class="form-control border-1 border-dark">
                            <option value="">Tous</option>
                            <option value="quotidien" {{ request('type_rapport') == 'quotidien' ? 'selected' : '' }}>Quotidien</option>
                            <option value="hebdomadaire" {{ request('type_rapport') == 'hebdomadaire' ? 'selected' : '' }}>Hebdomadaire</option>
                            <option value="mensuel" {{ request('type_rapport') == 'mensuel' ? 'selected' : '' }}>Mensuel</option>
                            <option value="annuel" {{ request('type_rapport') == 'annuel' ? 'selected' : '' }}>Annuel</option>
                            <option value="personnalise" {{ request('type_rapport') == 'personnalise' ? 'selected' : '' }}>Personnalisé</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="date_debut" class="form-label fw-semibold">Date début</label>
                        <input type="date" name="date_debut" id="date_debut" 
                               class="form-control border-1 border-dark" 
                               value="{{ request('date_debut') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="date_fin" class="form-label fw-semibold">Date fin</label>
                        <input type="date" name="date_fin" id="date_fin" 
                               class="form-control border-1 border-dark" 
                               value="{{ request('date_fin') }}">
                    </div>
                    <div class="col-md-2 mb-3 d-flex align-items-end">
                        <button type="submit" class="btn text-dark me-2 w-100" style="background-color: #fbc926;">
                            <i class="bi bi-funnel me-1"></i>Filtrer
                        </button>
                        <a href="{{ route('rapports-financiers.index') }}" class="btn btn-outline-dark">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tableau des rapports -->
    <div class="card border-0">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-dark fw-bold">
                <i class="bi bi-list-ul me-2" style="color: #fbc926;"></i>
                Historique des rapports
            </h5>
            <span class="badge bg-dark fs-6">{{ $rapports->total() }} résultat(s)</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="border-dark">Période</th>
                            <th class="border-dark">Type</th>
                            <th class="text-end border-dark">Chiffre d'affaires</th>
                            <th class="text-end border-dark">Gain sur ventes</th>
                            <th class="text-end border-dark">Bénéfice</th>
                            <th class="text-center border-dark">Statut</th>
                            <th class="text-center border-dark">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rapports as $rapport)
                            <tr>
                                <td class="align-middle">
                                    <span class="fw-bold text-dark">{{ $rapport->periode }}</span>
                                </td>
                                <td class="align-middle">
                                    <span class="badge bg-light text-dark text-capitalize">
                                        {{ $rapport->type_rapport }}
                                    </span>
                                </td>
                                <td class="text-end align-middle">
                                    <span class="fw-bold text-success">{{ number_format($rapport->chiffre_affaires_total, 0, ',', ' ') }} FCFA</span>
                                </td>
                                <td class="text-end align-middle">
                                    <span class="text-primary">{{ number_format($rapport->marge_brute, 0, ',', ' ') }} FCFA</span>
                                    <br>
                                    <small class="text-muted">({{ number_format($rapport->taux_marge_brute, 1) }}%)</small>
                                </td>
                                <td class="text-end align-middle">
                                    @if($rapport->marge_nette >= 0)
                                        <span class="text-success">{{ number_format($rapport->marge_nette, 0, ',', ' ') }} FCFA</span>
                                        <br>
                                        <small class="text-muted">({{ number_format($rapport->taux_marge_nette, 1) }}%)</small>
                                    @else
                                        <span class="text-danger">{{ number_format($rapport->marge_nette, 0, ',', ' ') }} FCFA</span>
                                        <br>
                                        <small class="text-muted">({{ number_format($rapport->taux_marge_nette, 1) }}%)</small>
                                    @endif
                                </td>
                                <td class="text-center align-middle">
                                    @if($rapport->est_valide)
                                    <p class="text-success fs-6">
                                         <i class="fas fa-check-circle"></i>
                                    </p>
                                    @else
                                    <p class="text-warning fs-6">
                                         <i class="fas fa-clock"></i>
                                    </p>
                                    @endif
                                </td>

                                <td class="text-center align-middle">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('rapports-financiers.show', $rapport) }}" 
                                           class="btn btn-sm btn-outline-dark"
                                           data-bs-toggle="tooltip" data-bs-title="Voir détails">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        
                                        @if(!$rapport->est_valide)
                                            <a href="{{ route('rapports-financiers.edit', $rapport) }}" 
                                               class="btn btn-sm btn-outline-dark"
                                               data-bs-toggle="tooltip" data-bs-title="Modifier">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        @endif
                                        
                                        <a href="{{ route('rapports-financiers.export-pdf', $rapport) }}" 
                                           class="btn btn-sm btn-outline-dark"
                                           data-bs-toggle="tooltip" data-bs-title="Exporter PDF">
                                            <i class="bi bi-file-earmark-pdf"></i>
                                        </a>
                                        
                                        @if(!$rapport->est_valide)
                                            <form action="{{ route('rapports-financiers.destroy', $rapport) }}" 
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce rapport ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        data-bs-toggle="tooltip" data-bs-title="Supprimer">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="py-4">
                                        <i class="bi bi-graph-up fs-1 text-muted"></i>
                                        <h5 class="text-muted mt-3">Aucun rapport financier trouvé</h5>
                                        <p class="text-muted">
                                            @if(request()->anyFilled(['type_rapport', 'date_debut', 'date_fin', 'est_valide']))
                                                Aucun rapport ne correspond à vos critères de recherche.
                                            @else
                                                Commencez par créer votre premier rapport financier.
                                            @endif
                                        </p>
                                        <a href="{{ route('rapports-financiers.create') }}" class="btn text-dark mt-2" style="background-color: #fbc926;">
                                            <i class="bi bi-plus-circle me-1"></i>Créer un rapport
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($rapports->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="text-muted small">
                Page {{ $rapports->currentPage() }} sur {{ $rapports->lastPage() }}
            </div>
            <div>
                {{ $rapports->links('pagination::bootstrap-5') }}
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
        
        // Auto-submit du formulaire de filtres (optionnel)
        const filterInputs = document.querySelectorAll('#type_rapport, #est_valide');
        filterInputs.forEach(input => {
            input.addEventListener('change', function() {
                this.form.submit();
            });
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
@endsection