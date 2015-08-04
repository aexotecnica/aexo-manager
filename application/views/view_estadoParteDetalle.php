<?php echo form_open( "estadosPartes/guardar", 'method="post" id="formBody" autocomplete="off" enctype="multipart/form-data" class="form-horizontal row-border"'); ?>
<div id="page-heading">
	<ul class="breadcrumb">
		<li>Advanced Forms</li>
		<li class="active">Estado de Partes</li>
	</ul>

	<h1>Ingresar Estado de Parte</h1>
</div>
<div class="container">
	<div class="panel panel-midnightblue">
		<div class="panel-heading ">
			<h4>Estado de Parte</h4>
			<div class="options">   
				<a class="panel-collapse" href="javascript:;"><i class="fa fa-chevron-down"></i></a>
			</div>
		</div>
		<div class="panel-body collapse in">
			<div class="form-group">
				<div class="row">
					<label class="col-sm-3 control-label">Id</label>
					<div class="col-md-6">
						<input type="text" value="<?= ($estadoParte!=NULL) ? $estadoParte->idEstadoParte :""; ?>" name="txtIdEstadoParte" id="txtIdEstadoParte" disabled="disabled" class="form-control" placeholder="Id">
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<label class="col-sm-3 control-label">Descripcion</label>
					<div class="col-md-6">
						<input type="text" value="<?= ($estadoParte!=NULL) ? $estadoParte->descripcion:""; ?>" name="txtDescripcion" id="txtDescripcion" required="required" class="form-control" placeholder="Descripcion">
					</div>
				</div>
			</div>

			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-6 col-sm-offset-3">
						<div class="btn-toolbar">
							<input type="button" id="btnGuardar" class="btn-primary btn" value="Guardar"></input>
							<input type="button" value="Cancel" id="btnCancelar" class="btn-default btn"></input>
						</div>
					</div>
				</div>
			</div>
		</div>
		<input type="hidden" value="<?= ($estadoParte!=NULL) ? $estadoParte->idEstadoParte :""; ?>"  id="idEstadoParte" name="idEstadoParte"></input>
	</div>
</div>

<?php echo form_close(); ?>

<script type='text/javascript' src='<?= base_url() ?>assets/plugins/form-inputmask/jquery.inputmask.bundle.min.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/jquery.dataTables.min.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/form-parsley/parsley.min.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/jquery.tabletojson.js'></script>
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/TableTools.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/jquery.tabletojson.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/dataTables.editor.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/dataTables.editor.bootstrap.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/dataTables.bootstrap.js'></script> 
<script type="text/javascript">
var baseUrl= "<?= base_url() ?>";

$( document ).ready(function() {

	$("#btnCancelar").click(function(){
		window.location.href = baseUrl + "index.php/estadosPartes";
	});

    $("#btnGuardar").click(function () {
        $("#formBody").attr("action", baseUrl + "index.php/estadosPartes/guardar");
        $("#formBody").submit();
    });

});

</script>