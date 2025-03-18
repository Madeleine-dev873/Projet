<!-- resources/views/parrainages/show.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Détails du Parrainage</h1>

    <p>Nom: {{ $parrainage->nom }}</p>
    <p>Prénom: {{ $parrainage->prenom }}</p>
    <p>Email: {{ $parrainage->email }}</p>
    <p>Parrainé par le candidat avec ID: {{ $parrainage->candidat_id }}</p>

    <a href="{{ route('parrainages.index') }}">Retour à la liste</a>
@endsection
