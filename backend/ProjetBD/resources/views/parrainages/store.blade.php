@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Parrainer le candidat</h1>

    <div class="card">
        <div class="card-body">
            <h3>{{ $candidat->prenom }} {{ $candidat->nom }}</h3>
            <p><strong>Email :</strong> {{ $candidat->email }}</p>
            <p><strong>Parti :</strong> {{ $candidat->parti }}</p>
        </div>
    </div>

    <form action="{{ route('parrainages.store') }}" method="POST">
        @csrf

        <!-- ID du candidat -->
        <input type="hidden" name="candidat_id" value="{{ $candidat->id }}">

        <!-- ID de l'électeur (à récupérer dynamiquement) -->
        <input type="hidden" name="electeur_id" value="{{ auth()->id() }}">

        <button type="submit" class="btn btn-primary mt-3">Confirmer le Parrainage</button>
    </form>

    <a href="{{ route('home') }}" class="btn btn-secondary mt-2">Retour</a>
</div>
@endsection
