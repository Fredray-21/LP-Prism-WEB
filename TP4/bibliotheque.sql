-- phpMyAdmin SQL Dump
-- version 5.0.4deb2+deb11u1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : Dim 02 oct. 2022 à 17:19
-- Version du serveur :  10.5.15-MariaDB-0+deb11u1
-- Version de PHP : 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `sgagne`
--

-- --------------------------------------------------------

--
-- Structure de la table `Adherent`
--

CREATE TABLE `Adherent` (
  `login` varchar(50) CHARACTER SET utf8 NOT NULL,
  `mdp` varchar(64) CHARACTER SET utf8 NOT NULL,
  `nomAdherent` varchar(50) DEFAULT NULL,
  `prenomAdherent` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `dateAdhesion` date DEFAULT NULL,
  `numCategorie` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `Adherent`
--

INSERT INTO `Adherent` (`login`, `mdp`, `nomAdherent`, `prenomAdherent`, `email`, `dateAdhesion`, `numCategorie`) VALUES
('lafleche', '12345', 'SELLA', 'Philippe', 'philippe.sella@yopmail.com', '2022-10-05', 3),
('musclor', 'grrr', 'CHABAL', 'Sébastien', 'sebastien.chabal@yopmail.com', '2022-10-05', 2),
('rico', 'delprado', 'DI MECO', 'Eric', 'eric.di-meco@yopmail.com', '2022-10-09', 3),
('speedy', 'azerty', 'DUPONT', 'Antoine', 'antoine.dupont@yopmail.com', '2022-10-03', 1),
('theboss', 'jojo', 'MOSCATO', 'Vincent', 'vincent.moscato@yopmail.com', '2022-10-03', 1);

-- --------------------------------------------------------

--
-- Structure de la table `Auteur`
--

CREATE TABLE `Auteur` (
  `numAuteur` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `anneeNaissance` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `Auteur`
--

INSERT INTO `Auteur` (`numAuteur`, `nom`, `prenom`, `anneeNaissance`) VALUES
(1, 'THILLIEZ', 'Franck', 1973),
(2, 'NOREK', 'Olivier', 1975),
(3, 'CORNWELL', 'Patricia', 1956),
(4, 'GARY', 'Romain', 1914),
(5, 'KLEIN', 'Etienne', 1958),
(6, 'HAWKING', 'Stephen', 1942),
(7, 'EINSTEIN', 'Albert', 1879),
(8, 'HELMSTETTER', 'Didier', 1953),
(9, 'DROUIN', 'Emilie', NULL),
(10, 'MORAND', 'Elodie', NULL),
(11, 'ZIDANE', 'Zinedine', 1972),
(12, 'MARX', 'Thierry', 1959),
(13, 'HAUMONT', 'Raphaël', 1978),
(14, 'HAMILTON', 'Gene', NULL),
(15, 'TURING', 'Alan', 1912);

-- --------------------------------------------------------

--
-- Structure de la table `Categorie`
--

CREATE TABLE `Categorie` (
  `numCategorie` int(11) NOT NULL,
  `libelle` varchar(50) DEFAULT NULL,
  `nbLivresAutorises` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `Categorie`
--

INSERT INTO `Categorie` (`numCategorie`, `libelle`, `nbLivresAutorises`) VALUES
(1, 'basique', 2),
(2, 'régulier', 5),
(3, 'fervent', 8);

-- --------------------------------------------------------

--
-- Structure de la table `DateEmprunt`
--

CREATE TABLE `DateEmprunt` (
  `numDateEmprunt` int(11) NOT NULL,
  `dateEmprunt` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `DateEmprunt`
--

INSERT INTO `DateEmprunt` (`numDateEmprunt`, `dateEmprunt`) VALUES
(1, '2022-10-02'),
(2, '2022-10-03'),
(3, '2022-10-04'),
(4, '2022-10-05');

-- --------------------------------------------------------

--
-- Structure de la table `emprunte`
--

CREATE TABLE `emprunte` (
  `numLivre` int(11) NOT NULL,
  `login` varchar(50) CHARACTER SET utf8 NOT NULL,
  `numDateEmprunt` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `emprunte`
--

INSERT INTO `emprunte` (`numLivre`, `login`, `numDateEmprunt`) VALUES
(1, 'rico', 1);

-- --------------------------------------------------------

--
-- Structure de la table `estAuteurDe`
--

CREATE TABLE `estAuteurDe` (
  `numAuteur` int(11) NOT NULL,
  `numLivre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `estAuteurDe`
--

INSERT INTO `estAuteurDe` (`numAuteur`, `numLivre`) VALUES
(1, 1),
(1, 2),
(3, 3),
(3, 4),
(3, 5),
(4, 6),
(4, 7),
(5, 10),
(5, 11),
(6, 9),
(7, 8),
(8, 12),
(9, 13),
(10, 13),
(11, 14),
(12, 15),
(13, 15),
(14, 16),
(15, 17);

-- --------------------------------------------------------

--
-- Structure de la table `estDeNationalite`
--

CREATE TABLE `estDeNationalite` (
  `numAuteur` int(11) NOT NULL,
  `numNationalite` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `estDeNationalite`
--

INSERT INTO `estDeNationalite` (`numAuteur`, `numNationalite`) VALUES
(1, 1),
(2, 1),
(3, 2),
(4, 1),
(4, 5),
(5, 1),
(6, 4),
(7, 2),
(7, 6),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 2),
(15, 1);

-- --------------------------------------------------------

--
-- Structure de la table `Genre`
--

CREATE TABLE `Genre` (
  `numGenre` int(11) NOT NULL,
  `intitule` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `Genre`
--

INSERT INTO `Genre` (`numGenre`, `intitule`) VALUES
(1, 'roman policier'),
(2, 'sciences'),
(3, 'jardinage'),
(4, 'tricot'),
(5, 'sport'),
(6, 'cuisine'),
(7, 'bricolage'),
(8, 'informatique'),
(9, 'roman');

-- --------------------------------------------------------

--
-- Structure de la table `Livre`
--

CREATE TABLE `Livre` (
  `numLivre` int(11) NOT NULL,
  `titre` varchar(50) DEFAULT NULL,
  `anneeParution` int(11) DEFAULT NULL,
  `numGenre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `Livre`
--

INSERT INTO `Livre` (`numLivre`, `titre`, `anneeParution`, `numGenre`) VALUES
(1, 'Le syndrome E', 2010, 1),
(2, 'Sharko', 2017, 1),
(3, 'Postmortem', 1990, 1),
(4, 'Une peine d\'exception', 1993, 1),
(5, 'La séquence des corps', 1994, 1),
(6, 'Tulipe', 1946, 9),
(7, 'La promesse de l\'aube', 1960, 9),
(8, 'Conceptions scientifiques', 1952, 2),
(9, 'Une brève histoire du temps', 1988, 2),
(10, 'Les tactiques de Chronos', 2003, 2),
(11, 'Discours sur l\'origine de l\'univers', 2010, 2),
(12, 'Le potager du paresseux', 2019, 3),
(13, 'Tricoter ses chaussettes', 2021, 4),
(14, 'Sur un coup de tête', 2006, 5),
(15, 'L\'innovation aux fourneaux', 2016, 6),
(16, 'Le bricolage pour les nuls', 1998, 7),
(17, 'PHP pour les nuls', 2022, 8);

-- --------------------------------------------------------

--
-- Structure de la table `Nationalite`
--

CREATE TABLE `Nationalite` (
  `numNationalite` int(11) NOT NULL,
  `pays` varchar(50) DEFAULT NULL,
  `abrege` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `Nationalite`
--

INSERT INTO `Nationalite` (`numNationalite`, `pays`, `abrege`) VALUES
(1, 'France', 'FRA'),
(2, 'Etats-Unis', 'USA'),
(3, 'Suède', 'SWE'),
(4, 'Royaume-Uni', 'GBR'),
(5, 'Russie', 'RUS'),
(6, 'Allemagne', 'DEU');

-- --------------------------------------------------------

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Adherent`
--
ALTER TABLE `Adherent`
  ADD PRIMARY KEY (`login`),
  ADD KEY `ctAd1` (`numCategorie`);

--
-- Index pour la table `Auteur`
--
ALTER TABLE `Auteur`
  ADD PRIMARY KEY (`numAuteur`);

--
-- Index pour la table `Categorie`
--
ALTER TABLE `Categorie`
  ADD PRIMARY KEY (`numCategorie`);

--
-- Index pour la table `DateEmprunt`
--
ALTER TABLE `DateEmprunt`
  ADD PRIMARY KEY (`numDateEmprunt`);

--
-- Index pour la table `emprunte`
--
ALTER TABLE `emprunte`
  ADD PRIMARY KEY (`numLivre`,`login`,`numDateEmprunt`),
  ADD KEY `ctEmprunte2` (`login`),
  ADD KEY `ctEmprunte3` (`numDateEmprunt`);

--
-- Index pour la table `estAuteurDe`
--
ALTER TABLE `estAuteurDe`
  ADD PRIMARY KEY (`numAuteur`,`numLivre`),
  ADD KEY `ctestAuteurDe2` (`numLivre`);

--
-- Index pour la table `estDeNationalite`
--
ALTER TABLE `estDeNationalite`
  ADD PRIMARY KEY (`numAuteur`,`numNationalite`),
  ADD KEY `ctEstDeNationalite2` (`numNationalite`);

--
-- Index pour la table `Genre`
--
ALTER TABLE `Genre`
  ADD PRIMARY KEY (`numGenre`);

--
-- Index pour la table `Livre`
--
ALTER TABLE `Livre`
  ADD PRIMARY KEY (`numLivre`),
  ADD KEY `ctL1` (`numGenre`);

--
-- Index pour la table `Nationalite`
--
ALTER TABLE `Nationalite`
  ADD PRIMARY KEY (`numNationalite`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Auteur`
--
ALTER TABLE `Auteur`
  MODIFY `numAuteur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `Categorie`
--
ALTER TABLE `Categorie`
  MODIFY `numCategorie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `DateEmprunt`
--
ALTER TABLE `DateEmprunt`
  MODIFY `numDateEmprunt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `Genre`
--
ALTER TABLE `Genre`
  MODIFY `numGenre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `Livre`
--
ALTER TABLE `Livre`
  MODIFY `numLivre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `Nationalite`
--
ALTER TABLE `Nationalite`
  MODIFY `numNationalite` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Adherent`
--
ALTER TABLE `Adherent`
  ADD CONSTRAINT `ctAd1` FOREIGN KEY (`numCategorie`) REFERENCES `Categorie` (`numCategorie`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `emprunte`
--
ALTER TABLE `emprunte`
  ADD CONSTRAINT `ctEmprunte1` FOREIGN KEY (`numLivre`) REFERENCES `Livre` (`numLivre`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ctEmprunte2` FOREIGN KEY (`login`) REFERENCES `Adherent` (`login`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ctEmprunte3` FOREIGN KEY (`numDateEmprunt`) REFERENCES `DateEmprunt` (`numDateEmprunt`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `estAuteurDe`
--
ALTER TABLE `estAuteurDe`
  ADD CONSTRAINT `ctestAuteurDe1` FOREIGN KEY (`numAuteur`) REFERENCES `Auteur` (`numAuteur`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ctestAuteurDe2` FOREIGN KEY (`numLivre`) REFERENCES `Livre` (`numLivre`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `estDeNationalite`
--
ALTER TABLE `estDeNationalite`
  ADD CONSTRAINT `ctEstDeNationalite1` FOREIGN KEY (`numAuteur`) REFERENCES `Auteur` (`numAuteur`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ctEstDeNationalite2` FOREIGN KEY (`numNationalite`) REFERENCES `Nationalite` (`numNationalite`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Livre`
--
ALTER TABLE `Livre`
  ADD CONSTRAINT `ctL1` FOREIGN KEY (`numGenre`) REFERENCES `Genre` (`numGenre`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
