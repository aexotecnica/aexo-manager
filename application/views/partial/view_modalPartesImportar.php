<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Partes temporales</h4>
            </div>
            <div class="modal-body">
                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables" id="dtPartesTemporales">
                    <thead>
                        <tr>
                            <th>idParte</th>
                            <th>descripcion</th>
                            <th>codigo</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                <input type="hidden" id="idParteTemporal" name="idParteTemporal"></input>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input id="btnImportar" type="button" class="btn btn-primary" value="Importar"></input>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type='text/javascript'>
    function importarPartes(){
        $('#myModal').modal('show');
    }

    $(document).ready(function() { 

        $('#btnImportar').click(function() {
            $.post("<?= base_url() ?>index.php/despiece/importarParte", {
                idParteTemporal: $("#idParteTemporal").val(),
            },
            function(data, status){
                if (status=='success'){
                    alert("Se importo correctamente");
                    $("#myModal").modal('hide'); 
                }
                
            });
        });

     
        $('#dtPartesTemporales').dataTable({

            "sDom": "<'row'<'col-sm-6'T><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
            "bProcessing": false,
            "bServerSide": true,
            "bAutoWidth": false,
            "sAjaxSource": "<?= base_url() ?>index.php/despiece/loadPartes",

            "sPaginationType": "bootstrap",
            "oTableTools": {
                "sRowSelect": "single",                        
                "aButtons": []
            }
        });


        $('#dtPartesTemporales tbody').on( 'click', 'tr', function () {
            $("#idParteTemporal").val($(this).children("td:eq(0)").text());
        } );    

        $('.dataTables_filter input').addClass('form-control').attr('placeholder','Search...');
        $('.dataTables_length select').addClass('form-control');

    });

</script>