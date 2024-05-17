<form id="formulario_detallee" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Editar Horario</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Hora:</label>
                <select name="id_horae" id="id_horae" class="form-control">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_hora as $list){?>
                    <option value="<?php echo $list['id_hora'] ?>" <?php if($get_id[0]['id_hora']==$list['id_hora']){echo "selected";}?>><?php echo $list['desde']." - ".$list['hasta'] ?></option>    
                    <?php }?>
                </select>
            </div>

            <div class="form-group col-md-6">
                <label class="control-label text-bold">Unid. Didáctica:</label>
                <select name="id_unidad_didacticae" id="id_unidad_didacticae" class="form-control">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_unidad as $list){?>
                    <option value="<?php echo $list['id_unidad_didactica'] ?>" <?php if($get_id[0]['id_unidad_didactica']==$list['id_unidad_didactica']){echo "selected";}?>><?php echo $list['nom_unidad_didactica'] ?></option>    
                    <?php }?>
                </select>
            </div>
            
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Profesor:</label>
                <select name="id_profesore" id="id_profesore" class="form-control">
                    <option value="0">Seleccione</option>
                </select>
            </div>

            <div class="form-group col-md-6">
                <label class="control-label text-bold">Salón:</label>
                <select name="id_salone" id="id_salone" class="form-control">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_salon as $list){?>
                    <option value="<?php echo $list['id_salon'] ?>" <?php if($get_id[0]['id_salon']==$list['id_salon']){echo "selected";}?>><?php echo $list['referencia']." - ".$list['nom_tipo_salon'] ?></option>    
                    <?php }?>
                </select>
            </div>
        </div>  	           	                	        
    </div> 
    
    <div class="modal-footer">
        <input type="hidden" name="id_horariore" id="id_horariore" value="<?php echo $get_id[0]['id_horario'] ?>">
        <input type="hidden" name="id_horario_detalle" id="id_horario_detalle" value="<?php echo $get_id[0]['id_horario_detalle'] ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Horario_Detalle();" data-loading-text="Loading..." autocomplete="off">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Update_Horario_Detalle(){
        $(document)
        .ajaxStart(function() {
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
        .ajaxStop(function() {
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
        var dataString = new FormData(document.getElementById('formulario_detallee'));
        var url = "<?php echo site_url(); ?>AppIFV/Update_Horario_Detalle";
        if (Valida_Horario_Detallee()) {
            $.ajax({
                type:"POST",
                url:url,
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
                            'Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            $('#acceso_modal_mod .close').click();
                            Busqueda_Horario_Detalle();
                        });
                    }
                }
            });
        }
    }

    function Valida_Horario_Detallee() {
        if($('#id_horae').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar hora.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#id_unidad_didacticae').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar unidad didáctica.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
    
</script>
