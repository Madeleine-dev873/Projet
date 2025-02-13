CREATE OR REPLACE FUNCTION ControlerElecteurs() RETURNS VOID AS $$
DECLARE
    rec RECORD;
BEGIN
    FOR rec IN SELECT * FROM electeurs_temp LOOP
        -- Vérification du numéro électeur
        IF rec.numero_electeur !~ '^[0-9]{10}$' THEN
            INSERT INTO electeurs_erreurs (ligne, champ, erreur)
            VALUES (rec.id, 'numero_electeur', 'Numéro invalide');
        END IF;

        -- Vérification de la carte d'identité
        IF rec.carte_identite !~ '^[A-Z]{2}[0-9]{7}$' THEN
            INSERT INTO electeurs_erreurs (ligne, champ, erreur)
            VALUES (rec.id, 'carte_identite', 'Carte d’identité invalide');
        END IF;

        -- Vérification du nom (lettres et espaces autorisés)
        IF rec.nom !~ '^[A-Za-zÀ-ÖØ-öø-ÿ\s-]+$' THEN
            INSERT INTO electeurs_erreurs (ligne, champ, erreur)
            VALUES (rec.id, 'nom', 'Nom invalide');
        END IF;

        -- Vérification de la date de naissance
        IF rec.date_naissance IS NULL OR 
           TO_CHAR(rec.date_naissance, 'YYYY-MM-DD') !~ '^\d{4}-\d{2}-\d{2}$' THEN
            INSERT INTO electeurs_erreurs (ligne, champ, erreur)
            VALUES (rec.id, 'date_naissance', 'Date invalide');
        END IF;
    END LOOP;
END;
$$ LANGUAGE plpgsql;
