<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Parrainage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('https://upload.wikimedia.org/wikipedia/commons/f/fd/Flag_of_Senegal.svg') no-repeat center center;
            background-size: cover;
        }
        .container {
            max-width: 500px;
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Inscription au Parrainage</h2>
        
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        
        <form action="{{ route('electeurs.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="numero_carte_electeur" class="form-label">Numéro de Carte d'Électeur</label>
                <input type="text" class="form-control" name="numero_carte_electeur" required>
                @if($errors->has('numero_carte_electeur'))
                    <div class="text-danger">{{ $errors->first('numero_carte_electeur') }}</div>
                @endif
            </div>

            <div class="mb-3">
                <label for="numero_carte_identite" class="form-label">Numéro de Carte d'Identité</label>
                <input type="text" class="form-control" name="numero_carte_identite" required>
                @if($errors->has('numero_carte_identite'))
                    <div class="text-danger">{{ $errors->first('numero_carte_identite') }}</div>
                @endif
            </div>
            
            <div class="mb-3">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" class="form-control" name="prenom" required>
            </div>
            @if($errors->has('prenom'))
                <div class="text-danger">{{ $errors->first('prenom') }}</div>
            @endif


            <div class="mb-3">
                <label for="nom" class="form-label">Nom de Famille</label>
                <input type="text" class="form-control" name="nom" required>
                @if($errors->has('nom'))
                    <div class="text-danger">{{ $errors->first('nom') }}</div>
                @endif
            </div>
            
            <div class="mb-3">
                <label for="bureau_vote" class="form-label">Numéro du Bureau de Vote</label>
                <input type="text" class="form-control" name="bureau_vote" required>
                @if($errors->has('bureau_vote'))
                    <div class="text-danger">{{ $errors->first('bureau_vote') }}</div>
                @endif
            </div>
            
            <div class="mb-3">
                <label for="telephone" class="form-label">Numéro de Téléphone</label>
                <input type="text" class="form-control" name="telephone" required>
                @if($errors->has('telephone'))
                    <div class="text-danger">{{ $errors->first('telephone') }}</div>
                @endif
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label">Adresse Email</label>
                <input type="email" class="form-control" name="email" required>
                @if($errors->has('email'))
                    <div class="text-danger">{{ $errors->first('email') }}</div>
                @endif
            </div>

            <div class="mb-3">
                <label for="date_naissance" class="form-label">Date de Naissance</label>
                <input type="date" class="form-control" name="date_naissance" required>
            </div>
            @if($errors->has('date_naissance'))
                <div class="text-danger">{{ $errors->first('date_naissance') }}</div>
            @endif

            <div class="mb-3">
                <label for="adresse" class="form-label">Adresse</label>
                <input type="text" class="form-control" name="adresse" required>
            </div>
            @if($errors->has('adresse'))
                <div class="text-danger">{{ $errors->first('adresse') }}</div>
            @endif
            
            <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
        </form>
    </div>
</body>
</html>
