CREATE DATABASE IF NOT EXISTS `bnbyte`
/*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */
/*!80016 DEFAULT ENCRYPTION='N' */
;

USE `bnbyte`;

-- MySQL dump 10.13  Distrib 8.0.34, for macos13 (arm64)
--
-- Host: 127.0.0.1    Database: bnbyte
-- ------------------------------------------------------
-- Server version	8.4.0
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */
;

/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */
;

/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */
;

/*!50503 SET NAMES utf8 */
;

/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */
;

/*!40103 SET TIME_ZONE='+00:00' */
;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */
;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */
;

/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */
;

/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */
;

--
-- Table structure for table `abonnement`
--
DROP TABLE IF EXISTS `abonnement`;

/*!40101 SET @saved_cs_client     = @@character_set_client */
;

/*!50503 SET character_set_client = utf8mb4 */
;

CREATE TABLE `abonnement` (
  `id` int NOT NULL AUTO_INCREMENT,
  `api_key` varchar(255) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `api_key_unique` (`api_key`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

/*!40101 SET character_set_client = @saved_cs_client */
;

--
-- Dumping data for table `abonnement`
--
LOCK TABLES `abonnement` WRITE;

/*!40000 ALTER TABLE `abonnement` DISABLE KEYS */
;

/*!40000 ALTER TABLE `abonnement` ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Table structure for table `abonnement_logement`
--
DROP TABLE IF EXISTS `abonnement_logement`;

/*!40101 SET @saved_cs_client     = @@character_set_client */
;

/*!50503 SET character_set_client = utf8mb4 */
;

CREATE TABLE `abonnement_logement` (
  `abonnement_id` int NOT NULL,
  `logement_uuid` varchar(255) NOT NULL,
  PRIMARY KEY (`abonnement_id`, `logement_uuid`),
  KEY `logement_fk_abonement_logement` (`logement_uuid`),
  CONSTRAINT `abonement_fk_abonement_logement` FOREIGN KEY (`abonnement_id`) REFERENCES `abonnement` (`id`),
  CONSTRAINT `logement_fk_abonement_logement` FOREIGN KEY (`logement_uuid`) REFERENCES `logement` (`uuid`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

/*!40101 SET character_set_client = @saved_cs_client */
;

--
-- Dumping data for table `abonnement_logement`
--
LOCK TABLES `abonnement_logement` WRITE;

/*!40000 ALTER TABLE `abonnement_logement` DISABLE KEYS */
;

/*!40000 ALTER TABLE `abonnement_logement` ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Table structure for table `activite`
--
DROP TABLE IF EXISTS `activite`;

/*!40101 SET @saved_cs_client     = @@character_set_client */
;

/*!50503 SET character_set_client = utf8mb4 */
;

CREATE TABLE `activite` (
  `activity` varchar(255) NOT NULL,
  `perimeter` varchar(255) NOT NULL,
  `logement_uuid` varchar(255) NOT NULL,
  PRIMARY KEY (`logement_uuid`, `activity`),
  CONSTRAINT `logement_fk_activite` FOREIGN KEY (`logement_uuid`) REFERENCES `logement` (`uuid`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

/*!40101 SET character_set_client = @saved_cs_client */
;

--
-- Dumping data for table `activite`
--
LOCK TABLES `activite` WRITE;

/*!40000 ALTER TABLE `activite` DISABLE KEYS */
;

INSERT INTO
  `activite`
VALUES
  (
    'GOLF',
    'LESS_5_KM',
    'f5a97f54-1863-11ef-9142-0242ac150002'
  ),
(
    'HIKING',
    'LESS_5_KM',
    'f5a97f54-1863-11ef-9142-0242ac150002'
  ),
(
    'HORSE_RIDING',
    'LESS_10_KM',
    'f5a97f54-1863-11ef-9142-0242ac150002'
  ),
(
    'TREE_CLIMBING',
    'LESS_5_KM',
    'f5a97f54-1863-11ef-9142-0242ac150002'
  ),
(
    'BATHING',
    'ON_THE_SPOT',
    'f5a9ab0e-1863-11ef-9142-0242ac150002'
  ),
(
    'HIKING',
    'ON_THE_SPOT',
    'f5a9ab0e-1863-11ef-9142-0242ac150002'
  ),
(
    'HORSE_RIDING',
    'ON_THE_SPOT',
    'f5a9ab0e-1863-11ef-9142-0242ac150002'
  ),
(
    'SAIL',
    'LESS_5_KM',
    'f5a9ab0e-1863-11ef-9142-0242ac150002'
  ),
(
    'BATHING',
    'LESS_5_KM',
    'f5a9b3c4-1863-11ef-9142-0242ac150002'
  ),
(
    'HIKING',
    'ON_THE_SPOT',
    'f5a9b3c4-1863-11ef-9142-0242ac150002'
  ),
(
    'HORSE_RIDING',
    'ON_THE_SPOT',
    'f5a9b3c4-1863-11ef-9142-0242ac150002'
  ),
(
    'TREE_CLIMBING',
    'ON_THE_SPOT',
    'f5a9b3c4-1863-11ef-9142-0242ac150002'
  ),
(
    'BATHING',
    'ON_THE_SPOT',
    'f5a9b5e1-1863-11ef-9142-0242ac150002'
  ),
(
    'HIKING',
    'ON_THE_SPOT',
    'f5a9b5e1-1863-11ef-9142-0242ac150002'
  ),
(
    'HORSE_RIDING',
    'MORE_20_KM',
    'f5a9b5e1-1863-11ef-9142-0242ac150002'
  ),
(
    'SAIL',
    'LESS_10_KM',
    'f5a9b5e1-1863-11ef-9142-0242ac150002'
  ),
(
    'TREE_CLIMBING',
    'LESS_10_KM',
    'f5a9b5e1-1863-11ef-9142-0242ac150002'
  ),
(
    'GOLF',
    'MORE_20_KM',
    'f5aa6315-1863-11ef-9142-0242ac150002'
  ),
(
    'HIKING',
    'ON_THE_SPOT',
    'f5aa6315-1863-11ef-9142-0242ac150002'
  ),
(
    'HORSE_RIDING',
    'ON_THE_SPOT',
    'f5aa6315-1863-11ef-9142-0242ac150002'
  ),
(
    'TREE_CLIMBING',
    'LESS_10_KM',
    'f5aa6315-1863-11ef-9142-0242ac150002'
  ),
(
    'BATHING',
    'LESS_20_KM',
    'f5aa736b-1863-11ef-9142-0242ac150002'
  ),
(
    'HIKING',
    'LESS_10_KM',
    'f5aa736b-1863-11ef-9142-0242ac150002'
  ),
(
    'HORSE_RIDING',
    'ON_THE_SPOT',
    'f5aa736b-1863-11ef-9142-0242ac150002'
  ),
(
    'SAIL',
    'LESS_20_KM',
    'f5aa736b-1863-11ef-9142-0242ac150002'
  ),
(
    'TREE_CLIMBING',
    'LESS_10_KM',
    'f5aa736b-1863-11ef-9142-0242ac150002'
  ),
(
    'BATHING',
    'LESS_5_KM',
    'f5aa8ba8-1863-11ef-9142-0242ac150002'
  ),
(
    'GOLF',
    'LESS_10_KM',
    'f5aa8ba8-1863-11ef-9142-0242ac150002'
  ),
(
    'HIKING',
    'MORE_20_KM',
    'f5aa8ba8-1863-11ef-9142-0242ac150002'
  ),
(
    'SAIL',
    'MORE_20_KM',
    'f5aa8ba8-1863-11ef-9142-0242ac150002'
  ),
(
    'BATHING',
    'ON_THE_SPOT',
    'f5aaa155-1863-11ef-9142-0242ac150002'
  ),
(
    'GOLF',
    'LESS_5_KM',
    'f5aaa155-1863-11ef-9142-0242ac150002'
  ),
(
    'HORSE_RIDING',
    'MORE_20_KM',
    'f5aaa155-1863-11ef-9142-0242ac150002'
  ),
(
    'SAIL',
    'LESS_5_KM',
    'f5aaa155-1863-11ef-9142-0242ac150002'
  ),
(
    'TREE_CLIMBING',
    'MORE_20_KM',
    'f5aaa155-1863-11ef-9142-0242ac150002'
  ),
(
    'BATHING',
    'LESS_20_KM',
    'f5aaaac8-1863-11ef-9142-0242ac150002'
  ),
(
    'HORSE_RIDING',
    'LESS_5_KM',
    'f5aaaac8-1863-11ef-9142-0242ac150002'
  ),
(
    'SAIL',
    'ON_THE_SPOT',
    'f5aaaac8-1863-11ef-9142-0242ac150002'
  ),
(
    'BATHING',
    'LESS_20_KM',
    'f5ab19e3-1863-11ef-9142-0242ac150002'
  ),
(
    'CANOE',
    'ON_THE_SPOT',
    'f5ab19e3-1863-11ef-9142-0242ac150002'
  ),
(
    'SAIL',
    'MORE_20_KM',
    'f5ab19e3-1863-11ef-9142-0242ac150002'
  ),
(
    'TREE_CLIMBING',
    'ON_THE_SPOT',
    'f5ab19e3-1863-11ef-9142-0242ac150002'
  ),
(
    'BATHING',
    'LESS_20_KM',
    'f5ab243d-1863-11ef-9142-0242ac150002'
  ),
(
    'HIKING',
    'LESS_5_KM',
    'f5ab243d-1863-11ef-9142-0242ac150002'
  ),
(
    'HORSE_RIDING',
    'LESS_10_KM',
    'f5ab243d-1863-11ef-9142-0242ac150002'
  ),
(
    'TREE_CLIMBING',
    'LESS_20_KM',
    'f5ab243d-1863-11ef-9142-0242ac150002'
  ),
(
    'BATHING',
    'LESS_20_KM',
    'f5ab2875-1863-11ef-9142-0242ac150002'
  ),
(
    'GOLF',
    'ON_THE_SPOT',
    'f5ab2875-1863-11ef-9142-0242ac150002'
  ),
(
    'HORSE_RIDING',
    'ON_THE_SPOT',
    'f5ab2875-1863-11ef-9142-0242ac150002'
  ),
(
    'SAIL',
    'LESS_20_KM',
    'f5ab2875-1863-11ef-9142-0242ac150002'
  ),
(
    'BATHING',
    'LESS_20_KM',
    'f5ab8132-1863-11ef-9142-0242ac150002'
  ),
(
    'HORSE_RIDING',
    'ON_THE_SPOT',
    'f5ab8132-1863-11ef-9142-0242ac150002'
  ),
(
    'SAIL',
    'LESS_5_KM',
    'f5ab8132-1863-11ef-9142-0242ac150002'
  ),
(
    'BATHING',
    'LESS_20_KM',
    'f5ab8927-1863-11ef-9142-0242ac150002'
  ),
(
    'CANOE',
    'LESS_20_KM',
    'f5ab8927-1863-11ef-9142-0242ac150002'
  ),
(
    'HORSE_RIDING',
    'MORE_20_KM',
    'f5ab8927-1863-11ef-9142-0242ac150002'
  ),
(
    'BATHING',
    'LESS_20_KM',
    'f5ab9021-1863-11ef-9142-0242ac150002'
  ),
(
    'GOLF',
    'LESS_5_KM',
    'f5ab9021-1863-11ef-9142-0242ac150002'
  ),
(
    'HORSE_RIDING',
    'LESS_5_KM',
    'f5ab9021-1863-11ef-9142-0242ac150002'
  );

/*!40000 ALTER TABLE `activite` ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Table structure for table `amenagement`
--
DROP TABLE IF EXISTS `amenagement`;

/*!40101 SET @saved_cs_client     = @@character_set_client */
;

/*!50503 SET character_set_client = utf8mb4 */
;

CREATE TABLE `amenagement` (
  `amenities` varchar(255) NOT NULL,
  `logement_uuid` varchar(255) NOT NULL,
  PRIMARY KEY (`amenities`, `logement_uuid`),
  KEY `logement_fk_amenagement` (`logement_uuid`),
  CONSTRAINT `logement_fk_amenagement` FOREIGN KEY (`logement_uuid`) REFERENCES `logement` (`uuid`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

/*!40101 SET character_set_client = @saved_cs_client */
;

--
-- Dumping data for table `amenagement`
--
LOCK TABLES `amenagement` WRITE;

/*!40000 ALTER TABLE `amenagement` DISABLE KEYS */
;

INSERT INTO
  `amenagement`
VALUES
  ('BALCONY', 'f5a97f54-1863-11ef-9142-0242ac150002'),
('GARDEN', 'f5a97f54-1863-11ef-9142-0242ac150002'),
('JACUZZI', 'f5a97f54-1863-11ef-9142-0242ac150002'),
('POOL', 'f5a97f54-1863-11ef-9142-0242ac150002'),
('TERRACE', 'f5a97f54-1863-11ef-9142-0242ac150002'),
('BALCONY', 'f5a9ab0e-1863-11ef-9142-0242ac150002'),
('GARDEN', 'f5a9ab0e-1863-11ef-9142-0242ac150002'),
('JACUZZI', 'f5a9ab0e-1863-11ef-9142-0242ac150002'),
('POOL', 'f5a9ab0e-1863-11ef-9142-0242ac150002'),
('TERRACE', 'f5a9ab0e-1863-11ef-9142-0242ac150002'),
('BALCONY', 'f5a9b3c4-1863-11ef-9142-0242ac150002'),
('GARDEN', 'f5a9b3c4-1863-11ef-9142-0242ac150002'),
('JACUZZI', 'f5a9b3c4-1863-11ef-9142-0242ac150002'),
('POOL', 'f5a9b3c4-1863-11ef-9142-0242ac150002'),
('TERRACE', 'f5a9b3c4-1863-11ef-9142-0242ac150002'),
('BALCONY', 'f5a9b5e1-1863-11ef-9142-0242ac150002'),
('GARDEN', 'f5a9b5e1-1863-11ef-9142-0242ac150002'),
('JACUZZI', 'f5a9b5e1-1863-11ef-9142-0242ac150002'),
('POOL', 'f5a9b5e1-1863-11ef-9142-0242ac150002'),
('TERRACE', 'f5a9b5e1-1863-11ef-9142-0242ac150002'),
('BALCONY', 'f5aa6315-1863-11ef-9142-0242ac150002'),
('GARDEN', 'f5aa6315-1863-11ef-9142-0242ac150002'),
('JACUZZI', 'f5aa6315-1863-11ef-9142-0242ac150002'),
('POOL', 'f5aa6315-1863-11ef-9142-0242ac150002'),
('TERRACE', 'f5aa6315-1863-11ef-9142-0242ac150002'),
('BALCONY', 'f5aa736b-1863-11ef-9142-0242ac150002'),
('GARDEN', 'f5aa736b-1863-11ef-9142-0242ac150002'),
('JACUZZI', 'f5aa736b-1863-11ef-9142-0242ac150002'),
('POOL', 'f5aa736b-1863-11ef-9142-0242ac150002'),
('TERRACE', 'f5aa736b-1863-11ef-9142-0242ac150002'),
('BALCONY', 'f5aa8ba8-1863-11ef-9142-0242ac150002'),
('GARDEN', 'f5aa8ba8-1863-11ef-9142-0242ac150002'),
('JACUZZI', 'f5aa8ba8-1863-11ef-9142-0242ac150002'),
('POOL', 'f5aa8ba8-1863-11ef-9142-0242ac150002'),
('TERRACE', 'f5aa8ba8-1863-11ef-9142-0242ac150002'),
('BALCONY', 'f5aaa155-1863-11ef-9142-0242ac150002'),
('GARDEN', 'f5aaa155-1863-11ef-9142-0242ac150002'),
('JACUZZI', 'f5aaa155-1863-11ef-9142-0242ac150002'),
('POOL', 'f5aaa155-1863-11ef-9142-0242ac150002'),
('TERRACE', 'f5aaa155-1863-11ef-9142-0242ac150002'),
('BALCONY', 'f5aaaac8-1863-11ef-9142-0242ac150002'),
('GARDEN', 'f5aaaac8-1863-11ef-9142-0242ac150002'),
('JACUZZI', 'f5aaaac8-1863-11ef-9142-0242ac150002'),
('POOL', 'f5aaaac8-1863-11ef-9142-0242ac150002'),
('TERRACE', 'f5aaaac8-1863-11ef-9142-0242ac150002'),
('BALCONY', 'f5ab19e3-1863-11ef-9142-0242ac150002'),
('GARDEN', 'f5ab19e3-1863-11ef-9142-0242ac150002'),
('JACUZZI', 'f5ab19e3-1863-11ef-9142-0242ac150002'),
('POOL', 'f5ab19e3-1863-11ef-9142-0242ac150002'),
('TERRACE', 'f5ab19e3-1863-11ef-9142-0242ac150002'),
('BALCONY', 'f5ab243d-1863-11ef-9142-0242ac150002'),
('GARDEN', 'f5ab243d-1863-11ef-9142-0242ac150002'),
('JACUZZI', 'f5ab243d-1863-11ef-9142-0242ac150002'),
('POOL', 'f5ab243d-1863-11ef-9142-0242ac150002'),
('TERRACE', 'f5ab243d-1863-11ef-9142-0242ac150002'),
('BALCONY', 'f5ab2875-1863-11ef-9142-0242ac150002'),
('GARDEN', 'f5ab2875-1863-11ef-9142-0242ac150002'),
('JACUZZI', 'f5ab2875-1863-11ef-9142-0242ac150002'),
('POOL', 'f5ab2875-1863-11ef-9142-0242ac150002'),
('TERRACE', 'f5ab2875-1863-11ef-9142-0242ac150002'),
('BALCONY', 'f5ab8132-1863-11ef-9142-0242ac150002'),
('GARDEN', 'f5ab8132-1863-11ef-9142-0242ac150002'),
('JACUZZI', 'f5ab8132-1863-11ef-9142-0242ac150002'),
('POOL', 'f5ab8132-1863-11ef-9142-0242ac150002'),
('TERRACE', 'f5ab8132-1863-11ef-9142-0242ac150002'),
('BALCONY', 'f5ab8927-1863-11ef-9142-0242ac150002'),
('GARDEN', 'f5ab8927-1863-11ef-9142-0242ac150002'),
('JACUZZI', 'f5ab8927-1863-11ef-9142-0242ac150002'),
('POOL', 'f5ab8927-1863-11ef-9142-0242ac150002'),
('TERRACE', 'f5ab8927-1863-11ef-9142-0242ac150002'),
('BALCONY', 'f5ab9021-1863-11ef-9142-0242ac150002'),
('GARDEN', 'f5ab9021-1863-11ef-9142-0242ac150002'),
('JACUZZI', 'f5ab9021-1863-11ef-9142-0242ac150002'),
('POOL', 'f5ab9021-1863-11ef-9142-0242ac150002'),
('TERRACE', 'f5ab9021-1863-11ef-9142-0242ac150002');

/*!40000 ALTER TABLE `amenagement` ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Table structure for table `avis`
--
DROP TABLE IF EXISTS `avis`;

/*!40101 SET @saved_cs_client     = @@character_set_client */
;

/*!50503 SET character_set_client = utf8mb4 */
;

CREATE TABLE `avis` (
  `reservation_uuid` varchar(255) NOT NULL,
  `grade` int NOT NULL,
  `initial_comment` varchar(255) NOT NULL,
  `updated_comment` varchar(255) DEFAULT NULL,
  `owner_comment` varchar(255) DEFAULT NULL,
  `proprietaire_uuid` varchar(255) NOT NULL,
  `logement_uuid` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`reservation_uuid`),
  KEY `avis_fk_logement` (`logement_uuid`),
  KEY `avis_fk_proprietaire` (`proprietaire_uuid`),
  CONSTRAINT `avis_fk_logement` FOREIGN KEY (`logement_uuid`) REFERENCES `logement` (`uuid`) ON UPDATE CASCADE,
  CONSTRAINT `avis_fk_proprietaire` FOREIGN KEY (`proprietaire_uuid`) REFERENCES `proprietaire` (`uuid`) ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

/*!40101 SET character_set_client = @saved_cs_client */
;

--
-- Dumping data for table `avis`
--
LOCK TABLES `avis` WRITE;

/*!40000 ALTER TABLE `avis` DISABLE KEYS */
;

/*!40000 ALTER TABLE `avis` ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Table structure for table `client`
--
DROP TABLE IF EXISTS `client`;

/*!40101 SET @saved_cs_client     = @@character_set_client */
;

/*!50503 SET character_set_client = utf8mb4 */
;

CREATE TABLE `client` (
  `uuid` varchar(255) NOT NULL DEFAULT (uuid()),
  `email` varchar(255) NOT NULL,
  `hashed_password` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `billing_address1` varchar(255) DEFAULT NULL,
  `billing_address2` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `username` varchar(255) NOT NULL,
  `birthdate` date NOT NULL,
  PRIMARY KEY (`uuid`),
  UNIQUE KEY `email_unique` (`email`),
  UNIQUE KEY `username_unique` (`username`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

/*!40101 SET character_set_client = @saved_cs_client */
;

--
-- Dumping data for table `client`
--
LOCK TABLES `client` WRITE;

/*!40000 ALTER TABLE `client` DISABLE KEYS */
;

INSERT INTO
  `client`
VALUES
  (
    '3c790ab3-1863-11ef-9142-0242ac150002',
    'laura.barbier@example.com',
    '$2y$10$bOJrThX0mzpEUCA3QLEjtu7miRHhZCK9Cr77lWyyGvfP1V6D9cU.m',
    'MME',
    'Laura',
    'BARBIER',
    'https://camille-hacquet.github.io/bnbyte-pictures/picture/client/MME-0c7fbb2b-a0db-47ed-a73a-8a86bd305e96.jpg',
    '951 Rue Montmartre',
    '75018 Paris',
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01',
    'lbarbier',
    '1985-03-25'
  ),
(
    '3c7914af-1863-11ef-9142-0242ac150002',
    'elodie.lefevre@example.com',
    '$2y$10$bOJrThX0mzpEUCA3QLEjtu7miRHhZCK9Cr77lWyyGvfP1V6D9cU.m',
    'MME',
    'Elodie',
    'LEFEVRE',
    'https://camille-hacquet.github.io/bnbyte-pictures/picture/client/MME-1eec3bba-0b6c-4cda-996e-f8c43d04b2f5.jpg',
    '951 Rue de Grenelle',
    '75007 Paris',
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01',
    'elefevre',
    '1990-08-15'
  ),
(
    '3c791761-1863-11ef-9142-0242ac150002',
    'martin.durand@example.com',
    '$2y$10$bOJrThX0mzpEUCA3QLEjtu7miRHhZCK9Cr77lWyyGvfP1V6D9cU.m',
    'M',
    'Martin',
    'DURAND',
    'https://camille-hacquet.github.io/bnbyte-pictures/picture/client/M-1fa918d3-2fd3-4f02-a607-3a1b573681f0.jpg',
    '123 Rue de la Paix',
    '75001 Paris',
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01',
    'mdurand',
    '1982-07-09'
  ),
(
    '3c793547-1863-11ef-9142-0242ac150002',
    'lucas.perrin@example.com',
    '$2y$10$bOJrThX0mzpEUCA3QLEjtu7miRHhZCK9Cr77lWyyGvfP1V6D9cU.m',
    'M',
    'Lucas',
    'PERRIN',
    'https://camille-hacquet.github.io/bnbyte-pictures/picture/client/M-8dc773e2-c9eb-44aa-88cf-b38b9c5017ae.jpg',
    '357 Avenue des Champs-Élysées',
    '75008 Paris',
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01',
    'lperrin',
    '1995-11-21'
  ),
(
    '3c793877-1863-11ef-9142-0242ac150002',
    'claire.bernard@example.com',
    '$2y$10$bOJrThX0mzpEUCA3QLEjtu7miRHhZCK9Cr77lWyyGvfP1V6D9cU.m',
    'MME',
    'Claire',
    'BERNARD',
    'https://camille-hacquet.github.io/bnbyte-pictures/picture/client/MME-3f2cc19d-c228-4594-8a31-8dc5b0dc56ab.jpg',
    '456 Avenue de France',
    '69001 Lyon',
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01',
    'cbernard',
    '1992-05-14'
  ),
(
    '3c7942ec-1863-11ef-9142-0242ac150002',
    'amelie.fabre@example.com',
    '$2y$10$bOJrThX0mzpEUCA3QLEjtu7miRHhZCK9Cr77lWyyGvfP1V6D9cU.m',
    'MME',
    'Amélie',
    'FABRE',
    'https://camille-hacquet.github.io/bnbyte-pictures/picture/client/MME-4fdbeea6-3735-43c9-b555-cf08fe85dd55.jpg',
    '753 Boulevard Haussmann',
    '75009 Paris',
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01',
    'afabre',
    '1988-12-02'
  ),
(
    '3c79463a-1863-11ef-9142-0242ac150002',
    'antoine.lebret@example.com',
    '$2y$10$bOJrThX0mzpEUCA3QLEjtu7miRHhZCK9Cr77lWyyGvfP1V6D9cU.m',
    'M',
    'Antoine',
    'LEBRET',
    'https://camille-hacquet.github.io/bnbyte-pictures/picture/client/M-8dfc8cb5-3eee-4cca-b679-7ee0b8970a2c.jpg',
    '789 Boulevard Saint-Germain',
    '75006 Paris',
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01',
    'alebret',
    '1987-04-23'
  ),
(
    '3c794931-1863-11ef-9142-0242ac150002',
    'gael.rousseau@example.com',
    '$2y$10$bOJrThX0mzpEUCA3QLEjtu7miRHhZCK9Cr77lWyyGvfP1V6D9cU.m',
    'M',
    'Gaël',
    'ROUSSEAU',
    'https://camille-hacquet.github.io/bnbyte-pictures/picture/client/M-9e03917e-580b-4842-bacd-3a04f567a3bb.jpg',
    '159 Rue Saint-Antoine',
    '75004 Paris',
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01',
    'grousseau',
    '1994-09-19'
  ),
(
    '3c795e9d-1863-11ef-9142-0242ac150002',
    'marie.martin@example.com',
    '$2y$10$bOJrThX0mzpEUCA3QLEjtu7miRHhZCK9Cr77lWyyGvfP1V6D9cU.m',
    'MME',
    'Marie',
    'MARTIN',
    'https://camille-hacquet.github.io/bnbyte-pictures/picture/client/MME-5b0c5f49-9439-48e7-a8c8-0688bbf5c680.jpg',
    '321 Rue de la République',
    '13001 Marseille',
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01',
    'mmartin',
    '1981-06-30'
  ),
(
    '3c796155-1863-11ef-9142-0242ac150002',
    'lea.joly@example.com',
    '$2y$10$bOJrThX0mzpEUCA3QLEjtu7miRHhZCK9Cr77lWyyGvfP1V6D9cU.m',
    'MME',
    'Léa',
    'JOLY',
    'https://camille-hacquet.github.io/bnbyte-pictures/picture/client/MME-7e25dc93-5458-41f4-9808-0b14d127bb70.jpg',
    '321 Rue de Rivoli',
    '75001 Paris',
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01',
    'ljoly',
    '1983-10-08'
  );

/*!40000 ALTER TABLE `client` ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Table structure for table `devis`
--
DROP TABLE IF EXISTS `devis`;

/*!40101 SET @saved_cs_client     = @@character_set_client */
;

/*!50503 SET character_set_client = utf8mb4 */
;

CREATE TABLE `devis` (
  `uuid` varchar(255) NOT NULL DEFAULT (uuid()),
  `client_uuid` varchar(255) DEFAULT NULL,
  `nb_people` int NOT NULL,
  `daily_price_ttc` int NOT NULL,
  `service_fees` int NOT NULL,
  `tourist_tax` int NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `cancellation_deadline` int NOT NULL,
  `logement_uuid` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `daily_price_ht` int NOT NULL,
  `total_ttc` int NOT NULL,
  PRIMARY KEY (`uuid`),
  KEY `devis_fk_logement` (`logement_uuid`),
  KEY `devis_fk_user` (`client_uuid`),
  CONSTRAINT `devis_fk_logement` FOREIGN KEY (`logement_uuid`) REFERENCES `logement` (`uuid`) ON UPDATE CASCADE,
  CONSTRAINT `devis_fk_user` FOREIGN KEY (`client_uuid`) REFERENCES `client` (`uuid`) ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

/*!40101 SET character_set_client = @saved_cs_client */
;

--
-- Dumping data for table `devis`
--
LOCK TABLES `devis` WRITE;

/*!40000 ALTER TABLE `devis` DISABLE KEYS */
;

INSERT INTO
  `devis`
VALUES
  (
    'ada26e26-1863-11ef-9142-0242ac150002',
    '3c791761-1863-11ef-9142-0242ac150002',
    2,
    1000000,
    60000,
    60600,
    '2024-06-01 00:00:00',
    '2024-06-07 00:00:00',
    5,
    'f5a97f54-1863-11ef-9142-0242ac150002',
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01',
    850000,
    612100
  ),
(
    'ada29ddc-1863-11ef-9142-0242ac150002',
    '3c793877-1863-11ef-9142-0242ac150002',
    4,
    2000000,
    180000,
    181800,
    '2024-08-01 00:00:00',
    '2024-08-10 00:00:00',
    7,
    'f5a97f54-1863-11ef-9142-0242ac150002',
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01',
    1700000,
    1836200
  ),
(
    'ada2ae5a-1863-11ef-9142-0242ac150002',
    '3c794931-1863-11ef-9142-0242ac150002',
    2,
    800000,
    56000,
    56600,
    '2024-07-07 00:00:00',
    '2024-07-14 00:00:00',
    7,
    'f5a9b5e1-1863-11ef-9142-0242ac150002',
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01',
    700000,
    571300
  ),
(
    'ada2bcfe-1863-11ef-9142-0242ac150002',
    '3c794931-1863-11ef-9142-0242ac150002',
    3,
    1000000,
    170000,
    171700,
    '2024-07-08 00:00:00',
    '2024-07-25 00:00:00',
    7,
    'f5aa6315-1863-11ef-9142-0242ac150002',
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01',
    850000,
    1734200
  ),
(
    'ada2c516-1863-11ef-9142-0242ac150002',
    '3c793877-1863-11ef-9142-0242ac150002',
    4,
    1500000,
    150000,
    151500,
    '2024-08-03 00:00:00',
    '2024-08-13 00:00:00',
    7,
    'f5aa736b-1863-11ef-9142-0242ac150002',
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01',
    1300000,
    1530200
  ),
(
    'ada2cb8e-1863-11ef-9142-0242ac150002',
    '3c791761-1863-11ef-9142-0242ac150002',
    2,
    900000,
    54000,
    54500,
    '2024-06-06 00:00:00',
    '2024-06-12 00:00:00',
    5,
    'f5aa736b-1863-11ef-9142-0242ac150002',
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01',
    750000,
    550900
  ),
(
    'ada2d18d-1863-11ef-9142-0242ac150002',
    '3c793877-1863-11ef-9142-0242ac150002',
    1,
    4000000,
    240000,
    242400,
    '2024-08-05 00:00:00',
    '2024-08-11 00:00:00',
    7,
    'f5aa8ba8-1863-11ef-9142-0242ac150002',
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01',
    3700000,
    2448200
  ),
(
    'ada2d9a3-1863-11ef-9142-0242ac150002',
    '3c794931-1863-11ef-9142-0242ac150002',
    3,
    2500000,
    200000,
    202000,
    '2024-08-01 00:00:00',
    '2024-08-09 00:00:00',
    7,
    'f5aa8ba8-1863-11ef-9142-0242ac150002',
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01',
    2100000,
    2040200
  ),
(
    'ada2e021-1863-11ef-9142-0242ac150002',
    '3c791761-1863-11ef-9142-0242ac150002',
    3,
    4000000,
    240000,
    242400,
    '2024-06-05 00:00:00',
    '2024-06-11 00:00:00',
    5,
    'f5aaa155-1863-11ef-9142-0242ac150002',
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01',
    3500000,
    2448200
  ),
(
    'ada2e602-1863-11ef-9142-0242ac150002',
    '3c791761-1863-11ef-9142-0242ac150002',
    3,
    2500000,
    175000,
    176800,
    '2024-06-02 00:00:00',
    '2024-06-09 00:00:00',
    5,
    'f5aaaac8-1863-11ef-9142-0242ac150002',
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01',
    2100000,
    1785200
  ),
(
    'ada2eb4b-1863-11ef-9142-0242ac150002',
    '3c794931-1863-11ef-9142-0242ac150002',
    2,
    8000000,
    80000,
    80800,
    '2024-07-15 00:00:00',
    '2024-07-16 00:00:00',
    7,
    'f5aaaac8-1863-11ef-9142-0242ac150002',
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01',
    7500000,
    816100
  );

/*!40000 ALTER TABLE `devis` ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Table structure for table `facture`
--
DROP TABLE IF EXISTS `facture`;

/*!40101 SET @saved_cs_client     = @@character_set_client */
;

/*!50503 SET character_set_client = utf8mb4 */
;

CREATE TABLE `facture` (
  `uuid` varchar(255) NOT NULL DEFAULT (uuid()),
  `user_title` varchar(255) NOT NULL,
  `owner_title` varchar(255) NOT NULL,
  `user_firstname` varchar(255) NOT NULL,
  `user_lastname` varchar(255) NOT NULL,
  `user_address1` varchar(255) NOT NULL,
  `user_address2` varchar(255) NOT NULL,
  `owner_firstname` varchar(255) NOT NULL,
  `owner_lastname` varchar(255) NOT NULL,
  `owner_address1` varchar(255) NOT NULL,
  `owner_address2` varchar(255) NOT NULL,
  `proprietaire_uuid` varchar(255) NOT NULL,
  `client_uuid` varchar(255) NOT NULL,
  `reservation_uuid` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uuid`),
  KEY `facture_fk_client` (`client_uuid`),
  KEY `facture_fk_proprietaire` (`proprietaire_uuid`),
  KEY `facture_fk_reservation` (`reservation_uuid`),
  CONSTRAINT `facture_fk_client` FOREIGN KEY (`client_uuid`) REFERENCES `client` (`uuid`) ON UPDATE CASCADE,
  CONSTRAINT `facture_fk_proprietaire` FOREIGN KEY (`proprietaire_uuid`) REFERENCES `proprietaire` (`uuid`) ON UPDATE CASCADE,
  CONSTRAINT `facture_fk_reservation` FOREIGN KEY (`reservation_uuid`) REFERENCES `reservation` (`uuid`) ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

/*!40101 SET character_set_client = @saved_cs_client */
;

--
-- Dumping data for table `facture`
--
LOCK TABLES `facture` WRITE;

/*!40000 ALTER TABLE `facture` DISABLE KEYS */
;

/*!40000 ALTER TABLE `facture` ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Table structure for table `langue_proprietaire`
--
DROP TABLE IF EXISTS `langue_proprietaire`;

/*!40101 SET @saved_cs_client     = @@character_set_client */
;

/*!50503 SET character_set_client = utf8mb4 */
;

CREATE TABLE `langue_proprietaire` (
  `code` varchar(5) NOT NULL,
  `proprietaire_uuid` varchar(30) NOT NULL,
  PRIMARY KEY (`code`, `proprietaire_uuid`),
  KEY `proprietaire_fk_langue_proprietaire` (`proprietaire_uuid`),
  CONSTRAINT `proprietaire_fk_langue_proprietaire` FOREIGN KEY (`proprietaire_uuid`) REFERENCES `proprietaire` (`uuid`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

/*!40101 SET character_set_client = @saved_cs_client */
;

--
-- Dumping data for table `langue_proprietaire`
--
LOCK TABLES `langue_proprietaire` WRITE;

/*!40000 ALTER TABLE `langue_proprietaire` DISABLE KEYS */
;

/*!40000 ALTER TABLE `langue_proprietaire` ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Table structure for table `logement`
--
DROP TABLE IF EXISTS `logement`;

/*!40101 SET @saved_cs_client     = @@character_set_client */
;

/*!50503 SET character_set_client = utf8mb4 */
;

CREATE TABLE `logement` (
  `uuid` varchar(255) NOT NULL DEFAULT (uuid()),
  `street_number` varchar(255) NOT NULL,
  `street_name` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `region` varchar(255) NOT NULL,
  `latitude` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `place_id` varchar(255) NOT NULL,
  `housing_type` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price_ht` int NOT NULL,
  `capacity` int NOT NULL,
  `state` varchar(255) NOT NULL,
  `arrival` time NOT NULL,
  `departure` time NOT NULL,
  `proprietaire_uuid` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `introduction` varchar(255) DEFAULT NULL,
  `housing_size` varchar(30) DEFAULT NULL,
  `surface` int DEFAULT NULL,
  `bedroom_number` int DEFAULT NULL,
  `single_bed_number` int DEFAULT NULL,
  `double_bed_number` int DEFAULT NULL,
  `price_ttc` int DEFAULT NULL,
  `minimal_location_duration` int NOT NULL DEFAULT '1',
  `minimal_delay` int NOT NULL DEFAULT '1',
  `zipcode` varchar(255) NOT NULL,
  PRIMARY KEY (`uuid`),
  KEY `logement_fk_proprietaire` (`proprietaire_uuid`),
  CONSTRAINT `logement_fk_proprietaire` FOREIGN KEY (`proprietaire_uuid`) REFERENCES `proprietaire` (`uuid`) ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

/*!40101 SET character_set_client = @saved_cs_client */
;

--
-- Dumping data for table `logement`
--
LOCK TABLES `logement` WRITE;

/*!40000 ALTER TABLE `logement` DISABLE KEYS */
;

INSERT INTO
  `logement`
VALUES
  (
    'f5a97f54-1863-11ef-9142-0242ac150002',
    '50',
    'route du Château',
    'Rennes',
    'Ille-et-Vilaine',
    'Bretagne',
    '48.1173',
    '-1.6778',
    'ChIJzT2rDhtvDkgRbt26MPHdBQk',
    'CHATEAU',
    'Château dans la campagne',
    'Bienvenue dans ce majestueux château, niché dans la campagne verdoyante à proximité de Rennes, où le luxe et l\'histoire se rencontrent pour une expérience de séjour inoubliable...',
    40000,
    20,
    'OFFLINE',
    '15:00:00',
    '11:00:00',
    'd960beca-1866-11ef-9142-0242ac150002',
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01',
    'Introduction au Château',
    'OTHER',
    500,
    5,
    2,
    3,
    42000,
    1,
    1,
    '35000'
  ),
(
    'f5a9ab0e-1863-11ef-9142-0242ac150002',
    '12',
    'rue du Port',
    'Brest',
    'Finistère',
    'Bretagne',
    '48.390394',
    '-4.486076',
    'ChIJc2s0eHT0CEgRh1_aJbzAn3A',
    'APPARTEMENT',
    'Appartement spacieux au coeur de ville',
    'Bienvenue dans notre logement, un appartement spacieux et lumineux de deux chambres, idéalement situé en plein cœur de la ville...',
    10000,
    4,
    'ONLINE',
    '15:00:00',
    '11:00:00',
    'd960beca-1866-11ef-9142-0242ac150002',
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01',
    'Introduction à l\'Appartement',
    'T1',
    120,
    2,
    2,
    1,
    12000,
    1,
    1,
    '29000'
  ),
(
    'f5a9b3c4-1863-11ef-9142-0242ac150002',
    '18',
    'rue de la Mer',
    'Saint-Malo',
    'Ille-et-Vilaine',
    'Bretagne',
    '48.6493',
    '-2.0257',
    'ChIJ_6r1-y1QDkgRszGVWm13LQs',
    'MAISON',
    'Maison sur la côte',
    'Bienvenue à Saint-Malo, une destination emblématique sur la côte nord de la Bretagne ! Si vous recherchez une maison confortable de plain-pied pour votre séjour dans cette charmante ville...',
    15000,
    6,
    'ONLINE',
    '15:00:00',
    '11:00:00',
    'd960e1a5-1866-11ef-9142-0242ac150002',
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01',
    'Introduction à la Maison',
    'F4',
    200,
    3,
    2,
    2,
    16000,
    1,
    1,
    '35321'
  ),
(
    'f5a9b5e1-1863-11ef-9142-0242ac150002',
    '22',
    'rue de la République',
    'Lorient',
    'Morbihan',
    'Bretagne',
    '47.7500',
    '-3.3667',
    'ChIJzT2rDhtvDkgRbt26MPHdBQk',
    'APPARTEMENT',
    'Appartement au centre ville calme',
    'Bienvenue dans cet appartement chaleureux et moderne, idéalement situé à Lorient, à quelques pas du site du Festival Interceltique...',
    9000,
    4,
    'OFFLINE',
    '15:00:00',
    '11:00:00',
    'd960e1a5-1866-11ef-9142-0242ac150002',
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01',
    'Introduction à l\'Appartement',
    'T3',
    100,
    2,
    2,
    1,
    10000,
    1,
    1,
    '56100'
  ),
(
    'f5aa6315-1863-11ef-9142-0242ac150002',
    '5',
    'place de la Mairie',
    'Rennes',
    'Ille-et-Vilaine',
    'Bretagne',
    '48.117266',
    '-1.677793',
    'ChIJzT2rDhtvDkgRbt26MPHdBQk',
    'APPARTEMENT',
    'Grand appartement calme',
    'Bienvenue dans notre logement, un charmant appartement d\'une chambre situé dans un quartier calme et résidentiel...',
    7000,
    2,
    'ONLINE',
    '15:00:00',
    '11:00:00',
    'd960e5e8-1866-11ef-9142-0242ac150002',
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01',
    'Introduction à l\'Appartement',
    'T2',
    80,
    1,
    1,
    1,
    8000,
    1,
    1,
    '35000'
  ),
(
    'f5aa736b-1863-11ef-9142-0242ac150002',
    '12',
    'rue des Chênes',
    'Campagne',
    'Côtes-d\'Armor',
    'Bretagne',
    '48.3558',
    '-2.2885',
    'ChIJzT2rDhtvDkgRbt26MPHdBQk',
    'MAISON',
    'Longère authentique calme',
    'Bienvenue dans cette charmante longère isolée, nichée au cœur de la campagne, où le temps semble ralentir et où la tranquillité règne en maître...',
    10000,
    6,
    'ONLINE',
    '15:00:00',
    '11:00:00',
    'd960eca8-1866-11ef-9142-0242ac150002',
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01',
    'Introduction à la Longère',
    'F2',
    150,
    3,
    2,
    2,
    11000,
    1,
    1,
    '22948'
  ),
(
    'f5aa8ba8-1863-11ef-9142-0242ac150002',
    '8',
    'rue de l\'Étang',
    'Glomel',
    'Côtes-d\'Armor',
    'Bretagne',
    '48.1911',
    '-3.4497',
    'ChIJJ4fF1Db_DkgRC2gDEaTZ3E4',
    'MAISON',
    'Maison chaleureuse et authentique',
    'Bienvenue à Glomel, un havre de paix au cœur de la nature bretonne ! Si vous recherchez une maison chaleureuse et confortable, à proximité d\'un étang où vous pourrez vous baigner...',
    12000,
    6,
    'ONLINE',
    '16:00:00',
    '11:00:00',
    'd960f34e-1866-11ef-9142-0242ac150002',
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01',
    'Introduction à la Maison',
    'F2',
    140,
    3,
    2,
    2,
    13000,
    1,
    1,
    '22837'
  ),
(
    'f5aaa155-1863-11ef-9142-0242ac150002',
    '20',
    'avenue du Général Leclerc',
    'Rennes',
    'Ille-et-Vilaine',
    'Bretagne',
    '48.1173',
    '-1.6778',
    'ChIJK2XPb1wDk0cRAZlQ-0pu98A',
    'APPARTEMENT',
    'Penthouse au coeur de Rennes',
    'Bienvenue dans ce superbe penthouse situé au cœur de Rennes, offrant une vue imprenable sur la ville et un luxe inégalé dans un cadre urbain chic...',
    25000,
    6,
    'OFFLINE',
    '15:00:00',
    '11:00:00',
    'd960fdc6-1866-11ef-9142-0242ac150002',
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01',
    'Introduction au Penthouse',
    'T6',
    300,
    4,
    2,
    2,
    27000,
    1,
    1,
    '35000'
  ),
(
    'f5aaaac8-1863-11ef-9142-0242ac150002',
    '20',
    'avenue des Roses',
    'Quimper',
    'Finistère',
    '\n\nBretagne',
    '47.995473',
    '-4.097899',
    'ChIJ5xIdNhtvDkgRbt26MPHdBQk',
    'VILLA',
    'Splendide Villa ',
    'Bienvenue dans cette charmante villa, un havre de paix et de luxe où le confort rencontre l\'élégance. Nichée dans un cadre idyllique, cette propriété offre une escapade parfaite...',
    25000,
    10,
    'ONLINE',
    '18:00:00',
    '11:00:00',
    'd9610789-1866-11ef-9142-0242ac150002',
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01',
    'Introduction à la Villa',
    'F7',
    400,
    5,
    2,
    3,
    27000,
    1,
    1,
    '29100'
  ),
(
    'f5ab19e3-1863-11ef-9142-0242ac150002',
    '15',
    'rue de la Ferme',
    'Campagne',
    'Ille-et-Vilaine',
    'Bretagne',
    '48.1218',
    '-1.6748',
    'ChIJzT2rDhtvDkgRbt26MPHdBQk',
    'FERME',
    'Ferme au calme',
    'Bienvenue chez Monique, la charmante fermière qui ouvre les portes de sa maison et de son cœur pour vous accueillir dans une expérience de séjour authentique à la campagne...',
    8000,
    4,
    'ONLINE',
    '15:00:00',
    '11:00:00',
    'd9610f82-1866-11ef-9142-0242ac150002',
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01',
    'Introduction à la Ferme',
    'F3',
    180,
    3,
    1,
    1,
    9000,
    1,
    1,
    '35234'
  ),
(
    'f5ab243d-1863-11ef-9142-0242ac150002',
    '12',
    'rue des Festivals',
    'Carhaix',
    'Finistère',
    'Bretagne',
    '48.2764',
    '-3.5728',
    'ChIJ92rHUq3IDkgR-W2kxSHKnBQ',
    'MAISON',
    'Maison à Carhaix super belle',
    'Bienvenue à Carhaix, une ville animée au cœur de la Bretagne, célèbre pour ses festivals de musique légendaires...',
    18000,
    8,
    'ONLINE',
    '15:00:00',
    '11:00:00',
    'd9610f82-1866-11ef-9142-0242ac150002',
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01',
    'Introduction à la Maison',
    'F3',
    250,
    4,
    2,
    2,
    19000,
    1,
    1,
    '29210'
  ),
(
    'f5ab2875-1863-11ef-9142-0242ac150002',
    '15',
    'chemin des Prés',
    'Lorient',
    'Morbihan',
    'Bretagne',
    '47.746442',
    '-3.366843',
    'ChIJ5xIdNhtvDkgRbt26MPHdBQk',
    'VILLA',
    'Villa tout confort',
    'Bienvenue dans ce luxueux refuge contemporain niché dans un cadre idyllique, où le calme de la nature rencontre le confort moderne...',
    30000,
    12,
    'ONLINE',
    '15:00:00',
    '11:00:00',
    'd961167c-1866-11ef-9142-0242ac150002',
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01',
    'Introduction à la Villa',
    'OTHER',
    500,
    6,
    2,
    3,
    32000,
    1,
    1,
    '56100'
  ),
(
    'f5ab8132-1863-11ef-9142-0242ac150002',
    '25',
    'rue du Stade',
    'Vannes',
    'Morbihan',
    'Bretagne',
    '47.658236',
    '-2.760847',
    'ChIJ5xIdNhtvDkgRbt26MPHdBQk',
    'MANOIR',
    'Grand manoir spacieux',
    'Bienvenue dans ce majestueux manoir, une oasis de grandeur et de charme intemporel, où l\'histoire se mêle harmonieusement au confort moderne...',
    50000,
    15,
    'ONLINE',
    '15:00:00',
    '11:00:00',
    'd961167c-1866-11ef-9142-0242ac150002',
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01',
    'Introduction au Manoir',
    'OTHER',
    700,
    8,
    3,
    5,
    52000,
    1,
    1,
    '56000'
  ),
(
    'f5ab8927-1863-11ef-9142-0242ac150002',
    '15',
    'rue de la Fête',
    'Landerneau',
    'Finistère',
    'Bretagne',
    '48.4495',
    '-4.2522',
    'ChIJx1x3_Qj1CkgR8rPwFr0wT3c',
    'MAISON',
    'Grande maison trop belle',
    'Bienvenue à Landerneau, terre de festivals et de bonne musique ! Si vous êtes à la recherche d\'un hébergement spacieux et confortable pour profiter pleinement de la \"Fête du Bruit\"...',
    15000,
    4,
    'ONLINE',
    '15:00:00',
    '11:00:00',
    'd9611e9c-1866-11ef-9142-0242ac150002',
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01',
    'Introduction à la Maison',
    'F4',
    150,
    2,
    2,
    1,
    16000,
    1,
    1,
    '29173'
  ),
(
    'f5ab9021-1863-11ef-9142-0242ac150002',
    '45',
    'avenue de la République',
    'Rennes',
    'Ille-et-Vilaine',
    'Bretagne',
    '48.1173',
    '-1.6778',
    'ChIJQ05xDTccDkgRZCoZ8x0GNcc',
    'APPARTEMENT',
    'Appartement moderne',
    'Bienvenue dans cet hébergement confortable et moderne, situé au cœur d\'une ville animée...',
    12000,
    2,
    'ONLINE',
    '15:00:00',
    '11:00:00',
    'd9611e9c-1866-11ef-9142-0242ac150002',
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01',
    'Introduction à l\'Appartement',
    'T3',
    100,
    1,
    1,
    1,
    13000,
    1,
    1,
    '35000'
  );

/*!40000 ALTER TABLE `logement` ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Table structure for table `photo_logement`
--
DROP TABLE IF EXISTS `photo_logement`;

/*!40101 SET @saved_cs_client     = @@character_set_client */
;

/*!50503 SET character_set_client = utf8mb4 */
;

CREATE TABLE `photo_logement` (
  `uuid` varchar(255) NOT NULL DEFAULT (uuid()),
  `url` varchar(255) NOT NULL,
  `order` int NOT NULL DEFAULT '0',
  `logement_uuid` varchar(255) NOT NULL,
  PRIMARY KEY (`uuid`),
  UNIQUE KEY `unique_order_logement` (`order`, `logement_uuid`),
  KEY `photo_logement_fk_logement` (`logement_uuid`),
  CONSTRAINT `photo_logement_fk_logement` FOREIGN KEY (`logement_uuid`) REFERENCES `logement` (`uuid`) ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

/*!40101 SET character_set_client = @saved_cs_client */
;

--
-- Dumping data for table `photo_logement`
--
LOCK TABLES `photo_logement` WRITE;

/*!40000 ALTER TABLE `photo_logement` DISABLE KEYS */
;

INSERT INTO
  `photo_logement`
VALUES
  (
    '0a09a6fa-1879-11ef-9142-0242ac150002',
    'https://camille-hacquet.github.io/bnbyte-pictures/photo_logement/appartement-4d301e90-6e0e-4ecf-866d-9d8e8fbea1f8.webp',
    0,
    'f5a9ab0e-1863-11ef-9142-0242ac150002'
  ),
(
    '226374b9-1879-11ef-9142-0242ac150002',
    'https://camille-hacquet.github.io/bnbyte-pictures/photo_logement/appartement-6d2eb47d-c5d6-4eb3-9700-086e146feed0.webp',
    0,
    'f5a9b5e1-1863-11ef-9142-0242ac150002'
  ),
(
    '2b1a6e35-1879-11ef-9142-0242ac150002',
    'https://camille-hacquet.github.io/bnbyte-pictures/photo_logement/appartement-7e74bfb3-a421-4e73-80bc-bc87a7205b86.webp',
    0,
    'f5aa6315-1863-11ef-9142-0242ac150002'
  ),
(
    '37fe9515-1879-11ef-9142-0242ac150002',
    'https://camille-hacquet.github.io/bnbyte-pictures/photo_logement/appartement-019d5fc1-a889-4130-bc08-41be665419d5.webp',
    0,
    'f5aaa155-1863-11ef-9142-0242ac150002'
  ),
(
    '38c11215-187b-11ef-9142-0242ac150002',
    'https://camille-hacquet.github.io/bnbyte-pictures/photo_logement/manoir-177c3b41-89ac-481b-94b6-874079789aba.webp',
    0,
    'f5ab8132-1863-11ef-9142-0242ac150002'
  ),
(
    '426a8454-1879-11ef-9142-0242ac150002',
    'https://camille-hacquet.github.io/bnbyte-pictures/photo_logement/appartement-49bf1e9c-8db7-4cbd-a579-9bf5b2267953.webp',
    0,
    'f5ab9021-1863-11ef-9142-0242ac150002'
  ),
(
    '5f5a28c6-187a-11ef-9142-0242ac150002',
    'https://camille-hacquet.github.io/bnbyte-pictures/photo_logement/maison-4a074f54-3487-4e99-b7d0-332e5ec05810.webp',
    0,
    'f5a9b3c4-1863-11ef-9142-0242ac150002'
  ),
(
    '6ccb4473-187a-11ef-9142-0242ac150002',
    'https://camille-hacquet.github.io/bnbyte-pictures/photo_logement/maison-9c3dde47-f0c6-4d3e-8842-e90e3debedb8.webp',
    0,
    'f5aa736b-1863-11ef-9142-0242ac150002'
  ),
(
    '75426c82-187a-11ef-9142-0242ac150002',
    'https://camille-hacquet.github.io/bnbyte-pictures/photo_logement/maison-74e48b58-c839-4867-8d60-7c9ce6eb775f.webp',
    0,
    'f5aa8ba8-1863-11ef-9142-0242ac150002'
  ),
(
    '7ed7d1e0-187a-11ef-9142-0242ac150002',
    'https://camille-hacquet.github.io/bnbyte-pictures/photo_logement/maison-0371fa65-5cb2-4463-a09c-5b5781621a4d.webp',
    0,
    'f5ab243d-1863-11ef-9142-0242ac150002'
  ),
(
    '8a91dfb0-187a-11ef-9142-0242ac150002',
    'https://camille-hacquet.github.io/bnbyte-pictures/photo_logement/maison-757617d1-ebcd-499b-ab86-248520ff4a3a.webp',
    0,
    'f5ab8927-1863-11ef-9142-0242ac150002'
  ),
(
    '8fcb4bea-187b-11ef-9142-0242ac150002',
    'https://camille-hacquet.github.io/bnbyte-pictures/photo_logement/ferme-db97ad64-d696-4f4e-9f04-f7d95f598b79.webp',
    0,
    'f5ab19e3-1863-11ef-9142-0242ac150002'
  ),
(
    'c839922e-1879-11ef-9142-0242ac150002',
    'https://camille-hacquet.github.io/bnbyte-pictures/photo_logement/chateau-2e4c6ae3-c0b6-4f00-a8cb-e289f0cb1e36.webp',
    0,
    'f5a97f54-1863-11ef-9142-0242ac150002'
  ),
(
    'e6bd1938-187a-11ef-9142-0242ac150002',
    'https://camille-hacquet.github.io/bnbyte-pictures/photo_logement/villa-03c40981-db69-439e-a812-b293e6bf6c99.webp',
    0,
    'f5aaaac8-1863-11ef-9142-0242ac150002'
  ),
(
    'efc8cfb0-187a-11ef-9142-0242ac150002',
    'https://camille-hacquet.github.io/bnbyte-pictures/photo_logement/villa-36122ed6-62df-49e9-99fa-ae25afbe9763.webp',
    0,
    'f5ab2875-1863-11ef-9142-0242ac150002'
  );

/*!40000 ALTER TABLE `photo_logement` ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Table structure for table `planning`
--
DROP TABLE IF EXISTS `planning`;

/*!40101 SET @saved_cs_client     = @@character_set_client */
;

/*!50503 SET character_set_client = utf8mb4 */
;

CREATE TABLE `planning` (
  `logement_uuid` varchar(255) NOT NULL,
  `unavailability_date` date NOT NULL,
  PRIMARY KEY (`logement_uuid`, `unavailability_date`),
  CONSTRAINT `planning_fk_logement` FOREIGN KEY (`logement_uuid`) REFERENCES `logement` (`uuid`) ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

/*!40101 SET character_set_client = @saved_cs_client */
;

--
-- Dumping data for table `planning`
--
LOCK TABLES `planning` WRITE;

/*!40000 ALTER TABLE `planning` DISABLE KEYS */
;

INSERT INTO
  `planning`
VALUES
  (
    'f5a97f54-1863-11ef-9142-0242ac150002',
    '2024-06-02'
  ),
(
    'f5a97f54-1863-11ef-9142-0242ac150002',
    '2024-06-03'
  ),
(
    'f5a97f54-1863-11ef-9142-0242ac150002',
    '2024-06-04'
  );

/*!40000 ALTER TABLE `planning` ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Table structure for table `proprietaire`
--
DROP TABLE IF EXISTS `proprietaire`;

/*!40101 SET @saved_cs_client     = @@character_set_client */
;

/*!50503 SET character_set_client = utf8mb4 */
;

CREATE TABLE `proprietaire` (
  `uuid` varchar(255) NOT NULL DEFAULT (uuid()),
  `email` varchar(255) NOT NULL,
  `hashed_password` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `address1` varchar(255) DEFAULT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `identity_card` varchar(255) DEFAULT NULL,
  `identity_verified` tinyint(1) NOT NULL DEFAULT '0',
  `iban` varchar(255) DEFAULT NULL,
  `cancellation_deadline` int NOT NULL DEFAULT '5',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `username` varchar(255) DEFAULT NULL,
  `birthdate` date NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `bank_account_holder` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`uuid`),
  UNIQUE KEY `email_unique` (`email`),
  UNIQUE KEY `username_unique` (`username`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

/*!40101 SET character_set_client = @saved_cs_client */
;

--
-- Dumping data for table `proprietaire`
--
LOCK TABLES `proprietaire` WRITE;

/*!40000 ALTER TABLE `proprietaire` DISABLE KEYS */
;

INSERT INTO
  `proprietaire`
VALUES
  (
    'd960beca-1866-11ef-9142-0242ac150002',
    'pierre.legrand@example.com',
    '$2y$10$bOJrThX0mzpEUCA3QLEjtu7miRHhZCK9Cr77lWyyGvfP1V6D9cU.m',
    'M',
    'Pierre',
    'LEGRAND',
    'https://camille-hacquet.github.io/bnbyte-pictures/picture/proprietaire/M-5c6201e7-8aa0-45c7-8c75-ca1be796b969.jpg',
    '12 Rue du Port',
    '35000 Rennes',
    'https://camille-hacquet.github.io/bnbyte-pictures/picture/cni/M-cni.jpg',
    1,
    'FR7630006000011234567890189',
    5,
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01',
    'plegrand',
    '1980-07-15',
    '0123456789',
    'Pierre Legrand'
  ),
(
    'd960e1a5-1866-11ef-9142-0242ac150002',
    'marion.lejeune@example.com',
    '$2y$10$bOJrThX0mzpEUCA3QLEjtu7miRHhZCK9Cr77lWyyGvfP1V6D9cU.m',
    'MME',
    'Marion',
    'LEJEUNE',
    'https://camille-hacquet.github.io/bnbyte-pictures/picture/proprietaire/MME-14c2dec1-1227-40da-97fe-9883a5a2da19.jpg',
    '432 Rue des Pins',
    '22200 Guingamp',
    'https://camille-hacquet.github.io/bnbyte-pictures/picture/cni/MME-cni.png',
    1,
    'FR7630006000011234567890189',
    5,
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01',
    'mlejeune',
    '1985-09-23',
    '0987654321',
    'Marion Lejeune'
  ),
(
    'd960e5e8-1866-11ef-9142-0242ac150002',
    'anne.durand@example.com',
    '$2y$10$bOJrThX0mzpEUCA3QLEjtu7miRHhZCK9Cr77lWyyGvfP1V6D9cU.m',
    'MME',
    'Anne',
    'DURAND',
    'https://camille-hacquet.github.io/bnbyte-pictures/picture/proprietaire/MME-96ea4ea5-e62a-4c54-8ee4-5c2e3ac2d030.jpg',
    '34 Avenue de Bretagne',
    '56100 Lorient',
    'https://camille-hacquet.github.io/bnbyte-pictures/picture/cni/MME-cni.png',
    1,
    'FR7630006000011234567890189',
    5,
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01',
    'adurand',
    '1978-02-14',
    '0223344556',
    'Anne Durand'
  ),
(
    'd960eca8-1866-11ef-9142-0242ac150002',
    'alexandre.martinez@example.com',
    '$2y$10$bOJrThX0mzpEUCA3QLEjtu7miRHhZCK9Cr77lWyyGvfP1V6D9cU.m',
    'M',
    'Alexandre',
    'MARTINEZ',
    'https://camille-hacquet.github.io/bnbyte-pictures/picture/proprietaire/M-7f7a6d80-6c93-42ad-83fd-c62aa3f7bd44.jpg',
    '454 Rue des Oliviers',
    '29100 Douarnenez',
    'https://camille-hacquet.github.io/bnbyte-pictures/picture/cni/M-cni.jpg',
    1,
    'FR7630006000011234567890189',
    5,
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01',
    'amartinez',
    '1982-11-30',
    '0345566778',
    'Alexandre Martinez'
  ),
(
    'd960f34e-1866-11ef-9142-0242ac150002',
    'jean-michel.leclerc@example.com',
    '$2y$10$bOJrThX0mzpEUCA3QLEjtu7miRHhZCK9Cr77lWyyGvfP1V6D9cU.m',
    'M',
    'Jean-Michel',
    'LECLERC',
    'https://camille-hacquet.github.io/bnbyte-pictures/picture/proprietaire/M-7f51f4bf-15b6-4625-8dcf-cf3e60c8ce37.jpg',
    '56 Rue de la Gare',
    '29200 Brest',
    'https://camille-hacquet.github.io/bnbyte-pictures/picture/cni/M-cni.jpg',
    0,
    'FR7630006000011234567890189',
    5,
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01',
    'jmleclerc',
    '1975-04-20',
    '0456677889',
    'Jean-Michel Leclerc'
  ),
(
    'd960fdc6-1866-11ef-9142-0242ac150002',
    'marie.leroy@example.com',
    '$2y$10$bOJrThX0mzpEUCA3QLEjtu7miRHhZCK9Cr77lWyyGvfP1V6D9cU.m',
    'MME',
    'Marie',
    'LEROY',
    'https://camille-hacquet.github.io/bnbyte-pictures/picture/proprietaire/MME-272d1741-4a96-491f-be24-2dbc329fa8c7.jpg',
    '78 Boulevard de la Liberté',
    '35400 Saint-Malo',
    'https://camille-hacquet.github.io/bnbyte-pictures/picture/cni/MME-cni.png',
    1,
    'FR7630006000011234567890189',
    5,
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01',
    'mleroy',
    '1985-05-06',
    '0566778890',
    'Marie Leroy'
  ),
(
    'd9610789-1866-11ef-9142-0242ac150002',
    'lucas.moreau@example.com',
    '$2y$10$bOJrThX0mzpEUCA3QLEjtu7miRHhZCK9Cr77lWyyGvfP1V6D9cU.m',
    'M',
    'Lucas',
    'MOREAU',
    'https://camille-hacquet.github.io/bnbyte-pictures/picture/proprietaire/M-22dc3931-f7ba-4427-a510-9eaa272326e8.jpg',
    '90 Place de la Mairie',
    '56000 Vannes',
    'https://camille-hacquet.github.io/bnbyte-pictures/picture/cni/M-cni.jpg',
    1,
    'FR7630006000011234567890189',
    7,
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01',
    'lmoreau',
    '1989-08-19',
    '0677889900',
    'Lucas Moreau'
  ),
(
    'd9610f82-1866-11ef-9142-0242ac150002',
    'julie.roux@example.com',
    '$2y$10$bOJrThX0mzpEUCA3QLEjtu7miRHhZCK9Cr77lWyyGvfP1V6D9cU.m',
    'MME',
    'Julie',
    'ROUX',
    'https://camille-hacquet.github.io/bnbyte-pictures/picture/proprietaire/MME-623b9ade-1efe-4248-985d-f89622ca7624.jpg',
    '123 Rue de la Mer',
    '29100 Douarnenez',
    'https://camille-hacquet.github.io/bnbyte-pictures/picture/cni/MME-cni.png',
    0,
    'FR7630006000011234567890189',
    5,
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01',
    'jroux',
    '1990-12-02',
    '0788990011',
    'Julie Roux'
  ),
(
    'd961167c-1866-11ef-9142-0242ac150002',
    'thomas.garnier@example.com',
    '$2y$10$bOJrThX0mzpEUCA3QLEjtu7miRHhZCK9Cr77lWyyGvfP1V6D9cU.m',
    'M',
    'Thomas',
    'GARNIER',
    'https://camille-hacquet.github.io/bnbyte-pictures/picture/proprietaire/M-29ef93cd-8a0c-46b1-a672-e3631b597b32.jpg',
    '45 Rue des Lices',
    '22200 Guingamp',
    'https://camille-hacquet.github.io/bnbyte-pictures/picture/cni/M-cni.jpg',
    0,
    'FR7630006000011234567890189',
    5,
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01',
    'tgarnier',
    '1977-03-10',
    '0899001122',
    'Thomas Garnier'
  ),
(
    'd9611e9c-1866-11ef-9142-0242ac150002',
    'emilie.dupuis@example.com',
    '$2y$10$bOJrThX0mzpEUCA3QLEjtu7miRHhZCK9Cr77lWyyGvfP1V6D9cU.m',
    'MME',
    'Emilie',
    'DUPUIS',
    'https://camille-hacquet.github.io/bnbyte-pictures/picture/proprietaire/MME-2582d10e-ff9e-42ad-817a-d6748530b483.jpg',
    '67 Rue des Sables',
    '22370 Pléneuf-Val-André',
    'https://camille-hacquet.github.io/bnbyte-pictures/picture/cni/MME-cni.png',
    1,
    'FR7630006000011234567890189',
    8,
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01',
    'edupuis',
    '1991-01-25',
    '0990011223',
    'Emilie Dupuis'
  );

/*!40000 ALTER TABLE `proprietaire` ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Table structure for table `recu`
--
DROP TABLE IF EXISTS `recu`;

/*!40101 SET @saved_cs_client     = @@character_set_client */
;

/*!50503 SET character_set_client = utf8mb4 */
;

CREATE TABLE `recu` (
  `uuid` varchar(255) NOT NULL DEFAULT (uuid()),
  `amount_ttc` int NOT NULL,
  `payment_mode` varchar(255) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `card_last_four` varchar(255) DEFAULT NULL,
  `card_exp` varchar(255) DEFAULT NULL,
  `paypal_email` varchar(255) DEFAULT NULL,
  `reservation_uuid` varchar(255) NOT NULL,
  `client_uuid` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uuid`),
  KEY `recu_fk_client` (`client_uuid`),
  KEY `recu_fk_reservation` (`reservation_uuid`),
  CONSTRAINT `recu_fk_client` FOREIGN KEY (`client_uuid`) REFERENCES `client` (`uuid`) ON UPDATE CASCADE,
  CONSTRAINT `recu_fk_reservation` FOREIGN KEY (`reservation_uuid`) REFERENCES `reservation` (`uuid`) ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

/*!40101 SET character_set_client = @saved_cs_client */
;

--
-- Dumping data for table `recu`
--
LOCK TABLES `recu` WRITE;

/*!40000 ALTER TABLE `recu` DISABLE KEYS */
;

/*!40000 ALTER TABLE `recu` ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Table structure for table `reservation`
--
DROP TABLE IF EXISTS `reservation`;

/*!40101 SET @saved_cs_client     = @@character_set_client */
;

/*!50503 SET character_set_client = utf8mb4 */
;

CREATE TABLE `reservation` (
  `uuid` varchar(255) NOT NULL DEFAULT (uuid()),
  `is_canceled` tinyint(1) NOT NULL DEFAULT '0',
  `logement_uuid` varchar(255) NOT NULL,
  `devis_uuid` varchar(255) NOT NULL,
  `client_uuid` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uuid`),
  KEY `reservation_fk_client` (`client_uuid`),
  KEY `reservation_fk_devis` (`devis_uuid`),
  KEY `reservation_fk_logement` (`logement_uuid`),
  CONSTRAINT `reservation_fk_client` FOREIGN KEY (`client_uuid`) REFERENCES `client` (`uuid`) ON UPDATE CASCADE,
  CONSTRAINT `reservation_fk_devis` FOREIGN KEY (`devis_uuid`) REFERENCES `devis` (`uuid`) ON UPDATE CASCADE,
  CONSTRAINT `reservation_fk_logement` FOREIGN KEY (`logement_uuid`) REFERENCES `logement` (`uuid`) ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

/*!40101 SET character_set_client = @saved_cs_client */
;

--
-- Dumping data for table `reservation`
--
LOCK TABLES `reservation` WRITE;

/*!40000 ALTER TABLE `reservation` DISABLE KEYS */
;

INSERT INTO
  `reservation`
VALUES
  (
    '50eb44e9-1868-11ef-9142-0242ac150002',
    0,
    'f5a97f54-1863-11ef-9142-0242ac150002',
    'ada26e26-1863-11ef-9142-0242ac150002',
    '3c791761-1863-11ef-9142-0242ac150002',
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01'
  ),
(
    '50eb6428-1868-11ef-9142-0242ac150002',
    0,
    'f5a97f54-1863-11ef-9142-0242ac150002',
    'ada29ddc-1863-11ef-9142-0242ac150002',
    '3c791761-1863-11ef-9142-0242ac150002',
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01'
  ),
(
    '50eb6c74-1868-11ef-9142-0242ac150002',
    0,
    'f5a97f54-1863-11ef-9142-0242ac150002',
    'ada2ae5a-1863-11ef-9142-0242ac150002',
    '3c791761-1863-11ef-9142-0242ac150002',
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01'
  ),
(
    '50eb737b-1868-11ef-9142-0242ac150002',
    0,
    'f5a9ab0e-1863-11ef-9142-0242ac150002',
    'ada2bcfe-1863-11ef-9142-0242ac150002',
    '3c791761-1863-11ef-9142-0242ac150002',
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01'
  ),
(
    '50eb7854-1868-11ef-9142-0242ac150002',
    0,
    'f5a9b3c4-1863-11ef-9142-0242ac150002',
    'ada2c516-1863-11ef-9142-0242ac150002',
    '3c791761-1863-11ef-9142-0242ac150002',
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01'
  ),
(
    '50eb7fdd-1868-11ef-9142-0242ac150002',
    0,
    'f5a9b3c4-1863-11ef-9142-0242ac150002',
    'ada2cb8e-1863-11ef-9142-0242ac150002',
    '3c791761-1863-11ef-9142-0242ac150002',
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01'
  ),
(
    '50eb863d-1868-11ef-9142-0242ac150002',
    1,
    'f5a9b5e1-1863-11ef-9142-0242ac150002',
    'ada2d18d-1863-11ef-9142-0242ac150002',
    '3c794931-1863-11ef-9142-0242ac150002',
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01'
  ),
(
    '50eb8d21-1868-11ef-9142-0242ac150002',
    0,
    'f5aa6315-1863-11ef-9142-0242ac150002',
    'ada2d9a3-1863-11ef-9142-0242ac150002',
    '3c794931-1863-11ef-9142-0242ac150002',
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01'
  ),
(
    '50eb9406-1868-11ef-9142-0242ac150002',
    0,
    'f5aa6315-1863-11ef-9142-0242ac150002',
    'ada2e021-1863-11ef-9142-0242ac150002',
    '3c794931-1863-11ef-9142-0242ac150002',
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01'
  ),
(
    '50eb9885-1868-11ef-9142-0242ac150002',
    0,
    'f5aa8ba8-1863-11ef-9142-0242ac150002',
    'ada2e602-1863-11ef-9142-0242ac150002',
    '3c794931-1863-11ef-9142-0242ac150002',
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01'
  ),
(
    '50eb9d22-1868-11ef-9142-0242ac150002',
    0,
    'f5aa8ba8-1863-11ef-9142-0242ac150002',
    'ada2eb4b-1863-11ef-9142-0242ac150002',
    '3c794931-1863-11ef-9142-0242ac150002',
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01'
  ),
(
    '50eba1af-1868-11ef-9142-0242ac150002',
    1,
    'f5aaa155-1863-11ef-9142-0242ac150002',
    'ada2cb8e-1863-11ef-9142-0242ac150002',
    '3c793877-1863-11ef-9142-0242ac150002',
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01'
  ),
(
    '50eba69c-1868-11ef-9142-0242ac150002',
    0,
    'f5aaaac8-1863-11ef-9142-0242ac150002',
    'ada2ae5a-1863-11ef-9142-0242ac150002',
    '3c793877-1863-11ef-9142-0242ac150002',
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01'
  ),
(
    '50ebac66-1868-11ef-9142-0242ac150002',
    0,
    'f5ab19e3-1863-11ef-9142-0242ac150002',
    'ada29ddc-1863-11ef-9142-0242ac150002',
    '3c793877-1863-11ef-9142-0242ac150002',
    '2024-05-22 17:46:01',
    '2024-05-22 17:46:01'
  );

/*!40000 ALTER TABLE `reservation` ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Table structure for table `synkronizator`
--
DROP TABLE IF EXISTS `synkronizator`;

/*!40101 SET @saved_cs_client     = @@character_set_client */
;

/*!50503 SET character_set_client = utf8mb4 */
;

CREATE TABLE `synkronizator` (
  `id` int NOT NULL AUTO_INCREMENT,
  `api_key` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `scopes` varchar(255) DEFAULT NULL,
  `proprietaire_uuid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `synkronizator_unique` (`api_key`),
  KEY `proprietaire_fk_synkronizator` (`proprietaire_uuid`),
  CONSTRAINT `proprietaire_fk_synkronizator` FOREIGN KEY (`proprietaire_uuid`) REFERENCES `proprietaire` (`uuid`)
) ENGINE = InnoDB AUTO_INCREMENT = 2 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

/*!40101 SET character_set_client = @saved_cs_client */
;

--
-- Dumping data for table `synkronizator`
--
LOCK TABLES `synkronizator` WRITE;

/*!40000 ALTER TABLE `synkronizator` DISABLE KEYS */
;

INSERT INTO
  `synkronizator`
VALUES
  (
    1,
    'zCMu91TRM2cE1FV9qFYlS1bSP1FBe0aYNPpD1Q4KPWbGAFlGa5qrdKRA9Fl3C7Lo',
    1,
    '',
    'd960beca-1866-11ef-9142-0242ac150002'
  );

/*!40000 ALTER TABLE `synkronizator` ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Dumping events for database 'bnbyte'
--
--
-- Dumping routines for database 'bnbyte'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */
;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */
;

/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */
;

/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */
;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
;

/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
;

/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
;

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */
;

-- Dump completed on 2024-06-27 15:09:34