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

/*Table structure for table `booking` */

DROP TABLE IF EXISTS `booking`;

CREATE TABLE `booking` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tgl` date DEFAULT NULL,
  `id_pelanggan` bigint(20) DEFAULT NULL,
  `id_gedung` bigint(20) DEFAULT NULL,
  `nama_pemesan` varchar(50) DEFAULT NULL,
  `alamat` text,
  `provinsi` text,
  `kota` text,
  `kodepos` varchar(6) DEFAULT NULL,
  `telp` varchar(15) DEFAULT NULL,
  `waktu` varchar(1) DEFAULT NULL,
  `harga` double DEFAULT NULL,
  `konfirmasi` varchar(1) DEFAULT NULL,
  `acc` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_booking_id_pelanggan` (`id_pelanggan`),
  KEY `FK_booking_id_gedung` (`id_gedung`),
  CONSTRAINT `FK_booking_id_gedung` FOREIGN KEY (`id_gedung`) REFERENCES `gedung` (`id`),
  CONSTRAINT `FK_booking_id_pelanggan` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

/*Data for the table `booking` */

insert  into `booking`(`id`,`tgl`,`id_pelanggan`,`id_gedung`,`nama_pemesan`,`alamat`,`provinsi`,`kota`,`kodepos`,`telp`,`waktu`,`harga`,`konfirmasi`,`acc`) values (1,'2015-09-03',1,1,'Rifky','Semarang','Jawa Tengah','Semarang','15000','085641099333','1',22500000,'1','1'),(2,'2015-09-03',1,1,'Rifky','Semarang','Jawa Tengah','Semarang','15000','085641099333','2',25000000,'1','1'),(3,'2015-09-03',1,2,'Rifky','Semarang','Jawa Tengah','Semarang','15000','085641099333','1',6000000,'0','0'),(4,'2015-09-03',1,2,'Rifky','Semarang','Jawa Tengah','Semarang','15000','085641099333','2',7000000,'0','0'),(5,'2015-09-03',1,3,'Rifky','Semarang','Jawa Tengah','Semarang','15000','085641099333','1',5500000,'0','0'),(6,'2015-09-03',1,3,'Rifky','Semarang','Jawa Tengah','Semarang','15000','085641099333','2',6500000,'0','0'),(7,'2015-09-04',1,2,'Rifky','Semarang','Jawa Tengah','Semarang','15000','085641099333','2',7000000,'1','2'),(8,'2015-09-15',1,2,'Zulfikar','Surabaya','Jawa Timur ','Surabaya','25000','085641099333','2',7000000,'0','0'),(9,'2015-09-15',1,3,'Kadir Mubarak','Jl. Musi No 23','Sumatera Selatan ','Lampung','14045','085641099333','1',5500000,'0','0'),(10,'2015-09-15',1,3,'Budi Darmono','Jl. Sepanjang V No 51','Jawa Barat ','Cirebon','56789','085641099333','2',6500000,'1','1'),(11,'2015-09-17',1,1,'Teguh Prakoso','Jl Parang Barong','Jawa Tengah ','Semarang','15000','0247057367','1',22500000,'1','0'),(12,'2015-09-12',1,1,'Aji Jaya','Sampangan','Jawa Tengah ','Semarang','14045','08672663726','2',30000000,'1','0'),(13,'2015-09-20',1,2,'Ibu ibu PKK','Dimana','Aceh, D.I ','Aceh','30000','08347583421','1',8000000,'0','0');

/*Table structure for table `booking_catering` */

DROP TABLE IF EXISTS `booking_catering`;

CREATE TABLE `booking_catering` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_booking` bigint(20) DEFAULT NULL,
  `id_catering` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_booking_catering_id_booking` (`id_booking`),
  KEY `FK_booking_catering_id_catering` (`id_catering`),
  CONSTRAINT `FK_booking_catering_id_booking` FOREIGN KEY (`id_booking`) REFERENCES `booking` (`id`),
  CONSTRAINT `FK_booking_catering_id_catering` FOREIGN KEY (`id_catering`) REFERENCES `catering` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `booking_catering` */

insert  into `booking_catering`(`id`,`id_booking`,`id_catering`) values (1,1,4),(2,10,5);

/*Table structure for table `catering` */

DROP TABLE IF EXISTS `catering`;

CREATE TABLE `catering` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) DEFAULT NULL,
  `alamat` text,
  `telepon` text,
  `dp` double DEFAULT NULL,
  `img` text,
  `brosur` text,
  `link` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `catering` */

insert  into `catering`(`id`,`nama`,`alamat`,`telepon`,`dp`,`img`,`brosur`,`link`) values (1,'Wina Al Husna Catering','Jl Supriyadi, Kalicari II / 38 Semarang','(024)6730956 / 08562716685',1000000,'1.jpg','-','http://www.winaalhusna.com/'),(2,'Cipta Jaya Catering','Jl Kanguru Utara Raya No.66 RT 08 RW 03 Gayamsari Semarang','081325697666',1000000,'2.jpg','-','http://www.ciptadjayacatering.com/'),(3,'Sridiva Catering','Jl Kasipah 23 Candi Lama Semarang','(024)8315043',1000000,'3.jpg','3.pdf','-'),(4,'Ibu Sri Catering','Jl Taman Tegalsari 1 No.9 Semarang','(024)8453816 / 081901197842',1000000,'4.jpg','4.pdf','-'),(5,'Lis Catering','Jl Bledak Kantil 3 No. 6, Tlogosari, Semarang','(024)6713475',1000000,'5.jpg','5.pdf','-'),(6,'Shella Catering','Jl Tlogosari Raya No.1 Semarang','(024)6706174',1000000,'6.jpg','6.pdf','-'),(7,'Raos Catering','Jl Plamongan Indah Blok D.17','(024)6746509',1000000,'7.jpg','7.pdf','-'),(8,'Berkah Catering','Jl Lempongsari 360, Semarang','(024)8314423',1000000,'8.jpg','8.jpg','-'),(9,'Citra Rasa Katering','Hanoman Raya II/13 Perumnas Krapyak Semarang','(024)7600765 / 0818294536',1000000,'9.jpg','9.pdf','-');

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

/*Table structure for table `jadwal_catering` */

DROP TABLE IF EXISTS `jadwal_catering`;

CREATE TABLE `jadwal_catering` (
  `id_catering` bigint(20) DEFAULT NULL,
  `tgl` date DEFAULT NULL,
  KEY `FK_jadwal_catering_id_catering` (`id_catering`),
  CONSTRAINT `FK_jadwal_catering_id_catering` FOREIGN KEY (`id_catering`) REFERENCES `catering` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `jadwal_catering` */

insert  into `jadwal_catering`(`id_catering`,`tgl`) values (4,'2015-09-03'),(5,'2015-09-15');

/*Table structure for table `konfirmasi` */

DROP TABLE IF EXISTS `konfirmasi`;

CREATE TABLE `konfirmasi` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_booking` bigint(20) DEFAULT NULL,
  `tgl` date DEFAULT NULL,
  `bank` varchar(20) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `jumlah` double DEFAULT NULL,
  `keterangan` text,
  `img` text,
  PRIMARY KEY (`id`),
  KEY `FK_konfirmasi_id_booking` (`id_booking`),
  CONSTRAINT `FK_konfirmasi_id_booking` FOREIGN KEY (`id_booking`) REFERENCES `booking` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `konfirmasi` */

insert  into `konfirmasi`(`id`,`id_booking`,`tgl`,`bank`,`nama`,`jumlah`,`keterangan`,`img`) values (1,1,'2015-09-05','BCA','Rifky',2000000,'','-'),(2,2,'2015-09-05','BCA','Rifky',2000000,'','-'),(3,11,'2015-09-05','Mandiri','Rifky',2000000,'ini keterangan','82647705.jpg'),(4,12,'2015-09-05','CIMB Niaga','Erlian',2000000,'','26803589.jpg'),(5,7,'2015-09-06','Bank Jateng','Jono',2000000,'','-'),(6,10,'2015-09-06','BJB','Shela Mariana',2000000,'','20159912.jpg');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `pelanggan` */

insert  into `pelanggan`(`id`,`nama`,`gender`,`alamat`,`email`,`telp`,`username`,`password`,`status`) values (1,'Rifky Zulfikar','L','Parangkusumo 1 No 30 Semarang','rifkyzulfikar92@gmail.com','085641099333','a','a','1'),(4,'Erlian','P','Tlogosari','erlianhusnaf@gmail.com','08562666717','erlian','erlian','1');

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
