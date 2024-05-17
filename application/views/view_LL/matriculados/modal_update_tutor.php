<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Editar Tutor</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Parentesco:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="id_parentesco_u" name="id_parentesco_u">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_parentesco as $list){ ?>
                        <option value="<?php echo $list['id_parentesco']; ?>" <?php if($list['id_parentesco']==$get_id[0]['id_parentesco']){ echo "selected"; } ?>>
                            <?php echo $list['nom_parentesco']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Apellido Paterno:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="apellido_paterno_u" name="apellido_paterno_u" placeholder="Apellido Paterno" value="<?php echo $get_id[0]['apellido_paterno']; ?>">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Apellido Materno:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="apellido_materno_u" name="apellido_materno_u" placeholder="Apellido Materno" value="<?php echo $get_id[0]['apellido_materno']; ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Nombre(s):</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="nombre_u" name="nombre_u" placeholder="Nombre(s)" value="<?php echo $get_id[0]['nombre']; ?>">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Celular:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control solo_numeros" id="celular_u" name="celular_u" placeholder="Celular" value="<?php echo $get_id[0]['celular']; ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Correo:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="email_u" name="email_u" placeholder="Correo" value="<?php echo $get_id[0]['email']; ?>">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">No Mailing:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="checkbox" id="no_mailing_u" name="no_mailing_u" value="1" <?php if($get_id[0]['no_mailing']==1){ echo "checked"; } ?>>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input type="hidden" id="id_tutor" name="id_tutor" value="<?php echo $get_id[0]['id_tutor']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Tutor();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cerrar
        </button>
    </div>
</form>

<script>
    $('.solo_numeros').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    function Update_Tutor(){
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
        var url="<?php echo site_url(); ?>LittleLeaders/Update_Tutor";

        if (Valida_Update_Tutor()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    window.location.reload();
                }
            });
        }
    }

    function Valida_Update_Tutor() {
        if($('#id_parentesco_u').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar parentesco.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#apellido_paterno_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar apellido paterno.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#apellido_materno_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar apellido materno.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#nombre_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar nombre(s).',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>