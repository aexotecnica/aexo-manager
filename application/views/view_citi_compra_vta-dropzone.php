            <div id="page-heading">
                <ol class="breadcrumb">
                    <li><a href="index.htm">Dashboard</a></li>
                    <li>Advanced Forms</li>
                    <li>Dropzone</li>
                </ol>

                <h1>Dropzone File Upload</h1>
                <div class="options">
                    <div class="btn-toolbar">
                        <div class="btn-group hidden-xs">
                            <a href='#' class="btn btn-default dropdown-toggle" data-toggle='dropdown'><i class="fa fa-cloud-download"></i><span class="hidden-sm"> Export as  </span><span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Text File (*.txt)</a></li>
                                <li><a href="#">Excel File (*.xlsx)</a></li>
                                <li><a href="#">PDF File (*.pdf)</a></li>
                            </ul>
                        </div>
                        <a href="#" class="btn btn-default"><i class="fa fa-cog"></i></a>
                    </div>
                </div>
            </div>
            <div class="container">

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="panel-heading">
                                <h4>File Upload</h4>
                                <div class="options">

                                </div>
                            </div>
                            <div class="panel-body">
                                 <div id="myId" class="dropzone"></div> 
                            </div>
                        </div>
						<div class="panel-footer">
							<div class="row">
								<div class="col-sm-6 col-sm-offset-3">
									<div class="btn-toolbar">
										<input type="button" id="btnGuardar" class="btn-primary btn" value="Guardar"></input>
										<input type="button" value="Cancel" id="btnCancelar" class="btn-default btn"></input>
									</div>
								</div>
							</div>
						</div>
                    </div>
                </div>

            </div> <!-- container -->


<link rel='stylesheet' type='text/css' href='<?= base_url() ?>assets/plugins/dropzone/css/dropzone.css' /> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/form-inputmask/jquery.inputmask.bundle.min.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/jquery.dataTables.min.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/form-parsley/parsley.min.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/jquery.tabletojson.js'></script>
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/TableTools.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/jquery.tabletojson.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/dataTables.editor.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/dataTables.editor.bootstrap.js'></script> 
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/dataTables.bootstrap.js'></script>
<script type='text/javascript' src='<?= base_url() ?>assets/plugins/dropzone/dropzone.min.js'></script>  
<script type="text/javascript">
var baseUrl= "<?= base_url() ?>";

$( document ).ready(function() {

	//mydropzone = $("#dropzone").dropzone({ url: "exportacion/subirarchivos" });
	var myDropzone = new Dropzone("div#myId", { url: "<?= base_url() ?>index.php/exportacion/subirarchivos"});
	
	$("#btnCancelar").click(function(){
		alert(myDropzone.getUploadingFiles());
	});

    $("#btnGuardar").click(function () {
		   // enable auto process queue after uploading started
	    myDropzone.options.autoProcessQueue = true;
	    // queue processing
	    myDropzone.processQueue();
    });

	

});
    Dropzone.options.myId = {

      // Prevents Dropzone from uploading dropped files immediately
      autoProcessQueue: false,
      acceptedFiles: ".txt,.TXT",

      init: function() {
        var submitButton = document.querySelector("#btnGuardar")
            myDropzone = this; // closure

        submitButton.addEventListener("click", function() {
          myDropzone.processQueue(); // Tell Dropzone to process all queued files.
        });

        // You might want to show the submit button only when 
        // files are dropped here:
        this.on("addedfile", function() {
          // Show submit button here and/or inform user to click it.
        });         
      }
    };
</script>