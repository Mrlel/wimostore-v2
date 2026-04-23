@extends('layouts.app')
@section('title', 'Renouvellement réussi')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">

        <div class="card border-0 shadow-sm text-center" style="border-radius:20px;overflow:hidden;">
            <div class="card-body py-5 px-4" style="background:#1A2E35;">
                <div style="width:72px;height:72px;background:#D1FAE5;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1.2rem;">
                    <i class="bi bi-check-lg" style="font-size:2rem;color:#10B981;"></i>
                </div>
                <h2 class="fw-bold text-white mb-1">Renouvellement réussi !</h2>
                <p class="mb-0" style="color:rgba(255,255,255,.6);font-size:13px;">
                    Votre abonnement est maintenant actif
                </p>
            </div>

            <div class="card-body p-4">
                <div class="card border-0 mb-4" style="background:#f8f8f8;border-radius:14px;">
                    <div class="card-body py-3">
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <small class="text-muted">Boutique</small>
                            <small class="fw-semibold">{{ $abonnement->cabine->nom_cab }}</small>
                        </div>
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <small class="text-muted">Date de début</small>
                            <small class="fw-semibold">{{ $abonnement->date_debut->format('d/m/Y') }}</small>
                        </div>
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <small class="text-muted">Date de fin</small>
                            <small class="fw-semibold">{{ $abonnement->date_fin->format('d/m/Y') }}</small>
                        </div>
                        <div class="d-flex justify-content-between py-2">
                            <small class="text-muted">Montant payé</small>
                            <small class="fw-bold">{{ number_format($abonnement->montant, 0, ',', ' ') }} FCFA</small>
                        </div>
                    </div>
                </div>

                <a href="{{ route('dashboard') }}" class="btn fw-bold w-100 py-3" style="background:#fbc926;border-radius:12px;font-size:15px;">
                    <i class="bi bi-columns-gap me-2"></i> Accéder à mon tableau de bord
                </a>
            </div>
        </div>

    </div>
</div>

@endsection
