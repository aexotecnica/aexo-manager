
var tblProductos;

var colsProductos = {
    id:             0,
    nombre:         1,
    cantidad:       2,
    cant_hide:      3,
//    costo:          4,
//    costoUnitario:  5,
//    margen:         6,
//    margen_hide:    7,
    precio:         4,
    precio_hide:    5,
    precioXCant_hide:    6
};

$( document ).ready(function() {

	$('#txtFechaPedido').datepicker({format: 'dd/mm/yyyy', language: 'es'});
	$('#txtFechaEntrega').datepicker({format: 'dd/mm/yyyy', language: 'es'});
    $(".cantidad").inputmask("9");

    if (!imprimirVisible)
        $('#btnImprimir').hide();       

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
        },
        "columnDefs": [
            {
                "targets": [3],
                "visible": false,
                "searchable": false
            }

        ]
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
	                "targets": [colsProductos.precio_hide,colsProductos.precioXCant_hide],
	                "visible": false,
	                "searchable": false
	            }

	        ]
    });


    $('#dtProductosModal tbody').on( 'click', 'tr', function () {
        $("#idProductoModal").val($(this).children("td:eq(0)").text());
		$("#descripcionModal").val($(this).children("td:eq(1)").text());
		$("#codigoModal").val($(this).children("td:eq(2)").text());
		//$("#costoModal").val($(this).children("td:eq(3)").text());
        $("#precioModal").val($(this).children("td:eq(3)").text());
		
    } );    

    $('#btnAgregar').click(function() {
    	var talbaProductos = $('#dtProductos').DataTable();
    	//alert(tblProductos.fnGetData().length);

    	talbaProductos.row.add([$("#idProductoModal").val(),
    							$("#descripcionModal").val(),
                                '<input type="text" size="2" value="1" onchange="javascript:cambiaText(this);" name="txtRow'+ tblProductos.fnGetData().length +'" id="txtRow'+ tblProductos.fnGetData().length +'" required="required" class="form-control textoCorto cantidad">',
    							'1',
    							//$("#costoModal").val(),
    							//$("#costoModal").val(),
                                //'<input type="text" size="2" onchange="javascript:cambiaMargen(this);" name="txtMargenRow'+ tblProductos.fnGetData().length +'" id="txtMargenRow'+ tblProductos.fnGetData().length +'" required="required" class="form-control textoCorto" value="30">',
                                //'0',
                                '<input type="text" size="2" value="' + $("#precioModal").val() + '"  name="txtPrecioRow'+ tblProductos.fnGetData().length +'" id="txtPrecioRow'+ tblProductos.fnGetData().length +'" required="required" class="form-control">',
                                $("#precioModal").val(),
                                $("#precioModal").val()]).draw();


        $("#myModal").modal('hide');
        $(".cantidad").inputmask("9");
        actualizarTotales();
    });

    $('#btnAceptar').click(function() {
    	var talbaProductos = $('#dtProductos').DataTable();

    	var colCantNoEditable = talbaProductos.column(colsProductos.cant_hide);
    	colCantNoEditable.visible(true);

		var colCantEditable = talbaProductos.column(colsProductos.cantidad);
    	colCantEditable.visible(false); 

        var colPrecioNoEditable = talbaProductos.column(colsProductos.precioXCant_hide);
        colPrecioNoEditable.visible(true);

        var colPrecioNoEditable = talbaProductos.column(colsProductos.precio_hide);
        colPrecioNoEditable.visible(true);

        var colPrecioEditable = talbaProductos.column(colsProductos.precio);
        colPrecioEditable.visible(false); 

        // var colMargenNoEditable = talbaProductos.column(colsProductos.margen_hide);
        // colMargenNoEditable.visible(true);

        // var colMargenEditable = talbaProductos.column(colsProductos.margen);
        // colMargenEditable.visible(false); 

		var table = $('#dtProductos').tableToJSON(); // Convert the table into a javascript object
        
        var colPrecioNoEditable = talbaProductos.column(colsProductos.precio_hide);
        colPrecioNoEditable.visible(false);
		
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


// function cambiaText(text){
// 	var talbaProductos = $('#dtProductos').DataTable();
// 	var lastChar = text.id.substr(text.id.length - 1); // => "1"
// 	var cantidad = 0;
//     var costo = 0;
//     var precioPrd = 0;
//     tblProductos.fnUpdate(text.value, lastChar, colsProductos.cant_hide);

 //    costo = eval(talbaProductos.cell(lastChar,colsProductos.costoUnitario).data());
 //    cantidad= text.value;
 //    margen = $("#txtMargenRow" + lastChar).val();
 //    tblProductos.fnUpdate(margen, lastChar, colsProductos.margen_hide);

	// talbaProductos.cell(lastChar,colsProductos.costo).data( cantidad * costo).draw();

 //    costoLinea= talbaProductos.cell(lastChar,colsProductos.costo).data();
 //    precioPrd = (margen * costoLinea/100) + costoLinea;
 //    $("#txtPrecioRow" + lastChar).val(precioPrd);
 //    tblProductos.fnUpdate(precioPrd, lastChar, colsProductos.precio_hide);
 //    //talbaProductos.cell(lastChar,7).data(precioPrd).draw();

	// var costoTotal = 0;
 //    var precioTotal = 0;
	// for (i=0; i<tblProductos.fnGetData().length; i++){
	// 	costoTotal += eval(talbaProductos.cell(i,colsProductos.costo).data());
	// 	$("#txtCostoTotal").val(costoTotal);

 //        //precioTotal += eval(talbaProductos.cell(i,7).data());
 //        precioTotal += parseFloat($("#txtPrecioRow" + i).val());
 //        $("#txtPrecioTotal").val(precioTotal);
	// }
 //}

function actualizarTotales(){
     var talbaProductos = $('#dtProductos').DataTable();
     var precioTotal = 0;
     for (i=0; i<tblProductos.fnGetData().length; i++){
    //  costoTotal += eval(talbaProductos.cell(i,colsProductos.costo).data());
    //  $("#txtCostoTotal").val(costoTotal);

         //precioTotal += eval(talbaProductos.cell(i,7).data());
         precioTotal += parseFloat($("#txtPrecioRow" + i).val());
         $("#txtPrecioTotal").val(precioTotal);
     }
}

function cambiaText(text){
    var talbaProductos = $('#dtProductos').DataTable();
    var lastChar = text.id.substr(text.id.length - 1); // => "1"
    var cantidad = 0;
    var costo = 0;
    var precioPrd = 0;
    tblProductos.fnUpdate(text.value, lastChar, colsProductos.cant_hide);

 //    costo = eval(talbaProductos.cell(lastChar,colsProductos.costoUnitario).data());
       precioPrd = eval(talbaProductos.cell(lastChar,colsProductos.precio_hide).data());
       cantidad= text.value;
 //    margen = $("#txtMargenRow" + lastChar).val();
 //    tblProductos.fnUpdate(margen, lastChar, colsProductos.margen_hide);

       //talbaProductos.cell(lastChar,colsProductos.precio).data( cantidad * precioPrd).draw();

 //    costoLinea= talbaProductos.cell(lastChar,colsProductos.costo).data();
 //    precioPrd = (margen * costoLinea/100) + costoLinea;
      $("#txtPrecioRow" + lastChar).val(precioPrd * cantidad);
     tblProductos.fnUpdate(precioPrd * cantidad, lastChar, colsProductos.precioXCant_hide);
     //talbaProductos.cell(lastChar,7).data(precioPrd).draw();

    // var costoTotal = 0;
     var precioTotal = 0;
     for (i=0; i<tblProductos.fnGetData().length; i++){
    //  costoTotal += eval(talbaProductos.cell(i,colsProductos.costo).data());
    //  $("#txtCostoTotal").val(costoTotal);

         //precioTotal += eval(talbaProductos.cell(i,7).data());
         precioTotal += parseFloat($("#txtPrecioRow" + i).val());
         $("#txtPrecioTotal").val(precioTotal);
     }
 }

// function cambiaMargen(margenText){
//     var talbaProductos = $('#dtProductos').DataTable();
//     var lastChar = margenText.id.substr(margenText.id.length - 1); // => "1"
//     var cantidad = 0;
//     var costo = 0;
//     var precioPrd = 0;

//     margen = parseFloat(margenText.value);

//     costoLinea= parseFloat(talbaProductos.cell(lastChar,colsProductos.costo).data());

//     precioPrd = (margen * costoLinea/100) + costoLinea;
//     $("#txtPrecioRow" + lastChar).val(precioPrd);

//     var precioTotal = 0;
//     for (i=0; i<tblProductos.fnGetData().length; i++){
//         precioTotal += parseFloat($("#txtPrecioRow" + i).val());
//         $("#txtPrecioTotal").val(precioTotal);
//     }

// }
