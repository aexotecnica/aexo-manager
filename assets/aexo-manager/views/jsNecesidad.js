$( document ).ready(function() {
	

	$('#btnNuevo').click(function() {
		$('#formBody').attr("action", baseUrl + "index.php/ordenPedido/nuevo");
		$('#formBody').submit();
	});


	$('#dtNecesidad').dataTable({

		"sDom": "<'row'<'col-sm-6'T><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        "bProcessing": false,
        "bServerSide": false,
        "bAutoWidth": false,
        "bLengthChange": false, "bPaginate": false,
        "sPaginationType": "bootstrap",
        "oTableTools": {
        	"sRowSelect": "single",
			"sSwfPath": "<?= base_url() ?>assets/plugins/datatables-1-10-4/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
        }
    }).rowGrouping({bExpandableGrouping: true, asExpandedGroups: []});

    $('#dtNecesidad tbody').on( 'click', 'tr', function () {
        $("#idNecesidad").val($(this).children("td:eq(0)").text());
    } );

    //$('#dtNecesidad').dataTable({ "bLengthChange": false, "bPaginate": false}).rowGrouping({bExpandableGrouping: true});

});