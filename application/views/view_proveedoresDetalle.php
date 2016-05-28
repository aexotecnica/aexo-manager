<?php echo form_open( "proveedores/guardar", 'method="post" id="formBody" autocomplete="off" enctype="multipart/form-data" data-validate="parsley" class="form-horizontal row-border"'); ?>
<div id="page-heading">
	<ul class="breadcrumb">
		<li><a href="index.htm">Dashboard</a></li>
		<li>Advanced Forms</li>
		<li class=	"active">Form Validation</li>
	</ul>

	<h1>Ingresar Proveedor</h1>
</div>


<div class="container">
	<div class="panel panel-midnightblue">
		<div class="panel-heading ">
			<h4>Proveedor</h4>
			<div class="options">   
				<a class="panel-collapse" href="javascript:;"><i class="fa fa-chevron-down"></i></a>
			</div>
		</div>
		<div class="panel-body collapse in">
			<div class="tab-container tab-left tab-danger">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#datosGrales" data-toggle="tab">Generales</a></li>
					<li ><a href="#tabComentarios" data-toggle="tab">Comentarios</a></li>
					<li><a href="#ubicacion" id="tabUbicacion" data-toggle="tab">Ubicacion</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="datosGrales">
						<div class="form-group">
							<div class="row">
								<label class="col-md-2 control-label">Nombre</label>
								<div class="col-md-4">
									<input type="text" value="<?= ($proveedor!=NULL) ? $proveedor->nombre :""; ?>" name="txtNombre" id="txtNombre" required="required" class="form-control" placeholder="Nombre">
								</div>
								<label class="col-md-2 control-label">Tipo de proveedor</label>
								<div class="col-md-4">
									<select name="selTipoProveedor" class="form-control" required="required"> 
										<option value="0">Tipo Proveedor</option>

										<?
										foreach ($tiposproveedores as $val){
											if ($proveedor==NULL) 	{?>
											<option  value='<?= $val->idTipoCliente?>'><?= $val->descripcion?></option>
											<?
										} else {
											?>
											<option  value='<?= $val->idTipoCliente?>' <?=($proveedor->idTipoProveedor == $val->idTipoCliente) ? "selected" :  "" ?>><?= $val->descripcion?></option>
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
									<input type="text" value="<?= ($proveedor!=NULL) ? $proveedor->cuit :""; ?>" name="txtCuit" id="txtCuit" required="required" class="form-control" placeholder="Cuit">
								</div>
								<label class="col-md-2 control-label">Categoria IVA</label>
								<div class="col-md-4">
									<select name="selCategoriaIVA" class="form-control" required="required"> 
										<option value="0">Categoria IVA</option>

										<?
										foreach ($categoriasIva as $val){
											if ($proveedor==NULL) 	{?>
											<option  value='<?= $val->idCategoriaIVA?>'><?= $val->descripcion?></option>
											<?
										} else {
											?>
											<option  value='<?= $val->idCategoriaIVA?>' <?=($proveedor->idCategoriaIVA == $val->idCategoriaIVA) ? "selected" :  "" ?>><?= $val->descripcion?></option>
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
									<input type="text" value="<?= ($proveedor!=NULL) ? $proveedor->email :""; ?>" name="txtEmail" id="txtEmail" required="required" class="form-control" placeholder="E-Mail">
								</div>
								<label class="col-md-2 control-label">Pagina Web.</label>
								<div class="col-md-4">
									<input type="text" value="<?= ($proveedor!=NULL) ? $proveedor->paginaWeb :""; ?>" name="txtPaginaWeb" id="txtPaginaWeb" class="form-control" placeholder="Pagina Web">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<label class="col-md-2 control-label">Responsable</label>
								<div class="col-md-4">
									<input type="text" value="<?= ($proveedor!=NULL) ? $proveedor->responsable :""; ?>" name="txtResponsable" id="txtResponsable" class="form-control" placeholder="Responsable">
								</div>

							</div>
						</div>
					</div>

					<div class="tab-pane" id="tabComentarios">
                    <div class="col-12">
                        <textarea name="txtComentarios" id="txtComentarios" cols="80" rows="20" class="ckeditor"><?= ($proveedor!=NULL) ? $proveedor->comentarios :""; ?></textarea>
                    </div>
					</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									
								</div>
							</div>
						</div>

					<div class="tab-pane" id="ubicacion">
						<div class="form-group">
							<div class="row">
								<label class="col-md-2 control-label">Domicilio</label>
								<div class="col-md-10">
									<input type="text" value="<?= ($proveedor!=NULL) ? $proveedor->domicilio :""; ?>" name="txtDomicilio" id="txtDomicilio"  class="form-control" placeholder="Domicilio">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<label class="col-md-2 control-label">Provincia</label>
								<div class="col-md-4">	
									<select name="selProvincia" id="selProvincia" class="form-control"  required="required"> 
										<option value="0">Provincia</option>

										<?
										foreach ($provincias as $val){
											if ($proveedor==NULL) {?>
											<option  value='<?= $val->idProvincia?>'><?= $val->descripcion?></option>
											<?
										} else {
											?>
											<option value='<?= $val->idProvincia?>' <?=($proveedor->idProvincia == $val->idProvincia) ? "selected" :  "" ?>><?= $val->descripcion?></option>
											<?
										}
									}?>
									</select>
								</div>
								<label class="col-md-2 control-label">Localidad</label>
								<div class="col-md-4">
									<input type="text" value="<?= ($proveedor!=NULL) ? $proveedor->localidad :""; ?>" name="txtLocalidad" id="txtLocalidad" class="form-control" placeholder="Localidad">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<label class="col-md-2 control-label">Partido</label>
								<div class="col-md-4">
									<input type="text" value="<?= ($proveedor!=NULL) ? $proveedor->partido :""; ?>" name="txtPartido" id="txtPartido" class="form-control" placeholder="Partido">
								</div>
								<label class="col-md-2 control-label">Cod. Postal</label>
								<div class="col-md-4">
									<input type="text" value="<?= ($proveedor!=NULL) ? $proveedor->codPostal :""; ?>" name="txtCodigoPostal" id="txtCodigoPostal" class="form-control" placeholder="Cod. Postal">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<div id="map-ubicacionProveedor"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>|
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
	</div>
</div>
<input type="hidden" value="<?= ($proveedor!=NULL) ? $proveedor->idProveedor :""; ?>"  id="txtidProveedor" name="txtidProveedor"></input>
<input type="hidden" value="<?= ($proveedor!=NULL) ? $proveedor->latitud :""; ?>"  id="txtLatitud" name="txtLatitud"></input>
<input type="hidden" value="<?= ($proveedor!=NULL) ? $proveedor->longitud :""; ?>"  id="txtLongitud" name="txtLongitud"></input>

<?php echo form_close(); ?>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=places"></script>


<script type='text/javascript' src='<?= base_url() ?>assets/plugins/bootbox/bootbox.min.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/form-inputmask/jquery.inputmask.bundle.min.js'></script> 

<script type='text/javascript' src='<?= base_url() ?>assets/aexo-manager/views/jsProveedoresDetalle.js'></script> 	
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/form-ckeditor/ckeditor.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/form-parsley/parsley.min.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/js/defiant-latest.min.js'></script> 
<script type='text/javascript'>
	var baseUrl= "<?= base_url() ?>";
</script>

<script type="text/javascript">
var jsProvincias = [];
$( document ).ready(function() {
	<? foreach ($provincias as $val){?>
		jsProvincias['<?=$val->codigo?>']=<?=$val->idProvincia?>;
		<?}?>

		$('.mask').inputmask();

		$("#btnCancelar").click(function(){
			window.location.href = baseUrl + "index.php/proveedores";
		});

		$("#btnSubmit").click(function(){
			$('#formBody').parsley( 'validate' );
			$("#formBody").attr("action", baseUrl + "index.php/proveedores/guardar");
			$("#formBody").submit();
		});

		$("#tabUbicacion").click(function(){
			<? if ($proveedor != NULL) {?>
				cargarMapa(<?=$proveedor->latitud?>,<?=$proveedor->longitud?>);
				<?}else { ?>
					cargarMapa(0,0);
				<?} ?>
			});
	});
</script>