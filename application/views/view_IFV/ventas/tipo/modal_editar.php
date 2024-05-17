<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title">Editar Tipo Producto</h5>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Código: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="cod_tipo_u" name="cod_tipo_u" placeholder="Ingresar Código" value="<?php echo $get_id[0]['cod_tipo']; ?>">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Descripción: </label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="descripcion_u" name="descripcion_u" placeholder="Ingresar Descripción" value="<?php echo $get_id[0]['descripcion']; ?>">
            </div>

            <!--<div class="form-group col-md-2">
                <label class="control-label text-bold">Foto: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="file" id="foto_u" name="foto_u" onchange="validarExt_U();">
            </div>-->
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="form-group col text-bold">Estado:</label>                 
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="estado_u" id="estado_u">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_estado as $list){ ?>
                        <option value="<?php echo $list['id_status']; ?>" <?php if($list['id_status']==$get_id[0]['estado']){ echo "selected"; } ?>>
                            <?php echo $list['nom_status'];?>
                        </option>
                    <?php } ?>
                </select>
            </div>    
        </div>
    </div>

    <div class="modal-footer"> 
        <input type="hidden" id="id_tipo" name="id_tipo" value="<?php echo $get_id[0]['id_tipo']; ?>">
        <!--<input type="hidden" id="foto_actual" name="foto_actual" value="<?php //echo $get_id[0]['foto']; ?>">-->
        <button type="button" class="btn btn-primary" onclick="Update_Tipo_Venta();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function validarExt_U(){
        var archivoInput = document.getElementById('foto_u'); 
        var archivoRuta = archivoInput.value;
        var extPermitidas = /(.png)$/i;
        if(!extPermitidas.exec(archivoRuta)){
            Swal({
                title: 'Registro Denegado',
                text: "Asegurese de ingresar foto con extensiones .png.",
                type: 'error', 
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK',
            });
            archivoInput.value = '';
            return false;
        }else{   
            let img = new Image()
            img.src = window.URL.createObjectURL(event.target.files[0])
            img.onload = () => {
                if(img.width === 250 && img.height === 250){
                    return true;
                }else{
                    Swal({
                        title: 'Registro Denegado',
                        text: "Asegurese de ingresar foto con dimensión de 250x250.",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                    archivoInput.value = '';
                    return false;
                }                
            }  
        }
    }

    function Update_Tipo_Venta(){
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
        var url="<?php echo site_url(); ?>AppIFV/Update_Tipo_Venta";

        if (Valida_Update_Tipo_Venta()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
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
                        Lista_Tipo_Venta();
                        $("#acceso_modal_mod .close").click()
                    }
                }
            });
        }    
    }

    function Valida_Update_Tipo_Venta() {
        if($('#cod_tipo_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Código.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#descripcion_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Descripción.',
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