@extends('layouts.app')
@section('title', 'Analyse des Performances - Inventaire')
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
}

.progress-stock {
    height: 8px;
    border-radius: 4px;
}

.filter-section {
    background: white;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 25px;
}
</style>

<div class="container-fluid py-4">

    <div class="d-flex align-items-center justify-content-between p-2 rounded mb-3" style="background-color: #fdfcf8ff;">
        <small class="ms-2 text-muted">🎙️ Guide vocal - Explication de la page</small>
    <audio controls style="max-width: 380px;">
        <source src="{{ asset('audios/analyse_performance_intro.mp3') }}" type="audio/mpeg">
        Votre navigateur ne supporte pas la lecture audio.
    </audio>
</div>

    <!-- En-tête -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-4 w-100 w-md-auto">
        <div class="col-md-8">
            <h1 class="h2 text-dark fw-bold">
                <i class="bi bi-graph-up-arrow me-2" style="color: var(--secondary-color);"></i>
                Analyse des Performances
            </h1>
            <p class="text-muted mb-0">Statistiques détaillées des ventes et analyse de rentabilité</p>
            <div class="mt-2 ">
                <span class="btn border border-secondary rounded px-2 py-1 fs-6">
                    <i class="bi bi-calendar-range me-1"></i>
                    {{ $periodeSelectionnee }}
                </span>
            </div>
        </div>
        <div class="col-12 col-md-auto text-md-end">
            <a href="{{ route('ventes.create') }}" class="btn w-100 w-md-auto text-dark fw-bold" style="background-color: var(--secondary-color);">
                <i class="bi bi-plus-circle me-1"></i>Nouvelle Vente
            </a>
        </div>
    </div>

    <!-- Filtres -->
    @can('manage-gestionnaires')
    <div class="filter-section">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-semibold">Date de début</label>
                <input type="date" name="start_date" class="form-control" value="{{ $start }}">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Date de fin</label>
                <input type="date" name="end_date" class="form-control" value="{{ $end }}">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn w-100 text-dark fw-bold" style="background-color: var(--secondary-color);">
                    <i class="bi bi-funnel me-1"></i>Filtrer
                </button>
            </div>
            <div class="col-md-3">
                <a href="{{ request()->url() }}" class="btn btn-outline-secondary w-100">
                    <i class="bi bi-arrow-clockwise me-1"></i>Réinitialiser
                </a>
            </div>
        </form>
    </div>
    @endcan
    <!-- Statistiques principales -->

    <div class="row mb-4">
        <div class="col-6 col-md-3 mb-3">
            <div class="stat-card">
                <div class="d-flex align-items-start justify-content-between mb-3">
                    <div style="width:38px;height:38px;border-radius:8px;background:rgba(240,198,29,0.12);border:1px solid rgba(240,198,29,0.2);display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-cash-stack" style="color:#f0c61d;font-size:1rem;"></i>
                    </div>
                </div>
                <div class="stat-info"><h3>Chiffre d'affaires</h3></div>
                <div class="stat-value">{{ number_format($totalCA) }}<span style="color:#f0c61d;font-size:1rem;"> FCFA</span></div>
                <div class="stat-footer">
                    <i class="bi bi-calendar3" style="font-size:0.75rem;"></i>
                    {{ $periodeSelectionnee }}
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <div class="stat-card">
                <div class="d-flex align-items-start justify-content-between mb-3">
                    <div style="width:38px;height:38px;border-radius:8px;background:rgba(240,198,29,0.12);border:1px solid rgba(240,198,29,0.2);display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-cart-check" style="color:#f0c61d;font-size:1rem;"></i>
                    </div>
                </div>
                <div class="stat-info"><h3>Produits vendus</h3></div>
                <div class="stat-value">{{ $totalVentes }}</div>
                <div class="stat-footer">
                    <i class="bi bi-calendar3" style="font-size:0.75rem;"></i>
                    {{ $periodeSelectionnee }}
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <div class="stat-card">
                <div class="d-flex align-items-start justify-content-between mb-3">
                    <div style="width:38px;height:38px;border-radius:8px;background:rgba(240,198,29,0.12);border:1px solid rgba(240,198,29,0.2);display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-coin" style="color:#f0c61d;font-size:1rem;"></i>
                    </div>
                    <span class="badge" style="background:rgba(45,180,90,0.15);color:#4ecb71;font-size:0.7rem;font-weight:600;padding:4px 10px;border-radius:20px;">
                        Bénéfice
                    </span>
                </div>
                <div class="stat-info"><h3>Marge bénéficiaire</h3></div>
                <div class="stat-value">{{ number_format($totalMarge) }}<span style="color:#f0c61d;font-size:1rem;"> FCFA</span></div>
                <div class="stat-footer">
                    <i class="bi bi-calendar3" style="font-size:0.75rem;"></i>
                    {{ $periodeSelectionnee }}
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <div class="stat-card">
                <div class="d-flex align-items-start justify-content-between mb-3">
                    <div style="width:38px;height:38px;border-radius:8px;background:rgba(240,198,29,0.12);border:1px solid rgba(240,198,29,0.2);display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-percent" style="color:#f0c61d;font-size:1rem;"></i>
                    </div>
                </div>
                <div class="stat-info"><h3>Taux de marge</h3></div>
                <div class="stat-value">{{ $tauxMargeGlobal }}<span style="color:#f0c61d;font-size:1rem;">%</span></div>
                <div class="stat-footer">
                    <i class="bi bi-graph-up" style="font-size:0.75rem;"></i>
                    rentabilité globale
                </div>
            </div>
        </div>
    </div>
   <!-- Analyse comparative -->
<div class="row mb-4">

    <!-- Produit le plus vendu -->
    <div class="col-md-6 mb-3 mb-md-0">
        <div class="stat-card h-100" style="background:#0d0d0d;">
            <div class="d-flex align-items-center gap-2 mb-3">
                <div style="width:36px;height:36px;border-radius:8px;background:rgba(240,198,29,0.12);border:1px solid rgba(240,198,29,0.2);display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-trophy" style="color:#f0c61d;font-size:0.95rem;"></i>
                </div>
                <span style="font-size:0.82rem;font-weight:600;color:rgba(255,255,255,0.5);text-transform:uppercase;letter-spacing:0.08em;">Produit le plus vendu</span>
            </div>

            @if($topVendus)
                <div class="mb-3">
                    <span style="font-family:'Playfair Display',serif;font-size:1.15rem;font-weight:700;color:#fff;">
                        {{ $topVendus->nom }}
                    </span>
                </div>

                <div class="row text-center g-0">
                    <div class="col-4">
                        <div style="padding:10px 6px;border-radius:8px;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.06);">
                            <div style="font-size:1.1rem;font-weight:700;color:#f0c61d;">{{ $topVendus->total_ventes }}</div>
                            <small style="font-size:0.7rem;color:rgba(255,255,255,0.35);text-transform:uppercase;letter-spacing:0.06em;">Ventes</small>
                        </div>
                    </div>
                    <div class="col-4" style="padding:0 4px;">
                        <div style="padding:10px 6px;border-radius:8px;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.06);">
                            <div style="font-size:0.85rem;font-weight:700;color:#fff;">{{ number_format($topVendus->chiffre_affaires) }}</div>
                            <small style="font-size:0.7rem;color:rgba(255,255,255,0.35);text-transform:uppercase;letter-spacing:0.06em;">CA FCFA</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div style="padding:10px 6px;border-radius:8px;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.06);">
                            <div style="font-size:0.85rem;font-weight:700;color:#fff;">{{ number_format($topVendus->marge_totale) }}</div>
                            <small style="font-size:0.7rem;color:rgba(255,255,255,0.35);text-transform:uppercase;letter-spacing:0.06em;">Marge FCFA</small>
                        </div>
                    </div>
                </div>

                <!-- Barre décorative dorée -->
                <div style="margin-top:16px;height:3px;border-radius:2px;background:linear-gradient(90deg,#f0c61d,#ffd93d);opacity:0.6;"></div>

            @else
                <p style="color:rgba(255,255,255,0.25);font-size:0.85rem;text-align:center;padding:24px 0;">
                    Aucune vente sur la période
                </p>
            @endif
        </div>
    </div>

    <!-- Produit le moins vendu -->
    <div class="col-md-6">
        <div class="stat-card h-100" style="background:#0d0d0d;">
            <div class="d-flex align-items-center gap-2 mb-3">
                <div style="width:36px;height:36px;border-radius:8px;background:rgba(255,80,80,0.1);border:1px solid rgba(255,80,80,0.2);display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-graph-down" style="color:#ff8080;font-size:0.95rem;"></i>
                </div>
                <span style="font-size:0.82rem;font-weight:600;color:rgba(255,255,255,0.5);text-transform:uppercase;letter-spacing:0.08em;">Produit le moins vendu</span>
            </div>

            @if($moinsVendus)
                <div class="mb-3">
                    <span style="font-family:'Playfair Display',serif;font-size:1.15rem;font-weight:700;color:#fff;">
                        {{ $moinsVendus->nom }}
                    </span>
                </div>

                <div class="row text-center g-0">
                    <div class="col-4">
                        <div style="padding:10px 6px;border-radius:8px;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.06);">
                            <div style="font-size:1.1rem;font-weight:700;color:#ff8080;">{{ $moinsVendus->total_ventes }}</div>
                            <small style="font-size:0.7rem;color:rgba(255,255,255,0.35);text-transform:uppercase;letter-spacing:0.06em;">Ventes</small>
                        </div>
                    </div>
                    <div class="col-4" style="padding:0 4px;">
                        <div style="padding:10px 6px;border-radius:8px;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.06);">
                            <div style="font-size:0.85rem;font-weight:700;color:#fff;">{{ number_format($moinsVendus->chiffre_affaires) }}</div>
                            <small style="font-size:0.7rem;color:rgba(255,255,255,0.35);text-transform:uppercase;letter-spacing:0.06em;">CA FCFA</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div style="padding:10px 6px;border-radius:8px;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.06);">
                            <div style="font-size:0.85rem;font-weight:700;color:#fff;">{{ number_format($moinsVendus->marge_totale) }}</div>
                            <small style="font-size:0.7rem;color:rgba(255,255,255,0.35);text-transform:uppercase;letter-spacing:0.06em;">Marge FCFA</small>
                        </div>
                    </div>
                </div>

                <!-- Barre décorative rouge -->
                <div style="margin-top:16px;height:3px;border-radius:2px;background:linear-gradient(90deg,#ff5050,#ff8080);opacity:0.5;"></div>

            @else
                <p style="color:rgba(255,255,255,0.25);font-size:0.85rem;text-align:center;padding:24px 0;">
                    Aucune vente sur la période
                </p>
            @endif
        </div>
    </div>

</div>

    <!-- Graphique d'évolution -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="dashboard-card">
                <div class="card-body">
                    <h5 class="card-title fw-bold p-3 text-dark">
                        <i class="bi bi-bar-chart-line me-2"></i>
                        Évolution des Ventes - {{ $periodeSelectionnee }}
                    </h5>
                    <canvas id="salesTrend" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau détaillé -->
    <div class="row">
        <div class="col-12">
            <div class="dashboard-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title fw-bold mb-0 text-dark">
                            <i class="bi bi-table me-2"></i>
                            Détails par Produit
                        </h5>
                        <span class="badge bg-dark">
                            {{ $produits->count() }} produits
                        </span>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-enhanced table-hover">
                            <thead>
                                <tr>
                                    <th>#Classement</th>
                                    <th>Produit</th>
                                    <th class="text-center">Ventes</th>
                                    <th class="text-end">Prix Achat</th>
                                    <th class="text-end">Chiffre d'Affaires</th>
                                    <th class="text-end">Coût Total</th>
                                    <th class="text-end">Marge</th>
                                    <th class="text-center">Taux Marge</th>
                                    <th class="text-center">Stock Actuel</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($produits as $p)
                                <tr>
                                    <td>{{ $loop->iteration }} ème</td>
                                    <td>
                                        <div>
                                            <strong>{{ $p->nom }}</strong>
                                            @if($p->marque)
                                            <br><small class="text-muted">{{ $p->marque }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center fw-bold">{{ $p->total_ventes }}</td>
                                    <td class="text-end">{{ number_format($p->prix_achat, 2) }} FCFA</td>
                                    <td class="text-end text-success fw-bold">{{ number_format($p->chiffre_affaires, 2) }} FCFA</td>
                                    <td class="text-end">{{ number_format($p->cout_achat_total, 2) }} FCFA</td>
                                    <td class="text-end fw-bold {{ $p->marge_totale >= 0 ? 'text-success' : 'text-danger' }}">
                                        {{ number_format($p->marge_totale, 2) }} FCFA
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-marge">
                                            {{ $p->taux_marge ?? 0 }}%
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge {{ $p->quantite_stock > 10 ? 'bg-success' : ($p->quantite_stock > 0 ? 'bg-warning' : 'bg-danger') }}">
                                            {{ $p->quantite_stock }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                                
                                @if($produits->isEmpty())
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                                        <span class="text-muted">Aucune donnée de vente sur cette période</span>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const trendData = {!! json_encode($trend) !!};
    
    const labels = trendData.map(item => {
        const date = new Date(item.date);
        return date.toLocaleDateString('fr-FR', { day: '2-digit', month: '2-digit' });
    });
    
    const ventesData = trendData.map(item => item.total_ventes);
    const caData = trendData.map(item => item.chiffre_affaires);

    const ctx = document.getElementById('salesTrend').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Quantité vendue',
                    data: ventesData,
                    borderColor: 'rgba(13, 110, 110, 1)',
                    backgroundColor: 'rgba(13, 110, 110, 0.1)',
                    tension: 0.4,
                    yAxisID: 'y'
                },
                {
                    label: 'Chiffre d\'affaires (FCFA)',
                    data: caData,
                    borderColor: 'rgba(251, 201, 38, 1)',
                    backgroundColor: 'rgba(251, 201, 38, 0.1)',
                    tension: 0.4,
                    yAxisID: 'y1'
                }
            ]
        },
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            scales: {
                x: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Dates'
                    }
                },
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Quantité vendue'
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Chiffre d\'affaires (FCFA)'
                    },
                    grid: {
                        drawOnChartArea: false,
                    },
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    mode: 'index',
                    intersect: false
                }
            }
        }
    });
});
</script>
@endsection