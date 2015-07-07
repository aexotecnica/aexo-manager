// Calendar
// If screensize > 1200, render with m/w/d view, if not by default render with just title

$( document ).ready(function() {

	$('.mask').inputmask();

    $('#txtFechaDesde').datepicker({format: 'dd/mm/yyyy', language: 'es'});
    $('#txtFechaHasta').datepicker({format: 'dd/mm/yyyy', language: 'es'});

    $("#dialog-costo").dialog({
        autoOpen: false,
        height: 350,
        width: 500,
        modal: true
    });


    var dataCosto = $('#gdCosto').dataTable({
        "sDom": "<'row'<'col-sm-12'T><'col-sm-12'f>r>t<'row'<'col-sm-12'i><'col-sm-12'p>>",
        "bProcessing": false,
        "bServerSide": false,
        "bAutoWidth": false,
        "sPaginationType": "bootstrap",
        "oTableTools": {
            "sRowSelect": "single",
            "aButtons": []
        }
    });

    $('.dataTables_filter input').addClass('form-control').attr('style', 'display:none');
    $('.dataTables_length select').addClass('form-control');
    
    $('#gdCosto tbody').on( 'click', 'tr', function () {
        var tablaCosto = $('#gdCosto').DataTable();

        var indice = tablaCosto.row(this).index();
        $("#txtModificaCosto").val(indice);
        $("#txtFechaDesde").val($(this).children("td:eq(0)").text());
        $("#txtFechaHasta").val($(this).children("td:eq(1)").text());
        $("#txtImporte").val($(this).children("td:eq(2)").text());
    });

    $("#btnAgregar").click(function () {
        $("#txtIdCosto").val("");
        $("#txtFechaDesde").val("");
        $("#txtFechaHasta").val("");
        $("#txtImporte").val("");
        $("#txtModificaCosto").val("");
        $("#dialog-costo").dialog("open");
    });

    $("#btnModificar").click(function () {
        $("#dialog-costo").dialog("open");
    });


    $("#btnCerrar").click(function () {
        $("#dialog-costo").dialog("close");
    });

    $("#btnEliminar").click(function () {
        var table = $('#gdCosto').DataTable();
        table.row('.active').remove().draw( false );
    });

    $("#btnAceptar").click(function () {

        var tablaCosto = $('#gdCosto').DataTable();
        if ($("#txtModificaCosto").val() == "") {
            tablaCosto.row.add([$("#txtFechaDesde").val(),
                                    $("#txtFechaHasta").val(),
                                    $("#txtImporte").val()
                                    ]).draw();

        }else {
            dataCosto.fnUpdate($("#txtFechaDesde").val(), $("#txtModificaCosto").val(), 0);
            dataCosto.fnUpdate($("#txtFechaHasta").val(), $("#txtModificaCosto").val(), 1);
            dataCosto.fnUpdate($("#txtImporte").val(), $("#txtModificaCosto").val(), 2);
        }
        

        $("#dialog-costo").dialog("close");


    });

	$("#btnCancelar").click(function(){
		window.location.href = baseUrl + "index.php/productos";
	});

	$("#selParteFinal").change(function() {

		$("#txtDescripcion").val($('option:selected', this).text() );
		$("#txtCodigo").val($('option:selected', this).attr("codigo") );
	});

    $("#btnGuardar").click(function () {
        var table = $('#gdCosto').tableToJSON();
        $("#txtJsonCosto").val(JSON.stringify(table));

        $("#formBody").attr("action", baseUrl + "index.php/productos/guardar");
        $("#formBody").submit();
    });

});
