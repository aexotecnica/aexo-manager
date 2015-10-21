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
/* Function  structure for function  `GetAncestry` */

/*!50003 DROP FUNCTION IF EXISTS `GetAncestry` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `GetAncestry`(_idDespiece INT) RETURNS varchar(1024) CHARSET latin1
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

/*!50003 CREATE FUNCTION `GetFamilyTree`(_idDespiece int) RETURNS varchar(1024) CHARSET latin1
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

/*!50003 CREATE FUNCTION `strSplit`(x VARCHAR(65000), delim VARCHAR(12), pos INTEGER) RETURNS varchar(65000) CHARSET latin1
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

/*!50003 CREATE PROCEDURE `sp_DespieceHijosAgregar`(p_idProducto int, 
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

/*!50003 CREATE PROCEDURE `sp_DespieceHijosConsultar`(p_idProducto int)
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

/*!50003 CREATE PROCEDURE `sp_DespieceHijosEliminar`(p_idDespiece int)
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

/*!50003 CREATE PROCEDURE `sp_DespieceHijosPartesObtener`(p_idProducto int, p_idParte int)
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

/*!50003 CREATE PROCEDURE `sp_DespieceHijosXidDespiece`(p_idDespiece int)
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

/*!50003 CREATE PROCEDURE `sp_DespieceObtenerHijos`(p_idDespiece int)
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

/*!50003 CREATE PROCEDURE `sp_DespieceObtenerHijosCompletos`(p_idDespiece int)
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

/* Procedure structure for procedure `sp_FacturaVtaAgregar` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_FacturaVtaAgregar` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `sp_FacturaVtaAgregar`(p_idCliente int, 
							p_nroFactura int,
							p_fechaFactura date,
							p_fechaVencimiento DATE,							
							p_importe double,
							p_iva double)
BEGIN
	if NOT EXISTS (SELECT 1 FROM facturaVta WHERE nroFactura=p_nroFactura) THEN
		Insert into facturavta (idCliente, 
					fechaFactura,
					fechaVencimiento,
					nroFactura, 
					importe,
					iva) 
		values(	p_idCliente, 
			p_fechaFactura,
			p_fechaVencimiento,
			p_nroFactura,
			p_importe,
			p_iva);
		Select LAST_INSERT_ID() idFactura, p_nroFactura nroUltimaFactura;
	ELSE
		Update facturavta set
			fechaFactura = p_fechaFactura,
			fechaVencimiento = p_fechaVencimiento,
			nroFactura = p_nroFactura,
			importe = p_importe,
			iva = p_iva
		where nroFactura = p_nroFactura;
		Select idFactura idFactura, p_nroFactura nroUltimaFactura from facturaVta where nroFactura = p_nroFactura;
	END IF;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_flujoCaja` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_flujoCaja` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `sp_flujoCaja`(p_mes  int, p_anio int)
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
									where MONTH(fechaPago) = p_mes and year(fechaPago) = p_anio and activo=1
									order by fechaPago) as calculado
							group by fechaPago) as sumarizado;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_flujoCajaRecalcular` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_flujoCajaRecalcular` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `sp_flujoCajaRecalcular`()
BEGIN
	 UPDATE movimientosaldomes AS mo
	 INNER JOIN (
		select mes, 
			anio, 
			saldo,
			ROUND(IFNULL(sum(importeIngreso),0) - IFNULL(sum(importeEgreso),0),2) saldoReal
		from movimiento as m
		inner join movimientosaldomes msm on msm.mes = month(fechaPago) and msm.anio= year(fechaPago)
		where activo=1
		group by anio, mes
	) as MA
	SET mo.saldo = MA.saldoReal
	where MA.anio= mo.anio and MA.mes = mo.mes;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_InsumoAgregar` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_InsumoAgregar` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `sp_InsumoAgregar`(p_idParte int, 
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

/*!50003 CREATE PROCEDURE `sp_InsumoHijosAgregar`(p_idParte int, 
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

/*!50003 CREATE PROCEDURE `sp_InsumoHijosConsultar`(p_idParte int, p_idInsumo int)
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

/*!50003 CREATE PROCEDURE `sp_InsumoHijosEliminar`(p_idInsumo int)
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

/*!50003 CREATE PROCEDURE `sp_InsumoObtenerHijos`(p_idInsumo int)
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

/*!50003 CREATE PROCEDURE `sp_OrdenPedidoAgregar`(p_idCliente int, 
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

/* Procedure structure for procedure `sp_OrdenPedidoDetalleEnConjunto` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_OrdenPedidoDetalleEnConjunto` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `sp_OrdenPedidoDetalleEnConjunto`(p_idsOrdenPedidos varchar(256))
BEGIN
	/*
	SELECT opd.idOrdenPedido,
		opd.idOrdenPedidoDetalle,
		c.nombre,
		p.idProducto,
		p.descripcion,
		cantidad,
		opd.precio
	FROM ordenpedido op
	inner join ordenpedidodetalle opd on op.idOrdenPedido = opd.idOrdenPedido
	inner join cliente c on c.idCliente = op.idCliente
	inner join producto p on p.idProducto = opd.idProducto
	WHERE FIND_IN_SET(op.idOrdenPedido, p_idsOrdenPedidos);
	*/
	SELECT opd.idOrdenPedido,
		opd.idOrdenPedidoDetalle,
		c.nombre,
		p.idProducto,
		p.descripcion,
		opd.cantidad -  SUM(IFNULL(fd.`cantidad`,0)) cantidad,
		(opd.precio / opd.cantidad) * (opd.cantidad -  SUM(IFNULL(fd.`cantidad`,0))) as precio
		-- opd.precio
	FROM ordenpedido op
	INNER JOIN ordenpedidodetalle opd ON op.idOrdenPedido = opd.idOrdenPedido
	INNER JOIN cliente c ON c.idCliente = op.idCliente
	INNER JOIN producto p ON p.idProducto = opd.idProducto
	LEFT JOIN facturavtadetalle fd ON fd.`idOrdenPedido`= opd.`idOrdenPedido` AND fd.`idOrdenPedidoDetalle`=opd.`idOrdenPedidoDetalle`
	WHERE FIND_IN_SET(op.idOrdenPedido, p_idsOrdenPedidos)
	GROUP BY fd.idProducto,opd.idOrdenPedido, opd.idOrdenPedidoDetalle;
	
    END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_ParteImportarTemporal` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_ParteImportarTemporal` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `sp_ParteImportarTemporal`(p_idParteTemporal int)
BEGIN
	insert into parte (codigo, descripcion) 
		select codigoTemp, descripcionTemp from parte_temp where idParteTemp = p_idParteTemporal;
	select LAST_INSERT_ID() as UltimoId;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_ParteObtener` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_ParteObtener` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `sp_ParteObtener`(p_idParte int)
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

/* Procedure structure for procedure `sp_parte_estadosConfObtener` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_parte_estadosConfObtener` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `sp_parte_estadosConfObtener`(p_idParte int)
BEGIN
	SELECT pc.idEstadoParte, 
		descripcion, orden, 
		IF (pf.idEstadoParte IS NULL,0,1) AS seleccionado
	-- Case when pf.idEstadoParte is Null then 0 else 1 end as seleccionado
	FROM `parte_estadoparte` pc
	LEFT JOIN `parte_estadoconf` pf ON pc.idEstadoParte = pf.idEstadoParte and pf.idParte = p_idParte;
	
    END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_StockActualizar` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_StockActualizar` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `sp_StockActualizar`(p_idParte int, 
						p_cantidad int, 
						p_idAlmacen int,
						p_idEstadoParte int,
						p_descripcion varchar(128),
						p_fechaIngreso datetime)
BEGIN
	set @idStockParte = 0;
	set @cantidad = null;
	SELECT idStockPartes INTO @idStockParte  from stockpartes
	where idParte=p_idParte 
		and idAlmacen = p_idAlmacen 
		and idEstadoParte = p_idEstadoParte;
	if @idStockParte <> 0 then
		update stockpartes
		set cantidad = cantidad + p_cantidad, 
			fechaModificacion = now(), fechaIngreso= p_fechaIngreso, descripcion = p_descripcion
		where idParte=p_idParte 
		and idAlmacen = p_idAlmacen 
		and idEstadoParte = p_idEstadoParte;
	else 
		insert into stockpartes
			(idParte, 
			cantidad, 
			fechaModificacion,
			fechaIngreso,
			idAlmacen,
			descripcion,
			idEstadoParte) 
		values (p_idParte,
			p_cantidad,
			now(),
			p_fechaIngreso,
			p_idAlmacen,
			p_descripcion,
			p_idEstadoParte);
	end if;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_StockObtenerFaltantes` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_StockObtenerFaltantes` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `sp_StockObtenerFaltantes`()
BEGIN
	select A.idParte, 
		parte.descripcion, 
		cantidadNecesidad - ifnull(cantidad,0) as cantidadFaltante 
	from (select idParte, sum(cantidad) cantidadNecesidad
		from necesidadpedido
		group by idParte) as A
	inner join parte on A.idParte=parte.idParte
	left join stockpartes stock on A.idParte = stock.idParte;
    END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
