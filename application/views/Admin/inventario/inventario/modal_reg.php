
<!--<script type="text/javascript" src="<?=base_url() ?>template/assets/js/plugins/loaders/pace.min.js"></script>-->
<!--<script type="text/javascript" src="<?=base_url() ?>template/assets/js/core/libraries/jquery.min.js"></script>-->
<!--<script type="text/javascript" src="<?=base_url() ?>template/assets/js/core/libraries/bootstrap.min.js"></script>-->
<!--<script type="text/javascript" src="<?=base_url() ?>template/assets/js/plugins/loaders/blockui.min.js"></script>-->
<script type="text/javascript" src="<?=base_url() ?>template/assets/js/pages/uploader_bootstrap.js"></script>
<form id="formulario_validacion" method="POST" enctype="multipart/form-data"  class="horizontal">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Validar Código (Foto)</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            
            <div class="form-group col-md-1">
                <label>Código:</label>
            </div>

            <div class="form-group col-md-4">
                <select  class="form-control basic" id="id_inventario" name="id_inventario">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_inventario as $list){ ?>
                        <option value="<?php echo $list['id_inventario']; ?>"><?php echo $list['letra']."/".$list['codigo_barra'];?></option>
                    <?php } ?>
                </select>
            </div>

            <!--<div class="form-group col-md-1">
                <label>Imágen:</label>
            </div>

            <div class="form-group col-md-6">
                
                <input type="file" id="imagenv" name="imagenv" class="file-input-overwrite" data-allowed-file-extensions='["png|jpg|pdf"]'>
            </div>-->
        </div>
        <div class="col-md-12 row">
            <div class="form-group col-md-1">
                <label>Código Barra:</label>
            </div>

            <div class="col-md-4">
                <input type="text" id="cod_barra" name="cod_barra" class="form-control">
            </div>

            <button class="btn btn-success" type="button" onclick="Ver_Scanner()"><i class="fa fa-plus"></i>Scannear</button>
            
        </div> 	           	                	        
    </div> 

    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Validacion_Producto()" data-loading-text="Loading..." autocomplete="off">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>
<form id="formulario_scanner" method="post" target="print_popup" action="<?= site_url('Snappy/Scanner')?>" onsubmit="window.open('about:blank','print_popup','width=530,height=600');">
</form>
<script src="<?= base_url() ?>template/fileinput/js/fileinput.min.js"></script>
<script>
    

    function Insert_Validacion_Producto(){
        var dataString = new FormData(document.getElementById('formulario_validacion'));
        var url="<?php echo site_url(); ?>Snappy/Validar_InventarioImg";
        if (valida_asignacion()) {
            bootbox.confirm({
                title: "Asignación Producto",
                message: "¿Desea asignar nuevo producto?",
                buttons: {
                    cancel: {
                        label: 'Cancelar'
                    },
                    confirm: {
                        label: 'Confirmar'
                    }
                },
                callback: function (result) {
                    if (result) {
                        $.ajax({
                            type:"POST",
                            url: url,
                            data:dataString,
                            processData: false,
                            contentType: false,
                            success:function (data) {
                                if(data=="error"){
                                    swal.fire(
                                        'Validación Denegada!',
                                        'El código ya fue validado anteriormente',
                                        'warning'
                                    ).then(function() {
                                        window.location = "<?php echo site_url(); ?>Snappy/Inventario";
                                        
                                    });
                                }else{
                                    swal.fire(
                                        'Validación Exitosa!',
                                        '',
                                        'success'
                                    ).then(function() {
                                        window.location = "<?php echo site_url(); ?>Snappy/Inventario";
                                        
                                    });
                                }
                                
                                
                            }
                        });
                    }
                } 
            });      
        }
    }
    

    function valida_asignacion() {
        if($('#id_inventario').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar código.',
                'warning'
            ).then(function() { });
            return false;
        }

        if($('#imagenv').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe adjuntar foto.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
