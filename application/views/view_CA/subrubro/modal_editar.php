<style>
    .tamanio{
        height: 20px;
        width: 20px;
    }
</style>

<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Editar Sub-Rubro</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Rubro:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="id_rubro_u" name="id_rubro_u">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_rubro as $list){ ?>
                        <option value="<?php echo $list['id_rubro']; ?>" <?php if($list['id_rubro']==$get_id[0]['id_rubro']){ echo "selected"; } ?>>
                            <?php echo $list['nom_rubro']; ?>
                        </option>
                    <?php } ?> 
                </select>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Nombre:</label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="nom_subrubro_u" name="nom_subrubro_u" placeholder="Nombre" value="<?php echo $get_id[0]['nom_subrubro']; ?>">
            </div>

            <div class="form-group col-md-4">
                <label class="control-label text-bold">Sem Contabilizar:</label>
                <input type="checkbox" class="tamanio" id="sin_contabilizar_u" name="sin_contabilizar_u" value="1" style="margin-left:20px;">
            </div>

            <div class="form-group col-md-4">
                <label class="control-label text-bold">Enviado Original:</label>
                <input type="checkbox" class="tamanio" id="enviado_original_u" name="enviado_original_u" value="1" style="margin-left:20px;">
            </div>

            <div class="form-group col-md-4">
                <label class="control-label text-bold">Sem Doc. Físico:</label>
                <input type="checkbox" class="tamanio" id="sin_documento_fisico_u" name="sin_documento_fisico_u" value="1" style="margin-left:20px;">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Estado:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="estado_u" id="estado_u">
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
        <input type="hidden" id="id_subrubro" name="id_subrubro" value="<?php echo $get_id[0]['id_subrubro']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Subrubro()">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cerrar
        </button>
    </div>
</form>

<script>
    function Update_Subrubro(){
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
        var url="<?php echo site_url(); ?>Ca/Update_Subrubro";

        if (Valida_Update_Subrubro()) { 
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
                        Lista_Subrubro();
                        $("#acceso_modal_mod .close").click()
                    }   
                }
            });
        }
    }

    function Valida_Update_Subrubro() {
        if($('#id_rubro_u').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Rubro.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#nom_subrubro_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Nombre.',
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