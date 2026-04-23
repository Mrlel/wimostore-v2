@extends('layouts.base')

@section('content')
<div class="container">
    <h2>Créer une page publique</h2>

    <form action="{{ route('cabine_pages.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('cabine_pages.form')
        <button type="submit" class="btn bg-dark text-white mt-3"> <i class="bi bi-save"></i> Enregistrer</button>
    </form>
</div>
@endsection
