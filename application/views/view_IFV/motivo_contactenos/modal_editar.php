<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Editar Motivo</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Tipo:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="tipoe" name="tipoe">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_tipo as $list){?> 
                        <option value="<?php echo $list['id_tipo'] ?>" <?php if($get_id[0]['tipo']==$list['id_tipo']){echo "selected";}?>><?php echo $list['nom_tipo'] ?></option> 
                    <?php }?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Motivo:</label>
            </div>
            <div id="div_modulo_i" class="form-group col-md-4">
                <input type="text" name="tituloe" id="tituloe" class="form-control" value="<?php echo $get_id[0]['titulo'] ?>">
            </div>

            <!--<div class="form-group col-md-2">
                <label class="control-label text-bold">De:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" name="dee" id="dee" class="form-control" value="<?php echo $get_id[0]['de'] ?>">
            </div>-->
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Para:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" name="parae" id="parae" class="form-control" value="<?php echo $get_id[0]['para'] ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Usuarios:</label>
            </div>

            <div class="form-group col-md-4">
                <select class="form-control multivalue_update" id="usuarios" name="usuarios[]" multiple="multiple">
                    <?php $base_array = explode(",",$get_id[0]['usuarios']);
                    foreach($list_usuario as $list){ ?>
                    <option value="<?php echo $list['id_usuario']; ?>" <?php if(in_array($list['id_usuario'],$base_array)){ echo "selected=\"selected\""; } ?>>
                        <?php echo $list['usuario_codigo']; ?>
                    </option>
                    <?php } ?>
                </select>
            </div>
        </div>           	                	        
    </div> 

    <div class="modal-footer">
        <input type="hidden" id="id_motivo" name="id_motivo" value="<?php echo $get_id[0]['id_motivo']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_C_Motivo_Contactenos()">
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

    function Update_C_Motivo_Contactenos(){
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
        var url="<?php echo site_url(); ?>AppIFV/Update_C_Motivo_Contactenos";

        if (Valida_C_Motivo_Contactenose()) {
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
                            text: "¡Existe un registro con los mismos datos!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        $('#acceso_modal_mod .close').click();
                        List_C_Motivo_Contactenos();
                    }
                }
            });
        }
    }

    function Valida_C_Motivo_Contactenose() {
        var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
        if($('#tipoe').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar tipo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#tituloe').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar motivo.',
                'warning'
            ).then(function() { });
            return false;
        }
        /*if (!regex.test($('#dee').val().trim())) {
            Swal(
                'Ups!',
                'La direccón de correo <b>De</b> no es válida.',
                'warning'
            ).then(function() { });
            return false;
        }*/
        if (!regex.test($('#parae').val().trim())) {
            Swal(
                'Ups!',
                'La direccón de correo <b>Para</b> no es válida.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>