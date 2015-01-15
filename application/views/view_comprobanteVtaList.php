<?php echo form_open( "comprobanteDeVenta/traerComprobantes", 'method="post" id="formBody" autocomplete="off" enctype="multipart/form-data"'); ?>
<div id="page-heading">
	<ul class="breadcrumb">
		<li><a href="index.htm">Dashboard</a></li>
		<li>Advanced Forms</li>
		<li class="active">Form Validation</li>
	</ul>

	<h1>Listar comprobantes de venta</h1>
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
							<option>Tipo de Comprobante</option>
							<?
							foreach ($tiposComprobantes as $val){?>	
							<option value='<?= $val->idTipoComprobante?>'><?= $val->descripcion?></option>
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
			<? if ($comprobantes != NULL) { ?>
			<div class="col-md-12">
				<div class="panel panel-sky">
					<div class="panel-heading">
						<h4>Comprobantes</h4>
						<div class="options">   
							<a href="javascript:;"><i class="fa fa-cog"></i></a>
							<a href="javascript:;"><i class="fa fa-wrench"></i></a>
							<a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
						</div>
					</div>
					<div class="panel-body collapse in">
						<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables" id="dtComprobantes">
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
								<? foreach ($comprobantes as $val){	?>	
								<tr class="odd gradeX">
									<td><?= $val->idComprobanteVta?></td>
									<td><?= $val->fecha?></td>
									<td><?= ""?></td>
									<td><?= $val->nroComprobante?></td>
									<td><?= $val->nombreCliente?></td>
									<td><?= $val->descripcion?></td>
									<td><?= $val->importeTotal?></td>
									<td><input type="button" id="btnMovimiento" value="Pasar" onclick="pasarMovimiento(<?= $val->idComprobanteVta?>);" class="btn-inverse btn"></input></td>
								</tr>
								<?}?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<input type="hidden" id="idComprobanteVta" name="idComprobanteVta"></input>
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
		</div>
	</div>

</div>
</div>

<?php echo form_close(); ?>


<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/jquery.dataTables.min.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/TableTools.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/dataTables.editor.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/dataTables.editor.bootstrap.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/dataTables.bootstrap.js'></script> 
<script type='text/javascript'>


	function pasarMovimiento(idComprobanteVta){
		$('#idComprobanteVta').val(idComprobanteVta);
		 
		if ($('#idComprobanteVta').val() != ''){
			$("#formBody").attr("action", "<?= base_url() ?>index.php/comprobanteDeVenta/crearMovimiento");
			$("#formBody").submit();
		}
	}

$( document ).ready(function() {

	$('#txtFecha').datepicker({format: 'dd/mm/yyyy', language: 'es'});

	$('#btnNuevo').click(function() {
		$('#formBody').attr("action", "<?= base_url() ?>index.php/comprobanteDeVenta/nuevo");
		$('#formBody').submit();
	});

	$("#btnModificar").click(function () {
		if ($('#idComprobanteVta').val() != ''){
			$("#formBody").attr("action", "<?= base_url() ?>index.php/comprobanteDeVenta/modificar");
			$("#formBody").submit();
		}
	});



	$('#dtComprobantes').dataTable({
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
        	"aButtons": [

        	]

        }
    });

	$("#dtComprobantes tr").click(function () {
		$("#idComprobanteVta").val($(this).children("td:eq(0)").text());
	});


	$('.dataTables_filter input').addClass('form-control').attr('placeholder','Search...');
	$('.dataTables_length select').addClass('form-control');


});
</script>