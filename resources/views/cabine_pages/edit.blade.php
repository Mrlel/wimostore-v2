@extends('layouts.base')

@section('content')
<div class="container">
    <h2>Modifier la page publique</h2>

    <form action="{{ route('cabine_pages.update', $cabine_page->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('cabine_pages.form', ['cabine_page' => $cabine_page])
        <button type="submit" class="btn bg-dark text-white mt-3"> <i class="bi bi-save"></i> Mettre à jour</button>
    </form>
</div>
@endsection
