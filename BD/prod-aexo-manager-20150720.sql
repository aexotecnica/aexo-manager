/*
SQLyog Ultimate v11.5 (64 bit)
MySQL - 5.1.73-1 : Database - aexomanager
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `accion` */

DROP TABLE IF EXISTS `accion`;

CREATE TABLE `accion` (
  `idAccion` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(128) DEFAULT NULL,
  `label` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`idAccion`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Table structure for table `almacen` */

DROP TABLE IF EXISTS `almacen`;

CREATE TABLE `almacen` (
  `idAlmacen` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(32) DEFAULT NULL,
  `domicilio` varchar(128) DEFAULT NULL,
  `latitud` float DEFAULT NULL,
  `longitud` float DEFAULT NULL,
  PRIMARY KEY (`idAlmacen`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `cliente` */

DROP TABLE IF EXISTS `cliente`;

CREATE TABLE `cliente` (
  `idCliente` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(128) DEFAULT NULL,
  `idTipoCliente` int(11) DEFAULT NULL,
  `calle` varchar(64) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `idProvincia` int(10) unsigned DEFAULT NULL,
  `localidad` varchar(128) DEFAULT NULL,
  `partido` varchar(128) DEFAULT NULL,
  `codigoPostal` int(11) DEFAULT NULL,
  `responsable` varchar(128) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `paginaWeb` varchar(128) DEFAULT NULL,
  `volumenFact` float(10,6) DEFAULT NULL,
  `telefono_1` varchar(64) DEFAULT NULL,
  `telefono_2` varchar(64) DEFAULT NULL,
  `dias_horarios` varchar(128) DEFAULT NULL,
  `latitud` float(10,6) DEFAULT NULL,
  `longitud` float(10,6) DEFAULT NULL,
  `cuit` varchar(13) DEFAULT NULL,
  `idCategoriaIVA` int(11) DEFAULT NULL,
  `descripcionFormaDePago` text,
  `domicilio` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`idCliente`),
  KEY `FK_web_rutas_cliente_provincia` (`idProvincia`),
  KEY `FK_web_rutas_cliente_tipoCliente` (`idTipoCliente`),
  CONSTRAINT `FK_cliente_provincia` FOREIGN KEY (`idProvincia`) REFERENCES `provincia` (`idProvincia`),
  CONSTRAINT `FK_cliente_tipoCliente` FOREIGN KEY (`idTipoCliente`) REFERENCES `cliente_tipocliente` (`idTipoCliente`)
) ENGINE=InnoDB AUTO_INCREMENT=181 DEFAULT CHARSET=latin1;

/*Table structure for table `cliente_categoriaiva` */

DROP TABLE IF EXISTS `cliente_categoriaiva`;

CREATE TABLE `cliente_categoriaiva` (
  `idCategoriaIVA` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(32) DEFAULT NULL,
  `codigo` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`idCategoriaIVA`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `cliente_tipocliente` */

DROP TABLE IF EXISTS `cliente_tipocliente`;

CREATE TABLE `cliente_tipocliente` (
  `idTipoCliente` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`idTipoCliente`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

/*Table structure for table `despiece` */

DROP TABLE IF EXISTS `despiece`;

CREATE TABLE `despiece` (
  `idProducto` int(10) unsigned DEFAULT NULL,
  `idParte` int(10) unsigned DEFAULT NULL,
  `idParent` int(10) unsigned DEFAULT NULL,
  `jerarquia` varchar(64) DEFAULT NULL,
  `nivel` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `idDespiece` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`idDespiece`),
  KEY `FK_despiece.despiece_parte` (`idParte`),
  KEY `FK_despiece.despiece_producto` (`idProducto`),
  CONSTRAINT `FK_despiece.despiece_parte` FOREIGN KEY (`idParte`) REFERENCES `parte` (`idParte`),
  CONSTRAINT `FK_despiece.despiece_producto` FOREIGN KEY (`idProducto`) REFERENCES `producto` (`idProducto`)
) ENGINE=InnoDB AUTO_INCREMENT=371 DEFAULT CHARSET=latin1;

/*Table structure for table `estadopago` */

DROP TABLE IF EXISTS `estadopago`;

CREATE TABLE `estadopago` (
  `idEstadoPago` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`idEstadoPago`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Table structure for table `insumo` */

DROP TABLE IF EXISTS `insumo`;

CREATE TABLE `insumo` (
  `idParte` int(10) unsigned NOT NULL,
  `jerarquia` varchar(64) DEFAULT NULL,
  `nivel` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `idInsumo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idInsumoParent` int(11) DEFAULT NULL,
  PRIMARY KEY (`idParte`,`idInsumo`),
  UNIQUE KEY `idInsumo` (`idInsumo`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

/*Table structure for table `mediocobro` */

DROP TABLE IF EXISTS `mediocobro`;

CREATE TABLE `mediocobro` (
  `idMedioCobro` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `importeSiva` float DEFAULT NULL,
  `importeTotal` float DEFAULT NULL,
  `cuitCliente` varchar(13) DEFAULT NULL,
  `nombreCliente` varchar(256) DEFAULT NULL,
  `descripcion` varchar(256) DEFAULT NULL,
  `idTipoMedio` int(11) DEFAULT NULL,
  `nroComprobante` varchar(12) DEFAULT NULL,
  `nroSerie` varchar(4) DEFAULT NULL,
  `fechaCreacion` datetime DEFAULT NULL,
  PRIMARY KEY (`idMedioCobro`),
  KEY `FK_comprobanteventa` (`idTipoMedio`),
  CONSTRAINT `FK_mediocobro_tipomedio` FOREIGN KEY (`idTipoMedio`) REFERENCES `tipomedio` (`idTipoMedio`)
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=utf8;

/*Table structure for table `mediopago` */

DROP TABLE IF EXISTS `mediopago`;

CREATE TABLE `mediopago` (
  `idMedioPago` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `importeSiva` float DEFAULT NULL,
  `importeTotal` float DEFAULT NULL,
  `cuitProveedor` varchar(13) DEFAULT NULL,
  `nombreProveedor` varchar(256) DEFAULT NULL,
  `descripcion` varchar(256) DEFAULT NULL,
  `idTipoMedio` int(11) DEFAULT NULL,
  `nroComprobante` varchar(12) DEFAULT NULL,
  `nroSerie` varchar(4) DEFAULT NULL,
  `fechaCreacion` datetime DEFAULT NULL,
  `idEstadoPago` int(11) DEFAULT NULL,
  PRIMARY KEY (`idMedioPago`),
  KEY `FK_comprobanteventa` (`idTipoMedio`),
  KEY `FK_mediopago_estadopago` (`idEstadoPago`),
  CONSTRAINT `FK_mediopago_estadopago` FOREIGN KEY (`idEstadoPago`) REFERENCES `estadopago` (`idEstadoPago`),
  CONSTRAINT `FK_mediopago_tipomedio` FOREIGN KEY (`idTipoMedio`) REFERENCES `tipomedio` (`idTipoMedio`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8;

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
  `idMedioCobro` int(11) DEFAULT NULL,
  `idMedioPago` int(11) DEFAULT NULL,
  `idRepeticion` int(11) DEFAULT NULL,
  `nroRepeticion` int(11) DEFAULT NULL,
  `esConciliado` tinyint(4) DEFAULT NULL,
  `activo` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`idMovimiento`),
  KEY `FK_movimiento` (`idTipoMovimiento`),
  KEY `FK_movimiento_comprovanteventa` (`idMedioCobro`),
  KEY `FK_movimiento_comprobanteCpr` (`idMedioPago`),
  CONSTRAINT `FK_movimiento` FOREIGN KEY (`idTipoMovimiento`) REFERENCES `tipomovimiento` (`idTipoMovimiento`),
  CONSTRAINT `FK_movimiento_mediocobro` FOREIGN KEY (`idMedioCobro`) REFERENCES `mediocobro` (`idMedioCobro`),
  CONSTRAINT `FK_movimiento_mediopago` FOREIGN KEY (`idMedioPago`) REFERENCES `mediopago` (`idMedioPago`)
) ENGINE=InnoDB AUTO_INCREMENT=1031 DEFAULT CHARSET=utf8;

/*Table structure for table `movimiento_trace` */

DROP TABLE IF EXISTS `movimiento_trace`;

CREATE TABLE `movimiento_trace` (
  `idMovimiento` int(11) NOT NULL,
  `descripcion` varchar(128) DEFAULT NULL,
  `idTipoMovimiento` int(11) NOT NULL,
  `fechaPago` date NOT NULL,
  `importeIngreso` float DEFAULT NULL,
  `importeEgreso` float DEFAULT NULL,
  `fechaCreacion` datetime NOT NULL,
  `nroOrden` int(11) DEFAULT NULL,
  `idMovimientoOrigen` int(11) DEFAULT NULL,
  `idMedioCobro` int(11) DEFAULT NULL,
  `idMedioPago` int(11) DEFAULT NULL,
  `idRepeticion` int(11) DEFAULT NULL,
  `nroRepeticion` int(11) DEFAULT NULL,
  `esConciliado` tinyint(4) DEFAULT NULL,
  `fechaAccion` datetime NOT NULL,
  `accion` varchar(16) DEFAULT NULL,
  `activo` tinyint(4) DEFAULT NULL,
  `idTrace` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`idTrace`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8;

/*Table structure for table `movimientosaldomes` */

DROP TABLE IF EXISTS `movimientosaldomes`;

CREATE TABLE `movimientosaldomes` (
  `mes` int(11) NOT NULL,
  `anio` int(11) NOT NULL,
  `saldo` decimal(10,2) DEFAULT NULL,
  `fechaCarga` datetime DEFAULT NULL,
  PRIMARY KEY (`mes`,`anio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `necesidadpedido` */

DROP TABLE IF EXISTS `necesidadpedido`;

CREATE TABLE `necesidadpedido` (
  `idNecesidadPedido` int(11) NOT NULL AUTO_INCREMENT,
  `idOrdenPedido` int(11) DEFAULT NULL,
  `idProducto` int(11) unsigned DEFAULT NULL,
  `idParte` int(11) unsigned DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  PRIMARY KEY (`idNecesidadPedido`),
  KEY `FK_necesidadpedido_pedido` (`idOrdenPedido`),
  KEY `FK_necesidadpedido_producto` (`idProducto`),
  KEY `FK_necesidadpedido_parte` (`idParte`),
  CONSTRAINT `FK_necesidadpedido_parte` FOREIGN KEY (`idParte`) REFERENCES `parte` (`idParte`),
  CONSTRAINT `FK_necesidadpedido_pedido` FOREIGN KEY (`idOrdenPedido`) REFERENCES `ordenpedido` (`idOrdenPedido`),
  CONSTRAINT `FK_necesidadpedido_producto` FOREIGN KEY (`idProducto`) REFERENCES `producto` (`idProducto`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

/*Table structure for table `ordenpedido` */

DROP TABLE IF EXISTS `ordenpedido`;

CREATE TABLE `ordenpedido` (
  `idOrdenPedido` int(11) NOT NULL AUTO_INCREMENT,
  `idCliente` int(11) DEFAULT NULL,
  `fechaPedido` date DEFAULT NULL,
  `fechaEntrega` date DEFAULT NULL,
  `idEstadoPedido` int(11) DEFAULT NULL,
  `nroPedido` int(11) DEFAULT NULL,
  `costoTotal` double DEFAULT NULL,
  `precioTotal` double DEFAULT NULL,
  `margenTotal` double DEFAULT NULL,
  PRIMARY KEY (`idOrdenPedido`),
  KEY `FK_ordenpedido_cliente` (`idCliente`),
  KEY `FK_ordenpedido_estadoPedido` (`idEstadoPedido`),
  CONSTRAINT `FK_ordenpedido_cliente` FOREIGN KEY (`idCliente`) REFERENCES `cliente` (`idCliente`),
  CONSTRAINT `FK_ordenpedido_estadoPedido` FOREIGN KEY (`idEstadoPedido`) REFERENCES `ordenpedido_estado` (`idEstadoOrdenPedido`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Table structure for table `ordenpedido_estado` */

DROP TABLE IF EXISTS `ordenpedido_estado`;

CREATE TABLE `ordenpedido_estado` (
  `idEstadoOrdenPedido` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`idEstadoOrdenPedido`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Table structure for table `ordenpedidodetalle` */

DROP TABLE IF EXISTS `ordenpedidodetalle`;

CREATE TABLE `ordenpedidodetalle` (
  `idOrdenPedidoDetalle` int(11) NOT NULL AUTO_INCREMENT,
  `idOrdenPedido` int(11) NOT NULL,
  `idProducto` int(11) unsigned DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `costo` double DEFAULT NULL,
  `precio` double DEFAULT NULL,
  `margen` double DEFAULT NULL,
  `costoUnitario` double DEFAULT NULL,
  PRIMARY KEY (`idOrdenPedidoDetalle`),
  KEY `FK_ordenpedidodetalle_producto` (`idProducto`),
  KEY `FK_ordenpedidodetalle` (`idOrdenPedido`),
  CONSTRAINT `FK_ordenpedidodetalle` FOREIGN KEY (`idOrdenPedido`) REFERENCES `ordenpedido` (`idOrdenPedido`),
  CONSTRAINT `FK_ordenpedidodetalle_producto` FOREIGN KEY (`idProducto`) REFERENCES `producto` (`idProducto`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Table structure for table `parte` */

DROP TABLE IF EXISTS `parte`;

CREATE TABLE `parte` (
  `idParte` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(128) DEFAULT NULL,
  `codigo` varchar(24) DEFAULT NULL,
  `esParteFinal` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idParte`)
) ENGINE=InnoDB AUTO_INCREMENT=2335 DEFAULT CHARSET=latin1;

/*Table structure for table `parte_estadoparte` */

DROP TABLE IF EXISTS `parte_estadoparte`;

CREATE TABLE `parte_estadoparte` (
  `idEstadoParte` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(64) DEFAULT NULL,
  `duracion` int(11) DEFAULT NULL,
  PRIMARY KEY (`idEstadoParte`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `parte_temp` */

DROP TABLE IF EXISTS `parte_temp`;

CREATE TABLE `parte_temp` (
  `idParteTemp` int(11) NOT NULL AUTO_INCREMENT,
  `descripcionTemp` varchar(128) DEFAULT NULL,
  `codigoTemp` varchar(24) DEFAULT NULL,
  `esParteFinalTemp` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`idParteTemp`)
) ENGINE=InnoDB AUTO_INCREMENT=2299 DEFAULT CHARSET=latin1;

/*Table structure for table `producto` */

DROP TABLE IF EXISTS `producto`;

CREATE TABLE `producto` (
  `idProducto` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(24) DEFAULT NULL,
  `descripcion` varchar(128) DEFAULT NULL,
  `idParteFinal` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`idProducto`),
  KEY `FK_despiece.producto_parte` (`idParteFinal`),
  CONSTRAINT `FK_despiece.producto_parte` FOREIGN KEY (`idParteFinal`) REFERENCES `parte` (`idParte`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

/*Table structure for table `productoprecio` */

DROP TABLE IF EXISTS `productoprecio`;

CREATE TABLE `productoprecio` (
  `idPrecio` int(10) unsigned NOT NULL,
  `idProducto` int(10) unsigned DEFAULT NULL,
  `fechaInicio` datetime DEFAULT NULL,
  `precio` float DEFAULT NULL,
  `fechaFin` datetime DEFAULT NULL,
  `costo` float DEFAULT NULL,
  PRIMARY KEY (`idPrecio`),
  KEY `FK_despiece.productoprecio_producto` (`idProducto`),
  CONSTRAINT `FK_despiece.productoprecio_producto` FOREIGN KEY (`idProducto`) REFERENCES `producto` (`idProducto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `provincia` */

DROP TABLE IF EXISTS `provincia`;

CREATE TABLE `provincia` (
  `idProvincia` int(10) unsigned NOT NULL,
  `descripcion` varchar(64) DEFAULT NULL,
  `codigo` varchar(8) DEFAULT NULL,
  PRIMARY KEY (`idProvincia`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `repeticion` */

DROP TABLE IF EXISTS `repeticion`;

CREATE TABLE `repeticion` (
  `idRepeticion` int(11) NOT NULL AUTO_INCREMENT,
  `cantRepeticion` int(11) DEFAULT NULL,
  PRIMARY KEY (`idRepeticion`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

/*Table structure for table `rol` */

DROP TABLE IF EXISTS `rol`;

CREATE TABLE `rol` (
  `idRol` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`idRol`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Table structure for table `rol_accion` */

DROP TABLE IF EXISTS `rol_accion`;

CREATE TABLE `rol_accion` (
  `idRol` int(11) NOT NULL,
  `idAccion` int(11) NOT NULL,
  PRIMARY KEY (`idRol`,`idAccion`),
  KEY `FK_rol_accion_accion` (`idAccion`),
  CONSTRAINT `FK_rol_accion` FOREIGN KEY (`idRol`) REFERENCES `rol` (`idRol`),
  CONSTRAINT `FK_rol_accion_accion` FOREIGN KEY (`idAccion`) REFERENCES `accion` (`idAccion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `stockpartes` */

DROP TABLE IF EXISTS `stockpartes`;

CREATE TABLE `stockpartes` (
  `idStockPartes` int(11) NOT NULL AUTO_INCREMENT,
  `idParte` int(11) unsigned DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `fecUltimoIngreso` date DEFAULT NULL,
  `idAlmacen` int(11) DEFAULT NULL,
  `idEstadoParte` int(11) DEFAULT NULL,
  PRIMARY KEY (`idStockPartes`),
  KEY `FK_stockpartes_parte` (`idParte`),
  KEY `FK_stockpartes_almacen` (`idAlmacen`),
  KEY `FK_stockpartes_estadoParte` (`idEstadoParte`),
  CONSTRAINT `FK_stockpartes_almacen` FOREIGN KEY (`idAlmacen`) REFERENCES `almacen` (`idAlmacen`),
  CONSTRAINT `FK_stockpartes_estadoParte` FOREIGN KEY (`idEstadoParte`) REFERENCES `parte_estadoparte` (`idEstadoParte`),
  CONSTRAINT `FK_stockpartes_parte` FOREIGN KEY (`idParte`) REFERENCES `parte` (`idParte`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tipomedio` */

DROP TABLE IF EXISTS `tipomedio`;

CREATE TABLE `tipomedio` (
  `idTipoMedio` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`idTipoMedio`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Table structure for table `tipomovimiento` */

DROP TABLE IF EXISTS `tipomovimiento`;

CREATE TABLE `tipomovimiento` (
  `idTipoMovimiento` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`idTipoMovimiento`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Table structure for table `usuario` */

DROP TABLE IF EXISTS `usuario`;

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) DEFAULT NULL,
  `pass` varchar(16) DEFAULT NULL,
  `nombre` varchar(64) DEFAULT NULL,
  `apellido` varchar(64) DEFAULT NULL,
  `idRol` int(11) DEFAULT NULL,
  PRIMARY KEY (`idUsuario`),
  KEY `FK_usuario_Rol` (`idRol`),
  CONSTRAINT `FK_usuario_Rol` FOREIGN KEY (`idRol`) REFERENCES `rol` (`idRol`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/* Trigger structure for table `movimiento` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `movimientos_insert` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'aexo'@'%' */ /*!50003 TRIGGER `movimientos_insert` AFTER INSERT ON `movimiento` FOR EACH ROW BEGIN
	insert into aexomanager.movimiento_trace  set 
	idMovimiento=NEW.idMovimiento,
	descripcion=NEW.descripcion,
	idTipoMovimiento=NEW.idTipoMovimiento,
	fechaPago=NEW.fechaPago,
	importeIngreso=NEW.importeIngreso,
	importeEgreso=NEW.importeEgreso,
	fechaCreacion=NEW.fechaCreacion,
	nroOrden=NEW.nroOrden,
	idMovimientoOrigen=NEW.idMovimientoOrigen,
	idMedioCobro=NEW.idMedioCobro,
	idMedioPago=NEW.idMedioPago,
	idRepeticion=NEW.idRepeticion,
	nroRepeticion=NEW.nroRepeticion,
	esConciliado=NEW.esConciliado,
	fechaAccion=now(),
	accion='Insert';
	
    END */$$


DELIMITER ;

/* Trigger structure for table `movimiento` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `movimientos_update` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'aexo'@'%' */ /*!50003 TRIGGER `movimientos_update` AFTER UPDATE ON `movimiento` FOR EACH ROW BEGIN
	insert into aexomanager.movimiento_trace  set 
	idMovimiento=NEW.idMovimiento,
	descripcion=NEW.descripcion,
	idTipoMovimiento=NEW.idTipoMovimiento,
	fechaPago=NEW.fechaPago,
	importeIngreso=NEW.importeIngreso,
	importeEgreso=NEW.importeEgreso,
	fechaCreacion=NEW.fechaCreacion,
	nroOrden=NEW.nroOrden,
	idMovimientoOrigen=NEW.idMovimientoOrigen,
	idMedioCobro=NEW.idMedioCobro,
	idMedioPago=NEW.idMedioPago,
	idRepeticion=NEW.idRepeticion,
	nroRepeticion=NEW.nroRepeticion,
	esConciliado=NEW.esConciliado,
	fechaAccion=now(),
	accion='Update';
	
    END */$$


DELIMITER ;

/* Trigger structure for table `movimiento` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `movimientos_delete` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'aexo'@'%' */ /*!50003 TRIGGER `movimientos_delete` AFTER DELETE ON `movimiento` FOR EACH ROW BEGIN
	insert into aexomanager.movimiento_trace  set 
	idMovimiento=OLD.idMovimiento,
	descripcion=OLD.descripcion,
	idTipoMovimiento=OLD.idTipoMovimiento,
	fechaPago=OLD.fechaPago,
	importeIngreso=OLD.importeIngreso,
	importeEgreso=OLD.importeEgreso,
	fechaCreacion=OLD.fechaCreacion,
	nroOrden=OLD.nroOrden,
	idMovimientoOrigen=OLD.idMovimientoOrigen,
	idMedioCobro=OLD.idMedioCobro,
	idMedioPago=OLD.idMedioPago,
	idRepeticion=OLD.idRepeticion,
	nroRepeticion=OLD.nroRepeticion,
	esConciliado=OLD.esConciliado,
	fechaAccion=now(),
	accion='Delete';
	
    END */$$


DELIMITER ;

/* Function  structure for function  `GetAncestry` */

/*!50003 DROP FUNCTION IF EXISTS `GetAncestry` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`aexo`@`%` FUNCTION `GetAncestry`(_idDespiece INT) RETURNS varchar(1024) CHARSET latin1
    DETERMINISTIC
BEGIN
    DECLARE rv VARCHAR(1024);
    DECLARE cm CHAR(1);
    DECLARE ch INT;
    SET rv = '';
    SET cm = '';
    SET ch = _idDespiece ;
    WHILE ch > 0 DO
        SELECT IFNULL(idParent,-1) INTO ch FROM
        (SELECT idParent FROM despiece WHERE idDespiece = ch) A;
        IF ch > 0 THEN
            SET rv = CONCAT(rv,cm,ch);
            SET cm = ',';
        END IF;
    END WHILE;
    RETURN rv;
END */$$
DELIMITER ;

/* Function  structure for function  `GetFamilyTree` */

/*!50003 DROP FUNCTION IF EXISTS `GetFamilyTree` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`aexo`@`%` FUNCTION `GetFamilyTree`(_idDespiece int) RETURNS varchar(1024) CHARSET latin1
    DETERMINISTIC
BEGIN
    DECLARE rv,q,queue,queue_children,queue_names VARCHAR(1024);
    DECLARE queue_length,pos INT;
    DECLARE GivenidDespiece,front_idDespiece VARCHAR(64);
    SET rv = '';
    SELECT idDespiece INTO GivenidDespiece
    FROM despiece
    WHERE idDespiece = _idDespiece
    AND idParent is not null;
    IF ISNULL(GivenidDespiece) THEN
        RETURN rv;
    END IF;
    SET queue = GivenidDespiece;
    SET queue_length = 1;
    WHILE queue_length > 0 DO
        IF queue_length = 1 THEN
            SET front_idDespiece = queue;
            SET queue = '';
        ELSE
            SET pos = LOCATE(',',queue);
            SET front_idDespiece = LEFT(queue,pos - 1);
            SET q = SUBSTR(queue,pos + 1);
            SET queue = q;
        END IF;
        SET queue_length = queue_length - 1;
        SELECT IFNULL(qc,'') INTO queue_children
        FROM
        (
            SELECT GROUP_CONCAT(idDespiece) qc FROM despiece
            WHERE idParent = front_idDespiece AND idParent is not null
        ) A;
        SELECT IFNULL(qc,'') INTO queue_names
        FROM
        (
            SELECT GROUP_CONCAT(idDespiece) qc FROM despiece
            WHERE idParent = front_idDespiece AND idParent is not null
        ) A;
        IF LENGTH(queue_children) = 0 THEN
            IF LENGTH(queue) = 0 THEN
                SET queue_length = 0;
            END IF;
        ELSE
            IF LENGTH(rv) = 0 THEN
                SET rv = queue_names;
            ELSE
                SET rv = CONCAT(rv,',',queue_names);
            END IF;
            IF LENGTH(queue) = 0 THEN
                SET queue = queue_children;
            ELSE
                SET queue = CONCAT(queue,',',queue_children);
            END IF;
            SET queue_length = LENGTH(queue) - LENGTH(REPLACE(queue,',','')) + 1;
        END IF;
    END WHILE;
    RETURN rv;
END */$$
DELIMITER ;

/* Function  structure for function  `strSplit` */

/*!50003 DROP FUNCTION IF EXISTS `strSplit` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`aexo`@`%` FUNCTION `strSplit`(x VARCHAR(65000), delim VARCHAR(12), pos INTEGER) RETURNS varchar(65000) CHARSET latin1
BEGIN
  DECLARE output VARCHAR(65000);
  SET output = REPLACE(SUBSTRING(SUBSTRING_INDEX(x, delim, pos)
                 , LENGTH(SUBSTRING_INDEX(x, delim, pos - 1)) + 1)
                 , delim
                 , '');
  IF output = '' THEN SET output = null; END IF;
  RETURN output;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_DespieceHijosAgregar` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_DespieceHijosAgregar` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`aexo`@`%` PROCEDURE `sp_DespieceHijosAgregar`(p_idProducto int, 
							p_idParte int, 
							p_idDespiecePadre int, 
							p_cantidad  int)
BEGIN
	START TRANSACTION;
	/*
	select @jerarquiaHijo := jerarquia,
		@nivelHijo := nivel + 1,
		@idDespiecePadre := idDespiece
	from despiece 
	where idDespiece = p_idDespiecePadre;
	*/
	select jerarquia 
	from despiece 
	where idDespiece = p_idDespiecePadre into @jerarquiaHijo;
	select nivel + 1
	from despiece 
	where idDespiece = p_idDespiecePadre into @nivelHijo;
	select idDespiece
	from despiece 
	where idDespiece = p_idDespiecePadre into @idDespiecePadre;
	-- where idProducto = p_idProducto and idParte=p_idPartePadre;
	Insert into despiece (
				idProducto, 
				idParte, 
				idParent, 
				nivel, 
				cantidad) 
	values(	p_idProducto,
		p_idParte, 
		@idDespiecePadre,
		@nivelHijo,
		p_cantidad);
	select LAST_INSERT_ID()into @ultimoDespiece;
	update despiece set jerarquia = concat(@jerarquiaHijo,@ultimoDespiece,'/') where idDespiece = @ultimoDespiece;
	select @ultimoDespiece ultimoDespiece;
	COMMIT;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_DespieceHijosConsultar` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_DespieceHijosConsultar` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`aexo`@`%` PROCEDURE `sp_DespieceHijosConsultar`(p_idProducto int)
BEGIN
	-- declare @jerarquiaProducto as varchar(64);
	select jerarquia into @jerarquiaProducto from despiece where idProducto = p_idProducto and nivel = 1;
	select idDespiece,
		idProducto, 
		d.idParte, 
		descripcion, 
		d.jerarquia, 
		d.nivel,
		d.cantidad,
		(select idParte from despiece des where d.idParent = des.idDespiece) idPartePadre,
		case when i.IdParte is null then 0 else 1 end esInsumo,
		i.idInsumo
	from despiece d
	inner join parte p on d.idParte = p.idParte
	left join insumo i on d.IdParte = i.IdParte and i.Nivel=1
	where d.jerarquia like concat(@jerarquiaProducto,'%') order by d.jerarquia desc;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_DespieceHijosEliminar` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_DespieceHijosEliminar` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`aexo`@`%` PROCEDURE `sp_DespieceHijosEliminar`(p_idDespiece int)
BEGIN
	START TRANSACTION;
	
	select concat('%/',p_idDespiece,'/%') into @jerarquiaEliminar;
	
	Delete from despiece where jerarquia like @jerarquiaEliminar; -- '%/255/%'
	
	COMMIT;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_DespieceHijosPartesObtener` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_DespieceHijosPartesObtener` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`aexo`@`%` PROCEDURE `sp_DespieceHijosPartesObtener`(p_idProducto int, p_idParte int)
BEGIN
	-- declare @jerarquiaProducto as varchar(64);
	select jerarquia into @jerarquiaProducto 
	from despiece 
	-- where idProducto = p_idProducto and nivel = 1;
	where idProducto = p_idProducto and idParte = p_idParte;
	
	select idDespiece,
		idProducto, 
		d.idParte, 
		descripcion, 
		d.jerarquia, 
		d.nivel,
		d.cantidad,
		(select idParte from despiece des where d.idParent = des.idDespiece) idPartePadre,
		case when i.IdParte is null then 0 else 1 end esInsumo
	from despiece d
	inner join parte p on d.idParte = p.idParte
	left join insumo i on d.IdParte = i.IdParte and i.Nivel=1
	where d.jerarquia like concat(@jerarquiaProducto,'%') order by d.jerarquia desc;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_DespieceHijosXidDespiece` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_DespieceHijosXidDespiece` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`aexo`@`%` PROCEDURE `sp_DespieceHijosXidDespiece`(p_idDespiece int)
BEGIN
	-- declare @jerarquiaProducto as varchar(64);
	select jerarquia into @jerarquiaProducto 
	from despiece 
	-- where idProducto = p_idProducto and nivel = 1;
	where idDespiece = p_idDespiece;
	
	select idDespiece,
		idProducto, 
		d.idParte, 
		descripcion, 
		d.jerarquia, 
		d.nivel,
		d.cantidad,
		(select idParte from despiece des where d.idParent = des.idDespiece) idPartePadre,
		case when i.IdParte is null then 0 else 1 end esInsumo
	from despiece d
	inner join parte p on d.idParte = p.idParte
	left join Insumo i on d.IdParte = i.IdParte and i.Nivel=1
	where d.jerarquia like concat(@jerarquiaProducto,'%') order by d.jerarquia desc;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_DespieceObtenerHijos` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_DespieceObtenerHijos` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`aexo`@`%` PROCEDURE `sp_DespieceObtenerHijos`(p_idDespiece int)
BEGIN
	-- SELECT idDespiece into @idDespiecePadre from despiece where idProducto=p_idProducto and idParte = p_idParte;
	SELECT idProducto, p.idParte, p.descripcion, p.codigo, jerarquia, nivel, cantidad
	FROM despiece d
	Inner join parte p on d.idParte = p.idParte 
	WHERE d.idParent = p_idDespiece ;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_DespieceObtenerHijosCompletos` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_DespieceObtenerHijosCompletos` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`aexo`@`%` PROCEDURE `sp_DespieceObtenerHijosCompletos`(p_idDespiece int)
BEGIN
	-- declare @jerarquiaProducto as varchar(64);
	select jerarquia into @jerarquiaProducto 
	from despiece 
	-- where idProducto = p_idProducto and nivel = 1;
	where idDespiece = p_idDespiece;
	select d.idParte, 
		d.jerarquia, 
		d.nivel,
		d.cantidad,
		(select idParte from despiece des where d.idParent = des.idDespiece) idPartePadre
	from despiece d
	inner join parte p on d.idParte = p.idParte
	where d.jerarquia like concat(@jerarquiaProducto,'%') 
	order by d.nivel asc, d.jerarquia asc;
    END */$$
DELIMITER ;

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

/* Procedure structure for procedure `sp_flujoCajaRecalcular` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_flujoCajaRecalcular` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`aexo`@`%` PROCEDURE `sp_flujoCajaRecalcular`()
BEGIN
	 UPDATE movimientosaldomes AS mo
	 INNER JOIN (
		select mes, 
			anio, 
			saldo,
			ROUND(IFNULL(sum(importeIngreso),0) - IFNULL(sum(importeEgreso),0),2) saldoReal
		from movimiento as m
		inner join movimientosaldomes msm on msm.mes = month(fechaPago) and msm.anio= year(fechaPago)
		group by anio, mes
	) as MA
	SET mo.saldo = MA.saldoReal
	where MA.anio= mo.anio and MA.mes = mo.mes;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_InsumoAgregar` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_InsumoAgregar` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`aexo`@`%` PROCEDURE `sp_InsumoAgregar`(p_idParte int, 
							p_jerarquia varchar(64),
							p_idInsumoPadre  int,
							p_nivel int, 
							p_cantidad  int)
BEGIN
	Insert into insumo (	idParte, 
				jerarquia,
				idInsumoParent,
				nivel, 
				cantidad) 
	values(	p_idParte, 
		p_jerarquia,
		p_idInsumoPadre,
		p_nivel,
		p_cantidad);
	-- select @ultimoDespiece := LAST_INSERT_ID();
    END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_InsumoHijosAgregar` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_InsumoHijosAgregar` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`aexo`@`%` PROCEDURE `sp_InsumoHijosAgregar`(p_idParte int, 
							p_idInsumoParent int, 
							p_cantidad  int)
BEGIN
	START TRANSACTION;
	/*
	select @jerarquiaHijo := jerarquia,
		@nivelHijo := nivel + 1,
		@idDespiecePadre := idDespiece
	from despiece 
	where idDespiece = p_idDespiecePadre;
	*/
	select jerarquia 
	from insumo
	where idInsumo = p_idInsumoParent into @jerarquiaHijo;
	select nivel + 1
	from insumo 
	where idInsumo = p_idInsumoParent into @nivelHijo;
	select idInsumo
	from insumo 
	where idInsumo = p_idInsumoParent into @idInsumoPadre;
	-- where idProducto = p_idProducto and idParte=p_idPartePadre;
	Insert into insumo (	idParte, 
				idInsumoParent, 
				nivel, 
				cantidad) 
	values(	p_idParte, 
		@idInsumoPadre,
		@nivelHijo,
		p_cantidad);
	select LAST_INSERT_ID()into @ultimoInsumo;
	update insumo set jerarquia = concat(@jerarquiaHijo,@ultimoInsumo,'/') where idInsumo = @ultimoInsumo;
	select @ultimoInsumo ultimoInsumo;
	COMMIT;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_InsumoHijosConsultar` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_InsumoHijosConsultar` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`aexo`@`%` PROCEDURE `sp_InsumoHijosConsultar`(p_idParte int, p_idInsumo int)
BEGIN
	select jerarquia into @jerarquiaProducto 
	from insumo 
	where (p_idInsumo is null and idParte = p_idParte) and nivel = 1 or (p_idParte is null and p_idInsumo = idInsumo);
		
	select idInsumo,
		i.idParte,
		descripcion,
		i.jerarquia,
		i.nivel,
		i.cantidad,
		(select idParte from insumo ins where i.idInsumoParent = ins.idinsumo) idPartePadre,
		case when i.IdParte is null then 0 else 1 end esInsumo
	from insumo i
	inner join parte p on i.idParte = p.idParte
	where i.jerarquia like concat(@jerarquiaProducto,'%') order by i.jerarquia desc;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_InsumoHijosEliminar` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_InsumoHijosEliminar` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`aexo`@`%` PROCEDURE `sp_InsumoHijosEliminar`(p_idInsumo int)
BEGIN
	START TRANSACTION;
	
	select concat('%/',p_idInsumo,'/%') into @jerarquiaEliminar;
	
	Delete from insumo where jerarquia like @jerarquiaEliminar; -- '%/255/%'
	
	COMMIT;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_InsumoObtenerHijos` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_InsumoObtenerHijos` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`aexo`@`%` PROCEDURE `sp_InsumoObtenerHijos`(p_idInsumo int)
BEGIN
	-- SELECT idDespiece into @idDespiecePadre from despiece where idProducto=p_idProducto and idParte = p_idParte;
	SELECT p.idParte, p.descripcion, p.codigo, jerarquia, nivel, cantidad, idInsumo
	FROM insumo i
	Inner join parte p on i.idParte = p.idParte 
	WHERE i.idInsumoParent = p_idInsumo ;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_OrdenPedidoAgregar` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_OrdenPedidoAgregar` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`aexo`@`%` PROCEDURE `sp_OrdenPedidoAgregar`(p_idCliente int, 
							p_fechaPedido date,
							p_fechaEntrega date,
							p_idEstadoPedido int,
							p_nroPedido int,
							p_precioTotal double,
							p_costoTotal double)
BEGIN
	if p_nroPedido is null THEN
		select max(nroPedido) + 1 into p_nroPedido from ordenpedido;
		Insert into ordenpedido (idCliente, 
					fechaPedido,
					fechaEntrega,
					idEstadoPedido, 
					nroPedido,
					precioTotal, 
					costoTotal) 
		values(	p_idCliente, 
			p_fechaPedido,
			p_fechaEntrega,
			p_idEstadoPedido,
			p_nroPedido,
			p_precioTotal,
			p_costoTotal);
		Select LAST_INSERT_ID() idUltimoPedido, p_nroPedido nroUltimoPedido;
	ELSE
		Update ordenpedido set
			fechaPedido = p_fechaPedido,
			fechaEntrega = p_fechaEntrega,
			idEstadoPedido = p_idEstadoPedido,
			precioTotal = p_precioTotal,
			costoTotal = p_costoTotal
		where nroPedido = p_nroPedido;
		Select idOrdenPedido idUltimoPedido, p_nroPedido nroUltimoPedido from ordenpedido where nroPedido = p_nroPedido;
	END IF;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_ParteImportarTemporal` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_ParteImportarTemporal` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`aexo`@`%` PROCEDURE `sp_ParteImportarTemporal`(p_idParteTemporal int)
BEGIN
	insert into parte (codigo, descripcion) 
		select codigoTemp, descripcionTemp from parte_temp where idParteTemp = p_idParteTemporal;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_ParteObtener` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_ParteObtener` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`aexo`@`%` PROCEDURE `sp_ParteObtener`(p_idParte int)
BEGIN
	
	SELECT p.idParte, 
		`descripcion`, 
		`codigo`, 
		`esParteFinal`, 
		case when i.IdParte is null then 0 else 1 end esInsumo
		
	FROM parte p
	left join insumo i on p.IdParte = i.IdParte
	WHERE p.idParte = p_idParte ;
    END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
