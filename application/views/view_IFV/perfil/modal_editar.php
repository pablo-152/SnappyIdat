<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Editar Mailing</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Nombre:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="nom_perfile" name="nom_perfile" placeholder="Nombre" value="<?php echo $get_id[0]['nom_perfil']; ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Estado:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="estadoe" name="estadoe">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_estado as $list){ ?>
                        <option value="<?php echo $list['id_status']; ?>" 
                        <?php if($list['id_status']==$get_id[0]['estado']){ echo "selected"; } ?>>
                            <?php echo $list['nom_status']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>  
    </div>
    
    <div class="modal-footer">
        <input type="hidden" id="id_perfil" name="id_perfil" value="<?php echo $get_id[0]['id_perfil']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Perfil();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Update_Perfil(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_update'));
        var url="<?php echo site_url(); ?>AppIFV/Update_Perfil";

        if (Valida_Update_Perfil()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
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
                        Lista_Perfil();
                        $("#acceso_modal_mod .close").click()                        
                    }
                }
            });
        }
    }

    function Valida_Update_Perfil() {
        if($('#nom_perfile').val().trim() === '') { 
            Swal(
                'Ups!',
                'Debe ingresar nombre.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#estadoe').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar estado.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
