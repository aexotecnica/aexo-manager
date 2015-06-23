<style media="all" type="text/css">
.alignRight { text-align: right; }
</style>
<!-- <link href="<?= base_url() ?>assets/less/styles.less" rel="stylesheet/less" media="all">  -->
<link rel="stylesheet" href="<?= base_url() ?>assets/css/styles.css">
<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600' rel='stylesheet' type='text/css'>

<link href='<?= base_url() ?>assets/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='styleswitcher'> 
<link href='<?= base_url() ?>assets/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='headerswitcher'> 

<link rel='stylesheet' type='text/css' href='<?= base_url() ?>assets/plugins/datatables/dataTables.css' /> 
<link rel='stylesheet' type='text/css' href='<?= base_url() ?>assets/plugins/fullcalendar/fullcalendar.css' />
<link rel='stylesheet' type='text/css' href='<?= base_url() ?>assets/plugins/form-nestable/jquery.nestable.css' />
	
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="clearfix">
						<div class="pull-left" style="width:45%">
							<h4>Nro de Pedido # 
								<strong><?=$ordenPedido->nroPedido?></strong>
							</h4>
						</div>
						<div class="pull-right" style="width:45%">
							<h4 class="text-right"><img src="<?=base_url()?>/assets/aexo-manager/img/logo_aexo_transparente_chico.png" alt="Aexo"></h4>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<h3 style="background: #85c744; padding: 5px 10px; color: #fff; border-radius: 1px; margin: 20px 0 20px; text-align:center">Orden de Pedido</h3>
							<div class="pull-left" style="width:45%">
								<div>
    							    <strong>Cliente: <?=$cliente->nombre?></strong><br>
    							    Domicilio: <?=$cliente->calle . ' ' . $cliente->numero?><br>
    							    Localidad: <?=$cliente->localidad?><br>
    							    Telefono: <?=$cliente->telefono_1?><br>
    							    CUIT: <?=$cliente->cuit?>
    							</div>
    						</div>
							<div class="pull-right" style="width:45%">
								<ul class="text-right list-unstyled">
									<li><strong>Fecha de Pedido:</strong> <?=$ordenPedido->fechaPedido?></li>
									<li><strong>Fecha de Entrega:</strong> <?=$ordenPedido->fechaEntrega?></li>
									<li><strong>IVA:</strong>Responsable Inscripto</li>
								</ul>
							</div>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-12">
							<div class="table-responsive" style="height:400px">
								<table class="table table-bordered table-striped table-hover" style="font-size: 11px">
									<tr>
										<th>#</th>
										<th>Codigo</th>
										<th>Cantidad</th>
										<th>Descripcion</th>
										<th>Precio</th>
										<th>Precio Unitario</th>
									</tr>
									<tbody>
									<?
									if ($productos != NULL)
										$cantTotal=0;
										foreach ($productos as $val){
											$cantTotal += $val->cantidad;?>	
											<tr>
												<td>1</td>
												<td><?=$val->codigo?></td>
												<td style="text-align:center;"><?=$val->cantidad?></td>
												<td><?=$val->producto_descripcion?></td>
												<td style="text-align:right;">$<?=$val->precio?></td>
												<td style="text-align:right;">$<?=($val->precio / $val->cantidad)?></td>
											</tr>
										<?}?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3 col-md-offset-9">
							<p class="text-right">Unidades: <?=$cantTotal?></p>
							<hr>
							<h3 class="text-right">Total: $ <?=$ordenPedido->precioTotal?></h3>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</div> <!-- container -->