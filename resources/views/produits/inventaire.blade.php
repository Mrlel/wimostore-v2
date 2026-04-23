@extends('layouts.app')
@section('title', 'Inventaire du Stock')
@section('content')
<div class="container-fluid py-4">

<div class="row align-items-center justify-content-between mb-4">
    <!-- Titre -->
    <div class="col-12 col-md-auto mb-3 mb-md-0">
        <h2 class="h2 h-md2 text-dark fw-bold mb-1">
            <i class="bi bi-clipboard-data me-2" style="color: #fbc926;"></i>
            Inventaire du Stock
        </h2>
    </div>

    <!-- Bouton PDF -->
    <div class="col-12 col-md-auto text-md-end">
        <a href="#" id="btnPdf" class="btn w-100 w-md-auto text-white fw-bold bg-dark">
            <i class="bi bi-file-pdf"></i> Télécharger la liste en PDF
        </a>
    </div>
</div>

<!-- Filtres -->
<div class="row g-2 my-3">
    <div class="col-12 col-md-6 col-lg-4">
        <input type="text" id="searchInput" class="form-control" placeholder=" Recherche...">
    </div>
    <div class="col-12 col-md-6 col-lg-3">
        <select id="etatFilter" class="form-select">
            <option value="">-- Tous les états --</option>
            <option value="faible">Stock faible</option>
            <option value="rupture">Rupture de stock</option>
            <option value="ok">OK</option>
        </select>
    </div>
</div>


    <div class="card border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="produitsTable" class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Catégorie</th>
                            <th>Description</th>
                            <th>Marque</th>
                            <th class="text-end">Prix Vente</th>
                            <th class="text-end">Quantité</th>
                            <th class="text-end">Seuil Alerte</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($produits as $produit)
                        <tr 
                            @if($produit->quantite_stock <= 0) style="background:#f8d7da;" 
                            @elseif($produit->quantite_stock <= $produit->seuil_alerte) style="background:#fff3cd;" @endif
                            data-etat="{{ $produit->quantite_stock <= 0 ? 'rupture' : ($produit->quantite_stock <= $produit->seuil_alerte ? 'faible' : 'ok') }}"
                        >
                            <td>{{ $produit->categorie->nom ?? '-' }}</td>
                            <td>{{ $produit->nom }}</td>
                            <td>{{ $produit->marque }}</td>
                            <td class="text-end">{{ number_format($produit->prix_vente) }} FCFA</td>
                            <td class="text-end fw-bold">{{ $produit->quantite_stock }}</td>
                            <td class="text-end">{{ $produit->seuil_alerte }}</td>
                               <td>
                                @if($produit->quantite_stock <= 0)
                                    <span class="badge bg-danger">Rupture</span>
                                @elseif($produit->quantite_stock <= $produit->seuil_alerte)
                                    <span class="badge bg-warning text-dark">Stock faible</span>
                                @else
                                    <span class="badge bg-success">OK</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted">Aucun produit trouvé.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Script recherche instantanée --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const searchInput = document.getElementById("searchInput");
        const etatFilter = document.getElementById("etatFilter");
        const rows = document.querySelectorAll("#produitsTable tbody tr");

        function filterTable() {
            const searchText = searchInput.value.toLowerCase();
            const etat = etatFilter.value;

            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                const rowEtat = row.getAttribute("data-etat");
                
                const matchText = text.includes(searchText);
                const matchEtat = etat === "" || etat === rowEtat;

                row.style.display = (matchText && matchEtat) ? "" : "none";
            });
        }

        // Recherche instantanée (avec petit délai pour éviter surcharge CPU)
        let debounce;
        searchInput.addEventListener("input", () => {
            clearTimeout(debounce);
            debounce = setTimeout(filterTable, 150);
        });

        etatFilter.addEventListener("change", filterTable);
    });
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchInput");
    const etatFilter = document.getElementById("etatFilter");
    const btnPdf = document.getElementById("btnPdf");

    function updatePdfLink() {
        const params = new URLSearchParams();
        const etat = etatFilter.value;
        const search = searchInput.value;

        if (etat) params.set('etat_stock', etat);
        if (search) params.set('search', search);

        btnPdf.href = `{{ route('inventaire.pdf') }}?${params.toString()}`;
    }

    // Mets à jour le lien quand on modifie les filtres
    searchInput.addEventListener("input", () => {
        // petit debounce facultatif
        clearTimeout(window.__debouncePdf);
        window.__debouncePdf = setTimeout(updatePdfLink, 150);
    });
    etatFilter.addEventListener("change", updatePdfLink);

    // Initialiser au chargement
    updatePdfLink();
});
</script>
@endsection
