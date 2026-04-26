@extends('layouts.base')
@section('title', 'Liste des Abonnements')

@section('content')
<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-4 w-100 w-md-auto">
        <div>
            <h1 class="h2 text-dark fw-bold d-flex align-items-center flex-wrap">
                <i class="bi bi-credit-card me-2" style="color: #ffde59;"></i>
                Gestion des Abonnements
            </h1>
            <p class="text-muted mb-0">Consultez et gérez les abonnements des cabines</p>
        </div>
        <div class="d-flex">
            <a href="" class="btn text-dark fw-bold" style="background-color: #ffde59;">
                <i class="bi bi-plus-circle me-1"></i>Nouvel Abonnement
            </a>
        </div>
    </div>

    <!-- Informations tarifaires 
    <div class="card border-0 mb-4">
        <div class="card-header bg-white py-3 border-bottom">
            <h5 class="mb-0 text-dark fw-bold">
                <i class="bi bi-info-circle me-2" style="color: #ffde59;"></i>
                Informations Tarifaires
            </h5>
        </div>
        <div class="card-body">
            <div class="row text-center">
                <div class="col-md-4 mb-3">
                    <div class="border rounded p-3">
                        <i class="bi bi-calendar-check fs-1 text-dark mb-2"></i>
                        <h4 class="fw-bold">30 jours</h4>
                        <h3 class="text-success fw-bold">5 000 FCFA</h3>
                        <small class="text-muted">Abonnement standard</small>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="border rounded p-3">
                        <i class="bi bi-lightning-charge fs-1 text-dark mb-2"></i>
                        <h4 class="fw-bold">Renouvellement</h4>
                        <h3 class="text-primary fw-bold">Instantané</h3>
                        <small class="text-muted">Activation immédiate</small>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="border rounded p-3">
                        <i class="bi bi-shield-check fs-1 text-dark mb-2"></i>
                        <h4 class="fw-bold">Garantie</h4>
                        <h3 class="text-warning fw-bold">Sans interruption</h3>
                        <small class="text-muted">Service continu assuré</small>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <!-- Carte principale -->
    <div class="card border-0">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-dark fw-bold">
                <i class="bi bi-list-ul me-2" style="color: #ffde59;"></i>
                Liste des Abonnements
            </h5>
            <span class="badge bg-dark fs-6">{{ $abonnements->count() }} abonnement(s)</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="border-dark">#ID</th>
                            <th class="border-dark">Cabine</th>
                            <th class="border-dark">Date début</th>
                            <th class="border-dark">Date fin</th>
                            <th class="text-center border-dark">Jours restants</th>
                            <th class="text-center border-dark">Statut</th>
                            <th class="text-end border-dark">Montant</th>
                            <th class="text-center border-dark">Renouvellement</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($abonnements as $abonnement)
                        @php
                            $dateFin = \Carbon\Carbon::parse($abonnement->date_fin);
                            $joursRestants = $dateFin->diffInDays(now(), false) * -1;
                            $estExpire = $dateFin->isPast();
                            $expireBientot = !$estExpire && $joursRestants <= 7;
                        @endphp
                        <tr>
                            <td class="align-middle">
                                <span class="fw-bold text-dark">#{{ $abonnement->id }}</span>
                            </td>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <span class="fw-semibold text-dark">{{ $abonnement->cabine->nom_cab }}</span>
                                        <br>
                                        <small class="text-muted">{{ $abonnement->cabine->code }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle">
                                <span class="text-dark">{{ \Carbon\Carbon::parse($abonnement->date_debut)->format('d/m/Y') }}</span>
                            </td>
                            <td class="align-middle">
                                <span class="text-dark">{{ $dateFin->format('d/m/Y') }}</span>
                                @if($estExpire)
                                    <br>
                                    <small class="text-danger">
                                        <i class="bi bi-exclamation-triangle me-1"></i>Expiré
                                    </small>
                                @elseif($expireBientot)
                                    <br>
                                    <small class="text-warning">
                                        <i class="bi bi-clock me-1"></i>Expire bientôt
                                    </small>
                                @endif
                            </td>
                            <td class="text-center align-middle">
                                @if($estExpire)
                                    <span class="badge bg-danger">0 jour</span>
                                @else
                                    <span class="badge {{ $expireBientot ? 'bg-warning' : 'bg-success' }}">
                                        {{ $joursRestants }} jour(s)
                                    </span>
                                @endif
                            </td>
                            <td class="text-center align-middle">
                                @if($abonnement->statut == 'actif')
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle me-1"></i>Actif
                                    </span>
                                @elseif($abonnement->statut == 'inactif')
                                    <span class="badge bg-secondary">
                                        <i class="bi bi-pause-circle me-1"></i>Inactif
                                    </span>
                                @elseif($abonnement->statut == 'expiré')
                                    <span class="badge bg-danger">
                                        <i class="bi bi-x-circle me-1"></i>Expiré
                                    </span>
                                @else
                                    <span class="badge bg-light text-dark text-capitalize">
                                        {{ $abonnement->statut }}
                                    </span>
                                @endif
                            </td>
                            <td class="text-end align-middle">
                                <span class="fw-bold text-dark">{{ number_format($abonnement->montant, 0, ',', ' ') }} FCFA</span>
                            </td>
                            <td class="text-center align-middle">
                                <form method="POST" action="{{ route('abonnements.renew') }}" class="d-flex gap-2 align-items-center justify-content-center">
                                    @csrf
                                    <input type="hidden" name="cabine_id" value="{{ $abonnement->cabine_id }}">
                                    
                                    <div class="input-group input-group-sm" style="width: 140px;">
                                        <span class="input-group-text bg-light border-dark">Durée</span>
                                        <select name="duree" class="form-select border-dark" required>
                                            <option value="30" selected>30 jours</option>
                                            <option value="60">60 jours</option>
                                            <option value="90">90 jours</option>
                                            <option value="180">180 jours</option>
                                            <option value="365">365 jours</option>
                                        </select>
                                    </div>
                                    
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <span class="input-group-text bg-light border-dark">Montant</span>
                                        <input type="number" name="montant" class="form-control border-dark text-end" 
                                               value="{{ $abonnement->montant }}" readonly
                                               data-base-price="5000"
                                               onchange="calculatePrice(this)">
                                        <span class="input-group-text bg-light border-dark">FCFA</span>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-sm text-dark fw-bold" style="background-color: #ffde59;"
                                            data-bs-toggle="tooltip" data-bs-title="Renouveler pour 30 jours - 5000 FCFA">
                                        <i class="bi bi-arrow-clockwise me-1"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="py-4">
                                    <i class="bi bi-credit-card fs-1 text-muted"></i>
                                    <h5 class="text-muted mt-3">Aucun abonnement trouvé</h5>
                                    <p class="text-muted">Commencez par créer votre premier abonnement.</p>
                                    <a href="{{ route('abonnements.create') }}" class="btn text-dark mt-2" style="background-color: #ffde59;">
                                        <i class="bi bi-plus-circle me-1"></i>Créer un abonnement
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => new bootstrap.Tooltip(el));

    function calculatePrice(select) {
        const duree = parseInt(select.value);
        const form  = select.closest('form');
        const input = form.querySelector('input[name="montant"]');
        input.value = Math.round((duree / 30) * 5000);
    }

    document.querySelectorAll('select[name="duree"]').forEach(sel => {
        calculatePrice(sel);
        sel.addEventListener('change', () => calculatePrice(sel));
    });
});
</script>
@endpush

@endsection