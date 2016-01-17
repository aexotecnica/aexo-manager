`mediocobro_facturavta`


SELECT facturavta.idFactura, 
	nroFactura, 
	fechaFactura,
	fechaVencimiento,
	iva,
	(ROUND(importe,2) + ROUND(iva,2))- ROUND(SUM(IFNULL(`mediocobro_facturavta`.`importePagado`,0)),2) AS importeApagar,
	idEstadoFactura
FROM facturavta
INNER JOIN cliente ON facturavta.idCliente = cliente.idCliente
LEFT JOIN `mediocobro_facturavta` ON `mediocobro_facturavta`.`idFactura` = `facturavta`.`idFactura`
WHERE cliente.idCliente=509
GROUP BY `mediocobro_facturavta`.`idFactura`
HAVING importeApagar>0
