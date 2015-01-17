<?php echo form_open( "ingresoMovimiento/traerMovimientos", 'method="post" id="formBody" autocomplete="off" enctype="multipart/form-data"'); ?>
<div id="page-heading">
	<ul class="breadcrumb">
		<li><a href="index.htm">Dashboard</a></li>
		<li>Advanced Forms</li>
		<li class="active">Form Validation</li>
	</ul>

	<h1>Listar movimiento</h1>
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
						<input type="text" name="txtFechaPago" id="fechaPago" value="<?=($fechaPago != NULL) ? $fechaPago : "" ;?>" class="form-control" placeholder="Fecha">
					</div>
					<div class="col-md-4">
						<select name="selTipoMovimiento" class="form-control"> 
							<option>Tipo Movimiento</option>
							<?
							foreach ($tiposMovimiento as $val){?>	
							<option value='<?= $val->idTipoMovimiento?>'><?= $val->descripcion?></option>
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
			<div class="col-md-12">
				<div class="panel panel-sky">
					<div class="panel-heading">
						<h4>Data Tables</h4>
						<div class="options">   
							<a href="javascript:;"><i class="fa fa-cog"></i></a>
							<a href="javascript:;"><i class="fa fa-wrench"></i></a>
							<a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
						</div>
					</div>
					<div class="panel-body collapse in">
						<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables" id="dtMovimiento">
							<thead>
								<tr>
									<th>Descripcion</th>
									<th>Importe Ingreso</th>
									<th>Importe Egreso</th>
									<th>Comprobante</th>
								</tr>
							</thead>
							<tbody>
								<?
								if ($movimientos != NULL)
									foreach ($movimientos as $val){?>	
								<tr class="odd gradeX">
									<td><?= $val->descripcion?></td>
									<td><?= $val->importeIngreso?></td>
									<td><?= $val->importeEgreso?></td>
									<td>
										<? if ($val->importeEgreso != NULL && $val->idComprobanteVta != NULL) { ?>
										<input type="button" id="btnMovimiento" value="<?= $val->nroOrden?>" onclick="verComprobante(<?= $val->idComprobanteVta?>, <?= $val->idTipoMovimiento?>);" class="btn-inverse btn"></input>
										<? } ?>
										<? if ($val->importeEgreso != NULL && $val->idComprobanteCpr != NULL) { ?>
										<input type="button" id="btnMovimiento" value="<?= $val->nroOrden?>" onclick="verComprobante(<?= $val->idComprobanteCpr?>, <?= $val->idTipoMovimiento?>);" class="btn-inverse btn"></input>
										<? } ?>
									</td>
								</tr>
								<?}?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

</div>
</div>
<input type="hidden" id="idComprobante" name="idComprobante"></input>

<?php echo form_close(); ?>

<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/jquery.dataTables.min.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/TableTools.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/dataTables.editor.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/dataTables.editor.bootstrap.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/dataTables.bootstrap.js'></script> 

<script type='text/javascript'>


function verComprobante(idComprobante, idTipoMovimiento){
	$('#idComprobante').val(idComprobante);

	if ($('#idComprobante').val() != ''){
		if (idTipoMovimiento == 1){
			$("#formBody").attr("action", "<?= base_url() ?>index.php/comprobanteDeVenta/modificar/" + $('#idComprobante').val());
			$("#formBody").submit();	
		}
		if (idTipoMovimiento == 2){
			$("#formBody").attr("action", "<?= base_url() ?>index.php/comprobanteDeCompra/modificar/" + $('#idComprobante').val());
			$("#formBody").submit();	
		}
	} else {
		alert("a");
	}
}

$( document ).ready(function() {

	$('#fechaPago').datepicker({format: 'dd/mm/yyyy', language: 'es'});


	$('#dtMovimiento').dataTable({
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


});
</script>