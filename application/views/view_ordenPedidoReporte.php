<?php echo form_open( $actionDelForm, 'method="post" id="formBody" autocomplete="off" enctype="multipart/form-data"'); ?>
<div id="page-heading">
	<ol class="breadcrumb">
		<li><a href="index.htm">Dashboard</a></li>
		<li>Extras</li>
		<li class="active">Orden de pedido</li>
	</ol>

	<h1>Inovice</h1>
</div>

<?echo $reporteHTML; ?>

<?php echo form_close(); ?>

<script type='text/javascript'>

$( document ).ready(function() {
	

	$('#btnImprimir').click(function() {
		alert("Se imprime");
		window.open("<?= base_url() ?>index.php/ordenPedido/reporteImprimir/<?=$ordenPedido->idOrdenPedido?>", "_blank");
	});

});
</script>