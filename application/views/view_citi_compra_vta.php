
<?php echo form_open( "", 'method="post" id="formBody" autocomplete="off" enctype="multipart/form-data" class="form-horizontal row-border"'); ?>
<div id="page-heading">
		<ol class="breadcrumb">
			<li><a href="index.htm">Dashboard</a></li>
			<li>Advanced Forms</li>
			<li>Dropzone</li>
		</ol>
		<h1>Citi Compras</h1>
		<div class="options">
			<div class="btn-toolbar">
				<div class="btn-group hidden-xs">
					<a href='#' class="btn btn-default dropdown-toggle" data-toggle='dropdown'><i class="fa fa-cloud-download"></i><span class="hidden-sm"> Export as  </span><span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="#">Text File (*.txt)</a></li>
						<li><a href="#">Excel File (*.xlsx)</a></li>
						<li><a href="#">PDF File (*.pdf)</a></li>
					</ul>
				</div>
				<a href="#" class="btn btn-default"><i class="fa fa-cog"></i></a>
			</div>
		</div>
</div>
<div class="container">
	<div class="panel panel-midnightblue">
		<div class="panel-heading ">
			<h4>Citi Compras</h4>
			<div class="options">   
				<a class="panel-collapse" href="javascript:;"><i class="fa fa-chevron-down"></i></a>
			</div>
		</div>
		
		<div id="divSeleccion" class="panel-body collapse in">
			<div class="form-group">
				 <div class="row">
					<div class="col-md-4">
						<select name="selExportacion" id="selExportacion" class="form-control" required="required"> 
							<option value="">Tipo de Exportacion</option>
							<option value="1">Citi Compras</option>
							<option value="2">Citi Ventas</option>
						</select>

					</div>
					<div class="col-md-4">
						<select name="selMes" id="selMes" class="form-control" required="required"> 
							<option value="">Mes</option>
							<option  value='1'>Enero</option>
							<option  value='2'>Febrero</option>
							<option  value='3'>Marzo</option>
							<option  value='4'>Abril</option>
							<option  value='5'>Mayo</option>
							<option  value='6'>Junio</option>
							<option  value='7'>Julio</option>
							<option  value='8'>Agosto</option>
							<option  value='9'>Septiembre</option>
							<option  value='10'>Octubre</option>
							<option  value='11'>Noviembre</option>
							<option  value='11'>Diciembre</option>
						</select>
					</div>
					<div class="col-md-4">
						<select name="selAnio" id="selAnio" class="form-control"> 
							<option value=''>Año</option>
							<option  value='2015'>2015</option>
							<option  value='2016'>2016</option>
						</select>
					</div>
				</div>
			</div>
			<div class="form-group">
				 <div class="row">
					<div class="col-md-5"></div>
					<div class="col-md-6">
						 <div id="myId" class="dropzone dz-clickable" style="width:120px; height:120px" >
							<div class="dz-default dz-message"><span>Archivo clientes</span></div>
						 </div>
					 </div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-md-5"></div>
					<div class="col-md-6">
						<div id="uplMovimientos" class="dropzone dz-clickable" style="width:120px; height:120px">
							<div class="dz-default dz-message"><span>Archivo movimientos</span></div>
						</div>
					</div>
				</div>
			</div>
		</div>


		<div id="divResultado" class="panel-body collapse in">
			<div class="form-group">
				 <div class="row">
					<div class="col-md-5"></div>
					<div class="col-md-6">
						<a id="linkMovimientos" href="hola.htm"><img src="<?= base_url() ?>assets/img/text-file-icon.jpg" width="120px" alt="CiteCompra" />
						<span id="spanMovimientos">Hola</span></a>
					 </div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-md-5"></div>
					<div class="col-md-6">
						<a id="linkAlicuotas" href="hola.htm"><img src="<?= base_url() ?>assets/img/text-file-icon.jpg" width="120px" alt="CiteCompra" />
						<span id="spanAlicuotas">Hola</span></a>
					</div>
				</div>
			</div>
		</div>


	</div>
	<div class="panel-footer">
		<div class="row">
			<div class="col-sm-6 col-sm-offset-3">
				<div class="btn-toolbar">
					<input type="button" id="btnUpload" class="btn-primary btn" value="Upload"></input>
					<input type="button" id="btnGuardar" class="btn-primary btn" value="Guardar"></input>
					<input type="button" value="Cancel" id="btnCancelar" class="btn-default btn"></input>
				</div>
			</div>
		</div>
	</div>
</div>
<input type="hidden" id="hdnProveedores" name="hdnProveedore"></input>
<input type="hidden" id="hdnMovimientos" name="hdnMovimientos"></input>
<div id="divPreload">
  <img src="<?= base_url() ?>assets/img/ajax-loader.gif" class="ajax-loader">
</div>
<?php echo form_close(); ?>
<link rel='stylesheet' type='text/css' href='<?= base_url() ?>assets/plugins/dropzone/css/dropzone.css' /> 
<link rel='stylesheet' type='text/css' href='<?= base_url() ?>assets/css/loading.css' /> 

<script type='text/javascript' src='<?= base_url() ?>assets/plugins/form-inputmask/jquery.inputmask.bundle.min.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/jquery.dataTables.min.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/form-parsley/parsley.min.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/jquery.tabletojson.js'></script>
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/TableTools.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/jquery.tabletojson.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/dataTables.editor.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/dataTables.editor.bootstrap.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/dataTables.bootstrap.js'></script>
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/dropzone/dropzone.js'></script>
<script type="text/javascript">
	var baseUrl= "<?= base_url() ?>";
</script>
<script type='text/javascript' src='<?= base_url() ?>assets/aexo-manager/views/jsCitiCompraVta.js'></script>
