<!-- resources/views/categories/form.blade.php -->
<form method="POST" action="{{ isset($categorie) ? route('categories.update', $categorie) : route('categories.store') }}">
    @csrf
    @if(isset($categorie)) @method('PUT') @endif

    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4 text-gray-800">
            {{ isset($categorie) ? 'Modifier la Catégorie' : 'Nouvelle Catégorie' }}
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Nom -->
            <div>
                <label for="nom" class="block text-sm font-medium text-gray-700 mb-2">Nom *</label>
                <input type="text" id="nom" name="nom" value="{{ old('nom', $categorie->nom ?? '') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
                @error('nom')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <a href="{{ route('categories.index') }}"
                class="mr-4 px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                Annuler
            </a>
            <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                {{ isset($categorie) ? 'Mettre à jour' : 'Créer' }}
            </button>
        </div>
    </div>
</form>