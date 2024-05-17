
<div class="modal-content">
    <form class="form-horizontal" id="from_foto" method="POST" enctype="multipart/form-data" action="<?= site_url('Ceba/Insert_Listado_Curso')?>"  class="formulario">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Curso (Nuevo)</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body" style="max-height:450px; overflow:auto;">
	            	<div class="col-md-12 row">
	                	<div class="form-group col-md-2">
	                    <label class="col-sm-3 control-label text-bold">Año: </label>
	                	</div>
	                	<div class="form-group col-md-4">
	               			<select class="form-control" name="id_anio" id="id_anio">
	                    		<option value="0">Seleccione</option>
	                    		<?php foreach($list_anio as $nivel){ ?>
	                        	<option value="<?php echo $nivel['id_anio'] ; ?>">
	                            <?php echo "Año: ".$nivel['nom_anio'];?></option>
	                    	<?php } ?>
	                    	</select>
	                    </div>
                		<div class="form-group col-md-2">
	                    <label class="col-sm-3 control-label text-bold">Grado: </label>
	                	</div>
                
                		<div class="form-group col-md-4">
	           				<select class="form-control" name="id_grado" id="id_grado">
	                		<option value="0">Seleccione</option>
	                			<?php foreach($list_grado as $nivel){ ?>
	                    		<option value="<?php echo $nivel['id_grado'] ; ?>">
	                        	<?php echo "Grado: ".$nivel['nom_grado'];?></option>
	                			<?php } ?>
	                		</select>
	                	</div>
                		<div class="form-group col-md-2">
	                    	<label class="col-sm-3 control-label text-bold">Inicio Matrículas: </label>
	                	</div>
                		<div class="form-group col-md-4">
                                 <input class="form-control" required type="date" id="fec_inicio" name="fec_inicio" placeholder= "Seleccionar Inicio de Matrícula" type="text" />
                 		</div>
                 		<div class="form-group col-md-2">
	                    	<label class="col-sm-3 control-label text-bold">Fin Matrículas: </label>
	                	</div>
                		<div class="form-group col-md-4">
                                 <input class="form-control" required type="date" id="fec_fin" name="fec_fin" placeholder= "Seleccionar Fin de Matrícula" type="text" />
                 		</div>
                 		<div class="form-group col-md-2">
	                    	<label class="col-sm-3 control-label text-bold">Curso&nbsp;a Copiar: </label>
	                	</div>
                		<div class="form-group col-md-4">
	           				<select disabled class="form-control" name="id_copiar" id="id_copiar">
	                		<option  value="0">Seleccione</option>
	                			<?php foreach($list_ as $nivel){ ?>
	                    		<option value="<?php echo $nivel['id_asignatura'] ; ?>">
	                        	<?php echo "Curso: ".$nivel['nom_asignatura'];?></option>
	                			<?php } ?>
	                		</select>
	                	</div>

	                	
	                	<div class="form-group col-md-12">
                            <label class="col-sm-3 control-label text-bold">Observaciones:</label>
                            <div class="form-group col-md-12">
	           				<textarea name="obs_curso" rows="5" class="form-control" id="obs_curso"></textarea>
                            
	                	</div>
                            
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
    if (valida_curso()) {
        bootbox.confirm({
            title: "Registrar Curso",
            message: "¿Desea registrar el curso?",
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
        msgDate = 'Debe seleccionar un año .';
        inputFocus = '#id_anio';
        return false;
    }if($('#id_grado').val().trim() === '0') {
        msgDate = 'Debe seleccionar un grado';
        inputFocus = '#id_grado';
        return false;
    }if($('#fec_inicio').val().trim() === '') {
        msgDate = 'Debe seleccionar fecha de inicio de matrícula';
        inputFocus = '#fec_inicio';
        return false;
    }if($('#fec_fin').val().trim() === '') {
        msgDate = 'Debe seleccionar fecha de fin de matrícula';
        inputFocus = '#fec_fin';
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
