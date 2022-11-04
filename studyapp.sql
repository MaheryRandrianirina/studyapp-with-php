-- MySQL dump 10.13  Distrib 8.0.29, for Win64 (x86_64)
--
-- Host: localhost    Database: studyapp
-- ------------------------------------------------------
-- Server version	8.0.29

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `emploi_du_temps`
--

DROP TABLE IF EXISTS `emploi_du_temps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `emploi_du_temps` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `emploi_du_temps_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=189 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `emploi_du_temps`
--

LOCK TABLES `emploi_du_temps` WRITE;
/*!40000 ALTER TABLE `emploi_du_temps` DISABLE KEYS */;
INSERT INTO `emploi_du_temps` VALUES (188,1);
/*!40000 ALTER TABLE `emploi_du_temps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `emploi_du_temps_content`
--

DROP TABLE IF EXISTS `emploi_du_temps_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `emploi_du_temps_content` (
  `id` int NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) NOT NULL,
  `chapter` varchar(255) NOT NULL,
  `done` tinyint(1) DEFAULT '0',
  `emploi_du_temps_id` int NOT NULL,
  `date` int NOT NULL,
  `time` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `emploi_du_temps_id` (`emploi_du_temps_id`),
  CONSTRAINT `emploi_du_temps_content_ibfk_1` FOREIGN KEY (`emploi_du_temps_id`) REFERENCES `emploi_du_temps` (`id`) ON DELETE CASCADE,
  CONSTRAINT `emploi_du_temps_content_ibfk_2` FOREIGN KEY (`emploi_du_temps_id`) REFERENCES `emploi_du_temps` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `emploi_du_temps_content`
--

LOCK TABLES `emploi_du_temps_content` WRITE;
/*!40000 ALTER TABLE `emploi_du_temps_content` DISABLE KEYS */;
INSERT INTO `emploi_du_temps_content` VALUES (121,'frs','1',0,188,1666904400,1666958400),(122,'math','2',0,188,1666990800,1667026800),(123,'math','2',0,188,1666990800,1667052000);
/*!40000 ALTER TABLE `emploi_du_temps_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `emploi_du_temps_day`
--

DROP TABLE IF EXISTS `emploi_du_temps_day`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `emploi_du_temps_day` (
  `id` int NOT NULL AUTO_INCREMENT,
  `calendar_timestamp` int NOT NULL,
  `emploi_du_temps_id` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `emploi_du_temps_id` (`emploi_du_temps_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `emploi_du_temps_day_ibfk_1` FOREIGN KEY (`emploi_du_temps_id`) REFERENCES `emploi_du_temps` (`id`) ON DELETE CASCADE,
  CONSTRAINT `emploi_du_temps_day_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `emploi_du_temps_day_ibfk_3` FOREIGN KEY (`emploi_du_temps_id`) REFERENCES `emploi_du_temps` (`id`) ON DELETE CASCADE,
  CONSTRAINT `emploi_du_temps_day_ibfk_4` FOREIGN KEY (`emploi_du_temps_id`) REFERENCES `emploi_du_temps` (`id`) ON DELETE CASCADE,
  CONSTRAINT `emploi_du_temps_day_ibfk_5` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `emploi_du_temps_day`
--

LOCK TABLES `emploi_du_temps_day` WRITE;
/*!40000 ALTER TABLE `emploi_du_temps_day` DISABLE KEYS */;
INSERT INTO `emploi_du_temps_day` VALUES (78,1666904400,188,1),(79,1666990800,188,1),(80,1666990800,188,1);
/*!40000 ALTER TABLE `emploi_du_temps_day` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `emploi_du_temps_subject`
--

DROP TABLE IF EXISTS `emploi_du_temps_subject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `emploi_du_temps_subject` (
  `emploi_du_temps_id` int NOT NULL,
  `subject_id` int NOT NULL,
  KEY `emploi_du_temps_id` (`emploi_du_temps_id`),
  KEY `subject_id` (`subject_id`),
  CONSTRAINT `emploi_du_temps_subject_ibfk_1` FOREIGN KEY (`emploi_du_temps_id`) REFERENCES `emploi_du_temps` (`id`) ON DELETE CASCADE,
  CONSTRAINT `emploi_du_temps_subject_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `emploi_du_temps_subject`
--

LOCK TABLES `emploi_du_temps_subject` WRITE;
/*!40000 ALTER TABLE `emploi_du_temps_subject` DISABLE KEYS */;
/*!40000 ALTER TABLE `emploi_du_temps_subject` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `content` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subject`
--

DROP TABLE IF EXISTS `subject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subject` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `exercise` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subject`
--

LOCK TABLES `subject` WRITE;
/*!40000 ALTER TABLE `subject` DISABLE KEYS */;
/*!40000 ALTER TABLE `subject` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `birth` date NOT NULL,
  `country` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `sexe` varchar(5) NOT NULL,
  `password` varchar(255) NOT NULL,
  `path_to_profile_photo` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `mail` (`mail`),
  UNIQUE KEY `password` (`password`),
  UNIQUE KEY `password_2` (`password`),
  UNIQUE KEY `password_3` (`password`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'mahery','mahery@gmail.com','2000-04-26','madagascar','fianarantsoa','2022-09-09 08:23:54','homme','$2y$10$XV3f75m3KZ.Nv8G3XTQWaenVFPCj9YRS.NFaMsTbVPMcflerv/Q4y',NULL),(2,'lalaina','lala@gmail.com','2001-12-28','madagascar','fianarantsoa','2022-09-09 17:40:32','femme','$2y$10$wEo/QiJ7YrcXoiNlI/HJmecgOTPGdC9ayXguWFnHJUlDCwW9E1LM.',NULL),(3,'njaka','njaka@gmail.com','2005-12-09','madagascar','fianarantsoa','2022-09-09 17:46:35','homme','$2y$10$FYT1O2JEYDO9Erwin3CtcO.bV/K1e/gFUzw4d6cStTcqsQtVZvp2a',NULL),(9,'njaka2','njaka2@gmail.com','2005-12-09','madagascar','fianarantsoa','2022-09-09 18:05:55','homme','$2y$10$chBI./At7QPUOCxaDQt.weRfmmYGh5s9/ElYFoJ/PhFnoOg19gM3G',NULL),(11,'njaka3','njaka3@gmail.com','2009-12-05','madagascar','fianarantsoa','2022-09-09 18:07:43','homme','$2y$10$QA0q8M40ZbHZCGKgX4gAL.73rDjpnIa9hx.lPUj0Kx8K5lTEWjlO2',NULL),(12,'njaka4','njaka4@gmail.com','2009-12-05','madagascar','fianarantsoa','2022-09-09 18:08:32','homme','$2y$10$oXGWe.HRnsaAtj0C35BUGelF/vttF/IX16p9HqScXa5CsABjLwy0a',NULL),(13,'test','test@gmail.com','2000-04-26','madagascar','fianarantsoa','2022-09-09 18:11:50','homme','$2y$10$Z4hu5TeYME5CA2IXXu8NDe/1RksWYKjflqEv0hLZmMTWBa1DV/8/m',NULL),(14,'test2','test2@gmail.com','2000-04-26','madagascar','fianarantsoa','2022-09-09 18:15:50','homme','$2y$10$jumfDRNvR7cV/2ci170UZ.4fw9QOl8pxCTye1xp2T0mHef0m1Xq36',NULL),(16,'papa','papa@gmail.com','1968-07-21','madagascar','fianarantsoa','2022-09-09 18:20:10','homme','$2y$10$dj5iE519O4RZZnSL7.paE.HrKHQFDIR0bh.ILEVgE47JROsSrKuSy',NULL),(17,'mama','mama@gmail.com','1977-02-10','madagascar','fianarantsoa','2022-09-09 18:21:36','homme','$2y$10$z3BbhjCQ3PAcQvGurUhniOziDSejCC6g3FrZRe.oa72GPMK.RU4LC',NULL),(18,'bidon','bidon@gmail.com','2000-02-12','madagascar','fianarantsoa','2022-09-09 18:27:21','homme','$2y$10$RyWMx2zGcxfeyC0F2HN6W.u.pwKLXPRc2oIwLrLMQdTy4NJCTcirS',NULL),(19,'fdf','fdf@gmail.com','2001-02-15','madagascar','fianarantsoa','2022-09-09 18:28:19','homme','$2y$10$3cZIHWYqtXfqZ6IRE0q1JuPJZkpNWm6ci41F6ecs9uEU2c/p8OB.K',NULL),(20,'testbidon','testbidon@gmail.com','2001-02-26','madagascar','fianarantsoa','2022-09-09 18:32:16','homme','$2y$10$OaGkZtK7lTh1Y4EbA5zYxOH84CJCNe2jDotuGgKXZAUQk2c3bAEY6',NULL),(21,'mahery2000','mahery2000@gmail.com','2000-04-26','madagascar','fianarantsoa','2022-09-09 18:39:13','homme','$2y$10$RnGUmzDHLo.I1oIFxxtd4uTstxFffdfpbiTOOfG7ULxxujMmlDcue',NULL),(22,'mahery2001','mahery2001@gmail.com','2001-04-26','madagascar','fianarantsoa','2022-09-09 18:40:14','homme','$2y$10$PyuLJGFYOJQ0LNqjxdRYsutBLeJ1MVNi7vIKYv2ZvQa9SfGKd6udO',NULL),(23,'mahery2002','mahery2002@gmail.com','2002-04-26','madagascar','fianarantsoa','2022-09-09 18:41:13','homme','$2y$10$i7h893t/Ks.VXMiCINjRTuDaoMJeG9TJEo4w1wvzMuh9f9pVpZRSS',NULL),(24,'pseudo','pseudo@gmail.com','2001-12-22','madagascar','fianarantsoa','2022-09-09 18:48:03','femme','$2y$10$eTcjyLzz3rUbRav/V97KmOCKe/U74e8edvZ0cIYIhSbJUabHttrGO',NULL),(25,'pseudo1','pseudo1@gmail.com','2006-06-06','madagascar','fianarantsoa','2022-09-09 18:53:14','femme','$2y$10$6l7Z0RJN2F3oGnRQQ57/y.FRtJ.kfEErikjaalx/X/HhH5DCxwn6S',NULL),(26,'adzadad','adzadad@gmail.com','2003-01-25','madagascar','fianarantsoa','2022-09-10 08:17:44','homme','$2y$10$MDExygsd69VGMnZwR/Oq.OvBmYMfh3F7qz9paF14v6RDQPFihySxu',NULL),(27,'azazez2000','azazez2000@gmail.com','1333-05-06','madagascar','fianarantsoa','2022-09-10 08:22:55','homme','$2y$10$mSMgn0GwcJYe5DiXWeO9D.ymBqr.nHT4BhqKPDc6yGycX.KsXnaLW',NULL),(28,'zaezaez50','zaezaez50@gmail.com','2001-05-05','madagascar','fianarantsoa','2022-09-10 08:26:34','femme','$2y$10$ru5L.lTq9DvZ8Ao80KPjOO5da3ioRFgsHIfLRM4Bn0Dk2Ogkj2hFq',NULL),(31,'zdyegfyuegf','zdyegfyuegf@gmail.com','1999-05-06','madagascar','fianarantsoa','2022-09-10 08:49:31','femme','$2y$10$kQCRfW2cX3jW5WQaKJHhau3sqWlI3VwefuzlVY6sKm82vKiATiUsS',NULL),(32,'zdezfzef','zdezfzef@gmail.com','2008-06-08','madagascar','fianarantsoa','2022-09-10 08:51:08','femme','$2y$10$KbvvrYm3owhHaXf/f5cIrOd7t9rWKvbcfqAtWYI/sTcW6R2nn/czu',NULL),(33,'grthrth','grthrth@gmail.com','2006-06-08','madagascar','fianarantsoa','2022-09-10 08:52:34','femme','$2y$10$0MNgPmMpyMIfjd7ymNMbjOX9fAnBh18FYjPWr5gQX8vBMBFOnWMeW',NULL),(35,'bdfngfjyt','bdfngfjyt@gmail.com','2020-08-05','madagascar','fianarantsoa','2022-09-10 08:54:35','homme','$2y$10$1bzCqfx9JF1OcVefjgNbdeOgzZNtfYS5bsqtgylqRCvaa76uMNp9y',NULL),(36,'fregergt','fregergt@gmail.com','2552-08-08','madagascar','fianarantsoa','2022-09-10 08:55:14','homme','$2y$10$eWnKC9y9pXRDn67pMqEW2uM6X/Kp2IagX9no/o0Is8BzjYHSup9S6',NULL),(37,'gtrhytj','gtrhytj@gmail.com','2525-04-06','madagascar','fianarantsoa','2022-09-10 09:09:13','homme','$2y$10$TL6wOQbVFTmtT1sexqqXOeNCsW08AYgvNlH3LYJVdqioW3Pciu/Oa',NULL),(40,'htjhtyj','htjhtyj@mail.com','2000-04-07','madagascar','fianarantsoa','2022-09-10 09:27:27','homme','$2y$10$4OGEvFAt60c9RnlwmN/fRe/ojO.XXXFZ285h8Xk8w2/KwsTeG3cGu',NULL),(41,'jytjyh','jytjyh@gmail.com','2000-05-06','madagascar','fianarantsoa','2022-09-10 09:32:40','homme','$2y$10$qXnBdcGP5qzeeKuSVo7Z9eT6OAs2ZtEDp99REyKW0flV3ONSmjojC',NULL),(42,'ghjhkuj','ghjhkuj@gmail.com','2000-06-05','madagascar','fianarantsoa','2022-09-10 19:19:56','homme','$2y$10$FbMOYOVnwsll0RI5uHGl2u2jzSNKKkmO1uXKQLExxJS9DjeszyzPy',NULL),(43,'djeklfzrhj3','djeklfzrhj3@gmail.com','2006-06-06','madagascar','fianarantsoa','2022-09-10 20:52:06','homme','$2y$10$7c596NFW3ORvTWBYoHbsFO55u8Dm8aiHnkpGmNDl036Q7yCqd4IQa',NULL),(45,'htyjytjtyj30','htyjytjtyj30@gmail.com','2010-08-25','madagascar','fianarantsoa','2022-09-10 20:57:56','femme','$2y$10$p.BfzGxg3lxoDc2MPe1QW.MmYUIw.OicMqpfu1zs49joIhy81ZJsu',NULL),(46,'hdjfshdjfd4','hdjfshdjfd4@gmail.com','2007-05-07','madagascar','fianarantsoa','2022-09-10 21:22:39','homme','$2y$10$3MMsks7gJFBpdJOE5ommJehbE/519md.nnOeTNoAPvWwPH6KgTxTu',NULL),(47,'registerAction3','registerAction3@gmail.com','2000-06-08','madagascar','fianarantsoa','2022-09-10 21:25:17','homme','$2y$10$cuDreWPT7nUv2l5EJ8VE5uM3aFU7iZCd0NR60bRfaDQg0TXkOFZza',NULL),(48,'jukui12','jukui12@mail.com','2001-07-05','madagascar','fianarantsoa','2022-09-10 21:26:57','femme','$2y$10$AP4uWwihAcnf/5mCqmAD.OdsG0Adzglff6Bn.F79NGzwlBwQJx/DK',NULL),(49,'bgnhtn12','bgnhtn12@mail.com','2004-05-24','madagascar','fianarantsoa','2022-09-10 21:29:21','femme','$2y$10$b830vqrv1gNsG2dnS3sp8ODI/J1HAPkVyss31SOHbFeJmLmcFPM1q',NULL),(50,'bgnht32','bgnht32@gmail.com','1555-06-15','madagascar','fianarantsoa','2022-09-10 21:31:20','homme','$2y$10$ApDhM9kanMcrTN2xTWUX1efG9NIjSwyK7XqYb2Wa0ziogxoT3PrL6',NULL),(51,'hgjgrg30','hgjgrg30@gmail.com','2005-08-27','madagascar','fianarantsoa','2022-09-13 07:48:03','homme','$2y$10$GhRXthNucnfEdSr/zD6/dOK0W/FywvCX7LAnjNZY9rwvqisXrIKZW',NULL),(52,'hghgjh25','hghgjh25@gmail.com','2000-02-05','madagascar','fianarantsoa','2022-09-13 07:51:46','femme','$2y$10$xGcCnRD62Q4LearUNZtwZO4O9nxOohL.0Pkv25Vw26ePD6WUYhW6S',NULL),(54,'hghgjh253','hghgjh253@gmail.com','2022-11-05','madagascar','fianarantsoa','2022-09-13 07:53:41','homme','$2y$10$guWufgjOvEP1ZnyHWrXoaOEF622x0ugbMg0Fqol23HZy.bgfVpP6a',NULL),(55,'hghgjh257','hghgjh257@gmail.com','2000-05-31','madagascar','fianarantsoa','2022-09-13 07:54:26','homme','$2y$10$aIuF0MDKS2y5gjcCOixX/uFE2jMT8RjPa9/oYidhmNfFuSC1fd1Em',NULL),(56,'hghgjh251','hghgjh251@gmail.com','2000-03-05','madagascar','fianarantsoa','2022-09-13 07:56:24','homme','$2y$10$ucqFjaMf.1B3BVtthOU1wOBCfJKhcV3ruKPjZVhucUK/CQ2G1fPoy',NULL),(57,'nhkjluil12','nhkjluil12@gmail.com','2001-04-07','madagascar','fianarantsoa','2022-09-13 08:00:48','homme','$2y$10$psCdivR1YLo8tdGnAk/vtu355/0OabLTY6JjtK7HDB91hkzl3UQI.',NULL),(58,'nhkjluil121','nhkjluil121@mail.com','2003-02-11','madagascar','fianarantsoa','2022-09-13 08:02:34','femme','$2y$10$VPHlIwdWWaOG3RU2//21D.y3Zd61qu2lnPZnpWcR4s3aBikFXmPKS',NULL),(59,'nhkjluil122','nhkjluil122@gmail.com','2000-07-31','madagascar','fianarantsoa','2022-09-13 08:07:18','homme','$2y$10$ox2rPKR/TQd1yl9bz5U/ueg7ICIvnw7ImKYMW4mQ7GjMPzCdYK8ji',NULL),(60,'nhkjluil124','nhkjluil124@gmail.com','2001-05-12','madagascar','fianarantsoa','2022-09-13 08:08:21','homme','$2y$10$RaFOyvLjz9XPfoyxMqi9Me/DaL56.A7I97jPSe7ngstco5aCmOy.q',NULL),(61,'nhkjluil127','nhkjluil127@mail.com','2001-02-15','madagascar','fianarantsoa','2022-09-13 08:09:17','femme','$2y$10$.mJ98Ov2mZQ0NqNp3S6SQOqLPpmZ5dNGZnFLbI/NnnrEyAuZHJkCa',NULL),(62,'bfdbfgngh56','bfdbfgngh56@mail.com','5222-02-25','madagascar','fianarantsoa','2022-09-13 08:10:55','femme','$2y$10$CCtnNjxVb48f2IDpf4HSuuMihU1s2LB4Gacjv9kGsCRTSRqU9BJhu',NULL),(63,'hkyukyu12','hkyukyu12@gmail.com','2004-02-14','madagascar','fianarantsoa','2022-09-13 08:27:14','femme','$2y$10$mIFXR3n7msphRqqn7Uuflud7JfHiigrLQRH4P.sGT/3Q9UjSOBBdm',NULL),(64,'hkyukyu121','hkyukyu121@gmail.com','2000-02-04','madagascar','fianarantsoa','2022-09-13 08:28:28','femme','$2y$10$/fR6oHMeNFoR3eiLPYEBweO19WjDhPLuxsH2LxrFzy4AuVG.QmBQC',NULL),(65,'dzgfgfb1','dzgfgfb1@gmail.com','2003-03-25','madagascar','fianarantsoa','2022-09-13 08:45:42','homme','$2y$10$sQOv62JGxduUavFbeV639OXqIgPdIIR8yVeJvqfNxpsxyaENoyOae',NULL),(66,'dzgfgfb2','dzgfgfb2@gmail.com','2005-05-07','madagascar','fianarantsoa','2022-09-13 08:46:23','homme','$2y$10$GkBGeRcbTiqVfjoHvxGOdOz913tzAi0vBuljP5w07hd42FYas5pvW',NULL),(67,'fgergr23','fgergr23@gmail.com','2000-07-28','madagascar','fianarantsoa','2022-09-13 08:48:01','femme','$2y$10$Jgok5DywmysEJ0Pipe.VwOzYSZnsyEYOpdJMpKCWPzBHhqjuyX4xu',NULL),(68,'maheryRnd','maheryRnd@gmail.com','2000-04-26','madagascar','fianarantsoa','2022-09-13 18:49:56','homme','$2y$10$.gZc1LCoH1Q4u6uC8b1ph.Bw/lqvbdEcbwfhB2xhVosfh9fgPA76O',NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_images`
--

DROP TABLE IF EXISTS `user_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `path` varchar(255) NOT NULL,
  `extension` varchar(10) NOT NULL,
  `size` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `user_images_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_images`
--

LOCK TABLES `user_images` WRITE;
/*!40000 ALTER TABLE `user_images` DISABLE KEYS */;
INSERT INTO `user_images` VALUES (3,'users/mahery.jpg','jpeg',2811039,1);
/*!40000 ALTER TABLE `user_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_subject`
--

DROP TABLE IF EXISTS `user_subject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_subject` (
  `user_id` int NOT NULL,
  `subject_id` int NOT NULL,
  KEY `user_id` (`user_id`),
  KEY `subject_id` (`subject_id`),
  CONSTRAINT `user_subject_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_subject_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_subject`
--

LOCK TABLES `user_subject` WRITE;
/*!40000 ALTER TABLE `user_subject` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_subject` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-10-28 15:16:24
