-- Création de la base de données
CREATE DATABASE IF NOT EXISTS GestionParrainages;

-- Sélection de la base de données
USE GestionParrainages;

-- Table des Candidats
CREATE TABLE IF NOT EXISTS Candidat (
    idCandidat INT AUTO_INCREMENT PRIMARY KEY,
    numeroCarteElecteur VARCHAR(20) UNIQUE NOT NULL, -- Référence à l'électeur
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    dateNaissance DATE NOT NULL,
    email VARCHAR(100) NOT NULL,
    telephone VARCHAR(20) NOT NULL,
    partiPolitique VARCHAR(100),
    slogan TEXT,
    couleursParti VARCHAR(255),
    photo BLOB,
    urlInfo VARCHAR(255)
);

-- Table des Electeurs
CREATE TABLE IF NOT EXISTS Electeur (
    numeroCarteElecteur VARCHAR(20) PRIMARY KEY,
    numeroCIN VARCHAR(20) NOT NULL,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    bureauVote VARCHAR(100) NOT NULL,
    telephone VARCHAR(20),
    email VARCHAR(100),
    UNIQUE (telephone),
    UNIQUE (email)
);

-- Table des Parrainages
CREATE TABLE IF NOT EXISTS Parrainage (
    idParrainage INT AUTO_INCREMENT PRIMARY KEY,
    numeroCarteElecteur VARCHAR(20),
    idCandidat INT,
    dateParrainage DATETIME DEFAULT CURRENT_TIMESTAMP,
    codeValidation VARCHAR(5) NOT NULL,
    statutParrainage ENUM('Validé', 'En attente') DEFAULT 'En attente',
    FOREIGN KEY (numeroCarteElecteur) REFERENCES Electeur(numeroCarteElecteur),
    FOREIGN KEY (idCandidat) REFERENCES Candidat(idCandidat)
);

-- Table des Authentifications (pour les codes de sécurité)
CREATE TABLE IF NOT EXISTS Authentification (
    idAuth INT AUTO_INCREMENT PRIMARY KEY,
    idCandidat INT,
    codeSecurite VARCHAR(10) NOT NULL,
    FOREIGN KEY (idCandidat) REFERENCES Candidat(idCandidat)
);

-- Table pour stocker l'état du parrainage (période de parrainage)
CREATE TABLE IF NOT EXISTS ParrainagePeriode (
    idPeriode INT AUTO_INCREMENT PRIMARY KEY,
    dateDebut DATE NOT NULL,
    dateFin DATE NOT NULL,
    etat ENUM('Ouvert', 'Fermé') DEFAULT 'Fermé'
);

-- Table des Statistiques de Parrainage
CREATE TABLE IF NOT EXISTS StatistiquesParrainages (
    idStatistiques INT AUTO_INCREMENT PRIMARY KEY,
    idCandidat INT,
    nombreParrainages INT DEFAULT 0,
    dateDernierParrainage DATETIME,
    FOREIGN KEY (idCandidat) REFERENCES Candidat(idCandidat)
);

-- Table des Administrateurs
CREATE TABLE IF NOT EXISTS Admin (
    idAdmin INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    motDePasse VARCHAR(255) NOT NULL
);

-- Table d'historique des tentatives de chargement des fichiers (pour les électeurs)
CREATE TABLE IF NOT EXISTS HistoriqueUpload (
    idUpload INT AUTO_INCREMENT PRIMARY KEY,
    idAdmin INT,
    dateUpload DATETIME DEFAULT CURRENT_TIMESTAMP,
    adresseIP VARCHAR(45),
    checksumUtilise VARCHAR(64),
    resultatVerification ENUM('Succès', 'Échec') DEFAULT 'Échec',
    FOREIGN KEY (idAdmin) REFERENCES Admin(idAdmin)
);

-- --- JOINTURES : Exemple d'utilisation des jointures pour relier les tables ---

-- Afficher les détails des parrainages avec les informations sur les candidats et les électeurs
SELECT 
    p.idParrainage, 
    e.nom AS nomElecteur, 
    e.prenom AS prenomElecteur, 
    c.nom AS nomCandidat, 
    c.prenom AS prenomCandidat, 
    p.dateParrainage,
    p.codeValidation,
    p.statutParrainage
FROM Parrainage p
JOIN Candidat c ON p.idCandidat = c.idCandidat
JOIN Electeur e ON p.numeroCarteElecteur = e.numeroCarteElecteur;

-- Afficher les statistiques de parrainages pour chaque candidat
SELECT 
    c.idCandidat, 
    c.nom, 
    c.prenom, 
    s.nombreParrainages, 
    s.dateDernierParrainage
FROM Candidat c
JOIN StatistiquesParrainages s ON c.idCandidat = s.idCandidat;

-- Afficher l'historique des uploads des fichiers avec les informations des administrateurs
SELECT 
    h.idUpload, 
    h.dateUpload, 
    h.adresseIP, 
    a.nom AS adminNom, 
    a.email AS adminEmail,
    h.resultatVerification
FROM HistoriqueUpload h
JOIN Admin a ON h.idAdmin = a.idAdmin;

-- Afficher les candidats et leurs codes d'authentification
SELECT 
    a.codeSecurite, 
    c.nom, 
    c.prenom, 
    c.email
FROM Authentification a
JOIN Candidat c ON a.idCandidat = c.idCandidat;

-- Afficher les électeurs et leur possibilité de parrainer un candidat
SELECT 
    e.numeroCarteElecteur, 
    e.nom, 
    e.prenom, 
    e.email,
    CASE 
        WHEN pp.etat = 'Ouvert' THEN 'Peut parrainer'
        ELSE 'Ne peut pas parrainer'
    END AS statutParrainage
FROM Electeur e
JOIN ParrainagePeriode pp ON pp.idPeriode = 1; -- Exemple : on suppose qu’il y a une seule période ouverte
