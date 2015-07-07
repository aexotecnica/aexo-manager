<?php echo form_open( "productos/guardar", 'method="post" id="formBody" autocomplete="off" enctype="multipart/form-data" class="form-horizontal row-border"'); ?>
<div id="page-heading">
	<ul class="breadcrumb">
		<li><a href="index.htm">Dashboard</a></li>
		<li>Advanced Forms</li>
		<li class="active">Form Validation</li>
	</ul>

	<h1>Ingresar Producto</h1>
</div>
<div class="container">
	<div class="panel panel-midnightblue">
		<div class="panel-heading ">
			<h4>Producto</h4>
			<div class="options">   
				<a class="panel-collapse" href="javascript:;"><i class="fa fa-chevron-down"></i></a>
			</div>
		</div>
		<div class="panel-body collapse in">
			<div class="form-group">
				<div class="row">
					<label class="col-sm-3 control-label">Parte Final</label>
					<div class="col-md-6">
						<select name="selParteFinal" id="selParteFinal" class="form-control"> 
							<option>Partes</option>
							<?
							foreach ($partes as $val){
								if ($producto==NULL) 	{?>
									<option codigo='<?= $val->codigo?>' value='<?= $val->idParte?>'><?= $val->descripcion?></option>
								<?
								} else {
									?>
									<option codigo='<?= $val->codigo?>'  value='<?= $val->idParte?>' <?=($producto->idParteFinal == $val->idParte) ? "selected" :  "" ?>><?= $val->descripcion?></option>
									<?
								}
							}?>
						</select>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<label class="col-sm-3 control-label">Codigo</label>
					<div class="col-md-6">
						<input type="text" value="<?= ($producto!=NULL) ? $producto->codigo :""; ?>" name="txtCodigo" id="txtCodigo" required="required" class="form-control" placeholder="Codigo">
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<label class="col-sm-3 control-label">Descripcion</label>
					<div class="col-md-6">
						<input type="text" value="<?= ($producto!=NULL) ? $producto->descripcion:""; ?>" name="txtDescripcion" id="txtDescripcion" required="required" class="form-control" placeholder="Descripcion">
					</div>
				</div>
			</div>

			<div class="form-group">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables" id="gdCosto">
                <thead>
                    <tr>
                        <th width="30%" style="padding:5px">FechaDesde</th>
                        <th width="20%" style="padding:5px">FechaHasta</th>
                        <th width="18%" style="padding:5px">Costo</th>
                    </tr>
                </thead>
                    <? if ($costos != null) { 
                        $indice=0;?>
                        <? foreach ($costos as $val){    ?>  
                            <tr class="odd gradeX">
                                <td><?= date( 'd/m/Y', strtotime( $val->fechaInicio)) ?></td>
                                <td><?= date( 'd/m/Y', strtotime( $val->fechaFin))?></td>
                                <td><?= $val->costo?></td>
                            </tr>
                        <? $indice +=1;
                        }?>
                    <? } ?>
                <tbody>
                </tbody>
            </table>
            <!--end table-->
            <input type="button" class="btn-primary btn" id="btnAgregar" value="Agregar Costo" />
            <input type="button" class="btn-primary btn" id="btnModificar" value="Modificar Costo" />
            <input type="button" class="btn-primary btn" id="btnEliminar" value="Eliminar Costo" />
			</div>
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-6 col-sm-offset-3">
						<div class="btn-toolbar">
							<input type="button" id="btnGuardar" class="btn-primary btn" value="Guardar"></input>
							<input type="button" value="Cancel" id="btnCancelar" class="btn-default btn"></input>
						</div>
					</div>
				</div>
			</div>
		</div>
		<input type="hidden" value="<?= ($producto!=NULL) ? $producto->idProducto :""; ?>"  id="txtIdProducto" name="txtIdProducto"></input>
	</div>
</div>

<div id="dialog-costo">
    <div class="form-group">
        <label class="col-sm-4 control-label">Fecha desde</label>
        <div class="col-sm-8" style="margin-bottom:15px">
            <input type="text" name="txtFechaDesde" id="txtFechaDesde" required="required" class="form-control">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Fecha hasta</label>
        <div class="col-sm-8" style="margin-bottom:15px">
            <input type="text" name="txtFechaHasta" id="txtFechaHasta" required="required" class="form-control">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Importe</label>
        <div class="col-sm-8" style="margin-bottom:15px">
            <input type="text" name="txtImporte" id="txtImporte" required="required" class="form-control">
        </div>
    </div>

    <div class="panel-footer">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <div class="btn-toolbar">
                    <input type="submit" id="btnAceptar" class="btn-primary btn" value="Aceptar" />
                    <button id="btnCerrar" class="btn-default btn">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="text" name="txtModificaCosto" id="txtModificaCosto" class="form-control">
<input type="hidden" name="txtJsonCosto" id="txtJsonCosto" class="form-control">
<?php echo form_close(); ?>

<script type='text/javascript' src='<?= base_url() ?>assets/plugins/form-inputmask/jquery.inputmask.bundle.min.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/jquery.dataTables.min.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/form-parsley/parsley.min.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/jquery.tabletojson.js'></script>
<script type='text/javascript' src='<?= base_url() ?>assets/aexo-manager/views/jsProductosDetalle.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/TableTools.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/jquery.tabletojson.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/dataTables.editor.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/dataTables.editor.bootstrap.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/dataTables.bootstrap.js'></script> 
<script type="text/javascript">
var baseUrl= "<?= base_url() ?>";
</script>