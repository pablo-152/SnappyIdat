<form id="formulario_obs" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Actualizar Motivo Retiro: <?php echo $codigo?></b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Motivo:</label>
            </div>
            <div class="form-group col-md-12">
                <textarea name="motivo" id="motivo" class="form-control" cols="10" rows="4"><?php if(count($get_id)>0){echo $get_id[0]['motivo']; }?></textarea>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input type="hidden" id="id_alumno" name="id_alumno" value="<?php echo $id_alumno; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Obs_Motivo_Retiro('<?php echo $tipo ?>')">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cerrar
        </button>
    </div>
</form>

<script>

    function Update_Obs_Motivo_Retiro(t){
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

        var dataString = new FormData(document.getElementById('formulario_obs'));
        var url="<?php echo site_url(); ?>AppIFV/Update_Obs_Motivo_Retiro";

        if (Valida_Update_Matriculados_C()) {
            Swal({
                title: '¿Realmente desea actualizar motivo de retiro?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: url,
                        data:dataString,
                        type:"POST",
                        processData: false,
                        contentType: false,
                        success:function (data) {
                            swal.fire(
                                'Actualización Exitosa',
                                'Haga clic en el botón!',
                                'success'
                            ).then(function() {
                                $("#acceso_modal_mod .close").click()
                                Lista_Matriculados_C(t)
                            });
                        }
                    });
                }
            })
        }
    }

    function Valida_Update_Matriculados_C() {
        if($('#motivo').val() === '') {
            Swal(
                'Ups!',
                'Debe ingresar algún motivo.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>