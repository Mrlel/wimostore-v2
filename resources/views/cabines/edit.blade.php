@extends('layouts.base')
@section('content')
    @include('layouts.message')

    <h2>Modifier la cabine <span class="text-success">{{ $cabine->nom_cab }}</span></h2>
<form method="POST" action="{{ route('admin.cabines.update', $cabine->id) }}" id="editCabineForm">
            @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nom de la cabine</label>
                        <input type="text" name="nom_cab" id="edit_nom_cab" value="{{ $cabine->nom_cab }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Localisation</label>
                        <input type="text" name="localisation" id="edit_localisation" value="{{ $cabine->localisation }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nombre maximal d'utilisateurs</label>
                        <input type="number" name="max_utilisateurs" id="edit_max_utilisateurs" value="{{ $cabine->max_utilisateurs }}" class="form-control" min="1" required>
                    </div>
                    <div class="mb-3">
    <label class="form-label">
        Statut du compte 
        <span class="text-danger"><i class="bi bi-info-circle"></i></span>
    </label>
    <select name="type_compte" id="edit_type_compte" class="form-select">
        <option value="standard" {{ $cabine->type_compte == 'standard' ? 'selected' : '' }}>Compte Standard</option>
        <option value="illimite" {{ $cabine->type_compte == 'illimite' ? 'selected' : '' }}>Compte Illimité</option>
    </select>
</div>

                    <input type="text" name="code" id="edit_code" value="{{ $cabine->code }}" readonly>

                </div>

                <div class="modal-footer gap-3">
                    <button type="submit" class="btn bg-dark text-white"> <i class="bi bi-save"></i> Enregistrer</button>
                </div>
        </form>
@endsection