SELECT tc.`codigo`,tc.`descripcion`, ocm.* FROM `old_clientesmovimientos` ocm 
INNER JOIN ivacompras_tipocomprobantes tc
ON ocm.`tipo` = tc.`tipo_oldProveeMovimiento`


SELECT * FROM `old_clientes`
SELECT *, gravado+iva, ROUND((iva*100)/gravado,2)  FROM `old_clientesmovimientos`


SELECT CONCAT('20',SUBSTRING(ocm.fecha,5,2),SUBSTRING(ocm.fecha,3,2),SUBSTRING(ocm.fecha,1,2)) fecha,
	LPAD(tc.`codigo`,3,'0')tipoComprobante,
	CONCAT('0',SUBSTRING(ocm.`numero`,1,4)) puntoVenta,
	CONCAT('000000000000',SUBSTRING(ocm.`numero`,5,8)) numComprobante,
	'                ' nroDespacho,
	'80' codDocumento,
	LPAD(cuit,20,'0') nroVendedor,
	RPAD(nombre,30,' ') nombreProveedor,
	LPAD(REPLACE(CAST(ROUND(ocm.`gravado`+ocm.`iva` , 2 )AS CHAR(20)),'.',''),15,'0') importeTotal, -- sumo gravado + iva, redondeo para que me de dos decimales, casteo a char para sacar la coma, y relleno con 0
	'000000000000000' importeTotalNoPrecioNeto,
	'000000000000000' importeExcentas,
	'000000000000000' importePercValorAgregado,
	'000000000000000' importePercImpuestoNacional,
	'000000000000000' importeIngBrutos,
	'000000000000000' importeImpuestoMunicipal,
	'000000000000000' importeImpuestoInterno,
	'PES' codMoneda,
	'0001000000' tipoCambio, -- 4 primeros son enteros, 6 restantes decimales,
	'1' cantCuotas,
	'A' codOperacion,
	LPAD(REPLACE(CAST(ROUND(ocm.iva , 2 )AS CHAR(20)),'.',''),15,'0') creditoFiscal,
	'000000000000000' otrosAtributos,
	'00000000000' cuitEmisor,
	'                              ' nombreEmisor,
	'000000000000000' ivaComision
	
FROM `old_clientesmovimientos` ocm
INNER JOIN ivacompras_tipocomprobantes tc ON ocm.`tipo` = tc.`tipo_oldProveeMovimiento`
INNER JOIN `old_clientes` oc ON ocm.`codigo` = oc.codigo
ORDER BY fecha

SELECT CONCAT(CAST(tipoComprobante AS CHAR(50)),
		CAST(puntoVenta AS CHAR(50)), 
		CAST(numComprobante AS CHAR(50)), 
		CAST(codDocumento AS CHAR(50)),
		CAST(nroVendedor AS CHAR(50)),
		CAST(importeTotal AS CHAR(50)),
		CAST(alicuota AS CHAR(50)),
		CAST(impuestoLiquidado AS CHAR(50))) FROM 
(SELECT 	LPAD(tc.`codigo`,3,'0')tipoComprobante,
	CONCAT('0',SUBSTRING(ocm.`numero`,1,4)) puntoVenta,
	CONCAT('000000000000',SUBSTRING(ocm.`numero`,5,8)) numComprobante,
	'80' codDocumento,
	LPAD(cuit,20,'0') nroVendedor,
	LPAD(REPLACE(CAST(ROUND(ocm.`gravado`, 2 )AS CHAR(20)),'.',''),15,'0') importeTotal, -- sumo gravado + iva, redondeo para que me de dos decimales, casteo a char para sacar la coma, y relleno con 0
	IF (ROUND((iva*100)/gravado,2) < 20, '0004', IF (ROUND((iva*100)/gravado,2) > 20 AND ROUND((iva*100)/gravado,2) < 25, '0005','0006')) AS alicuota ,
	LPAD(REPLACE(CAST(ROUND(ocm.iva , 2 )AS CHAR(20)),'.',''),15,'0') impuestoLiquidado

FROM `old_clientesmovimientos` ocm
INNER JOIN ivacompras_tipocomprobantes tc ON ocm.`tipo` = tc.`tipo_oldProveeMovimiento`
INNER JOIN `old_clientes` oc ON ocm.`codigo` = oc.codigo
WHERE MONTH(fecha) = p_mes
ORDER BY fecha, numero) AS a

CALL sp_citiCompras_Movimientos(1)
CALL sp_citiCompras_alicuotas(1)