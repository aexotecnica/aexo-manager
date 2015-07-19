<?php echo form_open( $actionDelForm, 'method="post" id="formBody" autocomplete="off" enctype="multipart/form-data"'); ?>
<div id="page-heading">
    <ul class="breadcrumb">
        <li><a href="#">Produccion</a></li>
        <li><a href="#">Despiece</a></li>
        <li class="active">Despiece de parte</li>
    </ul>

    <h1>Despiece de Parte</h1>
    <div class="options">
        <div class="btn-toolbar">
            <input type="button" id="btnInsumo" <? echo ($partePadre->esInsumo != null) ? "" : ""; ?> class="btn-primary btn" value="Convertir en insumo" />
            <a class="btn btn-default" href="javascript:importarPartes();">
                <i class="fa fa-arrow-circle-up"></i> 
                <span class="hidden-xs hidden-sm">Importar Partes</span>
            </a>
        </div>
    </div>
    </div>
    <div class="container">
        <div class="panel panel-midnightblue">
            <div class="row">

                <div class="col-md-12">
                    <div class="panel panel-sky">
                        <div class="panel-heading">
                            <h4>Despiece de la parte: <? echo $partePadre->descripcion ?></h4>

                            <div class="options">   
                                <a href="javascript:;"><i class="fa fa-cog"></i></a>
                                <a href="javascript:;"><i class="fa fa-wrench"></i></a>
                                <a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
                            </div>
                        </div>
                        <div class="panel-body collapse in">
                            <div class="row">
                                <div class="panel-body collapse in">
                                    <label class="col-sm-1 control-label">Parte</label>
                                    <div class="col-sm-3">
                                        <input type="text" id="txtParte" name="txtParte" class="form-control autocomplete" autocomplete="off" ></input>
                                    </div>
                                    <label class="col-sm-1 control-label">Cantidad</label>
                                    <div class="col-sm-1">
                                        <input type="text" id="txtCantidad" name="txtCantidad" class="form-control" ></input>
                                    </div>
                                    <label class="col-sm-1 control-label">Estado</label>
                                    <div class="col-sm-3">
                                        <select name="selEstadoParte" id="selEstadoParte" class="form-control"> 
                                            <option>Estado</option>
                                            <? 
                                            foreach ($estadosPartes as $val){ 
                                            ?>
                                                <option  value='<?= $val->idEstadoParte?>'><?= $val->descripcion?></option>    
                                            <?}?>
                                        </select>
                                    </div>
                                    <div class="col-sm-2" style="text-align:right">
                                        <button id="btnAgregar" class="btn-primary btn">Agregar</button>
                                    </div>
                                </div>
                                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables DTTT_selectable" id="tblPartes">
                                    <thead>
                                        <tr>
                                            <th width="10%">IdParte</th>
                                            <th width="15%">Codigo</th>
                                            <th width="50%">Descripcion</th>
                                            <th width="10%">Cantidad</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?
                                        if ($hijos != NULL)
                                            foreach ($hijos as $val){?> 
                                                <tr class="gradeX">
                                                    <td><?= $val->idParte?></td>
                                                    <td><?= $val->codigo?></td>
                                                    <td><?= $val->descripcion?></td>
                                                    <td><?= $val->cantidad?></td>
                                                </tr>
                                        <?}?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel-footer">
                    <div class="row">
                        <div class="pull-right">
                            <div class="btn-toolbar">
                                <input type="button" id="btnVolver" value="Volver" class="btn-primary btn"></input>
                            </div>
                        </div>
                    </div>
                </div>
                
                <input type="hidden" id="esInsumo" name="esInsumo" value="<?=($partePadre->esInsumo != null) ? 1 : 0;?>"></input>
                <input type="hidden" id="idDespiecce" name="idDespiece" value="<?=$idDespiece?>"></input>
                <input type="hidden" id="idProducto" name="idProducto" value="<?=$idProducto?>"></input>
                <input type="hidden" id="idPartePadre" name="idPartePadre" value="<?=$idPartePadre?>"></input>
                <input type="hidden" id="idParte" name="idParte" ></input>
            </div>
        </div>
    </div>


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


    <div class="modal fade" id="modalArbolInsumo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Convertir a Insumo</h4>
                </div>
                <div class="modal-body">
                    <div class="cf nestable-lists">
                        <div id="despiece">
                            <ul class="dd-list">
                                <?php echo $arbolString; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal" > Close</button>
                    <input id="btnConvertirInsumo" onclick="javascript:convertirInsumo();"  type="button" class="btn btn-primary" value="Guardar"></input>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <?php echo form_close(); ?>


    <script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/jquery.dataTables.min.js'></script> 
    <script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/TableTools.js'></script> 
    <script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/dataTables.editor.js'></script> 
    <script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/dataTables.editor.bootstrap.js'></script> 
    <script type='text/javascript' src='<?= base_url() ?>assets/plugins/datatables/dataTables.bootstrap.js'></script> 
    <script type='text/javascript' src='<?= base_url() ?>assets/plugins/bootbox/bootbox.min.js'></script> 
    <script type='text/javascript' src='<?= base_url() ?>assets/plugins/form-toggle/toggle.min.js'></script>
    <script type='text/javascript' src='<?= base_url() ?>assets/plugins/form-typeahead/typeahead.min.js'></script>
    <script type='text/javascript' src='<?= base_url() ?>assets/plugins/form-nestable/jquery.nestable.min.js'></script> 
    <script type='text/javascript' src='<?= base_url() ?>assets/plugins/form-nestable/ui-nestable.js'></script> 
    <script type='text/javascript' src='<?= base_url() ?>assets/plugins/bootbox/bootbox.min.js'></script> 

    <script type='text/javascript'>

    function importarPartes(){
        $('#myModal').modal('show');
    }

    function detalleDespiece(idParte,idProducto,idDespiece) {
        $("#idDespiece").val(idDespiece);
        $("#idProducto").val(idProducto);
        $("#idPartePadre").val(idParte);
        //alert("hola");
        $("#formBody").attr("action", "<?= base_url() ?>index.php/despiece/Parte");
        $("#formBody").submit();
    }

    $( document ).ready(function() {

        $('#despiece').nestable({
            group: 1
        });


        $('#btnVolver').click(function() {
            $('#formBody').attr("action", "<?= base_url() ?>index.php/despiece/ver");
            $('#formBody').submit();
        });

        $('#btnInsumo').click(function() {
            $('#modalArbolInsumo').modal('show');
        });

        $('#btnConvertirInsumo').click(function() {
           $('#formBody').attr("action", "<?= base_url() ?>index.php/despiece/convertirInsumo");
            $('#formBody').submit(); 
        });

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

    $("#txtParte").typeahead({
            source: function (query, process) {
                var partes = [];
                map = {};
                if (query.length > 3) {
                // This is going to make an HTTP post request to the controller
                return $.post('<?= base_url() ?>index.php/despiece/jsonConsultarParte', { query: query }, function (data) {
                    // Loop through and push to the array
                    //alert(eval(data));
                    $.each(eval(data), function (i, parte) {
                        map[parte.descripcion] = parte;
                        partes.push(parte.descripcion);
                    });
                    // Process the details
                    process(partes);

                });
            }
        },
        updater: function (item) {
            var selectedShortCode = map[item].idParte;
            // Set the text to our selected id
            $("#idParte").val(selectedShortCode);
            return item;
        }
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

// function detalleDespiece(idParte, idProducto) {
//     $("#IdProducto").val(idProducto);
//     $("#IdPartePadre").val(idParte);
//     //alert("hola");
//     $("#formBody").attr("action", "<?= base_url() ?>index.php/despiece/Parte");
//     $("#formBody").submit();
// }

</script>