/*
SQLyog Ultimate v9.20 
MySQL - 5.5.5-10.1.21-MariaDB : Database - myapps
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`myapps` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `myapps`;

/*Table structure for table `absen_siswa` */

DROP TABLE IF EXISTS `absen_siswa`;

CREATE TABLE `absen_siswa` (
  `id_absen` int(50) NOT NULL AUTO_INCREMENT,
  `id_siswa` int(10) DEFAULT NULL,
  `id_kelas` int(10) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `absen` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id_absen`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `absen_siswa` */

insert  into `absen_siswa`(`id_absen`,`id_siswa`,`id_kelas`,`tanggal`,`absen`) values (1,3,3,'2017-11-22','Sakit'),(2,1,7,'2017-11-15','Alpha'),(3,2,8,'2018-01-09','Izin');

/*Table structure for table `admin` */

DROP TABLE IF EXISTS `admin`;

CREATE TABLE `admin` (
  `id_admin` int(10) NOT NULL AUTO_INCREMENT,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_admin`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `admin` */

insert  into `admin`(`id_admin`,`nama_lengkap`,`username`,`password`) values (1,'Administrator','admin','21232f297a57a5a743894a0e4a801fc3');

/*Table structure for table `berita` */

DROP TABLE IF EXISTS `berita`;

CREATE TABLE `berita` (
  `id_berita` int(10) NOT NULL AUTO_INCREMENT,
  `judul_berita` varchar(100) DEFAULT NULL,
  `deskripsi` text,
  `file` varchar(200) DEFAULT NULL,
  `tgl_posting` date DEFAULT NULL,
  PRIMARY KEY (`id_berita`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `berita` */

insert  into `berita`(`id_berita`,`judul_berita`,`deskripsi`,`file`,`tgl_posting`) values (1,'Left 4 Dead 2','Left 4 Dead 2','250px-Left4Dead2.jpg','2017-11-19'),(2,'Battlefield 2','Battlefield 2','74242_front.jpg','2017-11-18'),(3,'Resident Evil 6','Resident Evil 6','Resident_Evil_6.jpg','2017-11-21'),(7,'Pro Evolution Soccer 2013','Pro Evolution Soccer 2013','1511102771015.jpg','2017-11-15');

/*Table structure for table `buku` */

DROP TABLE IF EXISTS `buku`;

CREATE TABLE `buku` (
  `id_buku` int(10) NOT NULL AUTO_INCREMENT,
  `judul` varchar(100) DEFAULT NULL,
  `pengarang` varchar(100) DEFAULT NULL,
  `id_kategori` int(10) DEFAULT NULL,
  `id_lokasi` int(10) DEFAULT NULL,
  `isbn` int(10) DEFAULT NULL,
  PRIMARY KEY (`id_buku`),
  KEY `FK_buku_kategori` (`id_kategori`),
  KEY `FK_buku_lokasi` (`id_lokasi`),
  CONSTRAINT `FK_buku_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON UPDATE NO ACTION,
  CONSTRAINT `FK_buku_lokasi` FOREIGN KEY (`id_lokasi`) REFERENCES `lokasi` (`id_lokasi`) ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `buku` */

insert  into `buku`(`id_buku`,`judul`,`pengarang`,`id_kategori`,`id_lokasi`,`isbn`) values (1,'Sistem Pernafasan','Suryadus Prime',3,3,65657483),(2,'Belajar Kosa Kata','Cassandra Jessica Vionita',1,3,99008877),(5,'Technical Death Metal','Yeni',3,2,2147483647);

/*Table structure for table `ebook` */

DROP TABLE IF EXISTS `ebook`;

CREATE TABLE `ebook` (
  `id_ebook` int(10) NOT NULL AUTO_INCREMENT,
  `judul` varchar(100) DEFAULT NULL,
  `deskripsi` text,
  `id_kategori` int(10) DEFAULT NULL,
  `gambar` varchar(250) DEFAULT NULL,
  `file` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id_ebook`),
  KEY `FK_ebook_kategori` (`id_kategori`),
  CONSTRAINT `FK_ebook_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `ebook` */

insert  into `ebook`(`id_ebook`,`judul`,`deskripsi`,`id_kategori`,`gambar`,`file`) values (2,'Belajar Pemrograman Python Dasar','Belajar Pemrograman Python Dasar',2,'1510848529377.png','1510848529377.pdf'),(3,'Land Of The Dead','Negeri Orang Mati',6,'1510849199217.jpg','1510849199217.pdf'),(4,'SMA 11 Matematika Program Bahasa','SMA 11 Matematika Program Bahasa',1,'1510930765632.JPG','1510930699149.pdf'),(5,'Hidayah Sang Bodyguard','Hidayah Sang Bodyguard',6,'1510930917958.jpg','1510930917958.pdf'),(6,'Belajar Framework Symfony','Belajar Framework Symfony',2,'1510932066055.jpg','1510932066055.pdf'),(7,'Elearning With Moodle','Elearning With Moodle',2,'1510999603375.jpg','1510999603375.pdf');

/*Table structure for table `guru` */

DROP TABLE IF EXISTS `guru`;

CREATE TABLE `guru` (
  `id_guru` int(10) NOT NULL AUTO_INCREMENT,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `alamat` text,
  `telp` varchar(15) DEFAULT NULL,
  `id_mapel` int(10) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_guru`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `guru` */

insert  into `guru`(`id_guru`,`nama_lengkap`,`alamat`,`telp`,`id_mapel`,`username`,`password`) values (1,'Agustina Rohaini','Bantar Gebang','081354657687',3,'agustina','agustina'),(2,'Andik Primayuda','Taman Raya','081266774354',2,'andik','andik'),(3,'Rayvandy Winata','Jati Mulya','087854657212',4,'rayvandy','rayvandy'),(4,'Untoro Edi Saputro','Kranggan','085645654543',1,'untoro','untoro');

/*Table structure for table `jadwal` */

DROP TABLE IF EXISTS `jadwal`;

CREATE TABLE `jadwal` (
  `id_jadwal` int(50) NOT NULL AUTO_INCREMENT,
  `id_guru` int(10) DEFAULT NULL,
  `id_kelas` int(10) DEFAULT NULL,
  `hari` varchar(20) DEFAULT NULL,
  `jam` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_jadwal`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `jadwal` */

insert  into `jadwal`(`id_jadwal`,`id_guru`,`id_kelas`,`hari`,`jam`) values (1,2,5,'Selasa','07:00 - 09:00'),(2,1,3,'Rabu','13:00 - 14:30'),(3,4,1,'Jumat','10:00 - 11:30');

/*Table structure for table `kategori` */

DROP TABLE IF EXISTS `kategori`;

CREATE TABLE `kategori` (
  `id_kategori` int(50) NOT NULL AUTO_INCREMENT,
  `kategori` varchar(50) DEFAULT NULL,
  `buku` int(10) DEFAULT NULL,
  `berita` int(10) DEFAULT NULL,
  `ebook` int(10) DEFAULT NULL,
  PRIMARY KEY (`id_kategori`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Data for the table `kategori` */

insert  into `kategori`(`id_kategori`,`kategori`,`buku`,`berita`,`ebook`) values (1,'Mata Pelajaran',0,1,1),(2,'Teknologi',0,1,1),(3,'Ilmu Pengetahuan Alam',1,0,0),(4,'Sejarah',1,1,1),(5,'Olahraga',1,1,0),(6,'Cerpen',0,0,1),(7,'Ekonomi',1,1,0),(8,'Matematika',1,0,0),(9,'Bahasa Inggris',1,0,0),(10,'Fisika',1,0,0),(11,'Bahasa Jepang',1,0,0),(12,'Kamus Bahasa',0,0,1);

/*Table structure for table `kelas` */

DROP TABLE IF EXISTS `kelas`;

CREATE TABLE `kelas` (
  `id_kelas` int(10) NOT NULL AUTO_INCREMENT,
  `kelas` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_kelas`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

/*Data for the table `kelas` */

insert  into `kelas`(`id_kelas`,`kelas`) values (1,'X 1'),(2,'X 2'),(3,'X 3'),(4,'X 4'),(5,'X 5'),(6,'X 6'),(7,'X 7'),(8,'X 8'),(9,'XI IPA 1'),(10,'XI IPA 2'),(11,'XI IPA 3'),(12,'XI IPA 4'),(13,'XI IPA 5'),(14,'XI IPS 1'),(15,'XI IPS 2'),(16,'XI IPS 3'),(17,'XII IPA 1'),(18,'XII IPA 2'),(19,'XII IPA 3'),(20,'XII IPA 4'),(21,'XII IPA 5'),(22,'XII IPS 1'),(23,'XII IPS 2'),(24,'XII IPS 3');

/*Table structure for table `lokasi` */

DROP TABLE IF EXISTS `lokasi`;

CREATE TABLE `lokasi` (
  `id_lokasi` int(10) NOT NULL AUTO_INCREMENT,
  `lokasi` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id_lokasi`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `lokasi` */

insert  into `lokasi`(`id_lokasi`,`lokasi`) values (1,'Rak 1'),(2,'Rak 2'),(3,'Rak 3');

/*Table structure for table `mapel` */

DROP TABLE IF EXISTS `mapel`;

CREATE TABLE `mapel` (
  `id_mapel` int(10) NOT NULL AUTO_INCREMENT,
  `mapel` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_mapel`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

/*Data for the table `mapel` */

insert  into `mapel`(`id_mapel`,`mapel`) values (1,'Bahasa Indonesia'),(2,'Matematika'),(3,'Agama Islam'),(4,'Pendidikan Kewarganegaraan'),(5,'Bahasa Inggris'),(6,'Sejarah'),(7,'Geografi'),(8,'Ekonomi'),(9,'Sosiologi'),(10,'Biologi'),(11,'Kimia'),(12,'Fisika'),(13,'Teknologi Informasi & Komunikasi'),(14,'Pendidikan Jasmani & Rohani'),(15,'Bahasa Sunda'),(16,'Kesenian Dan Budaya'),(17,'Bahasa Jepang');

/*Table structure for table `siswa` */

DROP TABLE IF EXISTS `siswa`;

CREATE TABLE `siswa` (
  `id_siswa` int(50) NOT NULL AUTO_INCREMENT,
  `nip` varchar(20) DEFAULT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `alamat` text,
  `telp` varchar(12) DEFAULT NULL,
  `agama` varchar(10) DEFAULT NULL,
  `foto_siswa` varchar(200) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `id_kelas` int(10) DEFAULT NULL,
  `status_siswa` int(10) DEFAULT NULL,
  PRIMARY KEY (`id_siswa`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `siswa` */

insert  into `siswa`(`id_siswa`,`nip`,`nama_lengkap`,`tempat_lahir`,`tanggal_lahir`,`alamat`,`telp`,`agama`,`foto_siswa`,`email`,`password`,`id_kelas`,`status_siswa`) values (1,'12133016','Suryana','Jakarta','1994-09-30','Tambun Selatan','089630332445','Islam','1511354481874.png','suryana.ryan009@gmail.com','siswa',7,1),(2,'12131213','Ramdani','Jakarta','1994-03-10','Jakarta Selatan','081345676543','Islam','1511354663117.jpg','ramdani_dani@gmail.com','siswa',4,1),(3,'12136677','Ficca Nuary Pramutya','Padang','1994-01-19','Taman Raya','085954657687','Islam','1511354718442.jpg','ficca19@gmail.com','siswa',3,1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
