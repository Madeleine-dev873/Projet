@extends('layouts.app')

@section('content')
<style>
    /* Arrière-plan en plein écran */
    body {
        background: url('/images/upload_logs.jpg') no-repeat center center fixed;
        background-size: cover;
    }

    /* Effet flou et transparence (Glassmorphism) */
    .upload-container {
        background: rgba(255, 255, 255, 0.2); /* Fond semi-transparent */
        backdrop-filter: blur(10px); /* Effet de flou */
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
        color: white;
        text-align: center;
        margin-top: -50px; /* Remonter légèrement le formulaire */
    }

    /* Style des boutons */
    .btn-action {
        background-color: #28a745;
        border: none;
        color: white;
        padding: 10px;
        width: 100%;
        font-size: 18px;
        border-radius: 5px;
        transition: 0.3s;
        margin-top: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px; /* Espacement entre l'icône et le texte */
    }

    .btn-action:hover {
        background-color: #218838;
    }

    /* Espacement entre les boutons */
    .button-group {
        display: flex;
        flex-direction: column;
        gap: 15px; /* Augmente l'espace entre les boutons */
    }

    /* Centrer le formulaire */
    .center-screen {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }
</style>

<div class="container center-screen">
    <div class="col-md-6 upload-container">
        <h3>📂 Importer un fichier CSV</h3>

        <!-- Messages -->
        @if (session('error'))
            <div class="alert alert-danger text-center">{{ session('error') }}</div>
        @endif

        @if (session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif

        <!-- Formulaire -->
        <form action="{{ route('upload-electors') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="document">Choisir un fichier CSV :</label>
                <input type="file" name="document" id="document" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="checksum">Empreinte SHA256 :</label>
                <input type="text" name="checksum" id="checksum" class="form-control" placeholder="Saisir l'empreinte SHA256" required>
            </div>

            <div class="button-group">
                <button type="submit" class="btn-action">
                    <i class="fas fa-upload"></i> 📤 Télécharger et Vérifier
                </button>

                <!-- Bouton Définir les Dates avec icône -->
                <a href="{{ route('define-dates') }}" class="btn-action">
                    <i class="fas fa-calendar-alt"></i> 📅 Définir les dates de parrainage
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Inclure FontAwesome pour les icônes -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

@endsection
