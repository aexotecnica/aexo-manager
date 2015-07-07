select -7647.56 - 54142.70

select IFNULL(sum(importeIngreso),0), IFNULL(sum(importeEgreso),0), IFNULL(sum(importeIngreso),0) - IFNULL(sum(importeEgreso),0) from movimiento
where year(fechaPago) = 2015 and month(fechaPago) = 8




update

select mes, 
	anio, 
	saldo,
	ROUND(IFNULL(sum(importeIngreso),0) - IFNULL(sum(importeEgreso),0),2)
from movimiento
inner join movimientosaldomes msm on msm.mes = month(fechaPago) and msm.anio= year(fechaPago)
group by anio, mes



 UPDATE movimientosaldomes AS MO
 INNER JOIN (
	select mes, 
		anio, 
		saldo,
		ROUND(IFNULL(sum(importeIngreso),0) - IFNULL(sum(importeEgreso),0),2) saldoReal
	from movimiento as m
	inner join movimientosaldomes msm on msm.mes = month(fechaPago) and msm.anio= year(fechaPago)
	group by anio, mes
) as MA
SET MO.saldo = MA.saldoReal
where Ma.anio= mo.anio and ma.mes = mo.mes