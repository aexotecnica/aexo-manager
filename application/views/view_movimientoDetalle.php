<?php echo form_open( "movimiento/guardar", 'method="post" id="formBody" autocomplete="off" enctype="multipart/form-data"'); ?>
<div id="page-heading">
	<ul class="breadcrumb">
		<li><a href="index.htm">Dashboard</a></li>
		<li>Advanced Forms</li>
		<li class="active">Form Validation</li>
	</ul>

	<h1>Ingresar movimiento</h1>
</div>
<div class="container">
	<div class="panel panel-midnightblue">
		<div class="panel-heading">
			<h4>Movimiento</h4>
			<div class="options">   
				<a class="panel-collapse" href="javascript:;"><i class="fa fa-chevron-down"></i></a>
			</div>
		</div>
		<div class="panel-body collapse in">
			<div class="form-group">
				<div class="row">
					<div class="col-md-4">
						<p class="help-block">Fecha pago</p>
						<input type="text" name="txtFechaPago" value="<?= ($movimiento!=NULL) ? $movimiento->fechaPago :""; ?>" id="fechaPago" required="required" class="form-control" placeholder="Fecha">
						
					</div>
					<div class="col-md-4">
						<p class="help-block">Tipo de movimiento</p>
						<select name="selTipoMovimiento" class="form-control"> 
							<option>Tipo Movimiento</option>
							<?
							foreach ($tiposMovimiento as $val){
								if ($movimiento==NULL) 	{?>
								<option  value='<?= $val->idTipoMovimiento?>'><?= $val->descripcion?></option>
								<?
							} else {
								?>
								<option  value='<?= $val->idTipoMovimiento?>' <?=($movimiento->idTipoMovimiento == $val->idTipoMovimiento) ? "selected" :  "" ?>><?= $val->descripcion?></option>
								<?
							}
						}
						?>
					</select>
				</div>
				<div class="col-md-4">
					<p class="help-block">Importe</p>
					<? if ($movimiento == NULL) {?>
					<input type="text" id="txtImporte" name="txtImporte" class="form-control mask" required="required" placeholder="Importe" >
					<?} else{ ?>
					<input type="text" id="txtImporte" name="txtImporte" class="form-control mask"value="<?=  ($movimiento->importeIngreso != NULL) ? $movimiento->importeIngreso :$movimiento->importeEgreso; ?>" class="form-control" required="required" placeholder="Importe" >
					<?}?>
					
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="row">
				<div class="col-md-4">
					<p class="help-block">Nro Comprobante</p>
					<input type="text" id="txtNroOrden" value="<?= ($movimiento!=NULL) ? $movimiento->nroOrden :""; ?>" name="txtNroOrden" class="form-control" placeholder="Nro Comprobante">
					
				</div>
				<div class="col-md-8">
					<p class="help-block">Descripcion</p>
					<input type="text" id="txtDescripcion" value="<?= ($movimiento!=NULL) ? $movimiento->descripcion :""; ?>" required="required" name="txtDescripcion" class="form-control" placeholder="Descripcion">
					
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="row">
				<div class="col-md-4">
					<? if ($movimiento!=NULL && $movimiento->idRepeticion != NULL) { ?>
						<p class="help-block">Cuotas restantes</p>
						<div class="input-group">
							<input type="text" id="txtNroCuota" value="<?= ($movimiento!=NULL) ? $movimiento->nroRepeticion - 1:""; ?>" name="txtNroCuota"  disabled="" placeholder="Cant. Repeticiones" class="form-control">
						</div>
					<?} else if ($movimiento == NULL) {?>
						<div class="input-group">
							<span class="input-group-addon">
								<input type="checkbox" id="chkRepeticion" name="chkRepeticion">
							</span>
							<input type="text" id="txtCantRepeticion" value="<?= ($movimiento!=NULL) ? $movimiento->nroRepeticion - 1:""; ?>" name="txtCantRepeticion"  disabled="" placeholder="Cant. Repeticiones" class="form-control">
						</div>
					<?}?>
				</div>
			</div>
		</div>
		<input type="hidden" id="idMovimiento" value="<?= ($movimiento!=NULL) ? $movimiento->idMovimiento :""; ?>"  name="idMovimiento"></input>
		<input type="hidden" id="idRepeticion" value="<?= ($movimiento!=NULL && $movimiento->idRepeticion != NULL) ? $movimiento->idRepeticion :""; ?>"  name="idRepeticion"></input>
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

</div>
</div>
<?php echo form_close(); ?>

<script type='text/javascript' src='<?= base_url() ?>assets/plugins/form-inputmask/jquery.inputmask.bundle.min.js'></script> 

<script type='text/javascript'>
// Calendar
// If screensize > 1200, render with m/w/d view, if not by default render with just title

$( document ).ready(function() {

	$('#txtImporte').inputmask('decimal', { radixPoint: ".", autoGroup: true, groupSeparator: ",", groupSize: 3 }); 

	$('#fechaPago').datepicker({format: 'dd/mm/yyyy', language: 'es'});

	$('#chkRepeticion').click(function(e) {
		if ($('#chkRepeticion').prop('checked'))
			$("#txtCantRepeticion").removeAttr("disabled");
		else{
			$("#txtCantRepeticion").val("");
			$("#txtCantRepeticion").attr("disabled","");
		}
	});

	$("#btnCancelar").click(function(){
		window.location.href = "<?= base_url() ?>index.php/movimiento/listarMovimientos";
	});
	
});
</script>