-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 27 sep. 2025 à 18:58
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

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
  `mot_de_passe` varchar(20) DEFAULT NULL,
  `photo` longblob DEFAULT NULL,
  `date_creation` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

--
-- Déchargement des données de la table `parrainmarrainemame`
--

INSERT INTO `parrainmarrainemame` (`id`, `nom`, `prenom`, `username`, `telephone`, `mot_de_passe`, `niveau`, `date_creation`) VALUES
(1, 'Amadou', 'Kane', 'amsthebest', '772413958', '$2y$10$nW44okUJZgrPqRCGIX7O.OFvC6HCvtMsjKzhKKQ2PTB8ZrVFMSQiq', 'parrain', '2025-09-28 23:04:46'),
(2, 'faye', 'mouhamed', 'general', '772419987', '$2y$10$9DXffsQgj7lCqlRzo5H1ceaG1XEMpsqQDmBuImXPqYHFHTI3txScm', '', '2025-09-28 23:55:56'),
(4, 'faye', 'moussa', 'super', '784532345', '$2y$10$7MS9GHDAkrkkyrLAgA.KceTfdQKJPTbchAnclmmuKNukif7ByN.62', 'mame_3', '2025-09-29 00:01:05'),
(5, 'Mbodji', 'Cheikh', 'Akassa', '773454139', '$2y$10$jZ0c3XJa6.zeJjiXoFap3O6OwRbBA3T44.vOP6sk1sy16gK52ufSm', 'mame_1', '2025-09-29 00:04:54'),
(6, 'Ka', 'Elimane', 'Eli', '772123432', '$2y$10$vvsB4.HcLbHxj3x2mjK63eGSOenQ93PWiSQbxGhfbXM3ueQE84TjW', 'mame_2', '2025-09-29 00:58:08'),
(7, 'Dieng Dieye', 'Ousmane', 'Ouz', '776543898', '$2y$10$CfdSnCE9HMEJ0CoVW6Pt4ewc.M0eSLkdmo6NX2b9QbSBvS/.SNdg6', 'parrain', '2025-09-29 01:20:14'),
(8, 'ba', 'Ahmadou', 'Ahmadouhtr', '781301602', '$2y$10$JycPqASXJ2eW4lUuVLPTAO3bDzm83DhEZtnRtE5B4oBeGRV0ByeiG', 'mame_1', '2025-09-29 15:27:15'),
(9, 'Diop', 'Aziz', 'ziz', '+221772483958', '$2y$10$qNIIKd5aMPiE7SHMLJME4Om0C5zDo2bUbYhCiKfj7PzwgZbaq9aBm', 'mame_3', '2025-09-29 20:45:07'),
(10, 'Ndiaye', 'Astou', 'atar', '+221772413958', '$2y$10$4JaKfD8UBI7aUe8L/nOEsux6h2Kt5c31rF0H5XtTkkARr3nmrFCka', 'parrain', '2025-09-29 20:49:21'),
(11, 'test', 'test', 'test', '+221772413953', '$2y$10$ajNOjYeouynAUJqJGdJxB.09WvEC9glYeAuKcP8haNcyvbyKsFciK', 'mame_1', '2025-09-29 21:26:25');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `dut1`
--
ALTER TABLE `dut1`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Username` (`username`),
  ADD UNIQUE KEY `username_2` (`username`),
  ADD UNIQUE KEY `Telepone` (`telephone`),
  ADD UNIQUE KEY `telephone` (`telephone`);

--
-- Index pour la table `parrainmarrainemame`
--
ALTER TABLE `parrainmarrainemame`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `telephone` (`telephone`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `dut1`
--
ALTER TABLE `dut1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `parrainmarrainemame`
--
ALTER TABLE `parrainmarrainemame`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
