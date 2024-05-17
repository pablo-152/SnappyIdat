<form id="formulario" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title">Editar Estado Bancario</h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-4">
                <label class="control-label text-bold">Empresa: </label>
                <select class="form-control" disabled>
                    <option value="0" <?php if(!(strcmp(0, $get_id[0]['id_empresa']))){ echo "selected=\"selected\""; } ?>>Seleccione</option>
                    <?php foreach ($list_empresa as $list) { ?>
                        <option value="<?php echo $list['id_empresa']; ?>" <?php if(!(strcmp($list['id_empresa'],$get_id[0]['id_empresa']))){ echo "selected=\"selected\""; } ?>>
                            <?php echo $list['nom_empresa']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-4">
                <label class="control-label text-bold">Cuenta Bancaria: </label>
                <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['cuenta_bancaria']; ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Mes&nbsp;Inicio: </label>
                <select class="form-control col-md-1" id="mes" name="mes">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_mes as $list){?>
                        <option value="<?php echo $list['cod_mes'] ?>" <?php if($get_id[0]['mes']==$list['cod_mes']){echo "selected";}?>><?php echo $list['nom_mes'] ?></option>    
                    <?php }?> 
                </select>
                <!--<input type="text"class="form-control" disabled value="<?php echo $get_id[0]['inicio']; ?>">-->
            </div>
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Año&nbsp;Inicio: </label>
                <select class="form-control col-md-1" id="anio" name="anio">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_anio as $list){?>
                        <option value="<?php echo $list['nom_anio'] ?>" <?php if($get_id[0]['anio']==$list['nom_anio']){echo "selected";}?>><?php echo $list['nom_anio'] ?></option>    
                    <?php }?> 
                </select>
                <!--<input type="text"class="form-control" disabled value="<?php echo $get_id[0]['inicio']; ?>">-->
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
        <button type="button" class="btn btn-primary" onclick="Update_Estado_Bancario();" data-loading-text="Loading..." autocomplete="off">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
    </div>
</form>

<script>
    function Update_Estado_Bancario(){
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
        var url="<?php echo site_url(); ?>Administrador/Update_Estado_Bancario";

        if (Valida_Estado_Bancario()) {
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
                        window.location = "<?php echo site_url(); ?>Administrador/Estado_Bancario";
                    });
                }
            });       
        }
    }

    function Valida_Estado_Bancario() {
        if($('#mes').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Mes de Inicio.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#anio').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Año de Inicio.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#estado').val() === '0') {
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
