@extends('layouts.app')

@section('content')
<div class="container">

    @csrf
   

    <h1>Parrainer le candidat {{ $candidat->prenom }} {{ $candidat->nom }}</h1>


    
        @csrf
        
        <input type="hidden" name="candidat_id" value="{{ $candidat->id }}">
        
        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" name="nom" class="form-control" id="nom" required>
        </div>

        <div class="form-group">
            <label for="prenom">Prénom</label>
            <input type="text" name="prenom" class="form-control" id="prenom" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" id="email" required>
        </div>

        <a href="{{ route('parrainages.store', $candidat->idCandidat) }}" class="btn btn-primary">Soumettre le Parrainage</a>
    </form>
</div>
@endsection
