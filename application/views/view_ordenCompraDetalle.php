<?php echo form_open( "ordenCompra/guardar", 'method="post" id="formBody" autocomplete="off" enctype="multipart/form-data"'); ?>
<div id="page-heading">
	<ul class="breadcrumb">
		<li><a href="index.htm">Dashboard</a></li>
		<li>Orden de Compra</li>
		<li class="active">Nueva</li>
	</ul>

	<h1>Ingresar Orden de Compra</h1>
</div>
<div class="container">
	<div class="panel panel-midnightblue">
		<div class="panel-heading">
			<h4>Orden de compra</h4>
			<div class="options">   
				<a class="panel-collapse" href="javascript:;"><i class="fa fa-chevron-down"></i></a>
			</div>
		</div>
		<div class="panel-body collapse in">
			<div class="form-group">
				<div class="row">
					<div class="col-md-6">
						<input type="text" value="<?= ($ordenCompra!=NULL) ? $ordenCompra->nroPedido :""; ?>" readonly="readonly" name="txtNroPedido" id="txtNroPedido" class="form-control" placeholder="Nro de Pedido">
					</div>
					<div class="col-md-6">
						<input type="text" value="<?= ($ordenCompra!=NULL) ? $ordenCompra->fechaPedido :""; ?>" name="txtFechaPedido" id="txtFechaPedido" required="required" class="form-control" placeholder="Fecha de Pedido" required="required">
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-md-6">
						<input type="hidden" value="<?= ($ordenCompra!=NULL) ? $ordenCompra->idProveedor :""; ?>" name="txtIdCliente" id="txtIdCliente" required="required" class="form-control" placeholder="Id">
						<input type="text" value="<?= ($ordenCompra!=NULL) ? $ordenCompra->proveedor_nombre :""; ?>" name="txtProveedorDescripcion" id="txtProveedorDescripcion" required="required" class="form-control" required="required" placeholder="Proveedor">
					</div>
					<div class="col-md-6"><input type="text" value="<?= ($ordenCompra!=NULL) ? $ordenCompra->fechaEntrega :""; ?>" id="txtFechaEntrega" name="txtFechaEntrega" class="form-control"  placeholder="Fecha de Entrega"></div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-md-6">
						<select name="selEstadoOrdenCompra" id="selEstadoOrdenCompra"  required="required" class="form-control"> 
							<option value="">Estado de Orden</option>

							<?
							foreach ($estadosOrdenCompra as $val){
								if ($ordenCompra==NULL) 	{?>
									<option  value='<?= $val->idEstadoOrdenPedido?>'><?= $val->descripcion?></option>
								<?
								} else {
									?>
									<option  value='<?= $val->idEstadoOrdenPedido?>' <?=($ordenCompra->idEstadoPedido == $val->idEstadoOrdenPedido) ? "selected" :  "" ?>><?= $val->descripcion?></option>
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
					
					<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables" id="dtPartes">
						<thead>
							<tr>
								<th>Id</th>
								<th>Nombre</th>
								<th>Cantidad</th>
								<th>Cant</th>
								<th>Estado</th>
								<th>EstadoHide</th>
								<th>Estado Anterior</th>
								<th>EstadoAnt</th>
							</tr>
						</thead>
						<tbody>
							<? if ($partes != null) { 
								$indice=0;?>
								<? foreach ($partes as $val){	?>	
									<tr class="odd gradeX">
										<td><?= $val->idProducto?></td>
										<td><?= $val->producto_descripcion?></td>
										<td><input type="text" size="2" value="<?= $val->cantidad?>" onchange="javascript:cambiaText(this);" name="txtRow<?=$indice?>" id="txtRow<?=$indice?>" required="required" class="form-control textoCorto cantidad"></td>
										<td><?= $val->cantidad?></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
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
						<input type="button" value="Agregar Parte" id="btnAgregarProducto" class="btn-primary btn"></input>
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
						<!-- <input type="text" value="<?= ($ordenCompra!=NULL) ? $ordenCompra->precioTotal :""; ?>" name="txtPrecioTotal" id="txtPrecioTotal" class="form-control" required="required" placeholder="Precio Total"> -->
					</div>
					<div class="col-md-1">
						<label class="control-label">Precio Total</label>
					</div>
					<div class="col-md-2">
						<input type="text" value="<?= ($ordenCompra!=NULL) ? $ordenCompra->precioTotal :""; ?>" name="txtPrecioTotal" id="txtPrecioTotal" class="form-control" required="required" placeholder="Precio Total">
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
		<div id="divPrueba"></div>
		<input type="hidden" value="<?= ($ordenCompra!=NULL) ? $ordenCompra->idOrdenPedido :""; ?>"  id="idOrdenPedido" name="idOrdenPedido"></input>
	</div>
</div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-productos">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Partes</h4>
                </div>
                <div class="modal-body">
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables" id="dtParteModal">
                        <thead>
                            <tr>
                                <th>idParte</th>
                                <th>descripcion</th>
                                <th>nombreHomologado</th>
                                <th>codigo</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                    <input type="hidden" id="idParteModal" name="idParteModal"></input>
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

    <script id="estadosTmpl" type="text/x-jQuery-tmpl">
    	<div>
		<select name="${idSelEstados}" id="${idSelEstados}" onchange="javascript:seleccionarEstado(this);" required="required" class="form-control"> 
			<option value="">Estado</option>
			{{each estados}}<option value="${idEstadoParte}">${descripcion}</option> {{/each}} 
		</select>
		</div>
    </script>   

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
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/jquery-tmpl/jquery.tmpl.min.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/aexo-manager/views/jsOrdenCompraDetalle.js'></script> 

<script type="text/javascript">
var baseUrl= "<?= base_url() ?>";
<? if ($ordenCompra==NULL) {?> 
	var imprimirVisible = false;
<?}else {?>
	var imprimirVisible = true;
<?}?>
</script>


