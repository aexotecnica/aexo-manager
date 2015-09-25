UPDATE cliente SET cuit = LEFT(cuit,11) 
WHERE codigo IS NOT NULL

UPDATE cliente SET codigo = TRIM(codigo)
WHERE codigo IS NOT NULL


UPDATE cliente 
SET esCliente = CASE WHEN LEFT(codigo,1) = 'C' THEN 1 ELSE 0 END,
	esProveedor = CASE WHEN LEFT(codigo,1) = 'P' THEN 1 ELSE 0 END
WHERE codigo IS NOT NULL