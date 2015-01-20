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

insert  into `comprobantecompra`(`idComprobanteCpr`,`fecha`,`importeSiva`,`importeTotal`,`cuitProveedor`,`nombreProveedor`,`descripcion`,`idTipoComprobante`,`nroComprobante`,`nroSerie`,`fechaCreacion`) values (2,'2015-01-08',0,20711.5,'345','ARGENTINA CARGO','',1,'55','534','2015-01-18 12:45:30'),(3,'2015-01-07',1795.72,1795.72,'1','SEC','SEC',1,'1','','2015-01-18 12:53:16'),(4,'2015-01-07',214.88,214.88,'1','INACAP','INACAP',1,'1','1','2015-01-18 12:54:14'),(5,'2015-01-07',448.93,448.93,'2','FAECYS','FAECYS',1,'2','1','2015-01-18 12:56:11'),(6,'2015-01-14',43298,43298,'2','SUSS','SUSS',1,'2','1','2015-01-18 13:01:35'),(7,'2014-12-18',6080,7356.8,'33-71130548-9','IDEA FABRIL SA','20 UNIDADES TAPAS PLASTICAS',1,'0001-0000054','','2015-01-19 08:29:12'),(8,'2014-12-23',13.76,17.48,'33-69509841-9','TELMEX ARGENTINA SA','TELEFONIA',1,'0016-0243082','','2015-01-19 08:31:03'),(9,'2015-01-02',524.57,524.57,'30-55449764-7','CITY MEDICAL SERVICE SA','SERVICIOS MEDICOS',1,'0003-0000115','','2015-01-19 08:33:54'),(10,'2015-01-19',563.64,848.18,'1','TELEFONICA','TELEFONICA',1,'1','','2015-01-19 08:34:58'),(11,'2015-01-13',1356.2,1701,'1','ELTA','MATAFUEGOS',1,'0001-0000984','','2015-01-19 08:46:25'),(12,'2014-12-31',287.6,348,'1','FISCHETTI','SODA',1,'0001-0017014','','2015-01-19 08:47:40'),(13,'2015-01-08',2130,2577.3,'º','SOLMEC','SOLDADOR',1,'0001-0000240','','2015-01-19 08:48:27'),(14,'2014-12-15',864,1045.44,'1','LAAPSA','KLANSEN 227',1,'0006-0001009','','2015-01-19 08:50:22'),(15,'2014-12-31',9814.2,11875.2,'27-23853065-8','GARCIA','FUNDICION',1,'0001-0000097','','2015-01-19 08:51:15'),(16,'2015-01-13',3150,3811.5,'1','GARCIA','FUNDICION',1,'0001-0000097','','2015-01-19 08:51:46'),(17,'2015-01-12',600,726,'1','THERMAL','CALENTITO',1,'0001-0004837','','2015-01-19 08:53:58'),(18,'2015-01-08',5745.39,6951.92,'1','LIT ALUMINIO','CAÑO',1,'0001-0007273','','2015-01-19 09:12:37'),(19,'2015-01-12',78438,78438,'1','GALENO','',1,'0001-000001','','2015-01-19 09:20:19');

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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

/*Data for the table `comprobanteventa` */

insert  into `comprobanteventa`(`idComprobanteVta`,`fecha`,`importeSiva`,`importeTotal`,`cuitCliente`,`nombreCliente`,`descripcion`,`idTipoComprobante`,`nroComprobante`,`nroSerie`,`fechaCreacion`) values (8,'2015-01-28',45800,55418,'30','AGD','Brazo AGD',1,'0001-0000024','9127','2015-01-18 12:02:59'),(9,'2015-01-21',47210.6,57124.9,'30-51824288-8','LOSI','BRAZOS DE CARGA 2\"',1,'0001-0000002','9127','2015-01-18 12:25:35'),(10,'2015-01-22',40205,40205,'55000000034','EQUIP','ACOPLES',1,'0004-0000002','','2015-01-18 12:29:43'),(11,'2015-01-26',9000,9000,'30-55449764-7','DISTRIBUIDORA RIO','',1,'0005-0000002','D','2015-01-18 12:31:42'),(12,'2015-01-26',71000,71000,'30-55449764-7','DISTRIBUIDORA RIO','RIO',1,'0005-0000002','','2015-01-18 12:32:49');

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
  PRIMARY KEY (`idMovimiento`),
  KEY `FK_movimiento` (`idTipoMovimiento`),
  KEY `FK_movimiento_comprovanteventa` (`idComprobanteVta`),
  KEY `FK_movimiento_comprobanteCpr` (`idComprobanteCpr`),
  CONSTRAINT `FK_movimiento` FOREIGN KEY (`idTipoMovimiento`) REFERENCES `tipomovimiento` (`idTipoMovimiento`),
  CONSTRAINT `FK_movimiento_comprobanteCpr` FOREIGN KEY (`idComprobanteCpr`) REFERENCES `comprobantecompra` (`idComprobanteCpr`),
  CONSTRAINT `FK_movimiento_comprovanteventa` FOREIGN KEY (`idComprobanteVta`) REFERENCES `comprobanteventa` (`idComprobanteVta`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8;

/*Data for the table `movimiento` */

insert  into `movimiento`(`idMovimiento`,`descripcion`,`idTipoMovimiento`,`fechaPago`,`importeIngreso`,`importeEgreso`,`fechaCreacion`,`nroOrden`,`idMovimientoOrigen`,`idComprobanteVta`,`idComprobanteCpr`) values (38,'Extraccion',2,'2015-01-02',NULL,1000,'2015-01-17 17:48:06',5910,NULL,NULL,NULL),(39,'Mapfre Argentina',2,'2015-01-02',NULL,826,'2015-01-17 17:49:32',3944,NULL,NULL,NULL),(40,'Sueldo+SAC  Marcelo',2,'2015-01-02',NULL,7892,'2015-01-17 17:52:35',226,NULL,NULL,NULL),(41,'Sueldo+SAC DDR',2,'2015-01-02',NULL,21000,'2015-01-17 17:53:31',175,NULL,NULL,NULL),(42,'Sueldo+SAC  Jose',2,'2015-01-02',NULL,12008,'2015-01-17 17:54:25',226,NULL,NULL,NULL),(43,'Sueldo+SAC GS',2,'2015-01-02',NULL,14695,'2015-01-17 17:55:14',226,NULL,NULL,NULL),(44,'Sueldo+SAC RB',2,'2015-01-02',NULL,9745,'2015-01-17 17:56:04',2147483647,NULL,NULL,NULL),(45,'Extraccion',1,'2015-01-02',278924,NULL,'2015-01-18 12:00:13',5910,NULL,NULL,NULL),(46,'Pago Cci 24hs Gravada Interbanking  - A Cbu 0170179740000030112261 ',2,'2015-01-02',NULL,342.17,'2015-01-18 10:43:58',40967,NULL,NULL,NULL),(47,'Imp Ley 25413 Deb 0,6% ',2,'2015-01-02',NULL,405.06,'2015-01-18 10:44:58',29590,NULL,NULL,NULL),(49,'Clearing Recibido 48 Hs',2,'2015-01-02',NULL,3033.99,'2015-01-18 10:46:44',78528232,NULL,NULL,NULL),(50,'Prosegur Activa 47625 -938,31',2,'2015-01-02',NULL,938.31,'2015-01-18 10:49:07',78481,NULL,NULL,NULL),(51,'Pago Electronico de Servicios Movistar 0100134754167',2,'2015-01-05',NULL,6766.46,'2015-01-18 11:24:37',425395,NULL,NULL,NULL),(52,'Caja Chica',2,'2015-01-05',NULL,4000,'2015-01-18 11:25:44',10001,NULL,NULL,NULL),(53,'Imp Ley 25413 Deb 0.6%',2,'2015-01-05',NULL,88.43,'2015-01-18 11:27:12',29598,NULL,NULL,NULL),(54,'RVG',2,'2015-01-06',NULL,23000,'2015-01-18 11:28:58',78528237,NULL,NULL,NULL),(55,'Dirección Gral D 6499407',2,'2015-01-06',NULL,594.71,'2015-01-18 11:30:13',57883,NULL,NULL,NULL),(56,'Imp Ley 25413 Deb 0.6%',2,'2015-01-06',NULL,141.57,'2015-01-18 11:31:45',29598,NULL,NULL,NULL),(57,'Amex',2,'2015-01-07',NULL,13500,'2015-01-18 11:32:33',78528240,NULL,NULL,NULL),(58,'Cablevision ',2,'2015-01-07',NULL,1494.36,'2015-01-18 11:34:48',316069,NULL,NULL,NULL),(59,'Vittal E833943',2,'2015-01-07',NULL,117.7,'2015-01-18 11:35:36',324210,NULL,NULL,NULL),(60,'Sueldo + SAC AV',2,'2015-01-07',NULL,15799.5,'2015-01-18 11:36:31',3213311,NULL,NULL,NULL),(61,'Imp Ley 25413 Deb 0.6%',2,'2015-01-07',NULL,185.48,'2015-01-18 11:37:30',29603,NULL,NULL,NULL),(62,'Cheque',2,'2015-01-08',NULL,1459.56,'2015-01-18 11:38:19',78528238,NULL,NULL,NULL),(63,'Solmec',2,'2015-01-08',NULL,1197.9,'2015-01-18 11:39:07',21419,NULL,NULL,NULL),(64,'Telefonica',2,'2015-01-08',NULL,162.2,'2015-01-18 11:39:40',23013,NULL,NULL,NULL),(65,'Telefonica',2,'2015-01-08',NULL,802.67,'2015-01-18 11:40:16',23053,NULL,NULL,NULL),(66,'Imp Ley 25413 Deb 0.6%',2,'2015-01-08',NULL,21.74,'2015-01-18 11:41:52',29608,NULL,NULL,NULL),(67,'Cheque',2,'2015-01-12',NULL,4897.06,'2015-01-18 11:42:50',78528221,NULL,NULL,NULL),(68,'Caja Chica',2,'2015-01-12',NULL,4000,'2015-01-18 11:43:37',78528244,NULL,NULL,NULL),(69,'Imp Ley 25413 Deb 0.6%',2,'2015-01-12',NULL,53.38,'2015-01-18 11:44:42',29611,NULL,NULL,NULL),(70,'Cheque Distribuidora Rio',1,'2015-01-13',6052.86,NULL,'2015-01-18 11:46:17',14000021,NULL,NULL,NULL),(71,'Comision Procesamiento Ch Dep Cfu',2,'2015-01-13',NULL,31.78,'2015-01-18 11:47:04',29613,NULL,NULL,NULL),(72,'Iva Tasa General',2,'2015-01-13',NULL,6.67,'2015-01-18 11:47:55',29614,NULL,NULL,NULL),(73,'Imp Ley 25413 Deb 0.6%',2,'2015-01-13',NULL,36.32,'2015-01-18 11:48:46',29615,NULL,NULL,NULL),(74,'Imp Ley 25413 Deb 0.6%',2,'2015-01-13',NULL,0.23,'2015-01-18 11:49:43',29616,NULL,NULL,NULL),(75,'Regimen De Recaudacion Sincreb Z ',2,'2015-01-13',NULL,302.64,'2015-01-18 11:51:21',29618,NULL,NULL,NULL),(76,'Cheque',2,'2015-01-14',NULL,725.77,'2015-01-18 11:51:56',78528224,NULL,NULL,NULL),(77,'Comision Envio inf \"c\" 4469',2,'2015-01-14',NULL,327.4,'2015-01-18 11:52:40',29619,NULL,NULL,NULL),(78,'Imp Ley 25413 Deb 0.6%',2,'2015-01-14',NULL,8.13,'2015-01-18 11:53:20',29620,NULL,NULL,NULL),(79,'Computadoras Repuestos',2,'2015-01-15',NULL,1150,'2015-01-18 11:54:02',5204,NULL,NULL,NULL),(80,'Almuerzo AOYPF',2,'2015-01-15',NULL,808.2,'2015-01-18 11:54:34',5263,NULL,NULL,NULL),(81,'Cheque',2,'2015-01-15',NULL,4174.5,'2015-01-18 11:55:15',78528247,NULL,NULL,NULL),(82,'Imp Ley 25413 Deb 0.6%',2,'2015-01-15',NULL,36.8,'2015-01-18 11:55:56',29624,NULL,NULL,NULL),(83,'AFIP ',2,'2015-01-16',NULL,4083.38,'2015-01-18 11:56:28',65521,NULL,NULL,NULL),(84,'AFIP',2,'2015-01-16',NULL,30746.3,'2015-01-18 11:56:55',65522,NULL,NULL,NULL),(85,'Imp Ley 25413 Deb 0.6%',2,'2015-01-16',NULL,208.98,'2015-01-18 11:57:41',29627,NULL,NULL,NULL),(86,'RVG',2,'2015-01-19',NULL,30000,'2015-01-18 11:58:27',78528225,NULL,NULL,NULL),(87,'Extraccion',1,'2015-01-01',1000,1000,'2015-01-18 12:01:10',5910,NULL,NULL,NULL),(88,'ZALOZE',2,'2015-02-06',NULL,1642.1,'2015-01-19 09:52:42',0,NULL,NULL,NULL),(89,'ACERO SUD',2,'2015-02-09',NULL,2841.03,'2015-01-19 09:46:05',0,NULL,NULL,NULL),(90,'BOMECA',2,'2015-02-09',NULL,11858,'2015-01-19 09:46:46',0,NULL,NULL,NULL),(91,'FAMIQ',2,'2015-02-13',NULL,2352.49,'2015-01-19 09:48:21',0,NULL,NULL,NULL),(92,'ENDURECIDO',2,'2015-01-13',NULL,726,'2015-01-19 09:49:37',0,NULL,NULL,NULL),(93,'BOLITAS',2,'2015-01-29',NULL,5644.65,'2015-01-19 09:52:08',0,NULL,NULL,NULL);

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

insert  into `usuario`(`idUsuario`,`username`,`pass`,`nombre`,`apellido`) values (1,'arothar','orionale','Alejandro','Rothar'),(2,'gmori','maga0727','Gonzalo','Mori'),(3,'admin','aexoadmin2015','Administrador','Aexo');

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
