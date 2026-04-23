@extends('layouts.base')

@section('content')
<div class="container">
<!-- Statistiques utilisateur -->
<div class="mb-4">
                <div class="card-header bg-white py-3">
                    <h3 class="mb-0 text-dark fw-bold">
                        <i class="bi bi-graph-up me-2" style="color: #fbc926;"></i>
                        Statistiques de progression <span class="text-success fs-2">{{ $cabine->nom_cab }}</span>
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4 mb-3">
                            <div class="border rounded p-3">
                                <i class="bi bi-cart-check fs-1 text-dark mb-2"></i>
                                <h4 class="fw-bold">{{ $ventes->count() }}</h4>
                                <small class="text-muted">Ventes effectuées</small>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="border rounded p-3">
                                <i class="bi bi-box fs-1 text-dark mb-2"></i>
                                <h4 class="fw-bold">{{ $produits->count() }}</h4>
                                <small class="text-muted">Total Produits</small>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="border-0 rounded bg-white p-3">
                                <i class="bi bi-currency-euro fs-1 text-dark mb-2"></i>
                                <h4 class="fw-bold">
                                {{ number_format($cabine->ventes->sum('montant_total')) }} FCFA
                                </h4>
                                <small class="text-muted">Chiffre d'affaires</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

</div>

   <div class="mt-4">
    

    <!-- Section QR Code -->
    <div class="card border-0">
        <div class="card-header bg-white py-3 border-bottom">
            <h6 class="mb-0 text-dark fw-bold d-flex align-items-center">
                <i class="bi bi-qr-code-scan me-2" style="color: #ffde59;"></i>
                QR Code d'Accès
            </h6>
        </div>
        <div class="card-body">
            <div class="row align-items-center">
                <!-- QR Code -->
                <div class="col-md-6 col-lg-4 text-center mb-3 mb-md-0">
                    <div class="border border-2 border-dark p-3 bg-white d-inline-block rounded">
                        <div class="mb-2">
                            {!! QrCode::size(150)->generate($cabine->public_url) !!}
                        </div>
                        <small class="text-muted fw-medium">Scannez pour accéder</small>
                    </div>
                </div>
                
                <!-- Informations et Actions -->
                <div class="col-md-6 col-lg-8">
                     <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center gap-3">
                <!-- URL avec style moderne -->
                <div class="flex-grow-1">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-dark">
                            <i class="bi bi-globe text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-dark bg-white" 
                               value="{{ $cabine->public_url }}" readonly
                               id="publicUrlInput">
                        <button class="btn btn-outline-dark" type="button" 
                                onclick="copyToClipboard('publicUrlInput')"
                                data-bs-toggle="tooltip" data-bs-title="Copier le lien">
                            <i class="bi bi-clipboard"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Bouton d'ouverture -->
                <a href="{{ $cabine->public_url }}" target="_blank" 
                   class="btn text-dark fw-bold d-flex align-items-center"
                   style="background-color: #ffde59;">
                    <i class="bi bi-box-arrow-up-right me-2"></i>
                    Ouvrir
                </a>
            </div>
                    <div class="my-4">
                        <p class="text-muted mb-2">
                            <i class="bi bi-info-circle me-1"></i>
                            Ce QR code permet un accès rapide à la page publique de la cabine depuis un appareil mobile.
                        </p>
                    </div>
                    
                    <div class="d-flex flex-wrap gap-2">
                        <!-- Téléchargement QR Code -->
                        <a href="{{ route('cabines.qr.download', $cabine) }}" 
                           class="btn btn-outline-dark d-flex align-items-center">
                            <i class="bi bi-download me-2"></i>
                            Télécharger QR Code
                        </a>
                        
                        <!-- Copier le lien -->
                        <button class="btn btn-outline-dark d-flex align-items-center"
                                onclick="copyToClipboard('publicUrlInput')">
                            <i class="bi bi-link-45deg me-2"></i>
                            Copier le lien
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Style supplémentaire -->
<style>
    .card {
        border: 2px solid #000;
    }
    
    .card-header {
        border-bottom: 2px solid #000 !important;
    }
    
    .btn:hover {
        opacity: 0.9;
        transform: translateY(-1px);
        transition: all 0.2s ease;
    }
    
    .input-group-text {
        border-right: none;
    }
    
    .form-control:read-only {
        background-color: #f8f9fa;
        cursor: not-allowed;
    }
</style>
    <script>
        function copyToClipboard(inputId) {
            const input = document.getElementById(inputId);
            input.select();
            input.setSelectionRange(0, 99999); // Pour les mobiles
            document.execCommand("copy");
            alert("Lien copié dans le presse-papiers!");
        }

        function printQRCode() {
            const qrCodeDiv = document.querySelector('.border-dark');
            const printWindow = window.open('', '_blank');
            printWindow.document.write('<html><head><title>QR Code</title></head><body>');
            printWindow.document.write(qrCodeDiv.outerHTML);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
            printWindow.close();
        }
    </script>

    <!-- Utilisateurs -->
    <div class="mb-4">
      
        <h4 class="mb-2">Utilisateurs liés</h4>

        <div class="">
            @if($cabine->users->isNotEmpty())
                <ul class="list-group">
                    @foreach($cabine->users as $user)
                        <li class="list-group-item">
                            <strong><i class="bi bi-person me-2" style="color: #fbc926;"></i> {{ $user->nom }}</strong>  <i class="bi bi-phone me-2" style="color: #fbc926;"></i>{{ $user->numero }}  
                            <i class="bi bi-envelope me-2" style="color: #fbc926;"></i> <span class="badge bg-success text-capitalize">{{ $user->email }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p>Aucun utilisateur rattaché.</p>
            @endif
        </div>
    </div>
    
@endsection
