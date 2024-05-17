<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title">Editar Publicidad</h5>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;"> 
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Campaña: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="campania" name="campania" placeholder="Campaña" value="<?php if(count($get_id)>0){ echo $get_id[0]['campania']; } ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Tipo: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="tipo" id="tipo">
                    <option value="0">Seleccione</option>
                    <option value="1" <?php if(count($get_id)>0 && $get_id[0]['tipo']==1){ echo "selected"; } ?>>Whatsapp</option>
                    <option value="2" <?php if(count($get_id)>0 && $get_id[0]['tipo']==2){ echo "selected"; } ?>>Mensaje</option>
                    <option value="3" <?php if(count($get_id)>0 && $get_id[0]['tipo']==3){ echo "selected"; } ?>>Me Gusta</option>
                    <option value="4" <?php if(count($get_id)>0 && $get_id[0]['tipo']==4){ echo "selected"; } ?>>Otro</option>
                </select>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Del día: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="del_dia" name="del_dia" value="<?php if(count($get_id)>0){ echo $get_id[0]['del_dia']; } ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Hasta: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="hasta" name="hasta" value="<?php if(count($get_id)>0){ echo $get_id[0]['hasta']; } ?>">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Alcance: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control solo_numeros" id="alcance" name="alcance" placeholder="Alcance" value="<?php if(count($get_id)>0){ echo $get_id[0]['alcance']; } ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Interacciones: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control solo_numeros" id="interacciones" name="interacciones" placeholder="Interacciones" value="<?php if(count($get_id)>0){ echo $get_id[0]['interacciones']; } ?>">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Monto: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control solo_numeros_punto" id="monto" name="monto" placeholder="Monto" value="<?php if(count($get_id)>0){ echo $get_id[0]['monto']; } ?>">
            </div>     	                	        
        </div>
    </div>

    <div class="modal-footer">
        <input type="hidden" id="id_proyecto" name="id_proyecto" value="<?php echo $id_proyecto; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Publicidad();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    $('.solo_numeros').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    $('.solo_numeros_punto').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9.,-]/g, '');
    });

    function Update_Publicidad(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_update'));
        var url="<?php echo site_url(); ?>Administrador/Update_Publicidad";

        if (Valida_Update_Publicidad()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                processData: false,
                contentType: false, 
                success:function (data) {
                    Lista_Publicidad(); 
                    $("#acceso_modal_mod .close").click()
                }
            });
        }    
    }

    function Valida_Update_Publicidad() {
        return true;
    }
</script>