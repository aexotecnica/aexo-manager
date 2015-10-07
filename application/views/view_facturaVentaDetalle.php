<?php echo form_open( "jsFacturaVentaDetalle/guardar", 'method="post" id="formBody" autocomplete="off" enctype="multipart/form-data"'); ?>
<div id="page-heading">
	<ul class="breadcrumb">
		<li><a href="index.htm">Dashboard</a></li>
		<li>Factura de Venta</li>
		<li class="active">Nueva</li>
	</ul>

	<h1>Ingresar Factura de Venta</h1>
</div>
<div class="container">
	<div class="panel panel-midnightblue">
		<div class="panel-heading">
			<h4>Factura de Venta</h4>
			<div class="options">   
				<a class="panel-collapse" href="javascript:;"><i class="fa fa-chevron-down"></i></a>
			</div>
		</div>
		<div class="panel-body collapse in">
			<div class="form-group">
				<div class="row">
					<div class="col-md-6">
						<input type="text" value="<?= ($facturaVenta!=NULL) ? $facturaVenta->nroFactura : $nroFactura; ?>" readonly="readonly" name="txtNroFactura" id="txtNroFactura" class="form-control" placeholder="Nro de Factura">
					</div>
					<div class="col-md-6">
						<input type="text" value="<?= ($facturaVenta!=NULL) ? $facturaVenta->fechaFactura :""; ?>" name="txtFechaFactura" id="txtFechaFactura" required="required" class="form-control" placeholder="Fecha Factura" required="required">
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-md-6">
						<input type="hidden" value="<?= ($facturaVenta!=NULL) ? $facturaVenta->idCliente :""; ?>" name="txtIdCliente" id="txtIdCliente" required="required" class="form-control" placeholder="Id">
						<input type="text" value="<?= ($facturaVenta!=NULL) ? $facturaVenta->cliente_nombre :""; ?>" name="txtClienteDescripcion" id="txtClienteDescripcion" required="required" class="form-control" required="required" placeholder="Cliente">
					</div>
					<div class="col-md-6"><input type="text" value="<?= ($facturaVenta!=NULL) ? $facturaVenta->fechaVencimiento :""; ?>" id="txtFechaVencimiento" name="txtFechaVencimiento" class="form-control"  placeholder="Fecha de vencimiento"></div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-md-1">
						<input type="button" value="Agregar Orden" id="btnAgregarOrden" class="btn-primary btn"></input>
					</div>
					<div class="col-md-11"></div>
				</div>
			</div>

			<div class="form-group">
				<div class="row">
					
					<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables" id="dtProductos">
						<thead>
							<tr>
								<th>IdOrden</th>
								<th>IdOrdenDetalle</th>
								<th>IdProd</th>
								<th>Nombre</th>
								<th>Cantidad</th>
								<th>PrecioUnit</th>
								<th>Precio</th>
								<th><input type="checkbox" data-group="chkOrdenTodos" id="chkSeltodos"></input></th>
								<th>Cantidad_hide</th>
							</tr>
						</thead>
						<tbody>
							<? if ($facturaDetalle != null) { 
								$indice=0;?>
								<? foreach ($facturaDetalle as $val){	?>	
									<tr class="odd gradeX">
										<td><?= $val->idOrdenPedido?></td>
										<td><?= $val->idOrdenPedidoDetalle?></td>
										<td><?= $val->idProducto?></td>
										<td><?= $val->producto_descripcion?></td>
										<td>
											<input type="text" size="2" onchange="calcularPrecio('<?=$indice?>');" name="txtCantidadProd<?=$indice?>" id="txtCantidadProd<?=$indice?>" required="required" class="form-control textoCorto" value="<?= $val->cantidad?>">
										</td>
										<td><?= $val->importeUnitario?></td>
										<td><?= $val->importeTotal?></td>
										<td>
											<input type="checkbox" data-group="chkOrden" onclick="calcularFactura();" class="checkSeleccionar" name="chkOrden" id="chkOrden-<?= $val->idOrdenPedido?>-<?= $val->idProducto?>" class="form-control" value="<?= $val->idOrdenPedido?>-<?= $val->idProducto?>">
										</td>
										<td><?= $val->cantidad?></td>
									</tr>
								<? $indice +=1;
								}?>
							<? } ?>
						</tbody>
					</table>
				
				</div>
			</div>

			<div class="form-group">
				<div class="row">
					<div class="col-md-1">
						<label class="control-label">Total Pendiente</label>
					</div>
					<div class="col-md-2">
						<input type="text" value="<?= ($facturaVenta!=NULL) ? 0 :""; ?>" name="txtTotalPendiente" id="txtTotalPendiente" class="form-control" required="required" placeholder="Precio Total">
					</div>
					<div class="col-md-1">
						<label class="control-label">Importe</label>
					</div>
					<div class="col-md-2">
						<input type="text" value="<?= ($facturaVenta!=NULL) ? $facturaVenta->importe :""; ?>" name="txtImporte" id="txtImporte" class="form-control" required="required" placeholder="Importe">
					</div>
					<div class="col-md-1">
						<label class="control-label">Iva</label>
					</div>
					<div class="col-md-2">
						<input type="text" value="<?= ($facturaVenta!=NULL) ? $facturaVenta->iva :""; ?>" name="txtIva" id="txtIva" class="form-control" required="required" placeholder="Iva">
					</div>
					<div class="col-md-1">
						<label class="control-label">Total</label>
					</div>
					<div class="col-md-2">
						<input type="text" value="<?= ($facturaVenta!=NULL) ? $facturaVenta->iva + $facturaVenta->importe :""; ?>" name="txtPagoTotal" id="txtPagoTotal" class="form-control" required="required" placeholder="Total">
					</div>
				</div>
			</div>
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-6 col-sm-offset-3">
						<div class="btn-toolbar">
							<!-- <button class="btn-primary btn">Submit</button> -->
							<input type="button" value="Aceptar" id="btnAceptar" class="btn-primary btn"></input>
							<input type="button" value="Imprimir" id="btnImprimir" class="btn-primary btn"></input>
							<input type="button" value="Cancel" id="btnCancelar" class="btn-default btn"></input>
						</div>
					</div>
				</div>
			</div>
		</div>

		<input type="hidden" value="<?= ($facturaVenta!=NULL) ? $facturaVenta->idFactura :""; ?>"  id="idFactura" name="idFactura"></input>
	</div>
</div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-productos">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Ordenes de Pedido</h4>
                </div>
                <div class="modal-body">
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables" id="dtProductosModal">
                        <thead>
                            <tr>
                                <th>IdOrden</th>
                                <th>NroOrden</th>
                                <th>Fecha</th>
                                <th>Importe</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                    <input type="hidden" id="idOrdenModal" name="idOrdenModal"></input>
                    <input type="hidden" id="nroOrdenModal" name="nroOrdenModal"></input>
                    <input type="hidden" id="fechaModal" name="fechaModal"></input>
                    <input type="hidden" id="importeModal" name="importeModal"></input>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input id="btnAgregar" type="button" class="btn btn-primary" value="Agregar"></input>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

<?php echo form_close(); ?>
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/bootbox/bootbox.min.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/jquery.dataTables.min.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/TableTools.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/jquery.tabletojson.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/dataTables.editor.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/dataTables.editor.bootstrap.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/dataTables.bootstrap.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/form-typeahead/typeahead.min.js'></script>
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/form-inputmask/jquery.inputmask.bundle.min.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/form-parsley/parsley.min.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/aexo-manager/views/jsFacturaVentaDetalle.js'></script> 

<script type="text/javascript">
var baseUrl= "<?= base_url() ?>";
<? if ($facturaVenta==NULL) {?> 
	var imprimirVisible = false;
<?}else {?>
	var imprimirVisible = true;
<?}?>
</script>


