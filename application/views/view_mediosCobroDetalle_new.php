<?php echo form_open( "mediosDeCobro/guardar", 'method="post" id="formBody" autocomplete="off" enctype="multipart/form-data"'); ?>
<div id="page-heading">
	<ul class="breadcrumb">
		<li><a href="index.htm">Dashboard</a></li>
		<li>Advanced Forms</li>
		<li class="active">Form Validation</li>
	</ul>

	<h1>Ingresar Medio de cobro</h1>
</div>
<div class="container">
	<div class="panel panel-midnightblue">
		<div class="panel-heading">
			<h4>Comprobante Venta</h4>
			<div class="options">   
				<a class="panel-collapse" href="javascript:;"><i class="fa fa-chevron-down"></i></a>
			</div>
		</div>
		<div class="panel-body collapse in">
			<div class="form-group">
				<div class="row">
					<div class="col-md-6"><input type="text" value="<?= ($medioCobro!=NULL) ? $medioCobro->fecha :""; ?>" name="txtFecha" id="txtFecha" required="required" class="form-control" placeholder="Fecha"></div>
	
					<div class="col-md-6">
						<input type="hidden" value="<?= ($medioCobro!=NULL) ? $medioCobro->idCliente :""; ?>" name="txtIdCliente" id="txtIdCliente" required="required" class="form-control" placeholder="Id">
						<input type="text" value="<?= ($medioCobro!=NULL) ? $medioCobro->nombreCliente :""; ?>" name="txtCliente" id="txtCliente" required="required" class="form-control" required="required" placeholder="Cliente">
						<!-- <input type="text" value="<?= ($medioCobro!=NULL) ? $medioCobro->nombreCliente :""; ?>" id="txtCliente" name="txtCliente" class="form-control" placeholder="Cliente"> -->
					</div>
<!-- 					<div class="col-md-1">
						<a class="panel-collapse" href="javascript:;"><i class="fa fa-search"></i></a>
					</div> -->
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-md-6"><input type="text" value="<?= ($medioCobro!=NULL) ? $medioCobro->nroSerie :""; ?>" id="txtSerie" name="txtSerie" class="form-control" placeholder="Nro Serie"></div>
					<div class="col-md-6"><input type="text" value="<?= ($medioCobro!=NULL) ? $medioCobro->nroComprobante :""; ?>" id="txtNroComprobante" required="required" name="txtNroComprobante" class="form-control" placeholder="Nro comprobante"></div>
				</div>
			</div>

			<div class="form-group">
				<div class="row">
					<div class="col-md-6">
						<select name="selTipoComprobante" class="form-control" required="required"> 
							<option value="">Tipo Comprobante</option>
							<?
							foreach ($tiposcobros as $val){
								if ($medioCobro==NULL) 	{?>
									<option  value='<?= $val->idTipoMedio?>'><?= $val->descripcion?></option>
								<?
								} else {
									?>
									<option  value='<?= $val->idTipoMedio?>' <?=($medioCobro->idTipoMedio == $val->idTipoMedio) ? "selected" :  "" ?>><?= $val->descripcion?></option>
									<?
								}
							}?>
						</select>
					</div>
					<div class="col-md-6"><input type="text" value="<?= ($medioCobro!=NULL) ? $medioCobro->cuitCliente :""; ?>" id="txtCuit" required="required" name="txtCuit" class="form-control" placeholder="Cuit"></div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-md-12"><input type="text" value="<?= ($medioCobro!=NULL) ? $medioCobro->descripcion :""; ?>"  id="txtDescripcion" name="txtDescripcion" class="form-control" placeholder="Descripcion"></div>
				</div>
			</div>


			<div class="form-group">
				<div class="row">
					<div class="col-md-6"><input type="button" value="Facturas" id="btnFacturas" class="btn-primary btn"></input></div>
					<div class="col-md-6"></div>
				</div>
			</div>

			<div class="form-group">
				<div class="row">
					<div class="col-md-6">
						<input type="text" value="<?= ($medioCobro!=NULL) ? $medioCobro->importeSiva :""; ?>"  id="txtImporteSiva" name="txtImporteSiva" class="form-control mask" placeholder="Importe sin Iva">
						
					</div>
					<div class="col-md-6">
						<input type="text" value="<?= ($medioCobro!=NULL) ? $medioCobro->importeTotal :""; ?>"  id="txtImporte" required="required" name="txtImporte" class="form-control mask" placeholder="Importe Total"></div>
				</div>
			</div>

			<div class="form-group">
				<div class="row">
					
					<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables" id="dtFacturasPagar">
						<thead>
							<tr>
								<th>IdFactura</th>
								<th>NroFactura</th>
								<th>Fecha</th>
								<th>Fecha Venc.</th>
								<th>Iva</th>
								<th>Importe_Factura</th>
								<th>Importe_Pagar</th>
								<th>Importe_Pagar_Hide</th>
							</tr>
						</thead>
						<tbody>
							<? if ($facturasPagadas != null) { 
								$indice=0;?>
								<? foreach ($facturasPagadas as $val){	?>	
									<tr class="odd gradeX">
										<td><?= $val->idFactura?></td>
										<td><?= $val->nroFactura?></td>
										<td><?= $val->fechaFactura?></td>
										<td><?= $val->fechaVencimiento?></td>
										<td><?= $val->iva?></td>
										<td><?= $val->importe?></td>
										<td><input type="text" size="2" onchange="calcularImporte();" name="txtImportePagado<?=$indice?>" id="txtImportePagado<?=$indice?>" required="required" class="form-control textoImporte" value="<?= $val->importePagado?>"></td>
										<td><?= $val->importePagado?></td>
									</tr>
								<? $indice +=1;
								}?>
							<? } ?>
						</tbody>
					</table>
				
				</div>
			</div>

			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-6 col-sm-offset-3">
						<div class="btn-toolbar">
							<!-- <button class="btn-primary btn">Submit</button> -->
							<input type="button" value="Aceptar" id="btnAceptar" class="btn-primary btn"></input>
							<input type="button" value="Cancel" id="btnCancelar" class="btn-default btn"></input>
						</div>
					</div>
				</div>
			</div>
		</div>
		<input type="hidden" value="<?= ($medioCobro!=NULL) ? $medioCobro->idMedioCobro :""; ?>"   id="idMedioCobro" name="idMedioCobro"></input>
		<input type="hidden" value="" id="jsonFacturas" name="jsonFacturas"></input>
	</div>

	<!-- class="modal fade" id="myModal" -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-productos">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Facturas</h4>
                </div>
                <div class="modal-body">
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables" id="dtFacturas">
                        <thead>
                            <tr>
                                <th>IdFactura</th>
                                <th>Nro Factura</th>
                                <th>Fecha</th>
                                <th>Fecha Venc.</th>
                                <th>Iva</th>
                                <th>Importe</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                    <input type="hidden" id="idFactura" name="idFacturaModal"></input>
                    <input type="hidden" id="nroFacturaModal" name="nroFacturaModal"></input>
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
</div>
<?php echo form_close(); ?>

<script type='text/javascript' src='<?= base_url() ?>assets/plugins/form-parsley/parsley.min.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/form-inputmask/jquery.inputmask.bundle.min.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/form-typeahead/typeahead.min.js'></script>
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/bootbox/bootbox.min.js'></script> 

<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/jquery.dataTables.min.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/TableTools.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/jquery.tabletojson.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/dataTables.editor.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/dataTables.editor.bootstrap.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/dataTables.bootstrap.js'></script> 

<script type='text/javascript' src='<?= base_url() ?>assets/aexo-manager/views/jsMediosCobroDetalle.js'></script> 

<script type='text/javascript'>
var baseUrl= "<?= base_url() ?>";
</script>