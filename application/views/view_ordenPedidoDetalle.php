<?php echo form_open( "ordenPedido/guardar", 'method="post" id="formBody" autocomplete="off" enctype="multipart/form-data"'); ?>
<div id="page-heading">
	<ul class="breadcrumb">
		<li><a href="index.htm">Dashboard</a></li>
		<li>Orden de Pedido</li>
		<li class="active">Nueva</li>
	</ul>

	<h1>Ingresar Orden de Pedido</h1>
</div>
<div class="container">
	<div class="panel panel-midnightblue">
		<div class="panel-heading">
			<h4>Orden de pedido</h4>
			<div class="options">   
				<a class="panel-collapse" href="javascript:;"><i class="fa fa-chevron-down"></i></a>
			</div>
		</div>
		<div class="panel-body collapse in">
			<div class="form-group">
				<div class="row">
					<div class="col-md-6">
						<input type="text" value="<?= ($ordenPedido!=NULL) ? $ordenPedido->nroPedido :""; ?>" readonly="readonly" name="txtNroPedido" id="txtNroPedido" class="form-control" placeholder="Nro de Pedido">
					</div>
					<div class="col-md-6">
						<input type="text" value="<?= ($ordenPedido!=NULL) ? $ordenPedido->fechaPedido :""; ?>" name="txtFechaPedido" id="txtFechaPedido" required="required" class="form-control" placeholder="Fecha de Pedido" required="required">
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-md-6">
						<input type="hidden" value="<?= ($ordenPedido!=NULL) ? $ordenPedido->idCliente :""; ?>" name="txtIdCliente" id="txtIdCliente" required="required" class="form-control" placeholder="Id">
						<input type="text" value="<?= ($ordenPedido!=NULL) ? $ordenPedido->cliente_nombre :""; ?>" name="txtClienteDescripcion" id="txtClienteDescripcion" required="required" class="form-control" required="required" placeholder="Cliente">
					</div>
					<div class="col-md-6"><input type="text" value="<?= ($ordenPedido!=NULL) ? $ordenPedido->fechaEntrega :""; ?>" id="txtFechaEntrega" name="txtFechaEntrega" class="form-control"  placeholder="Fecha de Entrega"></div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-md-6">
						<select name="selEstadoOrdenPedido" id="selEstadoOrdenPedido" class="form-control"> 
							<option>Estado de Orden</option>

							<?
							foreach ($estadosOrdenPedido as $val){
								if ($ordenPedido==NULL) 	{?>
									<option  value='<?= $val->idEstadoOrdenPedido?>'><?= $val->descripcion?></option>
								<?
								} else {
									?>
									<option  value='<?= $val->idEstadoOrdenPedido?>' <?=($ordenPedido->idEstadoPedido == $val->idEstadoOrdenPedido) ? "selected" :  "" ?>><?= $val->descripcion?></option>
									<?
								}
							}?>
						</select>
					</div>
					<div class="col-md-6"></div>
				</div>
			</div>

			<div class="form-group">
				<div class="row">
					
					<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables" id="dtProductos">
						<thead>
							<tr>
								<th>Id</th>
								<th>Nombre</th>
								<th>Cantidad</th>
								<th>Cant</th>

<!--							<th>Costo</th>
								<th>CostoUnitario</th>
								<th>Margen</th>
								<th>MargenHide</th> 
-->
								<th>Precio</th>
								<th>PrecioHide</th>
								<th>PrecioXCantHide</th>
							</tr>
						</thead>
						<tbody>
							<? if ($productos != null) { 
								$indice=0;?>
								<? foreach ($productos as $val){	?>	
									<tr class="odd gradeX">
										<td><?= $val->idProducto?></td>
										<td><?= $val->producto_descripcion?></td>
										<td><input type="text" size="2" value="<?= $val->cantidad?>" onchange="javascript:cambiaText(this);" name="txtRow<?=$indice?>" id="txtRow<?=$indice?>" required="required" class="form-control textoCorto cantidad"></td>
										<td><?= $val->cantidad?></td>
										<!-- 
										<td><?= $val->costo?></td>
										<td><?= $val->costoUnitario?></td>
										<td><input type="text" size="2" onchange="javascript:cambiaMargen(this);" name="txtMargenRow<?=$indice?>" id="txtMargenRow<?=$indice?>" required="required" class="form-control textoCorto" value="<?= $val->margen?>"></td>
										<td><?= $val->margen?></td> 
										-->
										<td><input type="text" size="2" value="<?= $val->precio?>"  name="txtPrecioRow<?=$indice?>" id="txtPrecioRow<?=$indice?>" required="required" class="form-control"></td>
										<td><?= $val->precioUnitario?></td>
										<td><?= $val->precio?></td>
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
						<input type="button" value="Agregar Producto" id="btnAgregarProducto" class="btn-primary btn"></input>
					</div>
					<div class="col-md-11"></div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-md-6">
						
					</div>
					<div class="col-md-1">
<!-- 						<label class="control-label">Precio Total</label> -->
					</div>
					<div class="col-md-2">
						<!-- <input type="text" value="<?= ($ordenPedido!=NULL) ? $ordenPedido->precioTotal :""; ?>" name="txtPrecioTotal" id="txtPrecioTotal" class="form-control" required="required" placeholder="Precio Total"> -->
					</div>
					<div class="col-md-1">
						<label class="control-label">Precio Total</label>
					</div>
					<div class="col-md-2">
						<input type="text" value="<?= ($ordenPedido!=NULL) ? $ordenPedido->precioTotal :""; ?>" name="txtPrecioTotal" id="txtPrecioTotal" class="form-control" required="required" placeholder="Precio Total">
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

		<input type="hidden" value="<?= ($ordenPedido!=NULL) ? $ordenPedido->idOrdenPedido :""; ?>"  id="idOrdenPedido" name="idOrdenPedido"></input>
	</div>
</div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-productos">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Productos</h4>
                </div>
                <div class="modal-body">
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables" id="dtProductosModal">
                        <thead>
                            <tr>
                                <th>idProducto</th>
                                <th>descripcion</th>
                                <th>codigo</th>
                                <th>costo</th>
                                <th>precio</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                    <input type="hidden" id="idProductoModal" name="idProductoModal"></input>
                    <input type="hidden" id="descripcionModal" name="descripcionModal"></input>
                    <input type="hidden" id="codigoModal" name="codigoModal"></input>
                    <input type="hidden" id="costoModal" name="costoModal"></input>
                    <input type="hidden" id="precioModal" name="precioModal"></input>
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
<script type='text/javascript' src='<?= base_url() ?>assets/aexo-manager/views/jsOrdenPedidoDetalle.js'></script> 

<script type="text/javascript">
var baseUrl= "<?= base_url() ?>";
<? if ($ordenPedido==NULL) {?> 
	var imprimirVisible = false;
<?}else {?>
	var imprimirVisible = true;
<?}?>
</script>


