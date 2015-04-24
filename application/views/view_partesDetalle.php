<?php echo form_open( "partes/guardar", 'method="post" id="formBody" autocomplete="off" enctype="multipart/form-data" class="form-horizontal row-border"'); ?>
<div id="page-heading">
	<ul class="breadcrumb">
		<li><a href="index.htm">Dashboard</a></li>
		<li>Advanced Forms</li>
		<li class="active">Form Validation</li>
	</ul>

	<h1>Ingresar Parte</h1>
</div>
<div class="container">
	<div class="panel panel-midnightblue">
		<div class="panel-heading ">
			<h4>Parte</h4>
			<div class="options">   
				<a class="panel-collapse" href="javascript:;"><i class="fa fa-chevron-down"></i></a>
			</div>
		</div>
		<div class="panel-body collapse in">
			<div class="form-group">
				<div class="row">
					<label class="col-sm-3 control-label">Codigo</label>
					<div class="col-md-6">
						<input type="text" value="<?= ($parte!=NULL) ? $parte->codigo :""; ?>" name="txtCodigo" id="txtCodigo" required="required" class="form-control" placeholder="Codigo">
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<label class="col-sm-3 control-label">Descripcion</label>
					<div class="col-md-6">
						<input type="text" value="<?= ($parte!=NULL) ? $parte->descripcion:""; ?>" name="txtDescripcion" id="txtDescripcion" required="required" class="form-control" placeholder="Descripcion">
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<label class="col-sm-3 control-label">Es parte final</label>
					<div class="col-md-6">
						<input type="checkbox" id="chkEsFinal" name="chkEsFinal" <?= ($parte!=NULL && $parte->esParteFinal) ? "checked='checked'" :""; ?> value="<?= ($parte!=NULL) ? $parte->idParte:""; ?>">
					</div>
				</div>
			</div>
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-6 col-sm-offset-3">
						<div class="btn-toolbar">
							<!-- <button class="btn-primary btn">Submit</button> -->
							<input type="button" value="Submit" id="btnSubmit" class="btn-primary btn"></input>
							<input type="button" value="Cancel" id="btnCancelar" class="btn-default btn"></input>
						</div>
					</div>
				</div>
			</div>
		</div>
		<input type="hidden" value="<?= ($parte!=NULL) ? $parte->idParte :""; ?>"  id="txtIdParte" name="txtIdParte"></input>
	</div>
</div>
<?php echo form_close(); ?>

<script type='text/javascript' src='<?= base_url() ?>assets/plugins/bootbox/bootbox.min.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/form-inputmask/jquery.inputmask.bundle.min.js'></script> 

<script type='text/javascript'>
// Calendar
// If screensize > 1200, render with m/w/d view, if not by default render with just title

$( document ).ready(function() {

	$('.mask').inputmask();

	$("#btnCancelar").click(function(){
		window.location.href = "<?= base_url() ?>index.php/partes";
	});
	$.ajaxSetup({ cache: false });
	$("#btnSubmit").click(function(){
	    if ($("#txtIdParte").val() == "") {
		    $.ajax({
		        method: "POST",
		        cache: false,
		        url: "<?= base_url() ?>index.php/partes/existeParte/"+ Math.random(),
		        async: false,
		        data: {codigo: $('#txtCodigo').val()},
		        success: function (existe) {
		            if (existe==0){
		            	$("#formBody").attr("action", "<?= base_url() ?>index.php/partes/guardar");
						$("#formBody").submit();
		            }else{
		            	bootbox.alert("El código de parte ya existe.");
		            }
		        }
		    });
	    }else{
	    	$("#formBody").attr("action", "<?= base_url() ?>index.php/partes/guardar");
			$("#formBody").submit();
	    }
	});
});
</script>