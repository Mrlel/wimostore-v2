@extends('layouts.app')
@section('title', 'Commandes boutique')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 fw-bold mb-0">Commandes boutique</h1>
        <a href="{{ route('boutique.suivi', auth()->user()->cabine->code) }}" target="_blank" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-external-link-alt"></i> Page suivi public
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Numéro</th>
                            <th>Client</th>
                            <th>Téléphone</th>
                            <th>Total</th>
                            <th>Statut</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($commandes as $commande)
                        <tr>
                            <td><code>{{ $commande->numero_commande }}</code></td>
                            <td>{{ $commande->nom_client }}</td>
                            <td>{{ $commande->telephone_client }}</td>
                            <td>{{ number_format($commande->montant_total,0,',',' ') }} FCFA</td>
                            <td>
                                <span class="badge rounded-pill" style="background:{{ $commande->statut_color }}22;color:{{ $commande->statut_color }};border:1px solid {{ $commande->statut_color }}44;">
                                    {{ $commande->statut_label }}
                                </span>
                            </td>
                            <td>{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <form method="POST" action="{{ route('commandes.statut', $commande->id) }}" class="d-flex gap-1">
                                    @csrf @method('PATCH')
                                    <select name="statut" class="form-select form-select-sm" style="width:auto;">
                                        @foreach(['en_attente'=>'En attente','confirmee'=>'Confirmée','en_preparation'=>'En préparation','expediee'=>'Expédiée','livree'=>'Livrée','annulee'=>'Annulée'] as $val=>$label)
                                        <option value="{{ $val }}" {{ $commande->statut===$val?'selected':'' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-dark">OK</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center py-5 text-muted">Aucune commande pour le moment.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-3">{{ $commandes->links() }}</div>
</div>
@endsection
