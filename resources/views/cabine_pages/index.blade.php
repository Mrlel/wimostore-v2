@extends('layouts.base')
@section('title', 'Sites vitrines')

@section('content')

<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
    <div>
        <h1 class="h2 text-dark fw-bold d-flex align-items-center">
            <i class="bi bi-globe me-2" style="color:#f0c61d;"></i>
            Sites vitrines
        </h1>
        <p class="text-muted mb-0">Gérez les boutiques en ligne de vos cabines</p>
    </div>
    <a href="{{ route('cabine_pages.create') }}" class="btn fw-bold text-dark" style="background:#f0c61d;">
        <i class="bi bi-plus-circle me-1"></i> Nouvelle boutique
    </a>
</div>

<div class="card border-0">
    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
        <h5 class="mb-0 text-dark fw-bold">
            <i class="bi bi-list-ul me-2" style="color:#f0c61d;"></i>
            Liste des boutiques
        </h5>
        <span class="badge bg-dark fs-6" id="resultCount">{{ $pages->count() }} boutique(s)</span>
    </div>

    <div class="card-body border-bottom bg-light py-3">
        <div class="input-group" style="max-width:400px;">
            <span class="input-group-text bg-white border-dark"><i class="bi bi-search text-muted"></i></span>
            <input type="text" id="searchPages" class="form-control border-dark"
                   placeholder="Rechercher par boutique, titre ou statut...">
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 table-card-mobile">
                <thead class="table-dark">
                    <tr>
                        <th>Boutique</th>
                        <th>Titre</th>
                        <th class="text-center">Statut</th>
                        <th>Créée le</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody id="pagesTableBody">
                    @forelse($pages as $page)
                    <tr class="page-row"
                        data-titre="{{ strtolower($page->titre ?? '') }}"
                        data-cabine="{{ strtolower($page->cabine->nom_cab ?? '') }}"
                        data-statut="{{ $page->est_publiee ? 'publiée' : 'brouillon' }}">

                        <td class="align-middle" data-label="Boutique">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-shop text-muted"></i>
                                <span class="fw-semibold text-dark">{{ $page->cabine->nom_cab ?? '—' }}</span>
                            </div>
                        </td>
                        <td class="align-middle" data-label="Titre">
                            <span class="fw-bold text-dark">{{ $page->titre ?? 'Sans titre' }}</span>
                        </td>
                        <td class="text-center align-middle" data-label="Statut">
                            <span class="badge {{ $page->est_publiee ? 'bg-success' : 'bg-secondary' }}">
                                {{ $page->est_publiee ? 'Publiée' : 'Brouillon' }}
                            </span>
                        </td>
                        <td class="align-middle" data-label="Créée le">
                            <small class="text-muted">{{ $page->created_at->format('d/m/Y') }}</small>
                        </td>
                        <td class="text-center align-middle">
                            <div class="btn-group" role="group">
                                <a href="{{ route('cabine_pages.edit', $page->id) }}"
                                   class="btn btn-sm btn-outline-dark" title="Modifier">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="{{ $page->cabine->public_url }}" target="_blank"
                                   class="btn btn-sm btn-outline-dark" title="Voir">
                                    <i class="bi bi-globe"></i>
                                </a>
                                <form action="{{ route('cabine_pages.destroy', $page->id) }}" method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Supprimer cette boutique ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr id="emptyRow">
                        <td colspan="5" class="text-center py-5">
                            <i class="bi bi-globe fs-1 text-muted d-block mb-2"></i>
                            <p class="text-muted mb-0">Aucune boutique créée pour l'instant</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input  = document.getElementById('searchPages');
    const rows   = document.querySelectorAll('.page-row');
    const count  = document.getElementById('resultCount');

    input.addEventListener('input', function () {
        const q = this.value.toLowerCase().trim();
        let n = 0;
        rows.forEach(row => {
            const match = !q ||
                row.dataset.titre.includes(q) ||
                row.dataset.cabine.includes(q) ||
                row.dataset.statut.includes(q);
            row.style.display = match ? '' : 'none';
            if (match) n++;
        });
        count.textContent = n + ' boutique(s)';
    });

    input.focus();
});
</script>
@endpush

@endsection
