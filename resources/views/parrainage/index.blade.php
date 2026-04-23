@extends('layouts.app')
@section('title', 'Mon Parrainage - Inventaire')
@section('content')
<style>
:root {
    --primary-color: #0D6E6E;
    --secondary-color: #fbc926;
    --success-color: #28a745;
    --danger-color: #dc3545;
    --warning-color: #ffc107;
    --info-color: #000000;
}

.dashboard-card {
    border: none;
    border-radius: 12px;
    transition: transform 0.3s ease;
    margin-bottom: 1.5rem;
}

.dashboard-card:hover {
    transform: translateY(-5px);
}

.stat-card {
    background: linear-gradient(135deg, #ffffff, #f8f9fa);
    border-radius: 12px;
    padding: 25px;
    text-align: center;
    border-left: 4px solid var(--secondary-color);
}

.stat-value {
    font-size: 2.2rem;
    font-weight: 700;
    color: var(--primary-color);
    margin-bottom: 5px;
}

.stat-label {
    color: #6c757d;
    font-size: 14px;
    font-weight: 500;
}

.badge-marge {
    background: rgba(40, 167, 69, 0.1);
    color: var(--success-color);
    font-weight: 600;
}

.table-enhanced th {
    background: var(--primary-color);
    color: white;
    border: none;
    padding: 1rem;
}

.table-enhanced td {
    vertical-align: middle;
    padding: 1rem;
    border-bottom: 1px solid #f8f9fa;
}

.btn-primary-custom {
    background: var(--secondary-color);
    color: var(--info-color);
    border: none;
    padding: 12px 30px;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary-custom:hover {
    background: #e6b722;
    transform: translateY(-2px);
}

.code-input-group {
    border-radius: 8px;
    overflow: hidden;
}

.code-input-group .form-control {
    border-right: none;
    padding: 12px 15px;
    font-weight: 600;
    font-size: 1.1rem;
    letter-spacing: 1px;
}

.code-input-group .btn {
    border-left: none;
    padding: 12px 20px;
    font-weight: 600;
}
</style>

<div class="container-fluid py-4">
    <!-- En-tête identique aux autres pages -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h2 text-dark fw-bold">
                <i class="bi bi-people me-2" style="color: var(--secondary-color);"></i>
                Mon Programme de Parrainage
            </h1>
            <p class="text-muted mb-0">Parrainez vos amis et gagnez des récompenses ensemble</p>
        </div>
        <div class="col-md-4 text-end">
             <a  href="{{ url()->previous() }}" class="btn btn-outline-dark rounded">
                <i class="bi bi-arrow-left me-1"></i> Retour
            </a>
        </div>
    </div>

    <!-- Carte du code de parrainage -->
    <div class="dashboard-card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="card-title fw-bold mb-0">
                    <i class="bi bi-person-badge me-2"></i>
                    Mon Code de Parrainage
                </h5>
                <span class="badge bg-dark">
                    Code personnel
                </span>
            </div>
            
            <div class="code-input-group input-group mb-3">
                <input type="text" 
                       class="form-control" 
                       id="codeParrain" 
                       value="{{ $user->code_parrainage }}" 
                       readonly
                       style="background: linear-gradient(135deg, #f8f9fa, #e9ecef);">
                <button class="btn text-dark fw-bold" onclick="copierCode()" style="background-color: var(--secondary-color);">
                    <i class="bi bi-copy me-1"></i> Copier
                </button>
            </div>
            <p class="text-muted mb-0">
                <i class="bi bi-share me-1"></i>
                Partagez ce code avec des personnes exerçant des activités commerçiale
            </p>
        </div>
    </div>

    <!-- Statistiques 
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="dashboard-card">
                <div class="stat-card">
                    <div class="stat-value">{{ $statistiques['nombre_filleuls'] }}</div>
                    <div class="stat-label">Filleuls inscrits</div>
                    <div class="mt-3">
                        <span class="badge bg-primary">
                            <i class="bi bi-people me-1"></i>Total
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="dashboard-card">
                <div class="stat-card">
                    <div class="stat-value">{{ number_format($statistiques['recompense_totale'], 0, ',', ' ') }} FCFA</div>
                    <div class="stat-label">Récompenses totales</div>
                    <div class="mt-3">
                        <span class="badge bg-success">
                            <i class="bi bi-coin me-1"></i>Gains
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="dashboard-card">
                <div class="stat-card">
                    <div class="stat-value">{{ $statistiques['filleuls_actifs'] }}</div>
                    <div class="stat-label">Filleuls actifs</div>
                    <div class="mt-3">
                        <span class="badge bg-warning text-dark">
                            <i class="bi bi-lightning me-1"></i>Actifs
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>-->

    <!-- Liste des filleuls -->
    <div class="dashboard-card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="card-title fw-bold mb-0">
                    <i class="bi bi-list-ul me-2"></i>
                    Mes Filleuls
                </h5>
                <span class="badge bg-dark">
                    {{ $filleuls->count() }} filleul(s)
                </span>
            </div>

            <div class="table-responsive">
                <table class="table table-enhanced table-hover">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Boutique</th>
                            <th class="text-center">Date d'inscription</th>
                            <th class="text-center">Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($filleuls as $filleul)
                            <tr>
                                <td>
                                    <strong>{{ $filleul->nom }}</strong>
                                </td>
                                <td>
                                    <strong>{{ $filleul->cabine->nom_cab}}</strong>
                                </td>
                                <td class="text-center">
                                    <span class="text-muted">{{ $filleul->created_at->format('d/m/Y') }}</span>
                                </td>
                                <td class="text-center">
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle me-1"></i>
                                            Actif
                                        </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <i class="bi bi-people fs-1 text-muted d-block mb-3"></i>
                                    <span class="text-muted">Vous n'avez pas encore de filleuls</span>
                                    <p class="text-muted small mt-2">
                                        Partagez votre code de parrainage pour inviter vos amis !
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <!-- Section d'information 
    <div class="dashboard-card">
        <div class="card-body rounded" style="background-color: var(--info-color);">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5 class="text-white fw-bold mb-2">
                        <i class="bi bi-info-circle me-2"></i>
                        Comment fonctionne le parrainage ?
                    </h5>
                    <p class="text-white mb-0 opacity-90">
                        Partagez votre code avec vos amis. Lorsqu'ils s'inscrivent et deviennent actifs, 
                        vous recevez des récompenses. Plus vous parrainez, plus vous gagnez !
                    </p>
                </div>
                <div class="col-md-4 text-end">
                    <span class="badge bg-warning text-dark fs-6 p-2">
                        <i class="bi bi-rocket-takeoff me-1"></i>Gagnez ensemble
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>-->

<script>
function copierCode() {
    const code = document.getElementById('codeParrain');
    code.select();
    code.setSelectionRange(0, 99999); // Pour mobile
    document.execCommand('copy');
    
    // Animation de feedback
    const btn = event.target.closest('button');
    const originalHtml = btn.innerHTML;
    btn.innerHTML = '<i class="bi bi-check2 me-1"></i>Copié !';
    btn.style.background = 'var(--success-color)';
    btn.style.color = 'white';
    
    setTimeout(() => {
        btn.innerHTML = originalHtml;
        btn.style.background = '';
        btn.style.color = '';
    }, 2000);
}
</script>
@endsection