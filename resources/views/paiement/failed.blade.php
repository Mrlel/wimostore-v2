@extends('layouts.app')
@section('title', 'Paiement échoué')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">

        <div class="card border-0 shadow-sm text-center" style="border-radius:20px;overflow:hidden;">
            <div class="card-body py-5 px-4" style="background:#1A2E35;">
                <div style="width:72px;height:72px;background:#FEE2E2;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1.2rem;">
                    <i class="bi bi-x-lg" style="font-size:2rem;color:#EF4444;"></i>
                </div>
                <h2 class="fw-bold text-white mb-1">Paiement échoué</h2>
                <p class="mb-0" style="color:rgba(255,255,255,.6);font-size:13px;">
                    La transaction n'a pas pu être finalisée
                </p>
            </div>

            <div class="card-body p-4">
                <div class="card border-0 mb-4" style="background:#f8f8f8;border-radius:14px;">
                    <div class="card-body py-3">
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <small class="text-muted">Boutique</small>
                            <small class="fw-semibold">{{ $paiement->abonnement->cabine->nom_cab }}</small>
                        </div>
                        <div class="d-flex justify-content-between py-2">
                            <small class="text-muted">Montant</small>
                            <small class="fw-bold">{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</small>
                        </div>
                    </div>
                </div>

                <div class="alert border-0 mb-4 d-flex align-items-center gap-2" style="background:#FEF3C7;border-radius:12px;">
                    <i class="bi bi-info-circle-fill" style="color:#F59E0B;flex-shrink:0;"></i>
                    <small>Vérifiez votre solde ou essayez avec un autre numéro de téléphone.</small>
                </div>

                <div class="d-flex flex-column gap-2">
                    <a href="{{ route('abonnement.renouveler', $paiement->abonnement->cabine_id) }}"
                       class="btn fw-bold py-3" style="background:#fbc926;border-radius:12px;font-size:15px;">
                        <i class="bi bi-arrow-repeat me-2"></i> Réessayer le paiement
                    </a>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-dark py-2" style="border-radius:12px;">
                        <i class="bi bi-house me-2"></i> Retour au tableau de bord
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
