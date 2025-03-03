<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choisissez votre rôle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #f7f7f7, #e0e0e0); /* Dégradé clair et doux */
            text-align: center;
            padding-top: 60px;
            color: black;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        h2 {
            font-size: 2.5rem; /* Agrandissement du titre */
            font-weight: bold;
            margin-bottom: 40px;
        }
        .roles-container {
            margin-top: 150px; /* Abaissement des sections */
        }
        .role-card {
            border-radius: 20px;
            padding: 40px; /* Agrandissement des sections */
            font-size: 1.5rem;
            font-weight: bold;
            text-transform: uppercase;
            color: white;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.4);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }
        /* Couleurs des sections */
        .role-dge { background-color: #007A33; }  /* Vert */
        .role-candidat { background-color: #FFC72C; color: black; } /* Jaune */
        .role-electeur { background-color: #DA291C; }  /* Rouge */

        /* Effet au survol */
        .role-card:hover {
            transform: translateY(-8px) scale(1.05);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Qui êtes-vous ?</h2>
        <div class="row justify-content-center roles-container">
            <div class="col-md-4">
                <div class="card role-card role-dge" onclick="redirectTo('dge')">
                    <h5 class="card-title">Membre de la DGE</h5>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card role-card role-candidat" onclick="redirectTo('candidat')">
                    <h5 class="card-title">Candidat</h5>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card role-card role-electeur" onclick="redirectTo('electeur')">
                    <h5 class="card-title">Électeur</h5>
                </div>
            </div>
        </div>
    </div>

    <script>
        function redirectTo(role) {
            if (role === 'dge') {
                window.location.href = "{{ route('upload-electors') }}";
            } else if (role === 'candidat') {
                window.location.href = "{{ route('suivi.parrainages') }}";
            } else if (role === 'electeur') {
                window.location.href = "{{ route('liste.candidats') }}";
            }
        }
    </script>
</body>
</html>
