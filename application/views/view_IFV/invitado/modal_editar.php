<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Editar Invitado</b></h5>
    </div> 

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Fecha:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="fecha_u" name="fecha_u" value="<?php echo $get_id[0]['fecha']; ?>">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Persona:</label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="persona_u" name="persona_u" placeholder="Persona" value="<?php echo $get_id[0]['persona']; ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">DNI:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control solo_numeros" id="dni_u" name="dni_u" placeholder="DNI" maxlength="8" value="<?php echo $get_id[0]['dni']; ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Inst./Empresa:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="inst_empresa_u" name="inst_empresa_u" placeholder="Inst./Empresa" value="<?php echo $get_id[0]['inst_empresa']; ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Invitado:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="invitado_u" name="invitado_u">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_invitado as $list){ ?>
                        <option value="<?php echo $list['Codigo']; ?>" <?php if($list['Codigo']==$get_id[0]['invitado']){ echo "selected"; } ?>>
                            <?php echo $list['nom_invitado']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>  	           	                	        
    </div> 

    <div class="modal-footer">
        <input type="hidden" id="id_invitado" name="id_invitado" value="<?php echo $get_id[0]['id_invitado']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Invitado()">
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

    function Update_Invitado(){
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
        var url="<?php echo site_url(); ?>AppIFV/Update_Invitado";

        if (Valida_Update_Invitado()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    window.location = "<?php echo site_url(); ?>AppIFV/Invitado";
                }
            });
        }
    }

    function Valida_Update_Invitado() {
        if($('#fecha_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Fecha.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#persona_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Persona.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#dni_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar DNI.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#invitado_u').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Invitado.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>