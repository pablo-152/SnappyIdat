<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Nueva Acción</b></h5>
    </div>

    <div class="modal-body" style="max-height:600px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-4">
                <label class="text-bold">Fecha</label>
                <div class="col">
                    <input type="date" class="form-control" id="fecha_accion_i" name="fecha_accion_i" value="<?php echo date('Y-m-d'); ?>" onkeypress="if(event.keyCode == 13){ Insert_Historial(); }">
                </div>
            </div>

            <div class="form-group col-md-8">
                <label class="text-bold">Comentario</label>
                <div class="col">
                    <input type="text" class="form-control" id="comentario1_i" name="comentario1_i" value="<?php echo $get_id[0]['ultimo_comentario']; ?>" placeholder="Comentario" maxlength="35" onkeypress="if(event.keyCode == 13){ Insert_Historial(); }">
                </div>
            </div>
            
            <div class="form-group col-md-12">
                <label class="text-bold">Observaciones:</label>
                <div class="col">
                    <textarea class="form-control" id="observacion_i" name="observacion_i" rows="5" placeholder="Observaciones"></textarea>
                </div>
            </div>

            <div class="form-group col-md-4">
                <label class="control-label text-bold">Tipo:</label>
                <div class="col">
                    <select class="form-control" id="id_tipo_i" name="id_tipo_i">
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
                    <select class="form-control" name="id_accion_i" id="id_accion_i" onchange="Busca_Estado_I();">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_accion as $list){ ?>
                            <option value="<?php echo $list['id_accion']; ?>"><?php echo $list['nom_accion']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="form-group col-md-4">
                <label class="control-label text-bold">Estado:</label>
                <div class="col">
                    <select class="form-control" id="estado_h_i" name="estado_h_i">
                        <option value="0">Seleccione</option>
                    </select>
                </div> 
            </div>         
        </div>                 
    </div>

    <div class="modal-footer">
        <input type="hidden" id="id_publico" name="id_publico" value="<?php echo $get_id[0]['id_publico']; ?>">
        <input type="hidden" id="ultimo_comentario" name="ultimo_comentario" value="<?php echo $get_id[0]['ultimo_comentario']; ?>">
        <button type="button" onclick="Insert_Historial();" class="btn btn-primary"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove-sign"></i>Cancelar</button>
    </div>
</form>

<script>
    function Busca_Estado_I(){
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

        var id_accion = $('#id_accion_i').val();

        if(id_accion=="0"){
            $('#estado_h_i').html('<option value="0">Seleccione</option>');
        }else{
            var url = "<?php echo site_url(); ?>AppIFV/Muestra_Estado";

            $.ajax({
                url: url,
                type: 'POST',
                data: {'id_accion':id_accion},
                success: function(data){
                    $('#estado_h_i').html(data);
                }
            });
        }
    }

    function Insert_Historial(){ 
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

        var dataString = $("#formulario_insert").serialize();
        var url="<?php echo site_url(); ?>AppIFV/Insert_Historial_Publico";

        if (Valida_Insert_Historial()) {
            $.ajax({
                type:"POST",
                url:url,
                data:dataString,
                success:function (data) {
                    swal.fire(
                        'Registro Exitoso!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        window.location.reload();
                    });
                }
            });
        }
    }

    function Valida_Insert_Historial() {
        if($('#id_tipo_i').val()=="0"){
            Swal(
                'Ups!',
                'Debe seleccionar Tipo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_accion_i').val()=="0"){
            Swal(
                'Ups!',
                'Debe seleccionar Acción.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#estado_h_i').val()=="0"){
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