
var tblProductos;

var colsProductos = {
    idOrden:        0,
    idProdcuto:     1,
    nombre:         2,
    cantidad:       3,
    precio:         4
};

function calcularFactura() {
    var indice=0;
    var talbaProductos = $('#dtProductos').DataTable();
    var precioTotal=0;
    $('.checkSeleccionar').each(function () {

           if (this.checked) {
               console.log($(this).val()); 
               precio = eval(talbaProductos.cell(indice,colsProductos.precio).data());
               precioTotal += precio;
           }

           indice += 1;
    });
    $('#txtPrecioTotal').val(precioTotal);
    
}

$( document ).ready(function() {

    
	$('#txtFechaFactura').datepicker({format: 'dd/mm/yyyy', language: 'es'});
	$('#txtFechaVencimiento').datepicker({format: 'dd/mm/yyyy', language: 'es'});

    if (!imprimirVisible)
        $('#btnImprimir').hide();       

	$('.mask').inputmask();
	$("#btnCancelar").click(function(){
		window.location.href = baseUrl + "index.php/facturaVenta";
	});

    $("#btnAgregarOrden").click(function(){
        $('#myModal').modal('show');
    });

var selected = [];
	$('#dtProductosModal').dataTable({

		"sDom": "<'row'<'col-sm-6'T><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        "bProcessing": false,
        "bServerSide": false,
        "bAutoWidth": false,
		"sAjaxSource": baseUrl + "index.php/ordenPedido/loadOrdenes",
		"iDisplayLength": 5,
        "sPaginationType": "bootstrap",
        "rowCallback": function( row, data ) {
            if ( $.inArray(data.nroPedido, selected) !== -1 ) {
                $(row).addClass('selected');
            }
        },
        "oTableTools": {
        	"sRowSelect": "multi",
        	"aButtons": [],
            "sSearch": ""
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
	        }
    });
    $('.dataTables_filter input').addClass('form-control').attr('style', 'display:none');
    $('.dataTables_length select').addClass('form-control');

    var talbaProductos = $('#dtProductos').DataTable();
/*
    $('#dtProductosModal tbody').on( 'click', 'tr', function () {
        $("#idProductoModal").val($(this).children("td:eq(0)").text());
		$("#descripcionModal").val($(this).children("td:eq(1)").text());
		$("#codigoModal").val($(this).children("td:eq(2)").text());
		$("#costoModal").val($(this).children("td:eq(3)").text());
		
    } ); */   

    //ESTO ES PARA PODER GUARDAR LOS VALORES SELECCIONADOS EN UNA TABLA DE SELECCION MULTIPLE.
    $('#dtProductosModal tbody').on( 'click', 'tr', function () {
        var id = this.cells[0].textContent;
        var index = $.inArray(id, selected);
 
        if ( index === -1 ) {
            selected.push( id );
        } else {
            selected.splice( index, 1 );
        }
 
        $(this).toggleClass('selected');
    } );


    $('#btnAgregar').click(function() {
        //alert(selected[0]);
        var idsPedidos="";
        for (var i = 0; i < selected.length; i++) {
            idsPedidos += selected[i] + ",";
        }

        idsPedidos = idsPedidos.substring(0, idsPedidos.length - 1);

        $.ajax({
           url: baseUrl + "index.php/ordenPedido/jsonOrdenes",
           type: 'POST',
           data: {
              ids: idsPedidos
           },
           error: function() {
              $('#info').html('<p>Ocurrio un error al buscar los datos al servidor.</p>');
           },
           dataType: 'json',
           success: function(data) {
                for (var i = 0; i < data.length; i++) {
                    talbaProductos.row.add([data[i].idOrdenPedido,
                                       data[i].idProducto,
                                       data[i].descripcion,
                                        '<input type="text" size="2" onchange="" name="txtCantidadProd'+ tblProductos.fnGetData().length +'" id="txtCantidadProd'+ tblProductos.fnGetData().length +'" required="required" class="form-control textoCorto" value="' + data[i].cantidad + '">',
                                        data[i].precio / data[i].cantidad,
                                        data[i].precio,
                                        '<input type="checkbox" onclick="calcularFactura();" class="checkSeleccionar" name="chkOrden-'+ data[i].idOrdenPedido +'-' + data[i].idProducto + '" id="chkOrden-'+ data[i].idOrdenPedido +'-' + data[i].idProducto + '" class="form-control" value="' + data[i].idOrdenPedido + '-' + data[i].idProducto + '">'
                                        ]).draw();

                };
           }
           
        });
        $("#myModal").modal('hide'); 

    });


    $('#btnAceptar').click(function() {
    	//var talbaProductos = $('#dtProductos').DataTable();

    	/*var colCantNoEditable = talbaProductos.column(colsProductos.cant_hide);
    	colCantNoEditable.visible(true);*/

		var table = $('#dtProductos').tableToJSON(); // Convert the table into a javascript object

		$('#formBody').parsley( 'validate' );

		$.post( baseUrl + "index.php/ordenPedido/guardarOrden", { 
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
            bootbox.alert("Se la orden se guardo correctamente.");
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
	//var talbaProductos = $('#dtProductos').DataTable();
	var lastChar = text.id.substr(text.id.length - 1); // => "1"
	var cantidad = 0;
    var costo = 0;
    var precioPrd = 0;
    tblProductos.fnUpdate(text.value, lastChar, colsProductos.cant_hide);

    costo = eval(talbaProductos.cell(lastChar,colsProductos.costoUnitario).data());
    cantidad= text.value;
    margen = $("#txtMargenRow" + lastChar).val();
    tblProductos.fnUpdate(margen, lastChar, colsProductos.margen_hide);

	talbaProductos.cell(lastChar,colsProductos.costo).data( cantidad * costo).draw();

    costoLinea= talbaProductos.cell(lastChar,colsProductos.costo).data();
    precioPrd = (margen * costoLinea/100) + costoLinea;
    $("#txtPrecioRow" + lastChar).val(precioPrd);
    tblProductos.fnUpdate(precioPrd, lastChar, colsProductos.precio_hide);
    //talbaProductos.cell(lastChar,7).data(precioPrd).draw();

	var costoTotal = 0;
    var precioTotal = 0;
	for (i=0; i<tblProductos.fnGetData().length; i++){
		costoTotal += eval(talbaProductos.cell(i,colsProductos.costo).data());
		$("#txtCostoTotal").val(costoTotal);

        //precioTotal += eval(talbaProductos.cell(i,7).data());
        precioTotal += parseFloat($("#txtPrecioRow" + i).val());
        $("#txtPrecioTotal").val(precioTotal);
	}

}

function cambiaMargen(margenText){
    //var talbaProductos = $('#dtProductos').DataTable();
    var lastChar = margenText.id.substr(margenText.id.length - 1); // => "1"
    var cantidad = 0;
    var costo = 0;
    var precioPrd = 0;

    margen = parseFloat(margenText.value);

    costoLinea= parseFloat(talbaProductos.cell(lastChar,colsProductos.costo).data());

    precioPrd = (margen * costoLinea/100) + costoLinea;
    $("#txtPrecioRow" + lastChar).val(precioPrd);

    var precioTotal = 0;
    for (i=0; i<tblProductos.fnGetData().length; i++){
        precioTotal += parseFloat($("#txtPrecioRow" + i).val());
        $("#txtPrecioTotal").val(precioTotal);
    }

}
