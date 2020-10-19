-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 31 mars 2020 à 18:55
-- Version du serveur :  5.7.26
-- Version de PHP :  7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `bebert`
--

--
-- Déchargement des données de la table `affaire`
--

INSERT INTO `affaire` (`id`, `designation`) VALUES
(8, 'Blanchiment d\'argent'),
(5, 'Détournement de fonds'),
(7, 'Meutre'),
(6, 'Vol');

--
-- Déchargement des données de la table `mairie`
--

INSERT INTO `mairie` (`id`, `ville`) VALUES
(6, 'Beauvais'),
(7, 'Lyon'),
(9, 'Marseille'),
(8, 'Paris');

--
-- Déchargement des données de la table `parti`
--

INSERT INTO `parti` (`id`, `nom`) VALUES
(5, 'Front national'),
(7, 'La France Soumise'),
(6, 'Les républicains');

--
-- Déchargement des données de la table `politicien`
--

INSERT INTO `politicien` (`id`, `parti_id`, `mairie_id`, `nom`, `sexe`, `age`) VALUES
(13, 5, 6, 'marine le stylo', 'F', 51),
(14, 6, 7, 'Nicolas sarkozy', 'M', 65),
(15, 7, 6, 'Jean-luc Mélenchon', 'M', 68);

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `roles`, `password`) VALUES
(4, 'secretaire', '[\"ROLE_SECRETAIRE\"]', '$argon2id$v=19$m=65536,t=4,p=1$eWgxMkxFOW1WUkF0bnZhNw$jC01uRw/vHaq0kBNpuzYUnDDxELJuqrBEm/K/gDPWZE'),
(5, 'administrateur', '[\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$cm0vc2J2Y3k3NmlUNHJyLw$4UM8WMQryPhVW2nIw6EfFLwYeYBve9S2W9gPbv5uP6w'),
(6, 'bebert', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$LjVkTEVJM2czTFdTN1l2Lg$XriPQHHTleuo/qiV1VtC5oMlfEgGyjh46uUsSjOToWE');
COMMIT;

--
-- Déchargement des données de la table `migration_versions`
--

INSERT INTO `migration_versions` (`version`, `executed_at`) VALUES
('20200323191502', '2020-03-23 19:15:30'),
('20200330160201', '2020-03-30 16:02:25'),
('20200330202403', '2020-03-30 20:26:33'),
('20200330212034', '2020-03-30 21:20:41');

--
-- Déchargement des données de la table `affaire_politicien`
--

INSERT INTO `affaire_politicien` (`affaire_id`, `politicien_id`) VALUES
(5, 13),
(6, 14);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
