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

/*Table structure for table `movimiento` */

DROP TABLE IF EXISTS `movimiento`;

CREATE TABLE `movimiento` (
  `idMovimiento` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(128) DEFAULT NULL,
  `idTipoMovimiento` int(11) NOT NULL,
  `fechaPago` datetime NOT NULL,
  `importeIngreso` float DEFAULT NULL,
  `importeEgreso` float DEFAULT NULL,
  `fechaCreacion` datetime NOT NULL,
  `nroOrden` int(11) DEFAULT NULL,
  `idMovimientoOrigen` int(11) DEFAULT NULL,
  PRIMARY KEY (`idMovimiento`),
  KEY `FK_movimiento` (`idTipoMovimiento`),
  CONSTRAINT `FK_movimiento` FOREIGN KEY (`idTipoMovimiento`) REFERENCES `tipomovimiento` (`idTipoMovimiento`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

/*Data for the table `movimiento` */

insert  into `movimiento`(`idMovimiento`,`descripcion`,`idTipoMovimiento`,`fechaPago`,`importeIngreso`,`importeEgreso`,`fechaCreacion`,`nroOrden`,`idMovimientoOrigen`) values (21,'Segundo ingreso',1,'2015-01-07 00:00:00',300000,NULL,'2015-01-07 02:57:21',45,NULL),(22,'Primer ingreso',1,'2015-01-05 00:00:00',50000,NULL,'2015-01-07 04:15:24',0,NULL),(23,'Pago de sueldos',2,'2015-01-10 00:00:00',NULL,40000,'2015-01-07 04:21:56',0,NULL),(24,'Gastos varios',2,'2015-01-10 00:00:00',NULL,60000,'2015-01-07 04:21:56',NULL,NULL),(25,'Mas Gastos grandes',2,'2015-01-17 00:00:00',NULL,343000,'2015-01-10 00:00:00',NULL,NULL),(26,'Una compra. ',1,'2015-01-29 00:00:00',48000,NULL,'2015-01-08 16:13:18',0,NULL),(28,'dfasdf',1,'2015-01-21 00:00:00',25000,NULL,'2015-01-08 16:18:42',0,NULL),(29,'erdsfs',2,'2015-01-15 00:00:00',NULL,230000,'2015-01-08 20:06:19',2,NULL),(30,'Desde la tablet',1,'2015-01-14 00:00:00',45000,NULL,'2015-01-08 22:50:21',0,NULL),(31,'Desde la tableta',1,'2015-01-14 00:00:00',45000,NULL,'2015-01-08 22:51:02',0,NULL);

/*Table structure for table `tipomovimiento` */

DROP TABLE IF EXISTS `tipomovimiento`;

CREATE TABLE `tipomovimiento` (
  `idTipoMovimiento` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`idTipoMovimiento`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `tipomovimiento` */

insert  into `tipomovimiento`(`idTipoMovimiento`,`descripcion`) values (1,'Ingreso'),(2,'Egreso');

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
