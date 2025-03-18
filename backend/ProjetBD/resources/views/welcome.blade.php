<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Parrainages Sénégal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            text-align: center;
        }
        .hero {
            background: url('https://upload.wikimedia.org/wikipedia/commons/f/fd/Flag_of_Senegal.svg') no-repeat center;
            background-size: cover;
            color: white;
            padding: 100px 20px;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
        }
        .hero h1 {
            font-size: 2.5rem;
            font-weight: bold;
        }
        .sections {
            margin-top: 30px;
            margin-bottom: 50px;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            padding: 15px;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card img {
            border-radius: 10px;
            height: 180px;
            object-fit: cover;
        }
        .footer {
            background-color: #343a40;
            color: white;
            padding: 15px 0;
            margin-top: 30px;
        }
    </style>
</head>
<body>

    <!-- Bannière avec drapeau -->
    <div class="hero">
        <h1>BIENVENUE SUR LE SITE DES PARRAINAGES DE CANDIDATURE</h1>
        <h2>D’ÉLECTIONS PRÉSIDENTIELLES POUR LE SÉNÉGAL</h2>
    </div>

    <!-- Sections d'accès aux différentes parties -->
    <div class="container sections">
        <div class="row justify-content-center">
            <div class="col-md-3">
                <a href="{{ route('upload-electors') }}" class="text-decoration-none">
                    <div class="card">
                        <img src="https://i0.wp.com/dubawa.org/wp-content/uploads/2024/11/Senegal.jpg" alt="Importation des Électeurs" class="img-fluid">
                        <h5 class="mt-3">Importation des Électeurs</h5>
                    </div>
                </a>
            </div>
            <div class="col-md-3">

                <a href="{{ route('upload-electors') }}" class="text-decoration-none">

                <a href="/suivi-parrainages"></a>

                    <div class="card">
                        <img src="https://ichef.bbci.co.uk/news/1024/branded_afrique/96c4/live/82b4e150-62bc-11ee-a8e6-efc60698ab1d.jpg" alt="Suivi des Parrainages" class="img-fluid">
                        <h5 class="mt-3">Suivi des Parrainages</h5>
                    </div>
                </a>
            </div>
            <div class="col-md-3">

                <a href="{{ route('upload-electors') }}" class="text-decoration-none">

                <a href="{{ route('electeurs.create') }}" class="text-decoration-none">

                    <div class="card">
                        <img src="https://ichef.bbci.co.uk/news/1024/branded_afrique/58aa/live/a5136aa0-e868-11ee-9410-0f893255c2a0.jpg" alt="Liste des Candidats" class="img-fluid">
                        <h5 class="mt-3">Liste des Candidats</h5>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ route('choisir.role') }}" class="text-decoration-none">
                    <div class="card">
                        <img src="https://cdn.prod.website-files.com/601057763f823a0bf65a8071/61dec7c565cc1be23d0d35af_Authentification%20article.png" alt="Authentification" class="img-fluid">
                        <h5 class="mt-3">Authentification</h5>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p class="mb-0">© 2025 Élections Présidentielles du Sénégal - Tous droits réservés</p>
            <p class="mb-0">Développé avec ❤️ pour une démocratie transparente</p>
        </div>
        
    </footer>

</body>
</html>
