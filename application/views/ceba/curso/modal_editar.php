
<div class="modal-content">
    <form class="form-horizontal" id="from_foto" method="POST" enctype="multipart/form-data" action="<?= site_url('Ceba/Update_Curso')?>"  class="formulario">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Actualización del Curso <b><?php echo $get_id[0]['id_curso']; ?></b></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body" style="max-height:450px; overflow:auto;">
            <div class="col-md-12 row">
                        <div class="form-group col-md-2">
                        <label class="col-sm-3 control-label text-bold">Año: </label>
                        </div>
                        <div class="form-group col-md-4">
                            <select class="form-control" name="id_anio" id="id_anio" >
                                            <option value="0">Seleccione</option>
                                            <?php foreach($list_anio as $nivel){ 
                                            if($get_id[0]['id_anio'] == $nivel['id_anio']){ ?>
                                            <option selected value="<?php echo $nivel['id_anio'] ; ?>">
                                            <?php echo "".$nivel['nom_anio'];?></option>
                                            <?php }else
                                            {?>
                                            <option value="<?php echo $nivel['id_anio']; ?>"><?php echo "".$nivel['nom_anio'];?></option>
                                            <?php }} ?>
                                    </select>
                        </div>
                        <div class="form-group col-md-2">
                        <label class="col-sm-3 control-label text-bold">Grado: </label>
                        </div>
                        <div class="form-group col-md-4">
                            <select class="form-control" name="id_grado" id="id_grado" >
                                            <option value="0">Seleccione</option>
                                            <?php foreach($list_grado as $nivel){ 
                                            if($get_id[0]['id_grado'] == $nivel['id_grado']){ ?>
                                            <option selected value="<?php echo $nivel['id_grado'] ; ?>">
                                            <?php echo "".$nivel['nom_grado'];?></option>
                                            <?php }else
                                            {?>
                                            <option value="<?php echo $nivel['id_grado']; ?>"><?php echo "".$nivel['nom_grado'];?></option>
                                            <?php }} ?>
                                    </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label class="col-sm-3 control-label text-bold">Inicio Matrículas: </label>
                        </div>
                        <div class="form-group col-md-4">
                                 <input value="<?php echo $get_id[0]['fec_inicio']; ?>" class="form-control" required type="date" id="fec_inicio" name="fec_inicio" placeholder= "Seleccionar Fecha inicio de matricula" type="text" />
                                            
                        </div>
                        <div class="form-group col-md-2">
                            <label class="col-sm-3 control-label text-bold">Fin Matrículas: </label>
                        </div>
                        <div class="form-group col-md-4">
                                 <input value="<?php echo $get_id[0]['fec_fin']; ?>" class="form-control" required type="date" id="fec_fin" name="fec_fin" placeholder= "Seleccionar Fecha de fin de matrícula" type="text" />
                        </div>

                        <div class="form-group col-md-2">
                            <label class="col-sm-3 control-label text-bold">Curso a Copiar: </label>
                        </div>
                        <div class="form-group col-md-4">
                            <select disabled class="form-control" name="id_curso" id="id_curso">
                            <option value="0">Seleccione</option>
                                <?php foreach($list_grado as $nivel){ ?>
                                <option value="<?php echo $nivel['id_grado'] ; ?>">
                                <?php echo "Grado: ".$nivel['nom_grado'];?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label class="col-sm-3 control-label text-bold">Estado: </label>
                        </div>
                        <div class="form-group col-md-4">
                            
                                    <select class="form-control" name="id_status" id="id_status">
                                    <option value="0" <?php if (!(strcmp(0, $get_id[0]['estado']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
                                    <?php foreach($list_estado as $estado){ ?>
                                        <option value="<?php echo $estado['id_status']; ?>" <?php if (!(strcmp($estado['id_status'], $get_id[0]['estado']))) {echo "selected=\"selected\"";} ?>><?php echo $estado['nom_status'];?></option>
                                    <?php } ?>
                                    </select>
                                
                        </div>

                        
                        <div class="form-group col-md-12">
                            <label class="col-sm-3 control-label text-bold">Observaciones:</label>
                            <div class="form-group col-md-12">
                            <textarea type="text" name="obs_curso" rows="5" class="form-control" id="obs_curso" > <?php echo $get_id[0]['obs_curso']?> </textarea>
                            
                        </div>
                        </div>

            </div>  	           	                	        
        </div> 
        <div class="modal-footer">
            <input name="id_curso" type="hidden" class="form-control" id="id_curso" value="<?php echo $get_id[0]['id_curso']; ?>">
            
            <button type="button" class="btn btn-primary" id="createProductBtn" data-loading-text="Loading..." autocomplete="off">
                <i class="glyphicon glyphicon-ok-sign"></i> Guardar
                
            </button>

            <button type="button" class="btn btn-default" data-dismiss="modal">
                <i class="glyphicon glyphicon-remove-sign"></i> Cerrar
            </button>
            
        </div>
    </form>
</div>

<script>

$(document).ready(function() {
    var msgDate = '';
    var inputFocus = '';
	
});

$("#createProductBtn").on('click', function(e){
    if (valida_curso()) {
        bootbox.confirm({
            title: "Actualizar Curso",
            message: "¿Desea ctualizar el curso?",
            buttons: {
                cancel: {
                    label: 'Cancelar'
                },
                confirm: {
                    label: 'Confirmar'
                }
            },
            callback: function (result) {
                if (result) {
                    $('#from_foto').submit();
                }
            } 
        });        
}
else{
        bootbox.alert(msgDate)
        var input = $(inputFocus).parent();
        $(input).addClass("has-error");
        $(input).on("change", function () {
            if ($(input).hasClass("has-error")) {
                $(input).removeClass("has-error");
            }
        });
    }

});

function valida_curso() {
    if($('#id_anio').val().trim() === '0') {
        msgDate = 'Debe seleccionar un año';
        inputFocus = '#id_anio';
        return false;
    }if($('#fec_inicio').val().trim() === '') {
        msgDate = 'Debe seleccionar fecha de inicio de matrícula';
        inputFocus = '#fec_inicio';
        return false;
    }if($('#fec_fin').val().trim() === '') {
        msgDate = 'Debe seleccionar fecha de fin de matrícula';
        inputFocus = '#fec_fin';
        return false;
    }if($('#id_status').val().trim() === '0') {
        msgDate = 'Debe seleccionar un estado';
        inputFocus = '#id_status';
        return false;
    }



    return true;
}
</script>