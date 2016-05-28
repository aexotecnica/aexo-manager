<?php echo form_open( $actionDelForm, 'method="post" id="formBody" autocomplete="off" enctype="multipart/form-data"'); ?>
<div id="page-heading">
	<ul class="breadcrumb">
		<li><a href="index.htm">Ventas</a></li>
		<li class="active">Listar Ordenes</li>
	</ul>

	<h1>Listar Ordenes Compra</h1>
</div>
<div class="container">
	<div class="panel panel-midnightblue">
		<div class="row">

			<div class="col-md-12">
				<div class="panel panel-sky">
					<div class="panel-heading">
						<h4>Ordenes de ccompra</h4>
						<div class="options">   
							<a href="javascript:;"><i class="fa fa-cog"></i></a>
							<a href="javascript:;"><i class="fa fa-wrench"></i></a>
							<a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
						</div>
					</div>
					<div class="panel-body collapse in">
						<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables" id="dtOrdenes">
							<thead>
								<tr>
									<th style="display:none">Id</th>
									<th>Nro</th>
									<th>Fecha Pedido</th>
									<th>Fecha Entrega</th>
									<th>Cliente</th>
								</tr>
							</thead>
							<tbody>
								<?
								if ($ordenes != NULL)
									foreach ($ordenes as $val){?>	
										<tr class="idOrdenCompra gradeX">
											<td style="display:none"><?= $val->idOrdenCompra?></td>
											<td><?= $val->nroPedido?></td>
											<td><?= $val->fechaPedido?></td>
											<td><?= $val->fechaEntrega?></td>
											<td><?= $val->proveedor_nombre?></td>
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
							<input type="button" id="btnImprimir" value="Imprimir" class="btn-primary btn"></input>
							<input type="button" id="btnNuevo" value="Nuevo" class="btn-primary btn"></input>
							<input type="button" id="btnModificar" value="Modificar" class="btn-primary btn"></input>
							<input type="button" id="btnEliminar" value="Eliminar" class="btn-primary btn"></input>
						</div>
					</div>
				</div>
			</div>
			<input type="hidden" id="idOrdenCompra" name="idOrdenCompra"></input>
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
		$('#formBody').attr("action", "<?= base_url() ?>index.php/ordenCompra/nuevo");
		$('#formBody').submit();
	});

	$("#btnImprimir").click(function () {
		if ($('#idOrdenCompra').val() != ''){
			$("#formBody").attr("action", "<?= base_url() ?>index.php/ordenCompra/reporteOrdenPedido/"+$('#idOrdenCompra').val());
			$("#formBody").submit();
		}
	});

	$("#btnModificar").click(function () {
		if ($('#idOrdenCompra').val() != ''){
			$("#formBody").attr("action", "<?= base_url() ?>index.php/ordenCompra/modificar");
			$("#formBody").submit();
		}else {
			bootbox.alert("Seleccione una Parte a modificar");
		}
	});

	$("#btnEliminar").click(function () {
		
		if ($('#idOrdenCompra').val() != ''){
			bootbox.confirm("Eliminará el comprobante seleccionado. ¿Está serguro?", function(result) {
				if (result == true) {
					
					$("#formBody").attr("action", "<?= base_url() ?>index.php/ordenCompra/eliminar");
					$("#formBody").submit();
				}
			});
		}else {
			bootbox.alert("Seleccione un Comprobante a Eliminar");
		} 
	});


	$('#dtOrdenes').dataTable({

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
    $('#dtOrdenes tbody').on( 'click', 'tr', function () {
        $("#idOrdenCompra").val($(this).children("td:eq(0)").text());
    } );

});
</script>