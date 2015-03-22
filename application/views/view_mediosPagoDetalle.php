<?php echo form_open( "mediosDePago/guardar", 'method="post" id="formBody" autocomplete="off" enctype="multipart/form-data"'); ?>
<div id="page-heading">
	<ul class="breadcrumb">
		<li><a href="index.htm">Dashboard</a></li>
		<li>Advanced Forms</li>
		<li class="active">Form Validation</li>
	</ul>

	<h1>Ingresar comprobante de Compra</h1>
</div>
<div class="container">
	<div class="panel panel-midnightblue">
		<div class="panel-heading">
			<h4>Comprobante Compra</h4>
			<div class="options">   
				<a class="panel-collapse" href="javascript:;"><i class="fa fa-chevron-down"></i></a>
			</div>
		</div>
		<div class="panel-body collapse in">
			<div class="form-group">
				<div class="row">
					<div class="col-md-6"><input type="text" value="<?= ($comprobanteCpr!=NULL) ? $comprobanteCpr->fecha :""; ?>" name="txtFecha" id="txtFecha" required="required" class="form-control" placeholder="Fecha"></div>
					<div class="col-md-6">
						<select name="selTipoComprobante" class="form-control"> 
							<option>Tipo Comprobante</option>

							<?
							foreach ($tiposPagos as $val){
								if ($comprobanteCpr==NULL) 	{?>
									<option  value='<?= $val->idTipoMedio?>'><?= $val->descripcion?></option>
								<?
								} else {
									?>
									<option  value='<?= $val->idTipoMedio?>' <?=($comprobanteCpr->idTipoMedio == $val->idTipoMedio) ? "selected" :  "" ?>><?= $val->descripcion?></option>
									<?
								}
							}?>
						</select>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-md-6"><input type="text" value="<?= ($comprobanteCpr!=NULL) ? $comprobanteCpr->nroSerie :""; ?>" id="txtSerie" name="txtSerie" class="form-control" placeholder="Nro Serie"></div>
					<div class="col-md-6"><input type="text" value="<?= ($comprobanteCpr!=NULL) ? $comprobanteCpr->nroComprobante :""; ?>" id="txtNroComprobante" required="required" name="txtNroComprobante" class="form-control" placeholder="Nro comprobante"></div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-md-6"><input type="text" value="<?= ($comprobanteCpr!=NULL) ? $comprobanteCpr->nombreProveedor :""; ?>" id="txtProveedor" name="txtProveedor" class="form-control" placeholder="Proveedor"></div>
					<div class="col-md-6"><input type="text" value="<?= ($comprobanteCpr!=NULL) ? $comprobanteCpr->cuitProveedor :""; ?>" id="txtCuit" required="required" name="txtCuit" class="form-control" placeholder="Cuit"></div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-md-12"><input type="text" value="<?= ($comprobanteCpr!=NULL) ? $comprobanteCpr->descripcion :""; ?>"  id="txtDescripcion" name="txtDescripcion" class="form-control" placeholder="Descripcion"></div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-md-6"><input type="text" value="<?= ($comprobanteCpr!=NULL) ? $comprobanteCpr->importeSiva :""; ?>"  id="txtImporteSiva" name="txtImporteSiva" class="form-control" placeholder="Importe sin Iva"></div>
					<div class="col-md-6"><input type="text" value="<?= ($comprobanteCpr!=NULL) ? $comprobanteCpr->importeTotal :""; ?>"  id="txtImporte" required="required" name="txtImporte" class="form-control mask" placeholder="Importe Total"></div>
				</div>
			</div>
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-6 col-sm-offset-3">
						<div class="btn-toolbar">
							<button class="btn-primary btn">Submit</button>
							<input type="button" value="Cancel" id="btnCancelar" class="btn-default btn"></input>
						</div>
					</div>
				</div>
			</div>
		</div>
		<input type="hidden" value="<?= ($comprobanteCpr!=NULL) ? $comprobanteCpr->idMedioPago :""; ?>"  id="idMedioPago" name="idMedioPago"></input>
	</div>
</div>
<?php echo form_close(); ?>

<script type='text/javascript' src='<?= base_url() ?>assets/plugins/form-inputmask/jquery.inputmask.bundle.min.js'></script> 

<script type='text/javascript'>
// Calendar
// If screensize > 1200, render with m/w/d view, if not by default render with just title

$( document ).ready(function() {

	$('.mask').inputmask();
 	
 	$('#txtImporteSiva').inputmask('decimal', { radixPoint: ".", autoGroup: true, groupSeparator: ",", groupSize: 3 }); 
 	$('#txtImporte').inputmask('decimal', { radixPoint: ".", autoGroup: true, groupSeparator: ",", groupSize: 3 }); 
	$('#txtFecha').datepicker({format: 'dd/mm/yyyy', language: 'es'});
	$("#btnCancelar").click(function(){
		window.location.href = "<?= base_url() ?>index.php/mediosDePago";
	});

});
</script>