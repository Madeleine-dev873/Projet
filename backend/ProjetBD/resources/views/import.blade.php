@extends('layouts.app')

@section('content')

<style>
    body {
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background-image: url("https://www.francophonie.org/sites/default/files/2024-11/3_0.jpg");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    /* Cache la section Laravel login et autres */
    .navbar,
    .footer {
        display: none;
    }

    .container {
        width: 750px;
        max-width: 900px;
        background-color: transparent; /* Fond transparent */
        padding: 40px;
        text-align: center;
        box-shadow: none; /* Supprimer l'ombre */
    }

    h2 {
        color: #ffffff;
        font-size: 28px;
        margin-bottom: 20px;
    }

    label {
        color: #ffffff;
        font-weight: bold;
        display: block;
        text-align: left;
        margin-bottom: 5px;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 5px;
        border: none;
        background-color: rgba(255, 255, 255, 0.8); /* Fond blanc légèrement transparent */
    }

    .btn-primary {
        background-color: #198a7b;
        border: none;
        padding: 12px;
        width: 100%;
        font-size: 18px;
        color: #ffffff;
        cursor: pointer;
        transition: background-color 0.3s ease;
        border-radius: 5px;
    }

    .btn-primary:hover {
        background-color: #44afa1;
    }

    .btn-primary:active {
        transform: translateY(2px);
    }
</style>

<div class="container">
    <h2>Importation du fichier électoral</h2>
    <p style="color: white;">Veuillez importer un fichier CSV et entrer son empreinte SHA256.</p>

    <!-- Message de succès -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Message d'erreur -->
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('upload.electors') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Sélection du fichier -->
        <div class="mb-3">
            <label for="file">Sélectionnez un fichier CSV</label>
            <input type="file" class="form-control" name="file" required>
        </div>

        <!-- Empreinte SHA256 -->
        <div class="mb-3">
            <label for="checksum">Empreinte SHA256 du fichier</label>
            <input type="text" class="form-control" name="checksum" placeholder="Entrez l'empreinte SHA256" required>
        </div>

        <!-- Bouton d'importation -->
        <button type="submit" class="btn-primary">Importer</button>
    </form>
</div>

@endsection
