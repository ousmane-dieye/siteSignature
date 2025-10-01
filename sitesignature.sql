-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 01 oct. 2025 à 03:08
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `sitesignature`
--

-- --------------------------------------------------------

--
-- Structure de la table `dut1`
--

CREATE TABLE `dut1` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `mot_de_passe` varchar(255) DEFAULT NULL,
  `date_creation` datetime DEFAULT current_timestamp(),
  `nombre_signature` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `dut1`
--

INSERT INTO `dut1` (`id`, `nom`, `prenom`, `username`, `telephone`, `mot_de_passe`, `date_creation`, `nombre_signature`) VALUES
(1, 'monkey D', 'luffytaro', 'mugiwara', '2152683428', '$2y$10$5wIfakEsckPcEMd9VC0EDeRakdlX76K112M/jkN0zPsFfg6W/qx0u', '2025-09-29 21:43:17', NULL),
(2, 'xruqxw', 'uec xwu', 'ok', '153763219', '$2y$10$TBneAk45iBsXhRlDz87pGOonxj1Z5u2lg2R8pBhabvNwTRDKL7qOe', '2025-09-29 21:45:49', NULL),
(3, 'diuof', 'ousmane', 'odddd', '235237622', '$2y$10$yUz9Qw15z5VBKxfU3GH7nupvcqu6Iba4RNIuKqwz0t6LKX5E/n6em', '2025-09-29 21:53:17', NULL),
(4, 'Kaa', 'Elimane', 'Elizoo', '771234567', '$2y$10$4qIoniSR5sihKk//mXuBxuNR8sWnp8dCb.9dshwjbuabIhoO1B6se', '2025-10-01 00:17:28', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `parrainmarrainemame`
--

CREATE TABLE `parrainmarrainemame` (
  `id` int(11) NOT NULL,
  `nom` varchar(20) DEFAULT NULL,
  `prenom` varchar(20) DEFAULT NULL,
  `username` varchar(20) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `niveau` enum('parrain','mame_1','mame_2','mame_3') NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `parrainmarrainemame`
--

INSERT INTO `parrainmarrainemame` (`id`, `nom`, `prenom`, `username`, `telephone`, `mot_de_passe`, `niveau`, `date_creation`) VALUES
(1, 'Luffy', 'Monkey D', 'Mugiwaraaaa', '+21777777777', '$2y$10$IoYuzInZhdrE89GPQg.uH.9K.uZ/79UVoxhZSeE9lW3baShtqht.S', 'mame_2', '2025-09-29 21:41:23');

-- --------------------------------------------------------

--
-- Structure de la table `signature`
--

CREATE TABLE `signature` (
  `id_dut1` int(11) NOT NULL,
  `id_Mame` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `dut1`
--
ALTER TABLE `dut1`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `parrainmarrainemame`
--
ALTER TABLE `parrainmarrainemame`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `telephone` (`telephone`);

--
-- Index pour la table `signature`
--
ALTER TABLE `signature`
  ADD PRIMARY KEY (`id_dut1`,`id_Mame`),
  ADD KEY `id_Mame` (`id_Mame`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `dut1`
--
ALTER TABLE `dut1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `parrainmarrainemame`
--
ALTER TABLE `parrainmarrainemame`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `signature`
--
ALTER TABLE `signature`
  ADD CONSTRAINT `signature_ibfk_1` FOREIGN KEY (`id_dut1`) REFERENCES `dut1` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `signature_ibfk_2` FOREIGN KEY (`id_Mame`) REFERENCES `parrainmarrainemame` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
