<?php
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Aexo-Manager</title>
	<script type='text/javascript' src='<?= base_url() ?>assets/js/jquery-1.10.2.min.js'></script> 
	<script type='text/javascript' src='<?= base_url() ?>assets/js/jqueryui-1.10.3.min.js'></script> 
	<script type='text/javascript' src='<?= base_url() ?>assets/plugins/form-typeahead/typeahead.min.js'></script>
	<script type='text/javascript' src='<?= base_url() ?>assets/js/bootstrap.min.js'></script> 

</head>

<body class="">

	<div id="page-content">
		<div id='wrap'>
			<input type="text" id="txtParte" name="txtParte" class="form-control autocomplete" autocomplete="off" ></input>
		</div> 
	</div>

</body>
<script type='text/javascript'>

	$( document ).ready(function() {
	    $("#txtParte").typeahead({
	        source: function (query, process) {
	            var partes = [];
	            map = {};
	            if (query.length > 3) {
	                // This is going to make an HTTP post request to the controller
	                return $.post('<?= base_url() ?>index.php/despiece/jsonConsultarParte', { query: query }, function (data) {
	                    // Loop through and push to the array
	                    $.each(data, function (i, parte) {
	                        map[parte.descripcion] = parte;
	                        partes.push(parte.descripcion);
	                    });
	                    // Process the details
	                    process(partes);

	                });
	            }
	        },
	        updater: function (item) {
	            var selectedShortCode = map[item].IdParte;

	            // Set the text to our selected id
	            $("#idParte").val(selectedShortCode);
	            return item;
	        }
	    });

	});

</script>
</html>