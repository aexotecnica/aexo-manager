<?php echo form_open( "IngresoMovimiento/guardar", 'method="post" id="formBody" autocomplete="off" enctype="multipart/form-data"'); ?>
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
					<div class="col-md-4"><input type="text" name="txtFechaPago" id="fechaPago" required="required" class="form-control" placeholder="Fecha"></div>
					<div class="col-md-4">
						<select name="selTipoMovimiento" class="form-control"> 
							<option>Tipo Movimiento</option>
							<?
							foreach ($tiposMovimiento as $val){?>	
							<option value='<?= $val->idTipoMovimiento?>'><?= $val->descripcion?></option>
							<?}?>
						</select>
					</div>
					<div class="col-md-4"><input type="text" name="txtImporte" class="form-control" required="required" placeholder="Importe" ></div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-md-4"><input type="text" id="txtNroOrden" name="txtNroOrden" class="form-control" placeholder="Nro de Orden"></div>
					<div class="col-md-8"><input type="text" id="txtDescripcion" required="required" name="txtDescripcion" class="form-control" placeholder="Descripcion"></div>
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

	$('#fechaPago').datepicker({format: 'dd/mm/yyyy', language: 'es'});

	
});
</script>