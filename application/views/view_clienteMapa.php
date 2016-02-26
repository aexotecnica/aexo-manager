<?php echo form_open( $actionDelForm, 'method="post" id="formBody" autocomplete="off" enctype="multipart/form-data"'); ?>
<div id="page-heading">
	<ul class="breadcrumb">
		<li><a href="index.htm">Produccion</a></li>
		<li class="active">clientes</li>
	</ul>

	<h1>Listar Clientes</h1>
</div>
<div class="container">
	<div class="panel panel-midnightblue">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-sky">
					<div class="panel-heading">
						<h4>Clientes</h4>
						<div class="options">   
							<a href="javascript:;"><i class="fa fa-cog"></i></a>
							<a href="javascript:;"><i class="fa fa-wrench"></i></a>
							<a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
						</div>
					</div>
					<div class="panel-body collapse in">
						<div>
							<input type="text" id="addressInput" style="width:80%;" size="10"/>
							<select id="radiusSelect">
								<option value="0.5" selected>500m</option>
								<option value="1" selected>1km</option>
								<option value="5">5km</option>
								<option value="10">10km</option>
								<option value="50">50km</option>
							</select>

							<input type="button" onClick="searchLocations()" value="Search"/>
							<div><select id="locationSelect" style="width:100%;visibility:hidden"></select></div>
						</div>
				    </div>
				    <div class="row">
				        <div class="col-xs-12">
				            <div class="panel panel-danger">
				                <div class="panel-heading">
				                    <h4>Routes</h4>
				                </div>
				                <div class="panel-body">
				                	<div class="col-md-12">
										<div  id="map" style="width: 99%; height: 400px"></div>
				                	</div>    
				                </div>
				            </div>
				        </div>
				    
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
			<input type="hidden" id="idCliente" name="idCliente"></input>
		</div>
	</div>
</div>

<?php echo form_close(); ?>

<script type='text/javascript'>
var baseUrl= "<?= base_url() ?>";
</script>

<script src="https://maps.google.com/maps/api/js?sensor=false&libraries=places" type="text/javascript"></script>
<script type='text/javascript' src='<?= base_url() ?>assets/aexo-manager/views/jsClienteMapa.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/bootbox/bootbox.min.js'></script> 
<script type='text/javascript'>
load();
$( document ).ready(function() {
	

});

</script>