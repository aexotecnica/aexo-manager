select *, Jerarquia.ToString() from insumo order by Jerarquia


select A.idDespiece, A.IdProducto,A.IdParte,A.Cantidad,A.Nivel,
Jerarquia.ToString(), 
(select B.idDespiece from Despiece B where B.jerarquia = A.Jerarquia.GetAncestor(1))  from Despiece A


select * from Parte where IdParte in (1,
2,
3,
10,
11,
12,
14)

select * from producto