@extends('layouts.app')

@section('content')
<style>
    body {
        font-family: "Arial", sans-serif;
        background: url('/images/upload_logs.jpg') no-repeat center center fixed;
        background-size: cover;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100vh;
        margin: 0;
    }

    .header {
        position: absolute;
        top: 10px;
        left: 15px;
        color: white;
        font-size: 18px;
        font-weight: bold;
    }

    .header a {
        color: white;
        text-decoration: none;
        margin-left: 15px;
        padding: 8px 12px;
        background-color: rgba(10, 61, 98, 0.8);
        border-radius: 5px;
        transition: 0.3s;
    }

    .header a:hover {
        background-color: rgba(6, 82, 221, 0.8);
    }

    .container {
        width: 400px;
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        text-align: center;
    }

    h1 {
        font-size: 22px;
        color: #0a3d62;
        margin-bottom: 15px;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    label {
        font-weight: bold;
        text-align: left;
    }

    input[type="date"] {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #bbb;
        border-radius: 6px;
    }

    .btn-confirm, .btn-retour {
        width: 100%;
        padding: 12px;
        font-size: 16px;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        margin-top: 10px;
        transition: 0.3s;
        font-weight: bold;
    }

    .btn-confirm {
        background-color: #0a3d62;
    }

    .btn-confirm:hover {
        background-color: #0652DD;
    }

    .btn-retour {
        background-color: #888;
    }

    .btn-retour:hover {
        background-color: #666;
    }

    #message {
        margin-top: 15px;
        font-size: 14px;
        font-weight: bold;
    }
</style>

<!-- En-tête avec Bienvenue et Déconnexion en haut à gauche -->
<div class="header">
    Bienvenue, {{ Auth::user()->name }}
    <a href="{{ route('logout') }}" 
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
       Se déconnecter
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</div>

<div class="container">
    <h1>📅 Définir la Période de Parrainage</h1>
    <form action="{{ route('update-dates') }}" method="POST">
        @csrf
        <label for="date-debut">Début :</label>
        <input type="date" id="date-debut" name="date_debut" required>

        <label for="date-fin">Fin :</label>
        <input type="date" id="date-fin" name="date_fin" required>

        <button type="submit" class="btn-confirm">✅ Confirmer</button>
    </form>


    <div id="message"></div>

    <!-- Bouton Retour -->
    <a href="{{ route('upload-electors') }}" class="btn-retour">⬅️ Retour</a>
</div>

<script>
    document.getElementById('parrainage-form').addEventListener('submit', function (e) {
        e.preventDefault();

        const dateDebut = new Date(document.getElementById('date-debut').value);
        const dateFin = new Date(document.getElementById('date-fin').value);

        if (dateDebut >= dateFin) {
            document.getElementById('message').innerHTML = "⚠️ La date de début doit précéder la date de fin.";
            document.getElementById('message').style.color = "red";
            return;
        }

        document.getElementById('message').innerHTML = "✅ Période enregistrée avec succès !";
        document.getElementById('message').style.color = "green";
    });
</script>
@endsection
