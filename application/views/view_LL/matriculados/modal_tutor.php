<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Tutor (Nuevo)</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Parentesco:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="id_parentesco_i" name="id_parentesco_i">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_parentesco as $list){ ?>
                        <option value="<?php echo $list['id_parentesco']; ?>"><?php echo $list['nom_parentesco']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Apellido Paterno:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="apellido_paterno_i" name="apellido_paterno_i" placeholder="Apellido Paterno">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Apellido Materno:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="apellido_materno_i" name="apellido_materno_i" placeholder="Apellido Materno">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Nombre(s):</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="nombre_i" name="nombre_i" placeholder="Nombre(s)">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Celular:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control solo_numeros" id="celular_i" name="celular_i" placeholder="Celular">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Correo:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="email_i" name="email_i" placeholder="Correo">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">No Mailing:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="checkbox" id="no_mailing_i" name="no_mailing_i" value="1">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Tutor();">
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

    function Insert_Tutor(){
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
        var url="<?php echo site_url(); ?>LittleLeaders/Insert_Tutor";

        var id_alumno = $("#id_alumno").val();
        dataString.append('id_alumno', id_alumno);

        if (Valida_Insert_Tutor()) {
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

    function Valida_Insert_Tutor() {
        if($('#id_parentesco_i').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar parentesco.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#apellido_paterno_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar apellido paterno.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#apellido_materno_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar apellido materno.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#nombre_i').val().trim() === '') {
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