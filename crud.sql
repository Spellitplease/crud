-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 07 juil. 2023 à 00:33
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `crud`
--

-- --------------------------------------------------------

--
-- Structure de la table `liste`
--

DROP TABLE IF EXISTS `liste`;
CREATE TABLE IF NOT EXISTS `liste` (
  `id` int NOT NULL AUTO_INCREMENT,
  `produit` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `prix` float NOT NULL,
  `nombre` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `liste`
--

INSERT INTO `liste` (`id`, `produit`, `prix`, `nombre`) VALUES
(8, 'Réfrégirateur', 599.99, 3),
(2, 'Ordinateur', 499.99, 4),
(3, 'Brouette', 29.99, 250),
(7, 'Télévision', 699.99, 9);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `mail` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `mp` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `avatar` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `nom`, `mail`, `mp`, `avatar`, `role`) VALUES
(1, 'thom', 'thom@gmail.com', '$2y$10$PmJSdd5qxLKZjhTm50O4Z.9ePIzxiJsQ/j3PVJmWKkSM8GpmL1eNm', 'https://img.freepik.com/psd-gratuit/illustration-3d-personne-lunettes-soleil_23-2149436188.jpg', 'admin'),
(2, 'tata', 'tata@gmail.com', '$2y$10$zGofx6SdHkvRFTPZt8Fu6upQ7.SRtKa91DtxvquaW6CwooJDJV.Dy', 'https://www.getillustrations.com/photos/pack/3d-avatar-male_lg.png', '0'),
(3, 'toto', 'toto@gmail.com', '$2y$10$ufZjjAxM/XnIGlREE/C/6./pBe80NyqKsVdL438t7hBHXYZHHAiS2', '', '0'),
(4, 'tutu', 'tutu@gmail.com', '$2y$10$QayyNhqApxM3jfjfC3qmx.uhyu0yb6/yhOBQ/zyPW6PK3DlulCUB2', '', '0'),
(5, 'lulu', 'lulu@gmail.com', '$2y$10$E4qrmTtiD0QuBCoONMB0l.5u4l85I4Cjpr4nPq5UypP8l89Orr5AK', '', '0'),
(11, 'lolo', 'lolo@gmail.com', '$2y$10$jJUlZ6joHjrSovusSXMvO.RTTVZ6SpLewSuYaakiptr9pYsEEP1z6', 'https://img1.cgtrader.com/items/4259531/867496ad17/large/3d-avatar-profession-as-writer-3d-model-867496ad17.jpg', '0');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
