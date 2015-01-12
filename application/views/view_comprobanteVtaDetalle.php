<?php echo form_open( "comprobanteDeVenta/guardar", 'method="post" id="formBody" autocomplete="off" enctype="multipart/form-data"'); ?>
<div id="page-heading">
	<ul class="breadcrumb">
		<li><a href="index.htm">Dashboard</a></li>
		<li>Advanced Forms</li>
		<li class="active">Form Validation</li>
	</ul>

	<h1>Ingresar comprobante de Venta</h1>
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
					<div class="col-md-6"><input type="text" name="txtFecha" id="txtFecha" required="required" class="form-control" placeholder="Fecha"></div>
					<div class="col-md-6">
						<select name="selTipoComprobante" class="form-control"> 
							<option>Tipo Comprobante</option>
							<?
							foreach ($tiposComprobantes as $val){?>	
							<option value='<?= $val->idTipoComprobante?>'><?= $val->descripcion?></option>
							<?}?>
						</select>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-md-6"><input type="text" id="txtSerie" name="txtSerie" class="form-control" placeholder="Nro Serie"></div>
					<div class="col-md-6"><input type="text" id="txtNroComprobante" required="required" name="txtNroComprobante" class="form-control" placeholder="Nro comprobante"></div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-md-6"><input type="text" id="txtCliente" name="txtCliente" class="form-control" placeholder="Cliente"></div>
					<div class="col-md-6"><input type="text" id="txtCuit" required="required" name="txtCuit" class="form-control" placeholder="Cuit"></div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-md-12"><input type="text" id="txtDescripcion" name="txtDescripcion" class="form-control" placeholder="Descripcion"></div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-md-6"><input type="text" id="txtImporteSiva" name="txtImporteSiva" class="form-control" placeholder="Importe sin Iva"></div>
					<div class="col-md-6"><input type="text" id="txtImporte" required="required" name="txtImporte" class="form-control" placeholder="Importe Total"></div>
				</div>
			</div>
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-6 col-sm-offset-3">
						<div class="btn-toolbar">
							<button class="btn-primary btn">Submit</button>
							<button class="btn-default btn">Cancel</button>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>
<?php echo form_close(); ?>


<script type='text/javascript'>
// Calendar
// If screensize > 1200, render with m/w/d view, if not by default render with just title

$( document ).ready(function() {

	$('#txtFecha').datepicker({format: 'dd/mm/yyyy', language: 'es'});


});
</script>