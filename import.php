import.php
<?php
// Inclusion du fichier de configuration pour se connecter à la base de données
require 'config.php';

/**
 * Fonction pour vérifier le format de la carte d'identité et du numéro d'électeur.
 * Ici, on attend que la carte d'identité contienne exactement 10 chiffres
 * et le numéro d'électeur exactement 12 chiffres.
 *
 * @param string $carte_id      La valeur de la carte d'identité
 * @param string $num_electeur  La valeur du numéro d'électeur
 * @return string|null          Retourne un message d'erreur ou null si tout est correct
 */
function verifier_format($carte_id, $num_electeur) {
    // Vérifie que la carte d'identité contient 10 chiffres
    if (!preg_match('/^\d{10}$/', $carte_id)) {
        return "Carte d'identité invalide (doit contenir 10 chiffres)";
    }
    // Vérifie que le numéro d'électeur contient 12 chiffres
    if (!preg_match('/^\d{12}$/', $num_electeur)) {
        return "Numéro d’électeur invalide (doit contenir 12 chiffres)";
    }
    // Si aucune erreur, retourne null
    return null;
}

// Vérifie si un fichier a bien été envoyé via le formulaire
if (isset($_FILES["csv_file"]) && $_FILES["csv_file"]["error"] == 0) {
    // Récupère le chemin temporaire du fichier téléchargé
    $fichier = $_FILES["csv_file"]["tmp_name"];

    // Récupère le contenu complet du fichier pour vérifier l'encodage
    $contenu = file_get_contents($fichier);
    // Vérifie que le contenu est en UTF-8
    if (!mb_check_encoding($contenu, 'UTF-8')) {
        // Si ce n'est pas le cas, on arrête le script avec un message d'erreur
        die("Le fichier doit être en encodage UTF-8.");
    }

    // Ouvre le fichier CSV en lecture
    if (($handle = fopen($fichier, "r")) !== FALSE) {
        // Lit la première ligne du CSV (souvent l'en-tête) et l'ignore
        fgetcsv($handle);

        // Parcourt chaque ligne du fichier CSV
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            // Utilisation de trim() pour enlever les espaces inutiles autour des données
            $carte_id = trim($data[0]);  
            $num_electeur = trim($data[1]);  
            $nom = trim($data[2]);  
            $prenom = trim($data[3]);  
            $date_naissance = trim($data[4]);  

            // Vérifie le format des champs
            $erreur = verifier_format($carte_id, $num_electeur);

            // Optionnel : Vérifier que tous les champs obligatoires sont renseignés
            if (empty($carte_id) || empty($num_electeur) || empty($nom) || empty($prenom) || empty($date_naissance)) {
                $erreur = "Champ(s) obligatoire(s) manquant(s)";
            }

            // Si une erreur est détectée, on enregistre l'erreur dans la table 'erreurs_electeurs'
            if ($erreur) {
                $stmt = $pdo->prepare("INSERT INTO erreurs_electeurs (carte_identite, numero_electeur, erreur) VALUES (?, ?, ?)");
                $stmt->execute([$carte_id, $num_electeur, $erreur]);
            } else {
                // Si tout est correct, on enregistre l'électeur dans la table 'electeurs'
                $stmt = $pdo->prepare("INSERT INTO electeurs (carte_identite, numero_electeur, nom, prenom, date_naissance) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$carte_id, $num_electeur, $nom, $prenom, $date_naissance]);
            }
        }
        // Ferme le fichier après lecture
        fclose($handle);
        echo "Importation terminée.";
    } else {
        // Message d'erreur si le fichier ne peut pas être ouvert
        echo "Erreur lors de l’ouverture du fichier.";
    }
} else {
    // Message d'erreur si aucun fichier n'a été envoyé
    echo "Aucun fichier envoyé.";
}
?>
