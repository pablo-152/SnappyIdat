<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Motivo Contactenos (Nuevo)</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Tipo:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="tipo" name="tipo">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_tipo as $list){?> 
                        <option value="<?php echo $list['id_tipo'] ?>"><?php echo $list['nom_tipo'] ?></option>
                    <?php }?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Motivo:</label>
            </div>
            <div id="div_modulo_i" class="form-group col-md-4">
                <input type="text" name="titulo" id="titulo" class="form-control">
            </div>

            <!--<div class="form-group col-md-2">
                <label class="control-label text-bold">De:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" name="de" id="de" class="form-control">
            </div>-->
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Para:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" name="para" id="para" class="form-control">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Usuarios:</label>
            </div>
            <div class="form-group col-md-4">
                
                <select class="form-control multivalue" id="usuarios" name="usuarios[]" multiple="multiple">
                <?php foreach($list_usuario as $list){ ?>
                    <option value="<?php echo $list['id_usuario']; ?>"><?php echo $list['usuario_codigo']; ?></option>
                <?php } ?>
                </select>
            </div>


        </div>
    </div> 
    
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_C_Motivo_Contactenos()">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    var ss = $(".multivalue").select2({
        tags: true
    });

    $('.multivalue').select2({
        dropdownParent: $('#acceso_modal_mod')
    });

    function Insert_C_Motivo_Contactenos(){
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
        var url="<?php echo site_url(); ?>AppIFV/Insert_C_Motivo_Contactenos";

        if (Valida_C_Motivo_Contactenos()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    if(data=="error"){
                        Swal({
                            title: 'Registro Denegado',
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

    function Valida_C_Motivo_Contactenos() {
        var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
        if($('#tipo').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar tipo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#titulo').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar motivo.',
                'warning'
            ).then(function() { });
            return false;
        }
        /*if (!regex.test($('#de').val().trim())) {
            Swal(
                'Ups!',
                'La direccón de correo <b>De</b> no es válida.',
                'warning'
            ).then(function() { });
            return false;
        }*/
        if (!regex.test($('#para').val().trim())) {
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
