
var tblParte;

var colsPartes = {
    id:              0,
    nombre:          1,
    cantidad:        2,
    cant_hide:       3,
    estadosSelect:   4,
    estadoText:      5,
	estadoAntSelect: 6,
    estadoAntText:   7,
};

$( document ).ready(function() {

	$('#txtFechaPedido').datepicker({format: 'dd/mm/yyyy', language: 'es'});
	$('#txtFechaEntrega').datepicker({format: 'dd/mm/yyyy', language: 'es'});
    $(".cantidad").inputmask("9");
    //construirSelEstados();

    if (!imprimirVisible)
        $('#btnImprimir').hide();       

	$('.mask').inputmask();
	$("#btnCancelar").click(function(){
		window.location.href = baseUrl + "index.php/ordenPedido";
	});

    $("#btnAgregarProducto").click(function(){
        $('#myModal').modal('show');
    });

    

	$('#dtParteModal').dataTable({

		"sDom": "<'row'<'col-sm-6'T><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        "bProcessing": false,
        "bServerSide": false,
        "bAutoWidth": false,
		"sAjaxSource": baseUrl + "index.php/partes/loadPartesAll",
		"iDisplayLength": 5,
        "sPaginationType": "bootstrap",
        "oTableTools": {
        	"sRowSelect": "single", 
        	"aButtons": []
        },
        "columnDefs": [
            {
                "targets": [2],
                "visible": false,
                "searchable": false
            }

        ]
    });

	tblParte = $('#dtPartes').dataTable({
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
        	"aButtons": []
        },
        "columnDefs": [
            {
                "targets": [colsPartes.cant_hide],
                "visible": false,
                "searchable": false
            }

        ]
    });


    $('#dtParteModal tbody').on( 'click', 'tr', function () {
        $("#dtParteModal").val($(this).children("td:eq(0)").text());
		$("#descripcionModal").val($(this).children("td:eq(1)").text());
		$("#codigoModal").val($(this).children("td:eq(2)").text());
		
    } );    

    $('#btnAgregar').click(function() {
    	var talbaProductos = $('#dtPartes').DataTable();

        var selEstados = construirSelEstados("selEstados_" + tblParte.fnGetData().length);
        //alert(selEstados);
    	talbaProductos.row.add([$("#dtParteModal").val(),
    							$("#descripcionModal").val(),
                                '<input type="text" size="2" value="1" onchange="javascript:cambiaText(this);" name="txtRow'+ tblParte.fnGetData().length +'" id="txtRow'+ tblParte.fnGetData().length +'" required="required" class="form-control textoCorto cantidad">',
    							'1',
								selEstados,
                                "",
                                selEstados,
                                ""]).draw();


        $("#myModal").modal('hide');
        $(".cantidad").inputmask("9");
    });

    $('#btnAceptar').click(function() {
    	var talbaProductos = $('#dtPartes').DataTable();

    	var colCantNoEditable = talbaProductos.column(colsPartes.cant_hide);
    	colCantNoEditable.visible(true);

		var colCantEditable = talbaProductos.column(colsPartes.cantidad);
    	colCantEditable.visible(false); 

        var colEstadosSelect = talbaProductos.column(colsPartes.estadosSelect);
        colEstadosSelect.visible(false); 

        var colEstadoText = talbaProductos.column(colsPartes.estadoText);
        colEstadoText.visible(true); 

        var colEstadoAntSelect = talbaProductos.column(colsPartes.estadoAntSelect);
        colEstadoAntSelect.visible(false); 

        var colEstadoAntText = talbaProductos.column(colsPartes.estadoAntText);
        colEstadoAntText.visible(true); 

		var table = $('#dtPartes').tableToJSON(); // Convert the table into a javascript object
        
        $('#formBody').parsley( 'validate' );
        //alert(JSON.stringify(table));
		$.post( baseUrl + "index.php/ordenCompra/guardarOrden", { 
			nroPedido: 		$('#txtNroPedido').val(), 
			idCliente: 		$('#txtIdCliente').val(),
			fechaPedido: 	$('#txtFechaPedido').val(), 
			fechaEntrega: 	$('#txtFechaEntrega').val(), 
			estadoOrden: 	$('#selEstadoOrdenPedido').val(), 
            precioTotal:    $('#txtPrecioTotal').val(), 
            costoTotal:    $('#txtCostoTotal').val(), 
			productos: 		JSON.stringify(table)
		}).done(function(data) {
		    var obj = jQuery.parseJSON(data);
		    $('#txtNroPedido').removeAttr("readonly");
		    $('#txtNroPedido').val(obj.nroUltimoPedido);
		    $('#txtNroPedido').attr("readonly","readonly");
            $('#btnImprimir').show();  
            bootbox.alert("La orden se guardo correctamente.");
		});

    });

    $("#txtClienteDescripcion").typeahead({
            source: function (query, process) {
                var clientes = [];
                map = {};
                if (query.length > 3) {
                // This is going to make an HTTP post request to the controller
                return $.post(baseUrl + 'index.php/clientes/jsonConsultarCliente', { query: query }, function (data) {

                    $.each(eval(data), function (i, cliente) {
                        map[cliente.nombre] = cliente;
                        clientes.push(cliente.nombre);
                    });
                    // Process the details
                    process(clientes);

                });
            }
        },
        updater: function (item) {
            var selectedShortCode = map[item].idCliente;
            // Set the text to our selected id
            $("#txtIdCliente").val(selectedShortCode);
            return item;
        }
    });    

});

function cambiaText(text){
    var talbaProductos = $('#dtPartes').DataTable();
    var lastChar = text.id.substr(text.id.length - 1); // => "1"
    var cantidad = 0;
    var costo = 0;
    var precioPrd = 0;
    tblParte.fnUpdate(text.value, lastChar, colsPartes.cant_hide);
	precioPrd = eval(talbaProductos.cell(lastChar,colsPartes.precio_hide).data());
	cantidad= text.value;

	$("#txtPrecioRow" + lastChar).val(precioPrd * cantidad);
	tblParte.fnUpdate(precioPrd * cantidad, lastChar, colsPartes.precioXCant_hide);

	var precioTotal = 0;
	for (i=0; i<tblParte.fnGetData().length; i++){
		precioTotal += parseFloat($("#txtPrecioRow" + i).val());
		$("#txtPrecioTotal").val(precioTotal);
	}
 }

 function seleccionarEstado(combo){
    var talbaProductos = $('#dtPartes').DataTable();
    var numRow = combo.id.substr(combo.id.length - 1);
    tblParte.fnUpdate(combo.value, numRow, colsPartes.estadoText);
 }

 function construirSelEstados(nombreSel){
 	var mihtml = "";
	$.ajax({
		method: "POST",
		cache: false,
		url: baseUrl + "index.php/estadosPartes/loadJsonEstados/",
		async: false,
		success: function (estadosJsno) {
		    var model = {
		        estados: JSON.parse(estadosJsno),
		        idSelEstados: nombreSel
		    }
	        mihtml = $("#estadosTmpl").tmpl(model).html();//.appendTo("#divPrueba");
		}
	});
    
    return mihtml;
 }


