<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Editar Producto</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Año:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" value="<?php echo $get_id[0]['anio']; ?>" disabled>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Producto:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" value="<?php echo $get_id[0]['nom_producto']; ?>" disabled>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Estado:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" value="<?php echo $get_id[0]['estado']; ?>" disabled>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Informe:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="informe_u" name="informe_u">
                    <option value="0" <?php if($get_id[0]['informe']==0){ echo "selected"; } ?>>No</option>
                    <option value="1" <?php if($get_id[0]['informe']==1){ echo "selected"; } ?>>Si</option>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Tipo:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="tipo_u" name="tipo_u">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_tipo as $list){ ?>
                        <option value="<?php echo $list['id_tipo_producto']; ?>" <?php if($list['id_tipo_producto']==$get_id[0]['tipo']){ echo "selected"; } ?>>
                            <?php echo $list['nom_tipo_producto']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Cancelados:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="cancelado_u" name="cancelado_u">
                    <option value="0" <?php if($get_id[0]['cancelado']==0){ echo "selected"; } ?>>No</option>
                    <option value="1" <?php if($get_id[0]['cancelado']==1){ echo "selected"; } ?>>Si</option>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Especialidad:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control multivalue_update" id="id_especialidad_u" name="id_especialidad_u[]" multiple="multiple">
                    <?php $base_array = explode(",",$get_id[0]['id_especialidad']);  
                    foreach($list_especialidad as $list){ ?>
                        <option value="<?php echo $list['id_especialidad']; ?>" <?php if(in_array($list['id_especialidad'],$base_array)){ echo "selected=\"selected\""; } ?>>
                            <?php echo $list['abreviatura']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div> 

    <div class="modal-footer">
        <input type="hidden" id="id_producto" name="id_producto" value="<?php echo $get_id[0]['id_producto']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Producto()">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cerrar
        </button>
    </div>
</form>

<script>
    var ss = $(".multivalue_update").select2({
        tags: true
    });

    $('.multivalue_update').select2({
        dropdownParent: $('#acceso_modal_mod')
    });

    function Update_Producto(){
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
        var url="<?php echo site_url(); ?>AppIFV/Update_Producto";

        if (Valida_Update_Producto()) {
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
                        window.location = "<?php echo site_url(); ?>AppIFV/Producto";
                    });
                }
            });
        }
    }

    function Valida_Update_Producto() {
        if($('#tipo_u').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Tipo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_especialidad_u').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Especialidad.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>