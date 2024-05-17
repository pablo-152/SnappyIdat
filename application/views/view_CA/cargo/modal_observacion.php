<form id="formulario_h" method="POST" enctype="multipart/form-data"  class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Actualizar Observación: </b></h5>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-12">
                <label>Observación:</label>
                <div class="col">
                    <textarea class="form-control" rows="5" id="observacion_h" name="observacion_h" placeholder="Ingresar Observación" maxlength="500"><?= $get_id[0]['observacion_h']; ?></textarea>
                </div>
            </div>
        </div>  	           	                	        
    </div>

    <div class="modal-footer">
        <input type="hidden" name="id" value="<?= $get_id[0]['id']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Observacion_Cargo();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
        
    </div>
</form>

<script>
    function Update_Observacion_Cargo(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_h'));
        var url="<?php echo site_url(); ?>Ca/Update_Observacion_Cargo_Historial";

        if (Valida_Update_Observacion_Cargo()) {
            $.ajax({
                type:"POST",
                url: url,
                data:dataString,
                processData: false,
                contentType: false,
                success:function () {
                    $("#acceso_modal_mod .close").click()
                }
            });     
        }
    }

    function Valida_Update_Observacion_Cargo() {
        if($('#observacion_h').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar observación.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
