-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : database
-- Généré le :  mar. 13 août 2019 à 21:50
-- Version du serveur :  8.0.16
-- Version de PHP :  7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `video_hub`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(2, 'Gaming'),
(3, 'Auto');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `firstname` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `newsletter` tinyint(1) DEFAULT NULL,
  `birthday` datetime DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `firstname`, `lastname`, `newsletter`, `birthday`, `password`) VALUES
(2, 'yasby01@gmail.com', '[\"ROLE_USER\"]', 'Yacine', 'Lahjaily', 1, '1951-05-05 00:00:00', '$2y$13$ckEPMs5DhnrfIDvA7/U1tO/bh0tKtBlialD5Y4zN3nkLjQ8l5hFF6'),
(3, 'admin@admin.com', '[\"ROLE_ADMIN\"]', 'Admin', 'Admin', 0, '1989-08-20 00:00:00', '$2y$13$Be6AaLm4jTG8rtq.Cc8bJuddc4AICkZOtfAMxBhd5b./aVhCHWiZK');

-- --------------------------------------------------------

--
-- Structure de la table `video`
--

CREATE TABLE `video` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `published` tinyint(1) NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `video`
--

INSERT INTO `video` (`id`, `title`, `description`, `created_at`, `published`, `url`) VALUES
(1, 'Cool', 'Too voo desc', '1947-05-06 00:00:00', 1, 'https://youtu.be/CJkMr-Ww05M'),
(2, 'Cool', 'Too voo desc', '1951-03-05 00:00:00', 1, 'Gaming'),
(3, 'uncool', 'Too voo desc', '2019-08-12 00:00:00', 0, 'Gaming');

-- --------------------------------------------------------

--
-- Structure de la table `video_category`
--

CREATE TABLE `video_category` (
  `video_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `video_user`
--

CREATE TABLE `video_user` (
  `video_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- Index pour la table `video`
--
ALTER TABLE `video`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `video_category`
--
ALTER TABLE `video_category`
  ADD PRIMARY KEY (`video_id`,`category_id`),
  ADD KEY `IDX_AECE2B7D29C1004E` (`video_id`),
  ADD KEY `IDX_AECE2B7D12469DE2` (`category_id`);

--
-- Index pour la table `video_user`
--
ALTER TABLE `video_user`
  ADD PRIMARY KEY (`video_id`,`user_id`),
  ADD KEY `IDX_8A048B9529C1004E` (`video_id`),
  ADD KEY `IDX_8A048B95A76ED395` (`user_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `video`
--
ALTER TABLE `video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `video_category`
--
ALTER TABLE `video_category`
  ADD CONSTRAINT `FK_AECE2B7D12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_AECE2B7D29C1004E` FOREIGN KEY (`video_id`) REFERENCES `video` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `video_user`
--
ALTER TABLE `video_user`
  ADD CONSTRAINT `FK_8A048B9529C1004E` FOREIGN KEY (`video_id`) REFERENCES `video` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_8A048B95A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
