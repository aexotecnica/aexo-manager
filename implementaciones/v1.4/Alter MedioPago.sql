ALTER TABLE medioPago ADD COLUMN idEstadoPago int

alter table `aexomanager`.`mediopago` add constraint `FK_mediopago_mediopago` FOREIGN KEY (`idEstadoPago`) REFERENCES `estadopago` (`idEstadoPago`)