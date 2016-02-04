// Calendar
// If screensize > 1200, render with m/w/d view, if not by default render with just title

$( document ).ready(function() {

	$('.mask').inputmask();

	$('#txtCostoSinProcesar').inputmask('decimal', { radixPoint: ".", autoGroup: true, groupSeparator: ",", groupSize: 3 }); 
	$('#txtCostoFinal').inputmask('decimal', { radixPoint: ".", autoGroup: true, groupSeparator: ",", groupSize: 3 }); 
	$('.numero').inputmask('decimal', { radixPoint: ".", autoGroup: true, groupSeparator: ",", groupSize: 3 }); 

	$("#btnCancelar").click(function(){
		window.location.href = baseUrl + "index.php/partes";
	});

	$.ajaxSetup({ cache: false });
	$("#btnSubmit").click(function(){
	    if ($("#txtIdParte").val() == "") {
		    $.ajax({
		        method: "POST",
		        cache: false,
		        url: baseUrl + "index.php/partes/existeParte/"+ Math.random(),
		        async: false,
		        data: {codigo: $('#txtCodigo').val()},
		        success: function (existe) {
		            if (existe==0){
		            	$("#formBody").attr("action", baseUrl + "index.php/partes/guardar");
						$("#formBody").submit();
		            }else{
		            	bootbox.alert("El código de parte ya existe.");
		            }
		        }
		    });
	    }else{
	    	$("#formBody").attr("action", baseUrl + "index.php/partes/guardar");
			$("#formBody").submit();
	    }
	});

	$('#mselEstadosParte').multiSelect({ 
		keepOrder: true,
	  	afterSelect: function(values){
    		//alert("Select value: "+values);
    		$("#divCostos").append('<input type="text" onblur="javascript:calcularCosto()" id="txtCosto_'+ values + '" name="costo[]" class="form-control numero" style="height:25px" placeholder="Costo"/>');
    		$('.numero').inputmask('decimal', { radixPoint: ".", autoGroup: true, groupSeparator: ",", groupSize: 3 }); 
  		},
  		afterDeselect: function(values){
    		//alert("Deselect value: "+values);
    		$("#txtCosto_" + values ).remove();
    		calcularCosto();
  		}
  	});


});

function calcularCosto(){
	var costoTotal = 0;
	var costoBruto = eval($("#txtCostoSinProcesar").val());
	$.each($("input[name='costo[]']"), function( key, costoEstado ) {
		if (costoEstado.value != "")
			costoTotal += eval(costoEstado.value);
	});
	$("#txtCostoFinal").val(costoTotal + costoBruto);
}