CREATE TABLE electeurs_temp (
    id SERIAL PRIMARY KEY,
    numero_electeur VARCHAR(10),
    carte_identite VARCHAR(9),
    nom VARCHAR(100),
    prenom VARCHAR(100),
    date_naissance DATE
);

CREATE TABLE electeurs (
    id SERIAL PRIMARY KEY,
    numero_electeur VARCHAR(10) UNIQUE,
    carte_identite VARCHAR(9) UNIQUE,
    nom VARCHAR(100),
    prenom VARCHAR(100),
    date_naissance DATE
);

CREATE TABLE electeurs_erreurs (
    id SERIAL PRIMARY KEY,
    ligne INT,
    champ VARCHAR(50),
    erreur VARCHAR(255),
    date_erreur TIMESTAMP DEFAULT NOW()
);
