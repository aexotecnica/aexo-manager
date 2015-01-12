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

		<?
		if ($comprobantes != NULL) {?>
		<div class="row">
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
						<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables" id="example">
							<thead>
								<tr>
									<th>Fecha</th>
									<th>Tipo Comprobante</th>
									<th>Nro Comprobante</th>
									<th>Cliente</th>
									<th>Descripcion</th>
								}<th>Importe</th>
							</tr>
						</thead>
						<tbody>
							<?
							foreach ($comprobantes as $val){?>	
							<tr class="odd gradeX">
								<td><?= $val->fecha?></td>
								<td><?= ""?></td>
								<td><?= $val->nroComprobante?></td>
								<td><?= $val->nombreCliente?></td>
								<td><?= $val->descripcion?></td>
								<td><?= $val->importeTotal?></td>
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
				<div class="col-sm-6 col-sm-offset-3">
					<div class="btn-toolbar">
						<input type="button" id="btnNuevo" value="Nuevo" class="btn-primary btn"></input>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

</div>
</div>

<?php echo form_close(); ?>


<script type='text/javascript'>
// Calendar
// If screensize > 1200, render with m/w/d view, if not by default render with just title

$( document ).ready(function() {

	$('#txtFecha').datepicker({format: 'dd/mm/yyyy', language: 'es'});

	$('#btnNuevo').click(function() {
		$('#formBody').attr("action", "<?= base_url() ?>index.php/comprobanteDeVenta/nuevo");
		$('#formBody').submit();
	})


});
</script>