-- MySQL dump 10.13  Distrib 5.7.20, for Linux (x86_64)
--
-- Host: 59.110.243.225    Database: attendance
-- ------------------------------------------------------
-- Server version	5.7.20-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `attendances`
--

DROP TABLE IF EXISTS `attendances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attendances` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '签到事件id',
  `att_token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '签到事件唯一码',
  `should` int(11) NOT NULL COMMENT '签到事件应到人数',
  `real` int(11) NOT NULL DEFAULT '0' COMMENT '签到事件实到人数',
  `class_id` int(10) unsigned NOT NULL COMMENT '签到班级id',
  `creator_id` int(10) unsigned NOT NULL COMMENT '签到事件发起者id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `attendances_class_id_foreign` (`class_id`),
  KEY `attendances_creator_id_foreign` (`creator_id`),
  CONSTRAINT `attendances_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `attendances_creator_id_foreign` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendances`
--

LOCK TABLES `attendances` WRITE;
/*!40000 ALTER TABLE `attendances` DISABLE KEYS */;
/*!40000 ALTER TABLE `attendances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `builds`
--

DROP TABLE IF EXISTS `builds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `builds` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `build_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `builds`
--

LOCK TABLES `builds` WRITE;
/*!40000 ALTER TABLE `builds` DISABLE KEYS */;
INSERT INTO `builds` VALUES (8,'励志楼A','2017-12-23 07:46:44','2017-12-23 07:46:44'),(9,'励志楼B','2017-12-24 16:56:31','2017-12-24 16:56:31'),(10,'励志楼C','2017-12-24 16:56:40','2017-12-24 16:56:40'),(11,'励志楼D','2017-12-24 16:56:52','2017-12-24 16:56:52'),(13,'厚德楼A','2017-12-24 16:58:16','2017-12-24 16:58:16'),(14,'厚德楼B','2017-12-24 16:58:28','2017-12-24 16:58:28'),(15,'厚德楼C','2017-12-24 16:58:39','2017-12-24 16:58:39'),(16,'启智楼','2017-12-24 17:00:03','2017-12-24 17:00:03');
/*!40000 ALTER TABLE `builds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `classes`
--

DROP TABLE IF EXISTS `classes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `classes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '班级id',
  `grade` int(11) NOT NULL COMMENT '年级',
  `desc` text COLLATE utf8mb4_unicode_ci COMMENT '介绍',
  `spe_id` int(10) unsigned NOT NULL COMMENT '所属系id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `class_num` int(11) NOT NULL COMMENT '班别',
  PRIMARY KEY (`id`),
  KEY `classes_spe_id_foreign` (`spe_id`),
  CONSTRAINT `classes_spe_id_foreign` FOREIGN KEY (`spe_id`) REFERENCES `specialities` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classes`
--

LOCK TABLES `classes` WRITE;
/*!40000 ALTER TABLE `classes` DISABLE KEYS */;
INSERT INTO `classes` VALUES (3,15,'无',7,'2017-12-19 06:56:04','2017-12-19 06:56:04',1),(5,15,'无',7,'2017-12-19 07:37:13','2017-12-19 07:37:13',2),(9,15,'无',8,'2017-12-19 13:13:27','2017-12-19 13:13:27',2),(10,15,'无',8,'2017-12-21 07:11:38','2017-12-21 07:11:38',1);
/*!40000 ALTER TABLE `classes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `counselors`
--

DROP TABLE IF EXISTS `counselors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `counselors` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '辅导员id',
  `user_id` int(10) unsigned NOT NULL COMMENT '关联的用户id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `counselors_user_id_index` (`user_id`),
  CONSTRAINT `counselors_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `counselors`
--

LOCK TABLES `counselors` WRITE;
/*!40000 ALTER TABLE `counselors` DISABLE KEYS */;
/*!40000 ALTER TABLE `counselors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `depar_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '院系名',
  `desc` text COLLATE utf8mb4_unicode_ci COMMENT '介绍',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departments`
--

LOCK TABLES `departments` WRITE;
/*!40000 ALTER TABLE `departments` DISABLE KEYS */;
INSERT INTO `departments` VALUES (1,'信息工程系','dasd','2017-12-17 11:20:27','2017-12-17 11:20:27'),(3,'会计系','刚被我删了，现在修改','2017-12-17 11:58:32','2017-12-17 12:51:53');
/*!40000 ALTER TABLE `departments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lessons`
--

DROP TABLE IF EXISTS `lessons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lessons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '课程id',
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '课程名称',
  `section` int(11) NOT NULL COMMENT '节次',
  `week_begin` int(11) NOT NULL COMMENT '起始周',
  `week_end` int(11) NOT NULL COMMENT '结束周',
  `weekday` int(11) NOT NULL COMMENT '周几',
  `room_id` int(10) unsigned NOT NULL COMMENT '课室id',
  `class_id` int(10) unsigned NOT NULL COMMENT '班级id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '课程状态',
  `teacher_id` int(11) DEFAULT NULL,
  `is_single` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lessons_room_id_foreign` (`room_id`),
  KEY `lessons_class_id_foreign` (`class_id`),
  CONSTRAINT `lessons_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `lessons_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lessons`
--

LOCK TABLES `lessons` WRITE;
/*!40000 ALTER TABLE `lessons` DISABLE KEYS */;
INSERT INTO `lessons` VALUES (1,'系统分析设计与UML',6,1,18,0,149,10,'2017-12-24 17:12:37','2017-12-24 17:17:39',0,NULL,0),(2,'面向对象程序设计（Java）',6,1,18,1,483,10,'2017-12-24 17:12:37','2017-12-24 17:17:39',0,NULL,0),(3,'大型数据库应用',6,1,18,2,360,10,'2017-12-24 17:12:37','2017-12-24 17:17:39',0,NULL,0),(4,'专业实习III（Web应用系统开发）',6,2,8,3,360,10,'2017-12-24 17:12:37','2017-12-24 17:17:39',0,NULL,1),(5,'数据结构',6,1,18,4,178,10,'2017-12-24 17:12:37','2017-12-24 17:17:39',0,NULL,0),(6,'大型数据库应用',8,1,18,2,360,10,'2017-12-24 17:12:37','2017-12-24 17:17:39',0,NULL,0),(7,'计算机组成原理',24,1,17,4,288,10,'2017-12-24 17:12:37','2017-12-24 17:17:39',0,NULL,1),(8,'计算机组成原理',96,1,18,0,137,10,'2017-12-24 17:12:37','2017-12-24 17:17:39',0,NULL,0),(9,'软件工程',96,1,18,1,288,10,'2017-12-24 17:12:37','2017-12-24 17:17:39',0,NULL,0),(10,'软件工程',96,1,18,2,180,10,'2017-12-24 17:12:37','2017-12-24 17:17:39',0,NULL,0),(11,'专业实习III（Web应用系统开发）',96,1,8,4,360,10,'2017-12-24 17:12:37','2017-12-24 17:17:39',0,NULL,0),(12,'系统分析设计与UML',384,1,17,0,300,10,'2017-12-24 17:12:37','2017-12-24 17:17:39',0,NULL,1),(13,'数据结构',384,1,18,3,355,10,'2017-12-24 17:12:37','2017-12-24 17:17:39',0,NULL,0),(14,'面向对象程序设计（Java）',384,1,18,4,360,10,'2017-12-24 17:12:37','2017-12-24 17:17:39',0,NULL,0),(15,'形势与政策III',1536,9,12,3,160,10,'2017-12-24 17:12:37','2017-12-24 17:17:39',0,NULL,0),(16,'形势与政策III',2048,9,12,3,160,10,'2017-12-24 17:12:37','2017-12-24 17:17:39',0,NULL,0),(17,'系统分析设计与UML',6,1,18,0,149,10,'2017-12-24 17:18:11','2017-12-24 17:18:11',1,NULL,0),(18,'面向对象程序设计（Java）',6,1,18,1,483,10,'2017-12-24 17:18:11','2017-12-24 17:18:11',1,NULL,0),(19,'大型数据库应用',6,1,18,2,360,10,'2017-12-24 17:18:11','2017-12-24 17:18:11',1,NULL,0),(20,'专业实习III（Web应用系统开发）',6,2,8,3,360,10,'2017-12-24 17:18:11','2017-12-24 17:18:11',1,NULL,1),(21,'数据结构',6,1,18,4,178,10,'2017-12-24 17:18:11','2017-12-24 17:18:11',1,NULL,0),(22,'大型数据库应用',8,1,18,2,360,10,'2017-12-24 17:18:11','2017-12-24 17:18:11',1,NULL,0),(23,'计算机组成原理',24,1,17,4,288,10,'2017-12-24 17:18:11','2017-12-24 17:18:11',1,NULL,1),(24,'计算机组成原理',96,1,18,0,137,10,'2017-12-24 17:18:11','2017-12-24 17:18:11',1,NULL,0),(25,'软件工程',96,1,18,1,288,10,'2017-12-24 17:18:11','2017-12-24 17:18:11',1,NULL,0),(26,'软件工程',96,1,18,2,180,10,'2017-12-24 17:18:11','2017-12-24 17:18:11',1,NULL,0),(27,'专业实习III（Web应用系统开发）',96,1,8,4,360,10,'2017-12-24 17:18:11','2017-12-24 17:18:11',1,NULL,0),(28,'系统分析设计与UML',384,1,17,0,300,10,'2017-12-24 17:18:11','2017-12-24 17:18:11',1,NULL,1),(29,'数据结构',384,1,18,3,355,10,'2017-12-24 17:18:11','2017-12-24 17:18:11',1,NULL,0),(30,'面向对象程序设计（Java）',384,1,18,4,360,10,'2017-12-24 17:18:11','2017-12-24 17:18:11',1,NULL,0),(31,'形势与政策III',1536,9,12,3,160,10,'2017-12-24 17:18:11','2017-12-24 17:18:11',1,NULL,0),(32,'形势与政策III',2048,9,12,3,160,10,'2017-12-24 17:18:11','2017-12-24 17:18:11',1,NULL,0);
/*!40000 ALTER TABLE `lessons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2015_01_15_105324_create_roles_table',1),(4,'2015_01_15_114412_create_role_user_table',1),(5,'2015_01_26_115212_create_permissions_table',1),(6,'2015_01_26_115523_create_permission_role_table',1),(7,'2015_02_09_132439_create_permission_user_table',1),(8,'2017_11_15_143543_create_departments_table',1),(9,'2017_11_15_143544_create_specialities_table',1),(10,'2017_11_15_143547_create_classes_table',1),(11,'2017_11_15_143851_create_students_table',1),(12,'2017_11_15_151049_create_builds_table',1),(13,'2017_11_15_151055_create_rooms_table',1),(14,'2017_11_15_152947_create_lessons_table',1),(15,'2017_11_15_153629_create_sign_ins_table',1),(16,'2017_11_15_153701_create_attendances_table',1),(17,'2017_12_19_060136_alter_classes_classname_to_class_num_table',2),(18,'2017_12_19_140513_drop_stu_name_add_user_id_table',3),(19,'2017_12_21_134651_create_teachers_table',4),(20,'2017_12_22_045545_add_col_status_on_lessons',5),(21,'2017_12_22_050408_add_col_teacher_work_num_on_lessons',6),(22,'2017_12_24_062135_alter_att_id_on_sign_ins_table',7),(23,'2017_12_24_062542_alter_in_lessons_table',7),(24,'2017_12_24_063306_add_status_in_attendances_table',7),(25,'2016_06_01_000001_create_oauth_auth_codes_table',8),(26,'2016_06_01_000002_create_oauth_access_tokens_table',8),(27,'2016_06_01_000003_create_oauth_refresh_tokens_table',8),(28,'2016_06_01_000004_create_oauth_clients_table',8),(29,'2016_06_01_000005_create_oauth_personal_access_clients_table',8),(30,'2018_01_21_010020_create_counselors_table',9),(31,'2018_01_21_011504_alter_col_students_table',10);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_access_tokens`
--

DROP TABLE IF EXISTS `oauth_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `client_id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_access_tokens`
--

LOCK TABLES `oauth_access_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_access_tokens` DISABLE KEYS */;
INSERT INTO `oauth_access_tokens` VALUES ('03415bdbd0e66a94f9ce38725bca14898e3d895a038b81573e2f38e181046efe2cde1e95d2746009',53,1,'User #53 - 123123 - 183.36.65.143','[]',0,'2017-12-26 04:23:20','2017-12-26 04:23:20','2018-12-26 12:23:20'),('08721796df7cc5764270307678e8b608bb4171766bee721878f7f0e5399cd6d26d15b0c97bfa443e',53,1,'User #53 - 123123 - 183.36.65.143','[]',0,'2017-12-25 06:29:25','2017-12-25 06:29:25','2018-12-25 14:29:25'),('10d8015318c64ba90affa268dedf02bd3c1602c645137263e1ae24d7b30f789b900737e91a0fc853',1,1,'User #1 - lotiger@lotiger.cn - 192.168.10.1','[]',0,'2017-12-25 11:53:43','2017-12-25 11:53:43','2018-12-25 11:53:43'),('28e84e22d805477d8124fe69c218e973d0baa0ca796c3a2421e509e07a41e09ada019b824022468f',53,1,'User #53 - 123123 - 183.36.65.143','[]',0,'2017-12-26 04:16:02','2017-12-26 04:16:02','2018-12-26 12:16:02'),('34fa60ea48ca5da9749334e07849b8ad29595cb9a31da0398c8fd87ba870e1454fba4bceb548d598',53,1,'User #53 - 123123 - 14.24.22.73','[]',0,'2017-12-25 06:20:15','2017-12-25 06:20:15','2018-12-25 14:20:15'),('3c608db4bbe864d81bb165b14cfc23ca741a63693b3050b347023cbe8aac9c7f5b3762b05d006ba5',53,1,'User #53 - 123123 - 183.36.65.143','[]',0,'2017-12-25 06:33:23','2017-12-25 06:33:23','2018-12-25 14:33:23'),('3f56fb572258848bf30cfca896a5953f721c287b6e834635026218becca8d00a2ec030eb20c2b609',53,1,'User #53 - 123123 - 183.36.65.143','[]',0,'2017-12-26 04:29:34','2017-12-26 04:29:34','2018-12-26 12:29:34'),('4d68310f8792040a0e390f783f53314582b3645310aae0a746483c42bf43f1ab836661c2095e8b5e',1,1,'Pizza App','[]',0,'2017-12-25 05:34:56','2017-12-25 05:34:56','2018-12-25 05:34:56'),('57ea1d246744e5e298157f8622bdcf6f8c0ac980e36fae13551fac10ddb5713c4d6b94d62b6979e8',53,1,'User #53 - 123123 - 183.36.65.143','[]',0,'2017-12-26 04:21:40','2017-12-26 04:21:40','2018-12-26 12:21:40'),('58053bdede75489088c3fc6dd11f9fd513e5f46e5e637dd30c9e64b28f9bfff1f46dcb2be6d3e8a9',53,1,'User #53 - 123123 - 14.24.22.73','[]',0,'2017-12-25 06:33:07','2017-12-25 06:33:07','2018-12-25 14:33:07'),('60d4d71ce66e9c32dc2dde814299ad06be09fe3cb2d2cbefed415bbc1b3ef6b54fade8076b425a0a',53,1,'User #53 - 123123 - 183.36.65.143','[]',0,'2017-12-26 04:21:47','2017-12-26 04:21:47','2018-12-26 12:21:47'),('6305e5af08ad6ddc153ad3a7dcd58102f1a741fe10c6dd7381a41f468488ce62bb953457855ac2c7',53,1,'User #53 - 123123 - 183.36.65.143','[]',0,'2017-12-25 06:22:52','2017-12-25 06:22:52','2018-12-25 14:22:52'),('7483d239860e5e9fb53aa151d95d22d69101f1b563e6181f2003f9ccb0088150a5daa3a1790a24ca',53,1,'User #53 - 123123 - 183.36.65.143','[]',0,'2017-12-26 04:37:43','2017-12-26 04:37:43','2018-12-26 12:37:43'),('7adf22522bf909e107c6260a363c4bacf34bd7d531dc0db4832ed525a120d70d3d233aa5143d72f2',53,1,'User #53 - 123123 - 219.72.202.129','[]',0,'2018-01-20 20:24:38','2018-01-20 20:24:38','2019-01-21 04:24:38'),('84db00dc39a6a13473a9f53bcb27f6d570fade9546246ecb34370b526b426160fa69cd74736559d3',53,1,'User #53 - 123123 - 183.36.65.143','[]',0,'2017-12-26 04:20:23','2017-12-26 04:20:23','2018-12-26 12:20:23'),('8a3bc977cb8ffd3b26c69e911ced077b4bb548ff852e58c7258b8f18a0f6807a00c32bfd448dd36c',53,1,'User #53 - 123123 - 183.36.65.143','[]',0,'2017-12-26 04:25:53','2017-12-26 04:25:53','2018-12-26 12:25:53'),('93f348048b9afd4ccb14500b070672f741177c28628fffb1464af2da13eae6b32e3bc96af7884be7',53,1,'User #53 - 123123 - 14.24.22.73','[]',0,'2017-12-26 03:48:42','2017-12-26 03:48:42','2018-12-26 11:48:42'),('9ab5265406e01085720dd8ff9fbb5cf40fb7d291e3b46972c1bdce4077dea14b0bc09f033e547d5e',53,1,'User #53 - 123123 - 183.36.65.143','[]',0,'2017-12-25 20:18:39','2017-12-25 20:18:39','2018-12-26 04:18:39'),('9c96432a9d753d59ee96ddcc84a4ee30213743c29441e96da6f954a79decf54db1d604d1a8c43108',53,1,'User #53 - 123123 - 183.36.65.143','[]',0,'2017-12-25 06:33:50','2017-12-25 06:33:50','2018-12-25 14:33:50'),('b8934f7480a31d84706ce17222eab86e4aee8fd5a41e8a43a6cfb94915e5b1dd7b26763eda14fa4f',1,1,'User #1 - lotiger@lotiger.cn - 192.168.10.1','[]',0,'2017-12-25 11:52:19','2017-12-25 11:52:19','2018-12-25 11:52:19'),('d9ff4933aef95c1dd70c60cc8f9996f5c6d02ea15dd26fa92f2bf02f96807a72dd10d4c5a3288991',53,1,'User #53 - 123123 - 219.72.202.129','[]',0,'2018-01-20 20:25:19','2018-01-20 20:25:19','2019-01-21 04:25:19'),('f471d77a771baee5d164e4bcb384216b006acc0a7306a000c2449215d0f3ba17ceb00c63c0fdba53',1,1,'User #1 - lotiger@lotiger.cn - 192.168.10.1','[]',0,'2017-12-25 11:38:58','2017-12-25 11:38:58','2018-12-25 11:38:58'),('f810d6738a728298d706dfec490bd17ae39b6e1dc8dd865f23aec9a6c0ddc061d05e290e154b3665',56,1,'User #56 - 111000 - 192.168.10.1','[]',0,'2017-12-25 11:57:24','2017-12-25 11:57:24','2018-12-25 11:57:24'),('f84c6d24abf50c83d3eb5dd6dfd3e9a64fa86e682676fba4bd7efb1cc78231921d8da2d71d1baa97',53,1,'User #53 - 123123 - 183.36.65.143','[]',0,'2017-12-26 04:30:30','2017-12-26 04:30:30','2018-12-26 12:30:30'),('fd96cb0a56bcd90e1ed522f0c6c2e27bd482476f646e0aa08f3f8609895a38c224536dbd638412b2',53,1,'User #53 - 123123 - 183.36.65.143','[]',0,'2017-12-25 06:33:13','2017-12-25 06:33:13','2018-12-25 14:33:13');
/*!40000 ALTER TABLE `oauth_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_auth_codes`
--

DROP TABLE IF EXISTS `oauth_auth_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_auth_codes`
--

LOCK TABLES `oauth_auth_codes` WRITE;
/*!40000 ALTER TABLE `oauth_auth_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_auth_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_clients`
--

DROP TABLE IF EXISTS `oauth_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_clients`
--

LOCK TABLES `oauth_clients` WRITE;
/*!40000 ALTER TABLE `oauth_clients` DISABLE KEYS */;
INSERT INTO `oauth_clients` VALUES (1,NULL,'Laravel Personal Access Client','BvagfN2bNzbREmn9pNLQEFsMH4BvCZFluiYRsAWw','http://localhost',1,0,0,'2017-12-25 05:22:03','2017-12-25 05:22:03'),(2,NULL,'Laravel Password Grant Client','ak40PwZWcfblqXcqLdZ94EJJQB9memc4y0dPhYr9','http://localhost',0,1,0,'2017-12-25 05:22:04','2017-12-25 05:22:04');
/*!40000 ALTER TABLE `oauth_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_personal_access_clients`
--

DROP TABLE IF EXISTS `oauth_personal_access_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_personal_access_clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_personal_access_clients_client_id_index` (`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_personal_access_clients`
--

LOCK TABLES `oauth_personal_access_clients` WRITE;
/*!40000 ALTER TABLE `oauth_personal_access_clients` DISABLE KEYS */;
INSERT INTO `oauth_personal_access_clients` VALUES (1,1,'2017-12-25 05:22:04','2017-12-25 05:22:04');
/*!40000 ALTER TABLE `oauth_personal_access_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_refresh_tokens`
--

DROP TABLE IF EXISTS `oauth_refresh_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_refresh_tokens`
--

LOCK TABLES `oauth_refresh_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_refresh_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_refresh_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permission_role`
--

DROP TABLE IF EXISTS `permission_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permission_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `permission_role_permission_id_index` (`permission_id`),
  KEY `permission_role_role_id_index` (`role_id`),
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=149 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission_role`
--

LOCK TABLES `permission_role` WRITE;
/*!40000 ALTER TABLE `permission_role` DISABLE KEYS */;
INSERT INTO `permission_role` VALUES (101,1,13,'2017-12-13 13:53:36','2017-12-13 13:53:36'),(121,1,1,'2017-12-13 14:29:50','2017-12-13 14:29:50'),(125,6,1,'2017-12-13 14:29:50','2017-12-13 14:29:50'),(127,8,1,'2017-12-13 14:29:50','2017-12-13 14:29:50'),(128,10,1,'2017-12-13 14:29:50','2017-12-13 14:29:50'),(130,2,1,'2017-12-13 16:41:55','2017-12-13 16:41:55'),(131,2,13,'2017-12-13 16:41:55','2017-12-13 16:41:55'),(132,4,1,'2017-12-13 16:42:01','2017-12-13 16:42:01'),(133,4,13,'2017-12-13 16:42:01','2017-12-13 16:42:01'),(134,5,1,'2017-12-13 16:42:06','2017-12-13 16:42:06'),(135,5,13,'2017-12-13 16:42:06','2017-12-13 16:42:06'),(136,11,1,'2017-12-14 08:56:27','2017-12-14 08:56:27'),(137,12,1,'2017-12-14 09:48:57','2017-12-14 09:48:57'),(138,13,1,'2017-12-17 11:16:54','2017-12-17 11:16:54'),(140,15,1,'2017-12-17 12:51:41','2017-12-17 12:51:41'),(141,16,1,'2017-12-18 11:26:28','2017-12-18 11:26:28'),(142,7,1,'2017-12-19 08:46:43','2017-12-19 08:46:43'),(143,7,13,'2017-12-19 08:46:43','2017-12-19 08:46:43'),(144,17,1,'2017-12-21 15:48:27','2017-12-21 15:48:27'),(145,18,1,'2017-12-21 15:48:55','2017-12-21 15:48:55'),(146,19,1,'2017-12-23 07:45:14','2017-12-23 07:45:14'),(147,20,1,'2017-12-23 08:43:51','2017-12-23 08:43:51'),(148,21,1,'2017-12-24 15:11:29','2017-12-24 15:11:29');
/*!40000 ALTER TABLE `permission_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permission_user`
--

DROP TABLE IF EXISTS `permission_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permission_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `permission_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `permission_user_permission_id_index` (`permission_id`),
  KEY `permission_user_user_id_index` (`user_id`),
  CONSTRAINT `permission_user_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `permission_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission_user`
--

LOCK TABLES `permission_user` WRITE;
/*!40000 ALTER TABLE `permission_user` DISABLE KEYS */;
INSERT INTO `permission_user` VALUES (2,1,1,'2017-11-27 11:46:04','2017-11-27 11:46:04');
/*!40000 ALTER TABLE `permission_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'Delete log','delete.log','删除日志123',NULL,'2017-11-27 03:21:56','2017-12-13 13:53:36'),(2,'Create users','create.users','123',NULL,'2017-12-05 14:07:43','2017-12-13 16:41:54'),(4,'删除角色','delete.role','123',NULL,'2017-12-07 11:19:37','2017-12-13 16:42:01'),(5,'添加角色','add.role','123',NULL,'2017-12-07 12:00:16','2017-12-13 16:42:06'),(6,'修改角色','edit.role','修改角色',NULL,'2017-12-07 13:30:29','2017-12-07 13:30:29'),(7,'修改操作','edit.permissions','123',NULL,'2017-12-10 12:42:42','2017-12-19 08:46:43'),(8,'添加操作','add.permissions','添加操作',NULL,'2017-12-11 11:59:37','2017-12-12 15:14:29'),(10,'删除操作','delete.permission','删除操作操作',NULL,'2017-12-11 17:21:15','2017-12-11 17:21:15'),(11,'删除用户','delete.user','删除用户',NULL,'2017-12-14 08:56:27','2017-12-14 08:56:27'),(12,'修改用户','edit.user','修改用户',NULL,'2017-12-14 09:48:57','2017-12-14 09:48:57'),(13,'新增院系','add.department','新增院系',NULL,'2017-12-17 11:16:54','2017-12-17 11:16:54'),(14,'删除院系','delete.department','删除院系',NULL,'2017-12-17 11:55:28','2017-12-17 11:55:28'),(15,'修改院系','edit.department','修改院系',NULL,'2017-12-17 12:51:41','2017-12-17 12:51:41'),(16,'删除专业','delete.speciality','删除专业',NULL,'2017-12-18 11:26:28','2017-12-18 11:26:28'),(17,'导入学生','add.students','导入学生',NULL,'2017-12-21 15:48:27','2017-12-21 15:48:27'),(18,'导入教师','add.teachers','导入教师',NULL,'2017-12-21 15:48:55','2017-12-21 15:48:55'),(19,'删除教学楼','delete.build','删除教学楼',NULL,'2017-12-23 07:45:14','2017-12-23 07:45:14'),(20,'删除课室','delete.room','删除课室',NULL,'2017-12-23 08:43:51','2017-12-23 08:43:51'),(21,'导入课程','add.lessons','导入课程',NULL,'2017-12-24 15:11:29','2017-12-24 15:11:29');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_user`
--

DROP TABLE IF EXISTS `role_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_user_role_id_index` (`role_id`),
  KEY `role_user_user_id_index` (`user_id`),
  CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_user`
--

LOCK TABLES `role_user` WRITE;
/*!40000 ALTER TABLE `role_user` DISABLE KEYS */;
INSERT INTO `role_user` VALUES (1,1,1,'2017-11-26 05:54:39','2017-11-26 05:54:39'),(62,26,53,'2017-12-21 11:49:51','2017-12-21 11:49:51'),(63,26,54,'2017-12-21 11:49:52','2017-12-21 11:49:52'),(64,26,55,'2017-12-21 11:49:52','2017-12-21 11:49:52'),(65,13,56,'2017-12-21 15:49:32','2017-12-21 15:49:32'),(66,13,57,'2017-12-21 15:49:32','2017-12-21 15:49:32'),(67,13,1,'2017-12-25 11:51:38','2017-12-25 11:51:38'),(68,26,1,'2017-12-25 11:51:38','2017-12-25 11:51:38');
/*!40000 ALTER TABLE `role_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'管理员','admin','1231',8,'2017-11-26 05:51:38','2017-12-26 04:25:35'),(13,'老师','teacher','123123123',2,'2017-12-07 15:21:36','2017-12-13 13:51:44'),(26,'学生','student','学生',0,'2017-12-13 15:47:33','2017-12-13 15:47:33');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rooms`
--

DROP TABLE IF EXISTS `rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rooms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `room_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `build_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rooms_build_id_foreign` (`build_id`),
  CONSTRAINT `rooms_build_id_foreign` FOREIGN KEY (`build_id`) REFERENCES `builds` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=542 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rooms`
--

LOCK TABLES `rooms` WRITE;
/*!40000 ALTER TABLE `rooms` DISABLE KEYS */;
INSERT INTO `rooms` VALUES (57,'101',8,'2017-12-23 07:46:44','2017-12-23 07:46:44'),(58,'102',8,'2017-12-23 07:46:44','2017-12-23 07:46:44'),(59,'103',8,'2017-12-23 07:46:44','2017-12-23 07:46:44'),(60,'104',8,'2017-12-23 07:46:44','2017-12-23 07:46:44'),(61,'105',8,'2017-12-23 07:46:44','2017-12-23 07:46:44'),(62,'106',8,'2017-12-23 07:46:44','2017-12-23 07:46:44'),(63,'107',8,'2017-12-23 07:46:44','2017-12-23 07:46:44'),(64,'108',8,'2017-12-23 07:46:44','2017-12-23 07:46:44'),(65,'201',8,'2017-12-23 07:46:44','2017-12-23 07:46:44'),(66,'202',8,'2017-12-23 07:46:44','2017-12-23 07:46:44'),(67,'203',8,'2017-12-23 07:46:44','2017-12-23 07:46:44'),(68,'204',8,'2017-12-23 07:46:44','2017-12-23 07:46:44'),(69,'205',8,'2017-12-23 07:46:44','2017-12-23 07:46:44'),(70,'206',8,'2017-12-23 07:46:44','2017-12-23 07:46:44'),(71,'207',8,'2017-12-23 07:46:44','2017-12-23 07:46:44'),(72,'208',8,'2017-12-23 07:46:44','2017-12-23 07:46:44'),(73,'301',8,'2017-12-23 07:46:44','2017-12-23 07:46:44'),(74,'302',8,'2017-12-23 07:46:44','2017-12-23 07:46:44'),(75,'303',8,'2017-12-23 07:46:44','2017-12-23 07:46:44'),(76,'304',8,'2017-12-23 07:46:44','2017-12-23 07:46:44'),(77,'305',8,'2017-12-23 07:46:44','2017-12-23 07:46:44'),(78,'306',8,'2017-12-23 07:46:44','2017-12-23 07:46:44'),(79,'307',8,'2017-12-23 07:46:44','2017-12-23 07:46:44'),(80,'308',8,'2017-12-23 07:46:44','2017-12-23 07:46:44'),(81,'401',8,'2017-12-23 07:46:44','2017-12-23 07:46:44'),(82,'402',8,'2017-12-23 07:46:44','2017-12-23 07:46:44'),(83,'403',8,'2017-12-23 07:46:44','2017-12-23 07:46:44'),(84,'404',8,'2017-12-23 07:46:44','2017-12-23 07:46:44'),(85,'405',8,'2017-12-23 07:46:44','2017-12-23 07:46:44'),(86,'406',8,'2017-12-23 07:46:44','2017-12-23 07:46:44'),(87,'407',8,'2017-12-23 07:46:44','2017-12-23 07:46:44'),(88,'408',8,'2017-12-23 07:46:44','2017-12-23 07:46:44'),(89,'501',8,'2017-12-23 07:46:44','2017-12-23 07:46:44'),(90,'502',8,'2017-12-23 07:46:44','2017-12-23 07:46:44'),(91,'503',8,'2017-12-23 07:46:44','2017-12-23 07:46:44'),(92,'504',8,'2017-12-23 07:46:44','2017-12-23 07:46:44'),(93,'505',8,'2017-12-23 07:46:44','2017-12-23 07:46:44'),(94,'506',8,'2017-12-23 07:46:44','2017-12-23 07:46:44'),(95,'507',8,'2017-12-23 07:46:44','2017-12-23 07:46:44'),(96,'508',8,'2017-12-23 07:46:44','2017-12-23 07:46:44'),(97,'101',9,'2017-12-24 16:56:31','2017-12-24 16:56:31'),(98,'102',9,'2017-12-24 16:56:31','2017-12-24 16:56:31'),(99,'103',9,'2017-12-24 16:56:31','2017-12-24 16:56:31'),(100,'104',9,'2017-12-24 16:56:31','2017-12-24 16:56:31'),(101,'105',9,'2017-12-24 16:56:31','2017-12-24 16:56:31'),(102,'106',9,'2017-12-24 16:56:31','2017-12-24 16:56:31'),(103,'107',9,'2017-12-24 16:56:31','2017-12-24 16:56:31'),(104,'108',9,'2017-12-24 16:56:31','2017-12-24 16:56:31'),(105,'201',9,'2017-12-24 16:56:31','2017-12-24 16:56:31'),(106,'202',9,'2017-12-24 16:56:31','2017-12-24 16:56:31'),(107,'203',9,'2017-12-24 16:56:31','2017-12-24 16:56:31'),(108,'204',9,'2017-12-24 16:56:31','2017-12-24 16:56:31'),(109,'205',9,'2017-12-24 16:56:31','2017-12-24 16:56:31'),(110,'206',9,'2017-12-24 16:56:31','2017-12-24 16:56:31'),(111,'207',9,'2017-12-24 16:56:31','2017-12-24 16:56:31'),(112,'208',9,'2017-12-24 16:56:31','2017-12-24 16:56:31'),(113,'301',9,'2017-12-24 16:56:31','2017-12-24 16:56:31'),(114,'302',9,'2017-12-24 16:56:31','2017-12-24 16:56:31'),(115,'303',9,'2017-12-24 16:56:31','2017-12-24 16:56:31'),(116,'304',9,'2017-12-24 16:56:31','2017-12-24 16:56:31'),(117,'305',9,'2017-12-24 16:56:31','2017-12-24 16:56:31'),(118,'306',9,'2017-12-24 16:56:31','2017-12-24 16:56:31'),(119,'307',9,'2017-12-24 16:56:31','2017-12-24 16:56:31'),(120,'308',9,'2017-12-24 16:56:31','2017-12-24 16:56:31'),(121,'401',9,'2017-12-24 16:56:31','2017-12-24 16:56:31'),(122,'402',9,'2017-12-24 16:56:31','2017-12-24 16:56:31'),(123,'403',9,'2017-12-24 16:56:31','2017-12-24 16:56:31'),(124,'404',9,'2017-12-24 16:56:31','2017-12-24 16:56:31'),(125,'405',9,'2017-12-24 16:56:31','2017-12-24 16:56:31'),(126,'406',9,'2017-12-24 16:56:31','2017-12-24 16:56:31'),(127,'407',9,'2017-12-24 16:56:31','2017-12-24 16:56:31'),(128,'408',9,'2017-12-24 16:56:31','2017-12-24 16:56:31'),(129,'501',9,'2017-12-24 16:56:31','2017-12-24 16:56:31'),(130,'502',9,'2017-12-24 16:56:31','2017-12-24 16:56:31'),(131,'503',9,'2017-12-24 16:56:31','2017-12-24 16:56:31'),(132,'504',9,'2017-12-24 16:56:31','2017-12-24 16:56:31'),(133,'505',9,'2017-12-24 16:56:31','2017-12-24 16:56:31'),(134,'506',9,'2017-12-24 16:56:31','2017-12-24 16:56:31'),(135,'507',9,'2017-12-24 16:56:31','2017-12-24 16:56:31'),(136,'508',9,'2017-12-24 16:56:31','2017-12-24 16:56:31'),(137,'101',10,'2017-12-24 16:56:40','2017-12-24 16:56:40'),(138,'102',10,'2017-12-24 16:56:40','2017-12-24 16:56:40'),(139,'103',10,'2017-12-24 16:56:40','2017-12-24 16:56:40'),(140,'104',10,'2017-12-24 16:56:40','2017-12-24 16:56:40'),(141,'105',10,'2017-12-24 16:56:40','2017-12-24 16:56:40'),(142,'106',10,'2017-12-24 16:56:40','2017-12-24 16:56:40'),(143,'107',10,'2017-12-24 16:56:40','2017-12-24 16:56:40'),(144,'108',10,'2017-12-24 16:56:40','2017-12-24 16:56:40'),(145,'201',10,'2017-12-24 16:56:40','2017-12-24 16:56:40'),(146,'202',10,'2017-12-24 16:56:40','2017-12-24 16:56:40'),(147,'203',10,'2017-12-24 16:56:40','2017-12-24 16:56:40'),(148,'204',10,'2017-12-24 16:56:40','2017-12-24 16:56:40'),(149,'205',10,'2017-12-24 16:56:40','2017-12-24 16:56:40'),(150,'206',10,'2017-12-24 16:56:40','2017-12-24 16:56:40'),(151,'207',10,'2017-12-24 16:56:40','2017-12-24 16:56:40'),(152,'208',10,'2017-12-24 16:56:40','2017-12-24 16:56:40'),(153,'301',10,'2017-12-24 16:56:40','2017-12-24 16:56:40'),(154,'302',10,'2017-12-24 16:56:40','2017-12-24 16:56:40'),(155,'303',10,'2017-12-24 16:56:40','2017-12-24 16:56:40'),(156,'304',10,'2017-12-24 16:56:40','2017-12-24 16:56:40'),(157,'305',10,'2017-12-24 16:56:40','2017-12-24 16:56:40'),(158,'306',10,'2017-12-24 16:56:40','2017-12-24 16:56:40'),(159,'307',10,'2017-12-24 16:56:40','2017-12-24 16:56:40'),(160,'308',10,'2017-12-24 16:56:40','2017-12-24 16:56:40'),(161,'401',10,'2017-12-24 16:56:40','2017-12-24 16:56:40'),(162,'402',10,'2017-12-24 16:56:40','2017-12-24 16:56:40'),(163,'403',10,'2017-12-24 16:56:40','2017-12-24 16:56:40'),(164,'404',10,'2017-12-24 16:56:40','2017-12-24 16:56:40'),(165,'405',10,'2017-12-24 16:56:40','2017-12-24 16:56:40'),(166,'406',10,'2017-12-24 16:56:40','2017-12-24 16:56:40'),(167,'407',10,'2017-12-24 16:56:40','2017-12-24 16:56:40'),(168,'408',10,'2017-12-24 16:56:40','2017-12-24 16:56:40'),(169,'501',10,'2017-12-24 16:56:40','2017-12-24 16:56:40'),(170,'502',10,'2017-12-24 16:56:40','2017-12-24 16:56:40'),(171,'503',10,'2017-12-24 16:56:40','2017-12-24 16:56:40'),(172,'504',10,'2017-12-24 16:56:40','2017-12-24 16:56:40'),(173,'505',10,'2017-12-24 16:56:40','2017-12-24 16:56:40'),(174,'506',10,'2017-12-24 16:56:40','2017-12-24 16:56:40'),(175,'507',10,'2017-12-24 16:56:40','2017-12-24 16:56:40'),(176,'508',10,'2017-12-24 16:56:40','2017-12-24 16:56:40'),(177,'101',11,'2017-12-24 16:56:52','2017-12-24 16:56:52'),(178,'102',11,'2017-12-24 16:56:52','2017-12-24 16:56:52'),(179,'103',11,'2017-12-24 16:56:52','2017-12-24 16:56:52'),(180,'104',11,'2017-12-24 16:56:52','2017-12-24 16:56:52'),(181,'105',11,'2017-12-24 16:56:52','2017-12-24 16:56:52'),(182,'106',11,'2017-12-24 16:56:52','2017-12-24 16:56:52'),(183,'107',11,'2017-12-24 16:56:52','2017-12-24 16:56:52'),(184,'108',11,'2017-12-24 16:56:52','2017-12-24 16:56:52'),(185,'201',11,'2017-12-24 16:56:52','2017-12-24 16:56:52'),(186,'202',11,'2017-12-24 16:56:52','2017-12-24 16:56:52'),(187,'203',11,'2017-12-24 16:56:52','2017-12-24 16:56:52'),(188,'204',11,'2017-12-24 16:56:52','2017-12-24 16:56:52'),(189,'205',11,'2017-12-24 16:56:53','2017-12-24 16:56:53'),(190,'206',11,'2017-12-24 16:56:53','2017-12-24 16:56:53'),(191,'207',11,'2017-12-24 16:56:53','2017-12-24 16:56:53'),(192,'208',11,'2017-12-24 16:56:53','2017-12-24 16:56:53'),(193,'301',11,'2017-12-24 16:56:53','2017-12-24 16:56:53'),(194,'302',11,'2017-12-24 16:56:53','2017-12-24 16:56:53'),(195,'303',11,'2017-12-24 16:56:53','2017-12-24 16:56:53'),(196,'304',11,'2017-12-24 16:56:53','2017-12-24 16:56:53'),(197,'305',11,'2017-12-24 16:56:53','2017-12-24 16:56:53'),(198,'306',11,'2017-12-24 16:56:53','2017-12-24 16:56:53'),(199,'307',11,'2017-12-24 16:56:53','2017-12-24 16:56:53'),(200,'308',11,'2017-12-24 16:56:53','2017-12-24 16:56:53'),(201,'401',11,'2017-12-24 16:56:53','2017-12-24 16:56:53'),(202,'402',11,'2017-12-24 16:56:53','2017-12-24 16:56:53'),(203,'403',11,'2017-12-24 16:56:53','2017-12-24 16:56:53'),(204,'404',11,'2017-12-24 16:56:53','2017-12-24 16:56:53'),(205,'405',11,'2017-12-24 16:56:53','2017-12-24 16:56:53'),(206,'406',11,'2017-12-24 16:56:53','2017-12-24 16:56:53'),(207,'407',11,'2017-12-24 16:56:53','2017-12-24 16:56:53'),(208,'408',11,'2017-12-24 16:56:53','2017-12-24 16:56:53'),(209,'501',11,'2017-12-24 16:56:53','2017-12-24 16:56:53'),(210,'502',11,'2017-12-24 16:56:53','2017-12-24 16:56:53'),(211,'503',11,'2017-12-24 16:56:53','2017-12-24 16:56:53'),(212,'504',11,'2017-12-24 16:56:53','2017-12-24 16:56:53'),(213,'505',11,'2017-12-24 16:56:53','2017-12-24 16:56:53'),(214,'506',11,'2017-12-24 16:56:53','2017-12-24 16:56:53'),(215,'507',11,'2017-12-24 16:56:53','2017-12-24 16:56:53'),(216,'508',11,'2017-12-24 16:56:53','2017-12-24 16:56:53'),(272,'101',13,'2017-12-24 16:58:16','2017-12-24 16:58:16'),(273,'102',13,'2017-12-24 16:58:16','2017-12-24 16:58:16'),(274,'103',13,'2017-12-24 16:58:16','2017-12-24 16:58:16'),(275,'104',13,'2017-12-24 16:58:16','2017-12-24 16:58:16'),(276,'105',13,'2017-12-24 16:58:16','2017-12-24 16:58:16'),(277,'106',13,'2017-12-24 16:58:16','2017-12-24 16:58:16'),(278,'107',13,'2017-12-24 16:58:16','2017-12-24 16:58:16'),(279,'108',13,'2017-12-24 16:58:16','2017-12-24 16:58:16'),(280,'109',13,'2017-12-24 16:58:16','2017-12-24 16:58:16'),(281,'110',13,'2017-12-24 16:58:16','2017-12-24 16:58:16'),(282,'111',13,'2017-12-24 16:58:16','2017-12-24 16:58:16'),(283,'112',13,'2017-12-24 16:58:16','2017-12-24 16:58:16'),(284,'113',13,'2017-12-24 16:58:16','2017-12-24 16:58:16'),(285,'201',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(286,'202',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(287,'203',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(288,'204',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(289,'205',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(290,'206',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(291,'207',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(292,'208',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(293,'209',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(294,'210',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(295,'211',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(296,'212',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(297,'213',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(298,'301',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(299,'302',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(300,'303',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(301,'304',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(302,'305',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(303,'306',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(304,'307',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(305,'308',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(306,'309',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(307,'310',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(308,'311',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(309,'312',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(310,'313',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(311,'401',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(312,'402',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(313,'403',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(314,'404',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(315,'405',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(316,'406',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(317,'407',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(318,'408',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(319,'409',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(320,'410',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(321,'411',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(322,'412',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(323,'413',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(324,'501',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(325,'502',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(326,'503',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(327,'504',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(328,'505',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(329,'506',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(330,'507',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(331,'508',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(332,'509',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(333,'510',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(334,'511',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(335,'512',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(336,'513',13,'2017-12-24 16:58:17','2017-12-24 16:58:17'),(337,'101',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(338,'102',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(339,'103',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(340,'104',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(341,'105',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(342,'106',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(343,'107',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(344,'108',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(345,'109',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(346,'110',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(347,'111',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(348,'112',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(349,'113',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(350,'201',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(351,'202',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(352,'203',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(353,'204',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(354,'205',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(355,'206',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(356,'207',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(357,'208',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(358,'209',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(359,'210',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(360,'211',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(361,'212',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(362,'213',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(363,'301',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(364,'302',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(365,'303',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(366,'304',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(367,'305',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(368,'306',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(369,'307',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(370,'308',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(371,'309',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(372,'310',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(373,'311',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(374,'312',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(375,'313',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(376,'401',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(377,'402',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(378,'403',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(379,'404',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(380,'405',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(381,'406',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(382,'407',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(383,'408',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(384,'409',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(385,'410',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(386,'411',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(387,'412',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(388,'413',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(389,'501',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(390,'502',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(391,'503',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(392,'504',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(393,'505',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(394,'506',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(395,'507',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(396,'508',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(397,'509',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(398,'510',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(399,'511',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(400,'512',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(401,'513',14,'2017-12-24 16:58:28','2017-12-24 16:58:28'),(402,'101',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(403,'102',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(404,'103',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(405,'104',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(406,'105',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(407,'106',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(408,'107',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(409,'108',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(410,'109',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(411,'110',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(412,'111',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(413,'112',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(414,'113',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(415,'201',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(416,'202',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(417,'203',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(418,'204',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(419,'205',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(420,'206',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(421,'207',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(422,'208',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(423,'209',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(424,'210',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(425,'211',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(426,'212',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(427,'213',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(428,'301',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(429,'302',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(430,'303',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(431,'304',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(432,'305',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(433,'306',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(434,'307',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(435,'308',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(436,'309',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(437,'310',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(438,'311',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(439,'312',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(440,'313',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(441,'401',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(442,'402',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(443,'403',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(444,'404',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(445,'405',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(446,'406',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(447,'407',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(448,'408',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(449,'409',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(450,'410',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(451,'411',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(452,'412',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(453,'413',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(454,'501',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(455,'502',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(456,'503',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(457,'504',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(458,'505',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(459,'506',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(460,'507',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(461,'508',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(462,'509',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(463,'510',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(464,'511',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(465,'512',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(466,'513',15,'2017-12-24 16:58:39','2017-12-24 16:58:39'),(467,'101',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(468,'102',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(469,'103',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(470,'104',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(471,'105',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(472,'106',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(473,'107',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(474,'108',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(475,'109',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(476,'110',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(477,'111',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(478,'112',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(479,'113',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(480,'114',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(481,'115',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(482,'201',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(483,'202',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(484,'203',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(485,'204',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(486,'205',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(487,'206',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(488,'207',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(489,'208',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(490,'209',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(491,'210',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(492,'211',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(493,'212',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(494,'213',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(495,'214',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(496,'215',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(497,'301',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(498,'302',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(499,'303',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(500,'304',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(501,'305',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(502,'306',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(503,'307',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(504,'308',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(505,'309',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(506,'310',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(507,'311',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(508,'312',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(509,'313',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(510,'314',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(511,'315',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(512,'401',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(513,'402',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(514,'403',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(515,'404',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(516,'405',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(517,'406',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(518,'407',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(519,'408',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(520,'409',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(521,'410',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(522,'411',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(523,'412',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(524,'413',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(525,'414',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(526,'415',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(527,'501',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(528,'502',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(529,'503',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(530,'504',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(531,'505',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(532,'506',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(533,'507',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(534,'508',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(535,'509',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(536,'510',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(537,'511',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(538,'512',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(539,'513',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(540,'514',16,'2017-12-24 17:00:03','2017-12-24 17:00:03'),(541,'515',16,'2017-12-24 17:00:03','2017-12-24 17:00:03');
/*!40000 ALTER TABLE `rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sign_ins`
--

DROP TABLE IF EXISTS `sign_ins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sign_ins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '签到id',
  `stu_id` int(10) unsigned NOT NULL COMMENT '签到学生',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `att_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sign_ins_stu_id_index` (`stu_id`),
  KEY `sign_ins_att_id_foreign` (`att_id`),
  CONSTRAINT `sign_ins_att_id_foreign` FOREIGN KEY (`att_id`) REFERENCES `attendances` (`id`) ON DELETE CASCADE,
  CONSTRAINT `sign_ins_stu_id_foreign` FOREIGN KEY (`stu_id`) REFERENCES `students` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sign_ins`
--

LOCK TABLES `sign_ins` WRITE;
/*!40000 ALTER TABLE `sign_ins` DISABLE KEYS */;
/*!40000 ALTER TABLE `sign_ins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `specialities`
--

DROP TABLE IF EXISTS `specialities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `specialities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '专业id',
  `spe_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '专业名',
  `desc` text COLLATE utf8mb4_unicode_ci COMMENT '介绍',
  `depar_id` int(10) unsigned NOT NULL COMMENT '所属院系id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `specialities_depar_id_foreign` (`depar_id`),
  CONSTRAINT `specialities_depar_id_foreign` FOREIGN KEY (`depar_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `specialities`
--

LOCK TABLES `specialities` WRITE;
/*!40000 ALTER TABLE `specialities` DISABLE KEYS */;
INSERT INTO `specialities` VALUES (6,'信息与管理','测试',1,'2017-12-18 11:28:47','2017-12-18 11:28:47'),(7,'电子商务','电子商务',1,'2017-12-19 05:35:02','2017-12-19 05:35:02'),(8,'计算机科学与技术','123',1,'2017-12-19 08:23:49','2017-12-19 08:23:49');
/*!40000 ALTER TABLE `specialities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `students` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '学生id',
  `class_id` int(10) unsigned NOT NULL COMMENT '所属班id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(10) unsigned NOT NULL COMMENT '关联的用户id',
  `sign_num` int(11) NOT NULL DEFAULT '0' COMMENT '签到次数',
  `att_num` int(11) NOT NULL DEFAULT '0' COMMENT '接受的考勤次数',
  PRIMARY KEY (`id`),
  KEY `students_class_id_foreign` (`class_id`),
  KEY `students_user_id_index` (`user_id`),
  CONSTRAINT `students_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `students_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES (1,10,'2017-12-21 11:49:51','2017-12-21 11:49:51',53,0,0),(2,10,'2017-12-21 11:49:52','2017-12-21 11:49:52',54,0,0),(3,10,'2017-12-21 11:49:52','2017-12-21 11:49:52',55,0,0);
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teachers`
--

DROP TABLE IF EXISTS `teachers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teachers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `spe_id` int(10) unsigned NOT NULL COMMENT '关联专业id',
  `user_id` int(10) unsigned NOT NULL COMMENT '关联的用户id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `teachers_spe_id_index` (`spe_id`),
  KEY `teachers_user_id_index` (`user_id`),
  CONSTRAINT `teachers_spe_id_foreign` FOREIGN KEY (`spe_id`) REFERENCES `specialities` (`id`) ON DELETE CASCADE,
  CONSTRAINT `teachers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teachers`
--

LOCK TABLES `teachers` WRITE;
/*!40000 ALTER TABLE `teachers` DISABLE KEYS */;
INSERT INTO `teachers` VALUES (1,6,56,'2017-12-21 15:49:32','2017-12-21 15:49:32'),(2,6,57,'2017-12-21 15:49:32','2017-12-21 15:49:32');
/*!40000 ALTER TABLE `teachers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Miss Myrtie Barton','lotiger@lotiger.cn','$2y$10$aH9ebmLFmJcGnKtnxT7jg.TLufE3DprkiCRt.E5AeXkbIwIzTEmn.','RELQ63RpU3jxw76jQx5dEKTcoyXh4v3vZjfXV4EsyZ8YxtH8QrnVx2uxpVjI','2017-11-26 05:40:38','2017-11-26 05:40:38'),(53,'小李','123123','$2y$10$TzIqtGzIpBmmRCSa7.GWSegzAvk9/7SI7XlpwnxbgLZJnlRx03eAS',NULL,'2017-12-21 11:49:51','2017-12-21 11:49:51'),(54,'小明','123124','$2y$10$qdtjXcrq8aCGQvXDSIoWrunxxpHnmTrh7SlR9iSZfxPaMW4zgSuBy',NULL,'2017-12-21 11:49:52','2017-12-21 11:49:52'),(55,'小花','123125','$2y$10$pRWjXldoR4yczCaQDzmbh.Y9qget79R9L1mubMR.0eMroug9hAs9y',NULL,'2017-12-21 11:49:52','2017-12-21 11:49:52'),(56,'李老师','111000','$2y$10$hKoSWchqQlZfmVGAtu2Tceg7YoGiYzvvfwo6K/HYvwJ.4HiJexqBe',NULL,'2017-12-21 15:49:32','2017-12-21 15:49:32'),(57,'王老师','111001','$2y$10$RaSwRRw53ELtv2nbX6n1JecXVYpfoEIEbS3.D5fSWMcIkSkQg8HEa',NULL,'2017-12-21 15:49:32','2017-12-21 15:49:32');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'attendance'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-01-21 13:01:57
