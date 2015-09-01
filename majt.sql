/*
SQLyog Ultimate v8.82 
MySQL - 5.6.24 : Database - majt
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`majt` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `majt`;

/*Table structure for table `gedung` */

DROP TABLE IF EXISTS `gedung`;

CREATE TABLE `gedung` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) DEFAULT NULL,
  `kapasitas` text,
  `dp` double DEFAULT NULL,
  `img` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `gedung` */

insert  into `gedung`(`id`,`nama`,`kapasitas`,`dp`,`img`) values (1,'Convention Hall','Standing party 2000 orang, theater 1500 orang, round table 500 orang',2000000,'1.jpg'),(2,'Gedung Perpustakaan','Standing party 600 orang',2000000,'2.jpg'),(3,'Office Hall Lt. 2','Standing party 700 orang',2000000,'3.jpg');

/*Table structure for table `harga_gedung` */

DROP TABLE IF EXISTS `harga_gedung`;

CREATE TABLE `harga_gedung` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_gedung` bigint(20) DEFAULT NULL,
  `hari` int(11) DEFAULT NULL COMMENT 'dayofweek, 0 sunday till 6 saturday',
  `waktu` varchar(1) DEFAULT NULL COMMENT '1=siang, 2=malam',
  `harga` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_harga_gedung_id_gedung` (`id_gedung`),
  CONSTRAINT `FK_harga_gedung_id_gedung` FOREIGN KEY (`id_gedung`) REFERENCES `gedung` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

/*Data for the table `harga_gedung` */

insert  into `harga_gedung`(`id`,`id_gedung`,`hari`,`waktu`,`harga`) values (1,1,0,'1',27500000),(2,1,0,'2',30000000),(3,1,1,'1',22500000),(4,1,1,'2',25000000),(5,1,2,'1',22500000),(6,1,2,'2',25000000),(7,1,3,'1',22500000),(8,1,3,'2',25000000),(9,1,4,'1',22500000),(10,1,4,'2',25000000),(11,1,5,'1',22500000),(12,1,5,'2',25000000),(13,1,6,'1',27500000),(14,1,6,'2',30000000),(15,2,0,'1',8000000),(16,2,0,'2',9000000),(17,2,1,'1',6000000),(18,2,1,'2',7000000),(19,2,2,'1',6000000),(20,2,2,'2',7000000),(21,2,3,'1',6000000),(22,2,3,'2',7000000),(23,2,4,'1',6000000),(24,2,4,'2',7000000),(25,2,5,'1',6000000),(26,2,5,'2',7000000),(27,2,6,'1',8000000),(28,2,6,'2',9000000),(29,3,0,'1',7500000),(30,3,0,'2',8500000),(31,3,1,'1',5500000),(32,3,1,'2',6500000),(33,3,2,'1',5500000),(34,3,2,'2',6500000),(35,3,3,'1',5500000),(36,3,3,'2',6500000),(37,3,4,'1',5500000),(38,3,4,'2',6500000),(39,3,5,'1',5500000),(40,3,5,'2',6500000),(41,3,6,'1',7500000),(42,3,6,'2',8500000);

/*Table structure for table `pelanggan` */

DROP TABLE IF EXISTS `pelanggan`;

CREATE TABLE `pelanggan` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) DEFAULT NULL,
  `gender` varchar(1) DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `telp` varchar(15) DEFAULT NULL,
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(20) DEFAULT NULL,
  `status` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `pelanggan` */

insert  into `pelanggan`(`id`,`nama`,`gender`,`alamat`,`email`,`telp`,`username`,`password`,`status`) values (1,'Rifky Zulfikar','L','Parangkusumo 1 No 30 Semarang','rifkyzulfikar92@gmail.com','085641099333','a','a','1');

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) DEFAULT NULL,
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(20) DEFAULT NULL,
  `privilege` varchar(1) DEFAULT NULL,
  `status` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `user` */

insert  into `user`(`id`,`nama`,`username`,`password`,`privilege`,`status`) values (1,'Rifky Zulfikar','admin','admin','1','1');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
