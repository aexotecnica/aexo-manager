// Calendar
// If screensize > 1200, render with m/w/d view, if not by default render with just title

$( document ).ready(function() {

	$('.mask').inputmask();


	$("#btnCancelar").click(function(){
		window.location.href = baseUrl + "index.php/productos";
	});

    $("#btnGuardar").click(function () {
        $('#formBody').parsley( 'validate' );
        var table = $('#gdCosto').tableToJSON();
        $("#txtJsonCosto").val(JSON.stringify(table));

        $("#formBody").attr("action", baseUrl + "index.php/productos/guardar");
        $("#formBody").submit();
    });

});
