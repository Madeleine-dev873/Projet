<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des électeurs</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Liste des électeurs importés</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Date de Naissance</th>
                    <th>Numéro de Carte</th>
                    <th>Adresse</th>
                    <th>Téléphone</th>
                    <th>Créé le</th>
                    <th>Mis à jour le</th>
                </tr>
            </thead>
            <tbody>
                @foreach($electeurs as $electeur)
                    <tr>
                        <td>{{ $electeur->id }}</td>
                        <td>{{ $electeur->nom }}</td>
                        <td>{{ $electeur->prenom }}</td>
                        <td>{{ $electeur->date_naissance }}</td>
                        <td>{{ $electeur->numero_carte }}</td>
                        <td>{{ $electeur->adresse }}</td>
                        <td>{{ $electeur->telephone }}</td>
                        <td>{{ $electeur->created_at }}</td>
                        <td>{{ $electeur->updated_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Affichage de la pagination -->
        {{ $electeurs->links() }}
    </div>
</body>
</html>
