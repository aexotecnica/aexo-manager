<?php echo form_open( $actionDelForm, 'method="post" id="formBody" autocomplete="off" enctype="multipart/form-data"'); ?>
<div id="page-heading">
	<ul class="breadcrumb">
		<li><a href="index.htm">Produccion</a></li>
		<li class="active">despiece</li>
	</ul>

	<h1>Listar despiece</h1>
</div>
<div class="container">
	<div class="panel panel-midnightblue">
		<div class="row">

			<div class="col-md-12">
				<div class="panel panel-sky">
					<div class="panel-heading">
						<h4>despiece</h4>
						<div class="options">   
							<a href="javascript:;"><i class="fa fa-cog"></i></a>
							<a href="javascript:;"><i class="fa fa-wrench"></i></a>
							<a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
						</div>
					</div>
					<div class="panel-body collapse in">
						<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables" id="dtProducto">
							<thead>
								<tr>
									<th>idProducto</th>
									<th>Descripcion</th>
									<th>Codigo</th>
								</tr>
							</thead>
							<tbody>
								<?
								if ($productos != NULL)
									foreach ($productos as $val){?>	
										<tr class="idProducto gradeX">
											<td><?= $val->idProducto?></td>
											<td><?= $val->descripcion?></td>
											<td><?= $val->codigo?></td>
										</tr>
									<?}?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="panel-footer">
				<div class="row">
					<div class="pull-right">
						<div class="btn-toolbar">
							<input type="button" id="btnNuevo" value="Nuevo" class="btn-primary btn"></input>
							<input type="button" id="btnModificar" value="Modificar" class="btn-primary btn"></input>
							<input type="button" id="btnDespiece" value="Despiece" class="btn-primary btn"></input>
							<input type="button" id="btnEliminar" value="Eliminar" class="btn-primary btn"></input>
						</div>
					</div>
				</div>
			</div>
			<input type="hidden" id="idProducto" name="idProducto"></input>
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
<script type='text/javascript'>

$( document ).ready(function() {
	

	$('#btnNuevo').click(function() {
		$('#formBody').attr("action", "<?= base_url() ?>index.php/productos/nuevo");
		$('#formBody').submit();
	});

	$("#btnModificar").click(function () {
		if ($('#idProducto').val() != ''){
			$("#formBody").attr("action", "<?= base_url() ?>index.php/productos/modificar");
			$("#formBody").submit();
		}else {
			bootbox.alert("Seleccione una Parte a modificar");
		}
	});

	$("#btnDespiece").click(function () {
		if ($('#idProducto').val() != ''){
			$("#formBody").attr("action", "<?= base_url() ?>index.php/despiece/ver");
			$("#formBody").submit();
		}else {
			bootbox.alert("Seleccione un producto a modificar");
		}
	});	


	$("#btnEliminar").click(function () {
		
		if ($('#idProducto').val() != ''){
			bootbox.confirm("Eliminará el comprobante seleccionado. ¿Está serguro?", function(result) {
				if (result == true) {
					
					$("#formBody").attr("action", "<?= base_url() ?>index.php/productos/eliminar");
					$("#formBody").submit();
				}
			});
		}else {
			bootbox.alert("Seleccione un Comprobante a Eliminar");
		} 
	});


	$('#dtProducto').dataTable({

		"sDom": "<'row'<'col-sm-6'T><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        "bProcessing": false,
        "bServerSide": false,
        "bAutoWidth": false,

        "sPaginationType": "bootstrap",
        "oTableTools": {
        	"sRowSelect": "single",
			"sSwfPath": "<?= base_url() ?>assets/plugins/datatables-1-10-4/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
        }
    });
    $('#dtProducto tbody').on( 'click', 'tr', function () {
        $("#idProducto").val($(this).children("td:eq(0)").text());
    } );

});
</script>