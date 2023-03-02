-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : jeu. 19 août 2021 à 12:54
-- Version du serveur :  5.7.11
-- Version de PHP : 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `membre_bn3f`
--

-- --------------------------------------------------------

--
-- Structure de la table `acl_actions`
--

CREATE TABLE `acl_actions` (
  `id` int(11) NOT NULL,
  `id_ctrl` int(10) NOT NULL,
  `action` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `acl_controllers`
--

CREATE TABLE `acl_controllers` (
  `id` int(11) NOT NULL,
  `controller` varchar(255) NOT NULL,
  `actions` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `acl_roles`
--

CREATE TABLE `acl_roles` (
  `id` int(11) NOT NULL,
  `role_name` varchar(255) NOT NULL,
  `role_description` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `acl_roles_controllers`
--

CREATE TABLE `acl_roles_controllers` (
  `id` int(11) NOT NULL,
  `id_role` int(11) NOT NULL,
  `id_ctrl` int(11) NOT NULL,
  `id_act` int(11) NOT NULL,
  `allow` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `acl_users`
--

CREATE TABLE `acl_users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `acl_actions`
--
ALTER TABLE `acl_actions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `acl_controllers`
--
ALTER TABLE `acl_controllers`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `acl_roles`
--
ALTER TABLE `acl_roles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `acl_roles_controllers`
--
ALTER TABLE `acl_roles_controllers`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `acl_users`
--
ALTER TABLE `acl_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `acl_actions`
--
ALTER TABLE `acl_actions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `acl_controllers`
--
ALTER TABLE `acl_controllers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `acl_roles`
--
ALTER TABLE `acl_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `acl_roles_controllers`
--
ALTER TABLE `acl_roles_controllers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `acl_users`
--
ALTER TABLE `acl_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
