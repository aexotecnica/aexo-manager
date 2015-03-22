<?php echo form_open( $actionDelForm, 'method="post" id="formBody" autocomplete="off" enctype="multipart/form-data"'); ?>
<div id="page-heading">
	<ul class="breadcrumb">
		<li><a href="index.htm">Produccion</a></li>
		<li class="active">Partes</li>
	</ul>

	<h1>Listar partes</h1>
</div>
<div class="container">
	<div class="panel panel-midnightblue">
		<div class="row">

			<div class="col-md-12">
				<div class="panel panel-sky">
					<div class="panel-heading">
						<h4>Partes</h4>
						<div class="options">   
							<a href="javascript:;"><i class="fa fa-cog"></i></a>
							<a href="javascript:;"><i class="fa fa-wrench"></i></a>
							<a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
						</div>
					</div>
					<div class="panel-body collapse in">
	                    <div class="panel-body collapse in">
	                        <div class="cf nestable-lists">
	                            <div id="despiece">
	                                <ul class="dd-list">
									    <?php echo $arbolString; ?>
	                                </ul>
	                            </div>
	                        </div>
	                    </div>
					</div>
				</div>
			</div>
			<div class="panel-footer">
				<div class="row">
					<div class="pull-right">
						<div class="btn-toolbar">
							<input type="button" id="btnVolver" value="Volver" class="btn-primary btn"></input>
						</div>
					</div>
				</div>
			</div>
			<input type="hidden" id="idPartePadre" name="idPartePadre"></input>
			<input type="hidden" id="idProducto" name="idProducto" value="<? $idProducto ?>"></input>
		</div>
	</div>
</div>
</div>

<?php echo form_close(); ?>

<script type='text/javascript' src='<?= base_url() ?>assets/plugins/bootbox/bootbox.min.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/jquery.dataTables.min.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/TableTools.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/dataTables.editor.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/dataTables.editor.bootstrap.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/dataTables.bootstrap.js'></script> 

<script type='text/javascript' src='<?= base_url() ?>assets/plugins/form-nestable/jquery.nestable.min.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/form-nestable/ui-nestable.js'></script> 

<script type='text/javascript'>

$( document ).ready(function() {

    $('#despiece').nestable({
        group: 1
    });
	

	$('#btnVolver').click(function() {
		$('#formBody').attr("action", "<?= base_url() ?>index.php/productos/");
		$('#formBody').submit();
	});

});

function detalleDespiece(idParte, idProducto) {
    $("#idProducto").val(idProducto);
    $("#idPartePadre").val(idParte);
    //alert("hola");
    $("#formBody").attr("action", "<?= base_url() ?>index.php/despiece/parte");
    $("#formBody").submit();
}
</script>