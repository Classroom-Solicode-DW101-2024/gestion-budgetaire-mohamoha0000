-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : jeu. 17 avr. 2025 à 15:42
-- Version du serveur : 5.7.24
-- Version de PHP : 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestion_budget`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `type` enum('revenu','depense') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `nom`, `type`) VALUES
(1, 'Salaire', 'revenu'),
(2, 'Bourse', 'revenu'),
(3, 'Ventes', 'revenu'),
(4, 'Autres', 'revenu'),
(5, 'Logement', 'depense'),
(6, 'Transport', 'depense'),
(7, 'Alimentation', 'depense'),
(8, 'Santé', 'depense'),
(9, 'Divertissement', 'depense'),
(10, 'Éducation', 'depense'),
(11, 'Autres', 'depense');

-- --------------------------------------------------------

--
-- Structure de la table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  `description` text,
  `date_transaction` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `category_id`, `montant`, `description`, `date_transaction`) VALUES
(1, 1, 1, '5000.00', 'Salaire du mois', '2025-04-01'),
(2, 1, 6, '1200.00', 'Loyer mensuel', '2025-04-02'),
(3, 1, 7, '300.00', 'Essence voiture', '2025-04-03'),
(4, 1, 8, '400.00', 'Courses alimentaires', '2025-04-04'),
(5, 1, 9, '150.00', 'Consultation médicale', '2025-04-05'),
(6, 2, 2, '2000.00', 'Bourse universitaire', '2025-04-01'),
(7, 2, 11, '500.00', 'Frais de scolarité', '2025-04-06'),
(8, 2, 10, '100.00', 'Soirée cinéma', '2025-04-07'),
(9, 2, 7, '250.00', 'Taxi', '2025-04-08'),
(10, 2, 8, '350.00', 'Courses du mois', '2025-04-09');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `prenom`, `nom`, `email`, `password`, `created_at`) VALUES
(1, 'mohamed', 'el meayouf', 'example@gmail.com', '$2y$10$V9b/gdCQSLeZwlA42Os18OLz47T9wuF/GR30iZgSgznpxMBgNoH9m', '2025-04-17 10:31:00'),
(2, 'mohamed', 'elmeayouf', 'mohamedd@gmoh.com', '$2y$10$FMfkz6ILl4gLTomveKNG2unDv5MSAdG8A7DmD6diGl2x.h9rzSUgS', '2025-04-17 11:09:37');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
