<?php echo form_open( "clientes/guardar", 'method="post" id="formBody" autocomplete="off" enctype="multipart/form-data" class="form-horizontal row-border"'); ?>
<div id="page-heading">
	<ul class="breadcrumb">
		<li><a href="index.htm">Dashboard</a></li>
		<li>Advanced Forms</li>
		<li class="active">Form Validation</li>
	</ul>

	<h1>Ingresar Cliente</h1>
</div>
<div class="container">
	<div class="panel panel-midnightblue">
		<div class="panel-heading ">
			<h4>Cliente</h4>
			<div class="options">   
				<a class="panel-collapse" href="javascript:;"><i class="fa fa-chevron-down"></i></a>
			</div>
		</div>
		<div class="panel-body collapse in">
			<div class="tab-container tab-left tab-danger">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#datosGrales" data-toggle="tab">Generales</a></li>
					<li><a href="#ubicacion" id="tabUbicacion" data-toggle="tab">Ubicacion</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="datosGrales">
						<div class="form-group">
							<div class="row">
								<label class="col-md-2 control-label">Nombre</label>
								<div class="col-md-4">
									<input type="text" value="<?= ($cliente!=NULL) ? $cliente->nombre :""; ?>" name="txtNombre" id="txtNombre" required="required" class="form-control" placeholder="Nombre">
								</div>
								<label class="col-md-2 control-label">Tipo de cliente</label>
								<div class="col-md-4">
									<select name="selTipoCliente" class="form-control"> 
										<option>Tipo Cliente</option>

										<?
										foreach ($tiposClientes as $val){
											if ($cliente==NULL) 	{?>
											<option  value='<?= $val->idTipoCliente?>'><?= $val->descripcion?></option>
											<?
										} else {
											?>
											<option  value='<?= $val->idTipoCliente?>' <?=($cliente->idTipoCliente == $val->idTipoCliente) ? "selected" :  "" ?>><?= $val->descripcion?></option>
											<?
										}
									}?>
								</select>
							</div>
						</div>
					</div>
						<div class="form-group">
							<div class="row">
								<label class="col-md-2 control-label">CUIT</label>
								<div class="col-md-4">
									<input type="text" value="<?= ($cliente!=NULL) ? $cliente->cuit :""; ?>" name="txtCuit" id="txtCuit" required="required" class="form-control" placeholder="Cuit">
								</div>
								<label class="col-md-2 control-label">Categoria IVA</label>
								<div class="col-md-4">
									<select name="selCategoriaIVA" class="form-control"> 
										<option>Categoria IVA</option>

										<?
										foreach ($categoriasIva as $val){
											if ($cliente==NULL) 	{?>
											<option  value='<?= $val->idCategoriaIVA?>'><?= $val->descripcion?></option>
											<?
										} else {
											?>
											<option  value='<?= $val->idCategoriaIVA?>' <?=($cliente->idCategoriaIVA == $val->idCategoriaIVA) ? "selected" :  "" ?>><?= $val->descripcion?></option>
											<?
										}
									}?>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<label class="col-md-2 control-label">E-Mail</label>
							<div class="col-md-4">
								<input type="text" value="<?= ($cliente!=NULL) ? $cliente->email :""; ?>" name="txtEmail" id="txtEmail" required="required" class="form-control" placeholder="E-Mail">
							</div>
							<label class="col-md-2 control-label">Pagina Web.</label>
							<div class="col-md-4">
								<input type="text" value="<?= ($cliente!=NULL) ? $cliente->paginaWeb :""; ?>" name="txtPaginaWeb" id="txtPaginaWeb" required="required" class="form-control" placeholder="Pagina Web">
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<label class="col-md-2 control-label">Responsable</label>
							<div class="col-md-4">
								<input type="text" value="<?= ($cliente!=NULL) ? $cliente->responsable :""; ?>" name="txtResponsable" id="txtResponsable" required="required" class="form-control" placeholder="Responsable">
							</div>
							
						</div>
					</div>
				</div>
				<div class="tab-pane" id="ubicacion">
					<div class="form-group">
						<div class="row">
							<label class="col-md-2 control-label">Domicilio</label>
							<div class="col-md-10">
								<input type="text" value="<?= ($cliente!=NULL) ? $cliente->calle :""; ?>" name="txtDomicilio" id="txtDomicilio" required="required" class="form-control" placeholder="Domicilio">
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<label class="col-md-2 control-label">Provincia</label>
							<div class="col-md-4">	
								<select name="selProvincia" class="form-control"> 
									<option>Provincia</option>

									<?
									foreach ($provincias as $val){
										if ($cliente==NULL) 	{?>
										<option  value='<?= $val->idProvincia?>'><?= $val->descripcion?></option>
										<?
									} else {
										?>
										<option  value='<?= $val->idProvincia?>' <?=($cliente->idProvincia == $val->idProvincia) ? "selected" :  "" ?>><?= $val->descripcion?></option>
										<?
									}
								}?>
							</select>
						</div>
						<label class="col-md-2 control-label">Calle</label>
						<div class="col-md-4">
							<input type="text" value="<?= ($cliente!=NULL) ? $cliente->calle :""; ?>" name="txtCalle" id="txtCalle" required="required" class="form-control" placeholder="Calle">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<label class="col-md-2 control-label">Numero</label>
						<div class="col-md-4">
							<input type="text" value="<?= ($cliente!=NULL) ? $cliente->numero :""; ?>" name="txtNumero" id="txtNumero" required="required" class="form-control" placeholder="Numero">
						</div>
						<label class="col-md-2 control-label">Localidad</label>
						<div class="col-md-4">
							<input type="text" value="<?= ($cliente!=NULL) ? $cliente->localidad :""; ?>" name="txtLocalidad" id="txtLocalidad" required="required" class="form-control" placeholder="Localidad">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<label class="col-md-2 control-label">Partido</label>
						<div class="col-md-4">
							<input type="text" value="<?= ($cliente!=NULL) ? $cliente->partido :""; ?>" name="txtPartido" id="txtPartido" required="required" class="form-control" placeholder="Partido">
						</div>
						<label class="col-md-2 control-label">Cod. Postal</label>
						<div class="col-md-4">
							<input type="text" value="<?= ($cliente!=NULL) ? $cliente->codigoPostal :""; ?>" name="txtCodigoPostal" id="txtCodigoPostal" required="required" class="form-control" placeholder="Cod. Postal">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-md-12">
							<div id="map-ubicacionCliente"></div>
						</div>
					</div>
				</div>
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
	<input type="hidden" value="<?= ($cliente!=NULL) ? $cliente->idCliente :""; ?>"  id="txtIdCliente" name="txtIdCliente"></input>
</div>
</div>
<?php echo form_close(); ?>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=places"></script>


<script type='text/javascript' src='<?= base_url() ?>assets/plugins/bootbox/bootbox.min.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/form-inputmask/jquery.inputmask.bundle.min.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/js/js_clientesDetalle.js'></script> 

<script type='text/javascript'>

$( document ).ready(function() {

	$('.mask').inputmask();

	$("#btnCancelar").click(function(){
		window.location.href = "<?= base_url() ?>index.php/clientes";
	});

	$("#btnSubmit").click(function(){
	  $("#formBody").attr("action", "<?= base_url() ?>index.php/clientes/guardar");
	  $("#formBody").submit();
	});

	$("#tabUbicacion").click(function(){
		cargarMapa(<?=$cliente->latitud?>,<?=$cliente->longitud?>);
	});
});

</script>