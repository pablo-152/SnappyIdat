<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
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
                <select class="form-control" id="informe_i" name="informe_i">
                    <option value="0">No</option>
                    <option value="1">Si</option>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Tipo:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="tipo_i" name="tipo_i">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_tipo as $list){ ?>
                        <option value="<?php echo $list['id_tipo_producto']; ?>"><?php echo $list['nom_tipo_producto']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Cancelados:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="cancelado_i" name="cancelado_i">
                    <option value="0">No</option>
                    <option value="1">Si</option>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Especialidad:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control multivalue_insert" id="id_especialidad_i" name="id_especialidad_i[]" multiple="multiple">
                    <?php foreach($list_especialidad as $list){ ?>
                        <option value="<?php echo $list['id_especialidad']; ?>"><?php echo $list['abreviatura']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div> 
    
    <div class="modal-footer">
        <input type="hidden" id="id_producto" name="id_producto" value="<?php echo $get_id[0]['Id']; ?>">
        <button type="button" class="btn btn-primary" onclick="Insert_Producto()">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    var ss = $(".multivalue_insert").select2({
        tags: true
    });

    $('.multivalue_insert').select2({
        dropdownParent: $('#acceso_modal_mod')
    });

    function Insert_Producto(){
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

        var dataString = new FormData(document.getElementById('formulario_insert'));
        var url="<?php echo site_url(); ?>AppIFV/Insert_Producto";

        if (Valida_Insert_Producto()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    swal.fire(
                        'Registro Exitoso',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        window.location = "<?php echo site_url(); ?>AppIFV/Producto";
                    });
                }
            });
        }
    }

    function Valida_Insert_Producto() {
        if($('#tipo_i').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Tipo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_especialidad_i').val() === '0') {
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
