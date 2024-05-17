<style>
    .color_casilla{
        border-color: #715D74;
        color: #FFF;
        background-color: rgba(113,93,116,0.5) !important;
    }
</style>

<form id="formulario" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title">Actualizar Sub-Rubro</h5>
    </div>
    
    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Rubro:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control color_casilla" disabled>
                    <option value="0"<?php if(!(strcmp(0,$get_subrubro[0]['Id']))){ echo "selected=\"selected\""; } ?>>Seleccione</option>
                    <?php foreach($list_rubro as $list){ ?>
                        <option value="<?php echo $list['Id']; ?>" <?php if(!(strcmp($list['Id'],$get_subrubro[0]['ParentCostTypeId']))){ echo "selected=\"selected\""; } ?>><?php echo $list['Name'];?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Empresa(s):</label>
            </div>
            <?php if($validar==1){ ?>
                <div class="form-group col-md-4">
                    <select class="form-control multivalue_update_empresa" id="id_empresa" name="id_empresa[]" multiple="multiple">
                        <?php $base_array = explode(",",$get_id[0]['id_empresa']);
                            foreach($combo_empresa as $list){ ?>
                            <option value="<?php echo $list['id_empresa']; ?>" <?php if(in_array($list['id_empresa'],$base_array)){ echo "selected=\"selected\""; } ?>>
                                <?php echo $list['cd_empresa'];?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            <?php }else{ ?>
                <div class="form-group col-md-4">
                    <select class="form-control multivalue_update_empresa" id="id_empresa" name="id_empresa[]" multiple="multiple">
                        <?php foreach($combo_empresa as $list){ ?>
                            <option value="<?php echo $list['id_empresa']; ?>"><?php echo $list['cd_empresa']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            <?php } ?>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Subrubro: </label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control color_casilla" placeholder="Subrubro" value="<?php echo $get_subrubro[0]['Name']; ?>" disabled autofocus>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Tipo Doc.:</label>
            </div>
            <?php if($validar==1){ ?>
                <div class="form-group col-md-4">
                    <select class="form-control multivalue_update" id="id_tipo_documento" name="id_tipo_documento[]" multiple="multiple">
                        <?php $base_array = explode(",",$get_id[0]['id_tipo_documento']);
                            foreach($list_tipo_documento as $list){ ?>
                            <option value="<?php echo $list['ReceiptTypeId']; ?>" <?php if(in_array($list['ReceiptTypeId'],$base_array)){ echo "selected=\"selected\""; } ?>>
                                <?php echo $list['Description'];?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            <?php }else{ ?>
                <div class="form-group col-md-4">
                    <select class="form-control multivalue_update" id="id_tipo_documento" name="id_tipo_documento[]" multiple="multiple">
                        <?php foreach($list_tipo_documento as $list){ ?>
                            <option value="<?php echo $list['ReceiptTypeId']; ?>"><?php echo $list['Description'];?></option>
                        <?php } ?>
                    </select>
                </div>
            <?php } ?>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Status: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control color_casilla" disabled>
                    <option value="0" <?php if(!(strcmp(0, $get_subrubro[0]['StatusId']))){ echo "selected=\"selected\""; } ?>>Seleccione</option>
                    <?php foreach($list_estado as $list){ ?>
                        <option value="<?php echo $list['StatusId']; ?>" <?php if(!(strcmp($list['StatusId'],$get_subrubro[0]['StatusId']))){ echo "selected=\"selected\""; } ?>><?php echo $list['Description'];?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Obliga Doc.:</label>
            </div>
            <div class="form-group col-md-4">
                <?php if($validar==1){ ?>
                    <input type="checkbox" id="obliga_documento" name="obliga_documento" <?php if($get_id[0]['obliga_documento']==1){ echo "checked";} ?> value="1" onkeypress="if(event.keyCode == 13){ Update_Subrubro(); }">
                <?php }else{ ?>
                    <input type="checkbox" id="obliga_documento" name="obliga_documento" value="1" onkeypress="if(event.keyCode == 13){ Update_Subrubro(); }">
                <?php } ?>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Informe:</label>
            </div>
            <div class="form-group col-md-4">
                <?php if($validar==1){ ?>
                    <input type="checkbox" id="informe" name="informe" <?php if($get_id[0]['informe']==1){ echo "checked";} ?> value="1" onkeypress="if(event.keyCode == 13){ Update_Subrubro(); }">
                <?php }else{ ?>
                    <input type="checkbox" id="informe" name="informe" value="1" onkeypress="if(event.keyCode == 13){ Update_Subrubro(); }">
                <?php } ?>
            </div>
        </div>  	     
        
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Obliga Datos:</label>
            </div>
            <div class="form-group col-md-4">
                <?php if($validar==1){ ?>
                    <input type="checkbox" id="obliga_datos" name="obliga_datos" <?php if($get_id[0]['obliga_datos']==1){ echo "checked";} ?> value="1" onkeypress="if(event.keyCode == 13){ Update_Subrubro(); }">
                <?php }else{ ?>
                    <input type="checkbox" id="obliga_datos" name="obliga_datos" value="1" onkeypress="if(event.keyCode == 13){ Update_Subrubro(); }">
                <?php } ?>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">RUC: </label>
            </div>
            <div class="form-group col-md-4">
                <?php if($validar==1){ ?>
                    <input type="text" class="form-control" id="ruc" name="ruc" placeholder="RUC" maxlength="11" value="<?php echo $get_id[0]['ruc']; ?>" autofocus onkeypress="if(event.keyCode == 13){ Update_Subrubro(); }">
                <?php }else{ ?>
                    <input type="text" class="form-control" id="ruc" name="ruc" placeholder="RUC" maxlength="11" autofocus onkeypress="if(event.keyCode == 13){ Update_Subrubro(); }">
                <?php } ?>
            </div>
        </div>  	   
    </div> 

    <div class="modal-footer">
        <?php if($validar==1){ ?>
            <input type="hidden" id="id_subrubro" name="id_subrubro" value="<?php echo $get_id[0]['id_subrubro']; ?>">
        <?php } ?>
        <input type="hidden" id="id" name="id" value="<?php echo $get_subrubro[0]['Id']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Subrubro();">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
    </div>
</form>

<script>
    var ss = $(".multivalue_update").select2({
        tags: true
    });

    $('.multivalue_update').select2({
        dropdownParent: $('#acceso_modal_mod')
    });

    var ss = $(".multivalue_update_empresa").select2({
        tags: true
    });

    $('.multivalue_update_empresa').select2({
        dropdownParent: $('#acceso_modal_mod')
    });

    $('#ruc').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    function Update_Subrubro() {
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
        var url = "<?php echo site_url(); ?>Administrador/Update_Subrubro";

        if (Valida_Subrubro()) {
            $.ajax({
                type: "POST",
                url: url,
                data: dataString,
                success: function(data) {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        window.location = "<?php echo site_url(); ?>Administrador/Subrubro";
                    });
                }
            });
        }
    }

    function Valida_Subrubro() {
        /*if($('#id_empresa').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Empresa.',
                'warning'
            ).then(function() { });
            return false;
        }*/
        return true;
    }
</script>
