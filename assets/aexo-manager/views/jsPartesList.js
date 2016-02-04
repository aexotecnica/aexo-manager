var PARTE_STOCK = -1000;
var PARTE_PRODUCTO = -2000;
var PARTE_DESPIECE = -3000;

$( document ).ready(function() {
	

	$('#btnNuevo').click(function() {
		$('#formBody').attr("action", baseUrl + "index.php/partes/nuevo");
		$('#formBody').submit();
	});

	$("#btnModificar").click(function () {
		if ($('#idParte').val() != ''){
			$("#formBody").attr("action", baseUrl + "index.php/partes/modificar");
			$("#formBody").submit();
		}else {
			bootbox.alert("Seleccione una Parte a modificar");
		}
	});


	$("#btnEliminar").click(function () {
		
		if ($('#idParte').val() != ''){
			bootbox.confirm("Eliminará el comprobante seleccionado. ¿Está serguro?", function(result) {
				if (result == true) {
					
					$.ajax({
						method: "POST",
						cache: false,
						url: baseUrl + "index.php/partes/verificarParte",
						async: false,
						data: {idParte: $('#idParte').val()},
						success: function (data) {
							jsonResult = data;
							//alert(data);
							if (data > 0){
								$("#formBody").attr("action", baseUrl + "index.php/partes/eliminar");
								$("#formBody").submit();
							}else if (data == PARTE_STOCK){
								bootbox.alert("Existe Stock de esta parte, por favor elimine el stock.");
							}else if (data == PARTE_PRODUCTO){
								bootbox.alert("Existe un producto cuya parte final es la seleccionada.");
							}else if (data == PARTE_DESPIECE){
								bootbox.alert("Existe un despiece que utiliza la parte seleccionada.");
							}
						},
					    error: function(XMLHttpRequest, textStatus, errorThrown) { 
					        	alert("Status: " + textStatus); alert("Error: " + errorThrown); 
						}
					});

					
				}
			});
		}else {
			bootbox.alert("Seleccione un Comprobante a Eliminar");
		} 
	});


	$('#dtPartes').dataTable({

		"sDom": "<'row'<'col-sm-6'T><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        "bProcessing": false,
        "bServerSide": true,
        "bAutoWidth": false,
		"sAjaxSource": baseUrl + "index.php/partes/loadPartes",
		"iDisplayLength": 5,
        "sPaginationType": "bootstrap",
        "oTableTools": {
        	"sRowSelect": "single",
			"sSwfPath": baseUrl + "assets/plugins/datatables-1-10-4/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
        }
    });


	$('#dtPartes tbody').on( 'click', 'tr', function () {
		$("#idParte").val($(this).children("td:eq(0)").text());
	} );

	$('.dataTables_filter input').addClass('form-control').attr('placeholder','Search...');
	$('.dataTables_length select').addClass('form-control');


});