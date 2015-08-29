
SELECT CONCAT(
	CAST(fechaString AS CHAR(90)), 
	CAST(tipoComprobante AS CHAR(90)), 
	CAST(puntoVenta AS CHAR(90)),
	CAST(numComprobanteDesde AS CHAR(90)),
	CAST(numComprobanteHasta AS CHAR(90)),
	CAST(codDocumento AS CHAR(90)),
	CAST(nroComprador AS CHAR(90)),
	CAST(nombreCliente AS CHAR(90)),
	CAST(importeTotal AS CHAR(90)),
	CAST(importeTotalNoPrecioNeto AS CHAR(90)),
	CAST(importePercNoCategorizadas AS CHAR(90)),
	CAST(importeExcentas AS CHAR(90)),
	CAST(importePercImpuestoNacional AS CHAR(90)),
	CAST(importeIngBrutos AS CHAR(90)),
	CAST(importeImpuestoMunicipal AS CHAR(90)),
	CAST(importeImpuestoInterno AS CHAR(90)),
	CAST(codMoneda AS CHAR(90)),
	CAST(tipoCambio AS CHAR(90)),
	CAST(cantCuotas AS CHAR(90)),
	CAST(codOperacion AS CHAR(90)),
	CAST(creditoFiscal AS CHAR(90)),
	CAST(otrosAtributos AS CHAR(90)),
	CAST(fechaVencimiento AS CHAR(90))
	) AS linea
	
	
FROM (
	SELECT CONCAT('20',SUBSTRING(ocm.fecha,5,2),SUBSTRING(ocm.fecha,3,2),SUBSTRING(ocm.fecha,1,2)) fechaString,
		LPAD(tc.`codigo`,3,'0')tipoComprobante,
		CONCAT('0',SUBSTRING(ocm.`numero`,1,4)) puntoVenta,
		CONCAT('000000000000',SUBSTRING(ocm.`numero`,5,8)) numComprobanteDesde,
		CONCAT('000000000000',SUBSTRING(ocm.`numero`,5,8)) numComprobanteHasta,
-- 		'                ' nroDespacho,
		'80' codDocumento,
		LPAD(cuit,20,'0') nroComprador,
		RPAD(nombre,30,' ') nombreCliente,
		LPAD(REPLACE(CAST(ROUND(((SUM(cantidad * precio) * iva) /100) + SUM(cantidad * precio)  , 2 )AS CHAR(20)),'.',''),15,'0') importeTotal, -- sumo gravado + iva, redondeo para que me de dos decimales, casteo a char para sacar la coma, y relleno con 0
		'000000000000000' importeTotalNoPrecioNeto,
		'000000000000000' importePercNoCategorizadas,
		'000000000000000' importeExcentas,
		'000000000000000' importePercImpuestoNacional,
		'000000000000000' importeIngBrutos,
		'000000000000000' importeImpuestoMunicipal,
		'000000000000000' importeImpuestoInterno,
		'PES' codMoneda,
		'0001000000' tipoCambio, -- 4 primeros son enteros, 6 restantes decimales,
		'1' cantCuotas,
		'A' codOperacion,
		LPAD(REPLACE(CAST(ROUND(SUM(cantidad * precio), 2 ) AS CHAR(20)),'.',''),15,'0') creditoFiscal,
		'000000000000000' otrosAtributos,
		'00000000000' fechaVencimiento
	FROM `old_vtamovimiento` ocm
	INNER JOIN ivacompras_tipocomprobantes tc ON ocm.`tipo` = tc.`tipo_oldVtaMovimiento`
	INNER JOIN `old_clientes` oc ON ocm.`cliente` = oc.codigo
	GROUP BY numero -- , cantidad, precio 
	) AS t 
	WHERE MONTH(fecha) = p_mes AND YEAR(fecha) = p_anio;

