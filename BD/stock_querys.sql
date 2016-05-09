SELECT idParte, descripcion, cantidadFaltante FROM (
	SELECT A.idParte, 
		parte.descripcion, 
		cantidadNecesidad - IFNULL(cantidad,0) AS cantidadFaltante 
	FROM (SELECT idParte, SUM(cantidad) cantidadNecesidad
		FROM necesidadpedido
		GROUP BY idParte) AS A
	INNER JOIN parte ON A.idParte=parte.idParte
	LEFT JOIN despiece ON a.idParte = despiece.idParte
	LEFT JOIN stockpartes stock ON A.idParte = stock.idParte
	WHERE despiece.idProducto=21
	
	) AS faltante
	WHERE cantidadFaltante > 0;
	

SELECT d.idDespiece, d.idproducto, d.idParte, idParent, d.nivel,IFNULL(stock.cantidad,0) cantidadStock , cantidadNecesidad - IFNULL(stock.cantidad,0) AS cantidadFaltante , cantidadNecesidad
FROM despiece d
INNER JOIN (	
	SELECT p.idProducto, n.idParte, st.cantidad, SUM(n.cantidad)- st.cantidad cantidadNecesidad
	FROM necesidadpedido AS n
	INNER JOIN producto AS p ON n.idParte = p.idPartefinal
	INNER JOIN stockpartes AS st ON p.idPartefinal = st.idParte
	GROUP BY n.idParte
	) AS b ON d.idProducto = b.idProducto
LEFT JOIN stockpartes stock ON d.idParte = stock.idParte
WHERE nivel<>1

SELECT * FROM necesidadpedido

SELECT * FROM despiece WHERE idproducto=21

SELECT p.idProducto, 
	n.idParte,
	st.cantidad,
	SUM(n.cantidad)- st.cantidad cantidadNecesidad
--	SUM(st.cantidad), 
-- 	SUM(n.cantidad)- SUM(st.cantidad) cantidadNecesidad
FROM necesidadpedido AS n
INNER JOIN producto AS p ON n.idParte = p.idPartefinal
INNER JOIN stockpartes AS st ON p.idPartefinal = st.idParte
GROUP BY n.idParte




