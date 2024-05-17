<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Editar Tipo Contrato</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;"> 
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Nombre:</label> 
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="nom_tipo_u" name="nom_tipo_u" placeholder="Nombre" value="<?php echo $get_id[0]['nom_tipo']; ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Alumno:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="alumno_u" name="alumno_u">
                    <option value="0" <?php if($get_id[0]['alumno']==0){ echo "selected"; } ?>>Seleccione</option>
                    <option value="1" <?php if($get_id[0]['alumno']==1){ echo "selected"; } ?>>Admisión</option>
                    <option value="2" <?php if($get_id[0]['alumno']==2){ echo "selected"; } ?>>Matriculado</option>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Fecha Envío</label> 
            </div>
            <div class="form-group col-md-4">
                <input type="checkbox" id="fecha_envio_u" name="fecha_envio_u" value="1" <?php if($get_id[0]['fecha_envio']==1){ echo "selected"; } ?>>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Estado:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="estado_u" name="estado_u">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_estado as $list){ ?>
                        <option value="<?php echo $list['id_status']; ?>" <?php if($list['id_status']==$get_id[0]['estado']){ echo "selected"; } ?>>
                            <?php echo $list['nom_status']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>   	
    </div> 

    <div class="modal-footer">
        <input type="hidden" id="id_tipo" name="id_tipo" value="<?php echo $get_id[0]['id_tipo']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Tipo_C_Contrato()">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cerrar
        </button>
    </div>
</form> 

<script>
    function Update_Tipo_C_Contrato(){
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

        var dataString = new FormData(document.getElementById('formulario_update'));
        var url="<?php echo site_url(); ?>AppIFV/Update_Tipo_C_Contrato";

        if (Valida_Update_Tipo_C_Contrato()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    if(data=="error"){
                        Swal({
                            title: 'Actualización Denegada',
                            text: "¡El registro ya existe!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        Lista_Tipo_C_Contrato();
                        $("#acceso_modal_mod .close").click()
                    }
                }
            });
        }
    }

    function Valida_Update_Tipo_C_Contrato() {
        if($('#nom_tipo_u').val().trim() === '') { 
            Swal(
                'Ups!',
                'Debe ingresar Nombre.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#alumno_u').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Alumno.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#estado_u').val().trim() === '0') {
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