<?php echo form_open( "stock/guardar", 'method="post" id="formBody" autocomplete="off" enctype="multipart/form-data"'); ?>
<div id="page-heading">
	<ul class="breadcrumb">
		<li><a href="index.htm">Dashboard</a></li>
		<li>Advanced Forms</li>
		<li class="active">Form Validation</li>
	</ul>

	<h1>Detalle de Stock</h1>
</div>
<div class="container">
	<div class="panel panel-midnightblue">
		<div class="panel-heading">
			<h4>Stock</h4>
			<div class="options">   
				<a class="panel-collapse" href="javascript:;"><i class="fa fa-chevron-down"></i></a>
			</div>
		</div>
		<div class="panel-body collapse in">
			<div class="form-group">
				<div class="row">
					<div class="col-md-6"><input type="text" value="<?= ($stockParte!=NULL) ? $stockParte->fechaIngreso :""; ?>" name="txtFechaIngreso" id="txtFechaIngreso" required="required" class="form-control" placeholder="Fecha"></div>
					<div class="col-md-6">
						<select name="selAlmacen" class="form-control"> 
							<option>Almacen</option>
							<?
							foreach ($almacenes as $val){
								if ($stockParte==NULL) 	{?>
									<option  value='<?= $val->idAlmacen?>'><?= $val->descripcion?></option>
								<?
								} else {
									?>
									<option  value='<?= $val->idAlmacen?>' <?=($stockParte->idAlmacen == $val->idAlmacen) ? "selected" :  "" ?>><?= $val->descripcion?></option>
									<?
								}
							}?>
						</select>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-md-6">
						<input type="text" value="<?= ($stockParte!=NULL) ? $stockParte->parte_detalle :""; ?>" id="txtParte" name="txtParte" class="form-control autocomplete" autocomplete="off" ></input>
						<input type="hidden" value="<?= ($stockParte!=NULL) ? $stockParte->idParte :""; ?>" id="idParte" name="idParte"></input>
					</div>
					<div class="col-md-6"><input type="text" value="<?= ($stockParte!=NULL) ? $stockParte->cantidad :""; ?>" id="txtCantidad" required="required" name="txtCantidad" class="form-control" placeholder="Cantidad"></div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-md-6">
						<select name="selEstadoParte" class="form-control"> 
							<option>Estado de Parte</option>
							<?
							foreach ($estados as $val){
								if ($stockParte==NULL) 	{?>
									<option  value='<?= $val->idEstadoParte?>'><?= $val->descripcion?></option>
								<?
								} else {
									?>
									<option  value='<?= $val->idEstadoParte?>' <?=($stockParte->idEstadoParte == $val->idEstadoParte) ? "selected" :  "" ?>><?= $val->descripcion?></option>
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
		<input type="hidden" value="<?= ($stockParte!=NULL) ? $stockParte->idStockParte :""; ?>"  id="idStockParte" name="idStockParte"></input>
	</div>
</div>
<?php echo form_close(); ?>

<script type='text/javascript' src='<?= base_url() ?>assets/plugins/form-inputmask/jquery.inputmask.bundle.min.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/form-typeahead/typeahead.min.js'></script>

<script type='text/javascript'>
// Calendar
// If screensize > 1200, render with m/w/d view, if not by default render with just title

$( document ).ready(function() {

	$('.mask').inputmask();
 	
    $("#txtParte").typeahead({
        source: function (query, process) {
            var partes = [];
            map = {};
            if (query.length > 3) {
            // This is going to make an HTTP post request to the controller
            	return $.post('<?= base_url() ?>index.php/despiece/jsonConsultarParte', { query: query }, function (data) {
                // Loop through and push to the array
                //alert(eval(data));
	                $.each(eval(data), function (i, parte) {
	                    map[parte.descripcion] = parte;
	                    partes.push(parte.descripcion);
	                });
	                // Process the details
	                process(partes);

	            });
        	}
    	},
	    updater: function (item) {
	        var selectedShortCode = map[item].idParte;
	        // Set the text to our selected id
	        $("#idParte").val(selectedShortCode);
	        return item;
	    }
	});

	$('#txtFechaIngreso').datepicker({format: 'dd/mm/yyyy', language: 'es', currentText: "Now"});
	$('#txtFechaIngreso').datepicker("setDate", new Date());


	$("#btnCancelar").click(function(){
		window.location.href = "<?= base_url() ?>index.php/mediosDePago";
	});

});
</script>