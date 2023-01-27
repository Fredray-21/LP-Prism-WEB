-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 23 jan. 2023 à 08:48
-- Version du serveur : 5.7.40
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `medjs`
--

-- --------------------------------------------------------

--
-- Structure de la table `adherentmedjs`
--

DROP TABLE IF EXISTS `adherentmedjs`;
CREATE TABLE IF NOT EXISTS `adherentmedjs` (
  `numAdherent` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  PRIMARY KEY (`numAdherent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `adherentmedjs`
--

INSERT INTO `adherentmedjs` (`numAdherent`, `nom`, `prenom`) VALUES
(1, 'Dupont', 'Antoine'),
(2, 'Fickou', 'Gaël'),
(3, 'Jalibert', 'Matthieu'),
(4, 'Ntamack', 'Romain'),
(5, 'Rives', 'Jean-Pierre'),
(6, 'Platini', 'Michel'),
(7, 'Hinault', 'Bernard'),
(8, 'Larqué', 'Jean-Michel'),
(9, 'Olmeta', 'Pascal'),
(10, 'Fourcade', 'Martin'),
(11, 'Prost', 'Alain');

-- --------------------------------------------------------

--
-- Structure de la table `livremedjs`
--

DROP TABLE IF EXISTS `livremedjs`;
CREATE TABLE IF NOT EXISTS `livremedjs` (
  `numLivre` int(11) NOT NULL,
  `titre` varchar(100) NOT NULL,
  `auteur` varchar(50) NOT NULL,
  `numEmprunteur` int(11) DEFAULT NULL,
  `estEmprunte` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`numLivre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `livremedjs`
--

INSERT INTO `livremedjs` (`numLivre`, `titre`, `auteur`, `numEmprunteur`, `estEmprunte`) VALUES
(1, 'La loi du préau', 'ZEP', NULL, 0),
(2, 'Objectif Lune', 'Hergé', NULL, 0),
(3, 'On a marché sur la Lune', 'Hergé', NULL, 0),
(4, 'La zizanie', 'René Goscinny', NULL, 0),
(5, 'La serpe d\'or', 'René Goscinny', NULL, 0),
(6, 'Astérix et les normands', 'René Goscinny', NULL, 0),
(7, 'PHP pour les nuls', 'Alan Turing', NULL, 0),
(8, 'JavaScript pour les nuls', 'Xavier Lacour', NULL, 0),
(9, 'C\'est pô juste', 'ZEP', NULL, 0),
(10, 'Arachnéa', 'Jean Van Hamme', NULL, 0),
(11, 'Code 93', 'Olivier Norek', NULL, 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
