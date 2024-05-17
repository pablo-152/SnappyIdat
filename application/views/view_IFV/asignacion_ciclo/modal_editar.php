<form class="form-horizontal" id="formulario" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Ciclo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Carrera:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="id_carrera" id="id_carrera">
                    <option value="0" <?php if (!(strcmp(0, $get_id[0]['id_carrera']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
                    <?php foreach($list_carrera as $list){ 
                        if($list['id_especialidad']==1){ ?>
                            <option value="<?php echo $list['id_carrera']; ?>" <?php if (!(strcmp($list['id_carrera'], $get_id[0]['id_carrera']))) {echo "selected=\"selected\"";} ?>><?php echo $list['codigo'];?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Ciclo:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="number" class="form-control" id="ciclo" name="ciclo" value="<?php echo $get_id[0]['ciclo']; ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Estado:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="estado" id="estado">
                    <option value="0" <?php if (!(strcmp(0, $get_id[0]['estado']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
                    <?php foreach($list_estado as $list){ ?>
                        <option value="<?php echo $list['id_status']; ?>" <?php if (!(strcmp($list['id_status'], $get_id[0]['estado']))) {echo "selected=\"selected\"";} ?>><?php echo $list['nom_status'];?></option>
                    <?php } ?>
                </select>
            </div>
        </div>  	           	                	        
    </div> 
    
    <div class="modal-footer">
        <input type="hidden" id="id_asignacion_ciclo" name="id_asignacion_ciclo" value="<?php echo $get_id[0]['id_asignacion_ciclo']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Asignacion_Ciclo();" data-loading-text="Loading..." autocomplete="off">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    $(document).ready(function() {
        var msgDate = '';
        var inputFocus = '';  
    })

    function Update_Asignacion_Ciclo(){
        var dataString = $("#formulario").serialize();
        var url="<?php echo site_url(); ?>AppIFV/Update_Asignacion_Ciclo";
        if (Valida_Asignacion_Ciclo()) {
            $.ajax({
                type:"POST",
                url:url,
                data:dataString,
                success:function (data) {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        window.location = "<?php echo site_url(); ?>AppIFV/Asignacion_Ciclo";
                    });
                }
            });
        }else{
            bootbox.alert(msgDate)
            var input = $(inputFocus).parent();
            $(input).addClass("has-error");
            $(input).on("change", function () {
                if ($(input).hasClass("has-error")) {
                    $(input).removeClass("has-error");
                }
            });
        }
    }

    function Valida_Asignacion_Ciclo() {
        if($('#id_carrera').val().trim() === '0') {
            msgDate = 'Debe seleccionar carrera.';
            inputFocus = '#id_carrera';
            return false;
        }
        if($('#ciclo').val() == '') {
            msgDate = 'Debe ingresar ciclo.';
            inputFocus = '#ciclo';
            return false;
        }
        return true;
    }
</script>
