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
  PRIMARY KEY (`id_categorie`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Listage des données de la table forum_aliev.categorie : ~0 rows (environ)
INSERT INTO `categorie` (`id_categorie`, `nomCategorie`) VALUES
	(15, 'Discussions générales'),
	(16, 'Actualités et événements'),
	(18, 'Technologie et informatique'),
	(19, 'Santé et bien-être'),
	(20, 'Loisirs et hobbies'),
	(22, 'Sports et activités physiques'),
	(23, 'Style de vie et relations'),
	(24, 'Annonces et suggestions');

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
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Listage des données de la table forum_aliev.post : ~16 rows (environ)
INSERT INTO `post` (`id_post`, `texte`, `dateCreation`, `user_id`, `topic_id`) VALUES
	(11, 'Sujet : "Votre escapade estivale préférée"\r\n\r\nMessage : "Bonjour à tous ! L\'été approche à grands pas, et je me demande quelles sont vos destinations de vacances estivales préférées. Avez-vous des endroits que vous recommanderiez absolument ? Partagez vos expériences de voyage, les aventures inoubliables que vous avez vécues et les conseils pour des vacances parfaites. J\'ai hâte de lire vos récits et de trouver de l\'inspiration pour mes propres voyages estivaux !', '2023-09-06 09:24:17', 7, 15),
	(12, 'Sujet : "Votre escapade estivale préférée"', '2023-09-06 09:24:54', 7, 15),
	(16, 'Sujet : "Votre escapade estivale préférée"', '2023-09-06 09:25:48', 5, 19),
	(17, 'Sujet : "Votre escapade estivale préférée"', '2023-09-06 09:26:09', 5, 19),
	(38, 'Sujet : "Votre escapade estivale préférée"Message : "Bonjour à tous ! L\'été approche à grands pas, et je me demande quelles sont vos destinations de vacances estivales préférées. Avez-vous des endroits que vous recommanderiez absolument ? Partagez vos expériences de voyage, les aventures inoubliables que vous avez vécues et les conseils pour des vacances parfaites. J\'ai hâte de lire vos récits et de trouver de l\'inspiration pour mes propres voyages estivaux !', '2023-09-06 09:50:58', 4, 20),
	(41, 'Sujet : "Votre escapade estivale préférée"Message : "Bonjour à tous ! L\'été approche à grands pas, et je me demande quelles sont vos destinations de vacances estivales préférées. Avez-vous des endroits que vous recommanderiez absolument ? Partagez vos expériences de voyage, les aventures inoubliables que vous avez vécues et les conseils pour des vacances parfaites. J\'ai hâte de lire vos récits et de trouver de l\'inspiration pour mes propres voyages estivaux !', '2023-09-06 10:12:31', 4, 15),
	(42, 'Sujet : "Votre escapade estivale préférée"', '2023-09-06 11:00:07', 4, 8),
	(43, 'Sujet : "Votre escapade estivale préférée"', '2023-09-06 11:00:23', 6, 5),
	(44, 'Sujet : "Votre escapade estivale préférée"', '2023-09-06 11:00:34', 5, 24),
	(45, 'Sujet : "Votre escapade estivale préférée"', '2023-09-06 11:01:41', 6, 13),
	(46, 'Sujet : "Votre escapade estivale préférée"', '2023-09-06 11:01:56', 7, 16),
	(47, 'Sujet : "Votre escapade estivale préférée"', '2023-09-06 11:02:13', 7, 14),
	(49, 'Sujet : "Votre escapade estivale préférée"', '2023-09-06 11:03:22', 6, 22),
	(50, 'gfgfhfg', '2023-09-06 11:36:08', 4, 19),
	(51, 'gdfgdf', '2023-09-06 11:51:38', 4, 19),
	(52, 'sqdqsd', '2023-09-06 16:40:38', 4, 19);

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
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Listage des données de la table forum_aliev.topic : ~12 rows (environ)
INSERT INTO `topic` (`id_topic`, `locked`, `titre`, `dateCreation`, `categorie_id`, `user_id`) VALUES
	(5, 0, 'Quel est votre passe-temps préféré en dehors d\'Internet ?', '2023-09-06 09:08:17', 15, 7),
	(8, 0, 'Quels sont les films à ne pas manquer cet été ?', '2023-09-06 09:10:32', 16, 4),
	(13, 0, 'Stratégies pour améliorer la qualité de votre sommeil.', '2023-09-06 09:12:57', 19, 7),
	(14, 0, 'Partagez vos astuces de relaxation et de gestion du stress.', '2023-09-06 09:13:24', 19, 7),
	(15, 0, 'Les meilleures destinations de voyage pour les amateurs de nature.', '2023-09-06 09:13:45', 20, 4),
	(16, 0, 'Conseils pour cultiver un jardin biologique à la maison.', '2023-09-06 09:14:12', 20, 4),
	(19, 0, 'Analyse des performances de votre équipe sportive favorite.', '2023-09-06 09:15:39', 22, 6),
	(20, 0, 'Programmes d\'entraînement pour la musculation à domicile.', '2023-09-06 09:16:01', 22, 6),
	(22, 0, 'Idées de cadeaux originaux pour célébrer une occasion spéciale.', '2023-09-06 09:16:52', 23, 7),
	(24, 0, 'Prochaines mises à jour et améliorations prévues pour le site.', '2023-09-06 09:17:52', 24, 4),
	(33, 0, 'dfgdfgdfg', '2023-09-06 15:29:58', 24, 4),
	(34, 0, 'dfgdfgd', '2023-09-06 16:08:57', 16, 4);

-- Listage de la structure de table forum_aliev. user
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `mdp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `dateInscription` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `role` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Listage des données de la table forum_aliev.user : ~0 rows (environ)
INSERT INTO `user` (`id_user`, `pseudo`, `mdp`, `dateInscription`, `role`, `email`) VALUES
	(4, 'Baisangour', '123', '2023-09-06 09:02:01', 'admin', 'admin@gmail.com'),
	(5, 'Cédric', '123', '2023-09-06 09:02:43', 'user', 'cédric@gmail.com'),
	(6, 'Mansour', '123', '2023-09-06 09:03:07', 'user', 'mansour@gmail.com'),
	(7, 'Aziz', '123', '2023-09-06 09:03:24', 'user', 'aziz@gmail.com');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
