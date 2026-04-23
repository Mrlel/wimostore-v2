@extends('layouts.app')
@section('title', 'Statistiques des Visites - Ma Boutique')
@section('content')
@include('layouts.message')
<div class="container-fluid py-4">
    @if($boutiques)
        <!-- En-tête -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-4 w-100 w-md-auto">
            <div>
                <div class="h2 text-dark fw-bold d-flex align-items-center flex-wrap">
                    <i class="bi bi-graph-up-arrow me-2" style="color: #ffde59;"></i>
                    Tableau de Bord des Visites
                </div>
                <p class="text-muted mb-0">Suivez en temps réel l'activité de votre boutique</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ $boutiques->cabine->public_url }}" 
                   target="_blank" 
                   class="btn text-dark fw-bold" style="background-color: #ffde59;">
                    <i class="bi bi-shop me-1"></i>Visiter ma boutique
                </a>
            </div>
        </div>

        <!-- Cartes statistiques principales -->
                    <div class="row">
                        <div class="col-6 col-md-4 mb-3">
                            <div class="stat-card">
                                <div class="d-flex align-items-start justify-content-between mb-3">
                                    <div style="width:38px;height:38px;border-radius:8px;background:rgba(240,198,29,0.12);border:1px solid rgba(240,198,29,0.2);display:flex;align-items:center;justify-content:center;">
                                        <i class="bi bi-people" style="color:#f0c61d;font-size:1rem;"></i>
                                    </div>
                                </div>
                                <div class="stat-info"><h3>Visites Aujourd'hui</h3></div>
                                <div class="stat-value counter" data-target="{{ $visitsToday }}">{{ $visitsToday }}</div>
                                <div class="stat-footer">
                                    <i class="bi bi-clock" style="font-size:0.75rem;"></i>
                                    aujourd'hui
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-4 mb-3">
                            <div class="stat-card">
                                <div class="d-flex align-items-start justify-content-between mb-3">
                                    <div style="width:38px;height:38px;border-radius:8px;background:rgba(240,198,29,0.12);border:1px solid rgba(240,198,29,0.2);display:flex;align-items:center;justify-content:center;">
                                        <i class="bi bi-calendar-week" style="color:#f0c61d;font-size:1rem;"></i>
                                    </div>
                                </div>
                                <div class="stat-info"><h3>Visites sur 7 jours</h3></div>
                                <div class="stat-value">{{ $visitsThisWeek }}</div>
                                <div class="stat-footer">
                                    <i class="bi bi-calendar3" style="font-size:0.75rem;"></i>
                                    cette semaine
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 mb-3">
                            <div class="stat-card">
                                <div class="d-flex align-items-start justify-content-between mb-3">
                                    <div style="width:38px;height:38px;border-radius:8px;background:rgba(240,198,29,0.12);border:1px solid rgba(240,198,29,0.2);display:flex;align-items:center;justify-content:center;">
                                        <i class="bi bi-calendar" style="color:#f0c61d;font-size:1rem;"></i>
                                    </div>
                                </div>
                                <div class="stat-info"><h3>Visites mensuelles</h3></div>
                                <div class="stat-value">{{ $visitsThisMonth }}</div>
                                <div class="stat-footer">
                                    <i class="bi bi-calendar3" style="font-size:0.75rem;"></i>
                                    ce mois
                                </div>
                            </div>
                        </div>
                    </div>

        <!-- Graphiques et analyses -->
        <div class="row">
            <!-- Graphique des 7 derniers jours -->
            <div class="col-xl-12 mb-4">
                <div class="card border-0 animate-slide-up rounded-3" data-delay="400">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="mb-0 text-dark fw-bold">
                            <i class="bi bi-graph-up me-2" style="color: #ffde59;"></i>
                            Évolution des Visites - 7 Derniers Jours
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container" style="height: 300px;">
                            <canvas id="visitsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <!-- Répartition des visites 
            <div class="col-xl-12 mb-4 rounded-3">
                <div class="card border-0 animate-slide-up" data-delay="600">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="mb-0 text-dark fw-bold">
                            <i class="bi bi-pie-chart me-2" style="color: #ffde59;"></i>
                            Répartition des Visites
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container" style="height: 250px;">
                            <canvas id="distributionChart"></canvas>
                        </div>
                    </div>
                </div>
            </div> -->
    

    @else
        <!-- État sans boutique -->
        <div class="text-center mt-2">
            <div class="card border-0 bg-light">
                <div class="card-body py-5">
                    <i class="bi bi-shop fs-1 text-dark mb-3"></i>
                    <h4 class="text-dark fw-bold">Boutique en ligne non Configurée !</h4>
                    <p class="text-muted">
                        Veuillez nous contacter pour la configuration de votre boutique en ligne.<br>
                        C'est gratuit 🥳🎉
                    </p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="https://wa.me/2250585986100?text=Bonjour, j'aimerai configuré ma boutique en ligne dont le code est le suivant : {{ urlencode(auth()->user()->cabine->code) }}" 
                           class="btn text-dark fw-bold" style="background-color: #ffde59;">
                            <i class="bi bi-whatsapp me-1"></i>Nous contacter
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
@media (max-width: 767px) {
    .chart-container {
        padding: 0 5px;
    }
}
    .icon-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .rank-badge {
        width: 30px;
        height: 30px;
        background: #ffde59;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: #000;
        font-size: 0.8rem;
    }

    /* Animations */
    .animate-fade-in {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.6s ease forwards;
    }

    .animate-slide-up {
        opacity: 0;
        transform: translateY(30px);
        animation: slideUp 0.8s ease forwards;
    }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .progress {
        background-color: #e9ecef;
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-bar {
        border-radius: 10px;
        transition: width 1.5s ease-in-out;
    }
    
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation des compteurs (corrigé : fallback si aucun data-delay ou .stat-card)
    const counters = document.querySelectorAll('.counter');
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-target')) || 0;
        const duration = 2000;
        const step = target / (duration / 16);
        let current = 0;

        // Cherche un ancêtre portant un attribut data-delay, sinon 0
        const delayAncestor = counter.closest('[data-delay]');
        const delay = delayAncestor ? parseInt(delayAncestor.getAttribute('data-delay')) || 0 : 0;

        const updateCounter = () => {
            current += step;
            if (current < target) {
                counter.textContent = Math.floor(current);
                requestAnimationFrame(updateCounter);
            } else {
                counter.textContent = target;
            }
        };

        setTimeout(updateCounter, delay);
    });

    // Animation des éléments avec délai
    const animatedElements = document.querySelectorAll('[data-delay]');
    animatedElements.forEach(element => {
        const delay = parseInt(element.getAttribute('data-delay')) || 0;
        setTimeout(() => {
            element.style.animationDelay = delay + 'ms';
        }, 100);
    });

    // Graphique des visites des 7 derniers jours (gardes si canvas absent)
    const visitsCanvas = document.getElementById('visitsChart');
    if (visitsCanvas) {
        const visitsCtx = visitsCanvas.getContext('2d');
        const visitsChart = new Chart(visitsCtx, {
            type: 'line',
            data: {
                labels: Object.keys({!! json_encode($last7Days) !!}).map(date => {
                    return new Date(date).toLocaleDateString('fr-FR', { weekday: 'short', day: 'numeric' });
                }),
                datasets: [{
                    label: 'Visites',
                    data: Object.values({!! json_encode($last7Days) !!}),
                    borderColor: '#ffde59',
                    backgroundColor: 'rgba(255, 222, 89, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#000',
                    pointBorderColor: '#ffde59',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#000',
                        titleColor: '#ffde59',
                        bodyColor: '#fff',
                        borderColor: '#ffde59',
                        borderWidth: 1
                    }
                },
                scales: {
                    y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.1)' }, ticks: { color: '#666' } },
                    x: { grid: { display: false }, ticks: { color: '#666' } }
                }
            }
        });
    }

    // Graphique de répartition (gardes si canvas absent)
    const distributionCanvas = document.getElementById('distributionChart');
    if (distributionCanvas) {
        const distributionCtx = distributionCanvas.getContext('2d');
        const distributionChart = new Chart(distributionCtx, {
            type: 'doughnut',
            data: {
                labels: ['Aujourd\'hui', 'Cette Semaine', 'Ce Mois'],
                datasets: [{
                    data: [{{ $visitsToday }}, {{ $visitsThisWeek }}, {{ $visitsThisMonth }}],
                    backgroundColor: ['#ffde59', '#000', '#6c757d'],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { color: '#333', font: { size: 12 } }
                    }
                }
            }
        });
    }

    // Animation des barres de progression
    const progressBars = document.querySelectorAll('.progress-bar');
    progressBars.forEach(bar => {
        const width = bar.style.width;
        bar.style.width = '0%';
        setTimeout(() => {
            bar.style.width = width;
        }, 1000);
    });
});
</script>
@endsection