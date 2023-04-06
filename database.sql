-- MySQL dump 10.15  Distrib 10.0.21-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database:
-- ------------------------------------------------------
-- Server version	5.1.45-log

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
-- Current Database: `cpgjaspt`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `jeonju` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `jeonju`;

--
-- Table structure for table `sw_admin`
--

DROP TABLE IF EXISTS `sw_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sw_admin` (
  `idx` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `buse` tinyint(4) NOT NULL DEFAULT '1',
  `grplv` int(3) NOT NULL,
  `admid` varchar(30) NOT NULL,
  `admpw` varchar(255) NOT NULL,
  `name` varchar(30) NOT NULL,
  `nick` varchar(100) NOT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `hp` varchar(20) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `logdt` datetime DEFAULT NULL,
  `vcnt` int(3) DEFAULT '0',
  `memo` text,
  `photo` varchar(255) NOT NULL,
  `regdt` datetime DEFAULT NULL,
  PRIMARY KEY (`idx`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sw_admin`
--

LOCK TABLES `sw_admin` WRITE;
/*!40000 ALTER TABLE `sw_admin` DISABLE KEYS */;
INSERT INTO `sw_admin` VALUES (1,1,100,'admin','*4ACFE3202A5FF5CF467898FC58AAB1D615029441','관리자','관리자','','1111111','','2020-07-29 14:17:16',22,'','member05913_0.jpg','2017-05-15 13:12:03');
/*!40000 ALTER TABLE `sw_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sw_admlv`
--

DROP TABLE IF EXISTS `sw_admlv`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sw_admlv` (
  `idx` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lv` int(3) NOT NULL,
  `name` varchar(100) NOT NULL,
  `auth1` varchar(200) NOT NULL,
  `auth2` varchar(200) NOT NULL,
  `regdt` datetime DEFAULT NULL,
  PRIMARY KEY (`idx`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sw_admlv`
--

LOCK TABLES `sw_admlv` WRITE;
/*!40000 ALTER TABLE `sw_admlv` DISABLE KEYS */;
/*!40000 ALTER TABLE `sw_admlv` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sw_bank`
--

DROP TABLE IF EXISTS `sw_bank`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sw_bank` (
  `idx` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `buse` enum('Y','N') DEFAULT 'Y',
  `banknm` varchar(30) NOT NULL,
  `banknum` varchar(30) NOT NULL,
  `bankown` varchar(30) NOT NULL,
  `regdt` datetime DEFAULT NULL,
  PRIMARY KEY (`idx`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sw_bank`
--

LOCK TABLES `sw_bank` WRITE;
/*!40000 ALTER TABLE `sw_bank` DISABLE KEYS */;
/*!40000 ALTER TABLE `sw_bank` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sw_banner`
--

DROP TABLE IF EXISTS `sw_banner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sw_banner` (
  `idx` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NOT NULL,
  `buse` enum('Y','N') DEFAULT 'N',
  `name` varchar(100) NOT NULL,
  `sday` varchar(10) DEFAULT NULL,
  `eday` varchar(10) DEFAULT NULL,
  `img` varchar(30) DEFAULT NULL,
  `target` varchar(10) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `regdt` datetime DEFAULT NULL,
  PRIMARY KEY (`idx`),
  KEY `iidx` (`code`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sw_banner`
--

LOCK TABLES `sw_banner` WRITE;
/*!40000 ALTER TABLE `sw_banner` DISABLE KEYS */;
INSERT INTO `sw_banner` VALUES (1,'','Y','테스트배너','2020-07-19','2020-08-31','design81211_0.png','_blank','http://www.naver.com','2020-07-30 15:37:10');
/*!40000 ALTER TABLE `sw_banner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sw_banner_grp`
--

DROP TABLE IF EXISTS `sw_banner_grp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sw_banner_grp` (
  `idx` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `regdt` datetime DEFAULT NULL,
  PRIMARY KEY (`idx`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sw_banner_grp`
--

LOCK TABLES `sw_banner_grp` WRITE;
/*!40000 ALTER TABLE `sw_banner_grp` DISABLE KEYS */;
INSERT INTO `sw_banner_grp` VALUES (1,'main','main','2020-07-30 15:18:44');
/*!40000 ALTER TABLE `sw_banner_grp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sw_board`
--

DROP TABLE IF EXISTS `sw_board`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sw_board` (
  `idx` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NOT NULL,
  `hit` int(3) DEFAULT '0',
  `isadm` tinyint(4) DEFAULT '0',
  `userid` varchar(30) DEFAULT NULL,
  `pwd` varchar(30) DEFAULT NULL,
  `name` varchar(30) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `subtitle` varchar(255) NOT NULL,
  `sday` varchar(20) DEFAULT NULL,
  `eday` varchar(20) DEFAULT NULL,
  `eday_time` int(11) NOT NULL,
  `email` varchar(60) DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `home` varchar(100) DEFAULT NULL,
  `bLock` enum('Y','N') DEFAULT 'N',
  `lockid` varchar(30) DEFAULT NULL,
  `notice` enum('Y','N') DEFAULT 'N',
  `notice2` enum('Y','N') NOT NULL DEFAULT 'N',
  `ip` varchar(20) DEFAULT NULL,
  `cate` varchar(30) DEFAULT NULL,
  `ref` int(11) NOT NULL,
  `re_step` int(11) NOT NULL,
  `re_level` int(11) NOT NULL,
  `content` longtext,
  `regdt` datetime DEFAULT NULL,
  `updt` datetime DEFAULT NULL,
  `singo` int(11) NOT NULL COMMENT '1:신고 0:정상',
  `nprice` int(7) NOT NULL COMMENT '소비자가',
  `price` int(7) NOT NULL COMMENT '판매가',
  `url` varchar(255) NOT NULL COMMENT '링크',
  `goods` int(11) NOT NULL COMMENT '좋아요',
  `buse` enum('Y','N') NOT NULL DEFAULT 'Y' COMMENT 'Y:정상 N:숨김',
  `wr_1` varchar(20) NOT NULL,
  `wr_2` varchar(50) NOT NULL,
  `wr_3` varchar(50) NOT NULL,
  `re_content` longtext NOT NULL,
  `status` enum('Y','N') DEFAULT 'N',
  `keyword` varchar(200) NOT NULL,
  PRIMARY KEY (`idx`),
  KEY `iidx1` (`code`),
  KEY `idx` (`idx`),
  KEY `code` (`code`),
  KEY `idx_2` (`idx`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sw_board`
--

LOCK TABLES `sw_board` WRITE;
/*!40000 ALTER TABLE `sw_board` DISABLE KEYS */;
INSERT INTO `sw_board` VALUES (1,'1595387768',26,0,'admin@admin.com','','마스터관리자','체험넷 홈페이지가 오픈했습니다','','','',0,'',NULL,'','N','admin@admin.com','Y','N','1.212.109.221','',1,0,0,'<p>체험넷 홈페이지가 오픈했습니다&nbsp;</p><p>&nbsp;</p><p>많은 이용 바랍니다</p>','2020-08-17 13:46:07',NULL,0,0,0,'',0,'Y','','','','','N',''),(2,'1595387795',6,0,'admin@admin.com','','마스터관리자','예약은 비회원도 가능한가요 ?','','','',0,'',NULL,'','N','admin@admin.com','N','N','1.212.109.221','',2,0,0,'<p>안녕하세요 체험넷 입니다.</p><p>&nbsp;</p><p>현재 예약은 회원 / 비회원 둘다 이용가능합니다.</p>','2020-08-17 13:47:29',NULL,0,0,0,'',0,'Y','','','','','N',''),(3,'1595387805',12,0,'test1@test.com','0000','김종국','문의입니다','',NULL,NULL,0,'','--',NULL,'N','test1@test.com','N','N','1.212.109.219','',3,0,0,'<p>잘못 신청했는데 환불하고 싶습니다.</p>','2020-08-17 15:23:36',NULL,0,0,0,'',0,'Y','','','','','N',''),(8,'1595387795',7,0,'admin@admin.com','','마스터관리자','상품 구성이 어떤식으로 이루어져있나요?','','','',0,'',NULL,'','N','admin@admin.com','N','N','1.212.109.221','',5,0,0,'<p>안녕하세요 체험넷입니다. </p><p>&nbsp;</p><p>일반 입장권으로 이루어진상품부터 교통 및 숙소까지 포함된 상품까지 다양하게 구성되어있습니다. </p><p>&nbsp;</p><p>감사합니다. &nbsp;</p>','2020-08-18 11:37:25',NULL,0,0,0,'',0,'N','','','','','N',''),(7,'1595387768',15,0,'admin@admin.com','','마스터관리자','체험넷 웹사이트 오픈이벤트 상품준비중','','','',0,'',NULL,'','N','admin@admin.com','N','N','1.212.109.221','',4,0,0,'<p>체험넷 웹사이트 오픈기념 </p><p>&nbsp;</p><p>이벤트 상품이 곧 출시됩니다. </p><p>&nbsp;</p><p>감사합니다. &nbsp;</p>','2020-08-18 11:28:04',NULL,0,0,0,'',0,'N','','','','','N',''),(9,'1595387795',2,0,'admin@admin.com','','마스터관리자','결제는 어떻게 하나요?','','','',0,'',NULL,'','N','admin@admin.com','N','N','1.212.109.219','',6,0,0,'<p>안녕하세요 체험넷입니다.</p><p>결제는 홈페이지에서 예약을 먼저 진행하신 후</p><p>표기된 계좌번호로 입금해주시면 접수 및 입금 확인 후 예약을 승인해드리고 있습니다.&nbsp;</p>','2020-08-20 09:44:44',NULL,0,0,0,'',0,'N','','','','','N',''),(10,'1595387768',0,0,'admin@admin.com','','마스터관리자','[긴급공지사항]','','','',0,'',NULL,'','N','admin@admin.com','Y','N','1.212.109.221','',7,0,0,'<p>[한화와 함께하는 서울세계불꽃축제]</p><p>현재 기상악화로 인해 금일 예정이었던 [한화와 함께하는 서울세계불꽃축제]가 긴급 취소되었습니다.</p><p>예약을 하신 고객분들께서는 예약취소를 요청 드리며,</p><p>결제를 하신 고객분들께서는 금일 이내에 결제금액을 환불해드릴 예정입니다.</p><p>금일 16시까지 환불을 받지 못한 고객분들은 체험넷 고객센터에 문의 바랍니다.</p><p>&nbsp;</p><p>이상입니다.</p>','2020-08-25 14:15:54',NULL,0,0,0,'',0,'N','','','','','N','');
/*!40000 ALTER TABLE `sw_board` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sw_board_cnf`
--

DROP TABLE IF EXISTS `sw_board_cnf`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sw_board_cnf` (
  `idx` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NOT NULL,
  `name` varchar(30) NOT NULL,
  `part` tinyint(4) NOT NULL,
  `lAct` tinyint(4) DEFAULT '0',
  `rAct` tinyint(4) DEFAULT '0',
  `wAct` tinyint(4) DEFAULT '0',
  `cAct` tinyint(4) DEFAULT '0',
  `bspam` enum('Y','N') DEFAULT 'N',
  `path` varchar(100) DEFAULT NULL,
  `cutstr` int(3) DEFAULT NULL,
  `vlimit` int(3) DEFAULT NULL,
  `period` tinyint(4) DEFAULT '1',
  `thumW` int(3) DEFAULT NULL,
  `thumH` int(3) DEFAULT NULL,
  `lsimg` tinyint(4) DEFAULT '0',
  `imgclk` tinyint(4) DEFAULT '0',
  `vtype` tinyint(4) DEFAULT '0',
  `vip` tinyint(4) DEFAULT '0',
  `bCom` tinyint(4) DEFAULT '0',
  `breply` tinyint(4) DEFAULT '0',
  `bsecret` tinyint(4) DEFAULT '0',
  `bnotice` tinyint(4) DEFAULT '0',
  `beditor` tinyint(4) DEFAULT '1',
  `upcnt` tinyint(4) DEFAULT NULL,
  `bemail` tinyint(4) DEFAULT '0',
  `btel` tinyint(4) DEFAULT '0',
  `bhome` tinyint(4) DEFAULT '0',
  `bevent` tinyint(4) DEFAULT '0',
  `bcate` tinyint(4) DEFAULT '0',
  `scate` varchar(255) DEFAULT NULL,
  `hhtml` text,
  `fhtml` text,
  `regdt` datetime DEFAULT NULL,
  `tcate` tinyint(4) DEFAULT '0',
  `seq` int(11) NOT NULL DEFAULT '0',
  `push` enum('Y','N') NOT NULL DEFAULT 'Y',
  `icon` varchar(255) NOT NULL,
  PRIMARY KEY (`idx`),
  KEY `iidx` (`code`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sw_board_cnf`
--

LOCK TABLES `sw_board_cnf` WRITE;
/*!40000 ALTER TABLE `sw_board_cnf` DISABLE KEYS */;
INSERT INTO `sw_board_cnf` VALUES (1,'1595387768','알려드려요',10,0,0,90,0,'N','/community/notice.php',45,20,1,0,0,0,0,0,0,0,0,0,1,1,3,0,0,0,0,0,'','','','2020-07-22 12:16:18',0,0,'Y',''),(2,'1595387784','이벤트',10,0,0,0,0,'N','/community/event.php',45,20,1,0,0,0,0,0,0,1,0,0,0,1,1,0,0,0,0,0,'','','','2020-07-22 12:16:29',0,0,'Y',''),(3,'1595387795','FAQ',30,0,0,0,0,'N','/community/faq.php',45,20,1,0,0,0,0,0,0,0,0,0,0,1,1,0,0,0,0,0,'','','','2020-07-22 12:16:40',0,0,'Y',''),(4,'1595387805','1:1 문의',20,0,0,1,0,'N','/community/qna.php',45,20,1,0,0,0,0,0,0,0,1,0,0,1,1,0,0,0,0,0,'','','','2020-07-22 12:16:51',0,0,'Y','');
/*!40000 ALTER TABLE `sw_board_cnf` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sw_boardfile`
--

DROP TABLE IF EXISTS `sw_boardfile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sw_boardfile` (
  `idx` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NOT NULL,
  `bidx` int(11) NOT NULL,
  `upfile` varchar(30) NOT NULL,
  `upreal` varchar(100) DEFAULT NULL,
  `ftype` varchar(10) DEFAULT NULL,
  `fsize` int(3) DEFAULT NULL,
  `dcnt` int(3) DEFAULT NULL,
  `regdt` datetime DEFAULT NULL,
  `filetype` tinyint(4) DEFAULT NULL COMMENT '1:이미지 ,2:동영상',
  PRIMARY KEY (`idx`),
  KEY `iidx1` (`code`),
  KEY `iidx2` (`bidx`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sw_boardfile`
--

LOCK TABLES `sw_boardfile` WRITE;
/*!40000 ALTER TABLE `sw_boardfile` DISABLE KEYS */;
INSERT INTO `sw_boardfile` VALUES (4,'',3,'board44492_0.jpg','img_SRIFRI_A1_00124_24_164459268.jpg','image',3006112,NULL,'2020-08-17 15:08:12',1),(5,'',2,'board44503_0.jpg','g-0809.jpg.thumb.768.768.jpg','image',92425,NULL,'2020-08-17 15:08:23',1),(6,'3',10,'board45653_0.jpg','img_SRIFRI_A1_00124_24_164459268.jpg','image',3006112,0,'2020-08-17 15:27:34',1);
/*!40000 ALTER TABLE `sw_boardfile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sw_booking`
--

DROP TABLE IF EXISTS `sw_booking`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sw_booking` (
  `idx` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(100) DEFAULT NULL,
  `useridx` int(11) NOT NULL,
  `gidx` int(11) NOT NULL COMMENT '상품idx',
  `AccountName` varchar(30) NOT NULL COMMENT '예금주명',
  `AccountPhone` varchar(255) NOT NULL COMMENT '예금주연락처',
  `name` varchar(50) NOT NULL COMMENT '예약자명',
  `phone` varchar(100) NOT NULL COMMENT '예약자연락처',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:접수,2:입금대기,3:결제완료',
  `regdt` datetime DEFAULT NULL,
  `updt` datetime DEFAULT NULL,
  `std` datetime DEFAULT NULL,
  `enddt` datetime DEFAULT NULL,
  `add1` varchar(50) NOT NULL,
  `add2` varchar(50) NOT NULL,
  PRIMARY KEY (`idx`),
  KEY `gidx` (`gidx`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sw_booking`
--

LOCK TABLES `sw_booking` WRITE;
/*!40000 ALTER TABLE `sw_booking` DISABLE KEYS */;
INSERT INTO `sw_booking` VALUES (8,'JRG35X4A',1,4,'마스터관리자','01012345555','마스터관리자','01012345555',1,'2020-08-18 10:50:09',NULL,'2020-09-30 00:00:00','2020-09-30 00:00:00','7','16'),(7,'8SK4L43L',1,4,'해피누나','000-0000-000','마스터관리자','01012345555',1,'2020-08-18 09:36:36',NULL,'2020-09-30 00:00:00','2020-10-01 00:00:00','6','15'),(4,'4S4A9V98',24,4,'최영','01096607520','최영','01096607520',1,'2020-08-17 16:10:44',NULL,NULL,NULL,'',''),(6,'37488429',0,4,'홍길동','01012345678','홍길동','01012345678',1,'2020-08-17 16:40:29',NULL,'2020-09-30 00:00:00','2020-09-30 00:00:00','4','12'),(9,'4J77XSZ6',25,3,'강유리','010-3347-9628','강유리','010-3347-9628',1,'2020-08-18 11:13:13',NULL,'2020-10-07 00:00:00','2020-10-15 00:00:00','10','14'),(10,'08X07NG7',0,1,'ssssssssssssssssssss','000555','ssssssssssssssssssss','000555',1,'2020-08-18 15:08:01',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','','16'),(11,'D1PE6037',1,3,'마스터ㅇㅇㅇ관리자','01012345555','마스터ㅇㅇㅇ관리자','01012345555',1,'2020-08-18 18:25:22',NULL,'2020-08-16 00:00:00','2020-08-10 00:00:00','','15'),(12,'EV8AG26R',0,4,'최영','010-9660-7520','최영','010-9660-7520',1,'2020-08-18 18:27:08',NULL,'2020-10-01 00:00:00','2020-10-05 00:00:00','5','99'),(13,'OQ88KX5B',1,2,'마스터관리ㅇㅇㅇㅇ자','010-1234-5555','마스터관리ㅇㅇㅇㅇ자','010-1234-5555',1,'2020-08-18 18:28:52',NULL,'2020-08-11 00:00:00','2020-08-01 00:00:00','','12'),(14,'737459VX',1,4,'마스터관리자','01012345555','마스터관리자','01012345555',1,'2020-08-18 18:30:13',NULL,'2020-08-04 00:00:00','2020-08-02 00:00:00','5','13'),(15,'G3GZ5A59',1,4,'test','010-1234-5678','마스터관리자','01012345555',99,'2020-08-18 19:00:48','2020-08-19 00:01:40','2020-09-30 00:00:00','2020-10-01 00:00:00','2','10'),(16,'1I0ZT7GF',0,4,'test2','011-2345-6789','test','010-1234-5678',1,'2020-08-18 19:01:26',NULL,'2020-09-30 00:00:00','2020-09-30 00:00:00','2','11'),(17,'5YL06K57',26,4,'오승원','010-4856-7435','오승원','01048567435',1,'2020-08-21 12:27:19',NULL,'2020-10-01 00:00:00','2020-09-30 00:00:00','2','9'),(18,'7K5W9J70',1,2,'김아무','010-1234-5555','김아무','010-1234-5555',1,'2020-08-25 13:42:41',NULL,'2020-08-31 00:00:00','2020-08-31 00:00:00','2','13');
/*!40000 ALTER TABLE `sw_booking` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sw_calendar`
--

DROP TABLE IF EXISTS `sw_calendar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sw_calendar` (
  `idx` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NOT NULL,
  `admid` varchar(20) NOT NULL,
  `cdate` date NOT NULL,
  `sday` date DEFAULT NULL,
  `eday` date DEFAULT NULL,
  `stime` varchar(5) DEFAULT NULL,
  `etime` varchar(5) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `regdt` datetime DEFAULT NULL,
  PRIMARY KEY (`idx`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sw_calendar`
--

LOCK TABLES `sw_calendar` WRITE;
/*!40000 ALTER TABLE `sw_calendar` DISABLE KEYS */;
/*!40000 ALTER TABLE `sw_calendar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sw_category`
--

DROP TABLE IF EXISTS `sw_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sw_category` (
  `idx` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `seq` int(3) NOT NULL,
  `code` char(12) NOT NULL,
  `pcode` char(12) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `buse` tinyint(4) NOT NULL DEFAULT '1',
  `titimg` varchar(30) DEFAULT NULL,
  `topimg` varchar(30) DEFAULT NULL,
  `setting` varchar(50) NOT NULL,
  `price` varchar(50) NOT NULL,
  `regdt` datetime DEFAULT NULL,
  PRIMARY KEY (`idx`),
  KEY `iidx` (`code`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sw_category`
--

LOCK TABLES `sw_category` WRITE;
/*!40000 ALTER TABLE `sw_category` DISABLE KEYS */;
INSERT INTO `sw_category` VALUES (1,1,'001','0','일상체험',1,'','','','','2020-07-20 16:36:20'),(2,2,'002','0','취미체험',1,'','','','','2020-07-20 16:36:30'),(3,3,'003','0','가족체험',1,'','','','','2020-07-20 16:36:37'),(4,4,'004','0','여행체험',1,'','','','','2020-07-20 16:37:21'),(5,1,'001001','001','일상체험',1,'','','','','2020-07-20 17:36:22'),(6,1,'002001','002','취미체험',1,'','','','','2020-07-20 17:36:28');
/*!40000 ALTER TABLE `sw_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sw_comment`
--

DROP TABLE IF EXISTS `sw_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sw_comment` (
  `idx` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NOT NULL,
  `bidx` int(11) NOT NULL,
  `isadm` tinyint(4) DEFAULT '0',
  `userid` varchar(30) DEFAULT NULL,
  `pwd` varchar(30) DEFAULT NULL,
  `name` varchar(30) NOT NULL,
  `bLock` enum('Y','N') DEFAULT 'N',
  `comment` text,
  `photo` varchar(255) NOT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `regdt` datetime DEFAULT NULL,
  `wr_comment_reply` varchar(5) NOT NULL,
  `wr_comment` int(4) DEFAULT '0',
  PRIMARY KEY (`idx`),
  KEY `iidx1` (`code`),
  KEY `iidx2` (`bidx`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sw_comment`
--

LOCK TABLES `sw_comment` WRITE;
/*!40000 ALTER TABLE `sw_comment` DISABLE KEYS */;
INSERT INTO `sw_comment` VALUES (6,'1595387784',32,0,'test1@test.com','','김종국','N','그러게말입니다','','1.212.109.219','2020-08-12 11:42:09','',0),(7,'1595387784',32,0,'test1@test.com','','김종국','N','해당란에 로그인 사용자는 닉네임이 잘 뜨고 비로그인 사용자는 아무것도 안뜸','','1.212.109.219','2020-08-12 11:42:41','',0);
/*!40000 ALTER TABLE `sw_comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sw_config`
--

DROP TABLE IF EXISTS `sw_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sw_config` (
  `idx` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `upoint` enum('Y','N') DEFAULT 'Y',
  `punit` enum('Y','N') DEFAULT 'Y',
  `point` int(3) DEFAULT '0',
  `hpoint` int(3) DEFAULT '0',
  `minpoint` int(3) DEFAULT '0',
  `maxpoint` int(3) DEFAULT '0',
  `maxrefund` int(3) DEFAULT '0',
  `jbuse` enum('Y','N') DEFAULT 'N' COMMENT '댓글포인트 사용여부',
  `jcash` int(3) DEFAULT '0' COMMENT '댓글포인트',
  `bbuse` enum('Y','N') DEFAULT 'N' COMMENT '게시글 포인트사용여부',
  `bcash` int(3) DEFAULT '0' COMMENT '게시글 포인트',
  `fbuse` enum('Y','N') DEFAULT 'N' COMMENT '출석체크 포인트사용여부',
  `fcash` int(3) DEFAULT '0' COMMENT '출석체크 포인트',
  `fbuse2` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT '하루출석',
  `fcash2` int(3) NOT NULL COMMENT '하루출석포인트',
  `fcontent` varchar(255) NOT NULL,
  `mbuse` enum('Y','N') DEFAULT 'N' COMMENT '한달출석 사용여부',
  `mcash` int(3) DEFAULT '0' COMMENT '한달출석  포인트',
  `obuse` enum('Y','N') DEFAULT 'N' COMMENT '추천포인트 사용여부',
  `ocash` int(3) DEFAULT '0' COMMENT '추천포인트',
  `ocontent` varchar(255) NOT NULL,
  `rbuse` enum('Y','N') DEFAULT 'N' COMMENT '공유 포인트사용여부',
  `rcash` int(3) DEFAULT '0' COMMENT '공유 포인트',
  `auto_cash` datetime DEFAULT NULL,
  `auto_sms` datetime DEFAULT NULL,
  `update_sale` datetime DEFAULT NULL,
  `updt` datetime DEFAULT NULL,
  `link1` varchar(255) NOT NULL COMMENT '카카오톡',
  `link2` varchar(255) NOT NULL COMMENT '네이버카페',
  `link3` varchar(255) NOT NULL COMMENT '카카오스토리',
  `link4` varchar(255) NOT NULL,
  `recomcon` text NOT NULL,
  `recomtitle` varchar(255) NOT NULL,
  PRIMARY KEY (`idx`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sw_config`
--

LOCK TABLES `sw_config` WRITE;
/*!40000 ALTER TABLE `sw_config` DISABLE KEYS */;
INSERT INTO `sw_config` VALUES (1,'Y','N',0,0,1000,3000,20000,'Y',10,'Y',50,'Y',200,'Y',10,'2주 연속 출석체크: 200p 지급! 한 달 전체 출석체크: 500p지급!\r\n','Y',500,'Y',100,'','Y',50,'2020-07-21 08:43:31','2020-07-21 08:43:31',NULL,'2017-12-18 01:12:49','http://pf.kakao.com/_FgAsd','http://cafe.naver.com','https://story.kakao.com/ch/kakaostory','','체험넷 ','체험넷 ');
/*!40000 ALTER TABLE `sw_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sw_counter`
--

DROP TABLE IF EXISTS `sw_counter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sw_counter` (
  `idx` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `year` smallint(4) NOT NULL,
  `mon` tinyint(2) NOT NULL,
  `day` tinyint(2) NOT NULL,
  `hour` tinyint(2) NOT NULL,
  `week` tinyint(1) NOT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `osgrp` varchar(20) DEFAULT NULL,
  `os` varchar(20) DEFAULT NULL,
  `brogrp` varchar(20) DEFAULT NULL,
  `brower` varchar(20) DEFAULT NULL,
  `site` varchar(50) DEFAULT NULL,
  `referer` varchar(200) DEFAULT NULL,
  `agent` varchar(255) DEFAULT NULL,
  `regdt` datetime DEFAULT NULL,
  PRIMARY KEY (`idx`)
) ENGINE=MyISAM AUTO_INCREMENT=168 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sw_counter`
--

LOCK TABLES `sw_counter` WRITE;
/*!40000 ALTER TABLE `sw_counter` DISABLE KEYS */;
INSERT INTO `sw_counter` VALUES (1,2020,8,18,9,2,'1.212.109.221','MAC','MAC','Chrome','Chrome','','','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36','2020-08-18 09:58:14'),(2,2020,8,18,10,2,'220.124.102.104','Mozilla','Mozilla','Chrome','Chrome','','http://cpgjaspt.cafe24.com/community/event.php','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36','2020-08-18 10:06:33'),(3,2020,8,18,10,2,'220.124.102.104','Mozilla','Mozilla','Safari','Safari','','','Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; rv:11.0) like Gecko','2020-08-18 10:22:08'),(4,2020,8,18,10,2,'220.124.102.104','Mozilla','Mozilla','Chrome','Chrome','','','Mozilla/5.0 (Windows NT 10.0; Win64; x64; Cortana 1.14.0.19041; 10.0.0.0.19041.450) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.102 Safari/537.36 Edge/18.19041','2020-08-18 10:25:10'),(5,2020,8,18,10,2,'220.124.102.104','Mozilla','Mozilla','Chrome','Chrome','','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.106 Whale/2.8.105.22 Safari/537.36','2020-08-18 10:25:15'),(6,2020,8,18,10,2,'220.124.102.104','Others','기타','Others','Others','','','NateOn/7.0.1.1 (4991)','2020-08-18 10:53:46'),(7,2020,8,18,10,2,'1.212.109.221','Others','기타','Others','Others','','','NateOn/7.0.1.0 (4991)','2020-08-18 10:53:46'),(8,2020,8,18,10,2,'1.212.109.221','Windows7','Windows7','Safari','Safari','','','Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko','2020-08-18 10:53:50'),(9,2020,8,18,10,2,'203.226.253.198','Others','기타','Others','Others','','','Java/1.8.0_162','2020-08-18 10:53:50'),(10,2020,8,18,10,2,'1.212.109.221','Windows7','Windows7','Chrome','Chrome','','','Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36','2020-08-18 10:57:02'),(11,2020,8,18,11,2,'1.212.109.219','Mozilla','Mozilla','Safari','Safari','','','Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; rv:11.0) like Gecko','2020-08-18 11:40:25'),(12,2020,8,18,11,2,'220.124.102.104','Mozilla','Mozilla','Safari','Safari','','','Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; rv:11.0) like Gecko','2020-08-18 11:41:40'),(13,2020,8,18,11,2,'1.212.109.219','Mozilla','Mozilla','Chrome','Chrome','','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36','2020-08-18 11:44:33'),(14,2020,8,18,11,2,'1.212.109.219','Mozilla','Mozilla','Safari','Safari','','','Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; Touch; rv:11.0) like Gecko','2020-08-18 11:47:20'),(15,2020,8,18,12,2,'1.212.109.219','Mozilla','Mozilla','Chrome','Chrome','','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36','2020-08-18 12:11:32'),(16,2020,8,18,12,2,'1.212.109.219','Mozilla','Mozilla','Chrome','Chrome','','','Mozilla/5.0 (Windows NT 10.0; Win64; x64; Cortana 1.14.0.19041; 10.0.0.0.19041.450) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.102 Safari/537.36 Edge/18.19041','2020-08-18 12:16:56'),(17,2020,8,18,12,2,'1.212.109.222','MAC','MAC','Chrome','Chrome','','','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.106 Whale/2.8.105.22 Safari/537.36','2020-08-18 12:23:44'),(18,2020,8,18,15,2,'1.212.109.221','Windows7','Windows7','Safari','Safari','','','Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko','2020-08-18 15:03:16'),(19,2020,8,18,15,2,'220.124.102.104','Mozilla','Mozilla','Safari','Safari','','http://cpgjaspt.cafe24.com/common/private.php','Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; rv:11.0) like Gecko','2020-08-18 15:18:23'),(20,2020,8,18,15,2,'1.212.109.219','Mozilla','Mozilla','Chrome','Chrome','','','Mozilla/5.0 (Windows NT 10.0; Win64; x64; Cortana 1.14.0.19041; 10.0.0.0.19041.450) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.102 Safari/537.36 Edge/18.19041','2020-08-18 15:27:30'),(21,2020,8,18,15,2,'1.212.109.219','Mozilla','Mozilla','Safari','Safari','','','Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; rv:11.0) like Gecko','2020-08-18 15:27:44'),(22,2020,8,18,15,2,'1.212.109.219','Mozilla','Mozilla','Chrome','Chrome','','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36','2020-08-18 15:28:56'),(23,2020,8,18,15,2,'1.212.109.219','Mozilla','Mozilla','Safari','Safari','','','Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; Touch; rv:11.0) like Gecko','2020-08-18 15:29:07'),(24,2020,8,18,16,2,'1.212.109.222','Linux','Linux','Chrome','Chrome','','','Mozilla/5.0 (Linux; Android 9; SM-N950N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Mobile Safari/537.36','2020-08-18 16:05:05'),(25,2020,8,18,18,2,'1.212.109.221','MAC','MAC','Chrome','Chrome','','','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36','2020-08-18 18:07:24'),(26,2020,8,18,18,2,'211.249.201.138','Others','기타','Others','Others','','','facebookexternalhit/1.1; kakaotalk-scrap/1.0; +https://devtalk.kakao.com/t/scrap/33984','2020-08-18 18:10:33'),(27,2020,8,18,18,2,'1.212.109.221','Others','기타','Others','Others','','','NateOn/7.0.1.0 (4991)','2020-08-18 18:25:59'),(28,2020,8,18,18,2,'1.212.109.221','Others','기타','Others','Others','','','NTWebPageAssist/1.0','2020-08-18 18:25:59'),(29,2020,8,18,18,2,'203.226.253.198','Others','기타','Others','Others','','','Java/1.8.0_162','2020-08-18 18:26:07'),(30,2020,8,18,18,2,'117.52.140.112','Others','기타','Others','Others','','','bandscraper ( facebookexternalhit/1.1 )','2020-08-18 18:26:09'),(31,2020,8,18,18,2,'1.212.109.221','Windows7','Windows7','Chrome','Chrome','','','Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36','2020-08-18 18:26:12'),(32,2020,8,18,18,2,'175.223.30.178','Linux','Linux','Chrome','Chrome','','','Mozilla/5.0 (Linux; Android 10; SM-G965N Build/QP1A.190711.020; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/84.0.4147.125 Mobile Safari/537.36;KAKAOTALK 2108970','2020-08-18 18:42:23'),(33,2020,8,18,18,2,'211.249.40.27','Others','기타','Others','Others','','','Carbon','2020-08-18 18:43:24'),(34,2020,8,18,18,2,'220.230.168.3','Mozilla','Mozilla','Safari','Safari','','','Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; rv:11.0) like Gecko','2020-08-18 18:43:24'),(35,2020,8,18,18,2,'220.124.102.104','Mozilla','Mozilla','Safari','Safari','','http://cpgjaspt.cafe24.com/member/login.php','Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; rv:11.0) like Gecko','2020-08-18 18:44:31'),(36,2020,8,18,18,2,'1.212.109.221','MAC','MAC','Safari','Safari','','http://cpgjaspt.cafe24.com/community/faq.php','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.1.2 Safari/605.1.15','2020-08-18 18:55:23'),(37,2020,8,18,19,2,'220.124.102.104','Mozilla','Mozilla','Safari','Safari','','','Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; rv:11.0) like Gecko','2020-08-18 19:30:16'),(38,2020,8,18,19,2,'211.249.204.129','Others','기타','Others','Others','','','facebookexternalhit/1.1; kakaotalk-scrap/1.0; +https://devtalk.kakao.com/t/scrap/33984','2020-08-18 19:30:49'),(39,2020,8,18,19,2,'223.33.180.221','MAC','MAC','Safari','Safari','','','Mozilla/5.0 (iPhone; CPU iPhone OS 13_6_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.1.2 Mobile/15E148 Safari/604.1','2020-08-18 19:40:00'),(40,2020,8,18,20,2,'218.237.8.42','Mozilla','Mozilla','Chrome','Chrome','','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36','2020-08-18 20:34:15'),(41,2020,8,18,20,2,'218.237.8.42','Mozilla','Mozilla','Safari','Safari','','http://cpgjaspt.cafe24.com/common/contract.php','Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; rv:11.0) like Gecko','2020-08-18 20:35:38'),(42,2020,8,19,8,3,'220.124.102.104','Mozilla','Mozilla','Chrome','Chrome','','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36','2020-08-19 08:48:44'),(43,2020,8,19,8,3,'64.233.172.244','Linux','Linux','Chrome','Chrome','','','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36 Google Favicon','2020-08-19 08:52:12'),(44,2020,8,19,9,3,'182.216.161.118','Mozilla','Mozilla','Chrome','Chrome','','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36','2020-08-19 09:13:52'),(45,2020,8,19,9,3,'182.216.161.118','Mozilla','Mozilla','Chrome','Chrome','','http://203.233.19.54/tm/?a=CR&b=WIN&c=799003835494&d=10003&e=2061&f=Y3BnamFzcHQuY2FmZTI0LmNvbQ==&g=1597796033449&h=1597796033569&y=0&z=0&x=1&w=2020-03-24&in=2061_0913_00001302&id=20200819','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36','2020-08-19 09:13:54'),(46,2020,8,19,10,3,'1.212.109.222','MAC','MAC','Chrome','Chrome','','','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.106 Whale/2.8.105.22 Safari/537.36','2020-08-19 10:18:27'),(47,2020,8,19,10,3,'110.70.47.193','MAC','MAC','Safari','Safari','','','Mozilla/5.0 (iPad; CPU OS 13_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 BAND/8.0.1 (iOS 13.6; iPad6,3)','2020-08-19 10:57:38'),(48,2020,8,19,10,3,'110.70.47.193','MAC','MAC','Safari','Safari','','','Mozilla/5.0 (iPad; CPU OS 13_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 BAND/8.0.1 (iOS 13.6; iPad6,3)','2020-08-19 10:58:09'),(49,2020,8,19,11,3,'211.176.125.70','Windows8','Windows8','MSIE 10.0','MSIE 10.0','','','Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Trident/6.0)','2020-08-19 11:18:34'),(50,2020,8,19,12,3,'121.186.208.221','Mozilla','Mozilla','Chrome','Chrome','','','Mozilla/5.0 (Windows NT 10.0; Win64; x64; ; NCLIENT50_AAP552E5CC17B2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36','2020-08-19 12:36:16'),(51,2020,8,19,16,3,'220.124.102.104','Mozilla','Mozilla','Safari','Safari','','','Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; rv:11.0) like Gecko','2020-08-19 16:05:38'),(52,2020,8,19,16,3,'1.212.109.219','Mozilla','Mozilla','Chrome','Chrome','','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36','2020-08-19 16:10:19'),(53,2020,8,19,16,3,'1.212.109.219','Mozilla','Mozilla','Safari','Safari','','','Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; Touch; rv:11.0) like Gecko','2020-08-19 16:20:22'),(54,2020,8,19,17,3,'1.212.109.219','Mozilla','Mozilla','Chrome','Chrome','','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36','2020-08-19 17:54:53'),(55,2020,8,19,17,3,'1.212.109.219','Mozilla','Mozilla','Safari','Safari','','http://cpgjaspt.cafe24.com/member/login.act.php','Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; rv:11.0) like Gecko','2020-08-19 17:56:09'),(56,2020,8,19,18,3,'1.212.109.219','Mozilla','Mozilla','Chrome','Chrome','','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36','2020-08-19 18:21:47'),(57,2020,8,19,18,3,'1.212.109.219','Mozilla','Mozilla','Chrome','Chrome','','','Mozilla/5.0 (Windows NT 10.0; Win64; x64; Cortana 1.14.0.19041; 10.0.0.0.19041.450) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.102 Safari/537.36 Edge/18.19041','2020-08-19 18:27:06'),(58,2020,8,19,18,3,'1.212.109.219','Mozilla','Mozilla','Chrome','Chrome','','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36','2020-08-19 18:55:32'),(59,2020,8,19,18,3,'1.212.109.219','Mozilla','Mozilla','Safari','Safari','','','Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; rv:11.0) like Gecko','2020-08-19 18:57:24'),(60,2020,8,19,18,3,'1.212.109.219','Mozilla','Mozilla','Chrome','Chrome','','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36','2020-08-19 18:57:37'),(61,2020,8,19,18,3,'1.212.109.219','Mozilla','Mozilla','Safari','Safari','','','Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; rv:11.0) like Gecko','2020-08-19 18:58:00'),(62,2020,8,19,23,3,'218.237.8.42','Linux','Linux','Chrome','Chrome','','http://cpgjaspt.cafe24.com/member/login.act.php','Mozilla/5.0 (Linux; Android 9; SM-N950N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Mobile Safari/537.36','2020-08-19 23:27:45'),(63,2020,8,20,9,4,'1.212.109.219','Mozilla','Mozilla','Chrome','Chrome','','','Mozilla/5.0 (Windows NT 10.0; Win64; x64; Cortana 1.14.0.19041; 10.0.0.0.19041.450) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.102 Safari/537.36 Edge/18.19041','2020-08-20 09:13:51'),(64,2020,8,20,9,4,'1.212.109.219','Mozilla','Mozilla','Safari','Safari','','','Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; rv:11.0) like Gecko','2020-08-20 09:15:11'),(65,2020,8,20,9,4,'1.212.109.219','Mozilla','Mozilla','Chrome','Chrome','','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36','2020-08-20 09:22:48'),(66,2020,8,20,13,4,'1.212.109.221','Mozilla','Mozilla','Chrome','Chrome','','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36','2020-08-20 13:17:26'),(67,2020,8,20,13,4,'1.212.109.221','Windows8','Windows8','IE Others','MSIE 7.0','','','Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.2; WOW64; Trident/7.0; .NET4.0C; .NET4.0E; InfoPath.2)','2020-08-20 13:18:17'),(68,2020,8,20,14,4,'1.212.109.221','Windows7','Windows7','Safari','Safari','','','Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko','2020-08-20 14:21:39'),(69,2020,8,20,15,4,'1.212.109.221','MAC','MAC','Safari','Safari','','','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.1.2 Safari/605.1.15','2020-08-20 15:35:42'),(70,2020,8,20,16,4,'1.212.109.219','Mozilla','Mozilla','Safari','Safari','','','Mozilla/5.0 (Windows NT 10.0; Win64; x64; Trident/7.0; rv:11.0) like Gecko','2020-08-20 16:02:46'),(71,2020,8,21,8,5,'175.123.66.51','MAC','MAC','Safari','Safari','','http://cpgjaspt.cafe24.com/member/login.php','Mozilla/5.0 (iPhone; CPU iPhone OS 13_6_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.1.2 Mobile/15E148 Safari/604.1','2020-08-21 08:12:29'),(72,2020,8,21,11,5,'220.124.102.104','Mozilla','Mozilla','Chrome','Chrome','','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36','2020-08-21 11:11:48'),(73,2020,8,21,12,5,'112.184.97.123','Mozilla','Mozilla','Chrome','Chrome','','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36','2020-08-21 12:24:00'),(74,2020,8,21,12,5,'112.184.97.123','Mozilla','Mozilla','Safari','Safari','','http://cpgjaspt.cafe24.com/member/login.act.php','Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; rv:11.0) like Gecko','2020-08-21 12:29:47'),(75,2020,8,21,14,5,'220.124.102.104','Mozilla','Mozilla','Chrome','Chrome','','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36','2020-08-21 14:00:21'),(76,2020,8,21,14,5,'1.212.109.221','MAC','MAC','Safari','Safari','','','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.1.2 Safari/605.1.15','2020-08-21 14:12:44'),(77,2020,8,21,15,5,'1.212.109.221','Windows7','Windows7','Safari','Safari','','','Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko','2020-08-21 15:25:16'),(78,2020,8,21,15,5,'112.184.97.123','Mozilla','Mozilla','Chrome','Chrome','','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36','2020-08-21 15:28:54'),(79,2020,8,21,15,5,'112.184.97.123','Mozilla','Mozilla','Safari','Safari','','http://cpgjaspt.cafe24.com/member/login.act.php','Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; rv:11.0) like Gecko','2020-08-21 15:31:52'),(80,2020,8,21,15,5,'220.124.102.104','Mozilla','Mozilla','Chrome','Chrome','','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36','2020-08-21 15:38:43'),(81,2020,8,21,17,5,'1.212.109.221','Windows7','Windows7','Chrome','Chrome','','','Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36','2020-08-21 17:55:52'),(82,2020,8,22,9,6,'218.237.8.42','Linux','Linux','Chrome','Chrome','','http://cpgjaspt.cafe24.com/member/login.act.php','Mozilla/5.0 (Linux; Android 9; SM-N950N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Mobile Safari/537.36','2020-08-22 09:05:42'),(83,2020,8,22,10,6,'218.237.8.42','Mozilla','Mozilla','Chrome','Chrome','','','Mozilla/5.0 (Windows NT 10.0; Win64; x64; Cortana 1.14.0.19041; 10.0.0.0.19041.450) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.102 Safari/537.36 Edge/18.19041','2020-08-22 10:55:49'),(84,2020,8,22,15,6,'175.123.66.51','MAC','MAC','Safari','Safari','','http://cpgjaspt.cafe24.com/member/login.php','Mozilla/5.0 (iPhone; CPU iPhone OS 13_6_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.1.2 Mobile/15E148 Safari/604.1','2020-08-22 15:10:40'),(85,2020,8,22,15,6,'175.123.66.51','MAC','MAC','Safari','Safari','','','Mozilla/5.0 (iPhone; CPU iPhone OS 13_6_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.1.2 Mobile/15E148 Safari/604.1','2020-08-22 15:10:51'),(86,2020,8,22,15,6,'218.237.8.42','Mozilla','Mozilla','Chrome','Chrome','','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36','2020-08-22 15:33:42'),(87,2020,8,24,8,1,'112.184.97.123','Mozilla','Mozilla','Chrome','Chrome','','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36','2020-08-24 08:29:13'),(88,2020,8,24,8,1,'173.252.87.21','MAC','MAC','Safari','Safari','','','Mozilla/5.0 (iPhone; CPU iPhone OS 13_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.1.1 Mobile/15E148 Safari/604.1','2020-08-24 08:53:58'),(89,2020,8,24,9,1,'210.222.197.21','Mozilla','Mozilla','Chrome','Chrome','','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36','2020-08-24 09:28:42'),(90,2020,8,24,9,1,'1.212.109.221','MAC','MAC','Chrome','Chrome','','','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36','2020-08-24 09:46:10'),(91,2020,8,24,11,1,'121.186.251.54','Mozilla','Mozilla','Chrome','Chrome','','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.102 Safari/537.36 Edge/18.18363','2020-08-24 11:23:39'),(92,2020,8,24,11,1,'210.123.237.58','Mozilla','Mozilla','Safari','Safari','','','Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; rv:11.0) like Gecko','2020-08-24 11:23:56'),(93,2020,8,24,11,1,'112.184.97.4','Linux','Linux','Chrome','Chrome','','','Mozilla/5.0 (Linux; Android 6.0; LG-F600S Build/MRA58K; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/80.0.3987.163 Whale/1.0.0.0 Crosswalk/25.80.14.9 Mobile Safari/537.36 NAVER(inapp; search; 720; 10.25.1)','2020-08-24 11:24:23'),(94,2020,8,24,11,1,'211.249.205.128','Others','기타','Others','Others','','','facebookexternalhit/1.1; kakaotalk-scrap/1.0; +https://devtalk.kakao.com/t/scrap/33984','2020-08-24 11:24:29'),(95,2020,8,24,11,1,'106.101.0.142','Linux','Linux','Chrome','Chrome','','','Mozilla/5.0 (Linux; Android 10; SM-G977N Build/QP1A.190711.020; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/84.0.4147.125 Mobile Safari/537.36;KAKAOTALK 2108970','2020-08-24 11:24:54'),(96,2020,8,24,11,1,'39.7.230.115','MAC','MAC','Safari','Safari','','','Mozilla/5.0 (iPhone; CPU iPhone OS 13_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 KAKAOTALK 8.9.8','2020-08-24 11:24:59'),(97,2020,8,24,11,1,'112.184.97.4','Linux','Linux','Chrome','Chrome','','','Mozilla/5.0 (Linux; Android 6.0; LG-F600S Build/MRA58K; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/84.0.4147.125 Mobile Safari/537.36;KAKAOTALK 2108970','2020-08-24 11:25:00'),(98,2020,8,24,11,1,'125.139.230.208','Linux','Linux','Chrome','Chrome','','','Mozilla/5.0 (Linux; Android 10; SM-N976N Build/QP1A.190711.020; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/84.0.4147.125 Mobile Safari/537.36;KAKAOTALK 2108970','2020-08-24 11:25:14'),(99,2020,8,24,11,1,'39.7.58.116','MAC','MAC','Safari','Safari','','','Mozilla/5.0 (iPhone; CPU iPhone OS 13_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 KAKAOTALK 8.9.8','2020-08-24 11:25:44'),(100,2020,8,24,11,1,'175.202.55.102','MAC','MAC','Safari','Safari','','','Mozilla/5.0 (iPhone; CPU iPhone OS 12_4_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 KAKAOTALK 8.9.8','2020-08-24 11:27:50'),(101,2020,8,24,11,1,'175.223.30.126','Linux','Linux','Chrome','Chrome','','','Mozilla/5.0 (Linux; Android 7.0; SM-N920K Build/NRD90M; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/84.0.4147.111 Mobile Safari/537.36;KAKAOTALK 2108970','2020-08-24 11:28:02'),(102,2020,8,24,11,1,'175.223.39.154','MAC','MAC','Safari','Safari','','','Mozilla/5.0 (iPhone; CPU iPhone OS 13_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 KAKAOTALK 8.9.8','2020-08-24 11:28:23'),(103,2020,8,24,11,1,'175.202.55.102','Mozilla','Mozilla','Chrome','Chrome','','','Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36','2020-08-24 11:29:12'),(104,2020,8,24,11,1,'110.70.47.110','MAC','MAC','Safari','Safari','','','Mozilla/5.0 (iPhone; CPU iPhone OS 13_6_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 KAKAOTALK 8.9.8','2020-08-24 11:32:24'),(105,2020,8,24,11,1,'39.7.14.143','Linux','Linux','Chrome','Chrome','','','Mozilla/5.0 (Linux; Android 9; LGM-V300K Build/PKQ1.190414.001; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/79.0.3945.136 Mobile Safari/537.36;KAKAOTALK 1908801','2020-08-24 11:43:27'),(106,2020,8,24,11,1,'125.141.105.76','Mozilla','Mozilla','Chrome','Chrome','','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36','2020-08-24 11:49:53'),(107,2020,8,24,11,1,'14.55.121.185','MAC','MAC','Safari','Safari','','','Mozilla/5.0 (iPhone; CPU iPhone OS 13_6_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 KAKAOTALK 8.9.8','2020-08-24 11:58:33'),(108,2020,8,24,12,1,'59.2.254.70','MAC','MAC','Safari','Safari','','','Mozilla/5.0 (iPhone; CPU iPhone OS 13_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 KAKAOTALK 8.9.8','2020-08-24 12:03:05'),(109,2020,8,24,12,1,'121.154.228.31','MAC','MAC','Safari','Safari','','','Mozilla/5.0 (iPhone; CPU iPhone OS 13_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 KAKAOTALK 8.5.2','2020-08-24 12:23:18'),(110,2020,8,24,12,1,'210.222.197.21','Others','기타','Others','Others','','','NateOn/7.0.1.1 (4991)','2020-08-24 12:27:31'),(111,2020,8,24,12,1,'1.212.109.221','Others','기타','Others','Others','','','NateOn/7.0.1.0 (4991)','2020-08-24 12:27:31'),(112,2020,8,24,12,1,'203.226.253.198','Others','기타','Others','Others','','','Java/1.8.0_162','2020-08-24 12:27:33'),(113,2020,8,24,12,1,'1.212.109.221','Windows7','Windows7','Safari','Safari','','','Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko','2020-08-24 12:27:53'),(114,2020,8,24,12,1,'1.212.109.221','MAC','MAC','Safari','Safari','','','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.1.2 Safari/605.1.15','2020-08-24 12:29:09'),(115,2020,8,24,12,1,'121.53.243.3','Others','기타','Others','Others','','','facebookexternalhit/1.1; kakaotalk-scrap/1.0; +https://devtalk.kakao.com/t/scrap/33984','2020-08-24 12:52:14'),(116,2020,8,24,13,1,'106.101.194.13','Linux','Linux','Chrome','Chrome','','','Mozilla/5.0 (Linux; Android 10; SM-G977N Build/QP1A.190711.020; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/83.0.4103.101 Mobile Safari/537.36;KAKAOTALK 2108960','2020-08-24 13:00:04'),(117,2020,8,24,13,1,'121.186.78.226','Linux','Linux','Chrome','Chrome','','','Mozilla/5.0 (Linux; Android 10; SM-G965N Build/QP1A.190711.020; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/84.0.4147.125 Mobile Safari/537.36;KAKAOTALK 2108970','2020-08-24 13:04:39'),(118,2020,8,24,13,1,'106.101.66.52','Linux','Linux','Chrome','Chrome','','','Mozilla/5.0 (Linux; Android 10; SM-N986N Build/QP1A.190711.020; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/84.0.4147.125 Mobile Safari/537.36;KAKAOTALK 2108970','2020-08-24 13:06:44'),(119,2020,8,24,14,1,'121.53.84.7','Others','기타','Others','Others','','','facebookexternalhit/1.1; kakaotalk-scrap/1.0; +https://devtalk.kakao.com/t/scrap/33984','2020-08-24 14:17:47'),(120,2020,8,24,14,1,'125.243.51.234','MAC','MAC','Safari','Safari','','','Mozilla/5.0 (iPhone; CPU iPhone OS 13_6_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 KAKAOTALK 8.6.9','2020-08-24 14:18:11'),(121,2020,8,24,14,1,'110.47.29.253','Mozilla','Mozilla','Chrome','Chrome','','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36','2020-08-24 14:55:50'),(122,2020,8,24,15,1,'121.53.84.3','Others','기타','Others','Others','','','facebookexternalhit/1.1; kakaotalk-scrap/1.0; +https://devtalk.kakao.com/t/scrap/33984','2020-08-24 15:27:21'),(123,2020,8,24,15,1,'210.222.197.21','Mozilla','Mozilla','Chrome','Chrome','','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36','2020-08-24 15:58:50'),(124,2020,8,24,16,1,'1.212.109.221','MAC','MAC','Chrome','Chrome','','','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.106 Whale/2.8.105.22 Safari/537.36','2020-08-24 16:21:32'),(125,2020,8,24,16,1,'121.53.81.12','Others','기타','Others','Others','','','facebookexternalhit/1.1; kakaotalk-scrap/1.0; +https://devtalk.kakao.com/t/scrap/33984','2020-08-24 16:56:25'),(126,2020,8,24,17,1,'210.222.197.21','Mozilla','Mozilla','Chrome','Chrome','','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36','2020-08-24 17:07:46'),(127,2020,8,24,18,1,'1.212.109.221','MAC','MAC','Safari','Safari','','','Mozilla/5.0 (iPhone; CPU iPhone OS 13_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 BAND/8.0.2 (iOS 13.6; iPhone9,4)','2020-08-24 18:12:34'),(128,2020,8,24,18,1,'110.70.55.96','MAC','MAC','Safari','Safari','','','Mozilla/5.0 (iPhone; CPU iPhone OS 13_6_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 BAND/8.0.2 (iOS 13.6.1; iPhone11,6)','2020-08-24 18:33:26'),(129,2020,8,24,18,1,'110.11.131.158','Linux','Linux','Chrome','Chrome','','','Mozilla/5.0 (Linux; Android 9; SM-N950N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Mobile Safari/537.36','2020-08-24 18:55:34'),(130,2020,8,24,20,1,'1.250.224.31','Linux','Linux','Chrome','Chrome','','','Mozilla/5.0 (Linux; Android 10; LM-G900N Build/QKQ1.200308.002; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/84.0.4147.125 Mobile Safari/537.36;KAKAOTALK 1908930','2020-08-24 20:40:35'),(131,2020,8,24,20,1,'121.53.82.8','Others','기타','Others','Others','','','facebookexternalhit/1.1; kakaotalk-scrap/1.0; +https://devtalk.kakao.com/t/scrap/33984','2020-08-24 20:41:42'),(132,2020,8,24,20,1,'218.151.18.68','MAC','MAC','Safari','Safari','','','Mozilla/5.0 (iPhone; CPU iPhone OS 13_6_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 KAKAOTALK 8.9.8','2020-08-24 20:41:56'),(133,2020,8,24,20,1,'218.158.234.38','Linux','Linux','Chrome','Chrome','','','Mozilla/5.0 (Linux; Android 9; SM-N950N Build/PPR1.180610.011; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/84.0.4147.125 Mobile Safari/537.36;KAKAOTALK 2108970','2020-08-24 20:43:04'),(134,2020,8,24,20,1,'175.208.105.207','Windows7','Windows7','Safari','Safari','','','Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko','2020-08-24 20:58:27'),(135,2020,8,24,20,1,'1.250.224.215','MAC','MAC','Safari','Safari','','','Mozilla/5.0 (iPhone; CPU iPhone OS 13_6_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 KAKAOTALK 8.9.6','2020-08-24 20:58:55'),(136,2020,8,24,21,1,'115.161.113.17','Mozilla','Mozilla','Chrome','Chrome','','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36','2020-08-24 21:41:49'),(137,2020,8,24,21,1,'121.53.241.12','Others','기타','Others','Others','','','facebookexternalhit/1.1; kakaotalk-scrap/1.0; +https://devtalk.kakao.com/t/scrap/33984','2020-08-24 21:46:52'),(138,2020,8,24,21,1,'115.161.113.17','Linux','Linux','Chrome','Chrome','','','Mozilla/5.0 (Linux; Android 7.1.1; SM-G611S Build/NMF26X; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/84.0.4147.125 Mobile Safari/537.36;KAKAOTALK 2108970','2020-08-24 21:47:05'),(139,2020,8,24,22,1,'218.237.8.42','Mozilla','Mozilla','Chrome','Chrome','','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36','2020-08-24 22:09:19'),(140,2020,8,24,22,1,'211.199.196.200','Linux','Linux','Chrome','Chrome','','','Mozilla/5.0 (Linux; Android 9; SM-G955N Build/PPR1.180610.011; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/84.0.4147.125 Mobile Safari/537.36;KAKAOTALK 2108970','2020-08-24 22:09:27'),(141,2020,8,24,23,1,'220.64.101.1','Others','기타','Others','Others','','','facebookexternalhit/1.1; kakaotalk-scrap/1.0; +https://devtalk.kakao.com/t/scrap/33984','2020-08-24 23:27:22'),(142,2020,8,25,1,2,'211.176.125.70','Windows8','Windows8','MSIE 10.0','MSIE 10.0','','','Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Trident/6.0)','2020-08-25 01:47:37'),(143,2020,8,25,9,2,'1.212.109.221','Windows7','Windows7','Safari','Safari','','','Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko','2020-08-25 09:37:33'),(144,2020,8,25,11,2,'173.252.87.15','Others','기타','Others','Others','','','facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)','2020-08-25 11:06:15'),(145,2020,8,25,12,2,'1.212.109.221','MAC','MAC','Chrome','Chrome','','','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.106 Whale/2.8.105.22 Safari/537.36','2020-08-25 12:12:13'),(146,2020,8,25,12,2,'1.212.109.221','Others','기타','Others','Others','','','NTWebPageAssist/1.0','2020-08-25 12:12:20'),(147,2020,8,25,12,2,'1.212.109.221','Others','기타','Others','Others','','','NTWebPageAssist/1.0','2020-08-25 12:12:20'),(148,2020,8,25,12,2,'203.226.253.198','Others','기타','Others','Others','','','Java/1.8.0_162','2020-08-25 12:12:22'),(149,2020,8,25,12,2,'1.212.109.221','MAC','MAC','Chrome','Chrome','','http://br.nate.com/diagnose.php?r_url=http%3A%2F%2Fcpgjaspt.cafe24.com%2F','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36','2020-08-25 12:13:59'),(150,2020,8,25,16,2,'110.47.29.253','Mozilla','Mozilla','Chrome','Chrome','','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36','2020-08-25 16:25:46'),(151,2020,8,26,15,3,'1.212.109.221','MAC','MAC','Chrome','Chrome','','','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36','2020-08-26 15:47:03'),(152,2020,8,26,16,3,'121.53.242.13','Others','기타','Others','Others','','','facebookexternalhit/1.1; kakaotalk-scrap/1.0; +https://devtalk.kakao.com/t/scrap/33984','2020-08-26 16:08:35'),(153,2020,8,26,22,3,'218.237.8.42','Mozilla','Mozilla','Safari','Safari','','','Mozilla/5.0 (Windows NT 10.0; Win64; x64; Trident/7.0; rv:11.0) like Gecko','2020-08-26 22:16:32'),(154,2020,8,27,14,4,'1.212.109.221','Others','기타','Others','Others','','','Microsoft Office Word 2014','2020-08-27 14:12:45'),(155,2020,8,27,14,4,'1.212.109.221','Windows7','Windows7','IE Others','MSIE 7.0','','','Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.1; Win64; x64; Trident/7.0; .NET CLR 2.0.50727; SLCC2; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E; Tablet PC 2.0; ms-office)','2020-08-27 14:12:45'),(156,2020,8,27,14,4,'1.212.109.221','Windows7','Windows7','Safari','Safari','','','Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko','2020-08-27 14:12:46'),(157,2020,8,29,14,6,'1.212.109.221','Windows7','Windows7','Chrome','Chrome','','','Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36','2020-08-29 14:21:16'),(158,2020,8,31,14,1,'210.222.197.21','Mozilla','Mozilla','Chrome','Chrome','','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36','2020-08-31 14:17:02'),(159,2020,8,31,14,1,'1.212.109.221','Others','기타','Others','Others','','','NateOn/7.0.1.0 (4991)','2020-08-31 14:18:33'),(160,2020,8,31,14,1,'203.226.253.198','Others','기타','Others','Others','','','Java/1.8.0_162','2020-08-31 14:18:39'),(161,2020,8,31,14,1,'1.212.109.221','Others','기타','Others','Others','','','NTWebPageAssist/1.0','2020-08-31 14:19:38'),(162,2020,8,31,14,1,'1.212.109.221','MAC','MAC','Chrome','Chrome','','http://br.nate.com/diagnose.php?r_url=http%3A%2F%2Fcpgjaspt.cafe24.com%2F','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.106 Whale/2.8.105.22 Safari/537.36','2020-08-31 14:19:45'),(163,2020,8,31,14,1,'1.212.109.221','Others','기타','Others','Others','','','NateOn/7.0.1.0 (4991)','2020-08-31 14:21:56'),(164,2020,8,31,14,1,'220.230.168.29','MAC','MAC','Safari','Safari','','','Mozilla/5.0 (iPhone; CPU iPhone OS 10_0_1 like Mac OS X) AppleWebKit/602.1.50 (KHTML, like Gecko) Version/10.0 Mobile/14A403 Safari/602.1','2020-08-31 14:25:31'),(165,2020,8,31,16,1,'1.212.109.221','Windows7','Windows7','Safari','Safari','','','Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko','2020-08-31 16:33:46'),(166,2020,8,31,16,1,'1.212.109.221','Windows7','Windows7','Chrome','Chrome','','','Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36','2020-08-31 16:37:46'),(167,2020,8,31,16,1,'210.222.197.21','Mozilla','Mozilla','Safari','Safari','','','Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; rv:11.0) like Gecko','2020-08-31 16:39:23');
/*!40000 ALTER TABLE `sw_counter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sw_event`
--

DROP TABLE IF EXISTS `sw_event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sw_event` (
  `idx` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `buse` enum('Y','N') DEFAULT 'Y',
  `title` varchar(100) DEFAULT NULL,
  `img` varchar(30) DEFAULT NULL,
  `target` varchar(10) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `regdt` datetime DEFAULT NULL,
  PRIMARY KEY (`idx`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sw_event`
--

LOCK TABLES `sw_event` WRITE;
/*!40000 ALTER TABLE `sw_event` DISABLE KEYS */;
/*!40000 ALTER TABLE `sw_event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sw_goods`
--

DROP TABLE IF EXISTS `sw_goods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sw_goods` (
  `idx` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `gcode` varchar(20) NOT NULL,
  `seq` int(11) NOT NULL DEFAULT '0',
  `hit` int(3) NOT NULL DEFAULT '0',
  `category` char(12) NOT NULL,
  `display` enum('Y','N') DEFAULT 'Y',
  `name` varchar(100) NOT NULL,
  `origin` varchar(30) DEFAULT NULL,
  `maker` varchar(30) DEFAULT NULL,
  `keyword` varchar(200) DEFAULT NULL,
  `icon` varchar(30) DEFAULT NULL,
  `cbest` tinyint(4) DEFAULT '0',
  `mbest` tinyint(4) DEFAULT '0',
  `mnew` tinyint(4) DEFAULT '0',
  `bsale` int(11) DEFAULT '0',
  `price` int(7) NOT NULL DEFAULT '0',
  `nprice` int(7) NOT NULL DEFAULT '0',
  `blimit` tinyint(4) NOT NULL DEFAULT '1',
  `glimit` int(7) DEFAULT NULL,
  `minea` int(3) NOT NULL DEFAULT '1',
  `maxea` int(3) NOT NULL DEFAULT '0',
  `pointmod` tinyint(4) NOT NULL DEFAULT '0',
  `point` int(3) NOT NULL DEFAULT '0',
  `pointunit` enum('p','w') DEFAULT 'p',
  `delivery` tinyint(4) NOT NULL DEFAULT '1',
  `dyprice` int(3) DEFAULT NULL,
  `ndyprice` int(7) DEFAULT NULL,
  `bopt` enum('Y','N') DEFAULT 'N',
  `relation` varchar(100) DEFAULT NULL,
  `imgtype` tinyint(4) DEFAULT '1',
  `img1` varchar(100) DEFAULT NULL,
  `img2` varchar(100) DEFAULT NULL,
  `img3` varchar(100) DEFAULT NULL,
  `img4` varchar(100) DEFAULT NULL,
  `imgetc` varchar(255) DEFAULT NULL,
  `etc1` varchar(200) DEFAULT NULL,
  `etc2` varchar(200) DEFAULT NULL,
  `etc3` varchar(200) DEFAULT NULL,
  `etc4` varchar(255) NOT NULL,
  `address` mediumtext NOT NULL,
  `shortexp` varchar(255) DEFAULT NULL,
  `content` mediumtext,
  `notice` mediumtext NOT NULL,
  `mcontent` mediumtext,
  `salecnt` int(7) DEFAULT '0',
  `regdt` datetime DEFAULT NULL,
  `updt` datetime DEFAULT NULL,
  `sday` varchar(20) NOT NULL,
  `eday` varchar(20) NOT NULL,
  `maindisplay` enum('Y','N') DEFAULT 'N',
  `subtitle` varchar(255) NOT NULL,
  PRIMARY KEY (`idx`),
  UNIQUE KEY `gcode` (`gcode`),
  KEY `iidx1` (`category`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sw_goods`
--

LOCK TABLES `sw_goods` WRITE;
/*!40000 ALTER TABLE `sw_goods` DISABLE KEYS */;
INSERT INTO `sw_goods` VALUES (1,'8235IVST',6,0,'004','Y','전국 기차여행, 내일로',NULL,NULL,'',NULL,0,0,0,0,110000,50000,1,NULL,1,0,0,0,'p',1,NULL,NULL,'N',NULL,1,'big42361_0.jpg','thum_big42361_0.jpg','thum_big42361_0.jpg','thum_big42361_0.jpg','','2','99','2','9','전국','#내일로 #코레일 #기차여행 #전국','<p style=\"text-align: center;\" align=\"center\"><img src=\"http://cpgjaspt.cafe24.com/editor/upload/98792459.2.jpg\" title=\"98792459.2.jpg\"><br style=\"clear:both;\">&nbsp;</p><p style=\"text-align: center;\" align=\"center\">&nbsp;</p><p style=\"text-align: center;\" align=\"center\">| 자유롭게 떠나보자 |</p><p style=\"text-align: center;\" align=\"center\">&nbsp;</p><p style=\"text-align: center;\" align=\"center\">내일로 두번째 이야기</p><p style=\"text-align: center;\" align=\"center\">&nbsp;</p><p style=\"text-align: center;\" align=\"center\">\" 전 국민 누구나 즐기는 7일간의 자유여행!\"</p><p style=\"text-align: center;\" align=\"center\">보다 더 자유롭고 편안해진 내일로를 경험해보세요.</p><p style=\"text-align: center;\" align=\"center\">&nbsp;</p><p style=\"text-align: center;\" align=\"center\">&nbsp;</p><p style=\"text-align: center;\" align=\"center\">&nbsp;</p><p style=\"text-align: center;\" align=\"center\">대상 : 대한민국 국적을 가진</p><p style=\"text-align: center;\" align=\"center\">전 국민 누구나 이용할 수 있으며</p><p style=\"text-align: center;\" align=\"center\">이용연령이 확대되었습니다.</p><p style=\"text-align: center;\" align=\"center\">&nbsp;</p><p style=\"text-align: center;\" align=\"center\">날짜 : 선택 날짜3일권 또는 연속 7일권</p><p style=\"text-align: center;\" align=\"center\">&nbsp;</p><p style=\"text-align: center;\" align=\"center\">좌석지정 : KTX 및 일반열차의 좌석을</p><p style=\"text-align: center;\" align=\"center\">무료로 선택해 이용할 수 있도록 확대되었습니다</p><p style=\"text-align: center;\" align=\"center\">(KTX : 1일 1회, 총 2회)</p><p style=\"text-align: center;\" align=\"center\">(일반열차 : 1일 2회)</p>','<p>* 코로나19 종료시까지 일반열차의 입석/자유석 이용 불가</p><p>-&gt; 한시적으로 일반열차의 지정좌석을 1일 4회로 확대운영</p><p>&nbsp;</p><p>* 해당 패스의 좌석지정은 별도의 공석 범위내에서 이용되므로</p><p>일반좌석이 남아있더라도 별도 패스좌석 매진 시 이용이 불가할 수 있습니다.</p><p>&nbsp;</p><p>* 입석이용 제한으로 좌석매진 시 해당열차 이용이 불가하니 미리 구매하시기 바랍니다.</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p><img src=\"http://cpgjaspt.cafe24.com/editor/upload/%25EB%258B%25A4%25EC%259A%25B4%25EB%25A1%259C%25EB%2593%259C.jpg\" title=\"%25EB%258B%25A4%25EC%259A%25B4%25EB%25A1%259C%25EB%2593%259C.jpg\"><br style=\"clear:both;\">&nbsp;</p>',NULL,0,'2020-08-17 13:55:32','2020-08-17 17:20:40','2020-08-01','2020-12-31','N',''),(2,'IV2A99F0',5,0,'003','Y','다같이 즐겨요! 제주 돌하르방 축제',NULL,NULL,'',NULL,0,0,0,0,250000,230000,1,NULL,1,0,0,0,'p',1,NULL,NULL,'N',NULL,1,'big42342_0.jpg','thum_big42342_0.jpg','thum_big42342_0.jpg','thum_big42342_0.jpg','','5','20','','15','제주도 용오름, 제주도 한라산 정상','#돌하르방 #제주도 #현무암','<p><b><span style=\"color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">화산 흔적 따라 이야기 따라 해안길 걷기</span><br style=\"box-sizing: inherit; color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"></b><span style=\"color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">제주도는 화산 활동으로 만들어진 섬인 만큼 화산 지형이 잘 보존된 곳이 많다. 제주에는 유네스코 세계지질공원으로 선정된 곳이 9곳 있는데 제주도 서쪽 끝 차귀도포구의 수월봉도 그 중 하나다.</span><br style=\"box-sizing: inherit; color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><br style=\"box-sizing: inherit; color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">수월봉에는 화산 활동의 결과물이 절벽 단면으로 신비롭게 펼쳐져 있다. 수월봉에는 지질 트레일 코스가 여러 곳 있어 일대의 자연 경관을 둘러보며 산책할 수 있다.</span><br style=\"box-sizing: inherit; color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><br style=\"box-sizing: inherit; color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">수월봉 엉알길은 엉알해안을 따라 걷는 코스다. 걷다 보면 화산재가 겹겹이 쌓여 층을 이룬 모습이 마치 다른 행성에 온 것처럼 이색적이다. 곳곳에서 화산 분출 시 높이 날아갔던 암편들이 떨어져 지층에 콕콕 박혀 있는 모습도 발견할 수 있다.</span><br style=\"box-sizing: inherit; color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">&nbsp;</p><p><span style=\"color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">돌고래와 친구 되기, 어렵지 않아요</span><br style=\"box-sizing: inherit; color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">제주 연안에는 120여 마리의 남방큰돌고래가 살고 있다. 이들의 이동 거리는 꽤 먼 편으로 제주의 동쪽, 남쪽, 서쪽에 예고 없이 나타난다.&nbsp;그렇지만 돌고래들도 특히 좋아하는 놀이터가 있기 마련이다. 야생 돌고래 탐사는 이들의 일상 놀이터인 제주 남서쪽 동일리포구 쪽을 기점으로 한다.&nbsp;오랜 시간 돌고래의 이동을 연구하고 프로그램을 개발한 ‘디스커버제주’ 팀은 그들을 ‘구경’하기보다 ‘친구’가 되기 위해 부단히 노력했다고 한다.</span><br style=\"box-sizing: inherit; color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>','<p>&nbsp;</p><div style=\"text-align: center;\"><img src=\"http://cpgjaspt.cafe24.com/editor/upload/%25EB%258B%25A4%25EC%259A%25B4%25EB%25A1%259C%25EB%2593%259C.jpg\" title=\"%25EB%258B%25A4%25EC%259A%25B4%25EB%25A1%259C%25EB%2593%259C.jpg\" style=\"color: rgb(34, 34, 34);\"></div><span style=\"color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><br></span><p>&nbsp;</p><p><span style=\"color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">&nbsp;</span></p><p><span style=\"color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">&nbsp;</span></p><p><span style=\"color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">[여행 정보]</span><br style=\"box-sizing: inherit; color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><br style=\"box-sizing: inherit; color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Info 당산봉</span><br style=\"box-sizing: inherit; color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">주소 제주 제주시 한경면 용수리 산18</span><br style=\"box-sizing: inherit; color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">문의 064-710-6072&nbsp;</span><br style=\"box-sizing: inherit; color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><br style=\"box-sizing: inherit; color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">TIP 수월봉 지질 트레일 코스를 가려면 내비게이션에 ‘엉알해안’을 검색해야 한다. ‘수월봉’을 검색할 경우 수월봉 정상으로 안내하므로 절벽 단면을 볼 수 없다.</span><br style=\"box-sizing: inherit; color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">주소 제주 제주시 한경면 고산리</span><br style=\"box-sizing: inherit; color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">문의 064-728-7973</span><br style=\"box-sizing: inherit; color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><br style=\"box-sizing: inherit; color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Info 디스커버제주 돌고래 탐사</span><br style=\"box-sizing: inherit; color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">예약가능시간 오전 10시~오후 7시</span><br style=\"box-sizing: inherit; color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">이용요금 성인 3만8000원, 12세 이하 3만3000원&nbsp;</span><br style=\"box-sizing: inherit; color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">주소 제주 서귀포시 대정읍 동일하모로 98번길 14-33 동일리포구&nbsp;</span><br style=\"box-sizing: inherit; color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">문의 050-5558-3838</span><br style=\"box-sizing: inherit; color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><br style=\"box-sizing: inherit; color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Info 협재해수욕장</span><br style=\"box-sizing: inherit; color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">주소 제주 제주시 한림읍 협재리 2497-1</span><br style=\"box-sizing: inherit; color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">문의 064-796-2404(협재해수욕장), 064-728-7672(금능해수욕장)</span><br style=\"box-sizing: inherit; color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><br style=\"box-sizing: inherit; color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Info 한림공원</span><br style=\"box-sizing: inherit; color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">주소 제주 제주시 한림읍 한림로 300</span><br style=\"box-sizing: inherit; color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">문의 064-796-0001</span><br style=\"box-sizing: inherit; color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">이용시간 오전 8시30분~오후 7시&nbsp;</span><br style=\"box-sizing: inherit; color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">이용요금 일반 1만1000원, 경로 9000원, 청소년 8000원, 어린이 7000원</span><br style=\"box-sizing: inherit; color: rgb(34, 34, 34); font-family: \" malgun=\"\" gothic\",=\"\" 돋움,=\"\" dotum,=\"\" \"apple=\"\" sd=\"\" gothic=\"\" neo\",=\"\" \"helvetica=\"\" neue\",=\"\" helvetica,=\"\" roboto,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 16px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">&nbsp;</p>',NULL,0,'2020-08-17 14:03:44','2020-08-17 14:36:18','2020-07-01','2020-08-31','N',''),(3,'S5XX9K33',4,0,'002','Y','세계평화의 희망 2020  경주 등축제',NULL,NULL,'',NULL,0,0,0,0,120000,100000,1,NULL,1,0,0,0,'p',1,NULL,NULL,'N',NULL,1,'big42320_0.jpg','thum_big42320_0.jpg','thum_big42320_0.jpg','thum_big42320_0.jpg','','4','19','','4','경주 강가','#경주 #등축제 #호롱불','<div style=\"text-align: center;\" align=\"center\"><img src=\"http://cpgjaspt.cafe24.com/editor/upload/998CBB495CECF89718.png\" title=\"998CBB495CECF89718.png\"></div><div style=\"text-align: center;\" align=\"center\"><br></div><div style=\"text-align: center;\" align=\"center\"><br></div><div style=\"text-align: center;\" align=\"center\">&nbsp; &nbsp;[경주 세계문화유산]</div><div style=\"text-align: center;\" align=\"center\">등축제</div><div style=\"text-align: center;\" align=\"center\"><br></div><div style=\"text-align: center;\" align=\"center\"><br></div><div style=\"text-align: center;\" align=\"center\"><br></div><div style=\"text-align: center;\" align=\"center\"><br></div><div style=\"text-align: center;\" align=\"center\"><span style=\"box-sizing: border-box; font-weight: bolder; color: rgb(33, 33, 33); font-family: \" malgun=\"\" gothic\",=\"\" \"noto=\"\" sans=\"\" kr\",=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" letter-spacing:=\"\" -0.4px;=\"\" text-align:=\"\" justify;\"=\"\"><span style=\"box-sizing: border-box; color: rgb(53, 53, 53); font-size: 14pt;\">과거에 경주는 수학여행 단골 코스였죠? 그런데 요즘은 경상도 여행지 중에서도 손꼽히는 베스트 여행지 중 하나입니다. 신라시대의 찬란한 유산들은 기본이고 경주의 핫플레이스&nbsp;<span style=\"box-sizing: border-box; color: rgb(255, 94, 0);\">황리단길 그리고 경주의 숨어있는 엄청난 맛집들이 관광객들을 많이 불러모으고 있어요</span><span style=\"box-sizing: border-box; color: rgb(255, 94, 0);\">.&nbsp;</span>이런 기세를 몰아 경주에서 세계문화유산 등축제가 개최됩니다.</span></span><br></div><div style=\"text-align: center;\" align=\"center\"><br></div><div style=\"text-align: center;\" align=\"center\"><span style=\"box-sizing: border-box; font-weight: bolder; color: rgb(33, 33, 33); font-family: \" malgun=\"\" gothic\",=\"\" \"noto=\"\" sans=\"\" kr\",=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" letter-spacing:=\"\" -0.4px;=\"\" text-align:=\"\" justify;\"=\"\"><span style=\"box-sizing: border-box; color: rgb(53, 53, 53); font-size: 14pt;\">과거에는 경주에서 낮에 문화유적지만 돌아보는게 전부였죠. 이 축제에서는<span style=\"box-sizing: border-box; color: rgb(0, 87, 102);\">&nbsp;<u style=\"box-sizing: border-box;\">아름다운 조명에 빚춰진 우리 문화유적들을 볼 수&nbsp;</u></span><span style=\"box-sizing: border-box; color: rgb(0, 87, 102);\"><u style=\"box-sizing: border-box;\">있습니다.</u></span>&nbsp;낮에 보는 것과는 또 다른 매력적이고 아름다운 모습들입니다. 경복궁 야간개장에 가봤는데 낮에 본 경복궁과는 완전 다른 매력을 느낄 수 있었어요. 이렇게 아름다운 우리 문화 유산들이 빛을 만나면 더 아름다워지는구나 싶었습니다. 그럼 경주 세계문화유산 등축제에 대해서 자세히 알아볼게요.&nbsp;</span></span><br></div><div style=\"text-align: center;\" align=\"center\"><br></div><div style=\"text-align: center;\" align=\"center\"><br></div><div style=\"text-align: center;\" align=\"center\"><br></div><div style=\"text-align: center;\" align=\"center\"><br></div><div style=\"text-align: center;\" align=\"center\"><br></div><div style=\"text-align: center;\" align=\"center\"><br></div><div style=\"text-align: center;\" align=\"center\"><br></div><div style=\"text-align: center;\" align=\"center\"><br></div><div style=\"text-align: center;\" align=\"center\"><br></div><div style=\"text-align: center;\" align=\"center\"><br></div><div style=\"text-align: center;\" align=\"center\"><br></div><div style=\"text-align: center;\" align=\"center\"><br></div><div style=\"text-align: center;\" align=\"center\"><br></div><div style=\"text-align: center;\" align=\"center\"><br></div><div style=\"text-align: center;\" align=\"center\"><br></div><div style=\"text-align: center;\" align=\"center\">ㅊ</div><div style=\"text-align: center;\" align=\"center\"><br></div>','<h1 style=\"box-sizing: border-box; font-size: 20px; margin: 20px 0px; line-height: 1.5; font-weight: 500; letter-spacing: 0px; color: rgb(51, 51, 51); text-align: justify;\"><span style=\"box-sizing: border-box; color: rgb(33, 33, 33);\"><span style=\"box-sizing: border-box; font-weight: bolder;\"><span style=\"box-sizing: border-box; color: rgb(53, 53, 53); font-size: 14pt;\"><u style=\"box-sizing: border-box;\"><span style=\"box-sizing: border-box; color: rgb(255, 0, 0); font-size: 24pt;\">■</span><span style=\"box-sizing: border-box; font-size: 24pt;\">&nbsp;경주 세계</span><span style=\"box-sizing: border-box; font-size: 24pt;\">문화유산 등축제 개요</span></u></span></span></span></h1><ul style=\"box-sizing: border-box; color: rgb(51, 51, 51); font-family: \" malgun=\"\" gothic\",=\"\" \"noto=\"\" sans=\"\" kr\",=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" letter-spacing:=\"\" -0.4px;=\"\" text-align:=\"\" justify;=\"\" list-style-type:=\"\" square;\"=\"\"><li style=\"box-sizing: border-box;\"><span style=\"box-sizing: border-box; color: rgb(33, 33, 33);\"><span style=\"box-sizing: border-box; font-weight: bolder;\"><span style=\"box-sizing: border-box; color: rgb(53, 53, 53); font-size: 14pt;\"><i style=\"box-sizing: border-box;\">행사 기간 : 2019년 05월 25일 ~ 10월 31일 (개막식 : 5월 31일)</i></span></span></span></li><li style=\"box-sizing: border-box;\"><span style=\"box-sizing: border-box; color: rgb(33, 33, 33);\"><span style=\"box-sizing: border-box; font-weight: bolder;\"><span style=\"box-sizing: border-box; color: rgb(53, 53, 53); font-size: 14pt;\"><i style=\"box-sizing: border-box;\">장소 : 경주 신라밀레니엄 파크&nbsp;</i></span></span></span></li><li style=\"box-sizing: border-box;\"><span style=\"box-sizing: border-box; color: rgb(33, 33, 33);\"><span style=\"box-sizing: border-box; font-weight: bolder;\"><span style=\"box-sizing: border-box; color: rgb(53, 53, 53); font-size: 14pt;\"><i style=\"box-sizing: border-box;\">전시 작품 : 세계문화유산존(유네스코 등재 유산), 테마존(세계유명건축물 등의 테마), 캐릭터존 (유명 애니메이션 캐릭터)</i></span></span></span></li><li style=\"box-sizing: border-box;\"><span style=\"box-sizing: border-box; color: rgb(33, 33, 33);\"><span style=\"box-sizing: border-box; font-weight: bolder;\"><span style=\"box-sizing: border-box; color: rgb(53, 53, 53); font-size: 14pt;\"><i style=\"box-sizing: border-box;\">부대 행사 : 개막식, 소원등 달기, 활쏘기, 워터랜턴(Water Lantern) 등</i></span></span></span></li><li style=\"box-sizing: border-box;\"><span style=\"box-sizing: border-box; color: rgb(33, 33, 33);\"><span style=\"box-sizing: border-box; font-weight: bolder;\"><span style=\"box-sizing: border-box; color: rgb(53, 53, 53); font-size: 14pt;\"><i style=\"box-sizing: border-box;\">주최 : 경주 세계문화유산등축제 추진위원회</i></span></span></span></li><li style=\"box-sizing: border-box;\"><span style=\"box-sizing: border-box; color: rgb(33, 33, 33);\"><span style=\"box-sizing: border-box; font-weight: bolder;\"><span style=\"box-sizing: border-box; color: rgb(53, 53, 53); font-size: 14pt;\"><i style=\"box-sizing: border-box;\">주관 : MBN, (주)한그루기획</i></span></span></span></li></ul>',NULL,0,'2020-08-17 14:27:30','2020-08-17 14:32:00','2020-10-01','2021-01-01','N',''),(4,'35E02V75',3,0,'001','Y','한화와 함께하는 서울세계불꽃축제',NULL,NULL,'',NULL,0,0,0,0,15000,12000,1,NULL,1,0,0,0,'p',1,NULL,NULL,'N',NULL,1,'big42298_0.jpg','thum_big42298_0.jpg','thum_big42298_0.jpg','thum_big42298_0.jpg','','9','18','1','9','서울 여의도','#불꽃축제 #한화 #63빌딩 #한강','<p style=\"color: rgb(102, 102, 102); font-family: \" noto=\"\" sans=\"\" korean\",=\"\" \"맑은=\"\" 고딕\",=\"\" \"malgun=\"\" gothic\",=\"\" dotum,=\"\" 돋움;=\"\" font-size:=\"\" 16px;\"=\"\">글로벌 아티스트들이 참여하는 세계 최고의 불꽃쇼와 다채로운 아트전시가 여러분들을 찾아갑니다.</p><p style=\"color: rgb(102, 102, 102); font-family: \" noto=\"\" sans=\"\" korean\",=\"\" \"맑은=\"\" 고딕\",=\"\" \"malgun=\"\" gothic\",=\"\" dotum,=\"\" 돋움;=\"\" font-size:=\"\" 16px;\"=\"\">9월 30일부터 10월 5일까지! 축제의 감동을 더 오래 즐겨보세요!</p><p style=\"color: rgb(102, 102, 102); font-family: \" noto=\"\" sans=\"\" korean\",=\"\" \"맑은=\"\" 고딕\",=\"\" \"malgun=\"\" gothic\",=\"\" dotum,=\"\" 돋움;=\"\" font-size:=\"\" 16px;\"=\"\">&nbsp;</p><p style=\"color: rgb(102, 102, 102); font-family: \" noto=\"\" sans=\"\" korean\",=\"\" \"맑은=\"\" 고딕\",=\"\" \"malgun=\"\" gothic\",=\"\" dotum,=\"\" 돋움;=\"\" font-size:=\"\" 16px;\"=\"\">올해 한화와 함께하는 서울세계불꽃축제 2019에서는 \'Life is colorful\'을 테마로 관객 여러분의 일상에 다채로운 긍정 에너지를 전해드리기 위한 불꽃쇼와 아트 기획전 불꽃 Atelier 등 다양한 프로그램이 진행됩니다.&nbsp;</p>','<p class=\"MsoNormal\" style=\"color: rgb(102, 102, 102); font-family: \" noto=\"\" sans=\"\" korean\",=\"\" \"맑은=\"\" 고딕\",=\"\" \"malgun=\"\" gothic\",=\"\" dotum,=\"\" 돋움;=\"\" font-size:=\"\" 16px;\"=\"\"><span lang=\"EN-US\" style=\"font-size: 9pt; line-height: 12.84px;\">*</span><span style=\"font-size: 9pt; line-height: 12.84px;\">디자인위크<span lang=\"EN-US\" style=\"font-size: 9pt;\">: 10</span>월<span lang=\"EN-US\" style=\"font-size: 9pt;\">&nbsp;1</span>일<span lang=\"EN-US\" style=\"font-size: 9pt;\">&nbsp;- 10</span>월<span lang=\"EN-US\" style=\"font-size: 9pt;\">&nbsp;5</span>일<span lang=\"EN-US\" style=\"font-size: 9pt;\">&nbsp;13:00 ~ 20:00<o:p></o:p></span></span></p><p class=\"MsoNormal\" style=\"color: rgb(102, 102, 102); font-family: \" noto=\"\" sans=\"\" korean\",=\"\" \"맑은=\"\" 고딕\",=\"\" \"malgun=\"\" gothic\",=\"\" dotum,=\"\" 돋움;=\"\" font-size:=\"\" 16px;\"=\"\"><span style=\"font-size: 15pt; line-height: 21.4px;\"><span lang=\"EN-US\" style=\"font-size: 9pt;\">*서울세계불꽃축제 : 10월 5일 13:00 ~ 21:30</span></span></p><p class=\"MsoNormal\" style=\"color: rgb(102, 102, 102); font-family: \" noto=\"\" sans=\"\" korean\",=\"\" \"맑은=\"\" 고딕\",=\"\" \"malgun=\"\" gothic\",=\"\" dotum,=\"\" 돋움;=\"\" font-size:=\"\" 16px;\"=\"\"><span style=\"font-size: 15pt; line-height: 21.4px;\"><span lang=\"EN-US\" style=\"font-size: 9pt;\">*DJ 공연 : 10월 5일 20:40 ~ 21:30</span></span></p><div><span style=\"font-size: 15pt; line-height: 21.4px;\"><span lang=\"EN-US\" style=\"font-size: 9pt;\"><br></span></span></div>',NULL,0,'2020-08-17 14:31:38','2020-08-17 17:20:24','2020-09-30','2020-10-05','N',''),(6,'KDFQ9286',1,0,'003','Y','[문화관광축제] 추억의 충장축제 2020',NULL,NULL,'',NULL,0,0,0,0,10000,8000,1,NULL,1,0,0,0,'p',1,NULL,NULL,'N',NULL,1,'big33124_0.png','thum_big33124_0.png','thum_big33124_0.png','thum_big33124_0.png','','8','99','','5','	광주 동구 충장로, 금남로, 문화전당, 예술의 거리 일원','#축제 #가볼만한축제 #추억 # 복고 #가족여행 #공연장 #관광지 #광주추억의충장축제 #나들이 #아이와함께 #연인과함께 #이색체험','<p><span style=\"color: rgb(51, 51, 51); font-family: NotoSansKR, NotoSansJP, 돋움, Dotum, AppleGothic, sans-serif; font-size: 18px; letter-spacing: -1px; background-color: rgb(255, 255, 255);\">&lt;추억의 충장축제&gt;는 매해 가을에 광주광역시 동구에서 개최되는 도심 길거리 대표 문화 축제이다.&nbsp;</span></p><p><span style=\"color: rgb(51, 51, 51); font-family: NotoSansKR, NotoSansJP, 돋움, Dotum, AppleGothic, sans-serif; font-size: 18px; letter-spacing: -1px; background-color: rgb(255, 255, 255);\">2020 추억의 충장축제는 10월 14일부터 18일까지 4일간 충장로와 금남로, 아시아 문화전당(ACC) 일원에서 펼쳐진다.</span>&nbsp;</p>','<p>&nbsp;</p>',NULL,0,'2020-08-25 14:25:25',NULL,'	2020.10.14','	2020.10.18','N','');
/*!40000 ALTER TABLE `sw_goods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sw_help`
--

DROP TABLE IF EXISTS `sw_help`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sw_help` (
  `idx` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userid` varchar(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `category` tinyint(4) DEFAULT '0',
  `title` varchar(100) DEFAULT NULL,
  `content` text,
  `upfile` varchar(30) DEFAULT NULL,
  `auserid` varchar(30) DEFAULT NULL,
  `aname` varchar(30) DEFAULT NULL,
  `acontent` text,
  `status` tinyint(4) DEFAULT '0',
  `aregdt` datetime DEFAULT NULL,
  `regdt` datetime DEFAULT NULL,
  PRIMARY KEY (`idx`),
  KEY `iidex1` (`userid`),
  KEY `iidex2` (`category`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sw_help`
--

LOCK TABLES `sw_help` WRITE;
/*!40000 ALTER TABLE `sw_help` DISABLE KEYS */;
/*!40000 ALTER TABLE `sw_help` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sw_icon`
--

DROP TABLE IF EXISTS `sw_icon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sw_icon` (
  `idx` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `buse` enum('Y','N') DEFAULT 'Y',
  `name` varchar(30) DEFAULT NULL,
  `img` varchar(30) NOT NULL,
  `regdt` datetime DEFAULT NULL,
  PRIMARY KEY (`idx`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sw_icon`
--

LOCK TABLES `sw_icon` WRITE;
/*!40000 ALTER TABLE `sw_icon` DISABLE KEYS */;
/*!40000 ALTER TABLE `sw_icon` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sw_like`
--

DROP TABLE IF EXISTS `sw_like`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sw_like` (
  `idx` int(11) NOT NULL AUTO_INCREMENT,
  `bo_table` varchar(20) NOT NULL DEFAULT '',
  `wr_id` int(11) NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `useridx` int(11) NOT NULL,
  `good` int(11) NOT NULL,
  `regdt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idx`),
  UNIQUE KEY `fkey1` (`bo_table`,`wr_id`,`mb_id`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sw_like`
--

LOCK TABLES `sw_like` WRITE;
/*!40000 ALTER TABLE `sw_like` DISABLE KEYS */;
INSERT INTO `sw_like` VALUES (4,'goods',1,'test1@test.com',10,1,'2020-08-17 15:25:01'),(3,'goods',4,'test1@test.com',10,1,'2020-08-17 15:24:59'),(5,'goods',4,'test3@test.com',13,1,'2020-08-17 15:27:09'),(6,'goods',3,'test3@test.com',13,1,'2020-08-17 15:27:57'),(7,'goods',2,'test3@test.com',13,1,'2020-08-17 15:28:00'),(8,'goods',1,'test3@test.com',13,1,'2020-08-17 15:28:03'),(9,'goods',2,'1452760587',24,1,'2020-08-17 16:10:12'),(45,'goods',4,'admin@admin.com',1,1,'2020-08-18 19:40:34'),(18,'goods',1,'test10@test.com',25,1,'2020-08-18 11:08:14');
/*!40000 ALTER TABLE `sw_like` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sw_member`
--

DROP TABLE IF EXISTS `sw_member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sw_member` (
  `idx` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `nick` varchar(30) DEFAULT NULL,
  `birthday` varchar(10) DEFAULT NULL,
  `birtype` enum('+','-') DEFAULT '+',
  `sex` enum('M','W') DEFAULT 'M',
  `userid` varchar(30) NOT NULL,
  `kakaoid` varchar(100) NOT NULL,
  `naverid` varchar(100) NOT NULL,
  `access_token` varchar(255) NOT NULL,
  `userlv` tinyint(4) DEFAULT '0',
  `pwd` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mailing` enum('Y','N') DEFAULT 'Y',
  `zip` varchar(7) NOT NULL,
  `adr1` varchar(100) NOT NULL,
  `adr2` varchar(100) NOT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `hp` varchar(20) NOT NULL,
  `bsms` enum('Y','N') DEFAULT 'Y',
  `emoney` int(7) DEFAULT '0',
  `buycnt` int(3) DEFAULT '0',
  `buymoney` int(7) DEFAULT '0',
  `ip` varchar(15) DEFAULT NULL,
  `logdt` datetime DEFAULT NULL,
  `vcnt` int(3) DEFAULT '0',
  `status` tinyint(4) DEFAULT '0',
  `conninfo` varchar(200) DEFAULT NULL,
  `jType` varchar(10) DEFAULT NULL,
  `leave_ex` varchar(30) DEFAULT NULL,
  `leave_memo` text,
  `memo` text,
  `regdt` datetime DEFAULT NULL,
  `level` int(11) NOT NULL,
  `leave` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1:탈퇴 , 0:정상회원',
  `leave_date` datetime NOT NULL COMMENT '탈퇴날짜',
  `photo` varchar(255) NOT NULL COMMENT '사진',
  `user_type` int(11) NOT NULL,
  `updt` datetime DEFAULT NULL,
  `changepwd` tinyint(4) DEFAULT '0',
  `autoLogin` enum('Y','N') DEFAULT 'N',
  PRIMARY KEY (`idx`),
  KEY `iidx1` (`userid`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sw_member`
--

LOCK TABLES `sw_member` WRITE;
/*!40000 ALTER TABLE `sw_member` DISABLE KEYS */;
INSERT INTO `sw_member` VALUES (1,'마스터관리자','김아무',NULL,'+','M','admin@admin.com','','','',100,'*4ACFE3202A5FF5CF467898FC58AAB1D615029441','','Y','','','',NULL,'01012345555','Y',0,0,0,NULL,'2020-08-31 14:19:52',127,1,NULL,NULL,NULL,NULL,'1111','2020-07-24 16:21:55',100,0,'0000-00-00 00:00:00','member21378_0.jpg',0,NULL,0,'N'),(3,'테스트','테스트',NULL,'+','M','test@test.com','','','',20,'*89C6B530AA78695E257E55D63C00A6EC9AD3E977','test@test.com','Y','','','',NULL,'010-1234-5555','Y',0,0,0,'1.212.109.221','2020-08-13 10:13:10',8,1,NULL,NULL,NULL,NULL,NULL,'2020-07-27 12:36:42',0,0,'0000-00-00 00:00:00','',0,NULL,0,'N'),(4,'','체험넷',NULL,'+','M','abc@abc.com','','','',20,'*F2AC1CF2C99E1D9F06344EF77BCEF1FE53A307FA','','','','','',NULL,'01000000000','',0,0,0,'220.124.102.140','2020-08-12 16:02:24',10,1,NULL,NULL,NULL,NULL,NULL,'2020-07-30 10:16:36',0,0,'0000-00-00 00:00:00','',0,'2020-08-10 10:32:45',0,'N'),(14,'','우리요테스트',NULL,'+','M','wry1@wry.com','','','',20,'*A4B6157319038724E3560894F7F932C8886EBFCF','','Y','','','',NULL,'010-1234-1234','Y',0,0,0,'1.212.109.219','2020-08-10 15:29:16',1,0,NULL,NULL,NULL,NULL,NULL,'2020-08-10 15:17:13',0,1,'2020-08-12 13:46:41','',0,'2020-08-12 13:46:41',0,'N'),(10,'','김종국',NULL,'+','M','test1@test.com','','','',20,'*A4B6157319038724E3560894F7F932C8886EBFCF','','Y','','','',NULL,'010-2222-3333','Y',0,0,0,'1.212.109.219','2020-08-20 09:43:00',11,1,NULL,NULL,NULL,NULL,NULL,'2020-08-07 16:33:34',0,0,'0000-00-00 00:00:00','member85668_0.jpg',0,NULL,0,'N'),(11,'','유인나',NULL,'+','M','test2@test.com','','','',20,'*A4B6157319038724E3560894F7F932C8886EBFCF','','','','','',NULL,'01022226666','',0,0,0,'1.212.109.219','2020-08-17 14:45:49',2,1,NULL,NULL,NULL,NULL,NULL,'2020-08-07 17:36:49',0,0,'0000-00-00 00:00:00','member89440_0.png',0,NULL,0,'N'),(24,'(주)우리요 대표 최영','(주)우리요 대표 최영',NULL,'+','M','','1452760587','','',20,'','','Y','','','',NULL,'','Y',0,0,0,'1.212.109.221','2020-08-26 10:17:49',9,1,NULL,NULL,NULL,NULL,NULL,'2020-08-17 16:09:18',0,0,'0000-00-00 00:00:00','http://k.kakaocdn.net/dn/bpYcxY/btqF9Ht7eBS/Qu9q0gJeNz8DgXhPFX4ik1/img_640x640.jpg',1,NULL,0,'N'),(13,'','손예진',NULL,'+','M','test3@test.com','','','',20,'*A4B6157319038724E3560894F7F932C8886EBFCF','','','','','',NULL,'01022225555','',0,0,0,'1.212.109.219','2020-08-17 15:27:06',1,1,NULL,NULL,NULL,NULL,NULL,'2020-08-07 18:07:45',0,0,'0000-00-00 00:00:00','',0,NULL,0,'N'),(15,'','우리요테스트',NULL,'+','M','wry001@wry.com','','','',20,'*A4B6157319038724E3560894F7F932C8886EBFCF','','','','','',NULL,'01011111111','',0,0,0,'1.212.109.222','2020-08-10 15:35:48',3,1,NULL,NULL,NULL,NULL,NULL,'2020-08-10 15:17:59',0,0,'0000-00-00 00:00:00','',0,'2020-08-12 13:46:53',0,'N'),(16,'','우리요테스트2',NULL,'+','M','wry002@wry.com','','','',20,'*A4B6157319038724E3560894F7F932C8886EBFCF','','Y','','','',NULL,'01011111111','Y',0,0,0,'1.212.109.222','2020-08-10 15:36:51',2,0,NULL,NULL,NULL,NULL,NULL,'2020-08-10 15:19:50',0,1,'2020-08-12 13:47:01','',0,'2020-08-12 13:47:01',0,'N'),(22,'','베타테스터',NULL,'+','M','beta@test.com','','','',20,'*A4B6157319038724E3560894F7F932C8886EBFCF','','','','','',NULL,'01055556666','',0,0,0,'1.212.109.221',NULL,0,1,NULL,NULL,NULL,NULL,NULL,'2020-08-10 15:40:42',0,0,'0000-00-00 00:00:00','member41780_0.jpg',0,NULL,0,'N'),(23,'','우리요테스트',NULL,'+','M','wry001@test.com','','','',20,'*A4B6157319038724E3560894F7F932C8886EBFCF','','','','','',NULL,'01011111111','',0,0,0,'1.212.109.222','2020-08-10 15:46:42',1,1,NULL,NULL,NULL,NULL,NULL,'2020-08-10 15:41:31',0,0,'0000-00-00 00:00:00','member42724_0.jpg',0,NULL,0,'N'),(25,'','우리요테스트10',NULL,'+','M','test10@test.com','','','',20,'*A4B6157319038724E3560894F7F932C8886EBFCF','','Y','','','',NULL,'010-3347-9628','Y',0,0,0,'1.212.109.221',NULL,0,1,NULL,NULL,NULL,NULL,NULL,'2020-08-18 11:08:01',0,0,'0000-00-00 00:00:00','',0,NULL,0,'N'),(26,'','김제여행',NULL,'+','M','shinexg@naver.com','','','',20,'*131DC7328C2E2E50371E061E53F7882661EA16EB','','','','','',NULL,'01048567435','',0,0,0,'112.184.97.123','2020-08-21 15:31:52',2,1,NULL,NULL,NULL,NULL,NULL,'2020-08-21 12:25:58',0,0,'0000-00-00 00:00:00','',0,NULL,0,'N'),(34,'오승원','오승원',NULL,'+','M','','','naver_192460602','AAAAOZGTLoAJo6XCuKwmYYmD6SbleAs65tpvtI8itgoTkQW72nyTIejXfQcfsXrFnW4i2BS4UB0bR962NN03_1fxs7Q',20,'','gimjetour@naver.com','Y','','','',NULL,'','Y',0,0,0,'1.212.109.221','2020-08-26 10:17:49',1,9,NULL,NULL,NULL,NULL,NULL,'2020-08-21 16:36:36',0,0,'0000-00-00 00:00:00','https://ssl.pstatic.net/static/pwe/address/img_profile.png',2,NULL,0,'N'),(35,'오승원','오승원',NULL,'+','M','','','naver_192460602','AAAAOU6wAtyKpcrgcCIZCsiqy6WNTS1n3TMSBE9aPMUQHM3NYV3YeFobenzqiouRDV0_HqocHyVQJmOrIH4q0krugSs',20,'','gimjetour@naver.com','Y','','','',NULL,'','Y',0,0,0,'1.212.109.221','2020-08-26 10:17:49',1,9,NULL,NULL,NULL,NULL,NULL,'2020-08-25 17:23:09',0,0,'0000-00-00 00:00:00','https://ssl.pstatic.net/static/pwe/address/img_profile.png',2,NULL,0,'N'),(36,'오승원','오승원',NULL,'+','M','','','naver_192460602','AAAAOU6wAtyKpcrgcCIZCsiqy6WNTS1n3TMSBE9aPMUQHM3NYV3YeFobenzqiouRDV0_HqocHyVQJmOrIH4q0krugSs',20,'','gimjetour@naver.com','Y','','','',NULL,'','Y',0,0,0,'1.212.109.221','2020-08-26 10:17:49',1,9,NULL,NULL,NULL,NULL,NULL,'2020-08-25 17:24:30',0,0,'0000-00-00 00:00:00','https://ssl.pstatic.net/static/pwe/address/img_profile.png',2,NULL,0,'N'),(37,'','',NULL,'+','M','','','naver_56060920','AAAANs72iqgQApw17vkhCHGuZSAxekpO5bMsiSOB8vXKKR7ajGgPzZPkSWAwA5UoH_STqzXVJrfU1wjtMfVGxLkrhfs',20,'','','Y','','','',NULL,'','Y',0,0,0,'1.212.109.221','2020-08-26 10:17:49',1,9,NULL,NULL,NULL,NULL,NULL,'2020-08-25 17:24:38',0,0,'0000-00-00 00:00:00','',2,NULL,0,'N'),(38,'','',NULL,'+','M','','','naver_56060920','AAAANs72iqgQApw17vkhCHGuZSAxekpO5bMsiSOB8vXKKR7ajGgPzZPkSWAwA5UoH_STqzXVJrfU1wjtMfVGxLkrhfs',20,'','','Y','','','',NULL,'','Y',0,0,0,'1.212.109.221','2020-08-26 10:17:49',1,9,NULL,NULL,NULL,NULL,NULL,'2020-08-25 17:24:47',0,0,'0000-00-00 00:00:00','',2,NULL,0,'N'),(39,'','dd****',NULL,'+','M','','','naver_56060920','AAAAN5AJVsOLUtj9_Bny9nysnv3acQXEZaZXhzRhAVSbZYpmTtNLSkWLD345Zy_3F1a0QW-rHkT4_bkGA56BH9vAFMk',20,'','','Y','','','',NULL,'','Y',0,0,0,'1.212.109.221','2020-08-26 10:17:49',1,9,NULL,NULL,NULL,NULL,NULL,'2020-08-25 17:27:11',0,0,'0000-00-00 00:00:00','',2,NULL,0,'N'),(40,'','dd****',NULL,'+','M','','','naver_56060920','AAAAN5AJVsOLUtj9_Bny9nysnv3acQXEZaZXhzRhAVSbZYpmTtNLSkWLD345Zy_3F1a0QW-rHkT4_bkGA56BH9vAFMk',20,'','','Y','','','',NULL,'','Y',0,0,0,'1.212.109.221','2020-08-26 10:17:49',1,9,NULL,NULL,NULL,NULL,NULL,'2020-08-25 17:27:28',0,0,'0000-00-00 00:00:00','',2,NULL,0,'N'),(41,'','dd****',NULL,'+','M','','','naver_56060920','AAAANkyPze5v6fbO3olOCf_7_yF6sxKP0I65Tbtlr5NuM_6FeQAqhqggBZHr6gLq7BF_e2-Z5Bc22wDFjHEN0j4nh-I',20,'','','Y','','','',NULL,'010-1234-5678','Y',0,0,0,'1.212.109.221','2020-08-26 10:17:49',1,1,NULL,NULL,NULL,NULL,NULL,'2020-08-25 17:27:50',0,0,'0000-00-00 00:00:00','',2,NULL,0,'N');
/*!40000 ALTER TABLE `sw_member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sw_popup`
--

DROP TABLE IF EXISTS `sw_popup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sw_popup` (
  `idx` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `buse` enum('Y','N') DEFAULT 'Y',
  `title` varchar(100) NOT NULL,
  `sday` varchar(10) DEFAULT NULL,
  `eday` varchar(10) DEFAULT NULL,
  `width` int(3) DEFAULT NULL,
  `height` int(3) DEFAULT NULL,
  `ptop` int(3) DEFAULT NULL,
  `pleft` int(3) DEFAULT NULL,
  `ptype` tinyint(4) DEFAULT '1',
  `content` text,
  `bgimg` varchar(30) DEFAULT NULL,
  `regdt` datetime DEFAULT NULL,
  PRIMARY KEY (`idx`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sw_popup`
--

LOCK TABLES `sw_popup` WRITE;
/*!40000 ALTER TABLE `sw_popup` DISABLE KEYS */;
INSERT INTO `sw_popup` VALUES (2,'N','test','2020-07-27','2020-08-31',400,500,200,300,1,'test','design91805_0.png','2020-07-30 15:50:05');
/*!40000 ALTER TABLE `sw_popup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sw_qna`
--

DROP TABLE IF EXISTS `sw_qna`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sw_qna` (
  `idx` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `gidx` int(11) NOT NULL,
  `bLock` enum('Y','N') DEFAULT 'N',
  `userid` varchar(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `category` tinyint(4) DEFAULT '0',
  `title` varchar(100) DEFAULT NULL,
  `content` text,
  `ip` varchar(20) NOT NULL,
  `upfile` varchar(30) DEFAULT NULL,
  `auserid` varchar(30) DEFAULT NULL,
  `aname` varchar(30) DEFAULT NULL,
  `atitle` varchar(100) DEFAULT NULL,
  `acontent` text,
  `status` tinyint(4) DEFAULT '0',
  `aregdt` datetime DEFAULT NULL,
  `regdt` datetime DEFAULT NULL,
  PRIMARY KEY (`idx`),
  KEY `iidex1` (`userid`),
  KEY `iidex2` (`category`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sw_qna`
--

LOCK TABLES `sw_qna` WRITE;
/*!40000 ALTER TABLE `sw_qna` DISABLE KEYS */;
INSERT INTO `sw_qna` VALUES (1,1,'N','test2@test.com','유인나',NULL,1,'내일로 예약은 어떻게 하나요','내일로 예약은 어디서 어떻게 진행되나요?\r\n\r\n결제수단은 어떤것으로 결제가 가능한가요','1.212.109.219','','admin@admin.com','마스터관리자','예약에 대한 답변','예약은 해당 예약페이지에서 체험신청을 진행 한 후\r\n기재된 계좌번호로 입금해주세면 확인 후\r\n\r\n예약승인을 해드리는 방식으로 진행하고 있습니다.',2,'2020-08-17 14:49:13','2020-08-17 14:43:39'),(3,2,'N','test1@test.com','김종국',NULL,1,'돌하르방이 무엇인가요','체험이전에 돌하르방에 대해 자세히\r\n알고싶습니다.\r\n\r\n공식 홈페이지나 책자/포스터가 있을까요?\r\n답변바랍니다.','1.212.109.219','',NULL,NULL,NULL,NULL,1,NULL,'2020-08-17 15:26:35'),(4,4,'N','test3@test.com','손예진',NULL,1,'불꽃놀이 여행관련','근처에 주차할 곳이 있나요?\r\n','1.212.109.219','',NULL,NULL,NULL,NULL,1,NULL,'2020-08-17 15:29:01'),(5,1,'N','admin@admin.com','마스터관리자',NULL,1,'내일로 출발시간은 언제인가요?','내일로 출발시간은 언제인가요?','220.124.102.104','',NULL,NULL,NULL,NULL,1,NULL,'2020-08-18 09:43:16'),(6,1,'N','test10@test.com','',NULL,1,'여행상품 상세 구성','내일로 여행상품 상세구성(비용,체험내용)이\r\n알고싶습니다.','1.212.109.221','','admin@admin.com','관리자','안녕하세요 고객님','유선으로 안내드렸습니다. \r\n\r\n이용해주셔서 감사합니다. ',2,'2020-08-18 11:23:41','2020-08-18 11:10:45'),(7,4,'Y','test10@test.com','',NULL,2,'행사 끝나는 시간이 정확히 언제인가요?','축제끝나고 귀가시간을 알고싶습니다. \r\n\r\n많이 혼잡하여 늦어질거같은데\r\n\r\n대략적인 시간을 안내해주세요','1.212.109.221','','admin@admin.com','우리요관리자','안녕하세요 귀가시간 문의 답변드립니다. ','안녕하세요 고객님.\r\n\r\n체험넷입니다. \r\n\r\n해당 상품에 관심갖고 문의주셔서 감사합니다. \r\n\r\n해당 축제의 경우 세계를 주제로 진행되는 축제이니만큼\r\n\r\n참여 인원이 많아 교통 및 축제진행이 매우 혼잡할것으로 예상됩니다. \r\n\r\n예상 종료 시간은 1시이며, 1시 15분까지 제 2주차장으로 모여주시면\r\n\r\n함께 이동하여 귀가 할 수 있도록 상품이 구성되어있으니\r\n\r\n상품이용에 참고 부탁드립니다. \r\n\r\n감사합니다. ',2,'2020-08-18 11:35:35','2020-08-18 11:31:51');
/*!40000 ALTER TABLE `sw_qna` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sw_review`
--

DROP TABLE IF EXISTS `sw_review`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sw_review` (
  `idx` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `gidx` int(11) NOT NULL,
  `userid` varchar(30) NOT NULL,
  `point` tinyint(4) DEFAULT '0',
  `name` varchar(30) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` text,
  `ip` varchar(20) DEFAULT NULL,
  `mview` enum('Y','N') DEFAULT 'N',
  `status` tinyint(4) DEFAULT '0',
  `regdt` datetime DEFAULT NULL,
  `hashtag` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idx`),
  KEY `iidx` (`gidx`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sw_review`
--

LOCK TABLES `sw_review` WRITE;
/*!40000 ALTER TABLE `sw_review` DISABLE KEYS */;
INSERT INTO `sw_review` VALUES (1,4,'test1@test.com',0,'김종국','최고의 불꽃축제였습니다','정말 기대를 많이 하고 갔는데 \r\n기대만큼이나 스케일도 크고 이쁘네요\r\n\r\n다음에도 한번 더 오고싶어요 +_+','1.212.109.219','N',0,'2020-08-17 14:37:43','#불꽃축제 #서울'),(3,3,'test1@test.com',0,'김종국','세계적인 축제, 경주 등축제','옛날에 TV로만 보던 등을 계곡에 띄우고<br />\r\n소원을 비는 것을 <br />\r\n<br />\r\n경주에 와서 직업 해보니 정말로 뿌듯했습니다.<br />\r\n이번 한해도 좋은일만 가득하라고<br />\r\n소원도 빌고 가족끼리 재밌는 여행이 되었습니다~<br />\r\n<br />\r\n','1.212.109.219','N',0,'2020-08-17 14:40:16','#등불체험'),(4,2,'test2@test.com',0,'유인나','최고예요!','제주도를 많이 가보았지만\r\n돌하르방 축제는 처음이였던것 같아요\r\n\r\n돌하르방 축제에서 여러 신기한 돌도 보고\r\n먹거리도 많아 좋았답니다~','1.212.109.219','N',0,'2020-08-17 14:41:24','#제주도'),(5,4,'test2@test.com',0,'유인나','최고예요!','불꽃놀이가 너무 좋았어요!','1.212.109.219','N',0,'2020-08-17 14:41:58','#한강'),(9,1,'admin@admin.com',0,'마스터관리자','최고의 여행','제주도에서는 최고의 돌하르방 체험과\r\n여행이 되었습니다.','1.212.109.219','N',0,'2020-08-17 15:20:29','#돌하르방'),(13,4,'admin@admin.com',0,'관리자','한화와 불꽃축제!!!!','후기가 모두 좋길래 가족들과 시간내서 다녀왔어요!\r\n역시나 서울 세계불꽃축제라는 명성에 맞게 굉장하더라구요><\r\n가족들과 좋은 추억을 또 하나 만든 것 같아요.\r\n다음에 또 기회가 된다면 무조건 갈 것 같네요 :)','1.212.109.221','N',0,'2020-08-25 13:37:07','#서울세계불꽃축제'),(10,3,'test3@test.com',0,'손예진','등불여행','등불여행으로\r\n좋은 경험이 되었습니다.','1.212.109.219','N',0,'2020-08-17 15:27:33','#등불'),(11,2,'test3@test.com',0,'손예진','재미있는 돌하르방 축제','돌하르방 축제는 정말 재미있었습니다.\r\n좋은 경험이 되었네요\r\n\r\n제주도를 새롭게 알게 되었습니다','1.212.109.219','N',0,'2020-08-17 15:31:06','#재밌다 #즐겁다'),(12,1,'test10@test.com',0,'','내일로 좋아요','기차여행 좋아하는데 이번 여행으로 \r\n좋은 추억쌓고 올 수 있었어요','1.212.109.221','N',0,'2020-08-18 11:09:38','내일로');
/*!40000 ALTER TABLE `sw_review` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sw_sale`
--

DROP TABLE IF EXISTS `sw_sale`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sw_sale` (
  `idx` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `sday` varchar(10) NOT NULL,
  `shour` tinyint(4) DEFAULT '0',
  `smin` tinyint(4) DEFAULT '0',
  `eday` varchar(10) NOT NULL,
  `ehour` tinyint(4) DEFAULT '0',
  `emin` tinyint(4) DEFAULT '0',
  `gidx` int(11) NOT NULL,
  `price` int(7) NOT NULL DEFAULT '0',
  `jcnt` int(3) DEFAULT '0',
  `status` tinyint(4) DEFAULT '0',
  `regdt` datetime DEFAULT NULL,
  PRIMARY KEY (`idx`),
  KEY `iidx` (`gidx`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sw_sale`
--

LOCK TABLES `sw_sale` WRITE;
/*!40000 ALTER TABLE `sw_sale` DISABLE KEYS */;
/*!40000 ALTER TABLE `sw_sale` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sw_siteinfo`
--

DROP TABLE IF EXISTS `sw_siteinfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sw_siteinfo` (
  `idx` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `AccountName` varchar(30) NOT NULL,
  `AccountBank` varchar(255) NOT NULL,
  `AccountNum` varchar(50) NOT NULL,
  `sitename` varchar(100) NOT NULL,
  `naverClientID` varchar(255) DEFAULT NULL,
  `naverSecret` varchar(255) DEFAULT NULL,
  `kakaoClientID` varchar(255) DEFAULT NULL,
  `kakaoSecret` varchar(255) DEFAULT NULL,
  `regdt` datetime DEFAULT NULL,
  `updt` datetime DEFAULT NULL,
  `ceoname` varchar(50) NOT NULL,
  `tel` varchar(30) NOT NULL,
  `address` varchar(200) NOT NULL,
  `BusinessNum` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`idx`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sw_siteinfo`
--

LOCK TABLES `sw_siteinfo` WRITE;
/*!40000 ALTER TABLE `sw_siteinfo` DISABLE KEYS */;
INSERT INTO `sw_siteinfo` VALUES (1,'체험넷','전북은행','1013-01-3173814','체험넷','7mYQGw5I_rGkwLDuKKaa','qXPotrN0j1','e162e0ff41213acf417bc0a944197c98','','2020-07-28 16:22:01','2020-08-13 09:00:14','오승원','063-545-9800','전라북도 김제시 봉남면 봉남로 438, 2층','112-04-85315');
/*!40000 ALTER TABLE `sw_siteinfo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sw_text_info`
--

DROP TABLE IF EXISTS `sw_text_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sw_text_info` (
  `f_no` int(11) NOT NULL,
  `use_info` text NOT NULL COMMENT '이용약관',
  `pr_info` text NOT NULL COMMENT '개인정보취급방침',
  `offer_info` text NOT NULL COMMENT '3자정보제공',
  `solution1_info` text NOT NULL,
  `solution2_info` text NOT NULL,
  PRIMARY KEY (`f_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='약관정보';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sw_text_info`
--

LOCK TABLES `sw_text_info` WRITE;
/*!40000 ALTER TABLE `sw_text_info` DISABLE KEYS */;
INSERT INTO `sw_text_info` VALUES (1,'<p style=\"margin: 0px\"> </p>\r\n\r\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n\r\n<tbody>\r\n\r\n<tr>\r\n\r\n<td align=\"center\"><strong><span style=\"font-family: gulim; font-size: 24px\">이용약관</span></strong></td></tr>\r\n\r\n<tr>\r\n\r\n<td align=\"center\"><span style=\"font-family: dotum; font-size: 12px\">저희 체험넷 한국인터넷진흥원의 개인정보 취급방침을 준수 합니다.</span></td></tr></tbody></table><br>\r\n\r\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n\r\n<tbody>\r\n\r\n<tr>\r\n\r\n<td>\r\n\r\n<p style=\"margin: 0px; line-height: 1.6\"><span style=\"font-family: gulim; font-size: 12px\">저희 체험넷\" 사이버 몰은 (이하 \'회사\'는) 고객님의 개인정보를 중요시하며, \"정보통신망 이용촉진 및 정보보호\"에 관한 법률을 준수하고 있습니다. 회사는 개인정보취급방침을 통하여 고객님께서 제공하시는 개인정보가 어떠한 용도와 방식으로 이용되고 있으며, 개인정보보호를 위해 어떠한 조치가 취해지고 있는지 알려드립니다.</span></p></td></tr>\r\n\r\n<tr>\r\n\r\n<td> </td></tr>\r\n\r\n<tr>\r\n\r\n<td>\r\n\r\n<p style=\"margin: 0px; line-height: 1.6\"><span style=\"font-family: gulim; font-size: 12px\">개인정보취급방침을 개정하는 경우 웹사이트 공지사항(또는 개별공지)을 통하여 공지할 것입니다.</span><br><span style=\"font-family: gulim; font-size: 12px\">본 방침은 : 2020 년 07 월 01 일 부터 시행됩니다.</span></p></td></tr>\r\n\r\n<tr>\r\n\r\n<td> </td></tr>\r\n\r\n<tr>\r\n\r\n<td>\r\n\r\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n\r\n<tbody>\r\n\r\n<tr>\r\n\r\n<td colspan=\"2\">\r\n\r\n<p style=\"margin: 0px\"><strong><span style=\"font-family: gulim; font-size: 13px\">■ 수집하는 개인정보 항목</span></strong></p></td></tr>\r\n\r\n<tr>\r\n\r\n<td width=\"10\"> </td>\r\n\r\n<td>\r\n\r\n<p style=\"margin: 0px; line-height: 1.6\"><span style=\"font-family: gulim; font-size: 12px\">회사는 회원가입, 상담, 서비스 신청 등등을 위해 아래와 같은 개인정보를 수집하고 있습니다.</span></p>\r\n\r\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n\r\n<tbody>\r\n\r\n<tr>\r\n\r\n<td width=\"10\">\r\n\r\n<p style=\"margin: 0px; line-height: 1.6\"><span style=\"font-family: gulim; font-size: 12px\"> </span></p></td>\r\n\r\n<td width=\"120\">\r\n\r\n<p style=\"margin: 0px; line-height: 1.6\"><span style=\"font-family: gulim; font-size: 12px\">수집항목</span></p></td>\r\n\r\n<td>\r\n\r\n<p style=\"margin: 0px; line-height: 1.6\"><span style=\"font-family: dotum; font-size: 11px\">이름 , 생년월일 , 성별 , 로그인ID , 비밀번호 , 비밀번호 질문과 답변 , 자택 전화번호 , 자택 주소 , 휴대전화번호 , 이메일 , 직업 , 회사명 , 회사전화번호 , 주민등록번호 , 신용카드 정보 , 은행계좌 정보 , 서비스 이용기록 , 접속 로그 , 쿠키 , 접속 IP 정보 , 결제기록</span></p></td></tr>\r\n\r\n<tr>\r\n\r\n<td> </td>\r\n\r\n<td width=\"120\">\r\n\r\n<p style=\"margin: 0px; line-height: 1.6\"><span style=\"font-family: gulim; font-size: 12px\">개인정보 수집방법</span></p></td>\r\n\r\n<td>\r\n\r\n<p style=\"margin: 0px; line-height: 1.6\"><span style=\"font-family: dotum; font-size: 11px\">홈페이지(회원가입 및 상품주문) , 글쓰기</span></p></td></tr></tbody></table></td></tr></tbody></table></td></tr>\r\n\r\n<tr>\r\n\r\n<td> </td></tr>\r\n\r\n<tr>\r\n\r\n<td>\r\n\r\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n\r\n<tbody>\r\n\r\n<tr>\r\n\r\n<td colspan=\"2\">\r\n\r\n<p style=\"margin: 0px\"><strong><span style=\"font-family: gulim; font-size: 13px\">■ 개인정보의 수집 및 이용목적</span></strong></p></td></tr>\r\n\r\n<tr>\r\n\r\n<td width=\"10\"> </td>\r\n\r\n<td>\r\n\r\n<p style=\"margin: 0px; line-height: 1.6\"><span style=\"font-family: gulim; font-size: 12px\">회사는 수집한 개인정보를 다음의 목적을 위해 활용합니다.</span></p>\r\n\r\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n\r\n<tbody>\r\n\r\n<tr>\r\n\r\n<td width=\"10\">\r\n\r\n<p style=\"margin: 0px; line-height: 1.6\"><span style=\"font-family: gulim; font-size: 12px\"> </span></p></td>\r\n\r\n<td>\r\n\r\n<p style=\"margin: 0px; line-height: 1.6\"><span style=\"font-family: gulim; font-size: 12px\">- 서비스 제공에 관한 계약 이행 및 서비스 제공에 따른 요금정산</span><br><span style=\"font-family: gulim; font-size: 12px\">- 콘텐츠 제공 , 구매 및 요금 결제 , 물품배송 또는 청구지 등 발송 , 금융거래 본인 인증 및 금융 서비스</span><br><span style=\"font-family: gulim; font-size: 12px\">- 회원제 서비스 이용에 따른 본인확인 , 개인 식별<br>- 불량회원의 부정 이용 방지와 비인가 사용 방지 , 가입 의사 확인 , 연령확인 , 불만 등 민원처리 , 고지사항 전달</span><br><span style=\"font-family: gulim; font-size: 12px\">- 마케팅 및 광고에 활용</span><br><span style=\"font-family: gulim; font-size: 12px\">- 접속 빈도 파악 또는 회원의 서비스 이용에 대한 통계</span></p></td></tr></tbody></table></td></tr></tbody></table></td></tr>\r\n\r\n<tr>\r\n\r\n<td> </td></tr>\r\n\r\n<tr>\r\n\r\n<td>\r\n\r\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n\r\n<tbody>\r\n\r\n<tr>\r\n\r\n<td colspan=\"2\">\r\n\r\n<p style=\"margin: 0px\"><strong><span style=\"font-family: gulim; font-size: 13px\">■ 개인정보의 보유 및 이용기간 </span></strong></p></td></tr>\r\n\r\n<tr>\r\n\r\n<td width=\"10\"> </td>\r\n\r\n<td>\r\n\r\n<p style=\"margin: 0px; line-height: 1.6\"><span style=\"font-family: gulim; font-size: 12px\">원칙적으로, 개인정보 수집 및 이용목적이 달성된 후에는 해당 정보를 지체 없이 파기합니다. 단, 다음의 정보에 대해서는 아래의 이유로 명시한 기간 동안 보존합니다.</span></p>\r\n\r\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n\r\n<tbody>\r\n\r\n<tr>\r\n\r\n<td width=\"10\">\r\n\r\n<p style=\"margin: 0px; line-height: 1.6\"><span style=\"font-family: gulim; font-size: 12px\"> </span></p></td>\r\n\r\n<td>\r\n\r\n<p style=\"margin: 0px; line-height: 1.6\"><span style=\"font-family: gulim; font-size: 12px\">보존 항목 : 로그인ID</span><br><span style=\"font-family: gulim; font-size: 12px\">보존 근거 : 재가입, 특정회원 사칭 방지 목적</span><br><span style=\"font-family: gulim; font-size: 12px\">보존 기간 : 5년</span></p></td></tr></tbody></table><br>\r\n\r\n<p style=\"margin: 0px; line-height: 1.6\"><span style=\"font-family: gulim; font-size: 12px\">그리고 관계법령의 규정에 의하여 보존할 필요가 있는 경우 회사는 아래와 같이 관계법령에서 정한 일정한 기간 동안 회원정보를 보관합니다.</span></p>\r\n\r\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n\r\n<tbody>\r\n\r\n<tr>\r\n\r\n<td width=\"10\">\r\n\r\n<p style=\"margin: 0px; line-height: 1.6\"><span style=\"font-family: gulim; font-size: 12px\"> </span></p></td>\r\n\r\n<td>\r\n\r\n<p style=\"margin: 0px; line-height: 1.6\"><span style=\"font-family: gulim; font-size: 12px\">보존 항목 : 이름 , 생년월일 , 성별 , 회사명 , 회사전화번호</span><br><span style=\"font-family: gulim; font-size: 12px\">보존 근거 : 신용정보의 이용 및 보호에 관한 법률</span><br><span style=\"font-family: gulim; font-size: 12px\">보존 기간 : 1년</span></p></td></tr></tbody></table>\r\n\r\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n\r\n<tbody>\r\n\r\n<tr>\r\n\r\n<td width=\"10\">\r\n\r\n<p style=\"margin: 0px; line-height: 1.6\"><span style=\"font-family: gulim; font-size: 12px\"> </span></p></td>\r\n\r\n<td>\r\n\r\n<p style=\"margin: 0px; line-height: 1.6\"><span style=\"font-family: gulim; font-size: 12px\">보존 항목 : 비밀번호 , 비밀번호 질문과 답변 , 전화번호 , 주소 , 휴대전화번호 , 이메일 , 주민등록번호 , 서비스 이용기록</span><br><span style=\"font-family: gulim; font-size: 12px\">보존 근거 : 전자상거래등에서의 소비자보호에 관한 법률</span><br><span style=\"font-family: gulim; font-size: 12px\">보존 기간 : 1년</span></p></td></tr></tbody></table>\r\n\r\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n\r\n<tbody>\r\n\r\n<tr>\r\n\r\n<td width=\"10\">\r\n\r\n<p style=\"margin: 0px; line-height: 1.6\"><span style=\"font-family: gulim; font-size: 12px\"> </span></p></td>\r\n\r\n<td>\r\n\r\n<p style=\"margin: 0px; line-height: 1.6\"><span style=\"font-family: gulim; font-size: 12px\">보존 항목 : 접속 로그 , 쿠키 , 접속 IP 정보</span><br><span style=\"font-family: gulim; font-size: 12px\">보존 근거 : 전자상거래등에서의 소비자보호에 관한 법률</span><br><span style=\"font-family: gulim; font-size: 12px\">보존 기간 : 3년</span></p></td></tr></tbody></table>\r\n\r\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n\r\n<tbody>\r\n\r\n<tr>\r\n\r\n<td width=\"10\">\r\n\r\n<p style=\"margin: 0px; line-height: 1.6\"><span style=\"font-family: gulim; font-size: 12px\"> </span></p></td>\r\n\r\n<td>\r\n\r\n<p style=\"margin: 0px; line-height: 1.6\"><span style=\"font-family: gulim; font-size: 12px\">보존 항목 : 결제기록</span><br><span style=\"font-family: gulim; font-size: 12px\">보존 근거 : 전자상거래등에서의 소비자보호에 관한 법률</span><br><span style=\"font-family: gulim; font-size: 12px\">보존 기간 : 5년</span></p></td></tr></tbody></table>\r\n\r\n<p style=\"margin: 0px; line-height: 1.6\"><span style=\"font-family: gulim\"><br></span><span style=\"font-family: gulim; font-size: 12px\">계약 또는 청약철회 등에 관한 기록 : 5년 (전자상거래등에서의 소비자보호에 관한 법률)</span><br><span style=\"font-family: gulim; font-size: 12px\">대금결제 및 재화 등의 공급에 관한 기록 : 5년 (전자상거래등에서의 소비자보호에 관한 법률)</span><br><span style=\"font-family: gulim; font-size: 12px\">소비자의 불만 또는 분쟁처리에 관한 기록 : 3년 (전자상거래등에서의 소비자보호에 관한 법률)</span><br><span style=\"font-family: gulim; font-size: 12px\">신용정보의 수집/처리 및 이용 등에 관한 기록 : 3년 (신용정보의 이용 및 보호에 관한 법률)</span></p></td></tr></tbody></table></td></tr>\r\n\r\n<tr>\r\n\r\n<td> </td></tr>\r\n\r\n<tr>\r\n\r\n<td>\r\n\r\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n\r\n<tbody>\r\n\r\n<tr>\r\n\r\n<td colspan=\"2\">\r\n\r\n<p style=\"margin: 0px\"><strong><span style=\"font-family: gulim; font-size: 13px\">■ 개인정보의 파기절차 및 방법</span></strong></p></td></tr>\r\n\r\n<tr>\r\n\r\n<td width=\"10\"> </td>\r\n\r\n<td>\r\n\r\n<p style=\"margin: 0px; line-height: 1.6\"><span style=\"font-family: gulim; font-size: 12px\">회사는 원칙적으로 개인정보 수집 및 이용목적이 달성된 후에는 해당 정보를 지체없이 파기합니다. 파기절차 및 방법은 다음과 같습니다.</span></p>\r\n\r\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n\r\n<tbody>\r\n\r\n<tr>\r\n\r\n<td width=\"10\">\r\n\r\n<p style=\"margin: 0px; line-height: 1.6\"><span style=\"font-family: gulim; font-size: 12px\"> </span></p></td>\r\n\r\n<td width=\"120\">\r\n\r\n<p style=\"margin: 0px; line-height: 1.6\"><span style=\"font-family: gulim; font-size: 12px\">파기절차</span></p></td>\r\n\r\n<td>\r\n\r\n<p style=\"margin: 0px; line-height: 1.6\"><span style=\"font-family: gulim; font-size: 12px\">회원님이 회원가입 등을 위해 입력하신 정보는 목적이 달성된 후 별도의 DB로 옮겨져(종이의 경우 별도의 서류함) 내부 방침 및 기타 관련 법령에 의한 정보보호 사유에 따라(보유 및 이용기간 참조) 일정 기간 저장된 후 파기되어집니다. 별도 DB로 옮겨진 개인정보는 법률에 의한 경우가 아니고서는 보유되어지는 이외의 다른 목적으로 이용되지 않습니다.</span></p></td></tr>\r\n\r\n<tr>\r\n\r\n<td> </td>\r\n\r\n<td width=\"120\">\r\n\r\n<p style=\"margin: 0px; line-height: 1.6\"><span style=\"font-family: gulim; font-size: 12px\">파기방법</span></p></td>\r\n\r\n<td>\r\n\r\n<p style=\"margin: 0px; line-height: 1.6\"><span style=\"font-family: gulim; font-size: 12px\">전자적 파일형태로 저장된 개인정보는 기록을 재생할 수 없는 기술적 방법을 사용하여 삭제합니다.</span></p></td></tr></tbody></table></td></tr></tbody></table></td></tr>\r\n\r\n<tr>\r\n\r\n<td> </td></tr>\r\n\r\n<tr>\r\n\r\n<td>\r\n\r\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n\r\n<tbody>\r\n\r\n<tr>\r\n\r\n<td colspan=\"2\">\r\n\r\n<p style=\"margin: 0px\"><strong><span style=\"font-family: gulim; font-size: 13px\">■ 개인정보 제공</span></strong></p></td></tr>\r\n\r\n<tr>\r\n\r\n<td width=\"10\"> </td>\r\n\r\n<td>\r\n\r\n<p style=\"margin: 0px; line-height: 1.6\"><span style=\"font-family: gulim; font-size: 12px\">회사는 이용자의 개인정보를 원칙적으로 외부에 제공하지 않습니다. 다만, 아래의 경우에는 예외로 합니다.</span></p>\r\n\r\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n\r\n<tbody>\r\n\r\n<tr>\r\n\r\n<td width=\"10\">\r\n\r\n<p style=\"margin: 0px; line-height: 1.6\"><span style=\"font-family: gulim; font-size: 12px\"> </span></p></td>\r\n\r\n<td>\r\n\r\n<p style=\"margin: 0px; line-height: 1.6\"><span style=\"font-family: gulim; font-size: 12px\">- 이용자들이 사전에 동의한 경우</span><br><span style=\"font-family: gulim; font-size: 12px\">- 법령의 규정에 의거하거나, 수사 목적으로 법령에 정해진 절차와 방법에 따라 수사기관의 요구가 있는 경우</span></p></td></tr></tbody></table></td></tr></tbody></table></td></tr>\r\n\r\n<tr>\r\n\r\n<td> </td></tr>\r\n\r\n<tr>\r\n\r\n<td>\r\n\r\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n\r\n<tbody>\r\n\r\n<tr>\r\n\r\n<td colspan=\"2\">\r\n\r\n<p style=\"margin: 0px\"><strong><span style=\"font-family: gulim; font-size: 13px\">■ 수집한 개인정보의 위탁</span></strong></p></td></tr>\r\n\r\n<tr>\r\n\r\n<td width=\"10\"> </td>\r\n\r\n<td>\r\n\r\n<p style=\"margin: 0px; line-height: 1.6\"><span style=\"font-family: gulim; font-size: 12px\">회사는 고객님의 동의없이 고객님의 정보를 외부 업체에 위탁하지 않습니다. 향후 그러한 필요가 생길 경우, 위탁 대상자와 위탁 업무 내용에 대해 고객님에게 통지하고 필요한 경우 사전 동의를 받도록 하겠습니다.</span></p></td></tr></tbody></table></td></tr>\r\n\r\n<tr>\r\n\r\n<td> </td></tr>\r\n\r\n<tr>\r\n\r\n<td>\r\n\r\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n\r\n<tbody>\r\n\r\n<tr>\r\n\r\n<td colspan=\"2\">\r\n\r\n<p style=\"margin: 0px\"><strong><span style=\"font-family: gulim; font-size: 13px\">■ 이용자 및 법정대리인의 권리와 그 행사방법 </span></strong></p></td></tr>\r\n\r\n<tr>\r\n\r\n<td width=\"10\"> </td>\r\n\r\n<td>\r\n\r\n<p style=\"margin: 0px; line-height: 1.6\"><span style=\"font-family: gulim; font-size: 12px\">이용자 및 법정 대리인은 언제든지 등록되어 있는 자신 혹은 당해 만 14세 미만 아동의 개인정보를 조회하거나 수정할 수 있으며 가입해지를 요청할 수도 있습니다. 이용자 혹은 만 14세 미만 아동의 개인정보 조회?수정을 위해서는 \'개인정보변경\'(또는 \'회원정보수정\' 등)을 가입해지(동의철회)를 위해서는 \"회원탈퇴\"를 클릭하여 본인 확인 절차를 거치신 후 직접 열람, 정정 또는 탈퇴가 가능합니다. </span><span style=\"font-family: gulim; font-size: 12px\">혹은 개인정보관리책임자에게 서면, 전화 또는 이메일로 연락하시면 지체없이 조치하겠습니다. 귀하가 개인정보의 오류에 대한 정정을 요청하신 경우에는 정정을 완료하기 전까지 당해 개인정보를 이용 또는 제공하지 않습니다. 또한 잘못된 개인정보를 제3자에게 이미 제공한 경우에는 정정 처리결과를 제3자에게 지체없이 통지하여 정정이 이루어지도록 하겠습니다.</span><br><span style=\"font-family: gulim; font-size: 12px\">회사는 이용자 혹은 법정 대리인의 요청에 의해 해지 또는 삭제된 개인정보는 \"회사가 수집하는 개인정보의 보유 및 이용기간\"에 명시된 바에 따라 처리하고 그 외의 용도로 열람 또는 이용할 수 없도록 처리하고 있습니다.</span></p></td></tr></tbody></table></td></tr>\r\n\r\n<tr>\r\n\r\n<td> </td></tr>\r\n\r\n<tr>\r\n\r\n<td>\r\n\r\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n\r\n<tbody>\r\n\r\n<tr>\r\n\r\n<td colspan=\"2\">\r\n\r\n<p style=\"margin: 0px\"><strong><span style=\"font-family: gulim; font-size: 13px\">■ 개인정보 자동수집 장치의 설치, 운영 및 그 거부에 관한 사항</span></strong></p></td></tr>\r\n\r\n<tr>\r\n\r\n<td width=\"10\"> </td>\r\n\r\n<td>\r\n\r\n<p style=\"margin: 0px; line-height: 1.6\"><span style=\"font-family: gulim; font-size: 12px\">회사는 귀하의 정보를 수시로 저장하고 찾아내는 \'쿠키(cookie)\' 등을 운용합니다. 쿠키란 oo의 웹사이트를 운영하는데 이용되는 서버가 귀하의 브라우저에 보내는 아주 작은 텍스트 파일로서 귀하의 컴퓨터 하드디스크에 저장됩니다. 회사은(는) 다음과 같은 목적을 위해 쿠키를 사용합니다.</span></p>\r\n\r\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n\r\n<tbody>\r\n\r\n<tr>\r\n\r\n<td width=\"10\">\r\n\r\n<p style=\"margin: 0px; line-height: 1.6\"><span style=\"font-family: gulim; font-size: 12px\"> </span></p></td>\r\n\r\n<td width=\"120\"><span style=\"font-family: gulim; font-size: 12px\">쿠키 등 사용 목적</span></td>\r\n\r\n<td>\r\n\r\n<p style=\"margin: 0px\"><span style=\"font-family: gulim; font-size: 12px\">회원과 비회원의 접속 빈도나 방문 시간 등을 분석, 이용자의 취향과 관심분야를 파악 및 자취 추적, 각종 이벤트 참여 정도 및 방문 회수 파악 등을 통한 타겟 마케팅 및 개인 맞춤 서비스 제공</span></p><span style=\"font-family: gulim; font-size: 12px\"></span>\r\n\r\n<p style=\"margin: 0px\"><span style=\"font-family: gulim; font-size: 12px\">귀하는 쿠키 설치에 대한 선택권을 가지고 있습니다. 따라서, 귀하는 웹브라우저에서 옵션을 설정함으로써 모든 쿠키를 허용하거나, 쿠키가 저장될 때마다 확인을 거치거나, 아니면 모든 쿠키의 저장을 거부할 수도 있습니다.<br> </span></p></td></tr>\r\n\r\n<tr>\r\n\r\n<td> </td>\r\n\r\n<td width=\"120\"><span style=\"font-size: 12px\">쿠키 설정 거부 방법</span></td>\r\n\r\n<td>\r\n\r\n<p style=\"margin: 0px\"><span style=\"font-family: gulim; font-size: 12px\">예: 쿠키 설정을 거부하는 방법으로는 회원님이 사용하시는 웹 브라우저의 옵션을 선택함으로써 모든 쿠키를 허용하거나 쿠키를 저장할 때마다 확인을 거치거나, 모든 쿠키의 저장을 거부할 수 있습니다. </span></p><span style=\"font-family: gulim; font-size: 12px\"></span>\r\n\r\n<p style=\"margin: 0px\"><span style=\"font-family: gulim; font-size: 12px\">설정방법 예(인터넷 익스플로어의 경우)</span><br><span style=\"font-family: gulim; font-size: 12px\">: 웹 브라우저 상단의 도구 > 인터넷 옵션 > 개인정보</span><br><span style=\"font-family: gulim; font-size: 12px\">(단, 귀하께서 쿠키 설치를 거부하였을 경우 서비스 제공에 어려움이 있을 수 있습니다.)</span> </p></td></tr></tbody></table></td></tr></tbody></table></td></tr>\r\n\r\n<tr>\r\n\r\n<td> </td></tr>\r\n\r\n<tr>\r\n\r\n<td>\r\n\r\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n\r\n<tbody>\r\n\r\n<tr>\r\n\r\n<td colspan=\"2\">\r\n\r\n<p style=\"margin: 0px\"><strong><span style=\"font-family: gulim; font-size: 13px\">■ 개인정보에 관한 민원서비스</span></strong></p></td></tr>\r\n\r\n<tr>\r\n\r\n<td width=\"10\"> </td>\r\n\r\n<td>\r\n\r\n<p style=\"margin: 0px; line-height: 1.6\"><span style=\"font-family: gulim; font-size: 12px\">회사는 고객의 개인정보를 보호하고 개인정보와 관련한 불만을 처리하기 위하여 아래와 같이 관련 부서 및 개인정보관리책임자를 지정하고 있습니다.<br> </span></p>\r\n\r\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n\r\n<tbody>\r\n\r\n<tr>\r\n\r\n<td width=\"10\">\r\n\r\n<p style=\"margin: 0px; line-height: 1.6\"><span style=\"font-family: gulim; font-size: 12px\"> </span></p></td>\r\n\r\n<td><span style=\"font-family: gulim; font-size: 12px\">고객서비스담당 부서 : 해피콜센터</span><br><span style=\"font-family: gulim; font-size: 12px\">전화번호 : 02-1234-5678</span><br><span style=\"font-family: gulim; font-size: 12px\">이메일 : info@domain.com</span></td></tr>\r\n\r\n<tr>\r\n\r\n<td> </td>\r\n\r\n<td> </td></tr>\r\n\r\n<tr>\r\n\r\n<td> </td>\r\n\r\n<td><span style=\"font-family: gulim; font-size: 12px\">개인정보관리책임자 성명 : 홍길동</span><br><span style=\"font-family: gulim; font-size: 12px\">전화번호 : 02-1234-5678</span><br><span style=\"font-family: gulim; font-size: 12px\">이메일 : privacy@domain.com</span></td></tr></tbody></table></td></tr></tbody></table></td></tr>\r\n\r\n<tr>\r\n\r\n<td> </td></tr>\r\n\r\n<tr>\r\n\r\n<td>\r\n\r\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n\r\n<tbody>\r\n\r\n<tr>\r\n\r\n<td colspan=\"2\">\r\n\r\n<p style=\"margin: 0px\"><span style=\"font-family: gulim; font-size: 12px\">귀하께서는 회사의 서비스를 이용하시며 발생하는 모든 개인정보보호 관련 민원을 개인정보관리책임자 혹은 담당부서로 신고하실 수 있습니다. 회사는 이용자들의 신고사항에 대해 신속하게 충분한 답변을 드릴 것입니다.</span></p></td></tr>\r\n\r\n<tr>\r\n\r\n<td width=\"10\"><br></td>\r\n\r\n<td>\r\n\r\n<p style=\"margin: 0px; line-height: 1.6\"><span style=\"font-family: gulim; font-size: 12px\">기타 개인정보침해에 대한 신고나 상담이 필요하신 경우에는 아래 기관에 문의하시기 바랍니다.</span></p>\r\n\r\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n\r\n<tbody>\r\n\r\n<tr>\r\n\r\n<td width=\"10\">\r\n\r\n<p style=\"margin: 0px; line-height: 1.6\"><span style=\"font-family: gulim; font-size: 12px\"> </span></p></td>\r\n\r\n<td>\r\n\r\n<p style=\"margin: 0px\"><span style=\"font-family: gulim; font-size: 12px\"><br>1.개인정보침해신고센터 (<a href=\"http://www.1336.or.kr/국번없이\">www.1336.or.kr/국번없이</a> 118)</span><span style=\"font-family: gulim; font-size: 12px\"><br>2.정보보호마크인증위원회 (<a href=\"http://www.eprivacy.or.kr/02-580-0533~4)\">www.eprivacy.or.kr/02-580-0533~4)</a></span><span style=\"font-family: gulim; font-size: 12px\"><br>3.대검찰청 인터넷범죄수사센터 (<a href=\"http://icic.sppo.go.kr/02-3480-3600)\">http://icic.sppo.go.kr/02-3480-3600)</a></span><span style=\"font-family: gulim; font-size: 12px\"><br>4.경찰청 사이버테러대응센터 (<a href=\"http://www.ctrc.go.kr/02-392-0330)\">www.ctrc.go.kr/02-392-0330)</a></span></p></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table>\r\n\r\n<p style=\"margin: 0px\"> </p>',' \r\n\r\n개인정보 취급방침\r\n저희 체험넷 한국인터넷진흥원의 개인정보 취급방침을 준수 합니다.\r\n\r\n저희 체험넷\" 사이버 몰은 (이하 \'회사\'는) 고객님의 개인정보를 중요시하며, \"정보통신망 이용촉진 및 정보보호\"에 관한 법률을 준수하고 있습니다. 회사는 개인정보취급방침을 통하여 고객님께서 제공하시는 개인정보가 어떠한 용도와 방식으로 이용되고 있으며, 개인정보보호를 위해 어떠한 조치가 취해지고 있는지 알려드립니다.\r\n\r\n \r\n개인정보취급방침을 개정하는 경우 웹사이트 공지사항(또는 개별공지)을 통하여 공지할 것입니다.\r\n본 방침은 : 2020 년 07 월 01 일 부터 시행됩니다.\r\n\r\n \r\n■ 수집하는 개인정보 항목\r\n\r\n \r\n회사는 회원가입, 상담, 서비스 신청 등등을 위해 아래와 같은 개인정보를 수집하고 있습니다.\r\n\r\n \r\n\r\n수집항목\r\n\r\n이름 , 생년월일 , 성별 , 로그인ID , 비밀번호 , 비밀번호 질문과 답변 , 자택 전화번호 , 자택 주소 , 휴대전화번호 , 이메일 , 직업 , 회사명 , 회사전화번호 , 주민등록번호 , 신용카드 정보 , 은행계좌 정보 , 서비스 이용기록 , 접속 로그 , 쿠키 , 접속 IP 정보 , 결제기록\r\n\r\n \r\n개인정보 수집방법\r\n\r\n홈페이지(회원가입 및 상품주문) , 글쓰기\r\n\r\n \r\n■ 개인정보의 수집 및 이용목적\r\n\r\n \r\n회사는 수집한 개인정보를 다음의 목적을 위해 활용합니다.\r\n\r\n \r\n\r\n- 서비스 제공에 관한 계약 이행 및 서비스 제공에 따른 요금정산\r\n- 콘텐츠 제공 , 구매 및 요금 결제 , 물품배송 또는 청구지 등 발송 , 금융거래 본인 인증 및 금융 서비스\r\n- 회원제 서비스 이용에 따른 본인확인 , 개인 식별\r\n- 불량회원의 부정 이용 방지와 비인가 사용 방지 , 가입 의사 확인 , 연령확인 , 불만 등 민원처리 , 고지사항 전달\r\n- 마케팅 및 광고에 활용\r\n- 접속 빈도 파악 또는 회원의 서비스 이용에 대한 통계\r\n\r\n \r\n■ 개인정보의 보유 및 이용기간\r\n\r\n \r\n원칙적으로, 개인정보 수집 및 이용목적이 달성된 후에는 해당 정보를 지체 없이 파기합니다. 단, 다음의 정보에 대해서는 아래의 이유로 명시한 기간 동안 보존합니다.\r\n\r\n \r\n\r\n보존 항목 : 로그인ID\r\n보존 근거 : 재가입, 특정회원 사칭 방지 목적\r\n보존 기간 : 5년\r\n\r\n\r\n그리고 관계법령의 규정에 의하여 보존할 필요가 있는 경우 회사는 아래와 같이 관계법령에서 정한 일정한 기간 동안 회원정보를 보관합니다.\r\n\r\n \r\n\r\n보존 항목 : 이름 , 생년월일 , 성별 , 회사명 , 회사전화번호\r\n보존 근거 : 신용정보의 이용 및 보호에 관한 법률\r\n보존 기간 : 1년\r\n\r\n \r\n\r\n보존 항목 : 비밀번호 , 비밀번호 질문과 답변 , 전화번호 , 주소 , 휴대전화번호 , 이메일 , 주민등록번호 , 서비스 이용기록\r\n보존 근거 : 전자상거래등에서의 소비자보호에 관한 법률\r\n보존 기간 : 1년\r\n\r\n \r\n\r\n보존 항목 : 접속 로그 , 쿠키 , 접속 IP 정보\r\n보존 근거 : 전자상거래등에서의 소비자보호에 관한 법률\r\n보존 기간 : 3년\r\n\r\n \r\n\r\n보존 항목 : 결제기록\r\n보존 근거 : 전자상거래등에서의 소비자보호에 관한 법률\r\n보존 기간 : 5년\r\n\r\n\r\n계약 또는 청약철회 등에 관한 기록 : 5년 (전자상거래등에서의 소비자보호에 관한 법률)\r\n대금결제 및 재화 등의 공급에 관한 기록 : 5년 (전자상거래등에서의 소비자보호에 관한 법률)\r\n소비자의 불만 또는 분쟁처리에 관한 기록 : 3년 (전자상거래등에서의 소비자보호에 관한 법률)\r\n신용정보의 수집/처리 및 이용 등에 관한 기록 : 3년 (신용정보의 이용 및 보호에 관한 법률)\r\n\r\n \r\n■ 개인정보의 파기절차 및 방법\r\n\r\n \r\n회사는 원칙적으로 개인정보 수집 및 이용목적이 달성된 후에는 해당 정보를 지체없이 파기합니다. 파기절차 및 방법은 다음과 같습니다.\r\n\r\n \r\n\r\n파기절차\r\n\r\n회원님이 회원가입 등을 위해 입력하신 정보는 목적이 달성된 후 별도의 DB로 옮겨져(종이의 경우 별도의 서류함) 내부 방침 및 기타 관련 법령에 의한 정보보호 사유에 따라(보유 및 이용기간 참조) 일정 기간 저장된 후 파기되어집니다. 별도 DB로 옮겨진 개인정보는 법률에 의한 경우가 아니고서는 보유되어지는 이외의 다른 목적으로 이용되지 않습니다.\r\n\r\n \r\n파기방법\r\n\r\n전자적 파일형태로 저장된 개인정보는 기록을 재생할 수 없는 기술적 방법을 사용하여 삭제합니다.\r\n\r\n \r\n■ 개인정보 제공\r\n\r\n \r\n회사는 이용자의 개인정보를 원칙적으로 외부에 제공하지 않습니다. 다만, 아래의 경우에는 예외로 합니다.\r\n\r\n \r\n\r\n- 이용자들이 사전에 동의한 경우\r\n- 법령의 규정에 의거하거나, 수사 목적으로 법령에 정해진 절차와 방법에 따라 수사기관의 요구가 있는 경우\r\n\r\n \r\n■ 수집한 개인정보의 위탁\r\n\r\n \r\n회사는 고객님의 동의없이 고객님의 정보를 외부 업체에 위탁하지 않습니다. 향후 그러한 필요가 생길 경우, 위탁 대상자와 위탁 업무 내용에 대해 고객님에게 통지하고 필요한 경우 사전 동의를 받도록 하겠습니다.\r\n\r\n \r\n■ 이용자 및 법정대리인의 권리와 그 행사방법\r\n\r\n \r\n이용자 및 법정 대리인은 언제든지 등록되어 있는 자신 혹은 당해 만 14세 미만 아동의 개인정보를 조회하거나 수정할 수 있으며 가입해지를 요청할 수도 있습니다. 이용자 혹은 만 14세 미만 아동의 개인정보 조회?수정을 위해서는 \'개인정보변경\'(또는 \'회원정보수정\' 등)을 가입해지(동의철회)를 위해서는 \"회원탈퇴\"를 클릭하여 본인 확인 절차를 거치신 후 직접 열람, 정정 또는 탈퇴가 가능합니다. 혹은 개인정보관리책임자에게 서면, 전화 또는 이메일로 연락하시면 지체없이 조치하겠습니다. 귀하가 개인정보의 오류에 대한 정정을 요청하신 경우에는 정정을 완료하기 전까지 당해 개인정보를 이용 또는 제공하지 않습니다. 또한 잘못된 개인정보를 제3자에게 이미 제공한 경우에는 정정 처리결과를 제3자에게 지체없이 통지하여 정정이 이루어지도록 하겠습니다.\r\n회사는 이용자 혹은 법정 대리인의 요청에 의해 해지 또는 삭제된 개인정보는 \"회사가 수집하는 개인정보의 보유 및 이용기간\"에 명시된 바에 따라 처리하고 그 외의 용도로 열람 또는 이용할 수 없도록 처리하고 있습니다.\r\n\r\n \r\n■ 개인정보 자동수집 장치의 설치, 운영 및 그 거부에 관한 사항\r\n\r\n \r\n회사는 귀하의 정보를 수시로 저장하고 찾아내는 \'쿠키(cookie)\' 등을 운용합니다. 쿠키란 oo의 웹사이트를 운영하는데 이용되는 서버가 귀하의 브라우저에 보내는 아주 작은 텍스트 파일로서 귀하의 컴퓨터 하드디스크에 저장됩니다. 회사은(는) 다음과 같은 목적을 위해 쿠키를 사용합니다.\r\n\r\n \r\n\r\n쿠키 등 사용 목적\r\n회원과 비회원의 접속 빈도나 방문 시간 등을 분석, 이용자의 취향과 관심분야를 파악 및 자취 추적, 각종 이벤트 참여 정도 및 방문 회수 파악 등을 통한 타겟 마케팅 및 개인 맞춤 서비스 제공\r\n\r\n귀하는 쿠키 설치에 대한 선택권을 가지고 있습니다. 따라서, 귀하는 웹브라우저에서 옵션을 설정함으로써 모든 쿠키를 허용하거나, 쿠키가 저장될 때마다 확인을 거치거나, 아니면 모든 쿠키의 저장을 거부할 수도 있습니다.\r\n \r\n\r\n 쿠키 설정 거부 방법\r\n예: 쿠키 설정을 거부하는 방법으로는 회원님이 사용하시는 웹 브라우저의 옵션을 선택함으로써 모든 쿠키를 허용하거나 쿠키를 저장할 때마다 확인을 거치거나, 모든 쿠키의 저장을 거부할 수 있습니다.\r\n\r\n설정방법 예(인터넷 익스플로어의 경우)\r\n: 웹 브라우저 상단의 도구 > 인터넷 옵션 > 개인정보\r\n(단, 귀하께서 쿠키 설치를 거부하였을 경우 서비스 제공에 어려움이 있을 수 있습니다.) \r\n\r\n \r\n■ 개인정보에 관한 민원서비스\r\n\r\n \r\n회사는 고객의 개인정보를 보호하고 개인정보와 관련한 불만을 처리하기 위하여 아래와 같이 관련 부서 및 개인정보관리책임자를 지정하고 있습니다.\r\n \r\n\r\n \r\n\r\n고객서비스담당 부서 : 해피콜센터\r\n전화번호 : 02-1234-5678\r\n이메일 : info@domain.com\r\n  \r\n 개인정보관리책임자 성명 : 홍길동\r\n전화번호 : 02-1234-5678\r\n이메일 : privacy@domain.com\r\n \r\n귀하께서는 회사의 서비스를 이용하시며 발생하는 모든 개인정보보호 관련 민원을 개인정보관리책임자 혹은 담당부서로 신고하실 수 있습니다. 회사는 이용자들의 신고사항에 대해 신속하게 충분한 답변을 드릴 것입니다.\r\n\r\n\r\n기타 개인정보침해에 대한 신고나 상담이 필요하신 경우에는 아래 기관에 문의하시기 바랍니다.\r\n\r\n \r\n\r\n\r\n1.개인정보침해신고센터 (www.1336.or.kr/국번없이 118)\r\n2.정보보호마크인증위원회 (www.eprivacy.or.kr/02-580-0533~4)\r\n3.대검찰청 인터넷범죄수사센터 (http://icic.sppo.go.kr/02-3480-3600)\r\n4.경찰청 사이버테러대응센터 (www.ctrc.go.kr/02-392-0330)\r\n\r\n \r\n\r\n','dd','dd','dd');
/*!40000 ALTER TABLE `sw_text_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sw_visual`
--

DROP TABLE IF EXISTS `sw_visual`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sw_visual` (
  `idx` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `buse` enum('Y','N') DEFAULT 'Y',
  `gubun` enum('P','M') DEFAULT 'P',
  `seq` int(3) DEFAULT '1',
  `title` varchar(100) DEFAULT NULL,
  `img` varchar(30) DEFAULT NULL,
  `target` varchar(10) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `regdt` datetime DEFAULT NULL,
  PRIMARY KEY (`idx`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sw_visual`
--

LOCK TABLES `sw_visual` WRITE;
/*!40000 ALTER TABLE `sw_visual` DISABLE KEYS */;
/*!40000 ALTER TABLE `sw_visual` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-08-31 17:04:25
