<?php echo form_open( "productos/guardar", 'method="post" id="formBody" autocomplete="off" enctype="multipart/form-data" class="form-horizontal row-border"'); ?>
<div id="page-heading">
	<ul class="breadcrumb">
		<li><a href="index.htm">Dashboard</a></li>
		<li>Advanced Forms</li>
		<li class="active">Form Validation</li>
	</ul>

	<h1>Ingresar Producto</h1>
</div>
<div class="container">
	<div class="panel panel-midnightblue">
		<div class="panel-heading ">
			<h4>Producto</h4>
			<div class="options">   
				<a class="panel-collapse" href="javascript:;"><i class="fa fa-chevron-down"></i></a>
			</div>
		</div>
		<div class="panel-body collapse in">
			<div class="form-group">
				<div class="row">
					<label class="col-sm-3 control-label">Codigo</label>
					<div class="col-md-6">
						<input type="text" value="<?= ($producto!=NULL) ? $producto->codigo :""; ?>" name="txtCodigo" id="txtCodigo" required="required" class="form-control" placeholder="Codigo">
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<label class="col-sm-3 control-label">Descripcion</label>
					<div class="col-md-6">
						<input type="text" value="<?= ($producto!=NULL) ? $producto->descripcion:""; ?>" name="txtDescripcion" id="txtDescripcion" required="required" class="form-control" placeholder="Descripcion">
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<label class="col-sm-3 control-label">Parte Final</label>
					<div class="col-md-6">
						<select name="selParteFinal" class="form-control"> 
							<option>Partes</option>
							<?
							foreach ($partes as $val){
								if ($producto==NULL) 	{?>
									<option  value='<?= $val->idParte?>'><?= $val->descripcion?></option>
								<?
								} else {
									?>
									<option  value='<?= $val->idParte?>' <?=($producto->idParteFinal == $val->idParte) ? "selected" :  "" ?>><?= $val->descripcion?></option>
									<?
								}
							}?>
						</select>
					</div>
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
		<input type="hidden" value="<?= ($producto!=NULL) ? $producto->idProducto :""; ?>"  id="txtIdProducto" name="txtIdProducto"></input>
	</div>
</div>
<?php echo form_close(); ?>

<script type='text/javascript' src='<?= base_url() ?>assets/plugins/form-inputmask/jquery.inputmask.bundle.min.js'></script> 

<script type='text/javascript'>
// Calendar
// If screensize > 1200, render with m/w/d view, if not by default render with just title

$( document ).ready(function() {

	$('.mask').inputmask();

	$("#btnCancelar").click(function(){
		window.location.href = "<?= base_url() ?>index.php/productos";
	});

});
</script>