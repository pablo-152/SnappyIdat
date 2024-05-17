
<form id="formulario_horario_update" method="post" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Horario</h5>  
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Estado: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="estado_h" name="estado_h">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_estado as $list){ ?>
                        <option value="<?php echo $list['id_estado'] ?>" <?php if($list['id_estado']==$get_id[0]['estado_h']){ echo "selected"; } ?>>
                            <?php echo $list['nom_estado']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Horas: </label> 
            </div>
            <div class="form-group col-md-4">
                <input class="form-control solo_numero" type="text" id="horas" name="horas" value="<?php echo $get_id[0]['horas']; ?>">
            </div>
        </div>
    </div> 

    <div class="modal-footer">
        <input type="hidden" id="id_horario" name="id_horario" value="<?php echo $get_id[0]['id_horario']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Horario();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button> 
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    $('.solo_numero').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    function Update_Horario(){ 
        Cargando();
        
        var dataString = new FormData(document.getElementById('formulario_horario_update'));
        var url="<?php echo site_url(); ?>AppIFV/Update_Horario_Grupo_C";

        if (Valida_Update_Horario()) {
            $.ajax({
                type:"POST",
                url:url,
                data: dataString,
                processData: false,
                contentType: false,
                success:function (data) {
                    Lista_Horario();
                    $("#acceso_modal_mod .close").click()
                }
            });        
        }  
    }

    function Valida_Update_Horario() {
        if($('#estado_h').val().trim() === '0') {
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