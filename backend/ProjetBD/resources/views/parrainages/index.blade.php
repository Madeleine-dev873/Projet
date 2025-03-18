<!-- resources/views/parrainages/index.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Liste des Parrainages</h1>
    <a href="{{ route('parrainages.create') }}">Créer un nouveau parrainage</a>

    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($parrainages as $parrainage)
                <tr>
                    <td>{{ $parrainage->nom }}</td>
                    <td>{{ $parrainage->prenom }}</td>
                    <td>{{ $parrainage->email }}</td>
                    <td>
                        <a href="{{ route('parrainages.show', $parrainage->id) }}">Voir</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
