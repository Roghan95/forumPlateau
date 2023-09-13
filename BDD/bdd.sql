-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour forum_aliev
CREATE DATABASE IF NOT EXISTS `forum_aliev` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_bin */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `forum_aliev`;

-- Listage de la structure de table forum_aliev. categorie
CREATE TABLE IF NOT EXISTS `categorie` (
  `id_categorie` int NOT NULL AUTO_INCREMENT,
  `nomCategorie` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `dateCreation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_categorie`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Listage des données de la table forum_aliev.categorie : ~6 rows (environ)
INSERT INTO `categorie` (`id_categorie`, `nomCategorie`, `dateCreation`) VALUES
	(19, 'Santé et bien-être', '2023-09-13 08:44:53'),
	(20, 'Loisirs et hobbies', '2023-09-13 08:44:53'),
	(24, 'Annonces et suggestions', '2023-09-13 08:44:53');

-- Listage de la structure de table forum_aliev. post
CREATE TABLE IF NOT EXISTS `post` (
  `id_post` int NOT NULL AUTO_INCREMENT,
  `texte` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `dateCreation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int NOT NULL,
  `topic_id` int NOT NULL,
  PRIMARY KEY (`id_post`),
  KEY `user_id` (`user_id`),
  KEY `topic_id` (`topic_id`),
  CONSTRAINT `post_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`),
  CONSTRAINT `post_ibfk_2` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id_topic`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=130 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Listage des données de la table forum_aliev.post : ~10 rows (environ)
INSERT INTO `post` (`id_post`, `texte`, `dateCreation`, `user_id`, `topic_id`) VALUES
	(11, 'fghjjjfdg', '2023-09-06 09:24:17', 7, 15),
	(12, 'Sujet : "Votre escapade estivale préférée"', '2023-09-06 09:24:54', 7, 15),
	(44, 'Sujet : "Votre escapade estivale préférée"', '2023-09-06 11:00:34', 5, 24),
	(46, 'Sujet : "Votre escapade estivale préférée"', '2023-09-06 11:01:56', 7, 16),
	(102, 'touche pas wsh&#13;&#10;', '2023-09-08 23:36:16', 15, 60),
	(104, 'Test 1', '2023-09-09 00:07:55', 16, 60),
	(111, 'rhrgfesf', '2023-09-10 20:59:08', 17, 65),
	(112, 'hrytfhrtrfze', '2023-09-10 20:59:10', 17, 65),
	(113, 'test', '2023-09-10 21:00:39', 17, 60),
	(114, 'ok', '2023-09-10 21:04:12', 17, 66),
	(129, 'fg', '2023-09-13 16:21:20', 17, 60);

-- Listage de la structure de table forum_aliev. topic
CREATE TABLE IF NOT EXISTS `topic` (
  `id_topic` int NOT NULL AUTO_INCREMENT,
  `locked` tinyint(1) NOT NULL DEFAULT '0',
  `titre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `dateCreation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `categorie_id` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id_topic`),
  KEY `categorie_id` (`categorie_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `topic_ibfk_1` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id_categorie`) ON DELETE CASCADE,
  CONSTRAINT `topic_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Listage des données de la table forum_aliev.topic : ~6 rows (environ)
INSERT INTO `topic` (`id_topic`, `locked`, `titre`, `dateCreation`, `categorie_id`, `user_id`) VALUES
	(15, 0, 'Les meilleures destinations de voyage pour les amateurs de nature.', '2023-09-06 09:13:45', 20, 4),
	(16, 0, 'Conseils pour cultiver un jardin biologique à la maison.', '2023-09-06 09:14:12', 20, 4),
	(24, 0, 'Prochaines mises à jour et améliorations prévues pour le site.', '2023-09-06 09:17:52', 24, 4),
	(60, 0, 'hgfh', '2023-09-08 23:36:16', 19, 15),
	(65, 0, 'qsdqsd', '2023-09-10 20:59:08', 19, 17),
	(66, 1, 'Lock/Unlock', '2023-09-10 21:04:12', 19, 17);

-- Listage de la structure de table forum_aliev. user
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `role` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT 'user',
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `mdp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `dateInscription` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isBan` datetime DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `pseudo` (`pseudo`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Listage des données de la table forum_aliev.user : ~14 rows (environ)
INSERT INTO `user` (`id_user`, `pseudo`, `role`, `email`, `mdp`, `dateInscription`, `isBan`) VALUES
	(4, 'Baisangour', 'user', 'admin@gmail.com', '123', '2023-09-06 09:02:01', '2023-09-11 11:09:10'),
	(5, 'Cédric', 'user', 'cédric@gmail.com', '123', '2023-09-06 09:02:43', NULL),
	(6, 'Mansour', 'user', 'mansour@gmail.com', '123', '2023-09-06 09:03:07', NULL),
	(7, 'Aziz', 'user', 'aziz@gmail.com', '123', '2023-09-06 09:03:24', NULL),
	(8, 'aa', 'user', 'aaa@aa.aa', '$2y$10$nlUfkpGmB7pskQI5JhxKN.F1azEQgJNbHJQponL0ASYXRYtSu.czi', '2023-09-08 14:40:43', NULL),
	(9, 'Quentin', 'user', 'quentin@gmail.com', '$2y$10$P/E8tOAq4kYdpho2G1Ra5eX1vpAGnZdVO5Sr7.PeZVezKAACft/J6', '2023-09-08 14:53:03', NULL),
	(10, 'ali', 'user', 'ali@gmail.com', '$2y$10$4/CQPa4lpr0PDZRq2tPiOeIRC52E/JpMl1COV2BvpTBQbV1zmAnHW', '2023-09-08 14:54:30', NULL),
	(11, 'aze', 'user', 'aze@gmail.com', '$2y$10$RgTIi3vZTjQOtA1LoHtDGuJzEzTgvNWrLiL8aoWCpY.lIZg2y7p8y', '2023-09-08 15:04:50', NULL),
	(12, 'azerty', 'user', 'azerty@azerty.fr', '$2y$10$.uAF36zYt.zk1/oD90W4Zu3XPXnww4ONKUzQUwkR9Fm5WSL9C7RuG', '2023-09-08 15:05:22', NULL),
	(13, 'azea', 'user', 'azea@azea.fr', '$2y$10$S9HqPc45yTYrXJoXSUC4tOWCXn5qtnwbt/ySUlR6/Pxx4Ck/Bgk4K', '2023-09-08 16:06:51', NULL),
	(14, 'teste', 'user', 'teste@teste.fr', '$2y$10$LWm6gqnAW8ZGOSr6ZwadfOshFpmP616VSJbGzKT6F4hIOcR0HxsN6', '2023-09-08 16:50:44', NULL),
	(15, 'mansour287', 'ROLE_ADMIN', 'mansour@exemple.com', '$2y$10$jNS2V/MURjH5JLlUfRzBSusD2raUgUgopCNLfAMj0ceTKchamLGF.', '2023-09-08 21:54:46', NULL),
	(16, 'TestAcc', 'user', 'user@gmail.com', '$2y$10$oETxsui9Hp0NHq/97KXcsO189DiV9YMvj9.SsULZXHT1GGsHE2raW', '2023-09-09 00:07:09', NULL),
	(17, 'test123', 'user', 'test123@exemple.com', '$2y$10$wG.M1A6mQl1jouX5kpEEeu8Hn9mFGtMo/PC3hc3CxDP3YRqbVy00S', '2023-09-10 16:23:50', NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
