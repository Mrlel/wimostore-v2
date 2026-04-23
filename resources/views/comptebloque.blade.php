@extends('layouts.app')
@section('title', 'Renouveler mon abonnement')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">

        <div class="alert border-0 shadow-sm d-flex align-items-center gap-2 mb-4" style="background:#FEF3C7;border-radius:12px;">
            <i class="bi bi-exclamation-triangle-fill" style="color:#F59E0B;font-size:18px;flex-shrink:0;"></i>
            <span>Votre abonnement a expiré, Renouvelez le pour retrouver l'accès complet.
            </span>
        </div>
      

        {{-- Prix --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius:16px;overflow:hidden;">
            <div class="card-body text-center py-4" style="background:#1A2E35;">
                <p class="text-white-50 mb-1" style="font-size:12px;letter-spacing:.08em;text-transform:uppercase;">Abonnement mensuel</p>
                <div class="fw-bold text-white" style="font-size:2.4rem;line-height:1;">
                    {{ number_format(5000, 0, ',', ' ') }} FCFA
                </div>
                <p class="text-white-50 mt-1 mb-0" style="font-size:13px;">pour 30 jours d'accès complet</p>
            </div>
            <div class="card-body bg-white py-3">
                <div class="row text-center g-0">
                    @foreach(['Boutique en ligne','Gestion des ventes','Rapports financiers'] as $feat)
                    <div class="col-4">
                        <i class="bi bi-check-circle-fill text-success mb-1 d-block"></i>
                        <small class="text-muted" style="font-size:11px;">{{ $feat }}</small>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Formulaire --}}
        <div class="card border-0 shadow-sm" style="border-radius:16px;">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-person-circle me-2" style="color:#fbc926;"></i>Vos informations
                </h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('abonnement.initierRenouvellement', $cabine->id) }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nom complet</label>
                        <input type="text" name="nom" class="form-control border-1 border-dark"
                               value="{{ auth()->user()->nom ?? '' }}" required
                               placeholder="Votre nom complet">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Adresse email</label>
                        <input type="email" name="email" class="form-control border-1 border-dark"
                               value="{{ auth()->user()->email ?? '' }}" required
                               placeholder="votre@email.com">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            Téléphone
                            <small class="text-muted fw-normal">(Orange Money / MTN MoMo)</small>
                        </label>
                        <input type="tel" name="telephone" class="form-control border-1 border-dark"
                               value="{{ auth()->user()->numero ?? '' }}" required
                               placeholder="0707070707">
                    </div>

                    <button type="submit" class="btn fw-bold w-100 py-3" style="background-color:#fbc926;border-radius:10px;font-size:15px;">
                        <i class="bi bi-credit-card me-2"></i>
                        Payer {{ number_format(5000, 0, ',', ' ') }} FCFA et renouveler
                    </button>
                </form>

                <p class="text-center text-muted mt-3 mb-0" style="font-size:12px;">
                    <i class="bi bi-shield-lock me-1"></i> Paiement sécurisé par FedaPay
                </p>
            </div>
        </div>

    </div>
</div>

@endsection
