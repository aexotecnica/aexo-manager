<?php echo form_open( $actionDelForm, 'method="post" id="formBody" autocomplete="off" enctype="multipart/form-data"'); ?>
<div id="page-heading">
	<ul class="breadcrumb">
		<li><a href="index.htm">Produccion</a></li>
		<li class="active">clientes</li>
	</ul>

	<h1>Listar Clientes</h1>
</div>
<div class="container">
	<div class="panel panel-midnightblue">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-sky">
					<div class="panel-heading">
						<h4>Clientes</h4>
						<div class="options">   
							<a href="javascript:;"><i class="fa fa-cog"></i></a>
							<a href="javascript:;"><i class="fa fa-wrench"></i></a>
							<a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
						</div>
					</div>
					<div class="panel-body collapse in">
						<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables" id="dtclientes">
							<thead>
								<tr>
									<th>idCliente</th>
									<th>Nombre</th>
									<th>Responsable</th>
								</tr>
							</thead>
							<tbody>
								<? foreach ($clientes as $val){	?>	
									<tr class="odd gradeX">
										<td><?= $val->idCliente?></td>
										<td><?= $val->nombre?></td>
										<td><?= $val->responsable?></td>
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
							<input type="button" id="btnEliminar" value="Eliminar" class="btn-primary btn"></input>
						</div>
					</div>
				</div>
			</div>
			<input type="hidden" id="idCliente" name="idCliente"></input>
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
		$('#formBody').attr("action", "<?= base_url() ?>index.php/clientes/nuevo");
		$('#formBody').submit();
	});

	$("#btnModificar").click(function () {
		if ($('#idCliente').val() != ''){
			$("#formBody").attr("action", "<?= base_url() ?>index.php/clientes/modificar");
			$("#formBody").submit();
		}else {
			bootbox.alert("Seleccione una cliente a modificar");
		}
	});


	$("#btnEliminar").click(function () {
		
		if ($('#idCliente').val() != ''){
			bootbox.confirm("Eliminará el comprobante seleccionado. ¿Está serguro?", function(result) {
				if (result == true) {
					
					$("#formBody").attr("action", "<?= base_url() ?>index.php/clientes/eliminar");
					$("#formBody").submit();
				}
			});
		}else {
			bootbox.alert("Seleccione un cliente a Eliminar");
		} 
	});


	$('#dtclientes').dataTable({
		"sDom": "<'row'<'col-sm-6'T><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",		
        "sPaginationType": "bootstrap",
        "oLanguage": {
        	"sLengthMenu": "_MENU_ records per page",
        },
        "bProcessing": true,
        "bServerSide": false,
        "bAutoWidth": false,
        "oTableTools": {
        	"sRowSelect": "single",
			"sSwfPath": "<?= base_url() ?>assets/plugins/datatables-1-10-4/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
        }
    });


	$('#dtclientes tbody').on( 'click', 'tr', function () {
		$("#idCliente").val($(this).children("td:eq(0)").text());
	} );

	$('.dataTables_filter input').addClass('form-control').attr('placeholder','Search...');
	$('.dataTables_length select').addClass('form-control');

});
</script>