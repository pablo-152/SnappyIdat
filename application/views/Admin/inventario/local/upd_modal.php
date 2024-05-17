<form id="formulario_locale" method="POST" enctype="multipart/form-data" action="<?= site_url('Snappy/Update_Tipo')?>"  class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Actualizar Código: </b></h5>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label>Empresa:</label>
            </div>

            <div class="form-group col-md-10">
                <select required class="form-control" name="id_empresa" id="id_empresa" onchange="Busca_Sede()" >
                <option value="0">Seleccione</option>
                <?php foreach($list_empresa as $tipo){
                    if($get_id[0]['id_empresa']==$tipo['id_empresa']){?> 
                        <option selected value="<?php echo $tipo['id_empresa']; ?>"><?php echo $tipo['cod_empresa'];?></option>
                    <?php }else{?> 
                        <option value="<?php echo $tipo['id_empresa']; ?>"><?php echo $tipo['cod_empresa'];?></option>
                    <?php } } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label>Sede:</label>
            </div>

            <div class="form-group col-md-10" id="div_sede">
                    <select required class="form-control" name="id_sede" id="id_sede" >
                    <option value="0">Seleccione</option>
                    <?php foreach($list_sede as $tipo){
                        if($get_id[0]['id_sede']==$tipo['id_sede']){?>
                            <option selected value="<?php echo $tipo['id_sede']; ?>"><?php echo $tipo['cod_sede'];?></option>
                        <?php }else{?>
                            <option value="<?php echo $tipo['id_sede']; ?>"><?php echo $tipo['cod_sede'];?></option>
                        <?php }   } ?>
                    </select>
            </div>

            <div class="form-group col-md-2">
                <label>Responsable:</label>
            </div>

            <div class="form-group col-md-10">
                <select class="form-control basic" name="id_responsable" id="id_responsable" >
                <option value="0">Seleccione</option>
                <?php foreach($list_usuario as $list){
                    if($get_id[0]['id_responsable']==$list['id_usuario']){?> 
                    <option selected value="<?php echo $list['id_usuario']; ?>"><?php echo $list['usuario_codigo'];?></option>
                    <?php }else{?>
                        <option value="<?php echo $list['id_usuario']; ?>"><?php echo $list['usuario_codigo'];?></option>
                    <?php } } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label>Nombre:</label>
            </div>

            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="nom_local" name="nom_local" value="<?php echo $get_id[0]['nom_local'] ?>" placeholder="Ingresar Nombre" autofocus onkeypress="if(event.keyCode == 13){ Actualizar_Local(); }">
            </div>
        
        </div>  	           	                	        
    </div>

    <div class="modal-footer">
        <input name="id_inventario_local" type="hidden" class="form-control" id="id_inventario_local" value="<?php echo $get_id[0]['id_inventario_local']; ?>">
        <button type="button" class="btn btn-primary" onclick="Actualizar_Local()" data-loading-text="Loading..." autocomplete="off">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
        
    </div>
</form>

<script>

    var ss = $(".basic").select2({
        tags: true
    });

    $('.basic').select2({
        dropdownParent: $('#acceso_modal_mod')
    });

    function Actualizar_Local(){
        var dataString = new FormData(document.getElementById('formulario_locale'));
        var url="<?php echo site_url(); ?>Snappy/Update_Local";

        if (valida_locale()) {
            bootbox.confirm({
                title: "Editar Datos del Local",
                message: "¿Desea actualizar datos de Local?",
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
                                if(data=="error"){
                                    swal.fire(
                                    'Actualización Denegada!',
                                    'Existe un registro con los mismos datos',
                                    'error'
                                ).then(function() {
                                    
                                    
                                });
                                }else{
                                    swal.fire(
                                    'Actualización Exitosa!',
                                    '',
                                    'success'
                                ).then(function() {
                                    window.location = "<?php echo site_url(); ?>Snappy/Local";
                                    
                                });
                                }
                                
                            }
                        });
                    }
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

    

    function valida_locale() {
        if($('#id_empresa').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar empresa.',
                'warning'
            ).then(function() { });
            return false;
        }

        if($('#id_sede').val() == '0') {
            Swal(
                'Ups!',
                'Debe seleccionar sede.',
                'warning'
            ).then(function() { });
            return false;
        }

        if($('#id_responsable').val() == '0') {
            Swal(
                'Ups!',
                'Debe seleccionar responsable.',
                'warning'
            ).then(function() { });
            return false;
        }

        if($('#nom_local').val().trim() === '' ) {
            Swal(
                'Ups!',
                'Debe ingresar nombre de local.',
                'warning'
            ).then(function() { });
            return false;
        }

        return true;
    }
</script>
