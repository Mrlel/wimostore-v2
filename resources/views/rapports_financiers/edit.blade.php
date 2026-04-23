@extends('layouts.app')

@section('title', 'Modifier le Rapport Financier - ' . $rapport->periode)

@section('content')
<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-4 w-100 w-md-auto">
        <div>
            <h1 class="h2 text-dark fw-bold d-flex align-items-center flex-wrap">
                <i class="bi bi-pencil-square me-2" style="color: #fbc926;"></i>
                Modifier le Rapport Financier
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('rapports-financiers.index') }}">Rapports Financiers</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('rapports-financiers.show', $rapport) }}">{{ $rapport->periode }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Modification</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex">
            <a  href="{{ url()->previous() }}" class="btn btn-outline-dark">
                <i class="bi bi-arrow-left me-1"></i>
                Retour
            </a>
        </div>
    </div>

    <!-- Formulaire -->
    <div class="card border-0">
        <div class="card-body">
            <form action="{{ route('rapports-financiers.update', $rapport) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <!-- Informations de base -->
                    <div class="col-lg-6 mb-4">
                        <div class="card border-0 h-100">
                            <div class="card-header bg-white py-3 border-bottom">
                                <h5 class="mb-0 text-dark fw-bold">
                                    <i class="bi bi-info-circle me-2" style="color: #fbc926;"></i>
                                    Informations de base
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="type_rapport" class="form-label fw-semibold">
                                        Type de rapport <span class="text-danger">*</span>
                                    </label>
                                    <select name="type_rapport" id="type_rapport" 
                                            class="form-control border-1 border-dark @error('type_rapport') is-invalid @enderror" 
                                            required>
                                        <option value="">Sélectionner un type</option>
                                        @foreach($typesRapport as $type)
                                            <option value="{{ $type }}" {{ old('type_rapport', $rapport->type_rapport) == $type ? 'selected' : '' }}>
                                                {{ ucfirst($type) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('type_rapport')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="date_debut" class="form-label fw-semibold">
                                                Date de début <span class="text-danger">*</span>
                                            </label>
                                            <input type="date" name="date_debut" id="date_debut" 
                                                   class="form-control border-1 border-dark @error('date_debut') is-invalid @enderror" 
                                                   value="{{ old('date_debut', $rapport->date_debut->format('Y-m-d')) }}" required>
                                            @error('date_debut')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="date_fin" class="form-label fw-semibold">
                                                Date de fin <span class="text-danger">*</span>
                                            </label>
                                            <input type="date" name="date_fin" id="date_fin" 
                                                   class="form-control border-1 border-dark @error('date_fin') is-invalid @enderror" 
                                                   value="{{ old('date_fin', $rapport->date_fin->format('Y-m-d')) }}" required>
                                            @error('date_fin')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Coûts fixes -->
                    <div class="col-lg-6 mb-4">
                        <div class="card border-0 h-100">
                            <div class="card-header bg-white py-3 border-bottom">
                                <h5 class="mb-0 text-dark fw-bold">
                                    <i class="bi bi-cash-coin me-2" style="color: #fbc926;"></i>
                                    Coûts fixes (dépenses)
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="loyer" class="form-label fw-semibold">Loyer (FCFA)</label>
                                            <input type="number" name="loyer" id="loyer" 
                                                   class="form-control border-1 border-dark @error('loyer') is-invalid @enderror" 
                                                   value="{{ old('loyer', $rapport->loyer) }}" min="0" step="0.01">
                                            @error('loyer')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="electricite" class="form-label fw-semibold">Électricité (FCFA)</label>
                                            <input type="number" name="electricite" id="electricite" 
                                                   class="form-control border-1 border-dark @error('electricite') is-invalid @enderror" 
                                                   value="{{ old('electricite', $rapport->electricite) }}" min="0" step="0.01">
                                            @error('electricite')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="eau" class="form-label fw-semibold">Eau (FCFA)</label>
                                            <input type="number" name="eau" id="eau" 
                                                   class="form-control border-1 border-dark @error('eau') is-invalid @enderror" 
                                                   value="{{ old('eau', $rapport->eau) }}" min="0" step="0.01">
                                            @error('eau')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="internet" class="form-label fw-semibold">Internet (FCFA)</label>
                                            <input type="number" name="internet" id="internet" 
                                                   class="form-control border-1 border-dark @error('internet') is-invalid @enderror" 
                                                   value="{{ old('internet', $rapport->internet) }}" min="0" step="0.01">
                                            @error('internet')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="maintenance" class="form-label fw-semibold">Maintenance (FCFA)</label>
                                            <input type="number" name="maintenance" id="maintenance" 
                                                   class="form-control border-1 border-dark @error('maintenance') is-invalid @enderror" 
                                                   value="{{ old('maintenance', $rapport->maintenance) }}" min="0" step="0.01">
                                            @error('maintenance')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="autres_charges" class="form-label fw-semibold">Autres charges (FCFA)</label>
                                            <input type="number" name="autres_charges" id="autres_charges" 
                                                   class="form-control border-1 border-dark @error('autres_charges') is-invalid @enderror" 
                                                   value="{{ old('autres_charges', $rapport->autres_charges) }}" min="0" step="0.01">
                                            @error('autres_charges')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Remarques -->
                <div class="card border-0 mb-4">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="mb-0 text-dark fw-bold">
                            <i class="bi bi-chat-dots me-2" style="color: #fbc926;"></i>
                            Remarques
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <textarea name="remarques" id="remarques" rows="3" 
                                      class="form-control border-1 border-dark @error('remarques') is-invalid @enderror" 
                                      placeholder="Ajoutez des remarques sur ce rapport...">{{ old('remarques', $rapport->remarques) }}</textarea>
                            @error('remarques')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('rapports-financiers.show', $rapport) }}" class="btn btn-outline-dark">
                        <i class="bi bi-arrow-left me-1"></i>
                        Retour au rapport
                    </a>
                    <button type="submit" class="btn text-dark fw-bold" style="background-color: #fbc926;">
                        <i class="bi bi-save me-1"></i>
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

<style>
    .card {
        border: 2px solid #000;
    }
    
    .card-header {
        border-bottom: 2px solid #000 !important;
    }
    
    .btn:hover {
        opacity: 0.9;
    }
    
    .border-bottom {
        border-color: #fbc926 !important;
    }
    
    .breadcrumb {
        background-color: transparent;
        padding: 0;
    }
    
    .form-control:focus {
        border-color: #fbc926;
        box-shadow: 0 0 0 0.2rem rgba(255, 222, 89, 0.25);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Validation des dates
        const dateDebut = document.getElementById('date_debut');
        const dateFin = document.getElementById('date_fin');
        
        dateFin.addEventListener('change', function() {
            if (dateDebut.value && this.value < dateDebut.value) {
                alert('La date de fin doit être postérieure à la date de début');
                this.value = dateDebut.value;
            }
        });

        // Auto-remplir les dates selon le type de rapport
        const typeRapport = document.getElementById('type_rapport');
        
        typeRapport.addEventListener('change', function() {
            const today = new Date();
            let startDate, endDate;
            
            switch(this.value) {
                case 'quotidien':
                    startDate = endDate = today;
                    break;
                case 'hebdomadaire':
                    startDate = new Date(today);
                    startDate.setDate(today.getDate() - 6);
                    endDate = today;
                    break;
                case 'mensuel':
                    startDate = new Date(today.getFullYear(), today.getMonth(), 1);
                    endDate = new Date(today.getFullYear(), today.getMonth() + 1, 0);
                    break;
                case 'annuel':
                    startDate = new Date(today.getFullYear(), 0, 1);
                    endDate = new Date(today.getFullYear(), 11, 31);
                    break;
                default:
                    return;
            }
            
            dateDebut.value = startDate.toISOString().split('T')[0];
            dateFin.value = endDate.toISOString().split('T')[0];
        });
    });
</script>
@endsection