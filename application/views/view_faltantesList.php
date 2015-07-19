<?php echo form_open( $actionDelForm, 'method="post" id="formBody" autocomplete="off" enctype="multipart/form-data"'); ?>
<div id="page-heading">
	<ul class="breadcrumb">
		<li><a href="index.htm">Produccion</a></li>
		<li class="active">Faltantes</li>
	</ul>

	<h1>Listar Faltantes</h1>
</div>
<div class="container">
	<div class="panel panel-midnightblue">
		<div class="row">

			<div class="col-md-12">
				<div class="panel panel-sky">
					<div class="panel-heading">
						<h4>Faltantes</h4>
						<div class="options">   
							<a href="javascript:;"><i class="fa fa-cog"></i></a>
							<a href="javascript:;"><i class="fa fa-wrench"></i></a>
							<a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
						</div>
					</div>
					<div class="panel-body collapse in">
						<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables" id="dtStock">
							<thead>
								<tr>
									<th>IdParte</th>
									<th>Descripcion</th>
									<th>Falantes</th>
								</tr>
							</thead>
							<tbody>
								<?
								if ($stock != NULL)
									foreach ($stock as $val){?>	
										<tr class="idStockPartes gradeX">
											<td><?= $val->idParte?></td>
											<td><?= $val->descripcion?></td>
											<td><?= $val->cantidadFaltante?></td>
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
							<!-- <input type="button" id="btnNuevo" value="Ingreso o Egreso" class="btn-primary btn"></input>
							<input type="button" id="btnModificar" value="Corregir Stock" class="btn-primary btn"></input> -->
						</div>
					</div>
				</div>
			</div>
			<input type="hidden" id="idStockPartes" name="idStockPartes"></input>
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
		$('#formBody').attr("action", "<?= base_url() ?>index.php/stock/nuevo");
		$('#formBody').submit();
	});


	$("#btnModificar").click(function () {
		if ($('#idStockPartes').val() != ''){
			$("#formBody").attr("action", "<?= base_url() ?>index.php/stock/modificar");
			$("#formBody").submit();
		}else {
			bootbox.alert("Seleccione una Parte a modificar");
		}
	});

	$('#dtStock').dataTable({

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
    $('#dtStock tbody').on( 'click', 'tr', function () {
        $("#idStockPartes").val($(this).children("td:eq(0)").text());
    } );

});
</script>