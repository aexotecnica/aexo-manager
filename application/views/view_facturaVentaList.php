<?php echo form_open( $actionDelForm, 'method="post" id="formBody" autocomplete="off" enctype="multipart/form-data"'); ?>
<div id="page-heading">
	<ul class="breadcrumb">
		<li><a href="index.htm">Venta</a></li>
		<li class="active">Facturas</li>
	</ul>

	<h1>Listar de Facturas</h1>
</div>
<div class="container">
	<div class="panel panel-midnightblue">
		<div class="row">

			<div class="col-md-12">
				<div class="panel panel-sky">
					<div class="panel-heading">
						<h4>Facturas</h4>
						<div class="options">   
							<a href="javascript:;"><i class="fa fa-cog"></i></a>
							<a href="javascript:;"><i class="fa fa-wrench"></i></a>
							<a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
						</div>
					</div>
					<div class="panel-body collapse in">
						<div class="form-group">
							<div class="row">
								<div class="col-md-4">
									<select name="selEstadoFactura" class="form-control"> 
										<option>Estado de factura</option>
										<?
										foreach ($estadosFactura as $val){?>	
										<option value='<?= $val->idEstadoFactura?>'><?= $val->descripcion?></option>
										<?}?>
									</select>
								</div>
								<div class"col-md-4">
									<button class="btn-primary btn">Buscar</button>
								</div>
								
							</div>
						</div>
						
					</div>
					<div class="panel-body collapse in">
						<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables" id="dtfacturas">
							<thead>
								<tr>
									<th style="display:none">Id</th>
									<th>Nro</th>
									<th>Fecha Factura</th>
									<th>Fecha Vencimiento</th>
									<th>Cliente</th>
									<th>Importe</th>
									<th>Estado</th>
								</tr>
							</thead>
							<tbody>
								<?
								if ($facturas != NULL)
									foreach ($facturas as $val){?>	
										<tr class="idFactura gradeX">
											<td style="display:none"><?= $val->idFactura?></td>
											<td><?= $val->nroFactura?></td>
											<td><?= $val->fechaFactura?></td>
											<td><?= $val->fechaVencimiento?></td>
											<td><?= $val->cliente_nombre?></td>
											<td><?= $val->importe?></td>
											<td><?= $val->descripcionEstado?></td>
										</tr>
									<?}?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="panel-footer">
				<div class="row">
					<div class="pull-left">
						<input type="button" id="btnEntregar" value="Entregar" class="btn-primary btn"></input>
					</div>
					<div class="pull-right">
						<div class="btn-toolbar">
							<!--<input type="button" id="btnImprimir" value="Imprimir" class="btn-primary btn"></input>-->
							<input type="button" id="btnNuevo" value="Nuevo" class="btn-primary btn"></input>
							<input type="button" id="btnModificar" value="Modificar" class="btn-primary btn"></input>
							<!--<input type="button" id="btnEliminar" value="Eliminar" class="btn-primary btn"></input>-->
						</div>
					</div>
				</div>
			</div>
			<input type="hidden" id="idFactura" name="idFactura"></input>
			<input type="hidden" id="idEstadoEntregado" name="idEstadoEntregado" value="3"></input>
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
		$('#formBody').attr("action", "<?= base_url() ?>index.php/facturaventa/nuevo");
		$('#formBody').submit();
	});

	$("#btnImprimir").click(function () {
		if ($('#idFactura').val() != ''){
			$("#formBody").attr("action", "<?= base_url() ?>index.php/facturaventa/reporteOrdenPedido/"+$('#idFactura').val());
			$("#formBody").submit();
		}
	});

	$("#btnModificar").click(function () {
		if ($('#idFactura').val() != ''){
			$("#formBody").attr("action", "<?= base_url() ?>index.php/facturaventa/modificar");
			$("#formBody").submit();
		}else {
			bootbox.alert("Seleccione una factura a modificar");
		}
	});

	$("#btnEntregar").click(function () {
		if ($('#idFactura').val() != ''){
			$("#formBody").attr("action", "<?= base_url() ?>index.php/facturaventa/cambiarEstado");
			$("#formBody").submit();
		}else {
			bootbox.alert("Seleccione una factura para entregar");
		}
	});

	$("#btnEliminar").click(function () {
		
		if ($('#idFactura').val() != ''){
			bootbox.confirm("Eliminará el comprobante seleccionado. ¿Está serguro?", function(result) {
				if (result == true) {
					
					//$("#formBody").attr("action", "<?= base_url() ?>index.php/ordenpedido/eliminar");
					$("#formBody").submit();
				}
			});
		}else {
			bootbox.alert("Seleccione un Comprobante a Eliminar");
		} 
	});


	$('#dtfacturas').dataTable({

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
    $('#dtfacturas tbody').on( 'click', 'tr', function () {
        $("#idFactura").val($(this).children("td:eq(0)").text());
    } );

});
</script>