<?php echo form_open( $actionDelForm, 'method="post" id="formBody" autocomplete="off" enctype="multipart/form-data"'); ?>
<div id="page-heading">
	<ul class="breadcrumb">
		<li><a href="index.htm">Compras</a></li>
		<li class="active">Comprobantes</li>
	</ul>

	<h1>Listar pagos</h1>
</div>
<div class="container">
	<div class="panel panel-midnightblue">
		<div class="panel-heading">
			<h4>Filtros</h4>
			<div class="options">   
				<a class="panel-collapse" href="javascript:;"><i class="fa fa-chevron-down"></i></a>
			</div>
		</div>
		<div class="panel-body collapse in">
			<div class="form-group">
				<div class="row">
					<div class="col-md-4">
						<input type="text" name="txtFecha" id="txtFecha" value="<?=$fecha?>" class="form-control" placeholder="Fecha">
					</div>
					<div class="col-md-4">
						<select name="selTipoMovimiento" class="form-control"> 
							<option>Tipo de Medio</option>
							<?
							foreach ($tiposPagos as $val){?>	
								<option value='<?= $val->idTipoMedio?>'><?= $val->descripcion?></option>
							<?}?>
						</select>
					</div>
					<div class"col-md-4">
						<button class="btn-primary btn">Buscar</button>
					</div>
					
				</div>
			</div>
			
		</div>

		<div class="row">
			<? if ($pagos != NULL) { ?>
			<div class="col-md-12">
				<div class="panel panel-sky">
					<div class="panel-heading">
						<h4>pagos</h4>
						<div class="options">   
							<a href="javascript:;"><i class="fa fa-cog"></i></a>
							<a href="javascript:;"><i class="fa fa-wrench"></i></a>
							<a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
						</div>
					</div>
					<div class="panel-body collapse in">
						<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables" id="dtpagos">
							<thead>
								<tr>
									<th>Id</th>
									<th>Fecha</th>
									<th>Tipo Comprobante</th>
									<th>Nro Comprobante</th>
									<th>Cliente</th>
									<th>Descripcion</th>
									<th>Importe</th>
									<th>Movimiento</th>
								</tr>
							</thead>
							<tbody>
								<? foreach ($pagos as $val){	?>	
								<tr class="odd gradeX">
									<td><?= $val->idMedioPago?></td>
									<td><?= $val->fecha?></td>
									<td><?= ""?></td>
									<td><?= $val->nroComprobante?></td>
									<td><?= $val->nombreProveedor?></td>
									<td><?= $val->descripcion?></td>
									<td class="alignRight"><?= number_format(  $val->importeTotal, 2, ".", "," );?></td>
									<td>
										<? // if ($val->idMedioPagoMovimiento == NULL) { ?>
										<? if ($val->idEstadoPago == ESTADOPAGO_BORRADOR) { ?>
										<input type="button" id="btnMovimiento" value="Solicitar" onclick="solicitarAutorizacion(<?= $val->idMedioPago?>);" class="btn-inverse btn"></input>
										<? } ?>
										<? if ($val->idEstadoPago == ESTADOPAGO_PENDAUTORIZAR) { ?>
										<input type="button" id="btnMovimiento" value="Autorizar" onclick="autorizar(<?= $val->idMedioPago?>);" class="btn-inverse btn"></input>
										<? } ?>
										<? if ($val->idEstadoPago == ESTADOPAGO_AUTORIZADO) { ?>
										<input type="button" id="btnMovimiento" value="Pagar" onclick="pasarMovimiento(<?= $val->idMedioPago?>);" class="btn-inverse btn"></input>
										<? } ?>
										<? if ($val->idEstadoPago == ESTADOPAGO_PAGADO) { ?>
										<input type="button" id="btnMovimiento" value="Conciliar" onclick="conciliarPago(<?= $val->idMedioPago?>);" class="btn-inverse btn"></input>
										<? } ?>
										<?// } ?>
									</td>
								</tr>
								<?}?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<?}?>
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
			<input type="hidden" id="idMedioPago" name="idMedioPago"></input>
		</div>
	</div>
	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Conciliar Pago</h4>
				</div>
				<div class="modal-body">
					<input type="text" name="txtFechaConcilio" id="txtFechaConcilio" value="" class="form-control" placeholder="Fecha de Conciliacion">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
					<button id="btnAceptaConcilio" type="button" class="btn btn-primary">Aceptar</button>
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
<script type='text/javascript'>


function pasarMovimiento(idMedioPago){
	$('#idMedioPago').val(idMedioPago);

	if ($('#idMedioPago').val() != ''){
		$("#formBody").attr("action", "<?= base_url() ?>index.php/mediosDePago/crearMovimiento");
		$("#formBody").submit();
	}
}

function conciliarPago(idMedioPago){
	$('#idMedioPago').val(idMedioPago);
	$('#myModal').modal('show');
}

function solicitarAutorizacion(idMedioPago){
	$('#idMedioPago').val(idMedioPago);

	if ($('#idMedioPago').val() != ''){
		$("#formBody").attr("action", "<?= base_url() ?>index.php/mediosDePago/solicitarAutorizacion");
		$("#formBody").submit();
	}
}

function autorizar(idMedioPago){
	$('#idMedioPago').val(idMedioPago);

	if ($('#idMedioPago').val() != ''){
		$("#formBody").attr("action", "<?= base_url() ?>index.php/mediosDePago/autorizar");
		$("#formBody").submit();
	}
}

$( document ).ready(function() {

	$('#txtFecha').datepicker({format: 'dd/mm/yyyy', language: 'es'});
	$('#txtFechaConcilio').datepicker({format: 'dd/mm/yyyy', language: 'es'});
	

	$('#btnNuevo').click(function() {
		$('#formBody').attr("action", "<?= base_url() ?>index.php/mediosDePago/nuevo");
		$('#formBody').submit();
	});

	$("#btnModificar").click(function () {
		if ($('#idMedioPago').val() != ''){
			$("#formBody").attr("action", "<?= base_url() ?>index.php/mediosDePago/modificar");
			$("#formBody").submit();
		}else {
			bootbox.alert("Seleccione un Comprobante a modificar");
		}
	});

	$("#btnAceptaConcilio").click(function () {
		if ($('#idMedioPago').val() != ''){
			$("#formBody").attr("action", "<?= base_url() ?>index.php/mediosDePago/conciliar");
			$("#formBody").submit();
		}
	});



	$("#btnEliminar").click(function () {
		
		if ($('#idMedioPago').val() != ''){
			bootbox.confirm("Eliminará el comprobante seleccionado. ¿Está serguro?", function(result) {
				if (result == true) {
					
					$("#formBody").attr("action", "<?= base_url() ?>index.php/mediosDePago/eliminar");
					$("#formBody").submit();
				}
			});
		}else {
			bootbox.alert("Seleccione un Comprobante a Eliminar");
		} 
	});


	$('#dtpagos').dataTable({
		"sDom": "<'row'<'col-sm-6'T><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        //"sDom": "<'row'<'col-xs-6'l><'col-xs-6'f>r>t<'row'<'col-xs-6'i><'col-xs-6'p>>",
        "sPaginationType": "bootstrap",
        "oLanguage": {
        	"sLengthMenu": "_MENU_ records per page",
        	"sSearch": ""
        },
        //"sDom": "<'row'<'col-sm-12'T><'col-sm-12'f>r>t<'row'<'col-sm-12'i><'col-sm-12'p>>",
        "bServerSide": false,
        "bAutoWidth": false,
        "bDestroy": true,
        "oTableTools": {
        	"sRowSelect": "single",
			"sSwfPath": "<?= base_url() ?>assets/plugins/datatables-1-10-4/extensions/TableTools/swf/copy_csv_xls_pdf.swf",

        }
    });



	$('#dtpagos tbody').on( 'click', 'tr', function () {
		$("#idMedioPago").val($(this).children("td:eq(0)").text());
	} );


	$('.dataTables_filter input').addClass('form-control').attr('placeholder','Search...');
	$('.dataTables_length select').addClass('form-control');


});
</script>