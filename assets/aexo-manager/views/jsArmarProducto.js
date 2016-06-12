// Calendar
// If screensize > 1200, render with m/w/d view, if not by default render with just title

$( document ).ready(function() {

	$('.mask').inputmask();


	$("#btnCancelar").click(function(){
		window.location.href = baseUrl + "index.php/productos";
	});

    $("#btnGuardar").click(function () {
        $('#formBody').parsley( 'validate' );
        alert("armarProduct");

        $("#formBody").attr("action", baseUrl + "index.php/productos/guardarArmadoProducto");
        $("#formBody").submit();
    });

});

 function informarStock(idProducto){
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