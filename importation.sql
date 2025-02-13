-- 1. Exécuter la validation
SELECT ControlerElecteurs();

-- 2. Afficher les erreurs
SELECT * FROM electeurs_erreurs;

-- 3. Insérer les électeurs valides
INSERT INTO electeurs (numero_electeur, carte_identite, nom, prenom, date_naissance)
SELECT numero_electeur, carte_identite, nom, prenom, date_naissance
FROM electeurs_temp
WHERE id NOT IN (SELECT ligne FROM electeurs_erreurs);

-- 4. Nettoyage des tables temporaires
DELETE FROM electeurs_temp;
DELETE FROM electeurs_erreurs;

