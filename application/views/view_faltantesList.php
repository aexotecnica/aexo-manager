<?php echo form_open( $actionDelForm, 'method="post" id="formBody" autocomplete="off" enctype="multipart/form-data"'); ?>
<div id="page-heading">
	<ul class="breadcrumb">
		<li><a href="index.htm">Produccion</a></li>
		<li class="active">Faltantes</li>
	</ul>

	<h1>Listar Faltantes</h1>
</div>
<div class="container">
	<div class="panel panel-midnightblue">
		<div class="row">

			<div class="col-md-12">
				<div class="panel panel-sky">
					<div class="panel-heading">
						<h4>Faltantes</h4>
						<div class="options">   
							<a href="javascript:;"><i class="fa fa-cog"></i></a>
							<a href="javascript:;"><i class="fa fa-wrench"></i></a>
							<a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
						</div>
					</div>
					<div class="panel-body collapse in">
						<div class="tab-container tab-left tab-danger">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#porProducto" data-toggle="tab">Por Producto</a></li>
								<li ><a href="#porPartesGral" data-toggle="tab">General</a></li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane active" id="porProducto">
									<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables" id="dtStock">
										<thead>
											<tr>
												<th>IdProducto</th>
												<th>IdParte</th>
												<th>Descripcion</th>
												<th>Falantes</th>
											</tr>
										</thead>
										<tbody>
											<?
											if ($stock != NULL)
												foreach ($stock as $val){?>	
													<tr class="idStockPartes gradeX">
														<td><?= $val->idProducto?></td>
														<td><?= $val->idParte?></td>
														<td><?= $val->descripcion?></td>
														<td><?= $val->cantidadFaltante?></td>
													</tr>
												<?}?>
										</tbody>
									</table>
									<div class="row">
										<div class="pull-right">
											<div class="btn-toolbar">
												<input type="button" id="btnDetalle" value="Ver Detalle" class="btn-primary btn"></input>
												<!--<input type="button" id="btnModificar" value="Corregir Stock" class="btn-primary btn"></input> -->
											</div>
										</div>
									</div>

								</div>
								<div class="tab-pane" id="porPartesGral">
									<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables" id="dtFaltantesGral">
										<thead>
											<tr>
												<th>IdParte</th>
												<th>Descripcion</th>
												<th>Falantes</th>
											</tr>
										</thead>
										<tbody>
											<?
											if ($stockFalanteGral != NULL)
												foreach ($stockFalanteGral as $val){?>	
													<tr class="idStockPartes gradeX">
														<td><?= $val->idParte?></td>
														<td><?= $val->descripcion?></td>
														<td><?= $val->cantidadFaltante?></td>
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

			<input type="hidden" id="idStockPartes" name="idStockPartes"></input>
			<input type="hidden" id="idProducto" name="idProducto"></input>
		</div>
	</div>
</div>
</div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-productos">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Detalle</h4>
                </div>
                <div class="modal-body">
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label>
									<input name="tipoListado" id="porInsumo" type="radio" checked="">
									Por Subconjunto									
								</label>
								<label>
									<input name="tipoListado" id="porParte" type="radio" >
									Por Parte
								</label>
							</div>
						</div>
					</div>
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables" id="dtProductosModal">
                        <thead>
                            <tr>
                                <th>idParte</th>
                                <th>descripcion</th>
                                <th>cantidadStock</th>
                                <th>faltante</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

<?php echo form_close(); ?>

<script type='text/javascript' src='<?= base_url() ?>assets/plugins/bootbox/bootbox.min.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/jquery.dataTables.min.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/TableTools.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/dataTables.editor.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/dataTables.editor.bootstrap.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/dataTables.bootstrap.js'></script> 
<script type='text/javascript' src="<?= base_url() ?>assets/aexo-manager/views/jsFaltantesList.js"></script>
<script type="text/javascript">
var baseUrl= "<?= base_url() ?>";
</script>