<?php echo form_open( $actionDelForm, 'method="post" id="formBody" autocomplete="off" enctype="multipart/form-data"'); ?>
<div id="page-heading">
	<ul class="breadcrumb">
		<li><a href="index.htm">Produccion</a></li>
		<li class="active">Insumos</li>
	</ul>

	<h1>Arbol de Insumo</h1>
</div>
<div class="container">
	<div class="panel panel-midnightblue">
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-sky">
					<div class="panel-heading">
						<h4>Partes</h4>
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
            <div class="col-md-6">
                <div class="panel panel-sky">
                    <div class="panel-heading">
                        <h4>Parte padre: <span id="lblPartePadre"></span> </h4>
                    </div>
                    <div class="panel-body collapse in">
                        <div class="row">
                            <div class="panel-body collapse in">
                                <label class="col-sm-1 control-label">Parte</label>
                                <div class="col-sm-6">
                                    <input type="text" id="txtParte" name="txtParte" class="form-control autocomplete" autocomplete="off" ></input>
                                </div>
                                <label class="col-sm-2 control-label">Cantidad</label>
                                <div class="col-sm-2">
                                    <input type="text" id="txtCantidad" name="txtCantidad" class="form-control" ></input>
                                </div>
                                <input type="hidden" id="idParte" name="idParte"></input>
                            </div>
                        </div>
                        <div class="row">
							<div class="col-sm-12" style="text-align:right">
								<button id="btnAgregar" class="btn-primary btn">Agregar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			<input type="hidden" id="idInsumo" name="idInsumo"></input>
			<input type="hidden" id="idPartePadre" name="idPartePadre"></input>
		</div>
		<div class="row">
			<div class="panel-footer">
				<div class="row">
					<div class="pull-right">
						<div class="btn-toolbar">
							<input type="button" id="btnVolver" value="Volver" class="btn-primary btn"></input>
						</div>
					</div>
				</div>
			</div>
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
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/form-typeahead/typeahead.min.js'></script>
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/form-nestable/jquery.nestable.min.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/form-nestable/ui-nestable.js'></script> 

<script type='text/javascript'>

$( document ).ready(function() {

    $('#despiece').nestable({
        group: 1
    });
	

	$('#btnVolver').click(function() {
		$('#formBody').attr("action", "<?= base_url() ?>index.php/insumos/");
		$('#formBody').submit();
	});



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

});

// function detalleDespiece(idParte, idProducto) {
//     $("#idProducto").val(idProducto);
//     $("#idPartePadre").val(idParte);
//     //alert("hola");
//     $("#formBody").attr("action", "<?= base_url() ?>index.php/despiece/parte");
//     $("#formBody").submit();
// }
function detalleDespiece(idParte,idInsumo, descripcion) {
    $("#idInsumo").val(idInsumo);
    $("#idPartePadre").val(idParte);
	$("#lblPartePadre").html(descripcion);
    
    //alert("hola");

}
</script>