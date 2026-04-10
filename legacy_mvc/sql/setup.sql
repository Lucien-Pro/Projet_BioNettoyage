-- Création de la base de données
CREATE DATABASE IF NOT EXISTS `bionet_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `bionet_db`;

-- Table des agents
CREATE TABLE IF NOT EXISTS `agents` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `nom` VARCHAR(100) NOT NULL,
    `prenom` VARCHAR(100) NOT NULL,
    `initiales` VARCHAR(10) NOT NULL,
    `email` VARCHAR(255),
    `statut` VARCHAR(50) DEFAULT 'actif',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Données de test (Optionnel)
INSERT INTO `agents` (`nom`, `prenom`, `initiales`, `email`, `statut`) VALUES
('Dupont', 'Marie', 'MD', 'm.dupont@exemple.com', 'actif')
