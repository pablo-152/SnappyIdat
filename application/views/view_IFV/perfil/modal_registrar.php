<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button> 
        <h5 class="modal-title"><b>Perfil (Nuevo)</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Nombre:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="nom_perfil" name="nom_perfil" placeholder="Nombre">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Estado:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="estado" name="estado">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_estado as $list){ ?>
                        <option value="<?php echo $list['id_status']; ?>" <?php if($list['id_status']==2){ echo "selected"; } ?>>
                            <?php echo $list['nom_status']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>  
    </div>
    
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Perfil();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Insert_Perfil(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_insert'));
        var url="<?php echo site_url(); ?>AppIFV/Insert_Perfil";

        if (Valida_Insert_Perfil()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
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
                        Lista_Perfil();
                        $("#acceso_modal .close").click()
                    }
                }
            });
        }
    }

    function Valida_Insert_Perfil() {
        if($('#nom_perfil').val().trim() === '') { 
            Swal(
                'Ups!',
                'Debe ingresar nombre.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#estado').val().trim() === '0') {
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
