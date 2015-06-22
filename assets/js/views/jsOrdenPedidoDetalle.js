// Calendar
// If screensize > 1200, render with m/w/d view, if not by default render with just title
var tblProductos;
$( document ).ready(function() {

	$('#txtFechaPedido').datepicker({format: 'dd/mm/yyyy', language: 'es'});
	$('#txtFechaEntrega').datepicker({format: 'dd/mm/yyyy', language: 'es'});

	$('.mask').inputmask();
	$("#btnCancelar").click(function(){
		window.location.href = baseUrl + "index.php/ordenPedido";
	});

    $("#btnAgregarProducto").click(function(){
        $('#myModal').modal('show');
    });


	$('#dtProductosModal').dataTable({

		"sDom": "<'row'<'col-sm-6'T><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        "bProcessing": false,
        "bServerSide": false,
        "bAutoWidth": false,
		"sAjaxSource": baseUrl + "index.php/productos/loadProductos",
		"iDisplayLength": 5,
        "sPaginationType": "bootstrap",
        "oTableTools": {
        	"sRowSelect": "single", 
        	"aButtons": []
        }
    });

	tblProductos = $('#dtProductos').dataTable({
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
				//"sSwfPath": baseUrl + "assets/plugins/datatables-1-10-4/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
	        },
	        "columnDefs": [
	            {
	                "targets": [ 3, 5,8],
	                "visible": false,
	                "searchable": false
	            }

	        ]
    });


    $('#dtProductosModal tbody').on( 'click', 'tr', function () {
        $("#idProductoModal").val($(this).children("td:eq(0)").text());
		$("#descripcionModal").val($(this).children("td:eq(1)").text());
		$("#codigoModal").val($(this).children("td:eq(2)").text());
		$("#costoModal").val($(this).children("td:eq(3)").text());
		
    } );    

    $('#btnAgregar').click(function() {
    	var talbaProductos = $('#dtProductos').DataTable();
    	//alert(tblProductos.fnGetData().length);

    	talbaProductos.row.add([$("#idProductoModal").val(),
    							$("#descripcionModal").val(),
                                '<input type="text" size="2" onchange="javascript:cambiaText(this);" name="txtRow'+ tblProductos.fnGetData().length +'" id="txtRow'+ tblProductos.fnGetData().length +'" required="required" class="form-control textoCorto">',
    							'0',
    							$("#costoModal").val(),
    							$("#costoModal").val(),
                                '<input type="text" size="2"  name="txtMargenRow'+ tblProductos.fnGetData().length +'" id="txtMargenRow'+ tblProductos.fnGetData().length +'" required="required" class="form-control textoCorto" value="30">',
                                '<input type="text" size="2"  name="txtPrecioRow'+ tblProductos.fnGetData().length +'" id="txtPrecioRow'+ tblProductos.fnGetData().length +'" required="required" class="form-control">',
                                '0']).draw();


        $("#myModal").modal('hide'); 
    });

    $('#btnAceptar').click(function() {
    	var talbaProductos = $('#dtProductos').DataTable();

    	var colCantNoEditable = talbaProductos.column(3);
    	colCantNoEditable.visible(true);

		var colCantEditable = talbaProductos.column(2);
    	colCantEditable.visible(false);    

		var table = $('#dtProductos').tableToJSON(); // Convert the table into a javascript object

		$('#formBody').parsley( 'validate' );

		$.post( baseUrl + "index.php/ordenPedido/guardarOrden", { 
			nroPedido: 		$('#txtNroPedido').val(), 
			idCliente: 		$('#txtIdCliente').val(),
			fechaPedido: 	$('#txtFechaPedido').val(), 
			fechaEntrega: 	$('#txtFechaEntrega').val(), 
			estadoOrden: 	$('#selEstadoOrdenPedido').val(), 
			productos: 		JSON.stringify(table)
		}).done(function(data) {
		    var obj = jQuery.parseJSON(data);
		    $('#txtNroPedido').removeAttr("readonly");
		    $('#txtNroPedido').val(obj.nroUltimoPedido);
		    $('#txtNroPedido').attr("readonly","readonly");

		});

    });

    $("#txtClienteDescripcion").typeahead({
            source: function (query, process) {
                var clientes = [];
                map = {};
                if (query.length > 3) {
                // This is going to make an HTTP post request to the controller
                return $.post(baseUrl + 'index.php/clientes/jsonConsultarCliente', { query: query }, function (data) {
                    // Loop through and push to the array
                    //alert(eval(data));
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
    	var talbaProductos = $('#dtProductos').DataTable();
		var lastChar = text.id.substr(text.id.length - 1); // => "1"
    	var cantidad = 0;
        var costo = 0;
        var precioPrd = 0;
        tblProductos.fnUpdate(text.value, lastChar, 3);

        costo = eval(talbaProductos.cell(lastChar,5).data());
        cantidad= text.value;
        margen = $("#txtMargenRow" + lastChar).val();

    	talbaProductos.cell(lastChar,4).data( cantidad * costo).draw();

        costoLinea= talbaProductos.cell(lastChar,4).data();
        precioPrd = (margen * costoLinea/100) + costoLinea;
        talbaProductos.cell(lastChar,7).data(precioPrd).draw();

    	var costoTotal = 0;
        var precioTotal = 0;
    	for (i=0; i<tblProductos.fnGetData().length; i++){
    		costoTotal += eval(talbaProductos.cell(i,4).data());
			$("#txtCostoTotal").val(costoTotal);

            precioTotal += eval(talbaProductos.cell(i,7).data());
            $("#txtPrecioTotal").val(precioTotal);
    	}

    	//$("#txtCostoTotal").val(eval(talbaProductos.cell(lastChar,5).data()) * text.value);
    }
