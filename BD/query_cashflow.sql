SET @algo = 0;

select idMovimiento, 
	descripcion,
	idTipoMovimiento,
	fechaPago,
	CASE 
	    WHEN idTipoMovimiento = 1 THEN importeIngreso
	    WHEN idTipoMovimiento = 2 THEN importeEgreso * -1
	END as importe,
	@algo := CASE 
	    WHEN idTipoMovimiento = 1 THEN importeIngreso
	    WHEN idTipoMovimiento = 2 THEN importeEgreso * -1
	END  + @algo as acumulado
from movimiento
order by fechaPago
-- http://foros.cristalab.com/suma-acumulada-en-un-query-mysql-t59954/


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
								order by fechaPago) as calculado
						group by fechaPago) as sumarizado