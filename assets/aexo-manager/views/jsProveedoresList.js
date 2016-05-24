$( document ).ready(function() {
	

	$('#btnNuevo').click(function() {
		$('#formBody').attr("action", baseUrl + "index.php/proveedores/nuevo");
		$('#formBody').submit();
	});

	$("#btnModificar").click(function () {
		if ($('#idProveedor').val() != ''){
			$("#formBody").attr("action", baseUrl + "index.php/proveedores/modificar");
			$("#formBody").submit();
		}else {
			bootbox.alert("Seleccione una cliente a modificar");
		}
	});


	$("#btnEliminar").click(function () {
		
		if ($('#idProveedor').val() != ''){
			bootbox.confirm("Eliminará el comprobante seleccionado. ¿Está serguro?", function(result) {
				if (result == true) {
					
					$("#formBody").attr("action", baseUrl + "index.php/proveedores/eliminar");
					$("#formBody").submit();
				}
			});
		}else {
			bootbox.alert("Seleccione un cliente a Eliminar");
		} 
	});


	$('#dtproveedores').dataTable({
		"sDom": "<'row'<'col-sm-6'T><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",		
        "sPaginationType": "bootstrap",
        "oLanguage": {
        	"sLengthMenu": "_MENU_ records per page",
        },
        "bProcessing": true,
        "bServerSide": false,
        "bAutoWidth": false,
        "oTableTools": {
        	"sRowSelect": "single",
			"sSwfPath": baseUrl + "assets/plugins/datatables-1-10-4/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
        }
    });


	$('#dtproveedores tbody').on( 'click', 'tr', function () {
		$("#idProveedor").val($(this).children("td:eq(0)").text());
	} );

	$('.dataTables_filter input').addClass('form-control').attr('placeholder','Search...');
	$('.dataTables_length select').addClass('form-control');

});