<?php echo form_open( $actionDelForm, 'method="post" id="formBody" autocomplete="off" enctype="multipart/form-data"'); ?>
<div id="page-heading">
	<ol class="breadcrumb">
		<li><a href="index.htm">Dashboard</a></li>
		<li>Extras</li>
		<li class="active">Invoice</li>
	</ol>

	<h1>Inovice</h1>
</div>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="clearfix">
						<div class="pull-left">
							<h4>Nro de Pedido # 
								<strong><?=$nroPedido?></strong>
							</h4>
						</div>
						<div class="pull-right">
							<h4 class="text-right"><img src="<?=base_url()?>/assets/aexo-manager/img/logo_aexo_transparente_chico.png" alt="Aexo"></h4>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<h3 style="background: #85c744; padding: 5px 10px; color: #fff; border-radius: 1px; margin: 20px 0 20px; text-align:center">Orden de Pedido</h3>
							<div class="pull-left">
								<address>
    							    <strong>Cliente: Arauco Argentina SA</strong><br>
    							    Domicilio: Pedro Balia 3956<br>
    							    Localidad: CABA<br>
    							    Telefono: 49116269<br>
    							    CUIT: 33-56324011-9
    							</address>
    						</div>
							<div class="pull-right">
								<ul class="text-right list-unstyled">
									<li><strong>Fecha de Pedido:</strong> 14/11/2013</li>
									<li><strong>Fecha de Entrega:</strong> 24/12/2013</li>
									<li><strong>IVA:</strong>Responsable Inscripto</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="table-responsive" style="height:400px">
								<table class="table table-bordered table-striped table-hover">
									<thead>
										<th>#</th>
										<th>Codigo</th>
										<th>Cantidad</th>
										<th>Descripcion</th>
										<th>Precio</th>
										<th>Precio Unitario</th>
									</thead>
									<tbody>
										<tr>
											<td>1</td>
											<td>417K</td>
											<td>4</td>
											<td>Valvula Horizontal 4'' de Al. AC.</td>
											<td>$1423.00</td>
											<td>$4423.00</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3 col-md-offset-9">
							<p class="text-right">Unidades: 4</p>
							<hr>
							<h3 class="text-right">Total: $ 4423.24</h3>
						</div>
					</div>
					<div class="panel-footer hidden-print">
						<div class="pull-right">
							<a href="#" id="btnImprimir" class="btn btn-inverse"><i class="fa fa-print"></i></a>
							<a href="#" class="btn btn-primary">Submit</a>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</div> <!-- container -->
<?php echo form_close(); ?>

<script type='text/javascript'>

$( document ).ready(function() {
	

	$('#btnImprimir').click(function() {
		alert("Se imprime");
		$('#formBody').attr("action", "<?= base_url() ?>index.php/ordenPedido/reporteImprimir");
		$('#formBody').submit();
	});

});
</script>