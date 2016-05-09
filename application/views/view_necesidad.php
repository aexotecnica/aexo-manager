<?php echo form_open( $actionDelForm, 'method="post" id="formBody" autocomplete="off" enctype="multipart/form-data"'); ?>
<style>

td.group {
    background-color: #D1CFD0 !important;
    border-bottom: 2px solid #A19B9E !important;
    border-top: 2px solid #A19B9E !important;
}

.expanded-group{
	background: url("<?= base_url() ?>assets/plugins/datatables/images/minus.jpg") no-repeat scroll left center transparent;
	padding-left: 15px !important
}

.collapsed-group{
	background: url("<?= base_url() ?>assets/plugins/datatables/images/plus.jpg") no-repeat scroll left center transparent;
	padding-left: 15px !important
}

</style>
<div id="page-heading">
	<ul class="breadcrumb">
		<li><a href="index.htm">Produccion</a></li>
		<li class="active">Necesidad</li>
	</ul>

	<h1>Listar necesidad de partes</h1>
</div>
<div class="container">
	<div class="panel panel-midnightblue">
		<div class="row">

			<div class="col-md-12">
				<div class="panel panel-sky">
					<div class="panel-heading">
						<h4>Necesidad</h4>
						<div class="options">   
							<a href="javascript:;"><i class="fa fa-cog"></i></a>
							<a href="javascript:;"><i class="fa fa-wrench"></i></a>
							<a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
						</div>
					</div>
					<div class="panel-body collapse in">
						<table id="dtNecesidad" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables">
							<thead>
								<tr>
									<th>Parte</th>
									<th style="display:none">IdParte</th>
									<th>IdOrdenPedido</th>
									<th>cliente</th>
									<th>Cantidad</th>
								</tr>
							</thead>
							<tbody>
								<?
								if ($necesidad != NULL)
									foreach ($necesidad as $val){?>	
										<tr class="gradeX">
											<td><?= $val->parte_descripcion?></td>
											<td style="display:none"><?= $val->idParte?></td>
											<td><?= $val->idOrdenPedido?></td>
											<td><?= $val->cliente_nombre?></td>
											<td><?= $val->cantidad?></td>
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
							<!-- <input type="button" id="btnNuevo" value="Nuevo" class="btn-primary btn"></input> -->
						</div>
					</div>
				</div>
			</div>
			<input type="hidden" id="idNecesidad" name="idNecesidad"></input>
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
<script type='text/javascript' src="<?= base_url() ?>assets/plugins/datatables/RowGrouping/jquery.dataTables.rowGrouping.js"></script>
<script type='text/javascript' src="<?= base_url() ?>assets/aexo-manager/views/jsNecesidad.js"></script>

<script type="text/javascript">
var baseUrl= "<?= base_url() ?>";
</script>