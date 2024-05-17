<form id="formulario" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title">Editar Examen <b><?php echo $get_id[0]['nom_examen']; ?></b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Nombre:</label>
                <input type="text" class="form-control" id="nom_examen" name="nom_examen" value="<?php echo $get_id[0]['nom_examen']; ?>" >
            </div>

            <div class="form-group col-md-6">
                <label class="control-label text-bold">Fecha Examen:</label>
                <input type="date" class="form-control" id="fec_limite" name="fec_limite" value="<?php echo $get_id[0]['fecha_limite']; ?>">
            </div>

            <div class="form-group col-md-6">
                <label class="control-label text-bold">Publicación de Resultados:</label>
                <input type="date" class="form-control" id="fec_resultados" name="fec_resultados" value="<?php echo $get_id[0]['fecha_resultados']; ?>">
            </div>

            <div class="form-group col-md-6">
                <label class="control-label text-bold">Estado</label>
                <select class="form-control" name="estado" id="estado" >
                    <option value="0">Seleccione</option>
                    <?php foreach($list_estado as $list){ 
                    if($get_id[0]['estado'] == $list['id_status']){ ?>
                    <option selected value="<?php echo $list['id_status'] ; ?>">
                    <?php echo $list['nom_status'];?></option>
                    <?php }else
                    {?>
                    <option value="<?php echo $list['id_status']; ?>"><?php echo $list['nom_status'];?></option>
                    <?php }} ?>
                </select>
            </div>
        </div>

    </div> 
    <div class="modal-footer">
        <input name="id_examen" type="hidden" class="form-control" id="id_examen" value="<?php echo $get_id[0]['id_examen']; ?>">
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
        var dataString = $("#formulario").serialize();
        var url="<?php echo site_url(); ?>AppIFV/Update_Examen_Ifv";
        if (valida_examen()) {
            bootbox.confirm({
                title: "Actualizar Examen",
                message: "¿Desea actualizar datos de examen?",
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
                        url:url,
                        data:dataString,
                        success:function (data) {
                            if(data=="error"){
                                swal.fire(
                                    'Actualización Denegada!',
                                    'Existe otro examen activo, por favor revisar!',
                                    'error'
                                ).then(function() {});
                            }else{
                                swal.fire(
                                    'Actualización Exitosa!',
                                    'Haga clic en el botón!',
                                    'success'
                                ).then(function() {
                                    window.location = "<?php echo site_url(); ?>AppIFV/Examen";
                                });
                            }
                        }
                    });
                    }
                } 
            });        
        }
    });

    function valida_examen() {
        if($('#nom_examen').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Nombre.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#fec_limite').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Fecha Límite.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#fec_resultados').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Fecha de Publicación de Resultados.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#estado').val().trim() === '0') {
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