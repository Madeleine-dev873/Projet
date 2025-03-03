<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrement des Candidats</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; padding: 40px; }
        .container { max-width: 700px; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        .hidden { display: none; }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">Enregistrement des Candidats</h2>
        
        <!-- Étape 1 : Saisie du numéro d'électeur -->
        <div id="step1">
            <label for="numElecteur" class="form-label">Numéro de carte d'électeur :</label>
            <input type="text" id="numElecteur" class="form-control" placeholder="Entrez le numéro">
            <button class="btn btn-primary mt-3" onclick="verifierCandidat()">Vérifier</button>
            <p id="errorMsg" class="text-danger mt-2 hidden"></p>
        </div>

        <!-- Étape 2 : Formulaire de candidature -->
        <div id="step2" class="hidden">
            <h4 class="mt-4">Informations du candidat</h4>
            <p><strong>Nom :</strong> <span id="nom"></span></p>
            <p><strong>Prénom :</strong> <span id="prenom"></span></p>
            <p><strong>Date de naissance :</strong> <span id="dateNaissance"></span></p>
            
            <h4 class="mt-4">Informations complémentaires</h4>
            <label>Email :</label>
            <input type="email" class="form-control" id="email">
            
            <label>Téléphone :</label>
            <input type="text" class="form-control" id="telephone">
            
            <label>Nom du parti :</label>
            <input type="text" class="form-control" id="parti">
            
            <label>Slogan :</label>
            <input type="text" class="form-control" id="slogan">
            
            <label>Photo :</label>
            <input type="file" class="form-control" id="photo">
            
            <label>Couleurs du parti :</label>
            <input type="color"> <input type="color"> <input type="color">
            
            <label>URL d'informations :</label>
            <input type="url" class="form-control" id="url">
            
            <button class="btn btn-success mt-3" onclick="enregistrerCandidat()">Enregistrer</button>
        </div>
    </div>

    <script>
        function verifierCandidat() {
            let num = document.getElementById("numElecteur").value;
            let errorMsg = document.getElementById("errorMsg");
            
            if (num === "12345") { // Exemple de numéro valide
                document.getElementById("step1").classList.add("hidden");
                document.getElementById("step2").classList.remove("hidden");
                document.getElementById("nom").textContent = "Dupont";
                document.getElementById("prenom").textContent = "Jean";
                document.getElementById("dateNaissance").textContent = "01/01/1980";
            } else {
                errorMsg.textContent = "Le candidat considéré n’est pas présent dans le fichier électoral.";
                errorMsg.classList.remove("hidden");
            }
        }
    </script>
</body>
</html>
