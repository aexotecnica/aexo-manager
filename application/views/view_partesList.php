<?php echo form_open( $actionDelForm, 'method="post" id="formBody" autocomplete="off" enctype="multipart/form-data"'); ?>
<div id="page-heading">
	<ul class="breadcrumb">
		<li><a href="index.htm">Produccion</a></li>
		<li class="active">Partes</li>
	</ul>

	<h1>Listar partes</h1>
    <div class="options">
        <div class="btn-toolbar">
            <a class="btn btn-default" href="javascript:importarPartes();">
                <i class="fa fa-arrow-circle-up"></i> 
                <span class="hidden-xs hidden-sm">Importar Partes</span>
            </a>
        </div>
    </div>
</div>
<div class="container">
	<div class="panel panel-midnightblue">
		<div class="row">

			<div class="col-md-12">
				<div class="panel panel-sky">
					<div class="panel-heading">
						<h4>Partes</h4>
						<div class="options">   
							<a href="javascript:;"><i class="fa fa-cog"></i></a>
							<a href="javascript:;"><i class="fa fa-wrench"></i></a>
							<a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
						</div>
					</div>
					<div class="panel-body collapse in">
						<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables" id="dtPartes">
							<thead>
								<tr>
									<th>idParte</th>
									<th>descripcion</th>
									<th>codigo</th>
									<th>costo</th>
								</tr>
							</thead>
							<tbody>

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
			<input type="hidden" id="idParte" name="idParte"></input>
		</div>
	</div>
</div>
</div>

<?php echo $modalImportarPartes; ?>

<?php echo form_close(); ?>
<link rel='stylesheet' type='text/css' href='<?= base_url() ?>assets/plugins/form-multiselect/css/multi-select.css' /> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/bootbox/bootbox.min.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/jquery.dataTables.min.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/TableTools.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/dataTables.editor.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/dataTables.editor.bootstrap.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/dataTables.bootstrap.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/form-multiselect/js/jquery.multi-select.min.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/form-select2/select2.min.js'></script> 

<script type='text/javascript'>
	var baseUrl= "<?= base_url() ?>";
</script>
<script type='text/javascript' src='<?= base_url() ?>assets/aexo-manager/views/jsPartesList.js'></script> 	