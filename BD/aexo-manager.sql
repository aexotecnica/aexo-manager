/*
SQLyog Enterprise - MySQL GUI v7.15 
MySQL - 5.6.21 : Database - aexo-manager
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`aexo-manager` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `aexo-manager`;

/*Table structure for table `comprobantecompra` */

DROP TABLE IF EXISTS `comprobantecompra`;

CREATE TABLE `comprobantecompra` (
  `idComprobanteCpr` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `importeSiva` decimal(10,2) DEFAULT NULL,
  `importeTotal` decimal(10,2) DEFAULT NULL,
  `cuitProveedor` varchar(13) DEFAULT NULL,
  `nombreProveedor` varchar(256) DEFAULT NULL,
  `descripcion` varchar(256) DEFAULT NULL,
  `idTipoComprobante` int(11) DEFAULT NULL,
  `nroComprobante` varchar(12) DEFAULT NULL,
  `nroSerie` varchar(4) DEFAULT NULL,
  `fechaCreacion` datetime DEFAULT NULL,
  PRIMARY KEY (`idComprobanteCpr`),
  KEY `FK_comprobanteventa` (`idTipoComprobante`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `comprobantecompra` */

insert  into `comprobantecompra`(`idComprobanteCpr`,`fecha`,`importeSiva`,`importeTotal`,`cuitProveedor`,`nombreProveedor`,`descripcion`,`idTipoComprobante`,`nroComprobante`,`nroSerie`,`fechaCreacion`) values (4,'2015-01-14','24569.98','33000.55','12123131','Cualquiera','dfasda',1,'21231','','2015-01-17 20:27:45');

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `comprobanteventa` */

insert  into `comprobanteventa`(`idComprobanteVta`,`fecha`,`importeSiva`,`importeTotal`,`cuitCliente`,`nombreCliente`,`descripcion`,`idTipoComprobante`,`nroComprobante`,`nroSerie`,`fechaCreacion`) values (1,'2015-01-10',23000,27000,NULL,'Cliente 1','Factura por consumos varios',1,'2323283','0001',NULL),(3,'1970-01-01',23234,342352,'3044563345','YPF','por la compra de algunas cosas',1,'3242342','','2015-01-12 06:00:08'),(4,'2015-01-30',29991,455566,'302222221','Cliente Nuevo','Vendi un par de brazos',1,'11111','0002','2015-01-17 17:21:43'),(6,'2015-01-29',0,232445,'2342342','','',1,'243242','','2015-01-17 17:15:24');

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
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;

/*Data for the table `movimiento` */

insert  into `movimiento`(`idMovimiento`,`descripcion`,`idTipoMovimiento`,`fechaPago`,`importeIngreso`,`importeEgreso`,`fechaCreacion`,`nroOrden`,`idMovimientoOrigen`,`idComprobanteVta`,`idComprobanteCpr`,`idRepeticion`,`nroRepeticion`) values (22,'Primer ingreso dfd',1,'2015-01-06',50000,NULL,'2015-01-17 16:06:11',3234,NULL,NULL,NULL,NULL,NULL),(23,'Pago de sueldos',2,'2015-01-10',NULL,40000,'2015-01-07 04:21:56',0,NULL,NULL,NULL,NULL,NULL),(24,'Gastos varios',2,'2015-01-10',NULL,60000,'2015-01-07 04:21:56',NULL,NULL,NULL,NULL,NULL,NULL),(25,'Mas Gastos grandes',2,'2015-01-17',NULL,343000,'2015-01-10 00:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(26,'Una compra. ',1,'2015-01-29',48000,NULL,'2015-01-08 16:13:18',0,NULL,NULL,NULL,NULL,NULL),(31,'Desde la tableta',1,'2015-01-14',45000,NULL,'2015-01-08 22:51:02',0,NULL,NULL,NULL,NULL,NULL),(35,'Un egreso de prueba',2,'2015-01-02',NULL,3000,'2015-01-17 16:07:46',0,NULL,NULL,NULL,NULL,NULL),(39,'Vendi un par de brazos',1,'2015-01-30',455566,NULL,'2015-01-18 16:38:36',11111,NULL,4,NULL,NULL,NULL),(44,'Prueba de 3 repeticiones3',1,'2015-01-18',50000.5,NULL,'2015-01-18 16:52:45',0,NULL,NULL,NULL,3,3),(45,'Prueba de 3 repeticiones',1,'2015-02-18',50000.5,NULL,'2015-01-18 15:52:55',0,NULL,NULL,NULL,3,2),(46,'Prueba de 3 repeticiones',1,'2015-03-18',50000.5,NULL,'2015-01-18 15:52:55',0,NULL,NULL,NULL,3,1),(47,'',1,'2015-01-29',232445,NULL,'2015-01-18 16:37:44',243242,NULL,6,NULL,NULL,NULL);

/*Table structure for table `repeticion` */

DROP TABLE IF EXISTS `repeticion`;

CREATE TABLE `repeticion` (
  `idRepeticion` int(11) NOT NULL AUTO_INCREMENT,
  `cantRepeticion` int(11) DEFAULT NULL,
  PRIMARY KEY (`idRepeticion`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `repeticion` */

insert  into `repeticion`(`idRepeticion`,`cantRepeticion`) values (3,3);

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `usuario` */

insert  into `usuario`(`idUsuario`,`username`,`pass`,`nombre`,`apellido`) values (1,'arothar','orionale','Alejandro','Rothar'),(2,'gmori','maga0727','Gonzalo','Mori');

/* Procedure structure for procedure `sp_flujoCaja` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_flujoCaja` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_flujoCaja`(p_mes  int, p_ano int)
BEGIN
	SET @algo = 0;
	select fechaPago, 
		@algo := suma+ @algo as acumulado from (
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
									where MONTH(fechaPago) = p_mes and year(fechaPago) = p_ano
									order by fechaPago) as calculado
							group by fechaPago) as sumarizado;
    END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
