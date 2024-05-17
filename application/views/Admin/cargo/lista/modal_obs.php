<form id="formulario_m" method="POST" enctype="multipart/form-data"  class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Actualizar Observación: </b></h5>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-12">
                <label>Observación:</label>
                <div class="col">
                    <textarea name="obs" type="text" maxlength="500" rows="5" class="form-control" id="obs"><?php echo $get_id[0]['observacion'] ?></textarea>
                </div>
            </div>

        
        </div>  	           	                	        
    </div>

    <div class="modal-footer">
        <input name="id_cargo" type="hidden" class="form-control" id="id_cargo" value="<?php echo $get_id[0]['id_cargo']; ?>">
        <input name="id_cargo_historial" type="hidden" class="form-control" id="id_cargo_historial" value="<?php echo $get_id[0]['id_cargo_historial']; ?>">
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

        var dataString = new FormData(document.getElementById('formulario_m'));
        var url="<?php echo site_url(); ?>Snappy/Update_Obs_Cargo_Historial";

        if (Valida_Update_Observacion_Cargo()) {
            $.ajax({
                type:"POST",
                url: url,
                data:dataString,
                processData: false,
                contentType: false,
                success:function (data) {
                    window.location.reload();
                }
            });     
        }
    }

    function Valida_Update_Observacion_Cargo() {
        if($('#obs').val().trim() === '') {
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
