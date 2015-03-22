<?php echo form_open( $actionDelForm, 'method="post" id="formBody" autocomplete="off" enctype="multipart/form-data"'); ?>
<div id="page-heading">
	<ul class="breadcrumb">
		<li><a href="#">Produccion</a></li>
		<li><a href="#">Despiece</a></li>
		<li class="active">Despiece de parte</li>
	</ul>

	<h1>Despiece de Parte</h1>
</div>
<div class="container">
	<div class="panel panel-midnightblue">
		<div class="row">

			<div class="col-md-12">
				<div class="panel panel-sky">
					<div class="panel-heading">
						<h4>Despiece de la parte: <? echo $partePadre->descripcion ?></h4>
	                    <div class="col-sm-2" style="text-align:right">
	                        <input type="button" id="btnInsumo" class="btn btn" value="Convertir en insumo" />
	                    </div>
						<div class="options">   
							<a href="javascript:;"><i class="fa fa-cog"></i></a>
							<a href="javascript:;"><i class="fa fa-wrench"></i></a>
							<a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
						</div>
					</div>
					<div class="panel-body collapse in">
	                    <div class="panel-body collapse in">
	                        <label class="col-sm-1 control-label">Parte</label>
                        <div class="col-sm-3">
                            <input type="text" id="txtParte" name="txtParte" class="form-control autocomplete" autocomplete="off" ></input>
                        </div>
                        <label class="col-sm-1 control-label">Cantidad</label>
                        <div class="col-sm-1">
                            <input type="text" id="txtCantidad" name="txtCantidad" class="form-control" ></input>
                        </div>
                        <div class="col-sm-6" style="text-align:right">
                            <button id="btnAgregar" class="btn-primary btn">Agregar</button>
                        </div>
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables DTTT_selectable" id="tblPartes">
                            <thead>
                                <tr>
                                    <th width="10%">IdParte</th>
                                    <th width="15%">Codigo</th>
                                    <th width="50%">Descripcion</th>
                                    <th width="10%">Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
								<?
								if ($hijos != NULL)
									foreach ($hijos as $val){?>	
										<tr class="gradeX">
											<td><?= $val->idParte?></td>
	                                        <td><?= $val->codigo?></td>
	                                        <td><?= $val->descripcion?></td>
	                                        <td><?= $val->cantidad?></td>
										</tr>
									<?}?>
                            </tbody>
                        </table>
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
			<input type="hidden" id="idProducto" name="idProducto" value="<?=$idProducto?>"></input>
			<input type="hidden" id="idPartePadre" name="idPartePadre" value="<?=$idPartePadre?>"></input>
			<input type="hidden" id="idParte" name="idParte" ></input>
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

<script type='text/javascript' src='<?= base_url() ?>assets/plugins/form-toggle/toggle.min.js'></script>
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/form-typeahead/typeahead.min.js'></script>

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

function detalleDespiece(idParte, idProducto) {
    $("#IdProducto").val(idProducto);
    $("#IdPartePadre").val(idParte);
    //alert("hola");
    $("#formBody").attr("action", "<?= base_url() ?>index.php/despiece/Parte");
    $("#formBody").submit();
}
</script>