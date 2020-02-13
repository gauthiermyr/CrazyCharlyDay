-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 13 fév. 2020 à 14:51
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
-- Base de données :  `ccd`
--

-- --------------------------------------------------------

--
-- Structure de la table `account`
--

DROP TABLE IF EXISTS `account`;
CREATE TABLE IF NOT EXISTS `account` (
  `idCompte` int(10) NOT NULL AUTO_INCREMENT,
  `user` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hash` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default',
  PRIMARY KEY (`idCompte`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `account`
--

INSERT INTO `account` (`idCompte`, `user`, `hash`, `email`, `nom`, `prenom`, `img`) VALUES
(1, 'root', '$2y$10$zUnLFNxa0iP4svm5PMKvHu8u7Z8LWsedo0udjxQqfcJJa8h1CKRE2', 'root@root.com', 'root', 'root', 'default'),
(2, 'loick', '$2y$10$fVKZ9/.D5twEDcZOqNLiCOnKxGwGoRNXDGHdEVGJ7UpDH6gk6S6g.', 'nosal.loick@gmail.com', 'nosal', 'loick', 'default'),
(3, 'julien', '$2y$10$wESTa5YmkHmC6JAfhVb7zehXB3L78tLsyn5AInWqa/WT6qAXJ5RYK', 'juliennoel9@gmail.com', 'noel', 'julien', 'default'),
(4, 'louis', '$2y$10$wSw1zOhf3pwP24eN05cDNeKJEvdnDFck7121.di5XI0oBAsZwpA36', 'louis.demange.m@gmail.com', 'demange', 'louis', 'default'),
(5, 'gauthier', '$2y$10$rts0zZThndNbkObCSAHWheIoAiVopz2u3aDwDvIge9DMshK5WJSYe', 'gauthier.mayer5@gmail.com', 'mayer', 'gauthier', 'default'),
(6, 'sacha', '$2y$10$2p.64mTqjPs.FIUH9DgBZeg5OxUG3Xmr60d1YLmf.uC5UnUe0AveO', 'sacha.thommet5@orange.fr', 'thommet', 'sacha', 'default');

-- --------------------------------------------------------

--
-- Structure de la table `creneau`
--

DROP TABLE IF EXISTS `creneau`;
CREATE TABLE IF NOT EXISTS `creneau` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `cycle` int(10) NOT NULL,
  `semaine` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jour` int(1) NOT NULL,
  `heureD` int(2) NOT NULL,
  `heureF` int(2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_creneauCycle` (`cycle`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `creneau`
--

INSERT INTO `creneau` (`id`, `cycle`, `semaine`, `jour`, `heureD`, `heureF`) VALUES
(1, 0, 'A', 1, 8, 11),
(14, 0, 'A', 1, 14, 17),
(15, 0, 'A', 3, 11, 14),
(16, 0, 'B', 1, 8, 11),
(17, 0, 'B', 2, 8, 11),
(18, 0, 'B', 4, 12, 15),
(19, 0, 'C', 1, 8, 11),
(20, 0, 'C', 1, 9, 12),
(21, 0, 'C', 6, 13, 16),
(22, 0, 'D', 1, 8, 11),
(23, 0, 'D', 3, 16, 19),
(24, 0, 'D', 4, 8, 11);

--
-- Déclencheurs `creneau`
--
DROP TRIGGER IF EXISTS `OnDeleteCreneau`;
DELIMITER $$
CREATE TRIGGER `OnDeleteCreneau` AFTER DELETE ON `creneau` FOR EACH ROW DELETE FROM poste
WHERE creneau = old.id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `cycle`
--

DROP TABLE IF EXISTS `cycle`;
CREATE TABLE IF NOT EXISTS `cycle` (
  `numero` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`numero`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `cycle`
--

INSERT INTO `cycle` (`numero`) VALUES
(0),
(1),
(2),
(3),
(4);

-- --------------------------------------------------------

--
-- Structure de la table `poste`
--

DROP TABLE IF EXISTS `poste`;
CREATE TABLE IF NOT EXISTS `poste` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `creneau` int(10) NOT NULL,
  `idCompte` int(10) DEFAULT NULL,
  `role` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE` (`idCompte`,`creneau`),
  KEY `FK_posteCreneau` (`creneau`),
  KEY `FK_posteRole` (`role`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `poste`
--

INSERT INTO `poste` (`id`, `creneau`, `idCompte`, `role`) VALUES
(1, 1, NULL, 'caissier'),
(2, 1, NULL, 'livreur'),
(3, 1, NULL, 'vendeur');

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `libelle` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`libelle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`libelle`) VALUES
('caissier'),
('livreur'),
('vendeur');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `creneau`
--
ALTER TABLE `creneau`
  ADD CONSTRAINT `FK_creneauCycle` FOREIGN KEY (`cycle`) REFERENCES `cycle` (`numero`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `poste`
--
ALTER TABLE `poste`
  ADD CONSTRAINT `FK_posteCreneau` FOREIGN KEY (`creneau`) REFERENCES `creneau` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_posteRole` FOREIGN KEY (`role`) REFERENCES `role` (`libelle`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Fk` FOREIGN KEY (`idCompte`) REFERENCES `account` (`idCompte`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
