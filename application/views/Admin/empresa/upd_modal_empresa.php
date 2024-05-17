
<div class="modal-content">
    <form class="form-horizontal" id="from_foto" method="POST" enctype="multipart/form-data" action="<?= site_url('Snappy/Update_Empresa')?>"  class="formulario">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Actualización de datos de la Empresa <b><?php echo $get_id[0]['cod_empresa']; ?></b></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body" style="max-height:450px; overflow:auto;">
            <div class="col-md-12 row">
                <div class="form-group col-md-2">
                    <label class="col-sm-3 control-label text-bold">Empresa: </label>
                </div>
                <div class="form-group col-md-10">
                    <input type="text" class="form-control" id="nom_empresa" name="nom_empresa" value="<?php echo $get_id[0]['nom_empresa']; ?>" placeholder="Ingresar Nombre" autofocus>
                </div>
                <div class="form-group col-md-2">
                    <label class="col-sm-3 control-label text-bold">Código: </label>
                </div>
                <div class="form-group col-sm-4">
                    <input type="text" class="form-control" id="cod_empresa" name="cod_empresa" value="<?php echo $get_id[0]['cod_empresa']; ?>" placeholder="Ingresar Código" autofocus>
                </div>
                <div class="form-group col-md-2">
                    <label class="col-sm-3 control-label text-bold">Orden: </label>
                </div>
                <div class="form-group col-sm-4">
                    <input type="text" class="form-control" id="orden_empresa" name="orden_empresa" value="<?php echo $get_id[0]['orden_empresa']; ?>" placeholder="Ingresar Orden" autofocus>
                </div>
                <div class="form-group col-md-2">
                    <label class="col-sm-3 control-label text-bold">Status: </label>
                </div>
                <div class="form-group col-sm-4">
                    <select class="form-control" name="id_status" id="id_status">
                    <option value="0" <?php if (!(strcmp(0, $get_id[0]['estado']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
                    <?php foreach($list_estado as $estado){ ?>
                        <option value="<?php echo $estado['id_status']; ?>" <?php if (!(strcmp($estado['id_status'], $get_id[0]['estado']))) {echo "selected=\"selected\"";} ?>><?php echo $estado['nom_status'];?></option>
                    <?php } ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label class="col-sm-11 control-label text-bold">Reporte Redes (mensual): </label>
                </div>
                <div class="form-group col-sm-2">
                    <input type="checkbox" id="rep_redes" name="rep_redes" <?php if($get_id[0]['rep_redes']==1){ echo "checked";} ?> value="1" class="minimal"/>
                </div>
                <div class="form-group col-md-2">
                    <label class="col-sm-3 control-label text-bold">Observaciones: </label>
                </div>
                <div class="col-sm-10">
                    <textarea name="observaciones_empresa" rows="4" class="form-control" id="observaciones_empresa"><?php echo $get_id[0]['observaciones_empresa']; ?></textarea>
                </div>
            </div>  	           	                	        
        </div> 
        <div class="modal-footer">
            <input name="id_empresa" type="hidden" class="form-control" id="id_empresa" value="<?php echo $get_id[0]['id_empresa']; ?>">
            <button type="button" class="btn btn-primary" id="createProductBtn" data-loading-text="Loading..." autocomplete="off">
                <i class="glyphicon glyphicon-ok-sign"></i> Guardar
            </button>
            <button type="button" class="btn btn-default" data-dismiss="modal">
                <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
            </button>
            
        </div>
    </form>
</div>

<script>

$(document).ready(function() {
    /**/var msgDate = '';
    var inputFocus = '';
	
});

$("#createProductBtn").on('click', function(e){
    if (valida_empresa()) {
        bootbox.confirm({
            title: "Actualizar Datos Empresa",
            message: "¿Desea actualizar datos de la empresa?",
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

function valida_empresa() {
    if($('#nom_empresa').val().trim() === '') {
        msgDate = 'Debe ingresar un nombre de Empresa.';
        inputFocus = '#nom_empresa';
        return false;
    }

    if($('#id_status').val() === '0') {
        msgDate = 'Debe seleccionar un estado.';
        inputFocus = '#id_status';
        return false;
    }
    return true;
}
</script>
