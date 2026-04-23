@extends('layouts.app')
@section('title', 'Nouvelle Vente')
@section('content')
    <!-- resources/views/ventes/create.blade.php -->
<form method="POST" action="{{ route('ventes.store') }}" id="vente-form" class="needs-validation" novalidate>
    @csrf

    <div class="card border-0 mb-4">
        <div class="card-header bg-white py-3 border-bottom">
            <h2 class="h4 mb-0 text-dark fw-bold">
                <i class="bi bi-cart-plus me-2" style="color: #fbc926;"></i>
                Nouvelle Vente
            </h2>
        </div>

        <div class="card-body p-4">
          
            
            <div class="row mb-4">
                  <!--<div class="col-md-4 mb-3">
                    <label for="type_client" class="form-label fw-semibold">Type de client <span class="text-danger">*</span></label>
                    <select id="type_client" name="type_client" required
                        class="form-select border-1 border-dark">
                        <option value="particulier" {{ old('type_client') == 'particulier' ? 'selected' : '' }}>Particulier</option>
                        <option value="professionnel" {{ old('type_client') == 'professionnel' ? 'selected' : '' }}>Professionnel</option>
                        <option value="divers" {{ old('type_client') == 'divers' ? 'selected' : '' }}>Divers</option>
                    </select>
                </div>-->

                <div class="col-md-4 mb-3">
                    <label for="nom_client" class="form-label fw-semibold">Nom du client</label>
                    <input type="text" id="nom_client" name="nom_client" value="{{ old('nom_client') }}"
                        class="form-control border-1 border-dark"
                        placeholder="Nom complet">
                </div>

                <div class="col-md-4 mb-3">
                    <label for="contact_client" class="form-label fw-semibold">Contact</label>
                    <input type="text" id="contact_client" name="contact_client" value="{{ old('contact_client') }}"
                        class="form-control border-1 border-dark"
                        placeholder="Téléphone ou email">
                </div>
            </div>

            <!-- Ajout de produits -->
            <h5 class="mb-4 text-dark border-bottom pb-2">
                <i class="bi bi-basket me-2" style="color: #fbc926;"></i>Produits à vendre
            </h5>
            
            <div class="row mb-4" id="ajout-produit">
                <div class="col-md-3 mb-2">
                    <select id="produit_select" class="form-select border-1 border-dark">
                        <option value="">Sélectionner un produit</option>
                        @foreach($produits as $produit)
                            <option value="{{ $produit->id }}" 
                                data-prix="{{ $produit->prix_vente }}"
                                data-stock="{{ $produit->quantite_stock }}">
                                {{ $produit->nom }} {{ $produit->marque }} - {{ $produit->prix_vente }}FCFA
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 mb-2">
                    <input type="number" id="quantite_input" min="1" value="1" 
                        class="form-control border-1 border-dark" placeholder="Quantité">
                </div>
                <div class="col-md-3 mb-2">
                    <input type="number" id="prix_input" step="0.01"
                        class="form-control border-1 border-dark" placeholder="Prix unitaire">
                </div>
                <div class="col-md-2 mb-2">
                    <button type="button" onclick="ajouterProduit()"
                        class="btn w-100 text-dark fw-bold" style="background-color: #fbc926;">
                        <i class="bi bi-plus-circle me-1"></i>Ajouter
                    </button>
                </div>
                <div class="col-md-2 mb-2">
                    <button type="button" onclick="viderPanier()"
                        class="btn btn-outline-danger w-100">
                        <i class="bi bi-trash me-1"></i>Vider
                    </button>
                </div>
            </div>

            <!-- Tableau des produits -->
            <div class="table-responsive mb-4">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th class="border-dark">Produit</th>
                            <th class="border-dark">Quantité</th>
                            <th class="border-dark">Prix unitaire</th>
                            <th class="border-dark">Total</th>
                            <th class="border-dark">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="produits-list" class="bg-white">
                        <!-- Les produits seront ajoutés ici dynamiquement -->
                    </tbody>
                    <tfoot class="table-dark">
                        <tr>
                            <td colspan="3" class="text-end fw-bold border-dark">Total</td>
                            <td class="fw-bold border-dark" id="total-vente">0 FCFA</td>
                            <td class="border-dark"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Paiement -->
            <h5 class="mb-3 text-dark border-bottom pb-2">
                <i class="bi bi-credit-card me-2" style="color: #fbc926;"></i>Paiement
            </h5>
            
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label for="mode_paiement" class="form-label fw-semibold">Mode de paiement <span class="text-danger">*</span></label>
                    <select id="mode_paiement" name="mode_paiement" required
                        class="form-select border-1 border-dark">
                        <option value="especes">Espèces</option>
                        <option value="carte">Carte bancaire</option>
                        <option value="mobile">Paiement mobile</option>
                        <option value="virement">Virement</option>
                        <option value="autre">Autre</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="montant_regle" class="form-label fw-semibold">Montant réglé <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-dark">FCFA</span>
                        <input type="number" step="0.01" id="montant_regle" name="montant_regle" 
                            value="{{ old('montant_regle') }}" required
                            class="form-control border-1 border-dark">
                    </div>
                </div>
            </div>

            <!-- Remarques -->
            <div class="mb-4">
                <label for="remarques" class="form-label fw-semibold">Remarques</label>
                <textarea id="remarques" name="remarques" rows="3"
                    class="form-control border-1 border-dark">{{ old('remarques') }}</textarea>
            </div>
        </div>

        <div class="card-footer bg-white py-3 d-flex justify-content-end">
            <a href="{{ route('ventes.index') }}"
                class="btn btn-outline-dark me-3">
                <i class="bi bi-x-circle me-1"></i>Annuler
            </a>
            <button type="submit" class="btn text-dark fw-bold" style="background-color: #fbc926;">
                <i class="bi bi-check-circle me-1"></i>
                Enregistrer la vente
            </button>
        </div>
    </div>

    <!-- Champ caché pour les lignes de vente -->
    <input type="hidden" name="lignes" id="lignes-input">
</form>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

<style>
    .card {
        border: 2px solid #000;
    }
    
    .card-header {
        border-bottom: 2px solid #000 !important;
    }
    
    .table th, .table td {
        border-color: #000 !important;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #fbc926;
        box-shadow: 0 0 0 0.25rem rgba(255, 222, 89, 0.25);
    }
    
    .btn:hover {
        opacity: 0.9;
    }
    
    .border-bottom {
        border-color: #fbc926 !important;
    }
    
    #produits-list tr:hover {
        background-color: rgba(255, 222, 89, 0.1) !important;
    }
</style>

<script>
    let produitsVente = [];
    let nextId = 1;

    function ajouterProduit() {
        const produitSelect = document.getElementById('produit_select');
        const quantiteInput = document.getElementById('quantite_input');
        const prixInput = document.getElementById('prix_input');
        
        const produitId = produitSelect.value;
        const produitText = produitSelect.options[produitSelect.selectedIndex].text;
        const quantite = parseInt(quantiteInput.value);
        const prix = parseFloat(prixInput.value);
        const stock = parseInt(produitSelect.options[produitSelect.selectedIndex].getAttribute('data-stock'));

        if (!produitId || quantite <= 0 || prix <= 0) {
            showAlert('Veuillez remplir tous les champs correctement', 'warning');
            return;
        }

        if (quantite > stock) {
            showAlert('Stock insuffisant! Stock disponible: ' + stock, 'danger');
            return;
        }

        const ligne = {
            id: nextId++,
            produit_id: produitId,
            produit_text: produitText,
            quantite: quantite,
            prix_unitaire: prix,
            sous_total: quantite * prix
        };

        produitsVente.push(ligne);
        mettreAJourTableau();
        calculerTotal();

        // Réinitialiser les champs
        quantiteInput.value = 1;
        prixInput.value = '';
        produitSelect.value = '';
        
        showAlert('Produit ajouté au panier', 'success');
    }

    function supprimerProduit(id) {
        produitsVente = produitsVente.filter(p => p.id !== id);
        mettreAJourTableau();
        calculerTotal();
        showAlert('Produit retiré du panier', 'info');
    }

    function viderPanier() {
        if (produitsVente.length === 0) {
            showAlert('Le panier est déjà vide', 'info');
            return;
        }
        
        if (confirm('Êtes-vous sûr de vouloir vider tout le panier ?')) {
            produitsVente = [];
            mettreAJourTableau();
            calculerTotal();
            showAlert('Panier vidé', 'info');
        }
    }

    function mettreAJourTableau() {
        const tbody = document.getElementById('produits-list');
        tbody.innerHTML = '';

        if (produitsVente.length === 0) {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td colspan="5" class="text-center py-4 text-muted">
                    <i class="bi bi-cart-x me-2"></i>Aucun produit ajouté
                </td>
            `;
            tbody.appendChild(tr);
        } else {
            produitsVente.forEach(ligne => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="align-middle">${ligne.produit_text}</td>
                    <td class="align-middle">${ligne.quantite}</td>
                    <td class="align-middle">${ligne.prix_unitaire} FCFA</td>
                    <td class="align-middle fw-semibold">${ligne.sous_total} FCFA</td>
                    <td class="align-middle">
                        <button type="button" onclick="supprimerProduit(${ligne.id})" 
                            class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }

        // Mettre à jour le champ caché
        document.getElementById('lignes-input').value = JSON.stringify(produitsVente);
    }

    function calculerTotal() {
        const total = produitsVente.reduce((sum, ligne) => sum + ligne.sous_total, 0);
        document.getElementById('total-vente').textContent = total + ' FCFA';
        document.getElementById('montant_regle').value = total;
    }

    function showAlert(message, type) {
        // Créer une alerte Bootstrap temporaire
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
        alertDiv.style.top = '20px';
        alertDiv.style.right = '20px';
        alertDiv.style.zIndex = '1050';
        alertDiv.style.minWidth = '300px';
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(alertDiv);
        
        // Supprimer l'alerte après 3 secondes
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.parentNode.removeChild(alertDiv);
            }
        }, 3000);
    }

    document.getElementById('vente-form').addEventListener('submit', function(e) {
        if (produitsVente.length === 0) {
            e.preventDefault();
            showAlert('Veuillez ajouter au moins un produit', 'danger');
            
            // Scroll to products section
            document.getElementById('ajout-produit').scrollIntoView({
                behavior: 'smooth'
            });
        }
    });

    // Auto-remplir le prix lors de la sélection d'un produit
    document.getElementById('produit_select').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value) {
            document.getElementById('prix_input').value = selectedOption.getAttribute('data-prix');
        }
    });

    // Initialiser le tableau
    mettreAJourTableau();
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection