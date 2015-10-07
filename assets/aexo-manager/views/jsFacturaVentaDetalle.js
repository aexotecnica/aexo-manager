
var tblProductos;

var colsProductos = {
    idOrden:        0,
    idOrdenDetalle: 1,
    idProdcuto:     2,
    nombre:         3,
    cantidad:       4,
    precioUnitario: 5,
    precio:         6,
    check_seleccion:7,
    cantidad_hide:  8
};

var tablaModal;
var urlAjaxOrdenes="index.php/ordenPedido/loadOrdenes";


function calcularFactura() {
    var indice=0;
    var talbaProductos = $('#dtProductos').DataTable();
    var precioTotal=0;
    var iva = 0;
    $('.checkSeleccionar').each(function () {

           if (this.checked) {
               precio = eval(talbaProductos.cell(indice,colsProductos.precio).data());
               precioTotal += precio;
           }

           indice += 1;
    });

    $('#txtImporte').val(precioTotal);
    iva = ((precioTotal * 21) /100).toFixed(2);
    $('#txtIva').val(iva);
    $('#txtPagoTotal').val(eval(precioTotal) + eval(iva));
    
}

function calcularPrecio(indice){
    var nuevoPrecio=0;
    var talbaProductos = $('#dtProductos').DataTable();
    var cantidad = ($('.textoCorto')[indice]).value;

    var nuevoPrecio = eval(talbaProductos.cell(indice,colsProductos.precioUnitario).data()) * cantidad;

    tblProductos.fnUpdate(nuevoPrecio, indice, colsProductos.precio);
    tblProductos.fnUpdate(cantidad, indice, colsProductos.cantidad_hide);

    calcularFactura();
}

function encuentraOrden(idOrden){
    var talbaProductos = $('#dtProductos').DataTable();
    var cantRows = tblProductos.fnGetData().length;
    var encuentra = false;
    for (var i = 0; i < cantRows; i++) {
        idOrdenTabla = eval(talbaProductos.cell(i,colsProductos.idOrden).data());
        if (idOrdenTabla == idOrden)
            encuentra=true;
    }
    return encuentra;
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
        "bProcessing": true,
        "bServerSide": true,
        "bAutoWidth": false,
		"sAjaxSource": baseUrl + urlAjaxOrdenes,
        "fnServerParams": function ( aoData ) {
          aoData.push( { "name": "idCliente", "value": $("#txtIdCliente").val() } );
        },
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
	        },
            "columnDefs": [
                {
                    "targets": [ colsProductos.cantidad_hide],
                    "visible": false,
                    "searchable": false
                }

            ]
    });
    $('.dataTables_filter input').addClass('form-control').attr('style', 'display:none');
    $('.dataTables_length select').addClass('form-control');

    var talbaProductos = $('#dtProductos').DataTable();
    tablaModal = $('#dtProductosModal').DataTable();
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
        var totalDeOrdenes = 0;
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
                    if (!encuentraOrden(data[i].idOrdenPedido)){
                        talbaProductos.row.add([data[i].idOrdenPedido,
                                            data[i].idOrdenPedidoDetalle,
                                           data[i].idProducto,
                                           data[i].descripcion,
                                            '<input type="text" size="2" onchange="calcularPrecio(' + i + ');" name="txtCantidadProd'+ tblProductos.fnGetData().length +'" id="txtCantidadProd'+ tblProductos.fnGetData().length +'" required="required" class="form-control textoCorto" value="' + data[i].cantidad + '">',
                                            data[i].precio / data[i].cantidad,
                                            data[i].precio,
                                            '<input type="checkbox" data-group="chkOrden" onclick="calcularFactura();" class="checkSeleccionar" name="chkOrden" id="chkOrden-'+ data[i].idOrdenPedido +'-' + data[i].idProducto + '" class="form-control" value="' + data[i].idOrdenPedido + '-' + data[i].idProducto + '">',
                                            data[i].cantidad
                                            ]).draw();
                        totalDeOrdenes += eval(data[i].precio);                        
                    }
                }
                $("#txtTotalPendiente").val(totalDeOrdenes);
                $("#txtImporte").val(0);
                ;
           }
           
        });

        
        $("#myModal").modal('hide'); 

    });


    $('#btnAceptar').click(function() {
    	var talbaProductos = $('#dtProductos').DataTable();

        talbaProductos.column(colsProductos.cantidad_hide).visible(true);

		var table = $('#dtProductos').tableToJSON(); // Convert the table into a javascript object
        talbaProductos.column(colsProductos.cantidad_hide).visible(false);

		$('#formBody').parsley( 'validate' );

		$.post( baseUrl + "index.php/facturaVenta/guardarFactura", { 
			nroFactura: 		$('#txtNroFactura').val(), 
			idCliente: 		    $('#txtIdCliente').val(),
			fechaFactura: 	    $('#txtFechaFactura').val(), 
			fechaVencimiento: 	$('#txtFechaVencimiento').val(), 
			importe: 	        $('#txtImporte').val(), 
            iva:                $('#txtIva').val(), 
			productos: 		JSON.stringify(table)
		}).done(function(data) {
		    var obj = jQuery.parseJSON(data);
            $('#btnImprimir').show(); 
            bootbox.alert("La factura se guardo correctamente.");
		}).fail(function() {
            alert( "error" );
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
            var oTable = $('#dtProductos').dataTable();//get the DataTable
                oTable.fnClearTable();
            tablaModal.ajax.reload();
            return item;
        }
    });    

});

