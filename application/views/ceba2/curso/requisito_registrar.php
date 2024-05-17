
<div class="modal-content">
    <form class="form-horizontal" id="from_foto" method="POST" enctype="multipart/form-data" action="<?= site_url('Ceba/Insert_Requisito')?>"  class="formulario">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Requisito (Nuevo)</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body" style="max-height:450px; overflow:auto;">
	            	<div class="col-md-12 row">
	                	<div class="form-group col-md-2">
	                    <label class="col-sm-3 control-label text-bold">Grado: </label>
	                	</div>
	                	<div class="form-group col-md-4">
	               			<select class="form-control" name="id_grado" id="id_grado">
	                    		<option value="0">Seleccione</option>
	                    		<?php foreach($list_grado as $nivel){ ?>
	                        	<option value="<?php echo $nivel['id_grado'] ; ?>">
	                            <?php echo $nivel['nom_grado'];?></option>
	                    	<?php } ?>
	                    	</select>
	                    </div>

	                    
                		<div class="form-group col-md-2">
	                    <label class="col-sm-3 control-label text-bold">Tipo: </label>
	                	</div>
                
                		<div class="form-group col-md-4">
	           				<select class="form-control" name="id_tipo_requisito" id="id_tipo_requisito">
	                		<option value="0">Seleccione</option>
	                			<?php foreach($list_tipo_requisito as $nivel){ ?>
	                    		<option value="<?php echo $nivel['id_tipo_requisito'] ; ?>">
	                        	<?php echo $nivel['nom_tipo_requisito'];?></option>
	                			<?php } ?>
	                		</select>
	                	</div>
                		<div class="form-group col-md-2">
	                    	<label class="col-sm-3 control-label text-bold">Descripción: </label>
	                	</div>
                		<div class="form-group col-md-4">
                                 <input class="form-control" required type="text" id="desc_requisito" name="desc_requisito" placeholder= "Ingresar Descripción" type="text" />
                 		</div>
                 		<div class="form-group col-md-2">
	                    	<label class="col-sm-3 control-label text-bold">Estado: </label>
	                	</div>
                		
                		<div class="form-group col-md-4">
	           				<select required class="form-control" name="id_status" id="id_status">
	                		<option  value="2">Seleccione</option>
	                			

                                <?php foreach($list_estado as $nivel){ 
                                            if($nivel['id_status'] ==2){ ?>
                                            <option selected value="<?php echo $nivel['id_status'] ; ?>">
                                            <?php echo $nivel['nom_status'];?></option>
                                            <?php }else
                                            {?>
                                            <option value="<?php echo $nivel['id_status']; ?>"><?php echo $nivel['nom_status'];?></option>
                                            <?php }} ?>
	                		</select>
	                	</div>
                        
                        

	            	</div>

        </div> 
        <div class="modal-footer">

            <button type="button" class="btn btn-default" data-dismiss="modal">
                <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
            </button>
            <button type="button" class="btn btn-primary" id="createProductBtn" data-loading-text="Loading..." autocomplete="off">
                <i class="glyphicon glyphicon-ok-sign"></i> Guardar
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
    if (valida_requisito()) {
        bootbox.confirm({
            title: "Registrar Requisito",
            message: "¿Desea registrar requisito?",
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

function valida_requisito() {
    if($('#id_grado').val().trim() === '0') {
        msgDate = 'Debe seleccionar un grado';
        inputFocus = '#id_grado';
        return false;
    }if($('#id_tipo_requisito').val().trim() === '0') {
        msgDate = 'Debe seleccionar un requisito';
        inputFocus = '#id_tipo_requisito';
        return false;
    }if($('#id_status').val().trim() === '') {
        msgDate = 'Debe seleccionar un estado';
        inputFocus = '#id_status';
        return false;
    }
    /*if($('#id_copiar').val().trim() === '0') {
        msgDate = 'Debe seleccionar un curso a copiar';
        inputFocus = '#id_copiar';
        return false;
    }*/


    return true;
}
</script>
