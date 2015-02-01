/*
SQLyog Enterprise - MySQL GUI v7.15 
MySQL - 5.1.73-1 : Database - aexomanager
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`aexomanager` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `aexomanager`;

/*Table structure for table `comprobantecompra` */

DROP TABLE IF EXISTS `comprobantecompra`;

CREATE TABLE `comprobantecompra` (
  `idComprobanteCpr` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `importeSiva` float DEFAULT NULL,
  `importeTotal` float DEFAULT NULL,
  `cuitProveedor` varchar(13) DEFAULT NULL,
  `nombreProveedor` varchar(256) DEFAULT NULL,
  `descripcion` varchar(256) DEFAULT NULL,
  `idTipoComprobante` int(11) DEFAULT NULL,
  `nroComprobante` varchar(12) DEFAULT NULL,
  `nroSerie` varchar(4) DEFAULT NULL,
  `fechaCreacion` datetime DEFAULT NULL,
  PRIMARY KEY (`idComprobanteCpr`),
  KEY `FK_comprobanteventa` (`idTipoComprobante`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

/*Data for the table `comprobantecompra` */

insert  into `comprobantecompra`(`idComprobanteCpr`,`fecha`,`importeSiva`,`importeTotal`,`cuitProveedor`,`nombreProveedor`,`descripcion`,`idTipoComprobante`,`nroComprobante`,`nroSerie`,`fechaCreacion`) values (2,'2015-01-08',0,10711,'345','ARGENTINA CARGO','',1,'55','534','2015-01-22 12:11:15'),(3,'2015-01-07',1795.72,1795.72,'1','SEC','SEC',1,'1','','2015-01-18 12:53:16'),(4,'2015-01-07',214.88,214.88,'1','INACAP','INACAP',1,'1','1','2015-01-18 12:54:14'),(5,'2015-01-07',448.93,448.93,'2','FAECYS','FAECYS',1,'2','1','2015-01-18 12:56:11'),(6,'2015-01-14',43298,43298,'2','SUSS','SUSS',1,'2','1','2015-01-18 13:01:35'),(7,'2014-12-18',6080,7356.8,'33-71130548-9','IDEA FABRIL SA','20 UNIDADES TAPAS PLASTICAS',1,'0001-0000054','','2015-01-19 08:29:12'),(8,'2014-12-23',13.76,17.48,'33-69509841-9','TELMEX ARGENTINA SA','TELEFONIA',1,'0016-0243082','','2015-01-19 08:31:03'),(9,'2015-01-02',524.57,524.57,'30-55449764-7','CITY MEDICAL SERVICE SA','SERVICIOS MEDICOS',1,'0003-0000115','','2015-01-19 08:33:54'),(10,'2015-01-19',563.64,848.18,'1','TELEFONICA','TELEFONICA',1,'1','','2015-01-19 08:34:58'),(11,'2015-01-13',1356.2,1701,'1','ELTA','MATAFUEGOS',1,'0001-0000984','','2015-01-19 08:46:25'),(12,'2014-12-31',287.6,348,'1','FISCHETTI','SODA',1,'0001-0017014','','2015-01-19 08:47:40'),(13,'2015-01-08',2130,2577.3,'º','SOLMEC','SOLDADOR',1,'0001-0000240','','2015-01-19 08:48:27'),(14,'2014-12-15',864,1045.44,'1','LAAPSA','KLANSEN 227',1,'0006-0001009','','2015-01-19 08:50:22'),(15,'2014-12-31',9814.2,11875.2,'27-23853065-8','GARCIA','FUNDICION',1,'0001-0000097','','2015-01-19 08:51:15'),(16,'2015-01-13',3150,3811.5,'1','GARCIA','FUNDICION',1,'0001-0000097','','2015-01-19 08:51:46'),(17,'2015-01-12',600,726,'1','THERMAL','CALENTITO',1,'0001-0004837','','2015-01-19 08:53:58'),(18,'2015-01-08',5745.39,6951.92,'1','LIT ALUMINIO','CAÑO',1,'0001-0007273','','2015-01-19 09:12:37'),(19,'2015-01-12',78438,78438,'1','GALENO','',1,'0001-000001','','2015-01-19 09:20:19');

/*Table structure for table `comprobanteventa` */

DROP TABLE IF EXISTS `comprobanteventa`;

CREATE TABLE `comprobanteventa` (
  `idComprobanteVta` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `importeSiva` float DEFAULT NULL,
  `importeTotal` float DEFAULT NULL,
  `cuitCliente` varchar(13) DEFAULT NULL,
  `nombreCliente` varchar(256) DEFAULT NULL,
  `descripcion` varchar(256) DEFAULT NULL,
  `idTipoComprobante` int(11) DEFAULT NULL,
  `nroComprobante` varchar(12) DEFAULT NULL,
  `nroSerie` varchar(4) DEFAULT NULL,
  `fechaCreacion` datetime DEFAULT NULL,
  PRIMARY KEY (`idComprobanteVta`),
  KEY `FK_comprobanteventa` (`idTipoComprobante`),
  CONSTRAINT `FK_comprobanteventa` FOREIGN KEY (`idTipoComprobante`) REFERENCES `tipocomprobante` (`idTipoComprobante`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

/*Data for the table `comprobanteventa` */

insert  into `comprobanteventa`(`idComprobanteVta`,`fecha`,`importeSiva`,`importeTotal`,`cuitCliente`,`nombreCliente`,`descripcion`,`idTipoComprobante`,`nroComprobante`,`nroSerie`,`fechaCreacion`) values (8,'2015-01-28',45800,55418,'30','AGD','Brazo AGD',1,'0001-0000024','9127','2015-01-18 12:02:59'),(9,'2015-01-28',47210.6,2073.7,'30-51824288-8','LOSI','BRAZOS DE CARGA 2',1,'0001-0000002','9127','2015-01-20 16:53:07'),(10,'2015-01-22',40205,40205,'55000000034','EQUIP','ACOPLES',1,'0004-0000002','','2015-01-18 12:29:43'),(11,'2015-01-23',9529,9529,'30-55449764-7','DISTRIBUIDORA RIO','',1,'0005-0000002','D','2015-01-20 16:49:29'),(12,'2015-01-28',71652,71652,'30-55449764-7','DISTRIBUIDORA RIO','RIO',1,'0005-0000002','','2015-01-20 16:50:14'),(13,'2015-02-25',0,53194,'1','LOSI','',1,'0005-0000002','','2015-01-20 16:52:25');

/*Table structure for table `movimiento` */

DROP TABLE IF EXISTS `movimiento`;

CREATE TABLE `movimiento` (
  `idMovimiento` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(128) DEFAULT NULL,
  `idTipoMovimiento` int(11) NOT NULL,
  `fechaPago` date NOT NULL,
  `importeIngreso` float DEFAULT NULL,
  `importeEgreso` float DEFAULT NULL,
  `fechaCreacion` datetime NOT NULL,
  `nroOrden` int(11) DEFAULT NULL,
  `idMovimientoOrigen` int(11) DEFAULT NULL,
  `idComprobanteVta` int(11) DEFAULT NULL,
  `idComprobanteCpr` int(11) DEFAULT NULL,
  `idRepeticion` int(11) DEFAULT NULL,
  `nroRepeticion` int(11) DEFAULT NULL,
  PRIMARY KEY (`idMovimiento`),
  KEY `FK_movimiento` (`idTipoMovimiento`),
  KEY `FK_movimiento_comprovanteventa` (`idComprobanteVta`),
  KEY `FK_movimiento_comprobanteCpr` (`idComprobanteCpr`),
  CONSTRAINT `FK_movimiento` FOREIGN KEY (`idTipoMovimiento`) REFERENCES `tipomovimiento` (`idTipoMovimiento`),
  CONSTRAINT `FK_movimiento_comprobanteCpr` FOREIGN KEY (`idComprobanteCpr`) REFERENCES `comprobantecompra` (`idComprobanteCpr`),
  CONSTRAINT `FK_movimiento_comprovanteventa` FOREIGN KEY (`idComprobanteVta`) REFERENCES `comprobanteventa` (`idComprobanteVta`)
) ENGINE=InnoDB AUTO_INCREMENT=154 DEFAULT CHARSET=utf8;

/*Data for the table `movimiento` */

insert  into `movimiento`(`idMovimiento`,`descripcion`,`idTipoMovimiento`,`fechaPago`,`importeIngreso`,`importeEgreso`,`fechaCreacion`,`nroOrden`,`idMovimientoOrigen`,`idComprobanteVta`,`idComprobanteCpr`,`idRepeticion`,`nroRepeticion`) values (38,'Extraccion',2,'2015-01-02',NULL,1000,'2015-01-17 17:48:06',5910,NULL,NULL,NULL,NULL,NULL),(39,'Mapfre Argentina',2,'2015-01-02',NULL,826,'2015-01-17 17:49:32',3944,NULL,NULL,NULL,NULL,NULL),(40,'Sueldo+SAC  Marcelo',2,'2015-01-02',NULL,7892,'2015-01-17 17:52:35',226,NULL,NULL,NULL,NULL,NULL),(41,'Sueldo+SAC DDR',2,'2015-01-02',NULL,21000,'2015-01-17 17:53:31',175,NULL,NULL,NULL,NULL,NULL),(42,'Sueldo+SAC  Jose',2,'2015-01-02',NULL,12008,'2015-01-17 17:54:25',226,NULL,NULL,NULL,NULL,NULL),(43,'Sueldo+SAC GS',2,'2015-01-02',NULL,14695,'2015-01-17 17:55:14',226,NULL,NULL,NULL,NULL,NULL),(44,'Sueldo+SAC RB',2,'2015-01-02',NULL,9745,'2015-01-17 17:56:04',2147483647,NULL,NULL,NULL,NULL,NULL),(45,'Extraccion',1,'2015-01-02',278924,NULL,'2015-01-18 12:00:13',5910,NULL,NULL,NULL,NULL,NULL),(46,'Pago Cci 24hs Gravada Interbanking  - A Cbu 0170179740000030112261 ',2,'2015-01-02',NULL,342.17,'2015-01-18 10:43:58',40967,NULL,NULL,NULL,NULL,NULL),(47,'Imp Ley 25413 Deb 0,6% ',2,'2015-01-02',NULL,405.06,'2015-01-18 10:44:58',29590,NULL,NULL,NULL,NULL,NULL),(49,'Clearing Recibido 48 Hs',2,'2015-01-02',NULL,3033.99,'2015-01-18 10:46:44',78528232,NULL,NULL,NULL,NULL,NULL),(50,'Prosegur Activa 47625 -938,31',2,'2015-01-02',NULL,938.31,'2015-01-18 10:49:07',78481,NULL,NULL,NULL,NULL,NULL),(51,'Pago Electronico de Servicios Movistar 0100134754167',2,'2015-01-05',NULL,6766.46,'2015-01-18 11:24:37',425395,NULL,NULL,NULL,NULL,NULL),(52,'Caja Chica',2,'2015-01-05',NULL,4000,'2015-01-18 11:25:44',10001,NULL,NULL,NULL,NULL,NULL),(53,'Imp Ley 25413 Deb 0.6%',2,'2015-01-05',NULL,88.43,'2015-01-18 11:27:12',29598,NULL,NULL,NULL,NULL,NULL),(54,'RVG',2,'2015-01-06',NULL,23000,'2015-01-20 12:19:02',78528237,NULL,NULL,NULL,NULL,NULL),(55,'Dirección Gral D 6499407',2,'2015-01-06',NULL,594.71,'2015-01-18 11:30:13',57883,NULL,NULL,NULL,NULL,NULL),(56,'Imp Ley 25413 Deb 0.6%',2,'2015-01-06',NULL,141.57,'2015-01-18 11:31:45',29598,NULL,NULL,NULL,NULL,NULL),(57,'Amex',2,'2015-01-07',NULL,13500,'2015-01-18 11:32:33',78528240,NULL,NULL,NULL,NULL,NULL),(58,'Cablevision ',2,'2015-01-07',NULL,1494.36,'2015-01-18 11:34:48',316069,NULL,NULL,NULL,NULL,NULL),(59,'Vittal E833943',2,'2015-01-07',NULL,117.7,'2015-01-18 11:35:36',324210,NULL,NULL,NULL,NULL,NULL),(60,'Sueldo + SAC AV',2,'2015-01-07',NULL,15799.5,'2015-01-18 11:36:31',3213311,NULL,NULL,NULL,NULL,NULL),(61,'Imp Ley 25413 Deb 0.6%',2,'2015-01-07',NULL,185.48,'2015-01-18 11:37:30',29603,NULL,NULL,NULL,NULL,NULL),(62,'Cheque',2,'2015-01-08',NULL,1459.56,'2015-01-18 11:38:19',78528238,NULL,NULL,NULL,NULL,NULL),(63,'Solmec',2,'2015-01-08',NULL,1197.9,'2015-01-18 11:39:07',21419,NULL,NULL,NULL,NULL,NULL),(64,'Telefonica',2,'2015-01-08',NULL,162.2,'2015-01-18 11:39:40',23013,NULL,NULL,NULL,NULL,NULL),(65,'Telefonica',2,'2015-01-08',NULL,802.67,'2015-01-18 11:40:16',23053,NULL,NULL,NULL,NULL,NULL),(66,'Imp Ley 25413 Deb 0.6%',2,'2015-01-08',NULL,21.74,'2015-01-18 11:41:52',29608,NULL,NULL,NULL,NULL,NULL),(67,'Cheque',2,'2015-01-12',NULL,4897.06,'2015-01-18 11:42:50',78528221,NULL,NULL,NULL,NULL,NULL),(68,'Caja Chica',2,'2015-01-12',NULL,4000,'2015-01-18 11:43:37',78528244,NULL,NULL,NULL,NULL,NULL),(69,'Imp Ley 25413 Deb 0.6%',2,'2015-01-12',NULL,53.38,'2015-01-18 11:44:42',29611,NULL,NULL,NULL,NULL,NULL),(70,'Cheque Distribuidora Rio',1,'2015-01-13',6052.86,NULL,'2015-01-18 11:46:17',14000021,NULL,NULL,NULL,NULL,NULL),(71,'Comision Procesamiento Ch Dep Cfu',2,'2015-01-13',NULL,31.78,'2015-01-18 11:47:04',29613,NULL,NULL,NULL,NULL,NULL),(72,'Iva Tasa General',2,'2015-01-13',NULL,6.67,'2015-01-18 11:47:55',29614,NULL,NULL,NULL,NULL,NULL),(73,'Imp Ley 25413 Deb 0.6%',2,'2015-01-13',NULL,36.32,'2015-01-18 11:48:46',29615,NULL,NULL,NULL,NULL,NULL),(74,'Imp Ley 25413 Deb 0.6%',2,'2015-01-13',NULL,0.23,'2015-01-18 11:49:43',29616,NULL,NULL,NULL,NULL,NULL),(75,'Regimen De Recaudacion Sincreb Z ',2,'2015-01-13',NULL,302.64,'2015-01-18 11:51:21',29618,NULL,NULL,NULL,NULL,NULL),(76,'Cheque',2,'2015-01-14',NULL,725.77,'2015-01-18 11:51:56',78528224,NULL,NULL,NULL,NULL,NULL),(77,'Comision Envio inf \"c\" 4469',2,'2015-01-14',NULL,327.4,'2015-01-18 11:52:40',29619,NULL,NULL,NULL,NULL,NULL),(78,'Imp Ley 25413 Deb 0.6%',2,'2015-01-14',NULL,8.13,'2015-01-18 11:53:20',29620,NULL,NULL,NULL,NULL,NULL),(79,'Computadoras Repuestos',2,'2015-01-15',NULL,1150,'2015-01-18 11:54:02',5204,NULL,NULL,NULL,NULL,NULL),(80,'Almuerzo AOYPF',2,'2015-01-15',NULL,808.2,'2015-01-18 11:54:34',5263,NULL,NULL,NULL,NULL,NULL),(81,'Cheque',2,'2015-01-15',NULL,4174.5,'2015-01-18 11:55:15',78528247,NULL,NULL,NULL,NULL,NULL),(82,'Imp Ley 25413 Deb 0.6%',2,'2015-01-15',NULL,36.8,'2015-01-18 11:55:56',29624,NULL,NULL,NULL,NULL,NULL),(83,'AFIP ',2,'2015-01-16',NULL,4083.38,'2015-01-18 11:56:28',65521,NULL,NULL,NULL,NULL,NULL),(84,'AFIP',2,'2015-01-16',NULL,30746.3,'2015-01-18 11:56:55',65522,NULL,NULL,NULL,NULL,NULL),(85,'Imp Ley 25413 Deb 0.6%',2,'2015-01-16',NULL,208.98,'2015-01-18 11:57:41',29627,NULL,NULL,NULL,NULL,NULL),(86,'RVG',2,'2015-01-19',NULL,30000,'2015-01-18 11:58:27',78528225,NULL,NULL,NULL,NULL,NULL),(87,'Extraccion',1,'2015-01-01',1000,1000,'2015-01-18 12:01:10',5910,NULL,NULL,NULL,NULL,NULL),(88,'ZALOZE',2,'2015-02-06',NULL,1642.1,'2015-01-19 09:52:42',0,NULL,NULL,NULL,NULL,NULL),(89,'ACERO SUD',2,'2015-02-09',NULL,2841.03,'2015-01-19 09:46:05',0,NULL,NULL,NULL,NULL,NULL),(90,'BOMECA',2,'2015-02-09',NULL,11858,'2015-01-19 09:46:46',0,NULL,NULL,NULL,NULL,NULL),(91,'FAMIQ',2,'2015-02-13',NULL,2352.49,'2015-01-19 09:48:21',0,NULL,NULL,NULL,NULL,NULL),(92,'ENDURECIDO',2,'2015-01-13',NULL,726,'2015-01-19 09:49:37',0,NULL,NULL,NULL,NULL,NULL),(93,'BOLITAS',2,'2015-01-29',NULL,5644.65,'2015-01-19 09:52:08',0,NULL,NULL,NULL,NULL,NULL),(94,'LIT ALUMINIO',2,'2015-01-19',NULL,6951.92,'2015-01-20 17:11:18',78528243,NULL,NULL,NULL,NULL,NULL),(95,'ENRIQUE MOLINARI',2,'2015-02-09',NULL,2795.42,'2015-01-20 17:13:03',78528249,NULL,NULL,NULL,NULL,NULL),(96,'LAAPSA',2,'2015-02-19',NULL,1045.44,'2015-01-20 17:14:17',78528250,NULL,NULL,NULL,NULL,NULL),(97,'MATAFUEGOS',2,'2015-01-29',NULL,1701,'2015-01-20 17:15:05',78528252,NULL,NULL,NULL,NULL,NULL),(98,'Dist Rio',1,'2015-01-21',9529,NULL,'2015-01-23 17:40:01',5,NULL,11,NULL,NULL,NULL),(99,'Imp Ley 25413 Deb 0.6%',2,'2015-01-19',NULL,180,'2015-01-21 12:25:23',0,NULL,NULL,NULL,NULL,NULL),(100,'NO SE',2,'2015-01-20',NULL,2359.5,'2015-01-21 12:28:18',78528225,NULL,NULL,NULL,NULL,NULL),(101,'Prosegur',2,'2015-01-20',NULL,954,'2015-01-21 12:29:30',21981,NULL,NULL,NULL,4,30),(102,'Prosegur',2,'2015-02-20',NULL,954,'2015-01-21 12:29:30',21981,NULL,NULL,NULL,4,29),(103,'Prosegur',2,'2015-03-20',NULL,954,'2015-01-21 12:29:30',21981,NULL,NULL,NULL,4,28),(104,'Prosegur',2,'2015-04-20',NULL,954,'2015-01-21 12:29:30',21981,NULL,NULL,NULL,4,27),(105,'Prosegur',2,'2015-05-20',NULL,954,'2015-01-21 12:29:30',21981,NULL,NULL,NULL,4,26),(106,'Prosegur',2,'2015-06-20',NULL,954,'2015-01-21 12:29:30',21981,NULL,NULL,NULL,4,25),(107,'Prosegur',2,'2015-07-20',NULL,954,'2015-01-21 12:29:30',21981,NULL,NULL,NULL,4,24),(108,'Prosegur',2,'2015-08-20',NULL,954,'2015-01-21 12:29:30',21981,NULL,NULL,NULL,4,23),(109,'Prosegur',2,'2015-09-20',NULL,954,'2015-01-21 12:29:30',21981,NULL,NULL,NULL,4,22),(110,'Prosegur',2,'2015-10-20',NULL,954,'2015-01-21 12:29:30',21981,NULL,NULL,NULL,4,21),(111,'Prosegur',2,'2015-11-20',NULL,954,'2015-01-21 12:29:30',21981,NULL,NULL,NULL,4,20),(112,'Prosegur',2,'2015-12-20',NULL,954,'2015-01-21 12:29:30',21981,NULL,NULL,NULL,4,19),(113,'Prosegur',2,'2016-01-20',NULL,954,'2015-01-21 12:29:30',21981,NULL,NULL,NULL,4,18),(114,'Prosegur',2,'2016-02-20',NULL,954,'2015-01-21 12:29:30',21981,NULL,NULL,NULL,4,17),(115,'Prosegur',2,'2016-03-20',NULL,954,'2015-01-21 12:29:30',21981,NULL,NULL,NULL,4,16),(116,'Prosegur',2,'2016-04-20',NULL,954,'2015-01-21 12:29:30',21981,NULL,NULL,NULL,4,15),(117,'Prosegur',2,'2016-05-20',NULL,954,'2015-01-21 12:29:30',21981,NULL,NULL,NULL,4,14),(118,'Prosegur',2,'2016-06-20',NULL,954,'2015-01-21 12:29:30',21981,NULL,NULL,NULL,4,13),(119,'Prosegur',2,'2016-07-20',NULL,954,'2015-01-21 12:29:30',21981,NULL,NULL,NULL,4,12),(120,'Prosegur',2,'2016-08-20',NULL,954,'2015-01-21 12:29:30',21981,NULL,NULL,NULL,4,11),(121,'Prosegur',2,'2016-09-20',NULL,954,'2015-01-21 12:29:30',21981,NULL,NULL,NULL,4,10),(122,'Prosegur',2,'2016-10-20',NULL,954,'2015-01-21 12:29:30',21981,NULL,NULL,NULL,4,9),(123,'Prosegur',2,'2016-11-20',NULL,954,'2015-01-21 12:29:30',21981,NULL,NULL,NULL,4,8),(124,'Prosegur',2,'2016-12-20',NULL,954,'2015-01-21 12:29:30',21981,NULL,NULL,NULL,4,7),(125,'Prosegur',2,'2017-01-20',NULL,954,'2015-01-21 12:29:30',21981,NULL,NULL,NULL,4,6),(126,'Prosegur',2,'2017-02-20',NULL,954,'2015-01-21 12:29:30',21981,NULL,NULL,NULL,4,5),(127,'Prosegur',2,'2017-03-20',NULL,954,'2015-01-21 12:29:30',21981,NULL,NULL,NULL,4,4),(128,'Prosegur',2,'2017-04-20',NULL,954,'2015-01-21 12:29:30',21981,NULL,NULL,NULL,4,3),(129,'Prosegur',2,'2017-05-20',NULL,954,'2015-01-21 12:29:30',21981,NULL,NULL,NULL,4,2),(130,'Prosegur',2,'2017-06-20',NULL,954,'2015-01-21 12:29:30',21981,NULL,NULL,NULL,4,1),(131,'Abogada',2,'2015-01-20',NULL,2079,'2015-01-21 12:31:07',7745964,NULL,NULL,NULL,NULL,NULL),(132,'Chiazza',1,'2015-01-20',3496.9,NULL,'2015-01-21 12:32:50',999540,NULL,NULL,NULL,NULL,NULL),(133,'Imp Ley 25413 Deb 06%',2,'2015-01-20',NULL,74.07,'2015-01-21 12:34:16',4633,NULL,NULL,NULL,NULL,NULL),(134,'Imp Ley 25413 Deb 0.6%',2,'2015-01-20',NULL,20.98,'2015-01-21 12:35:29',29636,NULL,NULL,NULL,NULL,NULL),(135,'Garcia',2,'2015-02-20',NULL,5000,'2015-01-21 12:41:14',78528253,NULL,NULL,NULL,NULL,NULL),(136,'Garcia',2,'2015-02-20',NULL,5000,'2015-01-21 12:41:43',78528254,NULL,NULL,NULL,NULL,NULL),(137,'Garcia',2,'2015-02-20',NULL,5000,'2015-01-21 12:42:10',78528255,NULL,NULL,NULL,NULL,NULL),(138,'cheque',2,'2015-01-21',NULL,2000,'2015-01-21 15:17:08',78528229,NULL,NULL,NULL,NULL,NULL),(139,'Sircreb',2,'2015-01-20',NULL,174.85,'2015-01-22 10:48:59',29639,NULL,NULL,NULL,NULL,NULL),(140,'AOM  Bunge',2,'2015-01-22',NULL,3000,'2015-01-22 10:47:32',0,NULL,NULL,NULL,NULL,NULL),(141,'ARGENTINA CARGO',2,'1915-02-21',NULL,10000,'2015-01-22 12:12:25',3912691,NULL,NULL,NULL,NULL,NULL),(142,'Argentina cargo',2,'2015-01-22',NULL,10000,'2015-01-23 09:36:44',0,NULL,NULL,NULL,NULL,NULL),(143,'Imp Ley 25413 Cred 0.6%',2,'2015-01-21',NULL,57.17,'2015-01-23 17:41:47',0,NULL,NULL,NULL,NULL,NULL),(144,'Imp Ley 25413 Cred 0.6%',2,'2015-01-22',NULL,41.36,'2015-01-23 17:42:28',0,NULL,NULL,NULL,NULL,NULL),(145,'Regimen De Recaudacion Sicreb Z ',2,'2015-01-21',NULL,476.45,'2015-01-23 17:43:32',0,NULL,NULL,NULL,NULL,NULL),(146,'Imp Ley 25413 Deb 0.6%',2,'2015-01-22',NULL,80.86,'2015-01-23 17:44:15',0,NULL,NULL,NULL,NULL,NULL),(147,'Caja Chica',2,'2015-01-23',NULL,3000,'2015-01-23 17:45:08',0,NULL,NULL,NULL,NULL,NULL),(148,'Telmex',2,'2015-01-23',NULL,24.68,'2015-01-23 17:45:49',0,NULL,NULL,NULL,NULL,NULL),(149,'Losi',1,'2015-01-23',1153.04,NULL,'2015-01-23 17:46:38',0,NULL,NULL,NULL,NULL,NULL),(150,'mariela',2,'2015-01-21',NULL,4719,'2015-01-23 18:00:39',0,NULL,NULL,NULL,NULL,NULL),(151,'CAÑO',2,'2015-01-08',NULL,6951.92,'2015-01-27 08:47:12',1,NULL,NULL,18,NULL,NULL),(152,'Caja Chica',2,'2015-01-26',NULL,4000,'2015-01-27 08:48:33',0,NULL,NULL,NULL,NULL,NULL),(153,'Caja Chica',2,'2015-01-26',NULL,4000,'2015-01-27 08:49:41',0,NULL,NULL,NULL,NULL,NULL);

/*Table structure for table `movimientosaldomes` */

DROP TABLE IF EXISTS `movimientosaldomes`;

CREATE TABLE `movimientosaldomes` (
  `mes` int(11) NOT NULL,
  `anio` int(11) NOT NULL,
  `saldo` decimal(10,2) DEFAULT NULL,
  `fechaCarga` datetime DEFAULT NULL,
  PRIMARY KEY (`mes`,`anio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `movimientosaldomes` */

insert  into `movimientosaldomes`(`mes`,`anio`,`saldo`,`fechaCarga`) values (1,2015,'17123.12','0000-00-00 00:00:00'),(1,2016,'-954.00','0000-00-00 00:00:00'),(1,2017,'-954.00','0000-00-00 00:00:00'),(2,2015,'-38488.48','0000-00-00 00:00:00'),(2,2016,'-954.00','0000-00-00 00:00:00'),(2,2017,'-954.00','0000-00-00 00:00:00'),(3,2015,'-954.00','0000-00-00 00:00:00'),(3,2016,'-954.00','0000-00-00 00:00:00'),(3,2017,'-954.00','0000-00-00 00:00:00'),(4,2015,'-954.00','0000-00-00 00:00:00'),(4,2016,'-954.00','0000-00-00 00:00:00'),(4,2017,'-954.00','0000-00-00 00:00:00'),(5,2015,'-954.00','0000-00-00 00:00:00'),(5,2016,'-954.00','0000-00-00 00:00:00'),(5,2017,'-954.00','0000-00-00 00:00:00'),(6,2015,'-954.00','0000-00-00 00:00:00'),(6,2016,'-954.00','0000-00-00 00:00:00'),(6,2017,'-954.00','0000-00-00 00:00:00'),(7,2015,'-954.00','0000-00-00 00:00:00'),(7,2016,'-954.00','0000-00-00 00:00:00'),(8,2015,'-954.00','0000-00-00 00:00:00'),(8,2016,'-954.00','0000-00-00 00:00:00'),(9,2015,'-954.00','0000-00-00 00:00:00'),(9,2016,'-954.00','0000-00-00 00:00:00'),(10,2015,'-954.00','0000-00-00 00:00:00'),(10,2016,'-954.00','0000-00-00 00:00:00'),(11,2015,'-954.00','0000-00-00 00:00:00'),(11,2016,'-954.00','0000-00-00 00:00:00'),(12,2015,'-954.00','0000-00-00 00:00:00'),(12,2016,'-954.00','0000-00-00 00:00:00');

/*Table structure for table `repeticion` */

DROP TABLE IF EXISTS `repeticion`;

CREATE TABLE `repeticion` (
  `idRepeticion` int(11) NOT NULL AUTO_INCREMENT,
  `cantRepeticion` int(11) DEFAULT NULL,
  PRIMARY KEY (`idRepeticion`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `repeticion` */

insert  into `repeticion`(`idRepeticion`,`cantRepeticion`) values (4,30);

/*Table structure for table `tipocomprobante` */

DROP TABLE IF EXISTS `tipocomprobante`;

CREATE TABLE `tipocomprobante` (
  `idTipoComprobante` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`idTipoComprobante`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `tipocomprobante` */

insert  into `tipocomprobante`(`idTipoComprobante`,`descripcion`) values (1,'Factura'),(2,'Nota de Credito'),(3,'Nota de Debito');

/*Table structure for table `tipomovimiento` */

DROP TABLE IF EXISTS `tipomovimiento`;

CREATE TABLE `tipomovimiento` (
  `idTipoMovimiento` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`idTipoMovimiento`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `tipomovimiento` */

insert  into `tipomovimiento`(`idTipoMovimiento`,`descripcion`) values (1,'Ingreso'),(2,'Egreso');

/*Table structure for table `usuario` */

DROP TABLE IF EXISTS `usuario`;

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) DEFAULT NULL,
  `pass` varchar(16) DEFAULT NULL,
  `nombre` varchar(64) DEFAULT NULL,
  `apellido` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`idUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `usuario` */

insert  into `usuario`(`idUsuario`,`username`,`pass`,`nombre`,`apellido`) values (1,'arothar','orionale','Alejandro','Rothar'),(3,'admin','Aexo12100','Administrador','Aexo');

/* Procedure structure for procedure `sp_flujoCaja` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_flujoCaja` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`aexo`@`%` PROCEDURE `sp_flujoCaja`(p_mes  int, p_anio int)
BEGIN
	SET @acumulador = 0;
	set @fechaMesActual = 0;
	select DATE_ADD(MAKEDATE(p_anio, 1), INTERVAL (p_mes)-1 MONTH) into @fechaMesActual;
	SELECT ifnull(sum(coalesce(saldo,0)),0) as saldo INTO @acumulador 
	from movimientosaldomes 
	where @fechaMesActual > DATE_ADD(MAKEDATE(anio, 1), INTERVAL (mes)-1 MONTH); 
	select fechaPago, 
		@acumulador := suma+ @acumulador as acumulado from (
							select fechaPago, 
								sum(importe) as suma
								 from (
									select idMovimiento, 
										descripcion,
										idTipoMovimiento,
										fechaPago,
										CASE 
										    WHEN idTipoMovimiento = 1 THEN importeIngreso
										    WHEN idTipoMovimiento = 2 THEN importeEgreso * -1
										END as importe
									from movimiento
									where MONTH(fechaPago) = p_mes and year(fechaPago) = p_anio
									order by fechaPago) as calculado
							group by fechaPago) as sumarizado;
    END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
