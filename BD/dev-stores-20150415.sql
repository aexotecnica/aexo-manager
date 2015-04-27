/*
SQLyog Enterprise - MySQL GUI v7.15 
MySQL - 5.6.21 : Database - aexomanager
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

/* Procedure structure for procedure `sp_DespieceHijosAgregar` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_DespieceHijosAgregar` */;

DELIMITER $$

/*!50003 CREATE   PROCEDURE `sp_DespieceHijosAgregar`(p_idProducto int, 
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

/*!50003 CREATE   PROCEDURE `sp_DespieceHijosConsultar`(p_idProducto int)
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
	left join Insumo i on d.IdParte = i.IdParte and i.Nivel=1
	where d.jerarquia like concat(@jerarquiaProducto,'%') order by d.jerarquia desc;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_DespieceHijosEliminar` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_DespieceHijosEliminar` */;

DELIMITER $$

/*!50003 CREATE   PROCEDURE `sp_DespieceHijosEliminar`(p_idDespiece int)
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

/*!50003 CREATE   PROCEDURE `sp_DespieceHijosPartesObtener`(p_idProducto int, p_idParte int)
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
	left join Insumo i on d.IdParte = i.IdParte and i.Nivel=1
	where d.jerarquia like concat(@jerarquiaProducto,'%') order by d.jerarquia desc;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_DespieceHijosXidDespiece` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_DespieceHijosXidDespiece` */;

DELIMITER $$

/*!50003 CREATE   PROCEDURE `sp_DespieceHijosXidDespiece`(p_idDespiece int)
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

/*!50003 CREATE   PROCEDURE `sp_DespieceObtenerHijos`(p_idDespiece int)
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

/*!50003 CREATE   PROCEDURE `sp_DespieceObtenerHijosCompletos`(p_idDespiece int)
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

/*!50003 CREATE   PROCEDURE `sp_flujoCaja`(p_mes  int, p_anio int)
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

/* Procedure structure for procedure `sp_InsumoAgregar` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_InsumoAgregar` */;

DELIMITER $$

/*!50003 CREATE   PROCEDURE `sp_InsumoAgregar`(p_idParte int, 
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

/*!50003 CREATE   PROCEDURE `sp_InsumoHijosAgregar`(p_idParte int, 
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

/*!50003 CREATE   PROCEDURE `sp_InsumoHijosConsultar`(p_idParte int, p_idInsumo int)
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

/* Procedure structure for procedure `sp_InsumoObtenerHijos` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_InsumoObtenerHijos` */;

DELIMITER $$

/*!50003 CREATE   PROCEDURE `sp_InsumoObtenerHijos`(p_idInsumo int)
BEGIN
	-- SELECT idDespiece into @idDespiecePadre from despiece where idProducto=p_idProducto and idParte = p_idParte;
	SELECT p.idParte, p.descripcion, p.codigo, jerarquia, nivel, cantidad, idInsumo
	FROM insumo i
	Inner join parte p on i.idParte = p.idParte 
	WHERE i.idInsumoParent = p_idInsumo ;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_ParteImportarTemporal` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_ParteImportarTemporal` */;

DELIMITER $$

/*!50003 CREATE   PROCEDURE `sp_ParteImportarTemporal`(p_idParteTemporal int)
BEGIN
	insert into parte (codigo, descripcion) 
		select codigoTemp, descripcionTemp from parte_temp where idParteTemp = p_idParteTemporal;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_ParteObtener` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_ParteObtener` */;

DELIMITER $$

/*!50003 CREATE   PROCEDURE `sp_ParteObtener`(p_idParte int)
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