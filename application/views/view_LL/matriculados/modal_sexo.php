<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Editar Sexo</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Sexo:</label>
            </div>
            <div class="form-group col-md-5">
                <select class="form-control" id="sexo_u" name="sexo_u">
                    <?php if($update==1){ ?>
                        <option value="0" <?php if($get_id[0]['sexo']==0){ echo "selected"; } ?>>Seleccione</option>
                        <option value="1" <?php if($get_id[0]['sexo']==1){ echo "selected"; } ?>>Femenino</option>
                        <option value="2" <?php if($get_id[0]['sexo']==2){ echo "selected"; } ?>>Masculino</option>
                    <?php }else{ ?>
                        <option value="0">Seleccione</option>
                        <option value="1">Femenino</option>
                        <option value="2">Masculino</option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input type="hidden" id="id_alumno" name="id_alumno" value="<?php echo $id_alumno; ?>">
        <?php if($update==1){ ?>
            <input type="hidden" id="id_sexo" name="id_sexo" value="<?php echo $get_id[0]['id_sexo']; ?>">
        <?php }else{ ?>
            <input type="hidden" id="id_sexo" name="id_sexo" value="0">
        <?php } ?>
        <button type="button" class="btn btn-primary" onclick="Update_Sexo()">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cerrar
        </button>
    </div>
</form>

<script>
    function Update_Sexo(){
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

        var id_alumno = $("#id_alumno").val();
        var dataString = new FormData(document.getElementById('formulario_update')); 
        var url="<?php echo site_url(); ?>LittleLeaders/Update_Sexo";

        if (Valida_Update_Sexo()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    window.location = "<?php echo site_url(); ?>LittleLeaders/Detalle_Matriculados/"+id_alumno;
                }
            });
        }
    }

    function Valida_Update_Sexo() {
        if($('#sexo_u').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Sexo.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>