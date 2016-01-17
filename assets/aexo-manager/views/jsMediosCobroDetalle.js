

var tablaModal;
var urlAjaxFacturas="index.php/facturaVenta/loadFacturas";
var selected = [];

var colsFactura = {
    idFactura:        0,
    nroFactura:       1,
    fechaFactura:     2,
    fechaVencimiento: 3,
    iva:              4,
    importeTotal:     5,
    importeAPagar:    6,
    importeAPagar_hide:7
};

function calcularImporte(){
    var importeTotal=0;
    var importeIva=0;
    var tablaFacturasPagas = $('#dtFacturasPagar').DataTable();
    for (var indice = 0; indice < $('.textoImporte').length; indice++) {
        importeTotal += eval(($('.textoImporte')[indice]).value);
        importeIva += eval(tablaFacturasPagas.cell(indice,colsFactura.iva).data());
    };
    $("#txtImporte").val(importeTotal);
    $("#txtImporteSiva").val(importeIva);
}

$( document ).ready(function() {

$('#txtImporteSiva').inputmask('decimal', { radixPoint: ".", autoGroup: true, groupSeparator: ",", groupSize: 3 }); 
    $('#txtImporte').inputmask('decimal', { radixPoint: ".", autoGroup: true, groupSeparator: ",", groupSize: 3 }); 
    
    $('#txtFecha').datepicker({format: 'dd/mm/yyyy', language: 'es'});

    $("#btnCancelar").click(function(){
        window.location.href = "<?= base_url() ?>index.php/mediosDeCobro";
    });


    $('#btnAceptar').click(function() {

        var tablaFacturasPagas = $('#dtFacturasPagar').DataTable();

        if (tablaFacturasPagas.rows.length > 0){
            tablaFacturasPagas.column(colsFactura.importeAPagar_hide).visible(true);
            var table = $('#dtFacturasPagar').tableToJSON(); 
            tablaFacturasPagas.column(colsFactura.importeAPagar_hide).visible(false);    
        }else {
            var table = ""; 
        }
        

        $('#jsonFacturas').val(JSON.stringify(table));

        if ($("#txtIdCliente").val() == "0" || $("#txtIdCliente").val() == "-1"){
            alert("Por favor ingrese un Cliente existente. Si no existe Crealo desde el abm de clientes.")
        }
        $('#formBody').parsley( 'validate' );
        $('#formBody').submit();
    });


    $("#txtCliente").blur(function () {
        if ($("#txtIdCliente").val() == "-1" && $("#txtCliente").val() != "") {
            alert("El cliente no existe, por favor ingreselo al sistema."); 
        }
        
    });

    
    
	$('#dtFacturas').dataTable({

		"sDom": "<'row'<'col-sm-6'T><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        "bProcessing": true,
        "bServerSide": true,
        "bAutoWidth": false,
		"sAjaxSource": baseUrl + urlAjaxFacturas,
        "fnServerParams": function ( aoData ) {
          aoData.push( { "name": "idCliente", "value": $("#txtIdCliente").val() } );
        },
		"iDisplayLength": 5,
        "sPaginationType": "bootstrap",
        "rowCallback": function( row, data ) {
            if ( $.inArray(data.nroFactura, selected) !== -1 ) {
                $(row).addClass('selected');
            }
        },
        "oTableTools": {
        	"sRowSelect": "multi",
        	"aButtons": [],
            "sSearch": ""
        }
    });
    tablaModal = $('#dtFacturas').DataTable();

    $('#dtFacturas tbody').on( 'click', 'tr', function () {
        //var id = this.cells[0].textContent;
        var row = this.cells;
        var index = $.inArray(row, selected)
 
        if ( index === -1 ) {
            selected.push( row );
        } else {
            selected.splice( index, 1 );
        }
 
        //$(this).toggleClass('selected');
    } );

    tblFacturasPagas = $('#dtFacturasPagar').dataTable({
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
                    "targets": [colsFactura.importeAPagar_hide],
                    "visible": false,
                    "searchable": false
                }

            ]
    });
    $('.dataTables_filter input').addClass('form-control').attr('style', 'display:none');
    $('.dataTables_length select').addClass('form-control');

    var tablaFacturasPagas = $('#dtFacturasPagar').DataTable();

    $("#txtCliente").typeahead({
            source: function (query, process) {
                var clientes = [];
                map = {};
                if (query.length > 3) {
                // This is going to make an HTTP post request to the controller
                return $.post(baseUrl + 'index.php/clientes/jsonConsultarCliente', { query: query }, function (data) {
                    // Loop through and push to the array
                    //alert(eval(data));
                    if (eval(data).length != 0){
                        $.each(eval(data), function (i, cliente) {
                            map[cliente.nombre] = cliente;
                            clientes.push(cliente.nombre);
                        });
                        process(clientes);
                        $("#txtIdCliente").val("0");
                    }else{
                        $("#txtIdCliente").val("-1");
                    }

                });
            }
        },
        updater: function (item) {
            var selectedShortCode = map[item].idCliente;
            var cuitCliente = map[item].cuit;
            // Set the text to our selected id
            $("#txtIdCliente").val(selectedShortCode);
            $("#txtCuit").val(cuitCliente);

            tablaModal.ajax.reload();

            return item;
        },
    });

    $("#btnFacturas").click(function(){
        $('#myModal').modal('show');
    });

    $('#btnAgregar').click(function() {
        //alert(selected[0]);
        var idsFacturas="";
        var totalDeFacturas = 0;
        // for (var i = 0; i < selected.length; i++) {
        //     idsFacturas += selected[i] + ",";
        // }

        // idsFacturas = idsFacturas.substring(0, idsFacturas.length - 1);

        for (var i = 0; i < selected.length; i++) {
            //if (!encuentraOrden(data[i].idOrdenPedido,data[i].idOrdenPedidoDetalle)){
                tablaFacturasPagas.row.add([selected[i][colsFactura.idFactura].textContent,
                                            selected[i][colsFactura.nroFactura].textContent,
                                            selected[i][colsFactura.fechaFactura].textContent,
                                            selected[i][colsFactura.fechaVencimiento].textContent,
                                            selected[i][colsFactura.iva].textContent,
                                            selected[i][colsFactura.importeTotal].textContent,
                                            '<input type="text" size="2" onchange="calcularImporte();" name="txtImportePagado'+ tblFacturasPagas.fnGetData().length +'" id="txtImportePagado'+ tblFacturasPagas.fnGetData().length +'" required="required" class="form-control textoImporte" value="' + eval(eval(selected[i][colsFactura.importeTotal].textContent) + eval(selected[i][colsFactura.iva].textContent))  + '">',
                                            eval(eval(selected[i][colsFactura.importeTotal].textContent) + eval(selected[i][colsFactura.iva].textContent))
                                    ]).draw(); 
                //totalDeFacturas += eval(data[i].precio);                        
            //}
        }
        $("#txtTotalPendiente").val(totalDeFacturas);

        calcularImporte();
        
        $("#myModal").modal('hide'); 

    });


});