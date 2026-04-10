-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 10 avr. 2026 à 08:02
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bdd2025`
--

-- --------------------------------------------------------

--
-- Structure de la table `glpi_locations`
--

DROP TABLE IF EXISTS `glpi_locations`;
CREATE TABLE IF NOT EXISTS `glpi_locations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `entities_id` int UNSIGNED NOT NULL DEFAULT '0',
  `is_recursive` tinyint(1) NOT NULL DEFAULT '0',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `locations_id` int UNSIGNED NOT NULL DEFAULT '0',
  `completename` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `comment` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `level` int NOT NULL DEFAULT '0',
  `ancestors_cache` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `sons_cache` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `address` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `postcode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `town` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `building` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `room` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `altitude` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_mod` timestamp NULL DEFAULT NULL,
  `date_creation` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unicity` (`entities_id`,`locations_id`,`name`),
  KEY `locations_id` (`locations_id`),
  KEY `name` (`name`),
  KEY `is_recursive` (`is_recursive`),
  KEY `date_mod` (`date_mod`),
  KEY `date_creation` (`date_creation`),
  KEY `level` (`level`)
) ENGINE=InnoDB AUTO_INCREMENT=120 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Déchargement des données de la table `glpi_locations`
--

INSERT INTO `glpi_locations` (`id`, `entities_id`, `is_recursive`, `name`, `locations_id`, `completename`, `comment`, `level`, `ancestors_cache`, `sons_cache`, `address`, `postcode`, `town`, `state`, `country`, `building`, `room`, `latitude`, `longitude`, `altitude`, `date_mod`, `date_creation`) VALUES
(1, 0, 1, 'ACCUEIL BATIMENT PRINCIPAL', 0, 'ACCUEIL BATIMENT PRINCIPAL', '', 1, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:16:54', '2021-03-25 12:43:37'),
(2, 0, 1, 'INFIRMERIE USLD', 43, 'USLD > BUREAU CADRE USLD', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:24:32', '2021-03-25 14:17:03'),
(3, 0, 1, 'UCC', 0, 'UCC', '', 1, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:23:12', '2021-03-25 15:39:57'),
(4, 0, 1, 'SALLE KINE UCC', 3, 'UCC > SALLE KINE UCC', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:24:18', '2021-03-25 15:40:40'),
(5, 0, 1, 'PHARMACIE', 0, 'PHARMACIE', '', 1, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:20:04', '2021-03-26 10:47:07'),
(6, 0, 1, 'BUREAU SEC ECO FINANCIER', 1, 'ACCUEIL BATIMENT PRINCIPAL > BUREAU SEC ECO FINANCIER', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:12:25', '2021-03-29 05:47:10'),
(7, 0, 1, 'BUREAU FACTURATION EHPAD USLD', 1, 'ACCUEIL BATIMENT PRINCIPAL > BUREAU FACTURATION EHPAD USLD', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 08:57:43', '2021-03-29 11:47:49'),
(8, 0, 1, 'BUREAU DRH', 9, 'RESSOURCES HUMAINES > BUREAU DRH', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:20:45', '2021-03-30 13:22:44'),
(9, 0, 1, 'RESSOURCES HUMAINES', 0, 'RESSOURCES HUMAINES', '', 1, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:20:39', '2021-03-30 13:23:00'),
(10, 0, 1, 'BUREAUX SYNDICAUX', 0, 'BUREAUX SYNDICAUX', '', 1, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:17:26', '2021-03-31 06:30:24'),
(11, 0, 1, 'INFIRMERIE SSR', 45, 'SSR > INFIRMERIE SSR', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:22:51', '2021-04-06 11:28:30'),
(12, 0, 1, 'CUISINE', 0, 'CUISINE', '', 1, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:17:42', '2021-04-06 12:35:07'),
(13, 0, 1, 'EHPAD 2', 0, 'EHPAD 2', '', 1, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:18:56', '2021-04-12 11:26:40'),
(14, 0, 1, 'BUREAU CADRE EHPAD', 19, 'PASA > BUREAU CADRE EHPAD', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:19:49', '2021-04-13 10:56:44'),
(15, 0, 1, 'BUREAU NEUROPSY UCC', 3, 'UCC > BUREAU NEUROPSY UCC', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:23:51', '2021-04-15 12:25:11'),
(16, 0, 1, 'EHPAD 4', 0, 'EHPAD 4', '', 1, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:19:17', '2021-04-21 06:37:47'),
(17, 0, 1, 'INFIRMERIE EHPAD 1', 66, 'EHPAD 1 > INFIRMERIE EHPAD 1', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:18:50', '2021-04-22 09:45:52'),
(18, 0, 1, 'BUREAU RESP ECO FINANCIER', 29, 'SERVICES ECONOMIQUES > BUREAU RESP ECO FINANCIER', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:21:16', '2021-04-22 09:58:33'),
(19, 0, 1, 'PASA', 0, 'PASA', '', 1, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:19:43', '2021-04-27 11:29:33'),
(20, 0, 1, 'SSIAD', 0, 'SSIAD', '', 1, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:22:01', '2021-04-28 04:58:19'),
(21, 0, 1, 'BUREAU SEC MED SSR', 45, 'SSR > BUREAU SEC MED SSR', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:22:47', '2021-05-04 05:16:17'),
(22, 0, 1, 'KINE BAT PRINCIPAL', 0, 'KINE BAT PRINCIPAL', '', 1, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:19:27', '2021-05-04 05:41:56'),
(23, 0, 1, 'BUREAU ERGO UCC', 3, 'UCC > BUREAU ERGO UCC', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:23:41', '2021-05-04 10:02:43'),
(26, 0, 1, 'BUREAU SEC RH', 9, 'RESSOURCES HUMAINES > BUREAU SEC RH', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:20:50', '2021-05-18 05:26:20'),
(28, 0, 1, 'BUREAU SEC DIRECTION', 33, 'DIRECTION > BUREAU SEC DIRECTION', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-11 12:32:02', '2021-05-18 05:36:24'),
(29, 0, 1, 'SERVICES ECONOMIQUES', 0, 'SERVICES ECONOMIQUES', '', 1, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:21:00', '2021-05-18 05:41:01'),
(31, 0, 1, 'BUREAU CHEF CUISINE', 12, 'CUISINE > BUREAU CHEF CUISINE', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:17:47', '2021-05-18 08:34:45'),
(32, 0, 1, 'BUREAU DIET/APA UCC', 3, 'UCC > BUREAU DIET/APA UCC', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:23:33', '2021-05-18 11:14:01'),
(33, 0, 1, 'DIRECTION', 0, 'DIRECTION', '', 1, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:17:57', '2021-05-19 05:49:51'),
(34, 0, 1, 'BUREAU DIRECTEUR', 33, 'DIRECTION > BUREAU DIRECTEUR', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:18:03', '2021-05-19 05:50:05'),
(35, 0, 1, 'PASSERELLE', 0, 'PASSERELLE', '', 1, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:19:59', '2021-05-26 10:48:13'),
(36, 0, 1, 'BUREAU AME', 29, 'SERVICES ECONOMIQUES > BUREAU AME', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:21:06', '2021-06-08 05:15:26'),
(37, 0, 1, 'INFIRMERIE UCC', 3, 'UCC > INFIRMERIE UCC', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:24:02', '2021-06-08 05:17:44'),
(38, 0, 1, 'SALLE REUNION DIRECTION', 33, 'DIRECTION > SALLE REUNION DIRECTION', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:18:21', '2021-06-10 05:19:47'),
(39, 0, 1, 'BUREAU SEC MED EHPAD USLD', 1, 'ACCUEIL BATIMENT PRINCIPAL > BUREAU SEC MED EHPAD USLD', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-11 12:31:36', '2021-06-10 05:42:28'),
(40, 0, 1, 'BUREAU PHARMACIEN HAUT', 5, 'PHARMACIE > BUREAU PHARMACIEN HAUT', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:20:15', '2021-06-11 11:40:10'),
(41, 0, 1, 'CAFE RENCONTRE', 0, 'CAFE RENCONTRE', '', 1, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:17:32', '2021-06-22 06:11:22'),
(42, 0, 1, 'BUREAU RESP SERV TECH', 77, 'SERVICES TECHNIQUES > BUREAU RESP SERV TECH', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:21:50', '2021-06-22 06:15:37'),
(43, 0, 1, 'USLD', 0, 'USLD', '', 1, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:24:28', '2021-06-22 06:19:40'),
(45, 0, 1, 'SSR', 0, 'SSR', '', 1, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:22:28', '2021-06-22 06:25:44'),
(48, 0, 1, 'EHPAD 3', 0, 'EHPAD 3', '', 1, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:19:06', '2021-07-13 07:59:43'),
(49, 0, 1, 'LOCAL ARCHIVES', 0, 'LOCAL ARCHIVES', '', 1, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:19:31', '2021-07-16 13:08:29'),
(50, 0, 1, 'BUREAU SEC MED UCC', 3, 'UCC > BUREAU SEC MED UCC', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:23:56', '2021-07-19 05:40:15'),
(51, 0, 1, 'BUREAU KINE PASA', 19, 'PASA > BUREAU KINE PASA', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:19:54', '2021-07-20 05:47:18'),
(52, 0, 1, 'SALLE SERVEURS', 0, 'SALLE SERVEURS', '', 1, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:20:55', '2021-07-20 05:47:54'),
(53, 0, 1, 'PARC INFORMATIQUE', 0, 'PARC INFORMATIQUE', '', 1, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:19:36', '2021-07-29 09:33:36'),
(54, 0, 1, 'BUREAU MEDICAL EHPAD', 68, 'EHPAD > BUREAU MEDICAL EHPAD', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:18:38', '2021-08-03 05:14:10'),
(55, 0, 1, 'BUREAU PREPARATRICE', 5, 'PHARMACIE > BUREAU PREPARATRICE', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:20:21', '2021-08-03 08:05:28'),
(56, 0, 1, 'BUREAU CADRE UCC', 3, 'UCC > BUREAU CADRE UCC', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:23:27', '2021-08-03 09:16:35'),
(57, 0, 1, 'BUREAU ASS UCC', 3, 'UCC > BUREAU ASS UCC', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:23:19', '2021-08-03 09:22:40'),
(59, 0, 1, 'QUALITE', 0, 'QUALITE', '', 1, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-09-19 11:46:34', '2021-08-16 13:41:45'),
(61, 0, 1, 'BLANCHISSERIE', 0, 'BLANCHISSERIE', '', 1, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:13:36', '2021-10-04 09:42:01'),
(62, 0, 1, 'BUREAU CADRE SSR', 45, 'SSR > BUREAU CADRE SSR', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:22:33', '2021-12-14 12:56:04'),
(63, 0, 1, 'BUREAU PHARMACIEN BAS', 5, 'PHARMACIE > BUREAU PHARMACIEN BAS', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:20:10', '2021-12-14 12:59:44'),
(65, 0, 1, 'DIET BAT PRINCIPAL', 0, 'DIET BAT PRINCIPAL', '', 1, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:17:52', '2021-12-14 15:22:50'),
(66, 0, 1, 'EHPAD 1', 0, 'EHPAD 1', '', 1, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:18:45', '2021-12-16 12:08:09'),
(67, 0, 1, 'CHM', 0, 'CHM', '', 1, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:17:37', '2021-12-16 13:55:07'),
(68, 0, 1, 'EHPAD', 0, 'EHPAD', '', 1, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:18:26', '2021-12-17 15:08:46'),
(69, 0, 1, 'INFIRMERIE EHPAD 2', 13, 'EHPAD 2 > INFIRMERIE EHPAD 2', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:19:01', '2021-12-17 15:12:14'),
(70, 0, 1, 'INFIRMERIE EHPAD 3', 48, 'EHPAD 3 > INFIRMERIE EHPAD 3', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:19:12', '2021-12-17 15:12:26'),
(71, 0, 1, 'INFIRMERIE EHPAD 4', 16, 'EHPAD 4 > INFIRMERIE EHPAD 4', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:19:22', '2021-12-17 15:12:58'),
(74, 0, 1, 'BUREAU PSYCHOLOGUE', 0, 'BUREAU PSYCHOLOGUE', '', 1, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:17:15', '2021-12-17 15:16:06'),
(75, 0, 1, 'BUREAU HOTELIERE', 29, 'SERVICES ECONOMIQUES > BUREAU HOTELIERE', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:21:11', '2021-12-17 15:16:22'),
(76, 0, 1, 'BUREAU SEC SERV ECONOMIQUES', 29, 'SERVICES ECONOMIQUES > BUREAU SEC SERV ECONOMIQUES', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:21:21', '2021-12-17 15:16:39'),
(77, 0, 1, 'SERVICES TECHNIQUES', 0, 'SERVICES TECHNIQUES', '', 1, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:21:37', '2021-12-17 15:17:18'),
(78, 0, 1, 'ATELIER', 77, 'SERVICES TECHNIQUES > ATELIER', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:21:44', '2021-12-17 15:17:48'),
(79, 0, 1, 'BUREAU CADRE SSIAD', 20, 'SSIAD > BUREAU CADRE SSIAD', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:22:08', '2021-12-17 15:18:34'),
(80, 0, 1, 'BUREAU SEC SSIAD', 20, 'SSIAD > BUREAU SEC SSIAD', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:22:16', '2021-12-17 15:18:47'),
(81, 0, 1, 'SALLE REUNION UCC', 3, 'UCC > SALLE REUNION UCC', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:24:23', '2021-12-17 15:19:25'),
(82, 0, 1, 'SALLE HOPITAL DE JOUR', 3, 'UCC > SALLE HOPITAL DE JOUR', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:24:14', '2021-12-17 15:19:47'),
(83, 0, 1, 'RESTAURANT UCC', 3, 'UCC > RESTAURANT UCC', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:24:07', '2021-12-17 15:20:35'),
(84, 0, 1, 'BUREAU CADRE USLD', 43, 'USLD > BUREAU CADRE USLD', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:24:36', '2021-12-17 15:40:36'),
(85, 0, 1, 'ORDINATEUR TAXATION', 1, 'ACCUEIL BATIMENT PRINCIPAL > ORDINATEUR TAXATION', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:12:37', '2021-12-17 15:46:05'),
(86, 0, 1, 'BUREAU MEDECIN USLD', 43, 'USLD > BUREAU MEDECIN USLD', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:24:41', '2022-01-13 12:02:16'),
(87, 0, 1, 'BUREAU MEDECIN UCC 1', 3, 'UCC > BUREAU MEDECIN UCC 1', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2023-04-05 08:05:13', '2022-01-13 12:14:29'),
(88, 0, 1, 'BUREAU MEDECIN PASSERELLE', 0, 'BUREAU MEDECIN PASSERELLE', '', 1, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:17:09', '2022-01-13 12:39:52'),
(89, 0, 1, 'BUREAU MEDECIN SSR', 45, 'SSR > BUREAU MEDECIN SSR', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-20 09:22:42', '2022-01-13 12:48:10'),
(91, 2, 0, 'PASSERELLE', 0, 'PASSERELLE', '', 1, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-01-27 12:03:53', '2022-01-27 12:03:53'),
(92, 0, 0, 'ARCHIVES BATIMENT PRINCIPAL', 0, 'ARCHIVES BATIMENT PRINCIPAL', '', 1, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-02-04 12:06:10', '2022-02-04 12:06:10'),
(93, 0, 0, 'ATELIER', 0, 'ATELIER', '', 1, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-02-08 15:16:37', '2022-02-08 15:16:37'),
(94, 0, 0, 'INFORMATIQUE', 36, 'SERVICES ECONOMIQUES > BUREAU AME > INFORMATIQUE', '', 3, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-04-22 10:09:00', '2022-04-22 10:08:13'),
(95, 0, 0, 'SALLE DE REUNION', 35, 'PASSERELLE > SALLE DE REUNION', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-04-29 10:00:18', '2022-04-29 10:00:18'),
(96, 0, 0, 'PARKING', 0, 'PARKING', '', 1, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2023-04-06 08:11:06', '2022-04-29 10:04:36'),
(97, 0, 0, 'BUREAU FF CADRE EHPAD', 68, 'EHPAD > BUREAU FF CADRE EHPAD', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-07-11 06:39:10', '2022-07-07 05:09:03'),
(98, 0, 0, 'BUREAU SECECO', 29, 'SERVICES ECONOMIQUES > BUREAU SECECO', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-09-05 11:16:31', '2022-09-05 11:16:31'),
(99, 0, 0, 'BUREAU COORDONNATEUR DES SOINS', 0, 'BUREAU COORDONNATEUR DES SOINS', '', 1, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-09-06 09:56:24', '2022-09-06 09:56:24'),
(100, 0, 0, 'BUREAU TIM/SI', 0, 'BUREAU TIM/SI', '', 1, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2023-05-09 13:17:33', '2022-09-13 11:45:37'),
(101, 0, 0, 'BUREAU REFERENT QUALITE', 59, 'QUALITE > BUREAU REFERENT QUALITE', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-09-19 11:46:51', '2022-09-19 11:44:19'),
(102, 0, 0, 'BUREAU INGENIEUR QUALITE', 59, 'QUALITE > BUREAU INGENIEUR QUALITE', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-09-19 11:47:13', '2022-09-19 11:47:13'),
(103, 0, 0, 'CENTRE HOSPITALIER - TOUS BATIMENTS', 0, 'CENTRE HOSPITALIER - TOUS BATIMENTS', '', 1, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2022-12-08 10:53:38', '2022-12-08 10:53:38'),
(104, 0, 0, 'INFIRMERIE USLD', 0, 'INFIRMERIE USLD', '', 1, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2023-01-05 15:51:08', '2023-01-05 15:51:08'),
(105, 0, 0, 'BUREAU MEDECIN UCC 2', 3, 'UCC > BUREAU MEDECIN UCC 2', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2023-04-05 08:05:59', '2023-04-05 08:03:43'),
(106, 0, 0, 'SALLE DE CONVIVIALITE', 66, 'EHPAD 1 > SALLE DE CONVIVIALITE', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2023-06-21 07:45:05', '2023-06-21 07:45:05'),
(107, 0, 0, 'SERVICE INFORMATIQUE', 0, 'SERVICE INFORMATIQUE', '', 1, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2023-07-10 11:06:18', '2023-07-10 11:06:18'),
(108, 0, 0, 'BUREAU RSI/TECHNICIEN INFORMATIQUE', 107, 'SERVICE INFORMATIQUE > BUREAU RSI/TECHNICIEN INFORMATIQUE', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2023-07-10 11:06:44', '2023-07-10 11:06:44'),
(109, 0, 0, 'DIM', 0, 'DIM', '', 1, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2023-09-25 14:50:19', '2023-09-25 14:50:19'),
(110, 0, 0, 'ASCENSEUR', 0, 'ASCENSEUR', '', 1, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2023-10-17 07:28:01', '2023-10-17 07:28:01'),
(111, 0, 0, 'IDE COORDONNATEUR/RICE EHPAD', 68, 'EHPAD > IDE COORDONNATEUR/RICE EHPAD', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2024-05-27 09:07:19', '2024-05-27 09:07:19'),
(112, 0, 0, 'PALIER - PLATEFORME', 35, 'PASSERELLE > PALIER - PLATEFORME', '', 2, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '2024-08-01 06:56:03', '2024-08-01 06:56:03'),
(113, 0, 0, 'SECRETARIAT UCC', 0, 'SECRETARIAT UCC', '', 1, '[]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-26 10:33:53', '2025-06-26 10:33:53'),
(114, 0, 0, 'SERVICE ECONOMIQUE', 0, 'SERVICE ECONOMIQUE', '', 1, '[]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-26 10:33:55', '2025-06-26 10:33:55'),
(115, 0, 0, 'SECRETARIAT SMR', 0, 'SECRETARIAT SMR', '', 1, '[]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-26 10:33:56', '2025-06-26 10:33:56'),
(116, 0, 0, 'ACCUEIL', 0, 'ACCUEIL', '', 1, '[]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-26 10:33:57', '2025-06-26 10:33:57'),
(117, 0, 0, 'INFIRMERIE SMR', 0, 'INFIRMERIE SMR', '', 1, '[]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-26 10:33:58', '2025-06-26 10:33:58'),
(118, 0, 0, 'SALLE REUNION UCC', 0, 'SALLE REUNION UCC', '', 1, '[]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-24 10:58:54', '2025-07-24 10:58:54'),
(119, 0, 0, 'QUAI DE CHARGEMENT', 0, 'QUAI DE CHARGEMENT', '', 1, '[]', NULL, '', '', '', '', '', '', '', '', '', '', '2025-08-19 06:45:38', '2025-08-19 06:45:38');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
