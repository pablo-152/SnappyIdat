<form id="formulario" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" style="color: #715d74;font-size: 21px;"><b>Editar Sede</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
    
    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-4">
                <label class="text-bold">Empresa: </label>
                <div class="col">
                    <select class="form-control" name="id_empresa" id="id_empresa">
                        <option value="0">Seleccione</option>
                    <?php foreach($list_empresa as $empresa){ 
                        if($get_id[0]['id_empresa'] == $empresa['id_empresa']){ ?>
                        <option selected value="<?php echo $empresa['id_empresa'] ; ?>">
                            <?php echo $empresa['cod_empresa'];?></option>
                    <?php }else{?>
                        <option value="<?php echo $empresa['id_empresa']; ?>"><?php echo $empresa['cod_empresa'];?></option>
                    <?php }} ?>
                    </select>
                </div>
            </div>


            <div class="form-group col-md-4">
                <label class="text-bold">Código: </label>
                <div class="col">
                    <select class="form-control" name="cod_sede" id="cod_sede">
                        <option value="" <?php if (!(strcmp(0, $get_id[0]['codigo_sede']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
                        <option value="0" <?php if (!(strcmp(0, $get_id[0]['codigo_sede']))) {echo "selected=\"selected\"";} ?>>0</option>
                        <option value="1" <?php if (!(strcmp(1, $get_id[0]['codigo_sede']))) {echo "selected=\"selected\"";} ?>>1</option>
                        <option value="2" <?php if (!(strcmp(2, $get_id[0]['codigo_sede']))) {echo "selected=\"selected\"";} ?>>2</option>
                        <option value="3" <?php if (!(strcmp(3, $get_id[0]['codigo_sede']))) {echo "selected=\"selected\"";} ?>>3</option>
                        <option value="4" <?php if (!(strcmp(4, $get_id[0]['codigo_sede']))) {echo "selected=\"selected\"";} ?>>4</option>
                        <option value="5" <?php if (!(strcmp(5, $get_id[0]['codigo_sede']))) {echo "selected=\"selected\"";} ?>>5</option>
                        <option value="6" <?php if (!(strcmp(6, $get_id[0]['codigo_sede']))) {echo "selected=\"selected\"";} ?>>6</option>
                        <option value="7" <?php if (!(strcmp(7, $get_id[0]['codigo_sede']))) {echo "selected=\"selected\"";} ?>>7</option>
                        <option value="8" <?php if (!(strcmp(8, $get_id[0]['codigo_sede']))) {echo "selected=\"selected\"";} ?>>8</option>
                        <option value="9" <?php if (!(strcmp(9, $get_id[0]['codigo_sede']))) {echo "selected=\"selected\"";} ?>>9</option>
                    </select>
                </div>
            </div>

            <div class="form-group col-md-4">
                <label class="text-bold">Base de Datos: </label>
                <select class="form-control" id="b_datos" name="b_datos">
                    <option value="0" <?php if($get_id[0]['b_datos']==0){ echo "selected"; } ?>>No</option>
                    <option value="1" <?php if($get_id[0]['b_datos']==1){ echo "selected"; } ?>>Si</option>
                </select>
            </div>


            <div class="form-group col-md-4">
                <label class="text-bold">Local:</label>

                <div class="col">
                    <select class="form-control" id="id_local" name="id_local">
                        <option value="0" <?php if($get_id[0]['id_local']==0){ echo "selected"; } ?>>Ninguno</option>
                        <option value="1" <?php if($get_id[0]['id_local']==1){ echo "selected"; } ?>>Jesus Maria</option>
                        <option value="2" <?php if($get_id[0]['id_local']==2){ echo "selected"; } ?>>Chincha</option>
                    </select>
                </div>
            </div>

            <div class="form-group col-md-4">
                <label class="text-bold">Aparece Menú: </label>
                <select class="form-control" id="aparece_menu" name="aparece_menu">
                    <option value="0" <?php if($get_id[0]['aparece_menu']==0){ echo "selected"; } ?>>No</option>
                    <option value="1" <?php if($get_id[0]['aparece_menu']==1){ echo "selected"; } ?>>Si</option>
                </select>
            </div>

            <div class="form-group col-md-4">
                <label class="text-bold">Orden Menú: </label>
                <input type="text" class="form-control" id="orden_menu" name="orden_menu" placeholder="Orden Menú" value="<?php echo $get_id[0]['orden_menu']; ?>">
            </div>

            <div class="form-group col-md-12">
                <label class="col-sm-3 control-label text-bold">Observaciones: </label>
                <div class="col">
                    <textarea name="observaciones_sede" rows="4" class="form-control" id="observaciones_sede" > <?php echo $get_id[0]['observaciones_sede']; ?></textarea>
                </div>
            </div>
            
            <div class="form-group col-md-4">
                <label class="text-bold">Status: </label>
                <div class="col">
                    <select class="form-control" name="estado" id="estado">
                    <option value="0" <?php if (!(strcmp(0, $get_id[0]['estado']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
                    <?php foreach($list_estado as $estado){ ?>
                        <option value="<?php echo $estado['id_status']; ?>"
                            <?php if (!(strcmp($estado['id_status'],
                            $get_id[0]['estado']))) {echo "selected=\"selected\"";} ?>>
                            <?php echo $estado['nom_status'];?></option>
                    <?php } ?>
                    </select>
                </div>
            </div>

        </div>  	           	                	        
    </div> 
    
    <div class="modal-footer">
        <input name="id_sede" type="hidden" class="form-control" id="id_sede" value="<?php echo $get_id[0]['id_sede']; ?>">
        <button type="button" style="background-color:#715d74;border-color:#715d74" class="btn btn-primary" onclick="Update_Sede()" data-loading-text="Loading..." autocomplete="off">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    $('#orden_menu').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    function pulsar(e) {
        if (e.keyCode === 13 && !e.shiftKey) {
            e.preventDefault();
            Update_Sede();
        }
    }
    
    function Update_Sede(){
        $(document)
        .ajaxStart(function () {
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
        .ajaxStop(function () {
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
        var url="<?php echo site_url(); ?>General/update_sede";

        if (valida_sede()) {
            $.ajax({
                type:"POST",
                url:url,
                data:dataString,
                success:function (data) {
                    if(data=="limiteemp") {
                        Swal({
                            title: 'Actualización Denegada',
                            text: "¡Solo se pueden asignar sedes para 6 empresas, por favor verificar!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else if(data=="xempresa") {
                        Swal({
                            title: 'Actualización Denegada',
                            text: '¡Solo se pueden asignar 3 sedes por empresa para Base de Datos!',
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else if(data=="bd") {
                        Swal({
                            title: 'Actualización Denegada',
                            text: "¡Solo se pueden asignar 18 sedes en total para Base de Datos!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        swal.fire(
                            'Actualización Exitosa!',
                            'Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            window.location = "<?php echo site_url(); ?>General/Sedes";
                        });
                    }
                }
            });         
        }
    }

    function valida_sede() {
        if($('#id_empresa').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Empresa.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#cod_sede').val() === '') {
            Swal(
                'Ups!',
                'Debe seleccionar Código.',
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
