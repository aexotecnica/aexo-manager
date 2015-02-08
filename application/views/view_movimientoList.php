<?php echo form_open( "movimiento/traerMovimientos", 'method="post" id="formBody" autocomplete="off" enctype="multipart/form-data"'); ?>
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
					<div class="col-md-2">
						<div class="input-group">
							<div class="input-group-btn">
								<button class="btn btn-default" id="btnDiaAnterior" type="button"><i class="fa fa-arrow-circle-left"></i></button>
							</div>
							<input type="text" name="txtFechaDesde" id="fechaDesde" value="<?=($fechaDesde != NULL) ? $fechaDesde : "" ;?>" class="form-control" placeholder="Fecha Desde">

						</div>
					</div>
					<div class="col-md-2">
						<div class="input-group">
							<input type="text" name="txtFechaHasta" id="fechaHasta" value="<?=($fechaHasta != NULL) ? $fechaHasta : "" ;?>" class="form-control" placeholder="Fecha Hasta">
							<div class="input-group-btn">
								<button class="btn btn-default" id='btnDiaProximo' type="button"><i class="fa fa-arrow-circle-right"></i></button>
							</div>
						</div>
						
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
									<th>Id</th>
									<th>Fecha</th>
									<th>Conciliado</th>
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
									<td><?= $val->idMovimiento?></td>
									<td><?= $val->fechaPago?></td>
									<td><?= ($val->esConciliado) ? '<span class="label label-success">Si</span>' : '<span class="label label-warning">No</span>';?></td>
									<td><?= $val->descripcion?></td>
									<td class="alignRight"><?= number_format(  $val->importeIngreso, 2, ".", "," );?></td>
									<td class="alignRight"><?= number_format(  $val->importeEgreso, 2, ".", "," );?></td>
									<td>
										<? if ($val->importeIngreso != NULL && $val->idMedioCobro != NULL) {?>
										<input type="button" id="btnMovimiento" value="<?= $val->nroOrden?>" onclick="verComprobante(<?= $val->idMedioCobro?>, <?= $val->idTipoMovimiento?>);" class="btn-inverse btn"></input>
										<? } ?>
										<? if ($val->importeEgreso != NULL && $val->idMedioPago != NULL) { ?>
										<input type="button" id="btnMovimiento" value="<?= $val->nroOrden?>" onclick="verComprobante(<?= $val->idMedioPago?>, <?= $val->idTipoMovimiento?>);" class="btn-inverse btn"></input>
										<? } ?>
									</td>
								</tr>
								<?}?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<input type="hidden" id="idMovimiento" name="idMovimiento"></input>
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
</div>
<input type="hidden" id="idComprobante" name="idComprobante"></input>

<?php echo form_close(); ?>
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/bootbox/bootbox.min.js'></script> 
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
			$("#formBody").attr("action", "<?= base_url() ?>index.php/mediosDeCobro/modificar/" + $('#idComprobante').val());
			$("#formBody").submit();	
		}
		if (idTipoMovimiento == 2){
			$("#formBody").attr("action", "<?= base_url() ?>index.php/mediosDePago/modificar/" + $('#idComprobante').val());
			$("#formBody").submit();	
		}
	} else {
		alert("a");
	}
}

$( document ).ready(function() {

	$('#fechaDesde').datepicker({format: 'dd/mm/yyyy', language: 'es'});
	$('#fechaHasta').datepicker({format: 'dd/mm/yyyy', language: 'es'});
	

	$("#btnDiaAnterior").click(function () {
		if ($('#fechaDesde').val()!=""){
			var date2 = $('#fechaDesde').datepicker('getDate');
			date2.setDate(date2.getDate()-1);
			$('#fechaDesde').datepicker('setDate', date2);
		}else {
			$('#fechaDesde').datepicker('setDate', new Date());
		}

	});

	$("#btnDiaProximo").click(function () {
		if ($('#fechaHasta').val()!=""){
			var date2 = $('#fechaHasta').datepicker('getDate');
			date2.setDate(date2.getDate()+1);
			$('#fechaHasta').datepicker('setDate', date2);
		}else {
			$('#fechaHasta').datepicker('setDate', new Date());
		}
	});

	$('#dtMovimiento').dataTable({

		"sDom": "<'row'<'col-sm-6'T><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        "sPaginationType": "bootstrap",
        "oLanguage": {
        	"sLengthMenu": "_MENU_ records per page",
        	"sSearch": "Buscar"
        },
        //"sDom": "<'row'<'col-sm-12'T><'col-sm-12'f>r>t<'row'<'col-sm-12'i><'col-sm-12'p>>",
        "bSort": true,
        "bDestroy": true,
        "oTableTools": {
        	"sSwfPath": "<?= base_url() ?>assets/plugins/datatables-1-10-4/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
        	"sRowSelect": "single",


        }
    });


/*	$("#dtMovimiento tr").click(function () {
		$("#idMovimiento").val($(this).children("td:eq(0)").text());
	});
*/

    $('#dtMovimiento tbody').on( 'click', 'tr', function () {
        $("#idMovimiento").val($(this).children("td:eq(0)").text());
    } );

	$("#btnModificar").click(function () {
		if ($('#idMovimiento').val() != ''){
			$("#formBody").attr("action", "<?= base_url() ?>index.php/movimiento/modificar");
			$("#formBody").submit();
		} else {
			bootbox.alert("Seleccione un movimiento a modificar");
		}
	});

	$("#btnNuevo").click(function () {
		$("#formBody").attr("action", "<?= base_url() ?>index.php/movimiento");
		$("#formBody").submit();
	});

	$("#btnEliminar").click(function () {
		
		if ($('#idMovimiento').val() != ''){
			bootbox.confirm("Eliminará el movimiento seleccionado. ¿Está serguro?", function(result) {
				if (result == true) {
					
					$("#formBody").attr("action", "<?= base_url() ?>index.php/movimiento/eliminar");
					$("#formBody").submit();
				}
			});
		}else {
			bootbox.alert("Seleccione un Movimiento a Eliminar");
		} 
	});


});
</script>