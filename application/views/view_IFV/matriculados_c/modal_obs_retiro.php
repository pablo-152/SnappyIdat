<form id="formulario_obs" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button> 
        <h5 class="modal-title"><b>Editar Observación de Retiro: <?php echo $get_id[0]['Codigo']; ?></b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;"> 
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Observación:</label>
            </div>
            <div class="form-group col-md-12">
                <textarea name="obs_retiro" id="obs_retiro" class="form-control" cols="10" rows="4" placeholder="Observación"><?php if(count($get_id)>0){ echo $get_id[0]['obs_retiro']; } ?></textarea>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input type="hidden" id="id_alumno_retirado" name="id_alumno_retirado" value="<?php echo $get_id[0]['id_alumno_retirado']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Obs_Motivo_Retiro();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cerrar
        </button>
    </div>
</form>

<script>
    function Update_Obs_Motivo_Retiro(){
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

        var tipo_excel = $("#tipo_excel").val();
        var dataString = new FormData(document.getElementById('formulario_obs'));
        var url="<?php echo site_url(); ?>AppIFV/Update_Obs_Motivo_Retiro";

        $.ajax({
            url: url,
            data:dataString,
            type:"POST",
            processData: false,
            contentType: false,
            success:function (data) {
                $("#acceso_modal_mod .close").click()
                Lista_Matriculados_C(tipo_excel)
            }
        });
    }
</script>