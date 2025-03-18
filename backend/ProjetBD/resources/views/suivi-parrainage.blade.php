@extends('layouts.app') {{-- Étend un layout de base si nécessaire --}}

@section('content')
<style>
    .background-section {
        background-image: url('{{ asset('images/ton_image.jpg') }}');
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        height: 100vh;
    }
</style>
<div class="container background-section">
    <h1>État des Parrainages</h1>
    
    {{-- Formulaire de connexion --}}
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <label for="email">📩 Adresse Email :</label>
        <input type="email" id="email" name="email" required placeholder="Saisissez votre email">

        <label for="code_validation">🔑 Code d'Accès :</label>
        <input type="text" id="code_validation" name="code_validation" required placeholder="Saisissez votre code secret">

        <button type="submit">Connexion</button>
    </form>

    {{-- Messages de succès ou d'erreur --}}
    @if(session('success'))
        <p style="color: green;">✅ {{ session('success') }}</p>
    @endif
    @if(session('error'))
        <p style="color: red;">❌ {{ session('error') }}</p>
    @endif

    {{-- Section des parrainages (affiché après connexion) --}}
    @if(isset($parrainages) && count($parrainages) > 0)
        <div id="parrainage-details" class="parrainage-details">
            <h3>🔍 Suivi des Parrainages</h3>
            <ul>
                @foreach($parrainages as $parrainage)
                    <li>📅 {{ $parrainage->date }} : <strong>{{ $parrainage->nombre }}</strong> parrainages</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
@endsection
