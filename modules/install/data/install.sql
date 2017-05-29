-- MySQL dump 10.13  Distrib 5.6.17, for Win32 (x86)
--
-- Host: localhost    Database: lion_test
-- ------------------------------------------------------
-- Server version	5.6.17

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
-- Table structure for table `album`
--

DROP TABLE IF EXISTS `album`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `album` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `thumb` int(11) DEFAULT NULL,
  `intro` text COLLATE utf8_unicode_ci,
  `sort` int(11) DEFAULT NULL,
  `view_all` int(11) DEFAULT '0',
  `com_all` int(11) DEFAULT '0',
  `photo_num` int(11) DEFAULT '0',
  `recommend` smallint(6) DEFAULT '0',
  `created_by` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `album`
--

LOCK TABLES `album` WRITE;
/*!40000 ALTER TABLE `album` DISABLE KEYS */;
/*!40000 ALTER TABLE `album` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `album_2`
--

DROP TABLE IF EXISTS `album_2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `album_2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `thumb` int(11) DEFAULT NULL,
  `intro` text COLLATE utf8_unicode_ci,
  `sort` int(11) DEFAULT NULL,
  `view_all` int(11) DEFAULT '0',
  `com_all` int(11) DEFAULT '0',
  `photo_num` int(11) DEFAULT '0',
  `recommend` smallint(6) DEFAULT '0',
  `created_by` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `album_2`
--

LOCK TABLES `album_2` WRITE;
/*!40000 ALTER TABLE `album_2` DISABLE KEYS */;
/*!40000 ALTER TABLE `album_2` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `album_image`
--

DROP TABLE IF EXISTS `album_image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `album_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `album_id` int(11) DEFAULT NULL,
  `mod` int(11) DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `view_all` int(11) DEFAULT '0',
  `com_all` int(11) DEFAULT '0',
  `desc` text COLLATE utf8_unicode_ci,
  `ext` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `album_image`
--

LOCK TABLES `album_image` WRITE;
/*!40000 ALTER TABLE `album_image` DISABLE KEYS */;
/*!40000 ALTER TABLE `album_image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `area`
--

DROP TABLE IF EXISTS `area`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `area` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(255) NOT NULL,
  `level` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `pid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `list` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `upid` (`pid`,`list`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='常用地区表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `area`
--

LOCK TABLES `area` WRITE;
/*!40000 ALTER TABLE `area` DISABLE KEYS */;
/*!40000 ALTER TABLE `area` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attachment`
--

DROP TABLE IF EXISTS `attachment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attachment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `desc` text COLLATE utf8_unicode_ci,
  `ext` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attachment`
--

LOCK TABLES `attachment` WRITE;
/*!40000 ALTER TABLE `attachment` DISABLE KEYS */;
/*!40000 ALTER TABLE `attachment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attachment_rel`
--

DROP TABLE IF EXISTS `attachment_rel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attachment_rel` (
  `res_id` int(11) DEFAULT NULL,
  `res_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `attach_id` int(11) DEFAULT NULL,
  `use` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  KEY `attach_id` (`attach_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attachment_rel`
--

LOCK TABLES `attachment_rel` WRITE;
/*!40000 ALTER TABLE `attachment_rel` DISABLE KEYS */;
/*!40000 ALTER TABLE `attachment_rel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_assignment`
--

DROP TABLE IF EXISTS `auth_assignment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_assignment`
--

LOCK TABLES `auth_assignment` WRITE;
/*!40000 ALTER TABLE `auth_assignment` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_assignment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item`
--

DROP TABLE IF EXISTS `auth_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `real_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_menu` smallint(1) DEFAULT '0',
  `level` int(11) DEFAULT NULL,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item`
--

LOCK TABLES `auth_item` WRITE;
/*!40000 ALTER TABLE `auth_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item_child`
--

DROP TABLE IF EXISTS `auth_item_child`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item_child`
--

LOCK TABLES `auth_item_child` WRITE;
/*!40000 ALTER TABLE `auth_item_child` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_item_child` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_rule`
--

DROP TABLE IF EXISTS `auth_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_rule`
--

LOCK TABLES `auth_rule` WRITE;
/*!40000 ALTER TABLE `auth_rule` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog`
--

DROP TABLE IF EXISTS `blog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `summary` text COLLATE utf8_unicode_ci,
  `thumb` int(11) DEFAULT NULL,
  `video` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `body` text COLLATE utf8_unicode_ci,
  `sort` int(11) DEFAULT NULL,
  `recommend` smallint(6) DEFAULT '0',
  `is_customer` smallint(6) DEFAULT '0',
  `is_top` smallint(6) DEFAULT '0',
  `type` smallint(6) DEFAULT '1',
  `memorial_id` int(11) DEFAULT '0',
  `privacy` smallint(6) DEFAULT '1',
  `view_all` int(11) DEFAULT '0',
  `com_all` int(11) DEFAULT '0',
  `publish_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `ip` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog`
--

LOCK TABLES `blog` WRITE;
/*!40000 ALTER TABLE `blog` DISABLE KEYS */;
/*!40000 ALTER TABLE `blog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog_album`
--

DROP TABLE IF EXISTS `blog_album`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog_album` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `summary` text COLLATE utf8_unicode_ci,
  `thumb` int(11) DEFAULT NULL,
  `body` text COLLATE utf8_unicode_ci,
  `sort` int(11) DEFAULT NULL,
  `recommend` smallint(6) DEFAULT '0',
  `is_customer` smallint(6) DEFAULT '0',
  `is_top` smallint(6) DEFAULT '0',
  `memorial_id` int(11) DEFAULT '0',
  `privacy` smallint(6) DEFAULT '1',
  `view_all` int(11) DEFAULT '0',
  `com_all` int(11) DEFAULT '0',
  `num` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `ip` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_album`
--

LOCK TABLES `blog_album` WRITE;
/*!40000 ALTER TABLE `blog_album` DISABLE KEYS */;
/*!40000 ALTER TABLE `blog_album` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog_album_photo`
--

DROP TABLE IF EXISTS `blog_album_photo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog_album_photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `album_id` int(11) DEFAULT NULL,
  `title` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `path` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `view_all` int(11) DEFAULT '0',
  `com_all` int(11) DEFAULT '0',
  `body` text COLLATE utf8_unicode_ci,
  `ext` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ip` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `privacy` smallint(6) DEFAULT '1',
  `created_by` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_album_photo`
--

LOCK TABLES `blog_album_photo` WRITE;
/*!40000 ALTER TABLE `blog_album_photo` DISABLE KEYS */;
/*!40000 ALTER TABLE `blog_album_photo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `client`
--

DROP TABLE IF EXISTS `client`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(128) NOT NULL COMMENT '客户名称',
  `gender` tinyint(4) DEFAULT '1',
  `age` tinyint(4) DEFAULT NULL,
  `user_id` int(11) DEFAULT '0' COMMENT '账号id',
  `telephone` varchar(128) DEFAULT NULL COMMENT '家庭电话',
  `mobile` varchar(128) DEFAULT '' COMMENT '手机号',
  `email` varchar(200) DEFAULT NULL,
  `qq` varchar(128) DEFAULT '',
  `wechat` varchar(128) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT '',
  `province_id` int(11) DEFAULT '0',
  `city_id` int(11) DEFAULT '0',
  `zone_id` int(11) DEFAULT '0',
  `address` text COMMENT '详细地址',
  `note` text COMMENT '备注',
  `guide_id` int(11) DEFAULT '0' COMMENT '导购员ID',
  `come_from` tinyint(4) DEFAULT NULL COMMENT '客户来源',
  `agent_id` int(11) DEFAULT '0' COMMENT '最终业值ID',
  `status` tinyint(4) DEFAULT '1' COMMENT '1 正常 0 删除',
  `created_by` int(11) DEFAULT '0',
  `created_at` int(11) NOT NULL COMMENT '添加时间',
  `updated_at` int(11) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='预约表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client`
--

LOCK TABLES `client` WRITE;
/*!40000 ALTER TABLE `client` DISABLE KEYS */;
/*!40000 ALTER TABLE `client` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `client_deal`
--

DROP TABLE IF EXISTS `client_deal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `client_deal` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL DEFAULT '0',
  `guide_id` int(11) NOT NULL DEFAULT '0',
  `agent_id` int(11) NOT NULL DEFAULT '0',
  `recep_id` int(11) NOT NULL DEFAULT '0',
  `res_name` varchar(200) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `res_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(200) DEFAULT '',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '成交时间',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态 1-正常成交, 2感兴趣 -1-删除 ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client_deal`
--

LOCK TABLES `client_deal` WRITE;
/*!40000 ALTER TABLE `client_deal` DISABLE KEYS */;
/*!40000 ALTER TABLE `client_deal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `client_reception`
--

DROP TABLE IF EXISTS `client_reception`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `client_reception` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `client_id` int(11) NOT NULL DEFAULT '0' COMMENT '客户信息ID',
  `guide_id` int(11) DEFAULT '0' COMMENT '导购员id',
  `agent_id` int(11) DEFAULT '0',
  `car_number` varchar(128) DEFAULT NULL,
  `person_num` int(11) DEFAULT '1',
  `start` datetime DEFAULT NULL COMMENT '开始时间',
  `end` datetime DEFAULT NULL COMMENT '结束时间',
  `un_reason` tinyint(4) DEFAULT '113',
  `is_success` tinyint(4) DEFAULT '0',
  `note` text COMMENT '备注',
  `type` tinyint(4) NOT NULL COMMENT '联系类型',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0 删除',
  `created_at` int(11) DEFAULT NULL COMMENT '录入时间',
  `updated_at` int(11) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `idx_gid` (`guide_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='接待记录表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client_reception`
--

LOCK TABLES `client_reception` WRITE;
/*!40000 ALTER TABLE `client_reception` DISABLE KEYS */;
/*!40000 ALTER TABLE `client_reception` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_category`
--

DROP TABLE IF EXISTS `cms_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) DEFAULT NULL,
  `mid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `level` smallint(6) NOT NULL DEFAULT '1',
  `code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `thumb` int(11) DEFAULT NULL,
  `body` text COLLATE utf8_unicode_ci,
  `sort` smallint(6) NOT NULL DEFAULT '0',
  `is_leaf` smallint(1) DEFAULT '1',
  `seo_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seo_keywords` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seo_description` text COLLATE utf8_unicode_ci,
  `created_at` int(11) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_category`
--

LOCK TABLES `cms_category` WRITE;
/*!40000 ALTER TABLE `cms_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `cms_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_nav`
--

DROP TABLE IF EXISTS `cms_nav`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_nav` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `keywords` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `show` smallint(6) DEFAULT '1',
  `sort` smallint(6) DEFAULT '0',
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_nav`
--

LOCK TABLES `cms_nav` WRITE;
/*!40000 ALTER TABLE `cms_nav` DISABLE KEYS */;
/*!40000 ALTER TABLE `cms_nav` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from` int(11) DEFAULT NULL,
  `to` int(11) DEFAULT NULL,
  `res_name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `res_id` int(11) DEFAULT NULL,
  `pid` int(11) DEFAULT '0',
  `content` text COLLATE utf8_unicode_ci,
  `privacy` smallint(1) DEFAULT '0',
  `status` smallint(1) DEFAULT '1',
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment`
--

LOCK TABLES `comment` WRITE;
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact`
--

DROP TABLE IF EXISTS `contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `ip` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `intro` text COLLATE utf8_unicode_ci,
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact`
--

LOCK TABLES `contact` WRITE;
/*!40000 ALTER TABLE `contact` DISABLE KEYS */;
/*!40000 ALTER TABLE `contact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `email_receive`
--

DROP TABLE IF EXISTS `email_receive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `email_receive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `msg` text COLLATE utf8_unicode_ci,
  `status` smallint(6) DEFAULT '1',
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `email_receive`
--

LOCK TABLES `email_receive` WRITE;
/*!40000 ALTER TABLE `email_receive` DISABLE KEYS */;
/*!40000 ALTER TABLE `email_receive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `email_send`
--

DROP TABLE IF EXISTS `email_send`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `email_send` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_user` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `from_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `msg` text COLLATE utf8_unicode_ci,
  `time` datetime DEFAULT NULL,
  `status` smallint(6) DEFAULT '1',
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `email_send`
--

LOCK TABLES `email_send` WRITE;
/*!40000 ALTER TABLE `email_send` DISABLE KEYS */;
/*!40000 ALTER TABLE `email_send` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `favor`
--

DROP TABLE IF EXISTS `favor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `favor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `res_name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `res_id` int(11) DEFAULT NULL,
  `title` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `res_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `favor`
--

LOCK TABLES `favor` WRITE;
/*!40000 ALTER TABLE `favor` DISABLE KEYS */;
/*!40000 ALTER TABLE `favor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `focus`
--

DROP TABLE IF EXISTS `focus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `focus` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `intro` text,
  `image` varchar(512) NOT NULL DEFAULT '',
  `category_id` int(10) NOT NULL,
  `sort` int(11) DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `focus`
--

LOCK TABLES `focus` WRITE;
/*!40000 ALTER TABLE `focus` DISABLE KEYS */;
/*!40000 ALTER TABLE `focus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `focus_category`
--

DROP TABLE IF EXISTS `focus_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `focus_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL COMMENT '标题',
  `thumb` varchar(255) DEFAULT NULL,
  `intro` text NOT NULL COMMENT '描述',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `focus_category`
--

LOCK TABLES `focus_category` WRITE;
/*!40000 ALTER TABLE `focus_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `focus_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grave`
--

DROP TABLE IF EXISTS `grave`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grave` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) DEFAULT '0',
  `level` smallint(6) NOT NULL DEFAULT '1',
  `code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `thumb` int(11) DEFAULT NULL,
  `intro` text COLLATE utf8_unicode_ci,
  `area_totle` float DEFAULT NULL,
  `area_use` float DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT '2',
  `user_id` int(11) DEFAULT NULL,
  `sort` smallint(6) NOT NULL DEFAULT '0',
  `is_leaf` smallint(6) NOT NULL DEFAULT '1',
  `is_show` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否在门户和手机显示',
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grave`
--

LOCK TABLES `grave` WRITE;
/*!40000 ALTER TABLE `grave` DISABLE KEYS */;
/*!40000 ALTER TABLE `grave` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grave_address`
--

DROP TABLE IF EXISTS `grave_address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grave_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `res_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `res_id` int(11) DEFAULT NULL,
  `province_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `zone_id` int(11) DEFAULT NULL,
  `address` text COLLATE utf8_unicode_ci,
  `postcode` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `status` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grave_address`
--

LOCK TABLES `grave_address` WRITE;
/*!40000 ALTER TABLE `grave_address` DISABLE KEYS */;
/*!40000 ALTER TABLE `grave_address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grave_bury`
--

DROP TABLE IF EXISTS `grave_bury`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grave_bury` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tomb_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `dead_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dead_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dead_num` smallint(6) NOT NULL,
  `bury_type` smallint(6) DEFAULT NULL,
  `pre_bury_date` datetime DEFAULT NULL,
  `bury_date` datetime DEFAULT NULL,
  `bury_time` time DEFAULT NULL,
  `bury_user` int(11) DEFAULT NULL,
  `bury_order` smallint(6) DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `status` smallint(6) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grave_bury`
--

LOCK TABLES `grave_bury` WRITE;
/*!40000 ALTER TABLE `grave_bury` DISABLE KEYS */;
/*!40000 ALTER TABLE `grave_bury` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grave_car`
--

DROP TABLE IF EXISTS `grave_car`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grave_car` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` smallint(1) DEFAULT '1',
  `keeper` int(11) DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `status` smallint(1) DEFAULT '1',
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grave_car`
--

LOCK TABLES `grave_car` WRITE;
/*!40000 ALTER TABLE `grave_car` DISABLE KEYS */;
/*!40000 ALTER TABLE `grave_car` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grave_car_addr`
--

DROP TABLE IF EXISTS `grave_car_addr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grave_car_addr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` smallint(1) DEFAULT '1',
  `time` int(11) DEFAULT '0',
  `status` smallint(1) DEFAULT '1',
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grave_car_addr`
--

LOCK TABLES `grave_car_addr` WRITE;
/*!40000 ALTER TABLE `grave_car_addr` DISABLE KEYS */;
/*!40000 ALTER TABLE `grave_car_addr` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grave_car_record`
--

DROP TABLE IF EXISTS `grave_car_record`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grave_car_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bury_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `tomb_id` int(11) NOT NULL,
  `grave_id` int(11) DEFAULT NULL,
  `dead_id` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dead_name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `car_id` int(11) DEFAULT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `use_date` date DEFAULT NULL,
  `use_time` time DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `contact_user` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_mobile` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_num` int(11) DEFAULT NULL,
  `addr_id` int(11) DEFAULT NULL,
  `addr` text COLLATE utf8_unicode_ci,
  `status` smallint(1) DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `order_id` int(11) DEFAULT NULL,
  `order_rel_id` int(11) DEFAULT NULL,
  `is_cremation` smallint(6) DEFAULT '0',
  `is_back` smallint(6) DEFAULT '0',
  `car_type` smallint(6) DEFAULT NULL,
  `updated_at` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grave_car_record`
--

LOCK TABLES `grave_car_record` WRITE;
/*!40000 ALTER TABLE `grave_car_record` DISABLE KEYS */;
/*!40000 ALTER TABLE `grave_car_record` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grave_card`
--

DROP TABLE IF EXISTS `grave_card`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grave_card` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tomb_id` int(11) NOT NULL COMMENT '墓位id',
  `start` date DEFAULT NULL COMMENT '开始时间',
  `end` date DEFAULT NULL COMMENT '结束日期',
  `total` int(11) DEFAULT NULL COMMENT '续费总年数',
  `created_by` int(11) DEFAULT '0' COMMENT '添加人',
  `created_at` int(11) DEFAULT NULL COMMENT '添加时间',
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grave_card`
--

LOCK TABLES `grave_card` WRITE;
/*!40000 ALTER TABLE `grave_card` DISABLE KEYS */;
/*!40000 ALTER TABLE `grave_card` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grave_card_rel`
--

DROP TABLE IF EXISTS `grave_card_rel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grave_card_rel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `card_id` int(11) NOT NULL COMMENT '主表id',
  `tomb_id` int(11) NOT NULL COMMENT '墓位id',
  `start` date DEFAULT NULL COMMENT '开始日期',
  `end` date DEFAULT NULL COMMENT '结束日期',
  `order_id` int(11) DEFAULT '0' COMMENT '订单id',
  `price` decimal(10,2) DEFAULT '0.00' COMMENT '续费钱数',
  `total` int(11) DEFAULT NULL COMMENT '续费年数',
  `num` int(11) DEFAULT '0' COMMENT '周期数',
  `customer_name` varchar(50) DEFAULT '',
  `mobile` varchar(20) DEFAULT '',
  `created_by` int(11) DEFAULT '0' COMMENT '添加人',
  `created_at` int(11) DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grave_card_rel`
--

LOCK TABLES `grave_card_rel` WRITE;
/*!40000 ALTER TABLE `grave_card_rel` DISABLE KEYS */;
/*!40000 ALTER TABLE `grave_card_rel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grave_clean`
--

DROP TABLE IF EXISTS `grave_clean`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grave_clean` (
  `id` int(11) NOT NULL,
  `tomb_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `bury_id` int(11) DEFAULT '0',
  `order_id` int(11) NOT NULL DEFAULT '0',
  `order_detail_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `content` text,
  `op_user` int(11) NOT NULL DEFAULT '0',
  `clean_user` int(11) NOT NULL DEFAULT '0',
  `goods_id` int(11) NOT NULL DEFAULT '0',
  `sku_id` int(11) NOT NULL DEFAULT '0',
  `use_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end_use_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `daynum` tinyint(4) NOT NULL DEFAULT '3',
  `is_over` tinyint(4) NOT NULL DEFAULT '0',
  `clean_cate` tinyint(4) DEFAULT '0',
  `clean_type` tinyint(4) DEFAULT '1',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grave_clean`
--

LOCK TABLES `grave_clean` WRITE;
/*!40000 ALTER TABLE `grave_clean` DISABLE KEYS */;
/*!40000 ALTER TABLE `grave_clean` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grave_customer`
--

DROP TABLE IF EXISTS `grave_customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grave_customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) DEFAULT '0',
  `tomb_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT '0',
  `name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `second_ct` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `second_mobile` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `units` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `province` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zone` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `addr` text COLLATE utf8_unicode_ci,
  `relation` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_vip` smallint(1) DEFAULT '0',
  `vip_desc` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `status` smallint(6) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grave_customer`
--

LOCK TABLES `grave_customer` WRITE;
/*!40000 ALTER TABLE `grave_customer` DISABLE KEYS */;
/*!40000 ALTER TABLE `grave_customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grave_dead`
--

DROP TABLE IF EXISTS `grave_dead`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grave_dead` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `tomb_id` int(11) NOT NULL,
  `memorial_id` int(11) DEFAULT NULL,
  `dead_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `second_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dead_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `serial` int(11) DEFAULT NULL,
  `gender` smallint(1) DEFAULT '1',
  `birth_place` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birth` date DEFAULT NULL,
  `fete` date DEFAULT NULL,
  `is_alive` smallint(1) DEFAULT '1',
  `is_adult` smallint(1) DEFAULT NULL,
  `age` smallint(6) DEFAULT NULL,
  `follow_id` int(11) DEFAULT NULL,
  `desc` text COLLATE utf8_unicode_ci,
  `is_ins` smallint(1) DEFAULT '0',
  `bone_type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bone_box` smallint(6) DEFAULT NULL,
  `pre_bury` datetime DEFAULT NULL,
  `bury` datetime DEFAULT NULL,
  `sort` smallint(6) DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `status` smallint(6) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grave_dead`
--

LOCK TABLES `grave_dead` WRITE;
/*!40000 ALTER TABLE `grave_dead` DISABLE KEYS */;
/*!40000 ALTER TABLE `grave_dead` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grave_dead_dates`
--

DROP TABLE IF EXISTS `grave_dead_dates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grave_dead_dates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tomb_id` int(11) NOT NULL,
  `dead_id` int(11) DEFAULT NULL,
  `title` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dead_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `solar_dt` date DEFAULT NULL,
  `lunar_dt` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time` time DEFAULT NULL,
  `intro` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `status` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grave_dead_dates`
--

LOCK TABLES `grave_dead_dates` WRITE;
/*!40000 ALTER TABLE `grave_dead_dates` DISABLE KEYS */;
/*!40000 ALTER TABLE `grave_dead_dates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grave_images_inscfg`
--

DROP TABLE IF EXISTS `grave_images_inscfg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grave_images_inscfg` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `title` varchar(255) DEFAULT NULL COMMENT '图片标题',
  `desc` text COMMENT '图片描述',
  `path` varchar(255) NOT NULL COMMENT '保存路径,类型以后的路径',
  `name` varchar(64) NOT NULL COMMENT '保存名称',
  `owner_id` int(10) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `img_use` varchar(100) NOT NULL COMMENT '图片的用户',
  `sort` mediumint(5) NOT NULL DEFAULT '0' COMMENT '排序',
  `add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `md5` char(32) NOT NULL COMMENT '图片的md5',
  `ext` varchar(10) NOT NULL COMMENT '图片的类型',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否被删除',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grave_images_inscfg`
--

LOCK TABLES `grave_images_inscfg` WRITE;
/*!40000 ALTER TABLE `grave_images_inscfg` DISABLE KEYS */;
/*!40000 ALTER TABLE `grave_images_inscfg` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grave_ins`
--

DROP TABLE IF EXISTS `grave_ins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grave_ins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `guide_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tomb_id` int(11) NOT NULL,
  `op_id` int(11) DEFAULT NULL,
  `order_rel_id` int(11) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `type` smallint(1) DEFAULT '0',
  `tpl_cfg` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `position` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shape` varchar(1) COLLATE utf8_unicode_ci DEFAULT 'v',
  `content` text COLLATE utf8_unicode_ci,
  `img` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `font` smallint(1) DEFAULT '1',
  `big_num` smallint(6) DEFAULT NULL,
  `small_num` smallint(6) NOT NULL DEFAULT '0' COMMENT '小字个数',
  `new_small_num` smallint(6) NOT NULL DEFAULT '0' COMMENT '新增小字数',
  `new_big_num` smallint(6) DEFAULT NULL,
  `is_tc` smallint(1) DEFAULT '0',
  `final_tc` smallint(1) DEFAULT '0',
  `is_confirm` smallint(1) DEFAULT '0',
  `confirm_date` date DEFAULT NULL,
  `confirm_by` int(11) DEFAULT NULL,
  `pre_finish` date DEFAULT NULL,
  `finish_at` date DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `version` int(11) DEFAULT '0',
  `paint` smallint(6) DEFAULT NULL,
  `is_stand` smallint(1) DEFAULT '0',
  `paint_price` decimal(10,2) DEFAULT NULL,
  `letter_price` decimal(10,2) DEFAULT NULL,
  `tc_price` decimal(10,2) DEFAULT NULL,
  `changed` smallint(1) DEFAULT '0',
  `status` smallint(1) DEFAULT '1',
  `updated_at` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grave_ins`
--

LOCK TABLES `grave_ins` WRITE;
/*!40000 ALTER TABLE `grave_ins` DISABLE KEYS */;
/*!40000 ALTER TABLE `grave_ins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grave_ins_cfg`
--

DROP TABLE IF EXISTS `grave_ins_cfg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grave_ins_cfg` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '配置id',
  `name` varchar(100) NOT NULL COMMENT '配置名',
  `shape` char(1) NOT NULL DEFAULT 'v' COMMENT 'v竖，h横',
  `is_god` tinyint(1) NOT NULL COMMENT '1天主 0非天主',
  `is_front` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1前模板，0后模板',
  `note` text NOT NULL COMMENT '备注',
  `sort` int(11) NOT NULL DEFAULT '1' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grave_ins_cfg`
--

LOCK TABLES `grave_ins_cfg` WRITE;
/*!40000 ALTER TABLE `grave_ins_cfg` DISABLE KEYS */;
/*!40000 ALTER TABLE `grave_ins_cfg` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grave_ins_cfg_case`
--

DROP TABLE IF EXISTS `grave_ins_cfg_case`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grave_ins_cfg_case` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `cfg_id` int(11) NOT NULL COMMENT '配置id',
  `num` int(11) NOT NULL COMMENT '人数',
  `width` int(11) NOT NULL COMMENT '图片宽',
  `height` int(11) NOT NULL COMMENT '图片高',
  `img` varchar(200) DEFAULT NULL COMMENT '示例图片',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态，0删除　',
  `sort` int(11) NOT NULL DEFAULT '1' COMMENT '排序',
  `add_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='碑文配置名称表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grave_ins_cfg_case`
--

LOCK TABLES `grave_ins_cfg_case` WRITE;
/*!40000 ALTER TABLE `grave_ins_cfg_case` DISABLE KEYS */;
/*!40000 ALTER TABLE `grave_ins_cfg_case` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grave_ins_cfg_rel`
--

DROP TABLE IF EXISTS `grave_ins_cfg_rel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grave_ins_cfg_rel` (
  `grave_id` int(11) NOT NULL COMMENT '墓区id',
  `cfg_id` int(11) NOT NULL COMMENT '配置id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='墓区与配置关联表，多对多';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grave_ins_cfg_rel`
--

LOCK TABLES `grave_ins_cfg_rel` WRITE;
/*!40000 ALTER TABLE `grave_ins_cfg_rel` DISABLE KEYS */;
/*!40000 ALTER TABLE `grave_ins_cfg_rel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grave_ins_cfg_value`
--

DROP TABLE IF EXISTS `grave_ins_cfg_value`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grave_ins_cfg_value` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增加id',
  `case_id` int(11) NOT NULL COMMENT '配置名id',
  `mark` char(20) NOT NULL COMMENT '标识，如title、name等',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '序号，比如逝者有两个时,排个序',
  `is_big` tinyint(1) NOT NULL DEFAULT '1',
  `size` int(11) NOT NULL COMMENT '字体尺寸',
  `x` int(11) NOT NULL COMMENT 'x轴距离',
  `y` int(11) NOT NULL COMMENT 'y方向距离',
  `color` varchar(10) NOT NULL COMMENT '颜色,存16进制好一些',
  `direction` tinyint(4) NOT NULL COMMENT '字超向,0:正向，1:反向',
  `text` varchar(100) NOT NULL COMMENT '测试值',
  `add_time` datetime NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='碑文配置表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grave_ins_cfg_value`
--

LOCK TABLES `grave_ins_cfg_value` WRITE;
/*!40000 ALTER TABLE `grave_ins_cfg_value` DISABLE KEYS */;
/*!40000 ALTER TABLE `grave_ins_cfg_value` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grave_ins_log`
--

DROP TABLE IF EXISTS `grave_ins_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grave_ins_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ins_id` int(11) NOT NULL,
  `op_id` int(11) NOT NULL,
  `tomb_id` int(11) NOT NULL,
  `action` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `img` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci,
  `status` smallint(1) DEFAULT '1',
  `updated_at` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grave_ins_log`
--

LOCK TABLES `grave_ins_log` WRITE;
/*!40000 ALTER TABLE `grave_ins_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `grave_ins_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grave_portrait`
--

DROP TABLE IF EXISTS `grave_portrait`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grave_portrait` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `guide_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tomb_id` int(11) NOT NULL,
  `title` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sku_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `order_rel_id` int(11) DEFAULT NULL,
  `dead_ids` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `photo_original` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `photo_processed` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `confirm_by` int(11) DEFAULT NULL,
  `confirm_at` datetime DEFAULT NULL,
  `photo_confirm` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `use_at` datetime DEFAULT NULL,
  `up_at` datetime DEFAULT NULL,
  `notice_id` int(11) DEFAULT NULL,
  `type` smallint(6) DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `sort` int(11) DEFAULT '0',
  `status` smallint(1) DEFAULT '1',
  `updated_at` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grave_portrait`
--

LOCK TABLES `grave_portrait` WRITE;
/*!40000 ALTER TABLE `grave_portrait` DISABLE KEYS */;
/*!40000 ALTER TABLE `grave_portrait` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grave_portrait_log`
--

DROP TABLE IF EXISTS `grave_portrait_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grave_portrait_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `portrait_id` int(11) NOT NULL,
  `op_id` int(11) NOT NULL,
  `tomb_id` int(11) NOT NULL,
  `action` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `img` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `status` smallint(1) DEFAULT '1',
  `updated_at` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grave_portrait_log`
--

LOCK TABLES `grave_portrait_log` WRITE;
/*!40000 ALTER TABLE `grave_portrait_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `grave_portrait_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grave_return`
--

DROP TABLE IF EXISTS `grave_return`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grave_return` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grave_return`
--

LOCK TABLES `grave_return` WRITE;
/*!40000 ALTER TABLE `grave_return` DISABLE KEYS */;
/*!40000 ALTER TABLE `grave_return` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grave_tomb`
--

DROP TABLE IF EXISTS `grave_tomb`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grave_tomb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grave_id` int(11) DEFAULT NULL,
  `row` int(11) DEFAULT NULL,
  `col` int(11) DEFAULT NULL,
  `special` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tomb_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hole` smallint(6) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `cost` decimal(10,2) DEFAULT NULL,
  `area_total` float DEFAULT NULL,
  `area_use` float DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `agency_id` int(11) DEFAULT NULL,
  `guide_id` int(11) DEFAULT NULL,
  `sale_time` datetime DEFAULT NULL,
  `mnt_by` varchar(200) COLLATE utf8_unicode_ci DEFAULT '',
  `note` text COLLATE utf8_unicode_ci,
  `thumb` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grave_tomb`
--

LOCK TABLES `grave_tomb` WRITE;
/*!40000 ALTER TABLE `grave_tomb` DISABLE KEYS */;
/*!40000 ALTER TABLE `grave_tomb` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grave_withdraw`
--

DROP TABLE IF EXISTS `grave_withdraw`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grave_withdraw` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `guide_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tomb_id` int(11) NOT NULL,
  `current_tomb_id` int(11) NOT NULL,
  `refund_id` int(11) DEFAULT NULL,
  `ct_name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ct_mobile` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ct_card` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ct_relation` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reson` text COLLATE utf8_unicode_ci,
  `price` decimal(10,2) DEFAULT NULL,
  `in_tomb_id` int(11) DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `status` smallint(1) DEFAULT '1',
  `updated_at` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grave_withdraw`
--

LOCK TABLES `grave_withdraw` WRITE;
/*!40000 ALTER TABLE `grave_withdraw` DISABLE KEYS */;
/*!40000 ALTER TABLE `grave_withdraw` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `image_config`
--

DROP TABLE IF EXISTS `image_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `image_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `res_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_thumb` smallint(1) DEFAULT '1',
  `thumb_mode` smallint(1) DEFAULT '1',
  `thumb_config` text COLLATE utf8_unicode_ci,
  `water_mod` smallint(1) DEFAULT '1',
  `water_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `water_text` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `water_opacity` int(4) DEFAULT '100',
  `water_pos` smallint(6) DEFAULT NULL,
  `min_width` int(11) DEFAULT NULL,
  `min_height` int(11) DEFAULT NULL,
  `created_at` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `image_config`
--

LOCK TABLES `image_config` WRITE;
/*!40000 ALTER TABLE `image_config` DISABLE KEYS */;
/*!40000 ALTER TABLE `image_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventory`
--

DROP TABLE IF EXISTS `inventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) DEFAULT NULL,
  `sku_id` int(11) DEFAULT NULL,
  `record` float DEFAULT NULL,
  `actual` float DEFAULT NULL,
  `op_id` int(11) DEFAULT NULL,
  `op_date` datetime DEFAULT NULL,
  `diff_num` float DEFAULT NULL,
  `diff_amount` decimal(10,2) DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `created_at` int(11) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory`
--

LOCK TABLES `inventory` WRITE;
/*!40000 ALTER TABLE `inventory` DISABLE KEYS */;
/*!40000 ALTER TABLE `inventory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventory_purchase`
--

DROP TABLE IF EXISTS `inventory_purchase`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventory_purchase` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_id` int(11) DEFAULT NULL,
  `op_id` int(11) DEFAULT NULL,
  `op_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ct_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ct_mobile` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `checker_id` int(11) DEFAULT NULL,
  `checker_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `supply_at` date NOT NULL,
  `created_at` int(11) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory_purchase`
--

LOCK TABLES `inventory_purchase` WRITE;
/*!40000 ALTER TABLE `inventory_purchase` DISABLE KEYS */;
/*!40000 ALTER TABLE `inventory_purchase` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventory_purchase_finance`
--

DROP TABLE IF EXISTS `inventory_purchase_finance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventory_purchase_finance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_id` int(11) DEFAULT NULL,
  `refund_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `op_id` int(11) DEFAULT NULL,
  `op_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ct_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ct_mobile` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `created_at` int(11) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '2',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory_purchase_finance`
--

LOCK TABLES `inventory_purchase_finance` WRITE;
/*!40000 ALTER TABLE `inventory_purchase_finance` DISABLE KEYS */;
/*!40000 ALTER TABLE `inventory_purchase_finance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventory_purchase_refund`
--

DROP TABLE IF EXISTS `inventory_purchase_refund`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventory_purchase_refund` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_rel_id` int(11) DEFAULT NULL,
  `num` float DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `op_id` int(11) DEFAULT NULL,
  `op_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ct_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ct_mobile` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `created_at` int(11) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '2',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory_purchase_refund`
--

LOCK TABLES `inventory_purchase_refund` WRITE;
/*!40000 ALTER TABLE `inventory_purchase_refund` DISABLE KEYS */;
/*!40000 ALTER TABLE `inventory_purchase_refund` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventory_purchase_rel`
--

DROP TABLE IF EXISTS `inventory_purchase_rel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventory_purchase_rel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_id` int(11) NOT NULL,
  `record_id` int(11) NOT NULL,
  `goods_id` int(11) NOT NULL,
  `sku_id` int(11) NOT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `num` float DEFAULT NULL,
  `unit` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `retail` decimal(10,2) DEFAULT NULL,
  `op_id` int(11) DEFAULT NULL,
  `op_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `created_at` int(11) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory_purchase_rel`
--

LOCK TABLES `inventory_purchase_rel` WRITE;
/*!40000 ALTER TABLE `inventory_purchase_rel` DISABLE KEYS */;
/*!40000 ALTER TABLE `inventory_purchase_rel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventory_storage`
--

DROP TABLE IF EXISTS `inventory_storage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventory_storage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `pos` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `op_id` int(11) DEFAULT NULL,
  `op_name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `thumb` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory_storage`
--

LOCK TABLES `inventory_storage` WRITE;
/*!40000 ALTER TABLE `inventory_storage` DISABLE KEYS */;
/*!40000 ALTER TABLE `inventory_storage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventory_supplier`
--

DROP TABLE IF EXISTS `inventory_supplier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventory_supplier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cp_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `cp_phone` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `addr` text COLLATE utf8_unicode_ci NOT NULL,
  `ct_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ct_mobile` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ct_sex` smallint(6) DEFAULT NULL,
  `qq` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `wechat` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `created_by` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory_supplier`
--

LOCK TABLES `inventory_supplier` WRITE;
/*!40000 ALTER TABLE `inventory_supplier` DISABLE KEYS */;
/*!40000 ALTER TABLE `inventory_supplier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `links`
--

DROP TABLE IF EXISTS `links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `intro` text COLLATE utf8_unicode_ci,
  `status` smallint(1) DEFAULT '1',
  `created_at` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `links`
--

LOCK TABLES `links` WRITE;
/*!40000 ALTER TABLE `links` DISABLE KEYS */;
/*!40000 ALTER TABLE `links` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `memorial`
--

DROP TABLE IF EXISTS `memorial`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `memorial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `tomb_id` int(11) DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `thumb` int(11) DEFAULT NULL,
  `intro` text COLLATE utf8_unicode_ci,
  `privacy` smallint(1) DEFAULT '0',
  `view_all` int(11) DEFAULT '0',
  `com_all` int(11) DEFAULT '0',
  `tpl` varchar(200) COLLATE utf8_unicode_ci DEFAULT 'ink',
  `status` smallint(1) DEFAULT '1',
  `updated_at` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `memorial`
--

LOCK TABLES `memorial` WRITE;
/*!40000 ALTER TABLE `memorial` DISABLE KEYS */;
/*!40000 ALTER TABLE `memorial` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `memorial_day`
--

DROP TABLE IF EXISTS `memorial_day`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `memorial_day` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `memorial_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `date_type` smallint(1) DEFAULT '1',
  `created_by` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `status` smallint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `memorial_day`
--

LOCK TABLES `memorial_day` WRITE;
/*!40000 ALTER TABLE `memorial_day` DISABLE KEYS */;
/*!40000 ALTER TABLE `memorial_day` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `memorial_pray`
--

DROP TABLE IF EXISTS `memorial_pray`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `memorial_pray` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `memorial_id` int(11) NOT NULL,
  `type` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `msg` text COLLATE utf8_unicode_ci,
  `order_id` int(11) DEFAULT '0',
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `memorial_pray`
--

LOCK TABLES `memorial_pray` WRITE;
/*!40000 ALTER TABLE `memorial_pray` DISABLE KEYS */;
/*!40000 ALTER TABLE `memorial_pray` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `memorial_rel`
--

DROP TABLE IF EXISTS `memorial_rel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `memorial_rel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `memorial_id` int(11) NOT NULL,
  `res_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `res_id` int(11) NOT NULL,
  `res_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `res_user` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `res_cover` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `memorial_rel`
--

LOCK TABLES `memorial_rel` WRITE;
/*!40000 ALTER TABLE `memorial_rel` DISABLE KEYS */;
/*!40000 ALTER TABLE `memorial_rel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `memorial_user`
--

DROP TABLE IF EXISTS `memorial_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `memorial_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `memorial_id` int(11) NOT NULL,
  `relation` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `status` smallint(6) DEFAULT '1',
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `memorial_user`
--

LOCK TABLES `memorial_user` WRITE;
/*!40000 ALTER TABLE `memorial_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `memorial_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `res_id` int(11) DEFAULT NULL,
  `res_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'goods',
  `op_id` int(11) DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `term` date DEFAULT NULL,
  `product` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `qq` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `skype` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `intro` text COLLATE utf8_unicode_ci,
  `company` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(6) DEFAULT '1',
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message`
--

LOCK TABLES `message` WRITE;
/*!40000 ALTER TABLE `message` DISABLE KEYS */;
/*!40000 ALTER TABLE `message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration`
--

DROP TABLE IF EXISTS `migration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration`
--

LOCK TABLES `migration` WRITE;
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `module`
--

DROP TABLE IF EXISTS `module`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `title` varchar(200) NOT NULL,
  `intro` text,
  `logo` varchar(200) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `module`
--

LOCK TABLES `module` WRITE;
/*!40000 ALTER TABLE `module` DISABLE KEYS */;
/*!40000 ALTER TABLE `module` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `module_code`
--

DROP TABLE IF EXISTS `module_code`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `module_code` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL DEFAULT 'model',
  `code` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='模块代码';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `module_code`
--

LOCK TABLES `module_code` WRITE;
/*!40000 ALTER TABLE `module_code` DISABLE KEYS */;
/*!40000 ALTER TABLE `module_code` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `module_field`
--

DROP TABLE IF EXISTS `module_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `module_field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `model_id` int(11) NOT NULL,
  `table` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pop_note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `html` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `option` text COLLATE utf8_unicode_ci,
  `default` text COLLATE utf8_unicode_ci,
  `is_show` smallint(1) DEFAULT '1',
  `order` smallint(1) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `module_field`
--

LOCK TABLES `module_field` WRITE;
/*!40000 ALTER TABLE `module_field` DISABLE KEYS */;
/*!40000 ALTER TABLE `module_field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `module_model`
--

DROP TABLE IF EXISTS `module_model`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `module_model` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mid` int(11) NOT NULL COMMENT '代替原来用id的mod',
  `module` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dir` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `intro` text COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `order` smallint(4) DEFAULT NULL,
  `show` smallint(1) DEFAULT '1',
  `logo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `module_model`
--

LOCK TABLES `module_model` WRITE;
/*!40000 ALTER TABLE `module_model` DISABLE KEYS */;
/*!40000 ALTER TABLE `module_model` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subtitle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `summary` text COLLATE utf8_unicode_ci,
  `author` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pic_author` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `video_author` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `source` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `thumb` int(11) DEFAULT NULL,
  `video` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `view_all` int(11) DEFAULT '0',
  `com_all` int(11) DEFAULT '0',
  `recommend` smallint(6) DEFAULT '0',
  `is_top` smallint(6) DEFAULT '0',
  `type` smallint(6) DEFAULT '1',
  `created_by` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news_category`
--

DROP TABLE IF EXISTS `news_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) DEFAULT '0',
  `level` smallint(6) NOT NULL DEFAULT '1',
  `code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `thumb` int(11) DEFAULT NULL,
  `body` text COLLATE utf8_unicode_ci,
  `sort` smallint(6) NOT NULL DEFAULT '0',
  `is_leaf` smallint(1) DEFAULT '1',
  `seo_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seo_keywords` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seo_description` text COLLATE utf8_unicode_ci,
  `created_at` int(11) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news_category`
--

LOCK TABLES `news_category` WRITE;
/*!40000 ALTER TABLE `news_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `news_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news_data`
--

DROP TABLE IF EXISTS `news_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news_data` (
  `news_id` int(11) NOT NULL AUTO_INCREMENT,
  `body` text COLLATE utf8_unicode_ci,
  `status` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`news_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news_data`
--

LOCK TABLES `news_data` WRITE;
/*!40000 ALTER TABLE `news_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `news_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news_photo`
--

DROP TABLE IF EXISTS `news_photo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news_photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `news_id` int(11) DEFAULT NULL,
  `title` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `path` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `view_all` int(11) DEFAULT '0',
  `com_all` int(11) DEFAULT '0',
  `body` text COLLATE utf8_unicode_ci,
  `ext` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ip` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news_photo`
--

LOCK TABLES `news_photo` WRITE;
/*!40000 ALTER TABLE `news_photo` DISABLE KEYS */;
/*!40000 ALTER TABLE `news_photo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `note`
--

DROP TABLE IF EXISTS `note`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `note` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `res_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `intro` text COLLATE utf8_unicode_ci,
  `user_id` int(11) DEFAULT NULL,
  `start` date DEFAULT NULL,
  `end` date DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `status` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `note`
--

LOCK TABLES `note` WRITE;
/*!40000 ALTER TABLE `note` DISABLE KEYS */;
/*!40000 ALTER TABLE `note` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) DEFAULT NULL,
  `wechat_uid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `op_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `origin_price` decimal(10,2) DEFAULT NULL,
  `type` smallint(6) DEFAULT '1',
  `progress` smallint(6) DEFAULT '0',
  `note` text COLLATE utf8_unicode_ci,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `status` smallint(6) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order`
--

LOCK TABLES `order` WRITE;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
/*!40000 ALTER TABLE `order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_delay`
--

DROP TABLE IF EXISTS `order_delay`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_delay` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `op_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `pre_dt` date DEFAULT NULL,
  `pay_dt` datetime DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `created_by` int(11) DEFAULT NULL,
  `is_verified` smallint(1) DEFAULT '0',
  `verified_by` int(11) DEFAULT NULL,
  `verified_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `status` smallint(6) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_delay`
--

LOCK TABLES `order_delay` WRITE;
/*!40000 ALTER TABLE `order_delay` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_delay` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_log`
--

DROP TABLE IF EXISTS `order_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `op_id` int(11) NOT NULL,
  `old` text NOT NULL,
  `diff` text,
  `intro` text,
  `type` tinyint(4) NOT NULL DEFAULT '4',
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COMMENT='订单日志';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_log`
--

LOCK TABLES `order_log` WRITE;
/*!40000 ALTER TABLE `order_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_pay`
--

DROP TABLE IF EXISTS `order_pay`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_pay` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wechat_uid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `op_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `order_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `trade_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `total_fee` decimal(10,2) DEFAULT NULL,
  `total_pay` decimal(10,2) DEFAULT NULL,
  `pay_method` smallint(6) DEFAULT NULL,
  `pay_result` smallint(6) DEFAULT NULL,
  `paid_at` datetime DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `checkout_at` datetime DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `status` smallint(6) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_pay`
--

LOCK TABLES `order_pay` WRITE;
/*!40000 ALTER TABLE `order_pay` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_pay` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_refund`
--

DROP TABLE IF EXISTS `order_refund`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_refund` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL DEFAULT '0',
  `order_id` int(11) DEFAULT NULL,
  `wechat_uid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `op_id` int(11) DEFAULT NULL,
  `fee` decimal(10,2) DEFAULT NULL,
  `progress` smallint(6) DEFAULT '1',
  `price` decimal(10,2) DEFAULT NULL,
  `intro` text COLLATE utf8_unicode_ci,
  `note` text COLLATE utf8_unicode_ci,
  `checkout_at` datetime DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `status` smallint(6) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_refund`
--

LOCK TABLES `order_refund` WRITE;
/*!40000 ALTER TABLE `order_refund` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_refund` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_rel`
--

DROP TABLE IF EXISTS `order_rel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_rel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) DEFAULT '0',
  `wechat_uid` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `op_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` smallint(6) DEFAULT '1',
  `category_id` smallint(6) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `sku_id` int(11) DEFAULT NULL,
  `sku_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `original_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `price_unit` decimal(10,2) DEFAULT NULL,
  `num` int(11) DEFAULT NULL,
  `use_time` datetime DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `is_refund` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `status` smallint(6) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_rel`
--

LOCK TABLES `order_rel` WRITE;
/*!40000 ALTER TABLE `order_rel` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_rel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category_id` int(11) DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subtitle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `summary` text COLLATE utf8_unicode_ci,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `thumb` int(11) DEFAULT NULL,
  `ip` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `photo_num` int(11) NOT NULL DEFAULT '0',
  `view_all` int(11) DEFAULT '0',
  `com_all` int(11) DEFAULT '0',
  `recommend` smallint(6) DEFAULT '0',
  `created_by` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `type` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1text 2 image 3video',
  `updated_at` int(11) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post`
--

LOCK TABLES `post` WRITE;
/*!40000 ALTER TABLE `post` DISABLE KEYS */;
/*!40000 ALTER TABLE `post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post_2`
--

DROP TABLE IF EXISTS `post_2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `post_2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category_id` int(11) DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subtitle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `summary` text COLLATE utf8_unicode_ci,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `thumb` int(11) DEFAULT NULL,
  `ip` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `view_all` int(11) DEFAULT '0',
  `com_all` int(11) DEFAULT '0',
  `recommend` smallint(6) DEFAULT '0',
  `created_by` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `photo_num` int(11) NOT NULL DEFAULT '0',
  `type` int(11) NOT NULL DEFAULT '1',
  `updated_at` int(11) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1',
  `author2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_2`
--

LOCK TABLES `post_2` WRITE;
/*!40000 ALTER TABLE `post_2` DISABLE KEYS */;
/*!40000 ALTER TABLE `post_2` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post_attach`
--

DROP TABLE IF EXISTS `post_attach`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `post_attach` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `res_id` int(11) DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `desc` text COLLATE utf8_unicode_ci,
  `ext` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_attach`
--

LOCK TABLES `post_attach` WRITE;
/*!40000 ALTER TABLE `post_attach` DISABLE KEYS */;
/*!40000 ALTER TABLE `post_attach` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post_category`
--

DROP TABLE IF EXISTS `post_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `post_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) DEFAULT NULL,
  `level` smallint(6) NOT NULL DEFAULT '1',
  `code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cover` int(11) DEFAULT NULL,
  `body` text COLLATE utf8_unicode_ci,
  `sort` smallint(6) NOT NULL DEFAULT '0',
  `is_leaf` smallint(1) DEFAULT '1',
  `seo_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seo_keywords` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seo_description` text COLLATE utf8_unicode_ci,
  `created_at` int(11) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_category`
--

LOCK TABLES `post_category` WRITE;
/*!40000 ALTER TABLE `post_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `post_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post_data`
--

DROP TABLE IF EXISTS `post_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `post_data` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `body` text COLLATE utf8_unicode_ci,
  `status` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_data`
--

LOCK TABLES `post_data` WRITE;
/*!40000 ALTER TABLE `post_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `post_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post_data_2`
--

DROP TABLE IF EXISTS `post_data_2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `post_data_2` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `body` text COLLATE utf8_unicode_ci,
  `status` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_data_2`
--

LOCK TABLES `post_data_2` WRITE;
/*!40000 ALTER TABLE `post_data_2` DISABLE KEYS */;
/*!40000 ALTER TABLE `post_data_2` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post_image`
--

DROP TABLE IF EXISTS `post_image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `post_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) DEFAULT NULL,
  `mod` int(11) DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `view_all` int(11) DEFAULT '0',
  `com_all` int(11) DEFAULT '0',
  `desc` text COLLATE utf8_unicode_ci,
  `ext` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_image`
--

LOCK TABLES `post_image` WRITE;
/*!40000 ALTER TABLE `post_image` DISABLE KEYS */;
/*!40000 ALTER TABLE `post_image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settlement`
--

DROP TABLE IF EXISTS `settlement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settlement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `op_id` int(11) NOT NULL,
  `guide_id` int(11) DEFAULT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `type` smallint(6) NOT NULL,
  `pay_type` smallint(6) NOT NULL,
  `ori_price` decimal(10,2) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `year` smallint(6) DEFAULT NULL,
  `quarter` tinyint(4) NOT NULL COMMENT '季度',
  `month` smallint(2) DEFAULT NULL,
  `week` smallint(2) DEFAULT NULL,
  `day` smallint(2) DEFAULT NULL,
  `settle_time` datetime NOT NULL,
  `pay_time` datetime DEFAULT NULL,
  `intro` text COLLATE utf8_unicode_ci,
  `status` smallint(6) DEFAULT '1',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settlement`
--

LOCK TABLES `settlement` WRITE;
/*!40000 ALTER TABLE `settlement` DISABLE KEYS */;
/*!40000 ALTER TABLE `settlement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settlement_rel`
--

DROP TABLE IF EXISTS `settlement_rel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settlement_rel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `settlement_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `op_id` int(11) NOT NULL,
  `guide_id` int(11) DEFAULT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `res_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `goods_id` int(11) NOT NULL,
  `sku_id` int(11) NOT NULL,
  `type` smallint(6) DEFAULT NULL,
  `num` int(11) DEFAULT '1',
  `ori_price` decimal(10,2) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `year` smallint(6) DEFAULT NULL,
  `month` smallint(2) DEFAULT NULL,
  `week` smallint(2) DEFAULT NULL,
  `day` smallint(2) DEFAULT NULL,
  `settle_time` datetime NOT NULL,
  `pay_time` datetime DEFAULT NULL,
  `intro` text COLLATE utf8_unicode_ci,
  `status` smallint(6) DEFAULT '1',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settlement_rel`
--

LOCK TABLES `settlement_rel` WRITE;
/*!40000 ALTER TABLE `settlement_rel` DISABLE KEYS */;
/*!40000 ALTER TABLE `settlement_rel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settlement_tomb`
--

DROP TABLE IF EXISTS `settlement_tomb`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settlement_tomb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num` int(11) DEFAULT NULL,
  `amount` decimal(20,2) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `intro` text COLLATE utf8_unicode_ci,
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settlement_tomb`
--

LOCK TABLES `settlement_tomb` WRITE;
/*!40000 ALTER TABLE `settlement_tomb` DISABLE KEYS */;
/*!40000 ALTER TABLE `settlement_tomb` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_attach`
--

DROP TABLE IF EXISTS `shop_attach`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_attach` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `res_id` int(11) DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `desc` text COLLATE utf8_unicode_ci,
  `ext` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_attach`
--

LOCK TABLES `shop_attach` WRITE;
/*!40000 ALTER TABLE `shop_attach` DISABLE KEYS */;
/*!40000 ALTER TABLE `shop_attach` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_attr`
--

DROP TABLE IF EXISTS `shop_attr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_attr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_multi` smallint(6) DEFAULT '0',
  `is_spec` smallint(6) DEFAULT '0',
  `body` text COLLATE utf8_unicode_ci,
  `status` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_attr`
--

LOCK TABLES `shop_attr` WRITE;
/*!40000 ALTER TABLE `shop_attr` DISABLE KEYS */;
/*!40000 ALTER TABLE `shop_attr` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_av`
--

DROP TABLE IF EXISTS `shop_av`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_av` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) DEFAULT NULL,
  `attr_id` int(11) DEFAULT NULL,
  `val` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `thumb` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_av`
--

LOCK TABLES `shop_av` WRITE;
/*!40000 ALTER TABLE `shop_av` DISABLE KEYS */;
/*!40000 ALTER TABLE `shop_av` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_av_rel`
--

DROP TABLE IF EXISTS `shop_av_rel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_av_rel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `attr_id` int(11) DEFAULT NULL,
  `av_id` int(11) DEFAULT NULL,
  `value` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_av_rel`
--

LOCK TABLES `shop_av_rel` WRITE;
/*!40000 ALTER TABLE `shop_av_rel` DISABLE KEYS */;
/*!40000 ALTER TABLE `shop_av_rel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_bag`
--

DROP TABLE IF EXISTS `shop_bag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_bag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `op_id` int(11) DEFAULT NULL,
  `original_price` decimal(10,2) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `rate` decimal(10,2) NOT NULL COMMENT '折扣率',
  `thumb` int(11) DEFAULT NULL,
  `intro` text COLLATE utf8_unicode_ci,
  `type` smallint(6) DEFAULT '1',
  `status` smallint(6) DEFAULT '1',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_bag`
--

LOCK TABLES `shop_bag` WRITE;
/*!40000 ALTER TABLE `shop_bag` DISABLE KEYS */;
/*!40000 ALTER TABLE `shop_bag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_bag_rel`
--

DROP TABLE IF EXISTS `shop_bag_rel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_bag_rel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bag_id` int(11) NOT NULL,
  `goods_id` int(11) NOT NULL,
  `sku_id` int(11) NOT NULL,
  `num` int(11) NOT NULL DEFAULT '1',
  `unit_price` decimal(10,2) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `status` smallint(6) DEFAULT '1',
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_bag_rel`
--

LOCK TABLES `shop_bag_rel` WRITE;
/*!40000 ALTER TABLE `shop_bag_rel` DISABLE KEYS */;
/*!40000 ALTER TABLE `shop_bag_rel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_cart`
--

DROP TABLE IF EXISTS `shop_cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `type` smallint(6) DEFAULT '1',
  `goods_id` int(11) DEFAULT NULL,
  `sku_id` int(11) DEFAULT NULL,
  `num` int(11) DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_cart`
--

LOCK TABLES `shop_cart` WRITE;
/*!40000 ALTER TABLE `shop_cart` DISABLE KEYS */;
/*!40000 ALTER TABLE `shop_cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_category`
--

DROP TABLE IF EXISTS `shop_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `level` smallint(6) NOT NULL DEFAULT '1',
  `code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `thumb` int(11) DEFAULT NULL,
  `body` text COLLATE utf8_unicode_ci,
  `sort` smallint(6) NOT NULL DEFAULT '0',
  `is_leaf` smallint(6) NOT NULL DEFAULT '1',
  `is_show` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否前台显示 ',
  `seo_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seo_keywords` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seo_description` text COLLATE utf8_unicode_ci,
  `created_at` int(11) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_category`
--

LOCK TABLES `shop_category` WRITE;
/*!40000 ALTER TABLE `shop_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `shop_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_goods`
--

DROP TABLE IF EXISTS `shop_goods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `pinyin` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `serial` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `thumb` int(11) DEFAULT NULL,
  `intro` text COLLATE utf8_unicode_ci,
  `skill` text COLLATE utf8_unicode_ci,
  `unit` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `original_price` decimal(10,2) DEFAULT '0.00' COMMENT '原价',
  `num` int(11) DEFAULT NULL,
  `is_recommend` smallint(6) DEFAULT '0',
  `is_show` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否前台显示',
  `status` smallint(6) NOT NULL DEFAULT '1',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_goods`
--

LOCK TABLES `shop_goods` WRITE;
/*!40000 ALTER TABLE `shop_goods` DISABLE KEYS */;
/*!40000 ALTER TABLE `shop_goods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_history`
--

DROP TABLE IF EXISTS `shop_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wechat_uid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `sku_id` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_history`
--

LOCK TABLES `shop_history` WRITE;
/*!40000 ALTER TABLE `shop_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `shop_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_mix`
--

DROP TABLE IF EXISTS `shop_mix`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_mix` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mix_cate` int(11) DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `thumb` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_mix`
--

LOCK TABLES `shop_mix` WRITE;
/*!40000 ALTER TABLE `shop_mix` DISABLE KEYS */;
/*!40000 ALTER TABLE `shop_mix` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_mix_cate`
--

DROP TABLE IF EXISTS `shop_mix_cate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_mix_cate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) DEFAULT NULL,
  `level` smallint(6) NOT NULL DEFAULT '1',
  `code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `thumb` int(11) DEFAULT NULL,
  `body` text COLLATE utf8_unicode_ci,
  `sort` smallint(6) NOT NULL DEFAULT '0',
  `is_leaf` smallint(6) NOT NULL DEFAULT '1',
  `seo_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seo_keywords` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seo_description` text COLLATE utf8_unicode_ci,
  `created_at` int(11) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_mix_cate`
--

LOCK TABLES `shop_mix_cate` WRITE;
/*!40000 ALTER TABLE `shop_mix_cate` DISABLE KEYS */;
/*!40000 ALTER TABLE `shop_mix_cate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_mix_rel`
--

DROP TABLE IF EXISTS `shop_mix_rel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_mix_rel` (
  `category_id` int(11) DEFAULT NULL,
  `mix_cate` int(11) DEFAULT '0',
  `goods_id` int(11) DEFAULT NULL,
  `mix_id` int(11) DEFAULT NULL,
  `measure` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(1) DEFAULT '0',
  `status` smallint(6) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_mix_rel`
--

LOCK TABLES `shop_mix_rel` WRITE;
/*!40000 ALTER TABLE `shop_mix_rel` DISABLE KEYS */;
/*!40000 ALTER TABLE `shop_mix_rel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_process`
--

DROP TABLE IF EXISTS `shop_process`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_process` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) DEFAULT NULL,
  `step` smallint(6) DEFAULT NULL,
  `intro` text COLLATE utf8_unicode_ci,
  `thumb` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` smallint(6) DEFAULT '1',
  `sort` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_process`
--

LOCK TABLES `shop_process` WRITE;
/*!40000 ALTER TABLE `shop_process` DISABLE KEYS */;
/*!40000 ALTER TABLE `shop_process` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_sku`
--

DROP TABLE IF EXISTS `shop_sku`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_sku` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) NOT NULL,
  `serial` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `num` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `original_price` decimal(10,2) DEFAULT '0.00',
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `av` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_sku`
--

LOCK TABLES `shop_sku` WRITE;
/*!40000 ALTER TABLE `shop_sku` DISABLE KEYS */;
/*!40000 ALTER TABLE `shop_sku` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_type`
--

DROP TABLE IF EXISTS `shop_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_type`
--

LOCK TABLES `shop_type` WRITE;
/*!40000 ALTER TABLE `shop_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `shop_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sms_receive`
--

DROP TABLE IF EXISTS `sms_receive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sms_receive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mobile` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `msg` text COLLATE utf8_unicode_ci,
  `status` smallint(6) DEFAULT '1',
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sms_receive`
--

LOCK TABLES `sms_receive` WRITE;
/*!40000 ALTER TABLE `sms_receive` DISABLE KEYS */;
/*!40000 ALTER TABLE `sms_receive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sms_send`
--

DROP TABLE IF EXISTS `sms_send`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sms_send` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mobile` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `msg` text COLLATE utf8_unicode_ci,
  `time` datetime DEFAULT NULL,
  `status` smallint(6) DEFAULT '1',
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sms_send`
--

LOCK TABLES `sms_send` WRITE;
/*!40000 ALTER TABLE `sms_send` DISABLE KEYS */;
/*!40000 ALTER TABLE `sms_send` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subject`
--

DROP TABLE IF EXISTS `subject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `intro` text COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cover` int(11) DEFAULT NULL,
  `path` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cate` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '分类',
  `status` smallint(6) DEFAULT '1',
  `updated_at` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subject`
--

LOCK TABLES `subject` WRITE;
/*!40000 ALTER TABLE `subject` DISABLE KEYS */;
/*!40000 ALTER TABLE `subject` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_menu`
--

DROP TABLE IF EXISTS `sys_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auth_name` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pid` int(11) DEFAULT NULL,
  `icon` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort` smallint(6) NOT NULL DEFAULT '1',
  `status` smallint(6) NOT NULL DEFAULT '1',
  `description` text COLLATE utf8_unicode_ci,
  `panel` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_menu`
--

LOCK TABLES `sys_menu` WRITE;
/*!40000 ALTER TABLE `sys_menu` DISABLE KEYS */;
/*!40000 ALTER TABLE `sys_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_note`
--

DROP TABLE IF EXISTS `sys_note`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_note` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `res_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `res_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text COLLATE utf8_unicode_ci,
  `status` smallint(6) DEFAULT '1',
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_note`
--

LOCK TABLES `sys_note` WRITE;
/*!40000 ALTER TABLE `sys_note` DISABLE KEYS */;
/*!40000 ALTER TABLE `sys_note` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_note_log`
--

DROP TABLE IF EXISTS `sys_note_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_note_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `note_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text COLLATE utf8_unicode_ci,
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_note_log`
--

LOCK TABLES `sys_note_log` WRITE;
/*!40000 ALTER TABLE `sys_note_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `sys_note_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_settings`
--

DROP TABLE IF EXISTS `sys_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_settings` (
  `sname` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `svalue` text COLLATE utf8_unicode_ci,
  `svalues` text COLLATE utf8_unicode_ci,
  `sintro` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `stype` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  `smodule` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`sname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_settings`
--

LOCK TABLES `sys_settings` WRITE;
/*!40000 ALTER TABLE `sys_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `sys_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tag`
--

DROP TABLE IF EXISTS `tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `num` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tag`
--

LOCK TABLES `tag` WRITE;
/*!40000 ALTER TABLE `tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tag_rel`
--

DROP TABLE IF EXISTS `tag_rel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tag_rel` (
  `tag_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `res_id` int(11) DEFAULT NULL,
  `res_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tag_rel`
--

LOCK TABLES `tag_rel` WRITE;
/*!40000 ALTER TABLE `tag_rel` DISABLE KEYS */;
/*!40000 ALTER TABLE `tag_rel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `task`
--

DROP TABLE IF EXISTS `task`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cate_id` int(11) DEFAULT NULL,
  `res_name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `res_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_rel_id` int(11) DEFAULT NULL,
  `op_id` int(11) DEFAULT NULL,
  `title` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci,
  `pre_finish` datetime DEFAULT NULL,
  `finish` datetime DEFAULT NULL,
  `status` smallint(2) DEFAULT '1',
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task`
--

LOCK TABLES `task` WRITE;
/*!40000 ALTER TABLE `task` DISABLE KEYS */;
/*!40000 ALTER TABLE `task` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `task_goods`
--

DROP TABLE IF EXISTS `task_goods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `info_id` int(11) DEFAULT NULL,
  `res_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `res_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_goods`
--

LOCK TABLES `task_goods` WRITE;
/*!40000 ALTER TABLE `task_goods` DISABLE KEYS */;
/*!40000 ALTER TABLE `task_goods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `task_info`
--

DROP TABLE IF EXISTS `task_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `intro` text COLLATE utf8_unicode_ci,
  `msg` text COLLATE utf8_unicode_ci,
  `msg_time` text COLLATE utf8_unicode_ci,
  `trigger` int(11) DEFAULT '1',
  `msg_type` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(6) DEFAULT '1',
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_info`
--

LOCK TABLES `task_info` WRITE;
/*!40000 ALTER TABLE `task_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `task_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `task_log`
--

DROP TABLE IF EXISTS `task_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `conent` text COLLATE utf8_unicode_ci,
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_log`
--

LOCK TABLES `task_log` WRITE;
/*!40000 ALTER TABLE `task_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `task_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `task_order`
--

DROP TABLE IF EXISTS `task_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `order_rel_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_order`
--

LOCK TABLES `task_order` WRITE;
/*!40000 ALTER TABLE `task_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `task_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `task_self`
--

DROP TABLE IF EXISTS `task_self`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_self` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci,
  `pre_finish` datetime DEFAULT NULL,
  `finish` datetime DEFAULT NULL,
  `status` smallint(2) DEFAULT '1',
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_self`
--

LOCK TABLES `task_self` WRITE;
/*!40000 ALTER TABLE `task_self` DISABLE KEYS */;
/*!40000 ALTER TABLE `task_self` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `task_user`
--

DROP TABLE IF EXISTS `task_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `info_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `default` smallint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_user`
--

LOCK TABLES `task_user` WRITE;
/*!40000 ALTER TABLE `task_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `task_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar` int(11) DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `is_staff` smallint(1) NOT NULL,
  `allowance` int(11) DEFAULT NULL,
  `allowance_updated_at` int(11) DEFAULT NULL,
  `api_token` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin','KlroUlkExNSpTlbnUOa-Ph6bB80j-oHr','$2y$13$G.v5Tj9OKgJ7EZnLyLnQ1.Zawipm/esmHgNl2SpOil0gNAnmlOqyy',NULL,'cb@163.com',NULL,NULL,10,1,NULL,NULL,'',1495981056,1495981056);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_addition`
--

DROP TABLE IF EXISTS `user_addition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_addition` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `real_name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `logins` int(11) DEFAULT NULL,
  `gender` smallint(1) DEFAULT '1',
  `birth` date DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `qq` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8_unicode_ci,
  `hobby` text COLLATE utf8_unicode_ci,
  `native_place` text COLLATE utf8_unicode_ci,
  `intro` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_addition`
--

LOCK TABLES `user_addition` WRITE;
/*!40000 ALTER TABLE `user_addition` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_addition` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_field`
--

DROP TABLE IF EXISTS `user_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pop_note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `html` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `option` text COLLATE utf8_unicode_ci,
  `default` text COLLATE utf8_unicode_ci,
  `is_show` smallint(1) DEFAULT '1',
  `order` smallint(1) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_field`
--

LOCK TABLES `user_field` WRITE;
/*!40000 ALTER TABLE `user_field` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_log`
--

DROP TABLE IF EXISTS `user_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_log` (
  `user_id` int(11) DEFAULT NULL,
  `login_date` datetime DEFAULT NULL,
  `login_ip` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_log`
--

LOCK TABLES `user_log` WRITE;
/*!40000 ALTER TABLE `user_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_token`
--

DROP TABLE IF EXISTS `user_token`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `code` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) NOT NULL,
  `type` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_token`
--

LOCK TABLES `user_token` WRITE;
/*!40000 ALTER TABLE `user_token` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_token` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wechat`
--

DROP TABLE IF EXISTS `wechat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wechat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(255) NOT NULL,
  `access_token` varchar(255) DEFAULT NULL,
  `encodingaeskey` varchar(255) DEFAULT NULL,
  `level` tinyint(2) NOT NULL COMMENT '类型：订阅号 认证主阅 服务号 服务订阅',
  `name` varchar(200) NOT NULL,
  `original` varchar(200) NOT NULL,
  `appid` varchar(100) NOT NULL,
  `appsecret` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wechat`
--

LOCK TABLES `wechat` WRITE;
/*!40000 ALTER TABLE `wechat` DISABLE KEYS */;
/*!40000 ALTER TABLE `wechat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wechat_group`
--

DROP TABLE IF EXISTS `wechat_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wechat_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wechat_group`
--

LOCK TABLES `wechat_group` WRITE;
/*!40000 ALTER TABLE `wechat_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `wechat_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wechat_menu`
--

DROP TABLE IF EXISTS `wechat_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wechat_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wid` int(11) NOT NULL,
  `main_id` int(11) NOT NULL,
  `pid` int(11) DEFAULT NULL,
  `level` smallint(6) NOT NULL DEFAULT '1',
  `code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` smallint(6) NOT NULL DEFAULT '1',
  `key` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wechat_menu`
--

LOCK TABLES `wechat_menu` WRITE;
/*!40000 ALTER TABLE `wechat_menu` DISABLE KEYS */;
/*!40000 ALTER TABLE `wechat_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wechat_menu_main`
--

DROP TABLE IF EXISTS `wechat_menu_main`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wechat_menu_main` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1普通 菜单 2个性菜单',
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  `gender` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0不限 1男 2女',
  `tag` int(11) NOT NULL DEFAULT '0' COMMENT '0不限',
  `client_platform_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0不限',
  `language` smallint(6) NOT NULL DEFAULT '0' COMMENT '0不限',
  `country` varchar(100) DEFAULT NULL COMMENT '空则不限',
  `province` varchar(100) DEFAULT NULL COMMENT '空则不限',
  `city` varchar(100) DEFAULT NULL COMMENT '空则不限',
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wechat_menu_main`
--

LOCK TABLES `wechat_menu_main` WRITE;
/*!40000 ALTER TABLE `wechat_menu_main` DISABLE KEYS */;
/*!40000 ALTER TABLE `wechat_menu_main` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wechat_tag`
--

DROP TABLE IF EXISTS `wechat_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wechat_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wid` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL COMMENT '微信返回',
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wechat_tag`
--

LOCK TABLES `wechat_tag` WRITE;
/*!40000 ALTER TABLE `wechat_tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `wechat_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wechat_tag_rel`
--

DROP TABLE IF EXISTS `wechat_tag_rel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wechat_tag_rel` (
  `wid` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `openid` varchar(200) NOT NULL,
  UNIQUE KEY `wid` (`wid`,`tag_id`,`openid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wechat_tag_rel`
--

LOCK TABLES `wechat_tag_rel` WRITE;
/*!40000 ALTER TABLE `wechat_tag_rel` DISABLE KEYS */;
/*!40000 ALTER TABLE `wechat_tag_rel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wechat_token`
--

DROP TABLE IF EXISTS `wechat_token`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wechat_token` (
  `wechat_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_token` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `expire_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wechat_token`
--

LOCK TABLES `wechat_token` WRITE;
/*!40000 ALTER TABLE `wechat_token` DISABLE KEYS */;
/*!40000 ALTER TABLE `wechat_token` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wechat_user`
--

DROP TABLE IF EXISTS `wechat_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wechat_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gid` int(11) DEFAULT NULL,
  `openid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `nickname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remark` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sex` smallint(6) DEFAULT NULL,
  `language` varchar(120) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `province` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `headimgurl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subscribe` smallint(6) DEFAULT NULL,
  `subscribe_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `realname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birth` date DEFAULT NULL,
  `addr` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `openid` (`openid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wechat_user`
--

LOCK TABLES `wechat_user` WRITE;
/*!40000 ALTER TABLE `wechat_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `wechat_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-05-28 22:42:29
