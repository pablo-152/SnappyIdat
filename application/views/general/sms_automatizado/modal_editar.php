<form id="formulario_update" method="POST" enctype="multipart/form-data">
    <div class="modal-header">
        <h3 class="tile-title">Editar SMS Automatizado</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <div class="modal-body" style="overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="text-bold">Empresa: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="id_empresa_u" name="id_empresa_u" onchange="Traer_Sede_U();">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_empresa as $list){ ?>
                        <option value="<?php echo $list['id_empresa']; ?>" <?php if($list['id_empresa']==$get_id[0]['id_empresa']){ echo "selected"; } ?>>
                            <?php echo $list['cod_empresa']; ?>
                        </option>
                    <?php } ?>
                </select>                
            </div>

            <div class="form-group col-md-2">
                <label class="text-bold">Sede: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="id_sede_u" name="id_sede_u">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_sede as $list){ ?>
                        <option value="<?php echo $list['id_sede']; ?>" <?php if($list['id_sede']==$get_id[0]['id_sede']){ echo "selected"; } ?>>
                            <?php echo $list['cod_sede']; ?>
                        </option>
                    <?php } ?> 
                </select>                
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="text-bold">Tipo: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="tipo_u" name="tipo_u">
                    <option value="0">Seleccione</option>
                    <option value="1" <?php if($get_id[0]['tipo']==1){ echo "selected"; } ?>>Aniversario</option>
                    <option value="2" <?php if($get_id[0]['tipo']==2){ echo "selected"; } ?>>EFSRT</option>
                </select>                
            </div>

            <div class="form-group col-md-6">
                <input type="checkbox" id="unitario_u" name="unitario_u" value="1" <?php if($get_id[0]['unitario']==1){ echo "checked"; } ?>>
                <label class="text-bold">Unitario</label>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="text-bold">Motivo: </label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="motivo_u" name="motivo_u" placeholder="Motivo" value="<?php echo $get_id[0]['motivo']; ?>" onkeypress="if(event.keyCode == 13){ Update_Sms_Automatizado(); }">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="text-bold">Descripción: </label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="descripcion_u" name="descripcion_u" placeholder="Descripción" value="<?php echo $get_id[0]['descripcion']; ?>" onkeypress="if(event.keyCode == 13){ Update_Sms_Automatizado(); }">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="text-bold">Regularidad: </label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="regularidad_u" name="regularidad_u" placeholder="Regularidad" value="<?php echo $get_id[0]['regularidad']; ?>" onkeypress="if(event.keyCode == 13){ Update_Sms_Automatizado(); }">            </div>
        </div>
            
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="text-bold">Estado: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="estado_u" name="estado_u">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_estado as $list){ ?>
                        <option value="<?php echo $list['id_status']; ?>" <?php if($list['id_status']==$get_id[0]['estado']){ echo "selected"; } ?>>
                            <?php echo $list['nom_status']; ?>
                        </option>
                    <?php } ?>
                </select>                
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input type="hidden" id="id_sms" name="id_sms" value="<?php echo $get_id[0]['id_sms']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Sms_Automatizado();">
            <i class="glyphicon glyphicon-ok-sign"></i>Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i>Cancelar
        </button>
    </div>
</form>

<script>
    function Traer_Sede_U(){
        Cargando();
        
        var url = "<?php echo site_url(); ?>General/Traer_Sede_Sms_Automatizado";
        var id_empresa = $("#id_empresa_u").val();

        $.ajax({
            url: url,
            type: 'POST',
            data: {'id_empresa':id_empresa},
            success: function(data){
                $('#id_sede_u').html(data);
            }
        });
    }

    function Update_Sms_Automatizado(){
        Cargando();
        
        var dataString = $("#formulario_update").serialize();
        var url="<?php echo site_url(); ?>General/Update_Sms_Automatizado";

        if (Valida_Update_Sms_Automatizado()) {
            $.ajax({
                type:"POST",
                url:url,
                data:dataString,
                success:function (data) {
                    if(data=="error"){
                        Swal({
                            title: 'Registro Denegado',
                            text: "¡El registro ya existe!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        Lista_Sms_Automatizado();
                        $("#acceso_modal_mod .close").click()
                    }
                }
            });
        }
    }

    function Valida_Update_Sms_Automatizado() {
        if($('#id_empresa_u').val()=="0") { 
            Swal(
                'Ups!',
                'Debe seleccionar Empresa.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_sede_u').val()=="0") { 
            Swal(
                'Ups!',
                'Debe seleccionar Sede',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#tipo_u').val()=="0") { 
            Swal(
                'Ups!',
                'Debe seleccionar Tipo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#estado_u').val()=="0") { 
            Swal(
                'Ups!',
                'Debe seleccionar Estado',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>