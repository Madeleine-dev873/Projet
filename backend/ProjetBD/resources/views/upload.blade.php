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
    }

    /* Style du bouton */
    .btn-upload {
        background-color: #28a745;
        border: none;
        color: white;
        padding: 10px;
        width: 100%;
        font-size: 18px;
        border-radius: 5px;
        transition: 0.3s;
    }

    .btn-upload:hover {
        background-color: #218838;
    }

    /* Centrer le formulaire */
    .center-screen {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    /* Table stylisée */
    .table-container {
        background: rgba(255, 255, 255, 0.8);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
        margin-top: 20px;
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
        <form action="{{ route('upload.file') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="document">Choisir un fichier CSV :</label>
                <input type="file" name="document" id="document" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="checksum">Empreinte SHA256 :</label>
                <input type="text" name="checksum" id="checksum" class="form-control" placeholder="Saisir l'empreinte SHA256" required>
            </div>

            <button type="submit" class="btn-upload">Télécharger et Vérifier</button>
        </form>
    </div>
</div>

<!-- Section des logs -->
<div class="container table-container">
    <h3 class="text-center">📋 Historique des Uploads</h3>

    <table class="table table-bordered table-striped mt-3">
        <thead class="thead-dark">
            <tr>
                <th>Nom du fichier</th>
                <th>Raison du rejet</th>
                <th>Utilisateur</th>
                <th>IP</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logs as $log)
            <tr>
                <td>{{ $log->filename }}</td>
                <td>{{ $log->reason }}</td>
                <td>{{ $log->user ? $log->user->name : 'Anonyme' }}</td>
                <td>{{ $log->user_ip }}</td>
                <td>{{ $log->attempted_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
