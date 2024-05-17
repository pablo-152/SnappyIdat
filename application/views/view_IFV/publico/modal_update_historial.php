<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Editar Acción</b></h5>
    </div>

    <div class="modal-body" style="max-height:600px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-4">
                <label class="text-bold">Fecha</label>
                <div class="col">
                    <input type="date" class="form-control" id="fecha_accion_u" name="fecha_accion_u" value="<?php echo $get_id[0]['fecha_accion']; ?>" onkeypress="if(event.keyCode == 13){ Update_Historial(); }">
                </div>
            </div>

            <div class="form-group col-md-8">
                <label class="text-bold">Comentario</label>
                <div class="col">
                    <input type="text" class="form-control" id="comentario1_u" name="comentario1_u" value="<?php echo $get_id[0]['comentario']; ?>" placeholder="Comentario" maxlength="35" onkeypress="if(event.keyCode == 13){ Update_Historial(); }">
                </div>
            </div>
            
            <div class="form-group col-md-12">
                <label class="text-bold">Observaciones:</label>
                <div class="col">
                    <textarea class="form-control" id="observacion_u" name="observacion_u" rows="5" placeholder="Observaciones"><?php echo $get_id[0]['observacion']; ?></textarea>
                </div>
            </div>

            <div class="form-group col-md-4">
                <label class="control-label text-bold">Tipo:</label>
                <div class="col">
                    <select class="form-control" id="id_tipo_u" name="id_tipo_u">
                        <option value="0" >Seleccione</option>
                        <?php foreach($list_tipo as $list){ ?>
                            <option value="<?php echo $list['id_tipo']; ?>" <?php if($list['id_tipo']==$get_id[0]['id_tipo']){ echo "selected"; } ?>>
                                <?php echo $list['nom_tipo'];?>
                            </option>
                        <?php } ?>
                    </select>
                </div> 
            </div>    

            <div class="form-group col-md-4">
                <label class="text-bold">Acción:</label>
                <div class="col"> 
                    <select class="form-control" name="id_accion_u" id="id_accion_u" onchange="Busca_Estado_U();">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_accion as $list){ ?>
                            <option value="<?php echo $list['id_accion']; ?>" <?php if($list['id_accion']==$get_id[0]['id_accion']){ echo "selected"; } ?>>
                                <?php echo $list['nom_accion']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="form-group col-md-4">
                <label class="control-label text-bold">Estado:</label>
                <div class="col">
                    <select class="form-control" id="estado_h_u" name="estado_h_u">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_estado as $list){ ?>
                            <option value="<?php echo $list['id_status_general']; ?>" <?php if($list['id_status_general']==$get_id[0]['estado_h']){ echo "selected"; } ?>>
                                <?php echo $list['nom_status']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div> 
            </div>         
        </div>                 
    </div>

    <div class="modal-footer">
        <input type="hidden" id="id_historial" name="id_historial" value="<?php echo $get_id[0]['id_historial']; ?>">
        <input type="hidden" id="id_publico" name="id_publico" value="<?php echo $get_id[0]['id_publico']; ?>">
        <input type="hidden" id="ultimo_comentario" name="ultimo_comentario" value="<?php echo $get_id[0]['ultimo_comentario']; ?>">
        <button type="button" onclick="Update_Historial();" class="btn btn-primary"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove-sign"></i>Cancelar</button>
    </div>
</form>

<script>
    function Busca_Estado_U(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });

        var id_accion = $('#id_accion_u').val();

        if(id_accion=="0"){
            $('#estado_h_u').html('<option value="0">Seleccione</option>');
        }else{
            var url = "<?php echo site_url(); ?>AppIFV/Muestra_Estado";

            $.ajax({
                url: url,
                type: 'POST',
                data: {'id_accion':id_accion},
                success: function(data){
                    $('#estado_h_u').html(data);
                }
            });
        }
    }

    function Update_Historial(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });

        var dataString = $("#formulario_update").serialize();
        var url="<?php echo site_url(); ?>AppIFV/Update_Historial_Publico";

        if (Valida_Update_Historial()) {
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
                        window.location.reload();
                    });
                }
            });
        }
    }

    function Valida_Update_Historial() {
        if($('#id_tipo_u').val()=="0"){
            Swal(
                'Ups!',
                'Debe seleccionar Tipo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_accion_u').val()=="0"){
            Swal(
                'Ups!',
                'Debe seleccionar Acción.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#estado_h_u').val()=="0"){
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