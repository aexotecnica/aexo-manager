
$( document ).ready(function() {
	

	$('#btnNuevo').click(function() {
		$('#formBody').attr("action", baseUrl + "index.php/insumos/nuevo");
		$('#formBody').submit();
	});

	$("#btnModificar").click(function () {
		if ($('#idInsumo').val() != ''){
			$("#formBody").attr("action", baseUrl + "index.php/insumos/modificar");
			$("#formBody").submit();
		}else {
			bootbox.alert("Seleccione una Parte a modificar");
		}
	});


	$("#btnEliminar").click(function () {
		
		if ($('#idInsumo').val() != ''){
			bootbox.confirm("Eliminará el subconjunto seleccionado. ¿Está serguro?", function(result) {
				if (result == true) {
					
					$("#formBody").attr("action", baseUrl + "index.php/insumos/eliminar");
					$("#formBody").submit();
				}
			});
		}else {
			bootbox.alert("Seleccione un Comprobante a Eliminar");
		} 
	});


	$("#btnArbol").click(function () {
		if ($('#idInsumo').val() != ''){
			$("#formBody").attr("action", baseUrl + "index.php/insumos/arbol");
			$("#formBody").submit();
		}else {
			bootbox.alert("Seleccione un insumo a visualizar");
		}
	});	


	$('#dtInsumos').dataTable({

		"sDom": "<'row'<'col-sm-6'T><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        "bProcessing": false,
        "bServerSide": false,
        "bAutoWidth": false,
		"iDisplayLength": 5,
        "sPaginationType": "bootstrap",
        "oTableTools": {
        	"sRowSelect": "single",
			"sSwfPath": baseUrl + "assets/plugins/datatables-1-10-4/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
        }
    });


	$('#dtInsumos tbody').on( 'click', 'tr', function () {
		$("#idInsumo").val($(this).children("td:eq(0)").text());
		$("#codigoInsumo").val($(this).children("td:eq(1)").text());
	} );

	$('.dataTables_filter input').addClass('form-control').attr('placeholder','Search...');
	$('.dataTables_length select').addClass('form-control');


});