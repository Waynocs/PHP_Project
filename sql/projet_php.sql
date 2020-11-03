-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 04 nov. 2020 à 00:28
-- Version du serveur :  10.4.14-MariaDB
-- Version de PHP : 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projet_php`
--

-- --------------------------------------------------------

--
-- Structure de la table `editor`
--

CREATE TABLE `editor` (
  `id_editor` int(6) NOT NULL,
  `surname` varchar(32) NOT NULL,
  `name` varchar(32) NOT NULL,
  `mail_address` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `dateCreate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `editor`
--

INSERT INTO `editor` (`id_editor`, `surname`, `name`, `mail_address`, `password`, `dateCreate`) VALUES
(6, 'SERANO', 'Waian', 'waynocserano@gmail.com', '$2y$10$GRj9MZH.ZcE0C.VMzUszZe88vCx/wU0aSaLzuRQNwx/p.jJXtUsYS', '2020-11-02 09:43:37'),
(7, 'GROSIO', 'Aurelien', 'aureliengrosio@free.fr', '$2y$10$A.ol9PE62E1W38tWrQ13y.UaKIeF/cZKKGOMyXuAn6Y2Z.Y2/e1WS', '2020-11-02 09:47:05');

-- --------------------------------------------------------

--
-- Structure de la table `langue`
--

CREATE TABLE `langue` (
  `id_langue` int(11) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `langue`
--

INSERT INTO `langue` (`id_langue`, `title`) VALUES
(15, 'Fran&ccedil;ais'),
(16, 'Anglais');

-- --------------------------------------------------------

--
-- Structure de la table `news`
--

CREATE TABLE `news` (
  `id_news` int(11) NOT NULL,
  `id_theme` int(11) NOT NULL,
  `id_langue` int(11) NOT NULL,
  `visibility` tinyint(4) NOT NULL,
  `title_news` varchar(100) NOT NULL,
  `date_news` datetime NOT NULL,
  `text_news` text NOT NULL,
  `id_editor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `news`
--

INSERT INTO `news` (`id_news`, `id_theme`, `id_langue`, `visibility`, `title_news`, `date_news`, `text_news`, `id_editor`) VALUES
(28, 14, 15, 0, 'qsdsqd', '2020-11-03 19:12:53', '\r\n            qsff', 6),
(30, 14, 15, 1, 'Mort en surf', '2020-11-03 23:08:25', '\r\n            QSVQ', 6),
(36, 15, 16, 1, 'zevds', '2020-11-04 00:24:24', '\r\n            sdvsdv', 6);

-- --------------------------------------------------------

--
-- Structure de la table `theme`
--

CREATE TABLE `theme` (
  `id_theme` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `theme`
--

INSERT INTO `theme` (`id_theme`, `title`, `description`) VALUES
(14, 'Math&eacute;matiques', 'Les math&eacute;matiques (ou la math&eacute;matique) sont un ensemble de connaissances abstraites r&eacute;sultant de raisonnements logiques appliqu&eacute;s &agrave; des objets divers tels que les ensembles math&eacute;matiques, les nombres, les formes, les structures, les transformations, etc.'),
(15, 'Fran&ccedil;ais', 'Le fran&ccedil;ais est une langue indo-europ&eacute;enne de la famille des langues romanes.');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `editor`
--
ALTER TABLE `editor`
  ADD PRIMARY KEY (`id_editor`);

--
-- Index pour la table `langue`
--
ALTER TABLE `langue`
  ADD PRIMARY KEY (`id_langue`);

--
-- Index pour la table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id_news`);

--
-- Index pour la table `theme`
--
ALTER TABLE `theme`
  ADD PRIMARY KEY (`id_theme`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `editor`
--
ALTER TABLE `editor`
  MODIFY `id_editor` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `langue`
--
ALTER TABLE `langue`
  MODIFY `id_langue` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `news`
--
ALTER TABLE `news`
  MODIFY `id_news` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT pour la table `theme`
--
ALTER TABLE `theme`
  MODIFY `id_theme` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
