<form id="formulario_update" class="formulario" method="POST" enctype="multipart/form-data">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title">Editar Tipo</h5>
    </div>

    <div class="modal-body" style="overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class=" text-bold">Nombre: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="nom_informe_u" name="nom_informe_u" placeholder="Nombre" maxlength="16" value="<?php echo $get_id[0]['nom_informe']; ?>" onkeypress="if(event.keyCode == 13){ Update_Tipo_Comercial(); }">
            </div>
            
            <div class="form-group col-md-2">
                <label class=" text-bold">Estado: </label>
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
        <input type="hidden" id="id_informe" name="id_informe" value="<?php echo $get_id[0]['id_informe']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Tipo_Comercial();">
            <i class="glyphicon glyphicon-ok-sign"></i>Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i>Cancelar
        </button>
    </div>
</form>

<script>
    function Update_Tipo_Comercial(){
        Cargando();

        var dataString = $("#formulario_update").serialize();
        var url="<?php echo site_url(); ?>General/Update_Tipo_Comercial";

        if (Valida_Update_Tipo_Comercial()) {
            $.ajax({
                type:"POST",
                url:url,
                data:dataString,
                success:function (data) {
                    if(data=="error"){
                        Swal({
                            title: 'Actualización Denegada',
                            text: "¡El registro ya existe!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        Lista_Tipo_Comercial();
                        $("#acceso_modal_mod .close").click()
                    }
                }
            });
        }
    }

    function Valida_Update_Tipo_Comercial() {
        if($('#nom_informe_u').val().trim() === "") { 
            Swal(
                'Ups!',
                'Debe ingresar Nombre.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#estado_u').val().trim() === "0") { 
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