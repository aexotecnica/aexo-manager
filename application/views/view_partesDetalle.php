<?php echo form_open( "partes/guardar", 'method="post" id="formBody" autocomplete="off" enctype="multipart/form-data" class="form-horizontal row-border"'); ?>
<div id="page-heading">
	<ul class="breadcrumb">
		<li><a href="index.htm">Dashboard</a></li>
		<li>Advanced Forms</li>
		<li class="active">Form Validation</li>
	</ul>

	<h1>Ingresar Parte</h1>
</div>
<div class="container">
	<div class="panel panel-midnightblue">
		<div class="panel-heading ">
			<h4>Parte</h4>
			<div class="options">   
				<a class="panel-collapse" href="javascript:;"><i class="fa fa-chevron-down"></i></a>
			</div>
		</div>
		<div class="panel-body collapse in">
			<div class="form-group">
				<div class="row">
					<label class="col-sm-3 control-label">Codigo</label>
					<div class="col-md-6">
						<input type="text" value="<?= ($parte!=NULL) ? $parte->codigo :""; ?>" name="txtCodigo" id="txtCodigo" required="required" class="form-control" placeholder="Codigo">
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<label class="col-sm-3 control-label">Descripcion</label>
					<div class="col-md-6">
						<input type="text" value="<?= ($parte!=NULL) ? $parte->descripcion:""; ?>" name="txtDescripcion" id="txtDescripcion" required="required" class="form-control" placeholder="Descripcion">
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<label class="col-sm-3 control-label">Nombre Homologado</label>
					<div class="col-md-6">
						<input type="text" value="<?= ($parte!=NULL) ? $parte->nombreHomologado:""; ?>" name="txtNombreHomologado" id="txtNombreHomologado" required="required" class="form-control" placeholder="Nombre Homologado">
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<label class="col-sm-3 control-label">Costo S/procesar</label>
					<div class="col-md-6">
						<input type="text" value="<?= ($parte!=NULL) ? $parte->costoParteBruto:""; ?>" name="txtCostoSinProcesar" id="txtCostoSinProcesar" required="required" class="form-control" placeholder="Costo S/Procesar">
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<label class="col-sm-3 control-label">Es parte final</label>
					<div class="col-md-6">
						<input type="checkbox" id="chkEsFinal" name="chkEsFinal" <?= ($parte!=NULL && $parte->esParteFinal) ? "checked='checked'" :""; ?> value="<?= ($parte!=NULL) ? $parte->idParte:"0"; ?>">
					</div>
				</div>
			</div>

            <div class="form-group">
                <label class="col-sm-3 control-label">Transicion de estados</label>
                <div class="col-sm-9">
                    <div style="width:380; float:left">
                    <select multiple="multiple" id="mselEstadosParte" name="mselEstadosParte[]">
	                    <? 
	                    foreach ($estadosPartes as $val){ 
	                    ?>
	                        <option  value='<?= $val->idEstadoParte?>' <?if ($val->seleccionado ==1){echo "selected";}?> ><?= $val->descripcion?></option>    
	                    <?}?>
                    </select>
                	</div>
                    <div id="divCostos" style="width:180; float:left">
                    	<? 
                    	$contador= 0;
	                    foreach ($estadosPartes as $val){
	                    	if ($val->orden < 9999) {
	                    		?>
                    			<input type="text" onblur="javascript:calcularCosto()" value="<?=$val->costo?>" id="txtCosto_<?=$val->idEstadoParte?>" name="costo[]" class="form-control numero" style="height:25px" placeholder="Costo"/>
                    			<?
                    			$contador += 1;
                    		}
                    	}?>
                	</div>
                </div>
                
            </div>
       			<div class="form-group">
				<div class="row">
					<label class="col-sm-3 control-label">Costo Final</label>
					<div class="col-md-6">
						<input type="text" value="<?= ($parte!=NULL) ? $parte->costoParteFinal:""; ?>" name="txtCostoFinal" id="txtCostoFinal" required="required" class="form-control" placeholder="Costo S/Procesar">
					</div>
				</div>
			</div>

			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-6 col-sm-offset-3">
						<div class="btn-toolbar">
							<!-- <button class="btn-primary btn">Submit</button> -->
							<input type="button" value="Submit" id="btnSubmit" class="btn-primary btn"></input>
							<input type="button" value="Cancel" id="btnCancelar" class="btn-default btn"></input>
						</div>
					</div>
				</div>
			</div>
		</div>
		<input type="hidden" value="<?= ($parte!=NULL) ? $parte->idParte :""; ?>"  id="txtIdParte" name="txtIdParte"></input>
	</div>
</div>
<?php echo form_close(); ?>
<link rel='stylesheet' type='text/css' href='<?= base_url() ?>assets/plugins/form-multiselect/css/multi-select.css' /> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/bootbox/bootbox.min.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/form-inputmask/jquery.inputmask.bundle.min.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/form-multiselect/js/jquery.multi-select.min.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/form-select2/select2.min.js'></script> 
<script type='text/javascript'>
	var baseUrl= "<?= base_url() ?>";
</script>
<script type='text/javascript' src='<?= base_url() ?>assets/aexo-manager/views/jsPartesDetalle.js'></script> 	