<form id="formulario_update_cargo_colaborador" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Cargo Fotocheck</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row text-right">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Nombre:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="nom_cf_u" name="nom_cf_u" placeholder="Nombre" value="<?php echo $get_id[0]['nom_cf']; ?>">
            </div>

            <div class="form-group col-md-2 text-right">
                <label class="control-label text-bold">Estado:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="estado_u" name="estado_u">
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
        <input type="hidden" id="id_cf" name="id_cf" value="<?php echo $get_id[0]['id_cf']; ?>">
        <input type="hidden" name="id_sede_u" id="id_sede_u" value="<?php echo $get_id[0]['idsede_cf']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Cargo_Fotocheck_Colaborador();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Update_Cargo_Fotocheck_Colaborador(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_update_cargo_colaborador'));
        var url="<?php echo site_url(); ?>Colaborador/Update_Cargo_Fotocheck_Colaborador";

        if (Valida_Update_Cargo_Fotocheck_Colaborador()) {
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
                        Lista_Cargo_Fotocheck_Colaborador();
                        $("#acceso_modal_mod .close").click()                        
                    }
                }
            });
        }
    }

    function Valida_Update_Cargo_Fotocheck_Colaborador() {
        if($('#nom_cf_u').val().trim() === '') { 
            Swal(
                'Ups!',
                'Debe ingresar nombre.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#estado_u').val().trim() === '0') {
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
