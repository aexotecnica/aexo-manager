
$( document ).ready(function() {
	var idProducto=0;
	$('#dtStock').dataTable({

		"sDom": "<'row'<'col-sm-6'T><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        "bProcessing": false,
        "bServerSide": false,
        "bAutoWidth": false,

        "sPaginationType": "bootstrap",
        "oTableTools": {
        	"sRowSelect": "single",
			"sSwfPath": "<?= base_url() ?>assets/plugins/datatables-1-10-4/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
        }
    });

    $('#dtFaltantesGral').dataTable({

        "sDom": "<'row'<'col-sm-6'T><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        "bProcessing": false,
        "bServerSide": false,
        "bAutoWidth": false,

        "sPaginationType": "bootstrap",
        "oTableTools": {
            "sRowSelect": "none",
            "sSwfPath": "<?= base_url() ?>assets/plugins/datatables-1-10-4/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
        }
    });

    $('#dtStock tbody').on( 'click', 'tr', function () {
        $("#idStockPartes").val($(this).children("td:eq(0)").text());
        $("#idProducto").val($(this).children("td:eq(0)").text());
    } );

    $("#btnDetalle").click(function(){
    	$('#dtProductosModal').DataTable().ajax.url(baseUrl + "index.php/stock/loadFaltanteXProducto/" + $("#idProducto").val() + "/").load();
        $('#myModal').modal('show');
    });

    $("#porParte").click(function(){
        $('#dtProductosModal').DataTable().ajax.url(baseUrl + "index.php/stock/loadFaltanteXProducto/" + $("#idProducto").val() + "/1/" ).load();
    });

    $("#porInsumo").click(function(){
        $('#dtProductosModal').DataTable().ajax.url(baseUrl + "index.php/stock/loadFaltanteXProducto/" + $("#idProducto").val() + "/" ).load();
    });


	$('#dtProductosModal').dataTable({

		"sDom": "<'row'<'col-sm-6'T><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        "bProcessing": false,
        "bServerSide": false,
        "bAutoWidth": false,
		"sAjaxSource": baseUrl + "index.php/stock/loadFaltanteXProducto/",
		"iDisplayLength": 15,
        "sPaginationType": "bootstrap",
        "oTableTools": {
        	"sRowSelect": "single", 
        	"aButtons": []
        },
        "columnDefs": [
            {
                "targets": [3],
                "searchable": false
            }

        ]
    });
	tablaModal = $('#dtProductosModal').DataTable();

});