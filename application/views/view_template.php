<?php
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Aexo-Manager</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Avant">
	<meta name="author" content="The Red Team">
	<style media="all" type="text/css">
	.alignRight { text-align: right; }
	</style>
	<!-- <link href="<?= base_url() ?>assets/less/styles.less" rel="stylesheet/less" media="all">  -->
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/styles.css?<?php echo time(); ?>">
	<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600' rel='stylesheet' type='text/css'>

	<link href='<?= base_url() ?>assets/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='styleswitcher'> 
	<link href='<?= base_url() ?>assets/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='headerswitcher'> 
	
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries. Placeholdr.js enables the placeholder attribute -->
	<!--[if lt IE 9]>
				<link rel="stylesheet" href="<?= base_url() ?>assets/css/ie8.css">
		<script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.1.0/respond.min.js"></script>
				<script type="text/javascript" src="<?= base_url() ?>assets/plugins/charts-flot/excanvas.min.js"></script>
				<![endif]-->

				<!-- The following CSS are included as plugins and can be removed if unused-->
				<link rel='stylesheet' type='text/css' href='<?= base_url() ?>assets/plugins/datatables/dataTables.css' /> 
				<link rel='stylesheet' type='text/css' href='<?= base_url() ?>assets/plugins/fullcalendar/fullcalendar.css' />
				<link rel='stylesheet' type='text/css' href='<?= base_url() ?>assets/plugins/form-nestable/jquery.nestable.css' />
				

				<!-- <script type="text/javascript" src="<?= base_url() ?>assets/js/less.js"></script> -->

				<script type='text/javascript' src='<?= base_url() ?>assets/js/jquery-1.10.2.min.js'></script> 
				<script type='text/javascript' src='<?= base_url() ?>assets/js/jqueryui-1.10.3.min.js'></script> 

				<script type='text/javascript' src='<?= base_url() ?>assets/js/bootstrap.min.js'></script> 
				<script type='text/javascript' src='<?= base_url() ?>assets/js/enquire.js'></script> 
				<script type='text/javascript' src='<?= base_url() ?>assets/js/jquery.cookie.js'></script> 
				<script type='text/javascript' src='<?= base_url() ?>assets/js/jquery.nicescroll.min.js'></script> 
				<script type='text/javascript' src='<?= base_url() ?>assets/plugins/fullcalendar/fullcalendar.min.js'></script> 
				<script type='text/javascript' src='<?= base_url() ?>assets/plugins/jquery-tmpl/jquery.tmpl.min.js'></script> 

				<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables-1-10-4/media/js/jquery.dataTables.min.js'></script> 
				<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables-1-10-4/extensions/TableTools/js/dataTables.tableTools.js'></script> 

				<script type='text/javascript' src='<?= base_url() ?>assets/plugins/form-datepicker/js/bootstrap-datepicker.js'></script> 
				<script type='text/javascript' src='<?= base_url() ?>assets/plugins/form-datepicker/js/locales/bootstrap-datepicker.es.js'></script>
				<script type='text/javascript' src='<?= base_url() ?>assets/js/placeholdr.js'></script> 
				<script type='text/javascript' src='<?= base_url() ?>assets/js/application.js'></script> 
				<!--<script type='text/javascript' src='<?= base_url() ?>assets/demo/demo.js'></script> -->

				<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.0/css/bootstrap-toggle.min.css" rel="stylesheet">
				<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.0/js/bootstrap-toggle.min.js"></script> 

				<script type='text/javascript'>

				$(function(){
				/*	var notificaciones =  [{
						cantidad: 2,
						mensajes: [
							{ url: "http://ejohn.org/", mensaje: "Hay pagos a autorizar" },
							{ url: "http://ejohn.org/", mensaje: "Se vencen facturas" }
						]
					}];*/
					$.ajax({
						type:'POST',
						url:'<?php echo base_url(); ?>index.php/ajaxTemplate/traerNotificaciones',                    
						dataType:'json',
				        data:{},                    
				        cache:false,
				        success:function(aData){ 
				        	notificaciones = aData;
				        	$("#tmplNotificaciones").tmpl(notificaciones).appendTo("#notificaciones");

				        },
				        error:function(){alert("No se pudo traer las notificaciones");}
				    });
					

				});

				</script>

				<script id="tmplNotificaciones" type="text/x-jquery-tmpl">
					
					<a href="#" class="hasnotifications dropdown-toggle" data-toggle='dropdown'>
						<i class="fa fa-bell"></i>
						{{if cantidad >0 }}
							<span class="badge">${cantidad}</span>
						{{/if}}
					</a>
					<ul class="dropdown-menu notifications arrow">
						<li class="dd-header">
							<span>Tenes ${cantidad} notificaciones</span>
						</li>
						<div class="scrollthis">
							{{each mensajes}}
							<li>
								<a href="${url}" class="notification-warning active">
									<i class="fa fa-user"></i>
									<span class="msg">${mensaje}</span>
								</a>
							</li>
							{{/each}}
						</div>
					</ul>
					
				</script>

			</head>

			<body class="">

				<header class="navbar navbar-inverse navbar-fixed-top" role="banner">
					<a id="leftmenu-trigger" class="tooltips" data-toggle="tooltip" data-placement="right" title="Toggle Sidebar"></a>
					<a id="rightmenu-trigger" class="tooltips" data-toggle="tooltip" data-placement="left" title="Toggle Infobar"></a>

					<div class="navbar-header pull-left">
						<a class="navbar-brand" href="index.htm">Aexo</a>
					</div>

					<ul class="nav navbar-nav pull-right toolbar">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle username" data-toggle="dropdown"><span class="hidden-xs"><?=$nombreUsuario?> <?=$apellidoUsuario?> <i class="fa fa-caret-down"></i></span><img src="<?= base_url() ?>assets/demo/avatar/dangerfield.png" alt="Dangerfield" /></a>
							<ul class="dropdown-menu userinfo arrow">
								<li class="username">
									<a href="#">
										<div class="pull-left"><img src="<?= base_url() ?>assets/demo/avatar/dangerfield.png" alt="Jeff Dangerfield"/></div>
										<div class="pull-right"><h5><?=$nombreUsuario?> <?=$apellidoUsuario?></h5><small>Logged in as <span><?=$usuario?></span></small></div>
									</a>
								</li>
								<li class="userlinks">
									<ul class="dropdown-menu">
										<li><a href="<?= base_url() ?>index.php/login/remover" class="text-right">Sign Out</a></li>
									</ul>
								</li>
							</ul>
						</li>
						<li id="notificaciones" class="dropdown">
								<!-- ACA VAN LAS NOTIFICACIONES QUE SE SACAN DEL TEMPLATE tmplNotificaciones -->
						</li>
					</ul>
				</header>

				<div id="page-container">
					<!-- BEGIN SIDEBAR -->
					<nav id="page-leftbar" role="navigation">
						<!-- BEGIN SIDEBAR MENU -->
						<ul class="acc-menu" id="sidebar">
							<li id="search">
								<a href="javascript:;"><i class="fa fa-search opacity-control"></i></a>
								<form>
									<input type="text" class="search-query" placeholder="Search...">
									<button type="submit"><i class="fa fa-search"></i></button>
								</form>
							</li>
							<li class="divider"></li>
							<li><a href="index.htm"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>
							<li><a href="javascript:;"><i class="fa  fa-building"></i> <span>Produccion</span> </a>
								<ul class="acc-menu">
									<li><a href="<?= base_url() ?>index.php/partes"><span>Partes</span></a></li>
									<li><a href="<?= base_url() ?>index.php/insumos"><span>Insumos</span></a></li>
									<li><a href="<?= base_url() ?>index.php/productos"><span>Productos</span></a></li>
									<li><a href="<?= base_url() ?>index.php/necesidad"><span>Necesidad</span></a></li>
								</ul>
							</li>
							<li><a href="javascript:;"><i class="fa fa-shopping-cart"></i> <span>Ventas</span> </a>
								<ul class="acc-menu">
									<li><a href="<?= base_url() ?>index.php/clientes"><span>Clientes</span></a></li>
									<li><a href="<?= base_url() ?>index.php/ordenpedido"><span>Ordenes de pedido</span></a></li>
									<li><a href="<?= base_url() ?>index.php/mediosDeCobro"><span>Lista de cobros</span></a></li>
									<li><a href="<?= base_url() ?>index.php/mediosDeCobro/nuevo"><span>Nuevo cobro</span></a></li>
								</ul>
							</li>
							<li><a href="javascript:;"><i class="fa fa-shopping-cart"></i> <span>Compras</span> </a>
								<ul class="acc-menu">
									<? if ($muestraPendientes) { ?>
									<li><a href="<?= base_url() ?>index.php/mediosDePago/traerPendientesAutorizar"><span>Pagos pendientes de autorizar</span></a></li>
									<?}?>
									<li><a href="<?= base_url() ?>index.php/mediosDePago"><span>Lista de pagos</span></a></li>
									<li><a href="<?= base_url() ?>index.php/mediosDePago/nuevo"><span>Nuevo pago</span></a></li>
								</ul>
							</li>
							<li><a href="javascript:;"><i class="fa fa-briefcase"></i> <span>Cashflow</span> </a>
								<ul class="acc-menu">
									<li><a href="<?= base_url() ?>index.php/movimiento/listarMovimientos"><span>Movimientos</span></a></li>
									<li><a href="<?= base_url() ?>index.php/flujoCaja"><span>Visualizar Caja</span></a></li>
								</ul>
							</li>
						</ul>
					</ul>
					<!-- END SIDEBAR MENU -->
				</nav>

				<!-- BEGIN RIGHTBAR -->
				<div id="page-rightbar">

					<div id="widgetarea">
						<div class="widget">
							<div class="widget-heading">
								<a href="javascript:;" data-toggle="collapse" data-target="#accsummary"><h4>Pendientes de Pasar</h4></a>
							</div>
							<div class="widget-body collapse in" id="accsummary">
								<div class="widget-block" style="background: #7ccc2e; margin-top:10px;">
									<div class="pull-left">
										<small>Saldo por Cobrar Ventas</small>
										<h5><?=number_format(  $saldoVenta, 2, ".", "," );?></h5>
									</div>
									<div class="pull-right">
										<small class="text-right"></small>
										<a href="<?= base_url() ?>index.php/mediosDeCobro/traerCobros/true"><h5><small>Ver detalle</small></h5></a>
									</div>
								</div>
								<div class="widget-block" style="background: #dc8911;">
									<div class="pull-left">
										<small>Saldo por pagar Compras</small>
										<h5><?=number_format($saldoCompra, 2, ".", "," );?></h5>
									</div>
									<div class="pull-right">
										<small class="text-right"></small>
										<a href="<?= base_url() ?>index.php/mediosDePago/traerPagos/true"><h5><small>Ver detalle</small></h5></a>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
				<!-- END RIGHTBAR -->
				<div id="page-content">
					<div id='wrap'>
						<?php echo $cuerpo; ?>
					</div> <!--wrap -->
				</div> <!-- page-content -->

				<footer role="contentinfo">
					<div class="clearfix">
						<ul class="list-unstyled list-inline pull-left">
							<li>AVANT &copy; 2014</li>
						</ul>
						<button class="pull-right btn btn-inverse-alt btn-xs hidden-print" id="back-to-top"><i class="fa fa-arrow-up"></i></button>
					</div>
				</footer>

			</div> <!-- page-container -->

<!--
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

<script>!window.jQuery && document.write(unescape('%3Cscript src="<?= base_url() ?>assets/js/jquery-1.10.2.min.js"%3E%3C/script%3E'))</script>
<script type="text/javascript">!window.jQuery.ui && document.write(unescape('%3Cscript src="<?= base_url() ?>assets/js/jqueryui-1.10.3.min.js'))</script>
-->

</body>
</html>