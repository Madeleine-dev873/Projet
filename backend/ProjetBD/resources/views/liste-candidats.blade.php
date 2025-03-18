@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @foreach($candidats as $candidat)
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="{{ asset('uploads/candidats/' . $candidat->photo) }}" class="card-img-top" alt="Photo de {{ $candidat->nom }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $candidat->prenom }} {{ $candidat->nom }}</h5>
                    <p class="card-text"><strong>Parti :</strong> {{ $candidat->partiPolitique }}</p>
                    <p class="card-text"><strong>Slogan :</strong> {{ $candidat->slogan }}</p>
                    <a href="{{ $candidat->urlInfo }}" target="_blank" class="btn btn-info">En savoir plus</a>
                    <a href="{{ route('parrainages.create', $candidat->idCandidat) }}" class="btn btn-primary">Parrainer</a>


                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
