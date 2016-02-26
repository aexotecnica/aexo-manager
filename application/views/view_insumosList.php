<?php echo form_open( $actionDelForm, 'method="post" id="formBody" autocomplete="off" enctype="multipart/form-data"'); ?>
<div id="page-heading">
	<ul class="breadcrumb">
		<li><a href="index.htm">Produccion</a></li>
		<li class="active">Subconjuntos</li>
	</ul>

	<h1>Listar Subconjuntos</h1>
</div>
<div class="container">
	<div class="panel panel-midnightblue">
		<div class="row">

			<div class="col-md-12">
				<div class="panel panel-sky">
					<div class="panel-heading">
						<h4>Subconjuntos</h4>
						<div class="options">   
							<a href="javascript:;"><i class="fa fa-cog"></i></a>
							<a href="javascript:;"><i class="fa fa-wrench"></i></a>
							<a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
						</div>
					</div>
					<div class="panel-body collapse in">
						<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables" id="dtInsumos">
							<thead>
								<tr>
									<th>idInsumo</th>
									<th>Cod. Subconjunto</th>
									<th>idParte</th>
									<th>descripcion</th>
									<th>Cod. Parte</th>
								</tr>
							</thead>
							<tbody>
								<?
								if ($insumos != NULL)
									foreach ($insumos as $val){?>	
										<tr class="idProducto gradeX">
											<td><?= $val->idInsumo?></td>
											<td><?= $val->codigoInsumo?></td>
											<td><?= $val->idParte?></td>
											<td><?= $val->descripcion?></td>
											<td><?= $val->codigo?></td>
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
<!-- 							<input type="button" id="btnNuevo" value="Nuevo" class="btn-primary btn"></input>
							<input type="button" id="btnModificar" value="Modificar" class="btn-primary btn"></input> -->
							<input type="button" id="btnArbol" value="Arbol" class="btn-primary btn"></input>
							<input type="button" id="btnEliminar" value="Eliminar" class="btn-primary btn"></input>
						</div>
					</div>
				</div>
			</div>
			<input type="hidden" id="idInsumo" name="idInsumo"></input>
			<input type="hidden" id="codigoInsumo" name="codigoInsumo"></input>
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
	var baseUrl= "<?= base_url() ?>";
</script>
<script type='text/javascript' src='<?= base_url() ?>assets/aexo-manager/views/jsInsumosList.js'></script> 	