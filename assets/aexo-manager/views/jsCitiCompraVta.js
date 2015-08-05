$( document ).ready(function() {

	//mydropzone = $("#dropzone").dropzone({ url: "exportacion/subirarchivos" });
	var myDropzone = new Dropzone("div#myId", { url: baseUrl + "index.php/exportacion/subirarchivos"});
	var myDropzoneMovimientos = new Dropzone("div#uplMovimientos", { url: baseUrl + "index.php/exportacion/subirarchivos"});
	
	$("#btnGuardar").hide();
	$('#divPreload').hide();
	$('#divResultado').hide();
	
	//$('#divResultado').hide();
	$("#btnCancelar").click(function(){
		alert(myDropzone.getUploadingFiles());
	});

	$("#btnGuardar").click(function(){
		if ($("#hdnProveedores").val() != "" && $("#hdnMovimientos").val() != "") {
			$('#divPreload').show();
			$.ajax({
				method: "POST",
				cache: false,
				url: baseUrl + "index.php/exportacion/ivacompras/"+ Math.random(),
				async: false,
				data: {archivoProveedores: $('#hdnProveedores').val(), archivoMovimientos : $('#hdnMovimientos').val()},
				success: function (data) {
					jsonResult = JSON.parse(data);
					$("#linkMovimientos").attr("href", jsonResult.movimientos);
					$("#spanMovimientos").html(jsonResult.movimientos);
					
					$("#linkAlicuotas").attr("href", jsonResult.alicuotas);
					$("#spanAlicuotas").html(jsonResult.alicuotas);

				}
			});
			$('#divPreload').hide();
			$('#divSeleccion').hide();
			$('#divResultado').show();
		}
	});

	$("#btnUpload").click(function () {
		 // enable auto process queue after uploading started
		myDropzone.options.autoProcessQueue = true;
		// queue processing
		myDropzone.processQueue();
			
		 // enable auto process queue after uploading started
		myDropzoneMovimientos.options.autoProcessQueue = true;
		// queue processing
		myDropzoneMovimientos.processQueue();
	});


});

Dropzone.options.myId = {

	// Prevents Dropzone from uploading dropped files immediately
	autoProcessQueue: false,
	// acceptedFiles: ".txt,.TXT",

	init: function() {
		var submitButton = document.querySelector("#btnUpload")
				myDropzone = this; // closure

		submitButton.addEventListener("click", function() {
			myDropzone.processQueue(); // Tell Dropzone to process all queued files.
		});

		// You might want to show the submit button only when 
		// files are dropped here:
		this.on("addedfile", function() {
			// Show submit button here and/or inform user to click it.
		}); 
		this.on("sending", function(file, xhr, formData) {
			var name = "cliente";
			formData.append(name, file);
		});

		this.on("complete", function (file) {
			if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
				$("#hdnProveedores").val("cliente-" + file.name);
			}
			$("#btnUpload").hide();
			$("#btnGuardar").show();
		});
	}
};

Dropzone.options.uplMovimientos = {

	// Prevents Dropzone from uploading dropped files immediately
	autoProcessQueue: false,
	// acceptedFiles: ".txt,.TXT",

	init: function() {
		var submitButton = document.querySelector("#btnUpload")
				myDropzoneMovimientos = this; // closure

		submitButton.addEventListener("click", function() {
			myDropzoneMovimientos.processQueue(); // Tell Dropzone to process all queued files.
		});

		// You might want to show the submit button only when 
		// files are dropped here:
		this.on("addedfile", function() {
			// Show submit button here and/or inform user to click it.
		});
		this.on("sending", function(file, xhr, formData) {
			var name = "movimiento";
			formData.append(name, file);
		});
		this.on("complete", function (file) {
			if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
					$("#hdnMovimientos").val("movimiento-" + file.name);
			}
		});
	}
};