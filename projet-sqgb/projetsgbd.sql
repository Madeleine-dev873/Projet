-- Création de la base de données si elle n'existe pas
CREATE DATABASE IF NOT EXISTS `projetsgbd` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Sélection de la base de données
USE `projetsgbd`;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 12 fév. 2025 à 01:03
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Création de la table electeurs_temp si elle n'existe pas
CREATE TABLE IF NOT EXISTS `electeurs_temp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero_cin` varchar(13) NOT NULL,
  `numero_electeur` varchar(10) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `date_naissance` date NOT NULL,
  `lieu_naissance` varchar(100) NOT NULL,
  `sexe` enum('M', 'F') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Procédure ControlerElecteurs
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `ControlerElecteurs` (IN `upload_id` INT)
BEGIN
    INSERT INTO electeurs_erreurs (upload_attempt, numero_cin, numero_electeur, erreur_description)
    SELECT upload_id, numero_cin, numero_electeur, 'Format incorrect ou champs manquants'
    FROM electeurs_temp
    WHERE 
        LENGTH(numero_cin) <> 13 OR
        LENGTH(numero_electeur) <> 10 OR
        nom = '' OR prenom = '' OR
        date_naissance IS NULL OR
        lieu_naissance = '' OR
        sexe NOT IN ('M', 'F');

    -- Vérifier s'il y a des erreurs
    IF (SELECT COUNT(*) FROM electeurs_erreurs WHERE upload_attempt = upload_id) = 0 THEN
        INSERT INTO upload_logs (utilisateur_id, ip_address, checksum_fichier, statut, message)
        VALUES (1, '127.0.0.1', 'VALID FILE', 'SUCCESS', 'Fichier validé');
    ELSE
        INSERT INTO upload_logs (utilisateur_id, ip_address, checksum_fichier, statut, message)
        VALUES (1, '127.0.0.1', 'INVALID FILE', 'FAILURE', 'Erreurs détectées');
    END IF;
END$$
DELIMITER ;

-- Procédure ValiderImportation
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `ValiderImportation` ()
BEGIN
    INSERT INTO electeurs (numero_cin, numero_electeur, nom, prenom, date_naissance, lieu_naissance, sexe)
    SELECT numero_cin, numero_electeur, nom, prenom, date_naissance, lieu_naissance, sexe FROM electeurs_temp;

    DELETE FROM electeurs_temp;
END$$
DELIMITER ;

-- Fonction ControlerFichierElecteurs
DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `ControlerFichierElecteurs` (`fichier_checksum` VARCHAR(64), `checksum_saisi` VARCHAR(64)) RETURNS TINYINT(1) DETERMINISTIC BEGIN
    DECLARE is_valid BOOLEAN DEFAULT FALSE;

    -- Vérifier si le checksum correspond
    IF fichier_checksum = checksum_saisi THEN
        SET is_valid = TRUE;
    ELSE
        INSERT INTO upload_logs (utilisateur_id, ip_address, checksum_fichier, statut, message)
        VALUES (1, '127.0.0.1', fichier_checksum, 'FAILURE', 'Checksum invalide');
    END IF;

    RETURN is_valid;
END$$
DELIMITER ;

-- Création de la table candidats
CREATE TABLE IF NOT EXISTS `candidats` (
  `id_candidat` int(11) NOT NULL AUTO_INCREMENT,
  `cin` varchar(20) NOT NULL,
  `numero_electeur` varchar(20) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `date_naissance` date NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telephone` varchar(15) DEFAULT NULL,
  `parti_politique` varchar(50) DEFAULT NULL,
  `slogan` text DEFAULT NULL,
  `photo` blob DEFAULT NULL,
  `couleurs` varchar(100) DEFAULT NULL,
  `url_information` varchar(255) DEFAULT NULL,
  `date_creation` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_candidat`),
  UNIQUE KEY `numero_electeur` (`numero_electeur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Création de la table electeurs
CREATE TABLE IF NOT EXISTS `electeurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero_electeur` varchar(50) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `date_naissance` date NOT NULL,
  `sexe` enum('M','F') NOT NULL,
  `carte_identite` varchar(50) NOT NULL,
  `adresse_ip` varchar(50) DEFAULT NULL,
  `upload_time` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `numero_electeur` (`numero_electeur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Création de la table historiqueupload
CREATE TABLE IF NOT EXISTS `historiqueupload` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(50) DEFAULT NULL,
  `upload_time` timestamp NULL DEFAULT current_timestamp(),
  `checksum` varchar(64) DEFAULT NULL,
  `status` enum('Succès','Échec') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Création de la table tempelecteurs
CREATE TABLE IF NOT EXISTS `tempelecteurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero_electeur` varchar(50) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `date_naissance` date NOT NULL,
  `sexe` enum('M','F') NOT NULL,
  `carte_identite` varchar(50) NOT NULL,
  `adresse_ip` varchar(50) DEFAULT NULL,
  `upload_time` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Création de la table temperrors
CREATE TABLE IF NOT EXISTS `temperrors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero_parrain` varchar(50) DEFAULT NULL,
  `error_message` varchar(255) DEFAULT NULL,
  `upload_time` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Création de la table tempproblemeelecteurs
CREATE TABLE IF NOT EXISTS `tempproblemeelecteurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero_electeur` varchar(50) NOT NULL,
  `carte_identite` varchar(50) NOT NULL,
  `error_message` varchar(255) NOT NULL,
  `upload_time` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Index pour la table candidats
ALTER TABLE `candidats`
  ADD PRIMARY KEY (`id_candidat`),
  ADD UNIQUE KEY `numero_electeur` (`numero_electeur`);

-- Index pour la table electeurs
ALTER TABLE `electeurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero_electeur` (`numero_electeur`);

-- Index pour la table historiqueupload
ALTER TABLE `historiqueupload`
  ADD PRIMARY KEY (`id`);

-- Index pour la table tempelecteurs
ALTER TABLE `tempelecteurs`
  ADD PRIMARY KEY (`id`);

-- Index pour la table temperrors
ALTER TABLE `temperrors`
  ADD PRIMARY KEY (`id`);

-- Index pour la table tempproblemeelecteurs
ALTER TABLE `tempproblemeelecteurs`
  ADD PRIMARY KEY (`id`);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
