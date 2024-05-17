
    <form id="from_foto" method="POST" enctype="multipart/form-data" class="formulario">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Actualización del Curso <b><?php echo $get_id[0]['id_curso']; ?></b></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body" style="">
            <div class="col-md-12 row">
                <div class="form-group col-md-6">
                    <label class=" control-label text-bold">Grado: </label>
                    <div class="col">
                        <select class="form-control" name="id_grado" id="id_grado" >
                            <option value="0">Seleccione</option>
                            <?php foreach($list_grado as $nivel){ 
                            if($get_id[0]['id_grado'] == $nivel['id_grado']){ ?>
                            <option selected value="<?php echo $nivel['id_grado'] ; ?>">
                            <?php echo $nivel['descripcion_grado'];?></option>
                            <?php }else
                            {?>
                            <option value="<?php echo $nivel['id_grado']; ?>"><?php echo $nivel['descripcion_grado'];?></option>
                            <?php }} ?>
                        </select>
                    </div>
                </div>
                        
                <div class="form-group col-md-6">
                    <label class=" control-label text-bold">Año: </label>
                    <div class="col">
                        <select class="form-control" name="id_anio" id="id_anio" >
                            <option value="0">Seleccione</option>
                            <?php foreach($list_anio as $nivel){ 
                            if($get_id[0]['id_anio'] == $nivel['id_anio']){ ?>
                            <option selected value="<?php echo $nivel['id_anio'] ; ?>">
                            <?php echo $nivel['nom_anio'];?></option>
                            <?php }else
                            {?>
                            <option value="<?php echo $nivel['id_anio']; ?>"><?php echo $nivel['nom_anio'];?></option>
                            <?php }} ?>
                        </select>
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label class=" control-label text-bold">Inicio Matrículas: </label>
                    <div class="col">
                        <input value="<?php echo $get_id[0]['fec_inicio']; ?>" class="form-control" required type="date" id="fec_inicio" name="fec_inicio" placeholder= "Seleccionar Fecha inicio de matricula" type="text" />
                    </div>
                </div>
                        
                <div class="form-group col-md-6">
                    <label class=" control-label text-bold">Fin Matrículas: </label>
                    <div class="col">
                        <input value="<?php echo $get_id[0]['fec_fin']; ?>" class="form-control" required type="date" id="fec_fin" name="fec_fin" placeholder= "Seleccionar Fecha de fin de matrícula" type="text" />
                    </div>
                </div>
                        
                <div class="form-group col-md-6">
                    <label class=" control-label text-bold">Estado: </label>
                    <div class="col">
                        <select class="form-control" name="id_status" id="id_status">
                        <option value="0" <?php if (!(strcmp(0, $get_id[0]['estado']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
                        <?php foreach($list_estado as $estado){ ?>
                            <option value="<?php echo $estado['id_status']; ?>" <?php if (!(strcmp($estado['id_status'], $get_id[0]['estado']))) {echo "selected=\"selected\"";} ?>><?php echo $estado['nom_status'];?></option>
                        <?php } ?>
                        </select>
                    </div>
                </div>
                        
                <div class="form-group col-md-6">
                    <label class=" control-label text-bold">Curso&nbsp;a Copiar: </label>
                    <div class="col">
                        <select disabled class="form-control" name="id_curso" id="id_curso">
                        <option value="0">Seleccione</option>
                            <?php foreach($list_grado as $nivel){ ?>
                            <option value="<?php echo $nivel['id_grado'] ; ?>">
                            <?php echo $nivel['nom_grado'];?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                        
                        
                <div class="form-group col-md-12">
                    <label class=" control-label text-bold">Observaciones:</label>
                    <div class="col">
                        <textarea type="text" name="obs_curso" rows="3" class="form-control" id="obs_curso" > <?php echo $get_id[0]['obs_curso']?> </textarea>
                    </div>
                </div>

            </div>  	           	                	        
        </div> 
        <div class="modal-footer">
            <input name="id_curso" type="hidden" class="form-control" id="id_curso" value="<?php echo $get_id[0]['id_curso']; ?>">
            <input name="id_cursor" type="hidden" class="form-control" id="id_cursor" value="<?php echo $get_id[0]['id_curso']; ?>">
            
            <button type="button" class="btn btn-primary" id="createProductBtn" data-loading-text="Loading..." autocomplete="off">
                <i class="glyphicon glyphicon-ok-sign"></i> Guardar
            </button>
            <button type="button" class="btn btn-default" data-dismiss="modal">
                <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
            </button>
            
        </div>
    </form>

<script>
    $("#createProductBtn").on('click', function(e){
        var dataString = new FormData(document.getElementById('from_foto'));
        var url="<?php echo site_url(); ?>Ceba/Update_Curso";
        var id = $('#id_cursor').val();
      
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
                        $.ajax({
                            type:"POST",
                            url: url,
                            data:dataString,
                            processData: false,
                            contentType: false,
                            success:function (data) {
                                swal.fire(
                                        'Actualización Exitosa!',
                                        '',
                                        'success'
                                    ).then(function() {
                                        window.location = "<?php echo site_url(); ?>Ceba/Detalles_Curso/"+id;
                                    });
                            }
                        }); 
                    }
                } 
            });        
        }
    });

    function valida_curso() {
        if($('#id_anio').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Año.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#fec_inicio').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe seleccionar Fecha Inicio.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#fec_fin').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe seleccionar Fecha Fin.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#id_status').val().trim() === '') {
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