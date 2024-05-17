<form id="formulario" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title">Editar Saldo Banco</h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-4">
                <label class="control-label text-bold">Empresa: </label>
                <input type="text" class="form-control" disabled value="CA">
            </div>

            <div class="form-group col-md-4">
                <label class="control-label text-bold">Cuenta Bancaria: </label>
                <input type="text" class="form-control" id="cuenta_bancaria" name="cuenta_bancaria" value="<?php echo $get_id[0]['cuenta_bancaria']; ?>">
            </div>

            <div class="form-group col-md-4">
                <label class="control-label text-bold">Inicio: </label>
                <select class="form-control" id="inicio" name="inicio">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_anio as $list){ 
                        foreach($list_mes as $mes){ ?>
                            <option value="<?php echo $mes['cod_mes']."/".$list['nom_anio']; ?>"
                            <?php if($mes['cod_mes'].$list['nom_anio']==$get_id[0]['mes'].$get_id[0]['anio']){ echo "selected"; } ?>>
                                <?php echo substr($mes['nom_mes'],0,3)."/".substr($list['nom_anio'],-2); ?>
                            </option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-4">
                <label class="control-label text-bold">Estado: </label>
                <select class="form-control" name="estado" id="estado">
                    <option value="0" <?php if(!(strcmp(0, $get_id[0]['estado']))){ echo "selected=\"selected\"";} ?>>Seleccione</option>
                    <?php foreach($list_estado as $estado){ ?>
                        <option value="<?php echo $estado['id_status']; ?>" <?php if(!(strcmp($estado['id_status'],$get_id[0]['estado']))){ echo "selected=\"selected\""; } ?>>
                            <?php echo $estado['nom_status']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-8">
                <label class="control-label text-bold">Observaciones: </label>
                <textarea class="form-control" rows="5" id="observaciones" name="observaciones" placeholder="Observaciones"><?php echo $get_id[0]['observaciones']; ?></textarea>
            </div>
        </div>  	           	                	        
    </div> 
    
    <div class="modal-footer">
        <input type="hidden" id="id_estado_bancario" name="id_estado_bancario" value="<?php echo $get_id[0]['id_estado_bancario']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Saldo_Banco();" data-loading-text="Loading..." autocomplete="off">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
    </div>
</form>

<script>
    function Update_Saldo_Banco(){
        $(document)
        .ajaxStart(function() {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                backgroundColor: '#1b2024',
                opacity: 0.8,
                zIndex: 1200,
                cursor: 'wait'
                },
                css: {
                border: 0,
                color: '#fff',
                zIndex: 1201,
                padding: 0,
                backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function() {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                backgroundColor: '#1b2024',
                opacity: 0.8,
                zIndex: 1200,
                cursor: 'wait'
                },
                css: {
                border: 0,
                color: '#fff',
                zIndex: 1201,
                padding: 0,
                backgroundColor: 'transparent'
                }
            });
        });
        
        var dataString = $("#formulario").serialize();
        var url="<?php echo site_url(); ?>Ca/Update_Saldo_Banco";

        if (Valida_Update_Saldo_Banco()) {
            $.ajax({
                type:"POST",
                url:url,
                data:dataString,
                success:function (data) {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        Lista_Saldo_Banco();
                        $("#acceso_modal_mod .close").click()
                    });
                }
            });       
        }
    }

    function Valida_Update_Saldo_Banco() {
        if($('#estado').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Estado.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
